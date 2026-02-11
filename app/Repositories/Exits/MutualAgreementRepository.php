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

class MutualAgreementRepository extends BaseRepository
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
     * Get all mutual agreements with relationships
     */
    public function getAllMutualAgreements()
    {
        try {
            $mutualAgreements = collect(DB::select("
                SELECT 
                    ec.*,
                    e.employee_no as employee_number,
                    dpt.name as department_name,
                    jt.name as job_title
                FROM end_contracts ec
                LEFT JOIN employees e ON ec.employee_id = e.id
                LEFT JOIN departments dpt ON e.department_id = dpt.id
                LEFT JOIN job_title jt ON e.job_title_id = jt.id
                WHERE ec.exit_type = 'mutual_agreement'
                ORDER BY ec.created_at DESC
            "));

            return response()->json([
                'status' => 200,
                'message' => 'Mutual agreements retrieved successfully',
                'data' => $mutualAgreements
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve mutual agreements', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve mutual agreements',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get mutual agreement by ID with relationships
     */
    public function getMutualAgreementById($id)
    {
        try {
            $mutualAgreement = $this->model
                ->where('exit_type', 'mutual_agreement')
                ->with(['employee', 'creator', 'updater', 'workflows.attendedBy'])
                ->findOrFail($id);

            return response()->json([
                'status' => 200,
                'message' => 'Mutual agreement retrieved successfully',
                'data' => $mutualAgreement
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve mutual agreement', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 404,
                'message' => 'Mutual agreement not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Create new mutual agreement
     */
    public function createMutualAgreement(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id ?? 1;
            $data['updated_by'] = Auth::user()->id ?? 1;
            $data['exit_type'] = 'mutual_agreement';

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

            $mutualAgreement = $this->model->create($data);

            // Create initial workflow entry
            $this->createWorkflow(
                $mutualAgreement->id,
                'Initiated',
                'Initiated',
                'Mutual Agreement Initiation',
                $data['remark'] ?? null,
                null,
                'HR Review'
            );

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Mutual agreement created successfully',
                'data' => $mutualAgreement->load(['workflows.attendedBy'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to create mutual agreement', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to create mutual agreement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update mutual agreement
     */
    public function updateMutualAgreement(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $mutualAgreement = $this->model
                ->where('exit_type', 'mutual_agreement')
                ->findOrFail($id);

            // Check if mutual agreement can be updated
            if (!$mutualAgreement->canBeEdited()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Mutual agreement cannot be updated in current status'
                ], 400);
            }

            $data = $request->all();
            $data['updated_by'] = Auth::user()->id ?? 1;

            // Handle file uploads
            if ($request->hasFile('renewal_notice_file')) {
                if ($mutualAgreement->renewal_notice_file) {
                    Storage::delete('public/endcontracts/renewal_notices/' . $mutualAgreement->renewal_notice_file);
                }
                $data['renewal_notice_file'] = $this->uploadFile($request->file('renewal_notice_file'), 'endcontracts/renewal_notices');
            }

            if ($request->hasFile('signature_file')) {
                if ($mutualAgreement->signature_file) {
                    Storage::delete('public/endcontracts/signatures/' . $mutualAgreement->signature_file);
                }
                $data['signature_file'] = $this->uploadFile($request->file('signature_file'), 'endcontracts/signatures');
            }

            if ($request->hasFile('employee_signature_file')) {
                if ($mutualAgreement->employee_signature_file) {
                    Storage::delete('public/endcontracts/employee_signatures/' . $mutualAgreement->employee_signature_file);
                }
                $data['employee_signature_file'] = $this->uploadFile($request->file('employee_signature_file'), 'endcontracts/employee_signatures');
            }

            $mutualAgreement->update($data);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Mutual agreement updated successfully',
                'data' => $mutualAgreement->load(['workflows.attendedBy'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to update mutual agreement', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update mutual agreement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit mutual agreement for review
     */
    public function submitMutualAgreement(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            if ($id) {
                $mutualAgreement = $this->model
                    ->where('exit_type', 'mutual_agreement')
                    ->findOrFail($id);

                if (!$mutualAgreement->canBeSubmitted()) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Mutual agreement cannot be submitted in current status'
                    ], 400);
                }
            } else {
                $createResponse = $this->createMutualAgreement($request);
                if ($createResponse->getStatusCode() !== 200) {
                    return $createResponse;
                }
                $mutualAgreement = $this->model->findOrFail(json_decode($createResponse->getContent())->data->id);
            }

            $previousStage = 'Industrial Initiator';
            $nextStage = 'HR Review';
            $functionName = 'Mutual Agreement Submission';

            $mutualAgreement->update([
                'status' => 'Submitted',
                'stage' => $nextStage,
                'updated_by' => Auth::user()->id ?? 1,
            ]);

            $this->createWorkflow(
                $mutualAgreement->id,
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
                'message' => 'Mutual agreement submitted successfully',
                'data' => $mutualAgreement->load(['workflows.attendedBy'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to submit mutual agreement', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to submit mutual agreement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete mutual agreement
     */
    public function deleteMutualAgreement($id)
    {
        DB::beginTransaction();

        try {
            $mutualAgreement = $this->model
                ->where('exit_type', 'mutual_agreement')
                ->findOrFail($id);

            if (!$mutualAgreement->canBeDeleted()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Mutual agreement cannot be deleted in current status'
                ], 400);
            }

            // Delete associated files
            if ($mutualAgreement->renewal_notice_file) {
                Storage::delete('public/endcontracts/renewal_notices/' . $mutualAgreement->renewal_notice_file);
            }
            if ($mutualAgreement->signature_file) {
                Storage::delete('public/endcontracts/signatures/' . $mutualAgreement->signature_file);
            }
            if ($mutualAgreement->employee_signature_file) {
                Storage::delete('public/endcontracts/employee_signatures/' . $mutualAgreement->employee_signature_file);
            }

            $mutualAgreement->workflows()->delete();
            $mutualAgreement->delete();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Mutual agreement deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to delete mutual agreement', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to delete mutual agreement',
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
     * Get attachments for a mutual agreement
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
     * Save attachment for a mutual agreement
     */
    public function saveAttachment(Request $request, $endContractId)
    {
        try {
            $file = $request->file('attachment_file');
            $documentName = $request->input('document_name');
            $documentType = $request->input('document_type', 'mutual_agreement');

            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'exits/mutual_agreements/' . $endContractId . '/attachments/' . $fileName;

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

