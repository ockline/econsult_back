<?php

namespace App\Repositories\EmployeeRepositories;


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
use App\Models\Employee\Personal\Employee;
use App\Models\Employee\Social\SocialRecord;
use App\Models\Employee\Personal\EmployeeDocument;
use App\Models\Employee\Personal\EmployeeEducation;
use App\Models\Employee\Personal\EmploymentHistory;
use App\Models\Hiring\Interview\CompetencyInterDoc;
use App\Models\Employee\Induction\InductionTraining;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Models\Employee\Personal\EmploymentReference;
use App\Models\Hiring\Interview\CompetencyTransaction;
use App\Models\Hiring\JobApplication\JobDescTransaction;




class InductionTrainingRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = InductionTraining::class;


    protected $induction;
    protected $assessment;

    public function __construct(InductionTraining $induction, CompetencyInterview $assessment)
    {
        $this->induction = $induction;
        $this->assessment = $assessment;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */

    public function addInductionTraining($request)
    {

        // Log::info('************************************8');


        //   log::info($employee_no);

        DB::beginTransaction();

        try {
            $input = $request->all();
                log::info($input['firstname']);
            // $employee_no = $this->generateEmployeeNo();
            // log::info('data' . $employee_no);
            InductionTraining::create([
                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                'social_record_id' => !empty($input['social_record_id']) ? $input['social_record_id'] : null,
                'employer_id' => !empty($input['employer_id']) ? $input['employer_id'] : null,
                'employer_address' => !empty($input['employer_address']) ? $input['employer_address'] : null,
                // 'firstname' => !empty($input['firstname']) ? $input['firstname'] : null,
                'firstname' => !empty($input['firstname']) ? 'angumbwike' : $input['lastname'],

                'middlename' => !empty($input['middlename']) ? $input['middlename'] : null,
                'lastname' => !empty($input['lastname']) ? $input['lastname'] : null,
                'employee_name' => $input['firstname'] . " " . $input['middlename'] . " " . $input['lastname'],
                'contact_personal' => !empty($input['contact_personal']) ? $input['contact_personal'] : null,
                'personal_contacts' => !empty($input['personal_contacts']) ? $input['personal_contacts'] : 2,
                'personal_designation' => !empty($input['personal_designation']) ? $input['personal_designation'] : null,
                'reporting_to' => !empty($input['reporting_to']) ? $input['reporting_to'] : null,
                'employment_date' => !empty($input['employment_date']) ? $input['employment_date'] : 2,
                'comments' => !empty($input['comments']) ? $input['comments'] : null,
                'department_id' => !empty($input['department_id']) ? $input['department_id'] : null,
                'notes' => !empty($input['notes']) ? $input['notes'] : null,
                'conducted_date' => !empty($input['conducted_date']) ? $input['conducted_date'] : null,
                'business' => !empty($input['business']) ? json_encode($input['business']) : null,
                'establishment' => !empty($input['establishment']) ? $input['establishment'] : null,
                'roles_key' => !empty($input['roles_key']) ? json_encode($input['roles_key']) : null,
                'employee_remuneration' => !empty($input['employee_remuneration']) ? json_encode($input['employee_remuneration']) : null,
                'employment_condition' => !empty($input['employment_condition']) ? json_encode($input['employment_condition']) : null,
                'environment' => !empty($input['environment']) ? json_encode($input['environment']) : null,
                'apropos_training' => !empty($input['apropos_training']) ? json_encode($input['apropos_training']): null,
                'health_safety' => !empty($input['health_safety']) ? json_encode($input['health_safety']): null,
                'conduct_follow_up' => !empty($input['conduct_follow_up']) ? json_encode($input['conduct_follow_up']): null,
                'downloaded' => !empty($input['downloaded']) ? $input['downloaded'] : null,
                'uploaded' => !empty($input['uploaded']) ? $input['uploaded'] : 0,
                'uploaded_date' => !empty($input['uploaded_date']) ? $input['uploaded_date'] : null,
                'stage' => 0,
                'progressive_stage' => 4,
                'status' => 0,
                // 'employee_no' => !empty($employee_no) ? $employee_no : null,

            ]);
            // Log::info('vita iendeleee');
            // $employee_id = $employee->id;


            DB::commit();

            Log::info('Saved done');
            return response()->json(['message' => 'Induction Training Submited successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create Employee', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create induction', 'status' => 500]);
        }
    }
    /**
     *@checksum method to generate number
     */
    public function generateEmployeeNo()
    {
        $startNumber = 10001;
        $endNumber = 3999999999;

        // Get the last employee number from the database
        $lastEmployee = $this->getLastEmployee();

        // If there's no last employee, start from the beginning
        $employee = $lastEmployee ? $lastEmployee->employee_no : $startNumber;

        for ($i = $employee + 1; $i <= $endNumber; $i++) {
            // Log each generated number
            // log::info($i);

            // If you want to use the current generated number, return it
            return $i;
        }

        // If you want to use the last generated number, return it outside the loop
        return $endNumber;
    }
    public function getLastEmployee()
    {
        return $this->induction->select('*')->latest()->first();
    }

    /**
     *@method to save hr cometency attachment

     */
    public function saveInductionDocument($request, $training_id, $employee_id)
    {
        // Log::info($request->all());


        DB::beginTransaction();

        try {

            $documents = [];

            $documentTypes = ['induction_attachment', 'other_train_attachment'];

            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType) && $training_id) {
                    $files = $request->file($documentType);


                    foreach ($files as $file) {
                        //  log::info($file); next time i want to add id of employer  as pass to reach interview candidate document
                        //   log::info($employee_id);
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('employees/induction'), $fileName);
                        // log::info('hureee'. json_encode($fileName));
                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType), // Implement a function to get the document ID based on the type
                            'description' => $fileName,
                            'document_group_id' => 9,
                            'employee_id' => $employee_id,
                        ];
                    }
                }
            }
            // log::info('document:'. ' '. $documents);
            foreach ($documents as $document) {
                // log::info('document: ******************');
                EmployeeDocument::create($document);
            }

            DB::commit();

            Log::info('Saved induction document ');
            return response()->json(['message' => 'Induction Document created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save induction document', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save induction document', 'status' => 500]);
        }
    }
    public function getDocumentId($documentId)
    {
        // $document_id = [29, 30];
        //  $documentTypes = ['induction_attachment','other_train_attachment'];
        switch ($documentId) {
            case 'induction_attachment';
                return 47;
                break;
            case 'other_train_attachment';
                return 48;
                break;
            default:
                return null;
        }
    }
    /**
     * Method to Update assessed Candidate details
     */
    public function updateInductionDetails($request, $id)
    {

        $induction_details = $this->induction::where('social_record_id', $id)->first();

        // $candidate_number = $induction_details->interview_number;
       $employee = SocialRecord::select('employee_id')->where('id', $id)->first();
        $employee_id = $employee->employee_id;

        if (isset($induction_details)) {

            DB::beginTransaction();

            try {
                $input = $request->all();

                // $candidate_details->additional_comment = $request->input('additional_comment');
                $induction_details->update([

                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                'social_record_id' => !empty($input['social_record_id']) ? $input['social_record_id'] : null,
                'employer_id' => !empty($input['employer_id']) ? $input['employer_id'] : null,
                'employer_address' => !empty($input['employer_address']) ? $input['employer_address'] : null,
                // 'firstname' => !empty($input['firstname']) ? $input['firstname'] : null,
                'firstname' => !empty($input['firstname']) ? 'angumbwike' : $input['lastname'],

                'middlename' => !empty($input['middlename']) ? $input['middlename'] : null,
                'lastname' => !empty($input['lastname']) ? $input['lastname'] : null,
                'employee_name' => $input['firstname'] . " " . $input['middlename'] . " " . $input['lastname'],
                'contact_personal' => !empty($input['contact_personal']) ? $input['contact_personal'] : null,
                'personal_contacts' => !empty($input['personal_contacts']) ? $input['personal_contacts'] : 2,
                'personal_designation' => !empty($input['personal_designation']) ? $input['personal_designation'] : null,
                'reporting_to' => !empty($input['reporting_to']) ? $input['reporting_to'] : null,
                'employment_date' => !empty($input['employment_date']) ? $input['employment_date'] : 2,
                'comments' => !empty($input['comments']) ? $input['comments'] : null,
                'department_id' => !empty($input['department_id']) ? $input['department_id'] : null,
                'notes' => !empty($input['notes']) ? $input['notes'] : null,
                'conducted_date' => !empty($input['conducted_date']) ? $input['conducted_date'] : null,
                'business' => !empty($input['business']) ? json_encode($input['business']) : null,
                'establishment' => !empty($input['establishment']) ? $input['establishment']: null,
                'roles_key' => !empty($input['roles_key']) ? json_encode($input['roles_key']) : null,
                'employee_remuneration' => !empty($input['employee_remuneration']) ? json_encode($input['employee_remuneration']) : null,
                'employment_condition' => !empty($input['employment_condition']) ? json_encode($input['employment_condition']) : null,
                'environment' => !empty($input['environment']) ? json_encode($input['environment']) : null,
                'apropos_training' => !empty($input['apropos_training']) ? json_encode($input['apropos_training']): null,
                'health_safety' => !empty($input['health_safety']) ? json_encode($input['health_safety']): null,
                'conduct_follow_up' => !empty($input['conduct_follow_up']) ? json_encode($input['conduct_follow_up']): null,
                'downloaded' => !empty($input['downloaded']) ? $input['downloaded'] : null,
                'uploaded' => !empty($input['uploaded']) ? $input['uploaded'] : 0,
                'uploaded_date' => !empty($input['uploaded_date']) ? $input['uploaded_date'] : null,
                'stage' => 0 ,
                'progressive_stage' => 4,
                'status' => 0,
                    // 'employee_number' => !empty($employee_no) ? $employee_no : null,
                ]);


                $training_id = $induction_details->id;

                $this->saveInductionDocument($request, $training_id, $employee_id);


                DB::commit();
                Log::info('updated done');

                return response()->json(['message' => 'Induction Updated successfully', 'status' => 200], 200);
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Failed to update employee ', ['error' => $e->getMessage()]);

                return response()->json(['message' => 'Failed to Update  induction', 'status' => 500]);
            }
        }
    }
