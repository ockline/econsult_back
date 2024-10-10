<?php

namespace App\Repositories\HiringRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mews\Purifier\Facades\Purifier;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Hiring\JobApplication\JobVacancy;
use App\Models\Hiring\JobApplication\JobDescTransaction;
use App\Models\Hiring\JobApplication\JobVacancyDocument;
use App\Repositories\EmployerRepositories\EmployerRepository;



class JobApplicationRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = JobVacancy::class;


    protected $employer;
    protected $vacancy;

    public function __construct(JobVacancy $vacancy, EmployerRepository $employer)
    {
        $this->employer = $employer;
        $this->vacancy = $vacancy;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        // $employers = $this->employer->where("id", $id)->first();

        // if (!is_null($employers)) {
        //     return $employers;
        // }

    }

    public function getVacancies()
    {
        // return  $this->vacancy->get();
        return JobVacancy::select([
            DB::raw('job_vacancies.id'),
            DB::raw('job_vacancies.employer_id'),
            DB::raw('job_vacancies.job_title_id'),
            DB::raw('job_vacancies.department_id'),
            DB::Raw('position_vacant'),
            DB::raw('accademic'),
            DB::raw('date_application'),
            DB::raw('deadline_date'),
            DB::raw('hr_interview_date'),
            DB::raw('tech_interview_date'),
            DB::raw('apointment_date'),
            DB::raw('work_station'),
            DB::raw('replacement_reason'),
            DB::raw('age'),
            DB::raw('professional'),
            DB::raw('salary_range'),
            DB::raw('others'),
            DB::raw('additional_comment'),
            DB::Raw('e.name as employer'),
            DB::Raw('d.name as department'),
            DB::Raw('jt.name as job_title'),
            DB::Raw('tv.name as vacancy_type'),
            DB::Raw('jbt.name'),
            DB::Raw("CASE WHEN job_vacancies.status = 0 THEN 'Submitted' WHEN job_vacancies.status = 1 THEN 'Initiated' WHEN job_vacancies.status = 2 THEN 'Pending' WHEN job_vacancies.status = 3 THEN 'Approved' ELSE 'Rejected' END AS status"),


        ])
            ->join('employers as e', 'job_vacancies.employer_id', '=', 'e.id')
            ->join('departments as d', 'job_vacancies.department_id', '=', 'd.id')
            ->join('job_title as jt', 'job_vacancies.job_title_id', '=', 'jt.id')
            ->join('type_vacancies as tv', 'job_vacancies.type_vacancy_id', '=', 'tv.id')
            ->join('job_desc_transactions as jbt', 'job_vacancies.id', '=', 'jbt.job_vacancy_id')

            ->whereNull('job_vacancies.deleted_at')
            ->get();
    }
    public function getJobDocument()
    {
        return  JobVacancyDocument::select('*', 'name as vacancy_doc')->get();
    }

    public function addVacancy($request)
    {

        // Log::info('hapa atumefika');

        DB::beginTransaction();

        try {
            $input = $request->all();

       $new_vacancy =     $this->vacancy->create([
                'employer_id' => !empty($input['employer_id']) ? $input['employer_id'] : null,
                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                'department_id' => !empty($input['department_id']) ? $input['department_id'] : null,
                'type_vacancy_id' => !empty($input['type_vacancy_id']) ? $input['type_vacancy_id'] : null,
                'position_vacant' => !empty($input['position_vacant']) ? $input['position_vacant'] : null,
                'date_application' => !empty($input['date_application']) ? $input['date_application'] : null,
                'deadline_date' => !empty($input['deadline_date']) ? $input['deadline_date'] : null,
                'hr_interview_date' => !empty($input['hr_interview_date']) ? $input['hr_interview_date'] : null,
                'tech_interview_date' => !empty($input['tech_interview_date']) ? $input['tech_interview_date'] : null,
                'apointment_date' => !empty($input['apointment_date']) ? $input['apointment_date'] : null,
                'work_station' => !empty($input['work_station']) ? $input['work_station'] : null,
                'replacement_reason' => !empty($input['replacement_reason']) ? $input['replacement_reason'] : null,
                'age' => !empty($input['age']) ? $input['age'] : null,
                'accademic' => !empty($input['accademic']) ? $input['accademic'] : null,
                'professional' => !empty($input['professional']) ? $input['professional'] : null,
                'salary_range' => !empty($input['salary_range']) ? $input['salary_range'] : null,
                'others' => !empty($input['others']) ? $input['others'] : null,
                'additional_comment' => !empty($input['additional_comment']) ? $input['additional_comment'] : null,
                'status' => 0, // submitted


            ]);

            $this->jobDescription();  /// in order to complete cicle of job application

            DB::commit();

            Log::info('Saved done');
            return response()->json(['message' => 'User created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create user', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create user', 'status' => 500]);
        }
    }

    public function jobDescription()
    {

        DB::beginTransaction();

        try {
            $request = request()->all();

            $description = Purifier::clean($request['name']);

            $last_job = $this->getLastJob();

            $job_description = new JobDescTransaction();

            $data = ([
                'name' => !empty($description) ? $description : 'None',
                'job_title_id' => !empty($last_job->job_title_id) ? $last_job->job_title_id : $last_job->id,
                'employer_id' => !empty($last_job->employer_id) ? $last_job->employer_id : 2,
                'job_vacancy_id' => !empty($last_job->id) ? $last_job->id : 2,
                'description' => !empty($last_job->additional_comment) ? $last_job->additional_comment : null,
                'status' => 1,
            ]);
            $job_description->fill($data);
            $job_description->save();

            DB::commit();
            Log::info('Saved job description done');
            return response()->json(['message' => 'Job Description Saved successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save job description', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save job description', 'status' => 500]);
        }
    }
    public function getLastJob()
    {

        return $this->vacancy->latest()->first();
    }
    public function updateDetails($request, $id)
    {

        // $vacancy = JobVacancy::find($id);


        // if (isset($vacancy)) {

        DB::beginTransaction();

        try {

            JobVacancy::where('id', $id)
                ->update([
                    'employer_id' => !empty($request['employer_id']) ? $request['employer_id'] : null,
                    'employer_id' => $request['employer_id'],
                    'job_title_id' => $request['job_title_id'],
                    'department_id' => $request['department_id'],
                    'type_vacancy_id' => $request['type_vacancy_id'],
                    'position_vacant' => $request['position_vacant'],
                    'date_application' => $request['date_application'],
                    'deadline_date' => $request['deadline_date'],
                    'hr_interview_date' => $request['hr_interview_date'],
                    'tech_interview_date' => $request['tech_interview_date'],
                    'apointment_date' => $request['apointment_date'],
                    'work_station' => $request['work_station'],
                    'replacement_reason' => $request['replacement_reason'],
                    'age' => $request['age'],
                    'accademic' => $request['accademic'],
                    'professional' => $request['professional'],
                    'salary_range' => $request['salary_range'],
                    'others' => $request['others'],
                    'additional_comment' => $request['additional_comment'],
                ]);

            // Log::info('dataaa' . $id);
            $this->saveJobApplicationDocument($request, $id);

            DB::commit();
            Log::info('updated done');
            return response()->json(['message' => 'User Updated successfully', 'status' => 200], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create user', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to Update user', 'status' => 500]);
        }
        // }
    }

    public function updateJobDescription($request, $id)
    {
        // Log::info($request['name']);
        // die;
        DB::beginTransaction();

        try {

            $description = Purifier::clean($request['name']);
            $last_job = $this->getVacancies()->find($id);
            //  Log::info($last_job['id']);
            $job_description = new JobDescTransaction();

            JobDescTransaction::where('job_vacancy_id', $last_job->id)
                ->update([
                    'name' => !empty($description) ? $description : $last_job['name'],
                    'job_title_id' => !empty($last_job['job_title_id']) ? $last_job['job_title_id'] : $last_job['id'],
                    'employer_id' => !empty($last_job['employer_id']) ? $last_job['employer_id'] : 2,
                    'job_vacancy_id' => !empty($last_job['id']) ? $last_job['id'] : 2,
                    'description' => !empty($last_job['additional_comment']) ? $last_job['additional_comment'] : null,
                    'status' => 1,
                ]);
            DB::commit();

            // Log::info('updated done');
            return response()->json(['message' => 'Job Description updated successfully', 'status' => 200], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create user', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to update Job description', 'status' => 500]);
        }
    }

    public function saveJobApplicationDocument($request, $id)
    {
        // Log::info("*******************" . $id);
        // Log::info($request->all());

        DB::beginTransaction();

        try {

            $documents = [];

            // $document_types =  ['job_request_doc'];

            $documentTypes = ['job_request_doc', 'shortlisted_doc'];

            /**    in case user uploading single data  */

            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType) && $id) {
                    $files = $request->file($documentType);


                    foreach ($files as $file) {
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('hiring/vacancies'), $fileName);
                        // $file->move(public_path('hiring/vacancies/'.$id.'/'), $fileName);
                        // log::info('hureee'. json_encode($fileName));
                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType), // Implement a function to get the document ID based on the type
                            'description' => $fileName,
                            'document_group_id' => 3,
                            'job_vacancy_id' => $id,
                        ];
                    }
                }
            }
            // log::info('document:'. ' '. $documents);
            foreach ($documents as $document) {
                //   log::info('document: ******************');
                JobVacancyDocument::create($document);
            }

            // public static function createOrUpdate($data)
            // {
            //     // Assuming you have a unique key, e.g., 'document_group_id' and 'job_vacancy_id'
            //     $existingDocument = self::where([
            //         'document_group_id' => $data['document_group_id'],
            //         'job_vacancy_id' => $data['job_vacancy_id'],
            //     ])->first();

            //     if ($existingDocument) {
            //         // Update the existing document
            //         $existingDocument->update($data);
            //     } else {
            //         // Create a new document
            //         self::create($data);
            //     }
            // }

            DB::commit();

            Log::info('Saved document ');
            return response()->json(['message' => 'Document created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save document', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save document', 'status' => 500]);
        }
    }
    public function getDocumentId($documentId)
    {
        // $document_id = [5, 6];
        //  $documentTypes = [job_request_doc','shortlisted_doc'];
        switch ($documentId) {
            case 'job_request_doc';
                return 5;
                break;
            case 'shortlisted_doc';
                return 6;
                break;
            default:
                return null;
        }
    }

    // ***************** it will be used for change status after end date reach
    public function deactivateVacancy($id)
    {

        // log::info('hapaa');
        //         Log::info(request()->all());
        //       Log::info('katiiiii');
        $input = request()->all();
        $activate_reason = $input['activate_reason'];
        $deact_reason = !empty($input['deactivate_reason']) ? $input['deactivate_reason'] : null;


        if (isset($activate_reason)) {
            JobVacancy::where('id', $id)->update(['active' => 1, 'activate_reason' => $activate_reason, 'activate_date' => now()]);
        } else if (isset($deact_reason)) {
            JobVacancy::where('id', $id)->update(['active' => 2, 'deactivate_reason' => $deact_reason, 'deactivate_date' => now()]);

            // Delete the record
            $vacancy = JobVacancy::find($id);
            if ($vacancy) {
                $vacancy->delete();
                return response()->json(['status' => 200, 'message' => 'Record updated and deleted successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Record not found'], 404);
            }
        }
        return true;
    }
}
