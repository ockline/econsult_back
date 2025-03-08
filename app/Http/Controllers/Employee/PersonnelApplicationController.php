<?php

namespace App\Http\Controllers\Employee;

use Mpdf\Mpdf;
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
        $personnel_application = $this->personnel_application->showDownloadDetails($id);

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

    //block to handle new Id application request
    public function createIdApplication(Request $request)
    {
        log::info($request->all());
        $validator = Validator::make($request->all(), [

            'id_type' => 'required|max:191',

        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        }

        if ($request->id_type == 1) {
            $validator = Validator::make($request->all(), [

                'department_id' => 'required|max:191',
                'firstname' => 'required|max:191',
                'middlename' => 'required|max:191',
                'lastname' => 'required|max:191',
                'national_id' => 'required|max:191',
                'duration_deployment' => 'required|max:191',
                // 'birth_place' => 'required|max:191',
                'job_title_id' => 'required|max:191',
                'purpose' => 'required|max:191',

            ]);

            if ($validator->fails()) {
                $return = ['validator_err' => $validator->errors()->toArray()];
            } else {

                $new_employee = $this->personnel_application->addPersonnelApplication($request);
                $status = $new_employee->getStatusCode();

                $responseContent = $new_employee->getContent();
                if ($status === 201) {
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
        } // change job title
        else if ($request->id_type == 2) {

            $validator = Validator::make($request->all(), [

                'new_department_id' => 'required|max:191',
                'firstname' => 'required|max:191',
                // 'middlename' => 'required|max:191',
                'lastname' => 'required|max:191',
                // 'national_id' => 'required|max:191',
                'new_job_title_id' => 'required|max:191',
                'employee_no' => 'required|max:191',
                'effective_date' => 'required|max:191',

            ]);

            if ($validator->fails()) {
                $return = ['validator_err' => $validator->errors()->toArray()];
            } else {

                $new_employee = $this->personnel_application->addChangeJobTitle($request);
                $status = $new_employee->getStatusCode();

                 if ($status === 201) {

                    $return = [
                        'status' => 200,
                        "message" => "Employee Job title change successfully submitted.",
                    ];
                } else {
                    $return = [
                        'status' => 500,
                        'message' => 'Sorry! Operation failed'

                    ];
                }
            }
        } //subcontractor
        else if ($request->id_type == 3) {

            $validator = Validator::make($request->all(), [


                'firstname' => 'required|max:191',
                // 'middlename' => 'required|max:191',
                'lastname' => 'required|max:191',
                'national_id' => 'required|max:191',
                'contact_person' => 'required|max:191',
                'phone_number' => 'required|max:191',
                'email_address' => 'required|max:191',
                'job_title_id' => 'required|max:191',
                'from_date' => 'required|max:191',
                'end_date' => 'required|max:191',
                'emergency_contact_name' => 'required|max:191',
                'emergency_contact_number' => 'required|max:191',

            ]);

            if ($validator->fails()) {
                $return = ['validator_err' => $validator->errors()->toArray()];
            } else {

                $new_employee = $this->personnel_application->addSubcontractorRequest($request);
                $status = $new_employee->getStatusCode();

                if ($status === 201) {
                    $return = [
                        'status' => 200,
                        "message" => "Subcontractor person details successfully submitted.",
                    ];
                } else {
                    $return = [
                        'status' => 500,
                        'message' => 'Sorry! Operation failed'

                    ];
                }
            }
        } // temporary site pass
        else if ($request->id_type == 4) {

            $validator = Validator::make($request->all(), [

                'department_id' => 'required|max:191',
                'firstname' => 'required|max:191',
                'organization' => 'required|max:191',
                'lastname' => 'required|max:191',
                'national_id' => 'required|max:191',
                'contact_number' => 'required|max:191',
                'host_name' => 'required|max:191',
                'job_title_id' => 'required|max:191',
                'purpose' => 'required|max:191',
                'from_date' => 'required|max:191',
                'end_date' => 'required|max:191',

            ]);

            if ($validator->fails()) {
                $return = ['validator_err' => $validator->errors()->toArray()];
            } else {

                $new_employee = $this->personnel_application->addTemporaryRequest($request);
                $status = $new_employee->getStatusCode();
                $responseContent = $new_employee->getContent();
                if ($status === 201) {
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
        } //vistor
        else if ($request->id_type == 5) {
            $validator = Validator::make($request->all(), [

                'department_id' => 'required|max:191',
                'firstname' => 'required|max:191',
                'organization' => 'required|max:191',
                'lastname' => 'required|max:191',
                'national_id' => 'required|max:191',
                'contact_number' => 'required|max:191',
                'host_name' => 'required|max:191',
                'job_title_id' => 'required|max:191',
                'purpose' => 'required|max:191',
                // 'from_date' => 'required|max:191',
                // 'end_date' => 'required|max:191',

            ]);

            if ($validator->fails()) {
                $return = ['validator_err' => $validator->errors()->toArray()];
            } else {
                $new_employee = $this->personnel_application->addVistorRequest($request);
                $status = $new_employee->getStatusCode();

                $responseContent = $new_employee->getContent();

                if ($status === 201) {
                    $return = [
                        'status' => 200,
                        "message" => "Vistor person details successfully submitted.",
                    ];
                } else {
                    $return = [
                        'status' => 500,
                        'message' => 'Sorry! Operation failed'

                    ];
                }
            }
        } // Trainee
        else if ($request->id_type == 6) {
            $validator = Validator::make($request->all(), [

                'department_id' => 'required|max:191',
                'firstname' => 'required|max:191',
                'middlename' => 'required|max:191',
                'lastname' => 'required|max:191',
                'national_id' => 'required|max:191',
                'institution_name' => 'required|max:191',
                'course_study' => 'required|max:191',
                'from_date' => 'required|max:191',
                'end_date' => 'required|max:191',

            ]);

            if ($validator->fails()) {
                $return = ['validator_err' => $validator->errors()->toArray()];
            } else {

                $new_employee = $this->personnel_application->addTraineeRequest($request);
                $status = $new_employee->getStatusCode();

                $responseContent = $new_employee->getContent();

                if ($status === 201) {

                    $return = [
                        'status' => 200,
                        "message" => "Trainee details successfully submitted.",
                    ];
                } else {
                    $return = [
                        'status' => 500,
                        'message' => 'Sorry! Operation failed'

                    ];
                }
            }
        } else {
            $return = [
                'status' => 500,
                'message' => "No Id type Selected, Kindly select any of listed",

            ];
        }
        return response()->json($return);
    }
/**
*@method tor retrieve all id request
 */
public function retrieveGeneralIdRequest()
{

        $general_id_requests =    $this->personnel_application->retrieveGeneralIdRequest();

        if ($general_id_requests) {

            return response()->json([
                'status' => 200,
                'general_id_requests' => $general_id_requests
               ]);
        } else {

            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }

}
/**
*@method that retrieve requested   id application
 */
public function retrieveIdRequest($id)
{

        $general_id_requests =    $this->personnel_application->retrieveIdRequest($id);

        if ($general_id_requests) {

            return response()->json([
                'status' => 200,
                'general_id_requests' => $general_id_requests
               ]);
        } else {

            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }

}
/**
*@method to get requested form for preview
 */
public function previewApplicationForm($id, $type)
{
    $startTime = microtime(true);

$details = $this->personnel_application->previewApplicationForm($id, $type);
Log::info('Employee Details:', (array)$details);

if ($type == 1) {
    if (isset($details)) {
        try {
            // Configure mPDF with specific settings
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_header' => 0,
                'margin_top' => 20,
                'margin_bottom' => 20,
                'margin_footer' => 0,
            ]);

            // Enable image handling and set temp directory
            $mpdf->showImageErrors = true;

            $mpdf->SetTitle('New Employee');

            // Convert image paths to absolute paths
            $logoPath = public_path('images/socrate.png');
            $backgroundPath = public_path('images/socrate_emp.png');

            // Pass the absolute paths to the view
            $sheet = view('general_application.new_employee', [
                'employee' => $details,
                'logoPath' => $logoPath,
                'backgroundPath' => $backgroundPath
            ])->render();



            // Add debug information
            Log::info('HTML Content Length: ' . strlen($sheet));

            $mpdf->WriteHTML($sheet);

            // Output PDF to string
            $pdfContent = $mpdf->Output('', 'S');

            Log::info('PDF Content Length: ' . strlen($pdfContent));

            if (strlen($pdfContent) === 0) {
                throw new \Exception('PDF generation produced empty content');
            }

            $details = base64_encode($pdfContent);

            $executionTime = microtime(true) - $startTime;
            Log::info('PDF generation completed in ' . $executionTime . ' seconds');

            return response()->json([
                'status' => 200,
                'details' => $details,
                'message' => 'Success'
            ]);

        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'status' => 500,
                'message' => "Error generating PDF: " . $e->getMessage()
            ]);
        }
    }

    return response()->json([
        'status' => 500,
        'message' => "No details found for the employee."
    ]);
}

    if ($type == 2) {
        if (isset($details)) {
            $mpdf = new Mpdf();
            $mpdf->SetTitle('Fixed Contract');
            $sheet = view('ContractTemplate.details', [
                'details' => $details,
            ]);
            $mpdf->WriteHTML($sheet);
            $details = base64_encode($mpdf->Output('', 'S'));
            return response()->json(['details' => $details, 'status' => 200]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
    if ($type == 3) {
        if (isset($details)) {
            $mpdf = new Mpdf();
            $mpdf->SetTitle('Fixed Contract');
            $sheet = view('ContractTemplate.details', [
                'details' => $details,
            ]);
            $mpdf->WriteHTML($sheet);
            $fixed = base64_encode($mpdf->Output('', 'S'));
            return response()->json([ 'status' => 200,
                'details' =>  $details,
                'message' => 'Success'
]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
    if ($type == 4) {
        if (isset($details)) {
            $mpdf = new Mpdf();
            $mpdf->SetTitle('Fixed Contract');
            $sheet = view('ContractTemplate.details', [
                'details' => $details,
            ]);
            $mpdf->WriteHTML($sheet);
            $fixed = base64_encode($mpdf->Output('', 'S'));
            return response()->json([ 'status' => 200,
                'details' =>  $details,
                'message' => 'Success']);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
    if ($type == 5) {
        if (isset($details)) {
            $mpdf = new Mpdf();
            $mpdf->SetTitle('Fixed Contract');
            $sheet = view('ContractTemplate.details', [
                'details' => $details,
            ]);
            $mpdf->WriteHTML($sheet);
            $fixed = base64_encode($mpdf->Output('', 'S'));
           return response()->json([ 'status' => 200,
                'details' =>  $details,
                'message' => 'Success']);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    } else {
        if (isset($details)) {
            $mpdf = new Mpdf();
            $mpdf->SetTitle('Fixed Contract');
            $sheet = view('ContractTemplate.details', [
                'details' => $details,
            ]);
            $mpdf->WriteHTML($sheet);
            $fixed = base64_encode($mpdf->Output('', 'S'));
            return response()->json([ 'status' => 200,
                'details' =>  $details,
                'message' => 'Success']);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
return response()->json([
                    'status' => 200,
                    'details' =>  $details,
                    'message' => 'Success'
                ]);
}
}
