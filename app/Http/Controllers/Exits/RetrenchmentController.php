<?php

namespace App\Http\Controllers\Exits;

use App\Http\Controllers\Controller;
use App\Repositories\Exits\RetrenchmentRepository;
use App\Services\EndContractPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RetrenchmentController extends Controller
{
    protected $retrenchmentRepository;
    protected $pdfService;

    public function __construct(RetrenchmentRepository $retrenchmentRepository, EndContractPdfService $pdfService)
    {
        $this->retrenchmentRepository = $retrenchmentRepository;
        $this->pdfService = $pdfService;
    }

    /**
     * Display a listing of retrenchments
     */
    public function showAllRetrenchments()
    {
        return $this->retrenchmentRepository->getAllRetrenchments();
    }

    /**
     * Store a newly created retrenchment
     */
    public function createRetrenchment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Add exit_type for retrenchment
        $request->merge([
            'exit_type' => 'retrenchment'
        ]);

        return $this->retrenchmentRepository->createRetrenchment($request);
    }

    /**
     * Display the specified retrenchment
     */
    public function showRetrenchment($id)
    {
        return $this->retrenchmentRepository->getRetrenchmentById($id);
    }

    /**
     * Update the specified retrenchment
     */
    public function updateRetrenchment(Request $request, $id)
    {
        return $this->retrenchmentRepository->updateRetrenchment($request, $id);
    }

    /**
     * Submit the specified retrenchment for review
     */
    public function submitRetrenchment(Request $request, $id = null)
    {
        return $this->retrenchmentRepository->submitRetrenchment($request, $id);
    }

    /**
     * Delete the specified retrenchment
     */
    public function deleteRetrenchment($id)
    {
        return $this->retrenchmentRepository->deleteRetrenchment($id);
    }

    /**
     * Generate PDF for retrenchment
     */
    public function generateRetrenchmentPdf($id)
    {
        try {
            $retrenchment = $this->retrenchmentRepository->getRetrenchmentById($id);
            
            if ($retrenchment->getStatusCode() !== 200) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Retrenchment not found'
                ], 404);
            }

            $data = json_decode($retrenchment->getContent(), true);
            $contractData = $data['data'] ?? null;

            if (!$contractData) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Retrenchment data not found'
                ], 404);
            }

            // Generate PDF using the PDF service (Retrenchment format in Swahili)
            $pdf = $this->pdfService->generateRetrenchmentPdf($contractData);

            return response($pdf, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="retrenchment_' . $contractData['employee_name'] . '_' . date('Y-m-d') . '.pdf"');
        } catch (\Exception $e) {
            \Log::error('Error generating retrenchment PDF', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to generate PDF',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get attachments for retrenchment (only documents attached to this contract/employee)
     */
    public function getAttachments(Request $request, $id)
    {
        try {
            $attachments = $this->retrenchmentRepository->getAttachments($id);
            return response()->json([
                'status' => 200,
                'message' => 'Attachments retrieved successfully',
                'data' => $attachments
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching attachments', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve attachments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save attachment for retrenchment
     */
    public function saveAttachment(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'attachment_file' => 'required|file|mimes:pdf|max:10240', // 10MB max
                'document_name' => 'required|string|max:255',
                'document_type' => 'nullable|string|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $result = $this->retrenchmentRepository->saveAttachment($request, $id);
            return $result;
        } catch (\Exception $e) {
            \Log::error('Error saving attachment', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to save attachment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get attachment file for preview/download
     */
    public function getAttachmentFile($endContractId, $attachmentId)
    {
        try {
            $attachment = DB::table('exit_attachments')
                ->where('id', $attachmentId)
                ->where('end_contract_id', $endContractId)
                ->first();

            if (!$attachment) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Attachment not found'
                ], 404);
            }

            $filePath = storage_path('app/public/' . $attachment->file_path);

            if (!file_exists($filePath)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'File not found'
                ], 404);
            }

            // Read file and encode to base64
            $fileContent = file_get_contents($filePath);
            $base64Content = base64_encode($fileContent);
            $mimeType = $attachment->mime_type ?? 'application/pdf';

            return response()->json([
                'status' => 200,
                'message' => 'Attachment retrieved successfully',
                'data' => [
                    'file_content' => $base64Content,
                    'mime_type' => $mimeType,
                    'file_name' => $attachment->attachment_file,
                    'document_name' => $attachment->document_name
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error retrieving attachment file', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve attachment file',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

