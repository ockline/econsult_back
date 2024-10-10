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
use App\Models\Employee\Personal\EmployeeDocument;
use App\Models\Employee\Personal\EmployeeEducation;
use App\Models\Employee\Personal\EmploymentHistory;
use App\Models\Hiring\Interview\CompetencyInterDoc;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Models\Employee\Personal\EmploymentReference;
use App\Models\Hiring\Interview\CompetencyTransaction;
use App\Models\Hiring\JobApplication\JobDescTransaction;




class EmployeeRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Employee::class;


    protected $employee;
    protected $assessment;

    public function __construct(Employee $employee, CompetencyInterview $assessment)
    {
        $this->employee = $employee;
        $this->assessment = $assessment;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */

    public function addEmployee($request)
    {

        // Log::info('************************************8');


        //   log::info($employee_no);

        DB::beginTransaction();

        try {
            $input = $request->all();

            $employee_no = $this->generateEmployeeNo();
            // log::info('data' . $employee_no);
            $employee =  Employee::create([
                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                'cost_center_id' => !empty($input['cost_center_id']) ? $input['cost_center_id'] : null,
                'cost_number' => !empty($input['cost_number']) ? $input['cost_number'] : null,
                'dob' => !empty($input['dob']) ? $input['dob'] : null,
                'firstname' => !empty($input['firstname']) ? $input['firstname'] : null,
                'middlename' => !empty($input['middlename']) ? $input['middlename'] : null,
                'lastname' => !empty($input['lastname']) ? $input['lastname'] : null,
                'employee_name' => $input['firstname'] . " " . $input['middlename'] . " " . $input['lastname'],
                'interview_number' => !empty($input['interview_number']) ? $input['interview_number'] : null,
                'military_service' => !empty($input['military_service']) ? $input['military_service'] : 2,
                'military_number' => !empty($input['military_number']) ? $input['military_number'] : null,
                'name_language' => !empty($input['name_language']) ? $input['name_language'] : null,
                'gender' => !empty($input['gender']) ? $input['gender'] : 2,
                'package_id' => !empty($input['package_id']) ? $input['package_id'] : null,
                'department_id' => !empty($input['department_id']) ? $input['department_id'] : null,
                'national_id' => !empty($input['national_id']) ? $input['national_id'] : null,
                'passport_id' => !empty($input['passport_id']) ? $input['passport_id'] : null,
                'marital_status' => !empty($input['marital_status']) ? $input['marital_status'] : 2,
                'spause_name' => !empty($input['spause_name']) ? $input['spause_name'] : null,
                'telephone_home' => !empty($input['telephone_home']) ? $input['telephone_home'] : null,
                'telephone_office' => !empty($input['telephone_office']) ? $input['telephone_office'] : null,
                'mobile_number' => !empty($input['mobile_number']) ? $input['mobile_number'] : null,
                'email' => !empty($input['email']) ? $input['email'] : null,
                'dob' => !empty($input['dob']) ? $input['dob'] : null,
                'nationality_id' => !empty($input['nationality_id']) ? $input['nationality_id'] : 1,
                'driving_licence' => !empty($input['driving_licence']) ? $input['driving_licence'] : 4,
                'place_issued' => !empty($input['place_issued']) ? $input['place_issued'] : null,
                'chronic_disease' => !empty($input['chronic_disease']) ? $input['chronic_disease'] : 2,
                'chronic_remark' => !empty($input['chronic_remark']) ? $input['chronic_remark'] : null,
                'surgery_operation' => !empty($input['surgery_operation']) ? $input['surgery_operation'] : 2,
                'surgery_remark' => !empty($input['surgery_remark']) ? $input['surgery_remark'] : null,
                'employed_before' => !empty($input['employed_before']) ? $input['employed_before'] : 2,
                'from_date' => !empty($input['from_date']) ? $input['from_date'] : null,
                'to_date' => !empty($input['to_date']) ? $input['to_date'] : null,
                'position' => !empty($input['position']) ? $input['position'] : null,
                'relative_working' => !empty($input['relative_working']) ? $input['relative_working'] : 2,
                'relative_name' => !empty($input['relative_name']) ? $input['relative_name'] : null,
                'former_department' => !empty($input['former_department']) ? $input['former_department'] : null,
                'transfer_change' => !empty($input['transfer_change']) ? $input['transfer_change'] : null,
                'transfer_reasons' => !empty($input['transfer_reasons']) ? $input['transfer_reasons'] : null,
                'bank_id' => !empty($input['bank_id']) ? $input['bank_id'] : null,
                'account_number' => !empty($input['account_number']) ? $input['account_number'] : null,
                'bank_branch_id' => !empty($input['bank_branch_id']) ? $input['bank_branch_id'] : null,
                'account_name' => !empty($input['account_name']) ? $input['account_name'] : null,
                'nssf' => !empty($input['nssf']) ? $input['nssf'] : null,
                'wcf' => !empty($input['wcf']) ? $input['wcf'] : null,
                'tin' => !empty($input['tin']) ? $input['tin'] : null,
                'nhif' => !empty($input['nhif']) ? $input['nhif'] : null,
                'company_name' => !empty($input['company_name']) ? $input['company_name'] : null,
                'employer_from_date' => !empty($input['employer_from_date']) ? $input['employer_from_date'] : null,
                'employer_to_date' => !empty($input['employer_to_date']) ? $input['employer_to_date'] : null,
                'readiness_employee' => !empty($input['readiness_employee']) ? $input['readiness_employee'] : null,
                'downloaded' => !empty($input['downloaded']) ? $input['downloaded'] : null,
                'uploaded' => !empty($input['uploaded']) ? $input['uploaded'] : 0,
                'uploaded_date' => !empty($input['uploaded_date']) ? $input['uploaded_date'] : null,
                'stage' => !empty($input['stage']) ? $input['stage'] : null,
                'progressive_stage' => 1,
                'status' => 0,
                'employee_no' => !empty($employee_no) ? $employee_no : null,

            ]);
            // Log::info('vita iendeleee');
            $employee_id = $employee->id;

            // $this->saveCompetencyTransaction($request, $employee_id); //to save compotencies
            $this->saveEmployeeDocument($request, $employee_id); // To save attachment
            // $this->addEducation($request, $employee_id);
            DB::commit();

            Log::info('Saved done');
            return response()->json(['message' => 'Employee created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create Employee', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create Employee', 'status' => 500]);
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
        return $this->employee->select('*')->latest()->first();
    }
    // Example usage
    /**
     * @param $id
     * @return mixed
     * @competency transactions
     */
    // public function saveCompetencyTransaction($request, $employee_id)
    // {
    //     // Log::info('unyama sana');
    //     // log::info($employee_id);
    //     // Log::info('###############');
    //     // Log::info($request);

    //     DB::beginTransaction();

    //     try {
    //         $input = $request->all();
    //         // Log::info($input);
    //         //    Log::info($overall);
    //         // log::info('mwamba competencies');

    //         $competency = new CompetencyTransaction();

    //         $competency->create([
    //             'competency_id' => !empty($request['competency_id']) ? $request['competency_id'] : null,
    //             'competency__subject_id' => !empty($request['competency__subject_id']) ? $request['competency__subject_id'] : null,
    //             'competency_interview_id' => $employee_id,
    //             'description' => !empty($request['description']) ? $request['description'] : null,
    //             'interactive_communication' => !empty($request['interactive_communication']) ? $request['interactive_communication'] : 0,
    //             'accountability' => !empty($request['accountability']) ? $request['accountability'] : 0,
    //             'work_excellence' => !empty($request['work_excellence']) ? $request['work_excellence'] : 0,
    //             'planning_organizing' => !empty($request['planning_organizing']) ? $request['planning_organizing'] : 0,
    //             'problem_solving' => !empty($request['problem_solving']) ? $request['problem_solving'] : 0,
    //             'analytical_ability' => !empty($request['analytical_ability']) ? $request['analytical_ability'] : 0,
    //             'attention_details' => !empty($request['attention_details']) ? $request['attention_details'] : 0,
    //             'initiative' => !empty($request['initiative']) ? $request['initiative'] : 0,
    //             'multi_tasking' => !empty($request['multi_tasking']) ? $request['multi_tasking'] : 0,
    //             'continuous_improvement' => !empty($request['continuous_improvement']) ? $request['continuous_improvement'] : 0,
    //             'compliance' => !empty($request['compliance']) ? $request['compliance'] : 0,
    //             'creativity_innovation' => !empty($request['creativity_innovation']) ? $request['creativity_innovation'] : 0,
    //             'negotiation' => !empty($request['negotiation']) ? $request['negotiation'] : 0,
    //             'team_work' => !empty($request['team_work']) ? $request['team_work'] : 0,
    //             'adaptability_flexibility' => !empty($request['adaptability_flexibility']) ? $request['adaptability_flexibility'] : 0,
    //             'leadership' => !empty($request['leadership']) ? $request['leadership'] : 0,
    //             'delegating_managing' => !empty($request['delegating_managing']) ? $request['delegating_managing'] : 0,
    //             'managing_change' => !empty($request['managing_change']) ? $request['managing_change'] : 0,
    //             'strategic_conceptual_thinking' => !empty($request['strategic_conceptual_thinking']) ? $request['strategic_conceptual_thinking'] : 0,
    //             'interactive_communication_remark' => !empty($input['interactive_communication_remark']) ? $input['interactive_communication_remark'] : null,
    //             'accountability_remark' => !empty($input['accountability_remark']) ? $input['accountability_remark'] : null,
    //             'work_excellence_remark' => !empty($input['work_excellence_remark']) ? $input['work_excellence_remark'] : null,
    //             'planning_organizing_remark' => !empty($input['planning_organizing_remark']) ? $input['planning_organizing_remark'] : null,
    //             'problem_solving_remark' => !empty($input['problem_solving_remark']) ? $input['problem_solving_remark'] : null,
    //             'analytical_ability_remark' => !empty($input['analytical_ability_remark']) ? $input['analytical_ability_remark'] : null,
    //             'attention_details_remark' => !empty($input['attention_details_remark']) ? $input['attention_details_remark'] : null,
    //             'initiative_remark' => !empty($input['initiative_remark']) ? $input['initiative_remark'] : null,
    //             'multi_tasking_remark' => !empty($input['multi_tasking_remark']) ? $input['multi_tasking_remark'] : null,
    //             'continuous_improvement_remark' => !empty($input['continuous_improvement_remark']) ? $input['continuous_improvement_remark'] : null,
    //             'compliance_remark' => !empty($input['compliance_remark']) ? $input['compliance_remark'] : null,
    //             'creativity_innovation_remark' => !empty($input['creativity_innovation_remark']) ? $input['creativity_innovation_remark'] : null,
    //             'negotiation_remark' => !empty($input['negotiation_remark']) ? $input['negotiation_remark'] : null,
    //             'team_work_remark' => !empty($input['team_work_remark']) ? $input['team_work_remark'] : null,
    //             'adaptability_flexibility_remark' => !empty($input['adaptability_flexibility_remark']) ? $input['adaptability_flexibility_remark'] : null,
    //             'leadership_remark' => !empty($input['leadership_remark']) ? $input['leadership_remark'] : null,
    //             'delegating_managing_remark' => !empty($input['delegating_managing_remark']) ? $input['delegating_managing_remark'] : null,
    //             'managing_change_remark' => !empty($input['managing_change_remark']) ? $input['managing_change_remark'] : null,
    //             'strategic_conceptual_thinking_remark' => !empty($input['strategic_conceptual_thinking_remark']) ? $input['strategic_conceptual_thinking_remark'] : null,

    //         ]);
    //         DB::commit();

    //         return response()->json(['message' => 'Competencie saved successfully', 'status' => 201], 201);
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         Log::error('Failed to save competencies', ['error' => $e->getMessage()]);

    //         return response()->json(['message' => 'Failed to save on competency transactions', 'status' => 500]);
    //     }
    // }
    /**
     *@method to save hr cometency attachment

     */
    public function saveEmployeeDocument($request, $employee_id)
    {
        // Log::info($request->all());

        DB::beginTransaction();

        try {

            $documents = [];

            $documentTypes = ['education_cert', 'military_attach', 'certificate_service', 'marriage_cert', 'referee_passport', 'personal_signed_doc', 'special_cert_related'];

            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType) && $employee_id) {
                    $files = $request->file($documentType);


                    foreach ($files as $file) {
                        //  log::info($file); next time i want to add id of employer  as pass to reach interview candidate document
                        //   log::info($employee_id);
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('employees/personal'), $fileName);
                        // log::info('hureee'. json_encode($fileName));
                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType), // Implement a function to get the document ID based on the type
                            'description' => $fileName,
                            'document_group_id' => 7,
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

            Log::info('Saved employee document ');
            return response()->json(['message' => 'Document created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save document', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save document', 'status' => 500]);
        }
    }
    public function getDocumentId($documentId)
    {
        // $document_id = [29, 30];
        //  $documentTypes = ['education_cert','military_attach','marriage_cert','referee_passport','personal_signed_doc'];
        switch ($documentId) {
            case 'education_cert';
                return 15;
                break;
            case 'certificate_service';
                return 23;
                break;
            case 'military_attach';
                return 33;
                break;
            case 'marriage_cert';
                return 34;
                break;
            case 'referee_passport';
                return 35;
                break;
            case 'personal_signed_doc';
                return 36;
                break;
            case 'special_cert_related';
                return 37;
                break;
            default:
                return null;
        }
    }
    /**
     * Method to Update assessed Candidate details
     */
    public function updateDetails($request, $id)
    {
        // Log::info('*******************************');
        //    Log::info($request->all());
        $employee_details = $this->employee::where('id', $id)->first();

        $candidate_number = $employee_details->interview_number;
        if (isset($employee_details)) {



            DB::beginTransaction();

            try {
                $input = $request->all();

                // $candidate_details->additional_comment = $request->input('additional_comment');
                $employee_details->update([
                    'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                    'cost_center_id' => !empty($input['cost_center_id']) ? $input['cost_center_id'] : null,
                    'cost_number' => !empty($input['cost_number']) ? $input['cost_number'] : null,
                    'dob' => !empty($input['dob']) ? $input['dob'] : null,
                    'firstname' => !empty($input['firstname']) ? $input['firstname'] : null,
                    'middlename' => !empty($input['middlename']) ? $input['middlename'] : null,
                    'lastname' => !empty($input['lastname']) ? $input['lastname'] : null,
                    'employee_name' => $input['firstname'] . " " . $input['middlename'] . " " . $input['lastname'],
                    'interview_number' => !empty($input['interview_number']) ? $input['interview_number'] : null,
                    'military_service' => !empty($input['military_service']) ? $input['military_service'] : 2,
                    'military_number' => !empty($input['military_number']) ? $input['military_number'] : null,
                    'name_language' => !empty($input['name_language']) ? $input['name_language'] : null,
                    'gender' => !empty($input['gender']) ? $input['gender'] : 2,
                    'package_id' => !empty($input['package_id']) ? $input['package_id'] : null,
                    'department_id' => !empty($input['department_id']) ? $input['department_id'] : null,
                    'national_id' => !empty($input['national_id']) ? $input['national_id'] : null,
                    'passport_id' => !empty($input['passport_id']) ? $input['passport_id'] : null,
                    'marital_status' => !empty($input['marital_status']) ? $input['marital_status'] : 2,
                    'spause_name' => !empty($input['spause_name']) ? $input['spause_name'] : null,
                    'telephone_home' => !empty($input['telephone_home']) ? $input['telephone_home'] : null,
                    'telephone_office' => !empty($input['telephone_office']) ? $input['telephone_office'] : null,
                    'mobile_number' => !empty($input['mobile_number']) ? $input['mobile_number'] : null,
                    'email' => !empty($input['email']) ? $input['email'] : null,
                    'dob' => !empty($input['dob']) ? $input['dob'] : null,
                    'nationality_id' => !empty($input['nationality_id']) ? $input['nationality_id'] : 1,
                    'driving_licence' => !empty($input['driving_licence']) ? $input['driving_licence'] : 4,
                    'place_issued' => !empty($input['place_issued']) ? $input['place_issued'] : null,
                    'chronic_disease' => !empty($input['chronic_disease']) ? $input['chronic_disease'] : 2,
                    'chronic_remark' => !empty($input['chronic_remark']) ? $input['chronic_remark'] : null,
                    'surgery_operation' => !empty($input['surgery_operation']) ? $input['surgery_operation'] : 2,
                    'surgery_remark' => !empty($input['surgery_remark']) ? $input['surgery_remark'] : null,
                    'employed_before' => !empty($input['employed_before']) ? $input['employed_before'] : 2,
                    'from_date' => !empty($input['from_date']) ? $input['from_date'] : null,
                    'to_date' => !empty($input['to_date']) ? $input['to_date'] : null,
                    'position' => !empty($input['position']) ? $input['position'] : null,
                    'relative_working' => !empty($input['relative_working']) ? $input['relative_working'] : 2,
                    'relative_name' => !empty($input['relative_name']) ? $input['relative_name'] : null,
                    'former_department' => !empty($input['former_department']) ? $input['former_department'] : null,
                    'transfer_change' => !empty($input['transfer_change']) ? $input['transfer_change'] : null,
                    'transfer_reasons' => !empty($input['transfer_reasons']) ? $input['transfer_reasons'] : null,
                    'bank_id' => !empty($input['bank_id']) ? $input['bank_id'] : null,
                    'account_number' => !empty($input['account_number']) ? $input['account_number'] : null,
                    'bank_branch_id' => !empty($input['bank_branch_id']) ? $input['bank_branch_id'] : null,
                    'account_name' => !empty($input['account_name']) ? $input['account_name'] : null,
                    'nssf' => !empty($input['nssf']) ? $input['nssf'] : null,
                    'wcf' => !empty($input['wcf']) ? $input['wcf'] : null,
                    'tin' => !empty($input['tin']) ? $input['tin'] : null,
                    'nhif' => !empty($input['nhif']) ? $input['nhif'] : null,
                    'company_name' => !empty($input['company_name']) ? $input['company_name'] : null,
                    'employer_from_date' => !empty($input['employer_from_date']) ? $input['employer_from_date'] : null,
                    'employer_to_date' => !empty($input['employer_to_date']) ? $input['employer_to_date'] : null,
                    'readiness_employee' => !empty($input['readiness_employee']) ? $input['readiness_employee'] : null,
                    'downloaded' => !empty($input['downloaded']) ? $input['downloaded'] : null,
                    'uploaded' => !empty($input['uploaded']) ? $input['uploaded'] : 0,
                    'uploaded_date' => !empty($input['uploaded_date']) ? $input['uploaded_date'] : null,
                    'stage' => !empty($input['stage']) ? $input['stage'] : null,
                    'progressive_stage' => 1,
                    'status' => 0,
                    // 'employee_number' => !empty($employee_no) ? $employee_no : null,
                ]);


                $interview_id = $employee_details->id;
                // $this->updateCompetencyTransaction($request, $interview_id);
                $this->saveEmployeeDocument($request, $interview_id);
                //  $this->addEducation($request, )
                // $this->updateCompetencyDocument($request, $interview_id);

                DB::commit();
                Log::info('updated done');

                return response()->json(['message' => 'Employee Updated successfully', 'status' => 200], 200);
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Failed to update employee ', ['error' => $e->getMessage()]);

                return response()->json(['message' => 'Failed to Update  employee', 'status' => 500]);
            }
        }
    }
    public function addEducation($request, $employee_id)
    {

        DB::beginTransaction();
        $employee =  $this->getLastEmployee();
        $employee_id = $employee->id;
        // log::info($employee_id);
        try {

            $input = $request->all();
            // Log::info('ndaniiiii'.$employee_id);

            log::info('mwamba elimu');

            $education_history = new EmployeeEducation();

            $education_history->create([

                'education_id' => !empty($request['education_id']) ? $request['education_id'] : null,
                'institute_name' => !empty($request['institute_name']) ? $request['institute_name'] : null,
                'employee_id' => $employee_id,
                'description' => !empty($request['description']) ? $request['description'] : null,
                'other_institute' => !empty($request['other_institute']) ? $request['other_institute'] : null,
                'major' => !empty($request['major']) ? $request['major'] : null,
                'course' => !empty($request['course']) ? $request['course'] : null,
                'graduation_year' => !empty($request['graduation_year']) ? $request['graduation_year'] : null,
            ]);
            $this->saveEmployeeDocument($request, $employee_id);
            DB::commit();
            Log::info('education done');

            return response()->json(['message' => 'Education History successfully addedd', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to add education history ', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to add education history', 'status' => 500]);
        }
    }
    public function addEmployment($request)
    {

        DB::beginTransaction();
        $employee =  $this->getLastEmployee();
        $employee_id = $employee->id;
        // log::info($employee_id);
        try {

            $input = $request->all();

            $employment_history = new EmploymentHistory();

            $employment_history->create([
                'company_name' => !empty($request['company_name']) ? $request['company_name'] : null,
                'position' => !empty($request['position']) ? $request['position'] : null,
                'employee_id' => $employee_id,
                'description' => !empty($request['description']) ? $request['description'] : null,
                'salary' => !empty($request['salary']) ? $request['salary'] : null,
                'from_date' => !empty($request['from_date']) ? $request['from_date'] : null,
                'to_date' => !empty($request['to_date']) ? $request['to_date'] : null,

            ]);
            $this->saveEmployeeDocument($request, $employee_id);
            DB::commit();
            Log::info('employment done');

            return response()->json(['message' => 'Employment History successfully addedd', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to add employment history ', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to add employment history', 'status' => 500]);
        }
    }

    public function addReferenceCheck($request)
    {

        DB::beginTransaction();
        $employee =  $this->getLastEmployee();
        $employee_id = $employee->id;
        // log::info($employee_id);
        try {

            $input = $request->all();


            $reference_check = new EmploymentReference();

            $reference_check->create([

                'referee_id' => !empty($request['referee_id']) ? $request['referee_id'] : null,
                'referee_name' => !empty($request['referee_name']) ? $request['referee_name'] : null,
                'employee_id' => $employee_id,
                'description' => !empty($request['description']) ? $request['description'] : null,
                'referee_title' => !empty($request['referee_title']) ? $request['referee_title'] : null,
                'referee_address' => !empty($request['referee_address']) ? $request['referee_address'] : null,
                'referee_contact' => !empty($request['referee_contact']) ? $request['referee_contact'] : null,
                'referee_email' => !empty($request['referee_email']) ? $request['referee_email'] : null,

            ]);
            // $this->saveEmployeeDocument($request, $employee_id); // incase you will need to add passport
            DB::commit();
            Log::info('reference done');

            return response()->json(['message' => 'Employment Reference  successfully addedd', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to add employment reference check ', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to add employment reference check', 'status' => 500]);
        }
    }
    public function updateEducationHistory($request, $id)
    {
        // log::info($request->all());
        DB::beginTransaction();

        $education = $request->education_id;
        // log::info($education);
        // die;
        try {

            $input = $request->all();


            $education_history =  EmployeeEducation::where('education_id', $education)->where('employee_id', $id);

            $education_history->update([
                'education_id' => !empty($request['education_id']) ? $request['education_id'] : null,
                'institute_name' => !empty($request['institute_name']) ? $request['institute_name'] : null,
                'employee_id' => $id,
                'description' => !empty($request['description']) ? $request['description'] : null,
                'other_institute' => !empty($request['other_institute']) ? $request['other_institute'] : null,
                'major' => !empty($request['major']) ? $request['major'] : null,
                'course' => !empty($request['course']) ? $request['course'] : null,
                'graduation_year' => !empty($request['graduation_year']) ? $request['graduation_year'] : null,
            ]);

            $this->saveEmployeeDocument($request, $id);
            DB::commit();

            Log::info('education done');

            return response()->json(['message' => 'Education history  successfully addedd', 'status' => 200], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update education history ', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to update education history', 'status' => 500]);
        }
    }
    public function updateEmploymentHistory($request, $id)
    {

        DB::beginTransaction();
        // $employee =  $this->getLastEmployee();
        $employment = $request->employment_id;
        try {

            $input = $request->all();

            $employment_history =  EmploymentHistory::where('employee_id', $id)->where('id', $employment);
            $employment_history->update([
                'company_name' => !empty($request['company_name']) ? $request['company_name'] : null,
                'position' => !empty($request['position']) ? $request['position'] : null,
                'employee_id' => $id,
                'description' => !empty($request['description']) ? $request['description'] : null,
                'salary' => !empty($request['salary']) ? $request['salary'] : null,
                'from_date' => !empty($request['from_date']) ? $request['from_date'] : null,
                'to_date' => !empty($request['to_date']) ? $request['to_date'] : null,

            ]);
            $this->saveEmployeeDocument($request, $id);
            DB::commit();
            Log::info('employment done');
            return response()->json(['message' => 'Employment History successfully updated', 'status' => 200], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to add employment history ', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to add employment history', 'status' => 500]);
        }
    }
    public function updateEmploymentReference($request, $id)
    {
        //    log::info($request->all());

        DB::beginTransaction();
        // $employee =  $this->getLastEmployee();
        // $employee_id = $employee->id;
        // log::info($employee_id);
        try {
            $input = $request->all();

            $reference_check =  EmploymentReference::where('employee_id', $id)->where('id', $request->reference_id);

            $reference_check->update([
                'referee_id' => !empty($request['referee_id']) ? $request['referee_id'] : null,
                'referee_name' => !empty($request['referee_name']) ? $request['referee_name'] : null,
                'employee_id' => $id,
                'description' => !empty($request['description']) ? $request['description'] : null,
                'referee_title' => !empty($request['referee_title']) ? $request['referee_title'] : null,
                'referee_address' => !empty($request['referee_address']) ? $request['referee_address'] : null,
                'referee_contact' => !empty($request['referee_contact']) ? $request['referee_contact'] : null,
                'referee_email' => !empty($request['referee_email']) ? $request['referee_email'] : null,

            ]);
            // $this->saveEmployeeDocument($request, $employee_id); // incase you will need to add passport //enable this
            DB::commit();
            Log::info('reference done');

            return response()->json(['message' => 'Employment Reference  successfully addedd', 'status' => 200], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to add employment reference check ', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to add employment reference check', 'status' => 500]);
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
        $data =  DB::table('employees as e')
            ->select([
                DB::raw('e.* '),
                DB::raw("CASE WHEN e.military_service = 1 THEN 'Completed' ELSE 'Didnt Attend' END AS military_service "),
                DB::raw("CASE WHEN e.marital_status  = 1 THEN 'Married' ELSE 'Single' END AS marital"),
                DB::raw("CASE WHEN e.gender  = 1 THEN 'Male' ELSE 'Female' END AS genders"),
                DB::raw("CASE WHEN e.relative_working  = 1 THEN 'Yes' ELSE 'No' END AS relative_working "),
                DB::raw("CASE WHEN e.chronic_disease  = 1 THEN 'Yes' ELSE 'No' END AS chronic_disease "),
                DB::raw("CASE WHEN e.employed_before  = 1 THEN 'Yes' ELSE 'No' END AS employed_before "),
                DB::raw("CASE WHEN e.downloaded  = 1 THEN 'Yes' ELSE 'No' END AS downloaded "),
                DB::raw("CASE WHEN e.uploaded  = 1 THEN 'Yes' ELSE 'No' END AS uploaded "),
                DB::raw("CASE WHEN e.surgery_operation  = 1 THEN 'Yes' ELSE 'No' END AS surgery_operation "),
                DB::raw("CASE
                            WHEN e.driving_licence = 1 THEN 'Light'
                            WHEN e.driving_licence = 2 THEN 'Heavy'
                            WHEN e.driving_licence = 3 THEN 'Equipment'
                            ELSE 'None'
                        END AS driving"),
                DB::raw("CASE
                            WHEN e.progressive_stage = 1 THEN 'Employee Details'
                            WHEN e.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN e.progressive_stage = 3 THEN 'Social Record'
                            WHEN e.progressive_stage = 4 THEN 'Induction Training'
                            WHEN e.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN e.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS stage"),
                DB::raw('e.surgery_remark '),
                DB::raw('jt.name as job_title'),
                DB::raw('jt.name as recommended_title'),
                DB::raw('cc.name as cost_center'),
                DB::raw('c.description as nationality'),
                DB::raw('CONCAT(e.firstname, \' \', e.middlename, \' \', e.lastname) as employee_name'),
            ])
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('cost_centers as cc', 'e.cost_center_id', '=', 'cc.id')
            // ->leftJoin('employers as em', 'e.employer_id', '=', 'em.id')
            ->leftJoin('users as u', 'u.employer_id', '=', 'e.id')
            ->leftJoin('countries as c', 'e.nationality_id', '=', 'c.id')
            ->orderBy('e.id', 'DESC')
            ->get();

        return $data;
    }
    public function getPersonalDetail()
    {
        return DB::table('employees as e')
            ->select([
                DB::raw('e.* '),
                DB::raw("CASE WHEN e.military_service = 1 THEN 'Completed' ELSE 'Didnt Attend' END AS military_service "),
                DB::raw("CASE WHEN e.marital_status  = 1 THEN 'Married' ELSE 'Single' END AS marital"),
                DB::raw("CASE WHEN e.gender  = 1 THEN 'Male' ELSE 'Female' END AS genders"),
                DB::raw("CASE WHEN e.relative_working  = 1 THEN 'Yes' ELSE 'No' END AS relative_working "),
                DB::raw("CASE WHEN e.chronic_disease  = 1 THEN 'Yes' ELSE 'No' END AS chronic_disease "),
                DB::raw("CASE WHEN e.employed_before  = 1 THEN 'Yes' ELSE 'No' END AS employed_before "),
                DB::raw("CASE WHEN e.downloaded  = 1 THEN 'Yes' ELSE 'No' END AS downloaded "),
                DB::raw("CASE WHEN e.uploaded  = 1 THEN 'Yes' ELSE 'No' END AS uploaded "),
                DB::raw("CASE WHEN e.surgery_operation  = 1 THEN 'Yes' ELSE 'No' END AS surgery_operation "),
                DB::raw("CASE
                            WHEN e.driving_licence = 1 THEN 'Light'
                            WHEN e.driving_licence = 2 THEN 'Heavy'
                            WHEN e.driving_licence = 3 THEN 'Equipment'
                            ELSE 'None'
                        END AS driving"),
                DB::raw("CASE
                            WHEN e.progressive_stage = 1 THEN 'Employee Details'
                            WHEN e.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN e.progressive_stage = 3 THEN 'Social Record'
                            WHEN e.progressive_stage = 4 THEN 'Induction Training'
                            WHEN e.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN e.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS stage"),
                DB::raw('e.surgery_remark '),
                DB::raw('jt.name as job_title'),
                DB::raw('jt.name as recommended_title'),
                DB::raw('cc.name as cost_center'),
                DB::raw('c.description as nationality'),
                DB::raw('CONCAT(e.firstname, \' \', e.middlename, \' \', e.lastname) as employee_name'),
            ])
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('cost_centers as cc', 'e.cost_center_id', '=', 'cc.id')
            ->leftJoin('users as u', 'u.employer_id', '=', 'e.id')
            ->leftJoin('countries as c', 'e.nationality_id', '=', 'c.id')
            ->orderBy('e.id', 'DESC')
            ->get();
    }
}
