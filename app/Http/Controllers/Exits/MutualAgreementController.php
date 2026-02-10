<?php

namespace App\Http\Controllers\Exits;

use App\Http\Controllers\Controller;
use App\Repositories\Exits\MutualAgreementRepository;
use App\Services\EndContractPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MutualAgreementController extends Controller
{
    protected $mutualAgreementRepository;
    protected $pdfService;

    public function __construct(MutualAgreementRepository $mutualAgreementRepository, EndContractPdfService $pdfService)
    {
        $this->mutualAgreementRepository = $mutualAgreementRepository;
        $this->pdfService = $pdfService;
    }

    /**
     * Display a listing of mutual agreements
     */
    public function showAllMutualAgreements()
    {
        return $this->mutualAgreementRepository->getAllMutualAgreements();
    }

    /**
     * Store a newly created mutual agreement
     */
    public function createMutualAgreement(Request $request)
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

        // Add exit_type for mutual agreement
        $request->merge([
            'exit_type' => 'mutual_agreement'
        ]);

        return $this->mutualAgreementRepository->createMutualAgreement($request);
    }

    /**
     * Display the specified mutual agreement
     */
    public function showMutualAgreement($id)
    {
        return $this->mutualAgreementRepository->getMutualAgreementById($id);
    }

    /**
     * Update the specified mutual agreement
     */
    public function updateMutualAgreement(Request $request, $id)
    {
        return $this->mutualAgreementRepository->updateMutualAgreement($request, $id);
    }

    /**
     * Submit the specified mutual agreement for review
     */
    public function submitMutualAgreement(Request $request, $id = null)
    {
        return $this->mutualAgreementRepository->submitMutualAgreement($request, $id);
    }

    /**
     * Delete the specified mutual agreement
     */
    public function deleteMutualAgreement($id)
    {
        return $this->mutualAgreementRepository->deleteMutualAgreement($id);
    }

    /**
     * Generate PDF for mutual agreement
     */
    public function generateMutualAgreementPdf($id)
    {
        try {
            $mutualAgreement = $this->mutualAgreementRepository->getMutualAgreementById($id);
            
            if ($mutualAgreement->getStatusCode() !== 200) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Mutual agreement not found'
                ], 404);
            }

            $data = json_decode($mutualAgreement->getContent(), true);
            $contractData = $data['data'] ?? null;

            if (!$contractData) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Mutual agreement data not found'
                ], 404);
            }

            // Generate PDF using the PDF service (Mutual Agreement format in Swahili)
            $pdf = $this->pdfService->generateMutualAgreementPdf($contractData);

            return response($pdf, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="mutual_agreement_' . $contractData['employee_name'] . '_' . date('Y-m-d') . '.pdf"');
        } catch (\Exception $e) {
            \Log::error('Error generating mutual agreement PDF', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Failed to generate PDF',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get attachments for mutual agreement
     */
    public function getAttachments($id)
    {
        try {
            $attachments = $this->mutualAgreementRepository->getAttachments($id);
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
     * Save attachment for mutual agreement
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

            $result = $this->mutualAgreementRepository->saveAttachment($request, $id);
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

