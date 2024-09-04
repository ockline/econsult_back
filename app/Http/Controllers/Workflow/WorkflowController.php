<?php

namespace App\Http\Controllers\Workflow;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\Personal\Employee;
use App\Repositories\WorkflowRepositories\WorkflowRepository;


class WorkflowController extends Controller
{
    protected $workflows;

    public function __construct(WorkflowRepository $workflows)
    {
        $this->workflows = $workflows;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
*@method to initiate job vacancy workflow
 */
public function  initiateJobWorkflow(Request $request)
{

 $initate_details =    $this->workflows->saveInitiatedVacancy($request);

$status = $initate_details->getStatusCode();

// log::info($status);
        if ($status === 201) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'message' => 'Job workflow successfully initiated',
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Sorry! Operation failed"
            ]);
        }
}

/**
*@method to return initiated job vacancy workflow
 */
public function  returnInitiatedVacancy($workflow)
{

 $initiated_details =    $this->workflows->retriveInitiatedVacancy($workflow);




        if ($initiated_details) {

            return response()->json([
                'status' => 200,
                'initiated_details' => $initiated_details,
            ]);
        } else {
        
            return response()->json([
                'status' => 500,
                'message' => "Sorry! Data Not Found"
            ]);
        }

}


 /**
*@method to initiate job vacancy workflow
 */
public function  reviewInitiatedVacancy(Request $request)
{

 $review_details =    $this->workflows->saveReviewVacancy($request);

$status = $review_details->getStatusCode();


        if ($status === 201) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'message' => 'Job workflow successfully review',
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Sorry! Operation failed"
            ]);
        }
}

    public function review(string $id)
    {

        $employee = Employee::find($id);
        //   Log::info($employeeList->$employee);
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






}
