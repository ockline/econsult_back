<?php

namespace App\Repositories\Exits;

use App\Models\Exits\EndContract;
use App\Models\Exits\EndContractWorkflow;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RetrenchmentRepository extends BaseRepository
{
    const MODEL = EndContract::class;

    protected $model;
    protected $workflow;

    public function __construct(EndContract $model, EndContractWorkflow $workflow)
    {
        $this->model = $model;
        $this->workflow = $workflow;
    }

    /**
     * Get all retrenchments with relationships
     */
    public function getAllRetrenchments()
    {
        try {
            $retrenchments = collect(DB::select("
                SELECT 
                    ec.*,
                    e.employee_no as employee_number,
                    dpt.name as department_name,
                    jt.name as job_title
                FROM end_contracts ec
                LEFT JOIN employees e ON ec.employee_id = e.id
                LEFT JOIN departments dpt ON e.department_id = dpt.id
                LEFT JOIN job_title jt ON e.job_title_id = jt.id
                WHERE ec.exit_type = 'retrenchment'
                ORDER BY ec.created_at DESC
            "));

            return response()->json([
                'status' => 200,
                'message' => 'Retrenchments retrieved successfully',
                'data' => $retrenchments
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve retrenchments', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve retrenchments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get retrenchment by ID with relationships
     */
    public function getRetrenchmentById($id)
    {
        try {
            $retrenchment = $this->model
                ->where('exit_type', 'retrenchment')
                ->with(['employee', 'creator', 'updater', 'workflows.attendedBy'])
                ->findOrFail($id);

            return response()->json([
                'status' => 200,
                'message' => 'Retrenchment retrieved successfully',
                'data' => $retrenchment
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve retrenchment', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 404,
                'message' => 'Retrenchment not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Create new retrenchment
     */
    public function createRetrenchment(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id ?? 1;
            $data['updated_by'] = Auth::user()->id ?? 1;
            $data['exit_type'] = 'retrenchment';

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

            // Provide safe defaults for NOT NULL columns
            $data['employee_name'] = $data['employee_name'] ?? '';
            $data['department_name'] = $data['department_name'] ?? '';
            $data['job_title'] = $data['job_title'] ?? '';
            $data['postal_address'] = $data['postal_address'] ?? '';
            $data['phone_number'] = $data['phone_number'] ?? '';
            $data['remark'] = $data['remark'] ?? '';
            $data['end_date'] = $data['end_date'] ?? Carbon::today()->toDateString();

            $retrenchment = $this->model->create($data);

            // Create initial workflow entry
            $this->createWorkflow(
                $retrenchment->id,
                'Initiated',
                'Initiated',
                'Retrenchment Initiation',
                $data['remark'] ?? null,
                null,
                'HR Review'
            );

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Retrenchment created successfully',
                'data' => $retrenchment->load(['workflows.attendedBy'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to create retrenchment', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to create retrenchment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update retrenchment
     */
    public function updateRetrenchment(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $retrenchment = $this->model
                ->where('exit_type', 'retrenchment')
                ->findOrFail($id);

            // Check if retrenchment can be updated
            if (!$retrenchment->canBeEdited()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Retrenchment cannot be updated in current status'
                ], 400);
            }

            $data = $request->all();
            $data['updated_by'] = Auth::user()->id ?? 1;

            // Handle file uploads
            if ($request->hasFile('renewal_notice_file')) {
                if ($retrenchment->renewal_notice_file) {
                    Storage::delete('public/endcontracts/renewal_notices/' . $retrenchment->renewal_notice_file);
                }
                $data['renewal_notice_file'] = $this->uploadFile($request->file('renewal_notice_file'), 'endcontracts/renewal_notices');
            }

            if ($request->hasFile('signature_file')) {
                if ($retrenchment->signature_file) {
                    Storage::delete('public/endcontracts/signatures/' . $retrenchment->signature_file);
                }
                $data['signature_file'] = $this->uploadFile($request->file('signature_file'), 'endcontracts/signatures');
            }

            if ($request->hasFile('employee_signature_file')) {
                if ($retrenchment->employee_signature_file) {
                    Storage::delete('public/endcontracts/employee_signatures/' . $retrenchment->employee_signature_file);
                }
                $data['employee_signature_file'] = $this->uploadFile($request->file('employee_signature_file'), 'endcontracts/employee_signatures');
            }

            $retrenchment->update($data);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Retrenchment updated successfully',
                'data' => $retrenchment->load(['workflows.attendedBy'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to update retrenchment', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update retrenchment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit retrenchment for review
     */
    public function submitRetrenchment(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            if ($id) {
                $retrenchment = $this->model
                    ->where('exit_type', 'retrenchment')
                    ->findOrFail($id);

                if (!$retrenchment->canBeSubmitted()) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Retrenchment cannot be submitted in current status'
                    ], 400);
                }
            } else {
                $createResponse = $this->createRetrenchment($request);
                if ($createResponse->getStatusCode() !== 200) {
                    return $createResponse;
                }
                $retrenchment = $this->model->findOrFail(json_decode($createResponse->getContent())->data->id);
            }

            $previousStage = 'Industrial Initiator';
            $nextStage = 'HR Review';
            $functionName = 'Retrenchment Submission';

            $retrenchment->update([
                'status' => 'Submitted',
                'stage' => $nextStage,
                'updated_by' => Auth::user()->id ?? 1,
            ]);

            $this->createWorkflow(
                $retrenchment->id,
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
                'message' => 'Retrenchment submitted successfully',
                'data' => $retrenchment->load(['workflows.attendedBy'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to submit retrenchment', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to submit retrenchment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete retrenchment
     */
    public function deleteRetrenchment($id)
    {
        DB::beginTransaction();

        try {
            $retrenchment = $this->model
                ->where('exit_type', 'retrenchment')
                ->findOrFail($id);

            if (!$retrenchment->canBeDeleted()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Retrenchment cannot be deleted in current status'
                ], 400);
            }

            // Delete associated files
            if ($retrenchment->renewal_notice_file) {
                Storage::delete('public/endcontracts/renewal_notices/' . $retrenchment->renewal_notice_file);
            }
            if ($retrenchment->signature_file) {
                Storage::delete('public/endcontracts/signatures/' . $retrenchment->signature_file);
            }
            if ($retrenchment->employee_signature_file) {
                Storage::delete('public/endcontracts/employee_signatures/' . $retrenchment->employee_signature_file);
            }

            $retrenchment->workflows()->delete();
            $retrenchment->delete();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Retrenchment deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to delete retrenchment', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to delete retrenchment',
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
     * Get attachments for a retrenchment
     */
    public function getAttachments($endContractId)
    {
        try {
            $attachments = DB::table('exit_attachments')
                ->where('end_contract_id', $endContractId)
                ->orderBy('created_at', 'desc')
                ->get();

            return $attachments;
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve attachments', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Get all attachments for the same employer as the given end contract (for Document Center per employer)
     */
    public function getAttachmentsByEmployer($endContractId)
    {
        try {
            $contract = DB::table('end_contracts')->where('id', $endContractId)->first();
            if (!$contract || empty(trim($contract->employer_name ?? ''))) {
                return $this->getAttachments($endContractId);
            }
            $employerName = $contract->employer_name;

            $attachments = DB::table('exit_attachments as ea')
                ->join('end_contracts as ec', 'ea.end_contract_id', '=', 'ec.id')
                ->where('ec.employer_name', $employerName)
                ->select(
                    'ea.id',
                    'ea.end_contract_id',
                    'ea.document_name',
                    'ea.document_type',
                    'ea.attachment_file',
                    'ea.file_path',
                    'ea.file_size',
                    'ea.mime_type',
                    'ea.created_by',
                    'ea.created_at',
                    'ea.updated_at',
                    'ec.employee_name',
                    'ec.exit_type'
                )
                ->orderBy('ea.created_at', 'desc')
                ->get();

            return $attachments;
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve attachments by employer', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Save attachment for a retrenchment
     */
    public function saveAttachment(Request $request, $endContractId)
    {
        try {
            $file = $request->file('attachment_file');
            $documentName = $request->input('document_name');
            $documentType = $request->input('document_type', 'retrenchment');

            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'exits/retrenchments/' . $endContractId . '/attachments/' . $fileName;

            Storage::disk('public')->put($filePath, file_get_contents($file));

            $attachmentId = DB::table('exit_attachments')->insertGetId([
                'end_contract_id' => $endContractId,
                'document_name' => $documentName,
                'document_type' => $documentType,
                'attachment_file' => $fileName,
                'file_path' => $filePath,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'created_by' => Auth::id() ?? 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Attachment saved successfully',
                'data' => [
                    'id' => $attachmentId,
                    'document_name' => $documentName,
                    'file_path' => $filePath,
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to save attachment', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to save attachment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

