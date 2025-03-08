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
use App\Models\ContractManagement\TermCondition;
use App\Repositories\ContractRepositories\TermConditionRepository;


class TermConditionController extends Controller
{
    protected $term_condition;

    public function __construct(TermConditionRepository $term_condition)
    {
        $this->term_condition = $term_condition;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function termCondition(string $id)
    {
        // Log::info($id);

        // $employeeList = $this->term_condition(); // Assuming $employeeList is an array of objects

        $employee_details =  $this->term_condition->termsDatatable($id);

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
    public function storeTermCondition(Request $request)
    {
        // Log::info('hellow ndani');
        // log::info($request->all());

        $validator = Validator::make($request->all(), [

        'employer_name'  => 'required|max:191',
        'employee_name'  => 'required|max:191',
        'job_title_id'  => 'required|max:191',
        'date_contracted'  => 'required|max:191',
        'department_id'  => 'required|max:191',
        'reg_number'  => 'required|max:191',



        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
                // Log::info('ndani ya nyumba');
            ;
            $new_term_condition = $this->term_condition->addTermCondition($request);

            $status = $new_term_condition->getStatusCode();
            // Get HTTP status code
            $responseContent = $new_term_condition->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Term condition contract successfully created.",
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

    public function getTermConditionDocument(string $id)
    {
        // log::info($id);
        $document = $this->term_condition->getSpecificContractDoc();

        $terms_document = $document->where('employee_id', $id);

        //   log::info($terms_document);
        if (isset($terms_document)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'terms_document' => $terms_document
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

        $details = $this->term_condition->showDownloadSpecific();

        $term_condition = $details->where('employee_id', $id)->first();

        // if (!isset($term_condition)) {
        //     return response()->json([
        //         'status' => 404,
        //         'message' => "No data Found"
        //     ]);
        // } else {
            if (isset($term_condition)) {
                // Log::info('111');
                return response()->json([
                    'status' => 200,
                    'term_condition' => $term_condition,
                ]);
            } else {
                // log::info('222');
                return response()->json([
                    'status' => 500,
                    'message' => "Internal server Error"
                ]);
            }

    }

    public function editTermCondition(string $id)
    {
        // Log::info($id);

        $term_condition = DB::table('contract_term_conditions as ctc')->select('ctc.*','jt.name as job_title')->leftJoin('job_title as jt', 'ctc.job_title_id', '=', 'jt.id')->where('employee_id', $id)->first();
        //   Log::info($term_condition);
        if (isset($term_condition)) {

            return response()->json([
                'status' => 200,
                'term_condition' => $term_condition,
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
    public function updateSpecificTask(Request $request, string $id)
    {
        // log::info($request->all());

        $employee = $this->term_condition->updateSpecificContract($request, $id);

            $status = $employee->getStatusCode();
            // Log::info($status);
            // // Get HTTP status code
            // $responseContent = $employeee->getContent();
            if ($status === 200) {
                // log::info('ndani');
                return response()->json([
                    'status' => 200,
                    "message" => "Specific contract Successfully updated",
                ]);
            } else if($status === 500){
                return response()->json([
                    'status' => 500,
                    'message' => 'Update process failed'
                ]);
            }else {
            return response()->json([
                'status' => 404,
                'message' => 'No Data found to be updated!; kindly register first.'
            ]);
        }
    }

    public function  getTermConditions()
    {
        // Log::info('anafikaaa mkali');
        $term_conditions =    $this->term_condition->getTermConditionContract();
        // Log::info($assessment;
        if ($term_conditions) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'term_conditions' => $term_conditions
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
    public function completeTermCondition(string $id)
    {
         //it check is doc is uploaded then it update on table and return response
         $signed = $this->term_condition->checkSignedTermsDocUploaded($id);
        //  log::info($signed);
     if($signed > 0){
        $term_condition = SpecificTask::where('employee_id', $id)->where('uploaded', 1)->first();

// log::info($term_condition);
        if (!empty($term_condition)) {
            $this->term_condition->updateStageData($term_condition);

            //   Log::info($term_condition);
            if (isset($term_condition)) {
                return response()->json([
                    'status' => 200,
                    'term_condition' => $term_condition,
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
