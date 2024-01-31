<?php

namespace App\Repositories\HiringRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mews\Purifier\Facades\Purifier;
use App\Repositories\BaseREpository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Hiring\JobApplication\JobVacancy;
use App\Models\Hiring\JobApplication\JobDescTransaction;
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
         $vacancies = $this->vacancy
        ->select([
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
         DB::Raw('jbt.name as job_desciption'),
       DB::Raw("CASE WHEN job_vacancies.status = 0 THEN 'Submitted' WHEN job_vacancies.status = 1 THEN 'Initiated' WHEN job_vacancies.status = 2 THEN 'Pending' WHEN job_vacancies.status = 3 THEN 'Approved' ELSE 'Rejected' END AS status")

         ])
        ->leftJoin('employers as e', 'job_vacancies.employer_id', '=', 'e.id')
        ->leftJoin('departments as d', 'job_vacancies.department_id', '=', 'd.id')
        ->leftJoin('job_title as jt', 'job_vacancies.job_title_id','=', 'jt.id')
        ->leftJoin('type_vacancies as tv','job_vacancies.type_vacancy_id', '=', 'tv.id')
        ->leftJoin('job_desc_transactions as jbt', 'job_vacancies.id', '=', 'jbt.job_vacancy_id')
        ->get();
        // $employers = DB::table('employers')->select('*')->get();
        return $vacancies;
    }



    public function addVacancy($request)
    {

        Log::info('hapa atumefika');

        DB::beginTransaction();

        try {
            $input = $request->all();
            Log::info($input);

            //  log::info('mwamba juu');
            // log::info($employer_number);
            // log::info('mwamba chini');
            // $fileName = time().'.'.$request->file->extension();

            // $request->file->move(public_path('uploads'), $fileName);

            $this->vacancy->create([
                'employer_id' => !empty($input['employer_id']) ? $input['employer_id'] : null,
                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id']: null,
                'department_id' => !empty($input['department_id']) ? $input['department_id']: null,
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

            // Log::info('Saved done');
            return response()->json(['message' => 'Job Description Saved successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create user', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create user', 'status' => 500]);
        }
    }
    public function getLastJob()
    {

        return $this->vacancy->latest()->first();
    }
    public function updateDetails($request, $id)
    {
        // log::info('ndani');
        // Log::info($request);
        // Log::info("*************");
        $vacancy = JobVacancy::find($id);
        if (isset($vacancy)) {
            // $department = $this->department->id; // Assuming you have an 'id' field in your request


            DB::beginTransaction();

            try {
                $input = $request->all();


                // log::info($input);
                // log::info('mwamba chini');
                // $fileName = time().'.'.$request->file->extension();

                // $request->file->move(public_path('uploads'), $fileName);


                $vacancy->employer_id = $request->input('employer_id');
                $vacancy->job_title_id = $request->input('job_title_id');
                $vacancy->department_id = $request->input('department_id');
                $vacancy->type_vacancy_id = $request->input('type_vacancy_id');
                $vacancy->position_vacant   = $request->input('position_vacant');
                $vacancy->date_application = $request->input('date_application');
                $vacancy->deadline_date  = $request->input('deadline_date');
                $vacancy->hr_interview_date   = $request->input('hr_interview_date');
                $vacancy->tech_interview_date  = $request->input('tech_interview_date');
                $vacancy->apointment_date  = $request->input('apointment_date');
                $vacancy->work_station   = $request->input('work_station');
                $vacancy->replacement_reason = $request->input('replacement_reason');
                $vacancy->age = $request->input('age');
                $vacancy->accademic = $request->input('accademic');
                $vacancy->professional = $request->input('professional');
                $vacancy->salary_range = $request->input('salary_range');
                $vacancy->others = $request->input('others');
                $vacancy->additional_comment = $request->input('additional_comment');

                $vacancy->update();

                DB::commit();
                // Log::info('updated done');
                return response()->json(['message' => 'User Updated successfully', 'status' => 200], 200);
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Failed to create user', ['error' => $e->getMessage()]);

                return response()->json(['message' => 'Failed to Update user', 'status' => 500]);
            }
        }
    }

    public function getDocument(Request $request)
    {
        $vacancy = $this->addVacancy($request);
        $nhif_doc  = 10;
        $tin_doc =  11;
        $nssf_doc  = 12;
        $wcf_doc  = 13;
        $osha_doc  = 14;
        $vrn_doc  = 29;


        // $data = [
        //    'name'
        //    'employer_id'
        //    'document_id'
        //   'document_group_id'
        //   'description'
        //    ];



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
