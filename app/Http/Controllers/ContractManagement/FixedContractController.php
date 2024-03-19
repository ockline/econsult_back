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
use App\Models\ContractManagement\FixedContract;
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
use App\Repositories\ContractRepositories\FixedContractRepository;
use App\Repositories\ContractRepositories\ContractDetailRepository;
use App\Repositories\EmployeeRepositories\PersonnelApplicationRepository;

class FixedContractController extends Controller
{
    protected $fixed_contract;

    public function __construct(FixedContractRepository $fixed_contract)
    {
        $this->fixed_contract = $fixed_contract;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function fixedContract(string $id)
    {
        // Log::info($id);

        // $employeeList = $this->fixed_contract(); // Assuming $employeeList is an array of objects

        $employee_details =  $this->fixed_contract->fixedDatatable($id);

        if (isset($employee_details)) {
            // log::info('hapaa');
            return response()->json([
                'status' => 200,
                'employee_details' => $employee_details,
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
    public function storeFixed(Request $request)
    {
        // Log::info('hellow ndani');
        // log::info($request->all());

        $validator = Validator::make($request->all(), [


            'employer_name' => 'required|max:191',
            'employee_name' => 'required|max:191',
            'job_title_id' => 'required|max:191',
            'employee_id' => 'required|max:191',
            'job_title_id' => 'required|max:191',
            'phone_number' => 'required|max:191',
            'email' => 'required|max:191',
            'dob' => 'required|max:191',
            'job_profile' => 'required|max:191',
            'reporting_to' => 'required|max:191',
            'staff_classfication' => 'required|max:191',
            'place_recruitment' => 'required|max:191',
            'work_station' => 'required|max:191',
            // 'commencement_date' => 'required|max:191',
            'probation_period' => 'required|max:191',
            'remuneration' => 'required|max:191',
            'basic_salary' => 'required|max:191',
            'house_allowance' => 'required|max:191',
            'meal_allowance' => 'required|max:191',
            'transport_allowance' => 'required|max:191',
            'risk_bush_allowance' => 'required|max:191',
            'normal_working' => 'required|max:191',
            'ordinary_working' => 'required|max:191',
            'working_from' => 'required|max:191',
            'working_to' => 'required|max:191',
            'saturday_from' => 'required|max:191',
            'saturday_to' => 'required|max:191',
            'covered_statutory' => 'required|max:191',

        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
                // Log::info('ndani ya nyumba');
            ;
            $new_fixed_contract = $this->fixed_contract->addFixedContract($request);

            $status = $new_fixed_contract->getStatusCode();
            // Get HTTP status code
            $responseContent = $new_fixed_contract->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Employee Fixed Contract submitted",
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

    public function getContractDocument(string $id)
    {
        // log::info($id);
        $document = $this->fixed_contract->getFixedContractDoc();

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

        $details = $this->fixed_contract->showDownloadFixed();

        $fixed_contract = $details->where('employee_id', $id)->first();

        // if (!isset($fixed_contract)) {
        //     return response()->json([
        //         'status' => 404,
        //         'message' => "No data Found"
        //     ]);
        // } else {
            if (isset($fixed_contract)) {
                // Log::info('111');
                return response()->json([
                    'status' => 200,
                    'fixed_contract' => $fixed_contract,
                ]);
            } else {
                // log::info('222');
                return response()->json([
                    'status' => 500,
                    'message' => "Internal server Error"
                ]);
            }

    }

    public function editFixed(string $id)
    {
        // Log::info($id);

        $fixed_contract = FixedContract::select('contract_fixed.*','jt.name as job_title')->leftJoin('job_title as jt', 'contract_fixed.job_title_id', '=', 'jt.id')->where('employee_id', $id)->first();
        //   Log::info($fixed_contract);
        if (isset($fixed_contract)) {

            return response()->json([
                'status' => 200,
                'fixed_contract' => $fixed_contract,
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
    public function updateFixedContract(Request $request, string $id)
    {
        // log::info($request->all());

        $employee = $this->fixed_contract->updateFixedContract($request, $id);

            $status = $employee->getStatusCode();
            // Log::info($status);
            // // Get HTTP status code
            // $responseContent = $employeee->getContent();
            if ($status === 200) {
                // log::info('ndani');
                return response()->json([
                    'status' => 200,
                    "message" => "Fixed Contract Updated Successfully",
                ]);
            } else if($status === 500){
                return response()->json([
                    'status' => 500,
                    'message' => 'Update process failed'
                ]);
            }else {
            return response()->json([
                'status' => 404,
                'message' => 'No Data found to be updated!; kindly register first'
            ]);
        }
    }

    public function  getFixedContracts()
    {
        // Log::info('anafikaaa mkali');
        $fixed_contract =    $this->fixed_contract->getFixedContractDetails();
        // Log::info($assessment;
        if ($fixed_contract) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'fixed_contract' => $fixed_contract
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
    public function completeFixedContrat(string $id)
    {
        $fixed_contract = FixedContract::where('employee_id', $id)->where('uploaded', 1)->first();

// log::info($fixed_contract);
        if (!empty($fixed_contract)) {
            $this->fixed_contract->updateStageData($fixed_contract);

            //   Log::info($fixed_contract);
            if (isset($fixed_contract)) {
                return response()->json([
                    'status' => 200,
                    'fixed_contract' => $fixed_contract,
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "No data found",
                ]);
            }
        } else {
            // log::info('hapaa');
            return response()->json([
                'status' => 404,
                'message' => "You have not uploaded signed fixed Contract",

            ]);
        }
    }
}
