<?php

namespace App\Http\Controllers\Exits;

use App\Http\Controllers\Controller;
use App\Repositories\Exits\EndContractWorkflowRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EndContractWorkflowController extends Controller
{
    protected $workflow;

    public function __construct(EndContractWorkflowRepository $workflow)
    {
        $this->workflow = $workflow;
    }

    /**
     * Review end contract (HR/IR level)
     */
    public function review(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'endcontract_id' => 'required|exists:end_contracts,id',
            'comments' => 'nullable|string',
            'hr_recommendations' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // If hr_recommendations is not provided, use comments as fallback
        if (!$request->has('hr_recommendations') || empty($request->hr_recommendations)) {
            $request->merge(['hr_recommendations' => $request->comments]);
        }

        return $this->workflow->reviewEndContract($request);
    }

    /**
     * Manager review and recommendation
     */
    public function managerReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'endcontract_id' => 'required|exists:end_contracts,id',
            'comments' => 'nullable|string',
            'manager_recommendations' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // If manager_recommendations is not provided, use comments as fallback
        if (!$request->has('manager_recommendations') || empty($request->manager_recommendations)) {
            $request->merge(['manager_recommendations' => $request->comments]);
        }

        return $this->workflow->managerReview($request);
    }

    /**
     * Approve end contract
     */
    public function approve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'endcontract_id' => 'required|exists:end_contracts,id',
            'comments' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->workflow->approveEndContract($request);
    }

    /**
     * Reject end contract
     */
    public function reject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'endcontract_id' => 'required|exists:end_contracts,id',
            'comments' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->workflow->rejectEndContract($request);
    }

    /**
     * Return end contract for revision
     */
    public function return(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'endcontract_id' => 'required|exists:end_contracts,id',
            'comments' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->workflow->returnEndContract($request);
    }

    /**
     * Get workflow history for end contract
     */
    public function getWorkflowHistory($endContractId)
    {
        return $this->workflow->getWorkflowHistory($endContractId);
    }

    /**
     * Get pending workflows for current user
     */
    public function getPendingWorkflows(Request $request)
    {
        $userId = auth()->id() ?? 1;
        return $this->workflow->getPendingWorkflows($userId);
    }

    /**
     * Get workflow statistics
     */
    public function getWorkflowStatistics()
    {
        try {
            $model = $this->workflow->getModel();

            $statistics = [
                'total_workflows' => $model->count(),
                'pending_reviews' => $model->byStatus('Submitted')->count(),
                'completed_reviews' => $model->byStatus('Reviewed')->count(),
                'approved' => $model->byStatus('Approved')->count(),
                'rejected' => $model->byStatus('Rejected')->count(),
                'returned' => $model->byStatus('Returned')->count(),
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Workflow statistics retrieved successfully',
                'data' => $statistics
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve workflow statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk approve end contracts
     */
    public function bulkApprove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'endcontract_ids' => 'required|array',
            'endcontract_ids.*' => 'exists:end_contracts,id',
            'comments' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $results = [];
        $successCount = 0;
        $errorCount = 0;

        foreach ($request->endcontract_ids as $endContractId) {
            $approveRequest = new Request([
                'endcontract_id' => $endContractId,
                'comments' => $request->comments
            ]);

            $result = $this->workflow->approveEndContract($approveRequest);
            $results[] = [
                'endcontract_id' => $endContractId,
                'status' => $result->getStatusCode() === 200 ? 'success' : 'error',
                'message' => json_decode($result->getContent())->message
            ];

            if ($result->getStatusCode() === 200) {
                $successCount++;
            } else {
                $errorCount++;
            }
        }

        return response()->json([
            'status' => 200,
            'message' => "Bulk approval completed. {$successCount} successful, {$errorCount} failed.",
            'data' => [
                'results' => $results,
                'summary' => [
                    'total' => count($request->endcontract_ids),
                    'successful' => $successCount,
                    'failed' => $errorCount
                ]
            ]
        ]);
    }

    /**
     * Bulk reject end contracts
     */
    public function bulkReject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'endcontract_ids' => 'required|array',
            'endcontract_ids.*' => 'exists:end_contracts,id',
            'comments' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $results = [];
        $successCount = 0;
        $errorCount = 0;

        foreach ($request->endcontract_ids as $endContractId) {
            $rejectRequest = new Request([
                'endcontract_id' => $endContractId,
                'comments' => $request->comments
            ]);

            $result = $this->workflow->rejectEndContract($rejectRequest);
            $results[] = [
                'endcontract_id' => $endContractId,
                'status' => $result->getStatusCode() === 200 ? 'success' : 'error',
                'message' => json_decode($result->getContent())->message
            ];

            if ($result->getStatusCode() === 200) {
                $successCount++;
            } else {
                $errorCount++;
            }
        }

        return response()->json([
            'status' => 200,
            'message' => "Bulk rejection completed. {$successCount} successful, {$errorCount} failed.",
            'data' => [
                'results' => $results,
                'summary' => [
                    'total' => count($request->endcontract_ids),
                    'successful' => $successCount,
                    'failed' => $errorCount
                ]
            ]
        ]);
    }
}
