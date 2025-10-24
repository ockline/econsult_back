<?php

namespace App\Http\Controllers\Exits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Repositories\Exits\ResignationWorkflowRepository;

class ResignationWorkflowController extends Controller
{
    protected $workflow;

    public function __construct(ResignationWorkflowRepository $workflow)
    {
        $this->workflow = $workflow;
    }

    /**
     * Review resignation (HR/IR level)
     */
    public function review(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'resignation_id' => 'required|exists:resignations,id',
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

        return $this->workflow->reviewResignation($request);
    }

    /**
     * Manager review and recommendation
     */
    public function managerReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'resignation_id' => 'required|exists:resignations,id',
            'comments' => 'nullable|string',
            'manager_recommendations' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->workflow->managerReview($request);
    }

    /**
     * Approve resignation
     */
    public function approve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'resignation_id' => 'required|exists:resignations,id',
            'comments' => 'nullable|string',
            'recommendation' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->workflow->approveResignation($request);
    }

    /**
     * Reject resignation
     */
    public function reject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'resignation_id' => 'required|exists:resignations,id',
            'comments' => 'required|string',
            'recommendation' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->workflow->rejectResignation($request);
    }

    /**
     * Return resignation for revision
     */
    public function return(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'resignation_id' => 'required|exists:resignations,id',
            'comments' => 'required|string',
            'recommendation' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->workflow->returnResignation($request);
    }

    /**
     * Get workflow history
     */
    public function getWorkflowHistory($resignationId)
    {
        return $this->workflow->getWorkflowHistory($resignationId);
    }
}
