<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Employee\Social\Dependant;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\Personal\Employee;
use App\Models\Employee\Social\SocialRecord;
use App\Models\Employee\Social\RelativeDetail;
use App\Models\Hiring\JobApplication\JobVacancy;
use App\Models\Employee\Personal\EmployeeEducation;
use App\Models\Employee\Personal\EmploymentHistory;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Models\Employee\Personal\EmploymentReference;
use App\Models\Employee\Application\PersonnelApplication;
use App\Repositories\EmployeeRepositories\EmployeeRepository;
use App\Repositories\HiringRepositories\HrInterviewRepository;
use App\Repositories\EmployeeRepositories\SocialRecordRepository;
use App\Repositories\EmployeeRepositories\PersonnelApplicationRepository;

class PersonnelApplicationController extends Controller
{
    protected $personnel_application;

    public function __construct(PersonnelApplicationRepository $personnel_application)
    {
        $this->personnel_application = $personnel_application;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function getSocialRecord(string $id)
    {
        // Log::info($id);

        // $employeeList = $this->personnel_application(); // Assuming $employeeList is an array of objects

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
     * Store a newly created resource in storage.
     */
    public function storePersonnel(Request $request)
    {
        // Log::info('hellow ndani');
        // log::info($request->all());

        $validator = Validator::make($request->all(), [

            'department_id' => 'required|max:191',
            'firstname' => 'required|max:191',
            'middlename' => 'required|max:191',
            'lastname' => 'required|max:191',
            'national_id' => 'required|max:191',
            'duration_deployment' => 'required|max:191',
            'birth_place' => 'required|max:191',
            'job_title_id' => 'required|max:191',
            'purpose' => 'required|max:191',

        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
                // Log::info('ndani ya nyumba');
            ;
            $new_employee = $this->personnel_application->addPersonnelApplication($request);

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

    public function getPersonnelDocument(string $id)
    {
        // log::info($id);
        $document = $this->personnel_application->getPersonnelDoc();

            $data = SocialRecord::where('id', $id)->first();
        // log::info($data);
        $personnel_document = $document->where('employee_id', $data->employee_id);

        //   log::info($personnel_document);
        if (isset($personnel_document)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'personnel_document' => $personnel_document
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //  log::info($id);
        $details = $this->personnel_application->showDownloadDetails();
        $data = SocialRecord::where('id', $id)->first();

        $personnel_application = $details->where('employee_id', $data->employee_id)->first();

        //   log::info($personnel_application);
        if (isset($personnel_application)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'personnel_application' => $personnel_application,
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

        // $employeeList = $this->personnel_application(); // Assuming $employeeList is an array of objects
        $social = SocialRecord::where('id', $id)->first();
        // log::info($social);
        $personnel_applications = PersonnelApplication::where('employee_id', $social->employee_id)->first();
        //   Log::info($personnel_applications);
        if (isset($personnel_applications)) {
            return response()->json([
                'status' => 200,
                'personnel_applications' => $personnel_applications,
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
    public function updatePersonnelApplication(Request $request, string $id)
    {


        $employee = $this->personnel_application->updateApplicationDetails($request, $id);

        if (empty($employee)) {
            return response()->json([
                'status' => 404,
                'message' => 'No Data found to be updated!; kindly register first'
            ]);
        } else {
            $status = $employee->getStatusCode();
            // Log::info($status);
            // // Get HTTP status code
            // $responseContent = $employeee->getContent();
            if ($status === 200) {
                // log::info('ndani');
                return response()->json([
                    'status' => 200,
                    "message" => "Social Record Updated Successfully",
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Update process failed'


                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {

    //     $assessment = CompetencyInterview::find($id);
    //     // log::info($vacancy);

    //     // $mployer_deactivation = $this->assessment->deactivateAssessment($id);

    //     if ($assessment) {
    //         return response()->json([
    //             "status" =>  200,
    //             "message" => 'Record updated and deleted successfully'
    //         ]);
    //     } else {
    //         return response()->json([
    //             "status" =>  404,
    //             "assessment" => "Action Failed",
    //         ]);
    //     }
    // }
    /**
     * Remove the specified resource from storage.
     */

    public function  applicationDetails()
    {
        // Log::info('anafikaaa mkali');
        $personnel_application =    $this->personnel_application->getApplicationDetail();
        // Log::info($assessment;
        if ($personnel_application) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'personnel_application' => $personnel_application
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }





    public function getSocialRecordDocument(string $id)
    {
        // //   log::info($id);
        // $document = $this->personnel_application->getPersonalDocument();
        // //   log::info($document);
        // $employee_document = $document->where('employee_id', $id);

        // //   log::info($employee_document);
        // if (isset($employee_document)) {
        //     // Log::info('111');
        //     return response()->json([
        //         'status' => 200,
        //         'employee_document' => $employee_document
        //     ]);
        // } else {
        //     // log::info('222');
        //     return response()->json([
        //         'status' => 500,
        //         'message' => "Internal server Error"
        //     ]);
        // }
    }
    /**
     *@method to complete Personnel Id application  and become ready for initiate workflow
     */
    public function completePersonnelApplication(string $id)
    {

        $social = SocialRecord::where('id', $id)->first();
        // log::info($social);
        $personnel_applications = PersonnelApplication::where('employee_id', $social->employee_id)->first();

        if (!empty($personnel_applications)) {
            $data_update = $this->personnel_application->updateStageData($personnel_applications);

            if (isset($personnel_applications)) {
                return response()->json([
                    'status' => 200,
                    'personnel_applications' => $personnel_applications,
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "No data found",

                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }
}
