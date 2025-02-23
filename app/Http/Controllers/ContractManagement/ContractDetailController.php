<?php

namespace App\Http\Controllers\ContractManagement;

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
use App\Models\ContractManagement\ContractDetail;
use App\Models\Employee\Personal\EmployeeEducation;
use App\Models\Employee\Personal\EmploymentHistory;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Models\Employee\Personal\EmploymentReference;
use App\Models\Employee\Application\PersonnelApplication;
use App\Repositories\EmployeeRepositories\EmployeeRepository;
use App\Repositories\HiringRepositories\HrInterviewRepository;
use App\Repositories\EmployeeRepositories\SocialRecordRepository;
use App\Repositories\ContractRepositories\ContractDetailRepository;
use App\Repositories\EmployeeRepositories\PersonnelApplicationRepository;

class ContractDetailController extends Controller
{
    protected $contract;

    public function __construct(ContractDetailRepository $contract)
    {
        $this->contract = $contract;
    }
    /**
     * Display a listing of the resource.
     */
    public function getAllContracts()
    {
        $all_contracts = $this->contract->getContractDatatable();
        if (isset($all_contracts)) {
            return response()->json([
                'status' => 200,
                'all_contracts' => $all_contracts,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }
    public function getSocialRecord(string $id)
    {
        // Log::info($id);

        // $employeeList = $this->contract(); // Assuming $employeeList is an array of objects

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
    public function storeContractDetail(Request $request)
    {
        // Log::info('hellow ndani');
        // log::info($request->all());

        $validator = Validator::make($request->all(), [


            'firstname' => 'required|max:191',
            'middlename' => 'required|max:191',
            'lastname' => 'required|max:191',
            'birth_place' => 'required|max:191',
            'job_title_id' => 'required|max:191',
            'employee_id' => 'required|max:191',
            'contract_id' => 'required|max:191',
            'employer_id' => 'required|max:191',
            'job_title_id' => 'required|max:191',
            'phone_number' => 'required|max:191',
            'email' => 'required|max:191',
            'dob' => 'required|max:191',
            'postal_address' => 'required|max:191',
            'residence_place' => 'required|max:191',
            'permanent_residence' => 'required|max:191',
            'place_recruitment' => 'required|max:191',
            'work_station' => 'required|max:191',
            'date_employed' => 'required|max:191',
            'fullname_next1' => 'required|max:191',
            'residence1' => 'required|max:191',
            'phone_number1' => 'required|max:191',
            'relationship1' => 'required|max:191',
            'passport_attachment' =>'required'


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
                // Log::info('ndani ya nyumba');
            ;
            $ne_contract_details = $this->contract->addContractDetail($request);

            $status = $ne_contract_details->getStatusCode();

            // Get HTTP status code
            $responseContent = $ne_contract_details->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Employee person details successfuly submitted.",
                ];
            } else {
                $return = [
                    'status' => 500,
                    'message' => 'Sorry! Operation failed.'

                ];
            }
        }
        return response()->json($return);
    }

    public function getContractDocument(string $id)
    {
        // log::info($id);
        $document = $this->contract->getContractDoc();


        $contract_document = $document->where('employee_id', $id);

        //   log::info($contract_document);
        if (isset($contract_document)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'contract_document' => $contract_document
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

        $details = $this->contract->showDownloadDetails();

        $contract_detail = $details->where('employee_id', $id)->first();

        if(!isset($contract_detail)){
            return response()->json([
                'status' => 404,
                'message' => "No data Found"
            ]);
     }else{
        if (isset($contract_detail)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'contract_detail' => $contract_detail,
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

    public function editContractDetail(string $id)
    {
        // Log::info($id);

        // $employeeList = $this->contract(); // Assuming $employeeList is an array of objects
        // $social = SocialRecord::where('id', $id)->first();
        // log::info($social);
        $contract_detail = ContractDetail::where('employee_id', $id)->first();
        //   Log::info($contract_detail);
        if (isset($contract_detail)) {

            return response()->json([
                'status' => 200,
                'contract_detail' => $contract_detail,
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
    public function updateContractDetail(Request $request, string $id)
    {


        $employee = $this->contract->updateContractRequiredDetails($request, $id);

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
                    "message" => "Contract details Successfully updated.",
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Sorry! operation failed.'


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

    //     // $employer_deactivation = $this->assessment->deactivateAssessment($id);

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

    public function  contractDetails()
    {
        // Log::info('anafikaaa mkali');
        $contract_detail =    $this->contract->getContractDetails();
        // Log::info($assessment;
        if ($contract_detail) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'contract_detail' => $contract_detail
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
     *@method to complete Employee Required doc  for Contract  and become ready for initiate workflow
     */
    public function completeContractDetail(string $id)
    {
        // log::info('twende');
        // log::info($id);
        // $social = SocialRecord::where('id', $id)->first();
        // log::info($social);
        $contract_details = ContractDetail::where('employee_id', $id)->first();

        if (!empty($contract_details)) {
            $this->contract->updateStageData($contract_details);

            //   Log::info($contract_details);
            if (isset($contract_details)) {
                return response()->json([
                    'status' => 200,
                    'contract_details' => $contract_details,
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
