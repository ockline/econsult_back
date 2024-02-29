<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\Personal\Employee;
use App\Models\Hiring\JobApplication\JobVacancy;
use App\Models\Employee\Personal\EmployeeEducation;
use App\Models\Employee\Personal\EmploymentHistory;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Models\Employee\Personal\EmploymentReference;
use App\Repositories\EmployeeRepositories\EmployeeRepository;
use App\Repositories\HiringRepositories\HrInterviewRepository;

class EmployeeController extends Controller
{
    protected $employee;

    public function __construct(EmployeeRepository $employee)
    {
        $this->employee = $employee;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log::info('hellow ndani');
        // log::info($request->all());

        $validator = Validator::make($request->all(), [
            'job_title_id' => 'required|max:191',
            'firstname' => 'required|max:191',
            'middlename' => 'required|max:191',
            'lastname' => 'required|max:191',
            'national_id' => 'required|max:191',
            'marital_status' => 'required|max:191',
            'telephone_home' => 'required|max:191',
            'mobile_number' => 'required|max:191',
            'email' => 'required|max:191',
            'dob' => 'required|max:191',
            'bank_id' => 'required|max:191',
            'account_number' => 'required|max:191',
            'bank_branch_id' => 'required|max:191',
            'account_name' => 'required|max:191',
            'nssf' => 'required|max:191',
            'wcf' => 'required|max:191',
            'tin' => 'required|max:191',
            'nhif' => 'required|max:191',
            'readiness_employee' => 'required|max:191',

        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
                // Log::info('ndani ya nyumba');
            ;
            $new_employee = $this->employee->addEmployee($request);

            $status = $new_employee->getStatusCode();

            // Get HTTP status code
            $responseContent = $new_employee->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Employee person details submitted",
                ];
            } else {
                $return = [
                    'status' => 500,
                    'message' => 'Sorry! Operation failed'


                ];
            }
        }
        return response()->json($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $details = $this->employee->showDownloadDetails();
        //   log::info($id);
        //  Log::info($details);
        $employee = $details->where('id', $id)->first();

        // log::info("Date: " . $employee);
        // log::info("Employee Candidate: " . json_encode($employee));
        // $employee_candidate =    json_encode((array)$employee);
        // // Log::info($assessed_candidate);

        // Add more properties as needed

        if (isset($employee)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'employee' => $employee,
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }

    public function edit(string $id)
    {
        // Log::info($id);

        // $employeeList = $this->employee(); // Assuming $employeeList is an array of objects

        $employee = Employee::find($id);
        //   Log::info($employee);
        if (isset($employee)) {
            return response()->json([
                'status' => 200,
                'employee' => $employee,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateEmployee(Request $request, string $id)
    {
        //   log::info('tumeeanza');
        // Log::info($request->all());
        $employee = $this->employee->updateDetails($request, $id);

        $status = $employee->getStatusCode();
        // // Log::info($status);
        // // Get HTTP status code
        // $responseContent = $employeee->getContent();

        //$status
        if ($status === 200) {
            // log::info('ndani');
            return response()->json([
                'status' => 200,
                "message" => "Employeee details Updated Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Update process failed'


            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $assessment = CompetencyInterview::find($id);
        // log::info($vacancy);

        // $mployer_deactivation = $this->assessment->deactivateAssessment($id);

        if ($assessment) {
            return response()->json([
                "status" =>  200,
                "message" => 'Record updated and deleted successfully'
            ]);
        } else {
            return response()->json([
                "status" =>  404,
                "assessment" => "Action Failed",
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */

    public function  personDetails()
    {
        // Log::info('anafikaaa mkali');
        $employee =    $this->employee->getPersonalDetail();
        // Log::info($assessment;
        if ($employee) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'employee' => $employee
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
    /**
     *Save Education histories
     */
    public function saveEducation(Request $request, $id = null)
    {
        //  log::info($request->all());
        $validator = Validator::make($request->all(), [
            'education_id' => 'required|max:191',
            'institute_name' => 'required|max:191',
            'major' => 'required|max:191',
            'course' => 'required|max:191',
            'graduation_year' => 'required|max:191',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
                // Log::info('ndani ya nyumba');
            ;
            $education_level = $this->employee->addEducation($request, $id);

            $status = $education_level->getStatusCode();

            // Get HTTP status code
            $responseContent = $education_level->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Education History addedd Successfully",
                ];
            } else {
                $return = [
                    'status' => 500,
                    'message' => 'Sorry! Operation failed'


                ];
            }
        }
        return response()->json($return);
    }
    public function saveEmployment(Request $request)
    {
        //  log::info($request->all());
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|max:191',
            'from_date' => 'required|max:191',
            'to_date' => 'required|max:191',

        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
                // Log::info('ndani ya nyumba');
            ;
            $employment = $this->employee->addEmployment($request);

            $status = $employment->getStatusCode();

            // Get HTTP status code
            $responseContent = $employment->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Employment History addedd Successfully",
                ];
            } else {
                $return = [
                    'status' => 500,
                    'message' => 'Sorry! Operation failed'


                ];
            }
        }
        return response()->json($return);
    }
    public function saveReferenceCheck(Request $request)
    {
        //  log::info($request->all());
        $validator = Validator::make($request->all(), [
            'referee_id' => 'required|max:191',
            'referee_name' => 'required|max:191',
            'referee_title' => 'required|max:191',
            'referee_address' => 'required|max:191',
            'referee_contact' => 'required|max:191',
            'referee_email' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
                // Log::info('ndani ya nyumba');
            ;
            $employment_reference = $this->employee->addReferenceCheck($request);

            $status = $employment_reference->getStatusCode();

            // Get HTTP status code
            $responseContent = $employment_reference->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Employment Reference check addedd Successfully",
                ];
            } else {
                $return = [
                    'status' => 500,
                    'message' => 'Sorry! Operation failed'


                ];
            }
        }
        return response()->json($return);
    }

    public function editEducationHistory(string $id)
    {
        // log::info($id);
        $education_history = EmployeeEducation::select([
            '*',
            DB::Raw("ed.name as education"),
        ])
            ->join('education_histories as ed', 'employee_education_hist.education_id', '=', 'ed.id')
            ->where('employee_id', $id)
            ->get();
        //
        //   log::info('wpoo'. $education_history);
        if (isset($education_history)) {
            return response()->json([
                'status' => 200,
                'education_history' => $education_history,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }
    public function updateEducation(Request $request, string $id)
    {
        //    Log::info($request->all());
        $education_history = $this->employee->updateEducationHistory($request, $id);

        $status = $education_history->getStatusCode();
        // Log::info($status);
        // Get HTTP status code
        $responseContent = $education_history->getContent();


        if ($status === 200) {
            // log::info('ndani');
            return response()->json([
                'status' => 200,
                "message" => "Education Updated Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'


            ]);
        }
    }

    public function editEmployment(string $id)
    {

        $employment_history = EmploymentHistory::select([
            '*',
            //  DB::Raw("es.employee_name as education"),
        ])
            // ->leftJoin('employees as es', 'employee_employment_hist.employee_id', '=', 'es.id')
            ->where('employee_id', $id)
            ->get();

        if (isset($employment_history)) {
            return response()->json([
                'status' => 200,
                'employment_history' => $employment_history,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }
    public function updateEmployment(Request $request, string $id)
    {
        // Log::info($request->all());
        $employment_history = $this->employee->updateEmploymentHistory($request, $id);

        $status = $employment_history->getStatusCode();
        // Log::info($status);
        // Get HTTP status code
        $responseContent = $employment_history->getContent();


        if ($status === 200) {
            // log::info('ndani');
            return response()->json([
                'status' => 200,
                "message" => "Employement Updated Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'


            ]);
        }
    }
    public function editReferenceCheckt(string $id)
    {

        $reference_check = EmploymentReference::select('*')
                    ->where('employee_id', $id)
                    ->get();

        if (isset($reference_check)) {
            return response()->json([
                'status' => 200,
                'reference_check' => $reference_check,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }

    public function updateReferenceCheck(Request $request, string $id)
    {
        // Log::info($request->all());
        $reference_check = $this->employee->updateEmploymentReference($request, $id);

        $status = $reference_check->getStatusCode();
        // Log::info($status);
        // Get HTTP status code
        $responseContent = $reference_check->getContent();


        if ($status === 200) {
            // log::info('ndani');
            return response()->json([
                'status' => 200,
                "message" => "Employement Updated Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'


            ]);
        }
    }
























    // public function downloadJob(string $id)
    // {
    //     // log::info('ndanioiaiaiai');
    //     $details = $this->assessment->getAssessedCandidate();
    //     $assessment = $details->find($id);
    //     //  Log::info($assessment);
    //     if (isset($assessment)) {
    //         // Log::info('111');
    //         return response()->json([
    //             'status' => 200,
    //             'assessment' => $assessment
    //         ]);
    //     } else {
    //         // log::info('222');
    //         return response()->json([
    //             'status' => 500,
    //             'message' => "Internal server Error"
    //         ]);
    //     }
    // }

    public function getEmployeeDocument(string $id)
    {
        $document = $this->employee->getPersonalDocument();
        //   log::info($document);
        $employee_document = $document->where('employee_id', $id);

        //   log::info($employee_document);
        if (isset($employee_document)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'employee_document' => $employee_document
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
}
