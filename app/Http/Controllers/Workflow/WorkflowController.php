<?php

namespace App\Http\Controllers\Workflow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
     * Initiate job vacancy workflow.
     */
    public function initiateJobWorkflow(Request $request)
    {
        $initiateDetails = $this->workflows->saveInitiatedVacancy($request);
        $status = $initiateDetails->getStatusCode();

        if ($status === 201) {
            return response()->json([
                'status' => 200,
                'message' => 'Job workflow successfully initiated',
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Sorry! Operation failed',
        ]);
    }

    /**
     * Return initiated job vacancy workflow details.
     */
    public function returnInitiatedVacancy($workflow)
    {
        $initiatedDetails = $this->workflows->retriveInitiatedVacancy($workflow);

        if ($initiatedDetails) {
            return response()->json([
                'status' => 200,
                'initiated_details' => $initiatedDetails,
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Sorry! Data Not Found',
        ]);
    }

    /**
     * Review initiated workflow.
     */
    public function reviewInitiatedVacancy(Request $request)
    {
        $reviewDetails = $this->workflows->saveReviewVacancy($request);
        $status = $reviewDetails->getStatusCode();

        if ($status === 201) {
            return response()->json([
                'status' => 200,
                'message' => 'Job workflow successfully reviewed',
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Sorry! Operation failed',
        ]);
    }

    public function review(string $id)
    {
        $employee = Employee::find($id);

        if ($employee) {
            return response()->json([
                'status' => 200,
                'employee' => $employee,
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No data found',
        ]);
    }

    /**
     * Return pending workflow histories (status = initiated).
     */
    public function pendingWorkflows(Request $request)
    {
        $limit = (int) $request->get('limit', 15);
        $pending = $this->workflows->getPendingWorkflows($limit);

        return response()->json([
            'status' => 200,
            'count' => count($pending),
            'pending_workflows' => $pending,
        ]);
    }
}
