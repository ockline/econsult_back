<?php

namespace App\Repositories\Exits;

use App\Models\Exits\EndContract;
use App\Models\Exits\EndContractWorkflow;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EndContractWorkflowRepository extends BaseRepository
{
    public function __construct(EndContractWorkflow $model)
    {
        parent::__construct($model);
    }

    /**
     * Review end contract (HR/IR level)
     */
    public function reviewEndContract(Request $request)
    {
        DB::beginTransaction();

        try {
            $endContract = EndContract::findOrFail($request->endcontract_id);

            // Determine the next stage based on current stage
            $currentStage = $endContract->stage;
            $nextStage = 'Manager Review'; // Default next stage
            $functionName = 'End Contract Review';
            $previousStage = $currentStage;

            // Define stage progression
            if ($currentStage === 'Initiated') {
                $nextStage = 'HR Review';
                $functionName = 'End Contract Initiation Review';
                $previousStage = 'Industrial Initiator';
            } elseif ($currentStage === 'HR Review') {
                $nextStage = 'Manager Review';
                $functionName = 'HR Review Assessment';
                $previousStage = 'Industrial Reviewer';
            } elseif ($currentStage === 'Manager Review') {
                $nextStage = 'Final Approval';
                $functionName = 'Manager Review Assessment';
                $previousStage = 'Manager Review';
            }

            // Update end contract with recommendations
            $endContract->update([
                'hr_recommendations' => $request->hr_recommendations ?? $request->comments,
                'status' => 'Under Review',
                'stage' => $nextStage,
                'updated_by' => Auth::user()->id ?? 1,
            ]);

            // Create workflow entry
            $workflow = EndContractWorkflow::create([
                'end_contract_id' => $request->endcontract_id,
                'comments' => $request->comments,
                'recommendation' => $request->hr_recommendations ?? $request->comments,
                'received_date' => now(),
                'attended_by' => Auth::user()->id ?? 1,
                'attended_date' => now(),
                'status' => 'Reviewed',
                'stage' => $nextStage,
                'function_name' => $functionName,
                'previous_stage' => $previousStage,
                'next_stage' => $nextStage,
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'End contract reviewed successfully',
                'data' => $endContract->load(['workflows.attendedBy'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to review end contract', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to review end contract',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Manager review and recommendation
     */
    public function managerReview(Request $request)
    {
        DB::beginTransaction();

        try {
            $endContract = EndContract::findOrFail($request->endcontract_id);

            // Update end contract with manager recommendations
            $endContract->update([
                'manager_recommendations' => $request->manager_recommendations ?? $request->comments,
                'status' => 'Under Review',
                'stage' => 'Final Approval',
                'updated_by' => Auth::user()->id ?? 1,
            ]);

            // Create workflow entry
            $workflow = EndContractWorkflow::create([
                'end_contract_id' => $request->endcontract_id,
                'comments' => $request->comments,
                'recommendation' => $request->manager_recommendations ?? $request->comments,
                'received_date' => now(),
                'attended_by' => Auth::user()->id ?? 1,
                'attended_date' => now(),
                'status' => 'Reviewed',
                'stage' => 'Final Approval',
                'function_name' => 'Manager Review',
                'previous_stage' => 'Manager Review',
                'next_stage' => 'Final Approval',
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'End contract reviewed by manager successfully',
                'data' => $endContract->load(['workflows.attendedBy'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to review end contract by manager', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to review end contract',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve end contract
     */
    public function approveEndContract(Request $request)
    {
        DB::beginTransaction();

        try {
            $endContract = EndContract::findOrFail($request->endcontract_id);

            // Determine the function name and previous stage based on current stage
            $currentStage = $endContract->stage;
            $functionName = 'Final Approval';
            $previousStage = $currentStage;

            if ($currentStage === 'Final Approval') {
                $functionName = 'Final Approval';
                $previousStage = 'Final Approval';
            } elseif ($currentStage === 'Manager Review') {
                $functionName = 'Manager Approval';
                $previousStage = 'Manager Review';
            } elseif ($currentStage === 'HR Review') {
                $functionName = 'HR Approval';
                $previousStage = 'HR Review';
            }

            // Update end contract status
            $endContract->update([
                'status' => 'Approved',
                'stage' => 'Completed',
                'updated_by' => Auth::user()->id ?? 1,
            ]);

            // Create workflow entry
            $workflow = EndContractWorkflow::create([
                'end_contract_id' => $request->endcontract_id,
                'comments' => $request->comments,
                'received_date' => now(),
                'attended_by' => Auth::user()->id ?? 1,
                'attended_date' => now(),
                'status' => 'Approved',
                'stage' => 'Completed',
                'function_name' => $functionName,
                'previous_stage' => $previousStage,
                'next_stage' => 'Completed',
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'End contract approved successfully',
                'data' => $endContract->load(['workflows.attendedBy'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to approve end contract', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to approve end contract',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject end contract
     */
    public function rejectEndContract(Request $request)
    {
        DB::beginTransaction();

        try {
            $endContract = EndContract::findOrFail($request->endcontract_id);

            // Determine the function name and previous stage based on current stage
            $currentStage = $endContract->stage;
            $functionName = 'End Contract Rejection';
            $previousStage = $currentStage;

            if ($currentStage === 'Final Approval') {
                $functionName = 'Final Rejection';
                $previousStage = 'Final Approval';
            } elseif ($currentStage === 'Manager Review') {
                $functionName = 'Manager Rejection';
                $previousStage = 'Manager Review';
            } elseif ($currentStage === 'HR Review') {
                $functionName = 'HR Rejection';
                $previousStage = 'HR Review';
            }

            // Update end contract status
            $endContract->update([
                'status' => 'Rejected',
                'stage' => 'Completed',
                'updated_by' => Auth::user()->id ?? 1,
            ]);

            // Create workflow entry
            $workflow = EndContractWorkflow::create([
                'end_contract_id' => $request->endcontract_id,
                'comments' => $request->comments,
                'received_date' => now(),
                'attended_by' => Auth::user()->id ?? 1,
                'attended_date' => now(),
                'status' => 'Rejected',
                'stage' => 'Completed',
                'function_name' => $functionName,
                'previous_stage' => $previousStage,
                'next_stage' => 'Completed',
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'End contract rejected successfully',
                'data' => $endContract->load(['workflows.attendedBy'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to reject end contract', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to reject end contract',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Return end contract for revision
     */
    public function returnEndContract(Request $request)
    {
        DB::beginTransaction();

        try {
            $endContract = EndContract::findOrFail($request->endcontract_id);

            // Determine the function name and previous stage based on current stage
            $currentStage = $endContract->stage;
            $functionName = 'End Contract Return';
            $previousStage = $currentStage;

            if ($currentStage === 'Final Approval') {
                $functionName = 'Final Return for Revision';
                $previousStage = 'Final Approval';
            } elseif ($currentStage === 'Manager Review') {
                $functionName = 'Manager Return for Revision';
                $previousStage = 'Manager Review';
            } elseif ($currentStage === 'HR Review') {
                $functionName = 'HR Return for Revision';
                $previousStage = 'HR Review';
            }

            // Update end contract status - return to draft for revision
            $endContract->update([
                'status' => 'Draft',
                'stage' => 'Initiated',
                'updated_by' => Auth::user()->id ?? 1,
            ]);

            // Create workflow entry
            $workflow = EndContractWorkflow::create([
                'end_contract_id' => $request->endcontract_id,
                'comments' => $request->comments,
                'received_date' => now(),
                'attended_by' => Auth::user()->id ?? 1,
                'attended_date' => now(),
                'status' => 'Returned',
                'stage' => 'Initiated',
                'function_name' => $functionName,
                'previous_stage' => $previousStage,
                'next_stage' => 'Initiated',
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'End contract returned for revision successfully',
                'data' => $endContract->load(['workflows.attendedBy'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to return end contract', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to return end contract',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get workflow history for end contract
     */
    public function getWorkflowHistory($endContractId)
    {
        try {
            $workflows = $this->model
                ->with(['attendedBy'])
                ->byEndContract($endContractId)
                ->orderByDate('asc')
                ->get();

            return response()->json([
                'status' => 200,
                'message' => 'Workflow history retrieved successfully',
                'data' => $workflows
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve workflow history', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve workflow history',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get pending workflows for user
     */
    public function getPendingWorkflows($userId)
    {
        try {
            $endContracts = EndContract::with(['workflows.attendedBy'])
                ->whereIn('status', ['Submitted', 'Under Review'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 200,
                'message' => 'Pending workflows retrieved successfully',
                'data' => $endContracts
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve pending workflows', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve pending workflows',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