public function updateStageData($induction_training)
{


            DB::beginTransaction();

            try {
   if (!empty($induction_training)) {
            InductionTraining::where('id', $induction_training->id)->update(['stage' => 1, 'progressive_stage' => 5]);
            SocialRecord::where('id', $induction_training->social_record_id)->update(['stage' => 1, 'progressive_stage' => 5]);

         DB::commit();

                return response()->json(['message' => 'Induction Updated successfully', 'status' => 200], 200);
 }
   } catch (\Exception $e) {
                DB::rollback();
                Log::error('Failed to complete induction ', ['error' => $e->getMessage()]);

                return response()->json(['message' => 'Failed to complete induction', 'status' => 500]);
            }


}

    /**
     * Method to fetch Employee person Details
     */
    public function getPersonalDocument()
    {
        // return $this->assessment->get();
        return  DB::table('employee_documents as ed')
            ->select('ed.id', 'ed.employee_id', 'document_id', 'ed.description', 'ed.updated_at as doc_modified', 'd.name as doc_name')
            ->leftJoin('documents as d', 'ed.document_id', '=', 'd.id')
            ->get();
    }


    public function showDownloadDetails()
    {
        $data =  DB::table('induction_trainings as it')
            ->select([
                DB::raw('it.* '),
                 DB::raw('CONCAT(it.firstname, \' \', it.middlename, \' \', it.lastname) as employee_name'),
                DB::raw('e.employee_no'),
                DB::raw('it.stage as stage'),
                DB::raw('dp.name as department'),
                DB::raw("CASE
                            WHEN sr.progressive_stage = 1 THEN 'Employee Details'
                            WHEN sr.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN sr.progressive_stage = 3 THEN 'Social Record'
                            WHEN sr.progressive_stage = 4 THEN 'Induction Training'
                            WHEN sr.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN sr.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS progressive"),
            DB::raw('jt.name as job_title'),
            ])
            ->leftJoin('social_records as sr', 'it.social_record_id', '=', 'it.id')
           ->leftJoin('employees as e', 'sr.employee_id', '=', 'e.id')
           ->leftJoin('departments as dp', 'it.department_id', '=', 'dp.id')
            ->leftJoin('job_title as jt', 'it.job_title_id', '=', 'jt.id')
           ->whereIn('it.progressive_stage', [4,5])
           ->orderBy('it.updated_at', 'DESC')
           ->get();

        return $data;
    }
    public function getInductionDetail()
    {
        // log::info('hhahaha');
    $data =  DB::table('social_records as sr')
            ->select([
                'sr.*',
                DB::raw('CONCAT(sr.firstname, \' \', sr.middlename, \' \', sr.lastname) as employee_name'),
                DB::raw('e.employee_no'),
                DB::raw('it.stage as stage'),
                DB::raw('dp.name as department'),
                DB::raw("CASE
                            WHEN sr.progressive_stage = 1 THEN 'Employee Details'
                            WHEN sr.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN sr.progressive_stage = 3 THEN 'Social Record'
                            WHEN sr.progressive_stage = 4 THEN 'Induction Training'
                            WHEN sr.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN sr.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS progressive"),
            ])

           ->leftJoin('employees as e', 'sr.employee_id', '=', 'e.id')
           ->leftJoin('departments as dp', 'sr.department_id', '=', 'dp.id')
           ->leftJoin('induction_trainings as it', 'it.social_record_id', '=', 'sr.id')
           ->where('sr.progressive_stage', 4)
           ->orWhere('it.progressive_stage', 4)
           ->orWhere('it.progressive_stage', 5)
           ->orderBy('sr.updated_at', 'DESC')
           ->get();

        return $data;
    }
}
