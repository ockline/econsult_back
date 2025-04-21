<?php

namespace App\Http\Controllers\ContractManagement;

use Illuminate\Http\Request;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\Personal\Employee;
use App\Models\ContractManagement\SpecificTask;
use App\Models\ContractManagement\FixedContract;
use App\Repositories\ContractRepositories\SpecificTaskRepository;


class SpecificTaskController extends Controller
{
    protected $specific_task;

    public function __construct(SpecificTaskRepository $specific_task)
    {
        $this->specific_task = $specific_task;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function specificTask(string $id)
    {
        // Log::info($id);

        // $employeeList = $this->specific_task(); // Assuming $employeeList is an array of objects

        $employee_details =  $this->specific_task->specificDatatable($id);

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
    public function storeSpecificTask(Request $request)
    {
        // Log::info('hellow ndani');
        // log::info($request->all());

        $validator = Validator::make($request->all(), [

        'employer_name'  => 'required|max:191',
        'employee_name'  => 'required|max:191',
        'job_title_id'  => 'required|max:191',
        'phone_number'  => 'required|max:191',
        'email'  => 'required|max:191',
        'dob'  => 'required|max:191',
        'place_recruitment'  => 'required|max:191',
        'work_station'  => 'required|max:191',
        'basic_salary'  => 'required|max:191',
        'house_allowance'  => 'required|max:191',
        'meal_allowance'  => 'required|max:191',
        'transport_allowance'  => 'required|max:191',
        'risk_bush_allowance'  => 'required|max:191',
        'normal_working'  => 'required|max:191',
        'ordinary_working'  => 'required|max:191',
        'working_from'  => 'required|max:191',
        'working_to'  => 'required|max:191',
        'saturday_from'  => 'required|max:191',
        'saturday_to'  => 'required|max:191',
        'department_id'  => 'required|max:191',
        'bank_name'  => 'required|max:191',
        'bank_account_no'  => 'required|max:191',
        'bank_account_name'  => 'required|max:191',
        'residence_place'  => 'required|max:191',
        'nssf_number'  => 'required|max:191',
        'supervisor'  => 'required|max:191',
        'start_date'  => 'required|max:191',
        'expected_end_date'  => 'required|max:191',
        'monthly_salary'  => 'required|max:191',
        // 'night_shift'  => 'required|max:191',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
                // Log::info('ndani ya nyumba');

            $new_specific_task = $this->specific_task->addFixedContract($request);

            $status = $new_specific_task->getStatusCode();
            // Get HTTP status code
            $responseContent = $new_specific_task->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Specific task contract Successfully Created.",
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

    public function getSpecificTaskDocument(string $id)
    {
        // log::info($id);
        $contract_document = $this->specific_task->getSpecificContractDoc($id);

        // $contract_document = $document->where('employee_id', $id);

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

        $specific_task = $this->specific_task->showDownloadSpecific($id);



            if (isset($specific_task)) {
                // Log::info('111');
                return response()->json([
                    'status' => 200,
                    'specific_task' => $specific_task,
                ]);
            } else {
                // log::info('222');
                return response()->json([
                    'status' => 500,
                    'message' => "Internal server Error"
                ]);
            }

    }


    public function editSpecificTask(string $id)
    {
        // Log::info($id);

        $specific_task = SpecificTask::select('contract_specific.*','jt.name as job_title')->leftJoin('job_title as jt', 'contract_specific.job_title_id', '=', 'jt.id')->where('employee_id', $id)->first();
        //   Log::info($specific_task);
        if (isset($specific_task)) {

            return response()->json([
                'status' => 200,
                'specific_task' => $specific_task,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }
    /**
    *@method to preview specific contract
     */
    public function previewSpecificTaskContract(string $id)
            {

                    $specific_contract = $this->specific_task->previewSpecificTaskContract($id);


                        if (isset($specific_contract)) {
                            // Log::info('111');
                            return response()->json([
                                'status' => 200,
                                'specific_contract' => $specific_contract,
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
     * Update the specified resource in storage.
     */
    public function updateSpecificTask(Request $request, string $id)
    {
        // log::info($request->all());

        $employee = $this->specific_task->updateSpecificContract($request, $id);

            $status = $employee->getStatusCode();
            // Log::info($status);
            // // Get HTTP status code
            // $responseContent = $employeee->getContent();
            if ($status === 200) {
                // log::info('ndani');
                return response()->json([
                    'status' => 200,
                    "message" => "Specific Contract successfully updated.",
                ]);
            } else if($status === 500){
                return response()->json([
                    'status' => 500,
                    'message' => 'Sorry! operation failed.'
                ]);
            }else {
            return response()->json([
                'status' => 404,
                'message' => 'No Data found to be updated!; kindly register first'
            ]);
        }
    }

    public function  getSpecificTask()
    {
        // Log::info('anafikaaa mkali');
        $specific_task =    $this->specific_task->getSpecificTaskContract();
        // Log::info($assessment;
        if ($specific_task) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'specific_task' => $specific_task
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
    public function completeSpecificTask(string $id)
    {
         //it check is doc is uploaded then it update on table and return response
         $signed = $this->specific_task->checkSignedSpecificDocUploaded($id);
        //  log::info($signed);
     if($signed > 0){
        $specific_task = SpecificTask::where('employee_id', $id)->where('uploaded', 1)->first();

// log::info($specific_task);
        if (!empty($specific_task)) {
            $this->specific_task->updateStageData($specific_task);

            //   Log::info($specific_task);
            if (isset($specific_task)) {
                return response()->json([
                    'status' => 200,
                    'specific_task' => $specific_task,
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
                'message' => "You have not uploaded signed Specific Contract",

            ]);
        }
    }else{
return response()->json([
                'status' => 404,
                'message' => "You have not uploaded signed Specific Task Contract",

            ]);
}
    }

}
