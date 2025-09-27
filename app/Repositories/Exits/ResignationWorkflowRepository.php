<?php

namespace App\Repositories\Exits;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BaseRepository;
use App\Models\Exits\Resignation;
use App\Models\Exits\ResignationWorkflow;

class ResignationWorkflowRepository extends BaseRepository
{
    const MODEL = ResignationWorkflow::class;

    protected $resignation;
    protected $workflow;

    public function __construct(
        Resignation $resignation,
        ResignationWorkflow $workflow
    ) {
        $this->resignation = $resignation;
        $this->workflow = $workflow;
    }

    /**
     * Review resignation (HR/IR level)
     */
    public function reviewResignation($request)
    {
        DB::beginTransaction();

        try {
            $resignation = Resignation::findOrFail($request->resignation_id);

            // Update resignation with recommendations
            $resignation->update([
                'hr_recommendations' => $request->hr_recommendations,
                'status' => 'Under Review',
                'stage' => 'Manager Review',
                'updated_by' => Auth::user()->id,
            ]);

            // Create workflow entry
            $workflow = ResignationWorkflow::create([
                'resignation_id' => $request->resignation_id,
                'comments' => $request->comments,
                'recommendation' => $request->hr_recommendations,
                'received_date' => now(),
                'attended_by' => Auth::user()->id,
                'attended_date' => now(),
                'status' => 'Reviewed',
                'stage' => 'Manager Review',
                'function_name' => 'HR Review',
                'previous_stage' => 'HR Review',
                'next_stage' => 'Manager Review',
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Resignation reviewed successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to review resignation', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'
            ], 500);
        }
    }

    /**
     * Manager review and recommendation
     */
    public function managerReview($request)
    {
        DB::beginTransaction();

        try {
            $resignation = Resignation::findOrFail($request->resignation_id);

            // Update resignation with manager recommendations
            $resignation->update([
                'manager_recommendations' => $request->manager_recommendations,
                'status' => 'Under Review',
                'stage' => 'Final Approval',
                'updated_by' => Auth::user()->id,
            ]);

            // Create workflow entry
            $workflow = ResignationWorkflow::create([
                'resignation_id' => $request->resignation_id,
                'comments' => $request->comments,
                'recommendation' => $request->manager_recommendations,
                'received_date' => now(),
                'attended_by' => Auth::user()->id,
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
                'message' => 'Manager review completed successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to complete manager review', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'
            ], 500);
        }
    }

    /**
     * Approve resignation
     */
    public function approveResignation($request)
    {
        DB::beginTransaction();

        try {
            $resignation = Resignation::findOrFail($request->resignation_id);

            // Update resignation status
            $resignation->update([
                'status' => 'Approved',
                'stage' => 'Completed',
                'updated_by' => Auth::user()->id,
            ]);

            // Create workflow entry
            $workflow = ResignationWorkflow::create([
                'resignation_id' => $request->resignation_id,
                'comments' => $request->comments,
                'recommendation' => $request->recommendation,
                'received_date' => now(),
                'attended_by' => Auth::user()->id,
                'attended_date' => now(),
                'status' => 'Approved',
                'stage' => 'Completed',
                'function_name' => 'Final Approval',
                'previous_stage' => 'Final Approval',
                'next_stage' => null,
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Resignation approval successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to approve resignation', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'
            ], 500);
        }
    }

    /**
     * Reject resignation
     */
    public function rejectResignation($request)
    {
        DB::beginTransaction();

        try {
            $resignation = Resignation::findOrFail($request->resignation_id);

            // Update resignation status
            $resignation->update([
                'status' => 'Rejected',
                'stage' => 'Completed',
                'updated_by' => Auth::user()->id,
            ]);

            // Create workflow entry
            $workflow = ResignationWorkflow::create([
                'resignation_id' => $request->resignation_id,
                'comments' => $request->comments,
                'recommendation' => $request->recommendation,
                'received_date' => now(),
                'attended_by' => Auth::user()->id,
                'attended_date' => now(),
                'status' => 'Rejected',
                'stage' => 'Completed',
                'function_name' => 'Resignation Rejection',
                'previous_stage' => $resignation->stage,
                'next_stage' => null,
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Resignation rejected successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to reject resignation', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'
            ], 500);
        }
    }

    /**
     * Return resignation for revision
     */
    public function returnResignation($request)
    {
        DB::beginTransaction();

        try {
            $resignation = Resignation::findOrFail($request->resignation_id);

            // Update resignation status
            $resignation->update([
                'status' => 'Draft',
                'stage' => 'Initiated',
                'updated_by' => Auth::user()->id,
            ]);

            // Create workflow entry
            $workflow = ResignationWorkflow::create([
                'resignation_id' => $request->resignation_id,
                'comments' => $request->comments,
                'recommendation' => $request->recommendation,
                'received_date' => now(),
                'attended_by' => Auth::user()->id,
                'attended_date' => now(),
                'status' => 'Returned',
                'stage' => 'Initiated',
                'function_name' => 'Resignation Returned',
                'previous_stage' => $resignation->stage,
                'next_stage' => 'Initiated',
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Resignation returned for revision successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to return resignation', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'
            ], 500);
        }
    }

    /**
     * Get workflow history for a resignation
     */
    public function getWorkflowHistory($resignationId)
    {
        try {
            $workflows = ResignationWorkflow::with(['attendedBy'])
                ->where('resignation_id', $resignationId)
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json([
                'status' => 200,
                'data' => $workflows
            ], 200);

        } catch (\Exception $e) {
            Log::error('Failed to get workflow history', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'
            ], 500);
        }
    }
}
