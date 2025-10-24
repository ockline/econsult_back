<?php

namespace App\Repositories\Exits;

use App\Models\Exits\EndContract;
use App\Models\Exits\EndContractWorkflow;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class EndContractRepository extends BaseRepository
{
    public function __construct(EndContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all end contracts with relationships
     */
    public function getAllEndContracts()
    {
        try {
            $endContracts = $this->model
                ->with(['employee', 'creator', 'updater', 'workflows.attendedBy'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 200,
                'message' => 'End contracts retrieved successfully',
                'data' => $endContracts
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve end contracts', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve end contracts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get end contract by ID with relationships
     */
    public function getEndContractById($id)
    {
        try {
            $endContract = $this->model
                ->with(['employee', 'creator', 'updater', 'workflows.attendedBy'])
                ->findOrFail($id);

            return response()->json([
                'status' => 200,
                'message' => 'End contract retrieved successfully',
                'data' => $endContract
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve end contract', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 404,
                'message' => 'End contract not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Create new end contract
     */
    public function createEndContract(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id ?? 1;
            $data['updated_by'] = Auth::user()->id ?? 1;

            // Handle file uploads
            if ($request->hasFile('renewal_notice_file')) {
                $data['renewal_notice_file'] = $this->uploadFile($request->file('renewal_notice_file'), 'endcontracts/renewal_notices');
            }

            if ($request->hasFile('signature_file')) {
                $data['signature_file'] = $this->uploadFile($request->file('signature_file'), 'endcontracts/signatures');
            }

            if ($request->hasFile('employee_signature_file')) {
                $data['employee_signature_file'] = $this->uploadFile($request->file('employee_signature_file'), 'endcontracts/employee_signatures');
            }

            $endContract = $this->model->create($data);

            // Create initial workflow entry
            $this->createWorkflow(
                $endContract->id,
                'Initiated',
                'Initiated',
                'End Contract Initiation',
                $data['remark'] ?? null,
                null,
                'HR Review'
            );

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'End contract created successfully',
                'data' => $endContract->load(['workflows.attendedBy'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to create end contract', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to create end contract',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update end contract
     */
    public function updateEndContract(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $endContract = $this->model->findOrFail($id);

            // Check if end contract can be updated
            if (!$endContract->canBeEdited()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'End contract cannot be updated in current status'
                ], 400);
            }

            $data = $request->all();
            $data['updated_by'] = Auth::user()->id ?? 1;

            // Handle file uploads
            if ($request->hasFile('renewal_notice_file')) {
                // Delete old file if exists
                if ($endContract->renewal_notice_file) {
                    Storage::delete('public/endcontracts/renewal_notices/' . $endContract->renewal_notice_file);
                }
                $data['renewal_notice_file'] = $this->uploadFile($request->file('renewal_notice_file'), 'endcontracts/renewal_notices');
            }

            if ($request->hasFile('signature_file')) {
                // Delete old file if exists
                if ($endContract->signature_file) {
                    Storage::delete('public/endcontracts/signatures/' . $endContract->signature_file);
                }
                $data['signature_file'] = $this->uploadFile($request->file('signature_file'), 'endcontracts/signatures');
            }

            if ($request->hasFile('employee_signature_file')) {
                // Delete old file if exists
                if ($endContract->employee_signature_file) {
                    Storage::delete('public/endcontracts/employee_signatures/' . $endContract->employee_signature_file);
                }
                $data['employee_signature_file'] = $this->uploadFile($request->file('employee_signature_file'), 'endcontracts/employee_signatures');
            }

            $endContract->update($data);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'End contract updated successfully',
                'data' => $endContract->load(['workflows.attendedBy'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to update end contract', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update end contract',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit end contract for review
     */
    public function submitEndContract(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            if ($id) {
                // Re-submitting existing end contract
                $endContract = $this->model->findOrFail($id);

                if (!$endContract->canBeSubmitted()) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'End contract cannot be submitted in current status'
                    ], 400);
                }
            } else {
                // Creating and submitting new end contract
                $createResponse = $this->createEndContract($request);
                if ($createResponse->getStatusCode() !== 200) {
                    return $createResponse;
                }
                $endContract = $this->model->findOrFail(json_decode($createResponse->getContent())->data->id);
            }

            // Update status and stage
            $previousStage = 'Industrial Initiator';
            $nextStage = 'HR Review';
            $functionName = 'End Contract Submission';

            $endContract->update([
                'status' => 'Submitted',
                'stage' => $nextStage,
                'updated_by' => Auth::user()->id ?? 1,
            ]);

            // Create workflow entry for submission
            $this->createWorkflow(
                $endContract->id,
                'Submitted',
                $nextStage,
                $functionName,
                null,
                $previousStage,
                $nextStage
            );

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'End contract submitted successfully',
                'data' => $endContract->load(['workflows.attendedBy'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to submit end contract', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to submit end contract',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete end contract
     */
    public function deleteEndContract($id)
    {
        DB::beginTransaction();

        try {
            $endContract = $this->model->findOrFail($id);

            // Check if end contract can be deleted
            if (!$endContract->canBeDeleted()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'End contract cannot be deleted in current status'
                ], 400);
            }

            // Delete associated files
            if ($endContract->renewal_notice_file) {
                Storage::delete('public/endcontracts/renewal_notices/' . $endContract->renewal_notice_file);
            }
            if ($endContract->signature_file) {
                Storage::delete('public/endcontracts/signatures/' . $endContract->signature_file);
            }
            if ($endContract->employee_signature_file) {
                Storage::delete('public/endcontracts/employee_signatures/' . $endContract->employee_signature_file);
            }

            // Delete workflows
            $endContract->workflows()->delete();

            // Delete end contract
            $endContract->delete();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'End contract deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to delete end contract', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to delete end contract',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create workflow entry
     */
    private function createWorkflow($endContractId, $status, $stage, $functionName, $comments = null, $previousStage = null, $nextStage = null)
    {
        $workflow = EndContractWorkflow::create([
            'end_contract_id' => $endContractId,
            'comments' => $comments,
            'received_date' => now(),
            'attended_by' => Auth::user()->id ?? 1,
            'attended_date' => now(),
            'status' => $status,
            'stage' => $stage,
            'function_name' => $functionName,
            'previous_stage' => $previousStage,
            'next_stage' => $nextStage,
        ]);

        return $workflow;
    }

    /**
     * Upload file helper
     */
    private function uploadFile($file, $directory)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/' . $directory, $fileName);
        return $fileName;
    }

    /**
     * Get end contracts by status
     */
    public function getEndContractsByStatus($status)
    {
        try {
            $endContracts = $this->model
                ->with(['employee', 'workflows.attendedBy'])
                ->byStatus($status)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 200,
                'message' => 'End contracts retrieved successfully',
                'data' => $endContracts
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve end contracts by status', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve end contracts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get end contracts by employee
     */
    public function getEndContractsByEmployee($employeeId)
    {
        try {
            $endContracts = $this->model
                ->with(['employee', 'workflows.attendedBy'])
                ->byEmployee($employeeId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 200,
                'message' => 'End contracts retrieved successfully',
                'data' => $endContracts
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve end contracts by employee', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve end contracts',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
