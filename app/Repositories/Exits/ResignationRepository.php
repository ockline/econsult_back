<?php

namespace App\Repositories\Exits;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BaseRepository;
use App\Models\Exits\Resignation;
use App\Models\Exits\ResignationAcceptance;
use App\Models\Exits\ResignationWorkflow;
use App\Models\Exits\ResignationAttachment;

class ResignationRepository extends BaseRepository
{
    const MODEL = Resignation::class;

    protected $resignation;
    protected $acceptance;
    protected $workflow;
    protected $attachment;

    public function __construct(
        Resignation $resignation,
        ResignationAcceptance $acceptance,
        ResignationWorkflow $workflow,
        ResignationAttachment $attachment
    ) {
        $this->resignation = $resignation;
        $this->acceptance = $acceptance;
        $this->workflow = $workflow;
        $this->attachment = $attachment;
    }

    /**
     * Create a new resignation
     */
    public function createResignation($request)
    {
        DB::beginTransaction();

        try {
            $input = $request->all();

            $resignation = Resignation::create([
                'employee_id' => $input['employee_id'],
                'employee_name' => $input['employee_name'],
                'department_name' => $input['department_name'],
                'job_title' => $input['job_title'],
                'postal_address' => $input['postal_address'],
                'phone_number' => $input['phone_number'],
                'remark' => $input['remark'],
                'resignation_date' => $input['resignation_date'],
                'status' => 'Draft',
                'stage' => 'Initiated',
                'created_by' => Auth::user()->id,
            ]);

            // Save resignation documents
            if ($request->hasFile('resignation_notice_file')) {
                $resignation->resignation_notice_file = $this->saveFile($request->file('resignation_notice_file'), $resignation->id, 'resignation_notice');
                $resignation->save();
            }

            if ($request->hasFile('resignation_form_file')) {
                $resignation->resignation_form_file = $this->saveFile($request->file('resignation_form_file'), $resignation->id, 'resignation_form');
                $resignation->save();
            }

            if ($request->hasFile('resignation_letter_file')) {
                $resignation->resignation_letter_file = $this->saveFile($request->file('resignation_letter_file'), $resignation->id, 'resignation_letter');
                $resignation->save();
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Resignation Saved Successfully',
                'data' => $resignation
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create resignation', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'
            ], 500);
        }
    }

    /**
     * Update resignation details
     */
    public function updateResignation($request, $id)
    {
        DB::beginTransaction();

        try {
            $resignation = Resignation::findOrFail($id);
            $input = $request->all();

            $resignation->update([
                'employee_name' => $input['employee_name'],
                'department_name' => $input['department_name'],
                'job_title' => $input['job_title'],
                'postal_address' => $input['postal_address'],
                'phone_number' => $input['phone_number'],
                'remark' => $input['remark'],
                'resignation_date' => $input['resignation_date'],
                'updated_by' => Auth::user()->id,
            ]);

            // Update files if provided
            if ($request->hasFile('resignation_notice_file')) {
                $resignation->resignation_notice_file = $this->saveFile($request->file('resignation_notice_file'), $resignation->id, 'resignation_notice');
            }

            if ($request->hasFile('resignation_form_file')) {
                $resignation->resignation_form_file = $this->saveFile($request->file('resignation_form_file'), $resignation->id, 'resignation_form');
            }

            if ($request->hasFile('resignation_letter_file')) {
                $resignation->resignation_letter_file = $this->saveFile($request->file('resignation_letter_file'), $resignation->id, 'resignation_letter');
            }

            $resignation->save();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Resignation Updated Successfully',
                'data' => $resignation
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update resignation', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'
            ], 500);
        }
    }

    /**
     * Submit resignation for review
     */
    public function submitResignation($request, $id)
    {
        DB::beginTransaction();

        try {
            $resignation = Resignation::findOrFail($id);

            $resignation->update([
                'status' => 'Submitted',
                'stage' => 'HR Review',
                'updated_by' => Auth::user()->id,
            ]);

            // Create workflow entry
            $this->createWorkflow($resignation->id, 'Submitted', 'HR Review', 'Resignation Submitted');

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Resignation Submitted Successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to submit resignation', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'
            ], 500);
        }
    }

    /**
     * Create resignation acceptance
     */
    public function createAcceptance($request, $resignationId)
    {
        DB::beginTransaction();

        try {
            $input = $request->all();

            $acceptance = ResignationAcceptance::create([
                'resignation_id' => $resignationId,
                'acceptance_date' => $input['acceptance_date'],
                'employee_name' => $input['employee_name'],
                'job_title' => $input['job_title'],
                'postal_address' => $input['postal_address'],
                'letter_dated' => $input['letter_dated'],
                'service_of' => $input['service_of'],
                'effective_from' => $input['effective_from'],
                'started_work' => $input['started_work'],
                'hr_name' => $input['hr_name'],
                'hr_designation' => $input['hr_designation'],
                'created_by' => Auth::user()->id,
            ]);

            // Save signature files
            if ($request->hasFile('hr_signature_file')) {
                $acceptance->hr_signature_file = $this->saveFile($request->file('hr_signature_file'), $resignationId, 'hr_signature');
            }

            if ($request->hasFile('employee_signature_file')) {
                $acceptance->employee_signature_file = $this->saveFile($request->file('employee_signature_file'), $resignationId, 'employee_signature');
            }

            $acceptance->save();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Resignation Acceptance Created Successfully',
                'data' => $acceptance
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create resignation acceptance', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'
            ], 500);
        }
    }

    /**
     * Get all resignations
     */
    public function getAllResignations()
    {
        try {
            $resignations = Resignation::with(['employee', 'acceptance', 'workflows', 'creator'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 200,
                'data' => $resignations
            ], 200);

        } catch (\Exception $e) {
            Log::error('Failed to get resignations', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'
            ], 500);
        }
    }

    /**
     * Get resignation by ID
     */
    public function getResignationById($id)
    {
        try {
            $resignation = Resignation::with(['employee', 'acceptance', 'workflows.attendedBy', 'attachments', 'creator', 'updater'])
                ->findOrFail($id);

            return response()->json([
                'status' => 200,
                'data' => $resignation
            ], 200);

        } catch (\Exception $e) {
            Log::error('Failed to get resignation', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 404,
                'message' => 'Resignation not found'
            ], 404);
        }
    }

    /**
     * Create workflow entry
     */
    private function createWorkflow($resignationId, $status, $stage, $functionName, $comments = null)
    {
        $workflow = ResignationWorkflow::create([
            'resignation_id' => $resignationId,
            'comments' => $comments,
            'received_date' => now(),
            'attended_by' => Auth::user()->id,
            'attended_date' => now(),
            'status' => $status,
            'stage' => $stage,
            'function_name' => $functionName,
        ]);

        return $workflow;
    }

    /**
     * Save uploaded file
     */
    private function saveFile($file, $resignationId, $type)
    {
        $fileName = time() . '_' . $type . '_' . $file->getClientOriginalName();
        $file->move(public_path("resignations/{$resignationId}"), $fileName);
        return $fileName;
    }

    /**
     * Get document ID based on type
     */
    private function getDocumentId($documentType)
    {
        $documentIds = [
            'resignation_notice' => 1,
            'resignation_form' => 2,
            'resignation_letter' => 3,
            'certificate_of_service' => 4,
            'hr_signature' => 5,
            'employee_signature' => 6,
        ];

        return $documentIds[$documentType] ?? null;
    }
}
