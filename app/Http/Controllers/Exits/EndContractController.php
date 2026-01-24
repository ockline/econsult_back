<?php

namespace App\Http\Controllers\Exits;

use App\Http\Controllers\Controller;
use App\Repositories\Exits\EndContractRepository;
use App\Services\EndContractPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EndContractController extends Controller
{
    protected $endContractRepository;
    protected $pdfService;

    public function __construct(EndContractRepository $endContractRepository, EndContractPdfService $pdfService)
    {
        $this->endContractRepository = $endContractRepository;
        $this->pdfService = $pdfService;
    }

    /**
     * Display a listing of end contracts
     */
    public function showAllEndContracts()
    {
        return $this->endContractRepository->getAllEndContracts();
    }

    /**
     * Return contracts (fixed & specific task) that are eligible for end-of-contract.
     * This is used by the bulk initiate screen instead of contracts/* routes.
     */
    public function getEligibleContractsForEnd()
    {
        return $this->endContractRepository->getEligibleContractsForEnd();
    }

    /**
     * Show the form for creating a new end contract
     */
    public function create()
    {
        // This would typically return a view, but for API we might return form structure
        return response()->json([
            'status' => 200,
            'message' => 'End contract creation form data',
            'data' => [
                'statuses' => ['Draft', 'Submitted', 'Under Review', 'Approved', 'Rejected', 'Completed'],
                'stages' => ['Initiated', 'HR Review', 'Manager Review', 'Final Approval', 'Completed']
            ]
        ]);
    }

    /**
     * Store a newly created end contract
     */
    public function createEndContract(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'employee_name' => 'required|string|max:255',
            'department_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'postal_address' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'remark' => 'required|string',
            'end_date' => 'required|date',
            'renewal_notice_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',

            // Employment Contract Details
            'employer_name' => 'nullable|string|max:255',
            'letter_title' => 'nullable|string|max:255',
            'signed_date' => 'nullable|date',
            'started_date' => 'nullable|date',
            'days_worked' => 'nullable|integer|min:0',
            'on_behalf_of' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'hr_name' => 'nullable|string|max:255',
            'signature_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'employee_designation' => 'nullable|string|max:255',
            'employee_signature_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // Non-Renewal Contract Details
            'job_department' => 'nullable|string|max:255',
            'contract_date' => 'nullable|date',
            'expire_date' => 'nullable|date',
            'non_renewal_letter_title' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->endContractRepository->createEndContract($request);
    }

    /**
     * Display the specified end contract
     */
    public function showEndContract($id)
    {
        return $this->endContractRepository->getEndContractById($id);
    }

    /**
     * Show the form for editing the specified end contract
     */
    public function edit($id)
    {
        return $this->endContractRepository->getEndContractById($id);
    }

    /**
     * Update the specified end contract
     */
    public function updateEndContract(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'employee_name' => 'required|string|max:255',
            'department_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'postal_address' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'remark' => 'required|string',
            'end_date' => 'required|date',
            'renewal_notice_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',

            // Employment Contract Details
            'employer_name' => 'nullable|string|max:255',
            'letter_title' => 'nullable|string|max:255',
            'signed_date' => 'nullable|date',
            'started_date' => 'nullable|date',
            'days_worked' => 'nullable|integer|min:0',
            'on_behalf_of' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'hr_name' => 'nullable|string|max:255',
            'signature_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'employee_designation' => 'nullable|string|max:255',
            'employee_signature_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // Non-Renewal Contract Details
            'job_department' => 'nullable|string|max:255',
            'contract_date' => 'nullable|date',
            'expire_date' => 'nullable|date',
            'non_renewal_letter_title' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->endContractRepository->updateEndContract($request, $id);
    }

    /**
     * Remove the specified end contract
     */
    public function deleteEndContract($id)
    {
        return $this->endContractRepository->deleteEndContract($id);
    }

    /**
     * Submit end contract for review
     */
    public function submitEndContract(Request $request, $id = null)
    {
        if ($id) {
            // Re-submitting existing end contract
            return $this->endContractRepository->submitEndContract($request, $id);
        } else {
            // Creating and submitting new end contract
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|exists:employees,id',
                'employee_name' => 'required|string|max:255',
                'department_name' => 'required|string|max:255',
                'job_title' => 'required|string|max:255',
                'postal_address' => 'required|string',
                'phone_number' => 'required|string|max:20',
                'remark' => 'required|string',
                'end_date' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            return $this->endContractRepository->submitEndContract($request);
        }
    }

    /**
     * Get end contracts by status
     */
    public function getEndContractsByStatus($status)
    {
        return $this->endContractRepository->getEndContractsByStatus($status);
    }

    /**
     * Get end contracts by employee
     */
    public function getEndContractsByEmployee($employeeId)
    {
        return $this->endContractRepository->getEndContractsByEmployee($employeeId);
    }

    /**
     * Download file
     */
    public function downloadFile($id, $fileName)
    {
        try {
            $endContract = $this->endContractRepository->getModel()->findOrFail($id);

            // Determine file path based on file type
            $filePath = null;
            if ($endContract->renewal_notice_file === $fileName) {
                $filePath = 'public/endcontracts/renewal_notices/' . $fileName;
            } elseif ($endContract->signature_file === $fileName) {
                $filePath = 'public/endcontracts/signatures/' . $fileName;
            } elseif ($endContract->employee_signature_file === $fileName) {
                $filePath = 'public/endcontracts/employee_signatures/' . $fileName;
            }

            if (!$filePath || !Storage::exists($filePath)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'File not found'
                ], 404);
            }

            return Storage::download($filePath, $fileName);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to download file',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Serve file for viewing (iframe)
     */
    public function serveFile($id, $fileName)
    {
        try {
            $endContract = $this->endContractRepository->getModel()->findOrFail($id);

            // Determine file path based on file type
            $filePath = null;
            if ($endContract->renewal_notice_file === $fileName) {
                $filePath = 'public/endcontracts/renewal_notices/' . $fileName;
            } elseif ($endContract->signature_file === $fileName) {
                $filePath = 'public/endcontracts/signatures/' . $fileName;
            } elseif ($endContract->employee_signature_file === $fileName) {
                $filePath = 'public/endcontracts/employee_signatures/' . $fileName;
            }

            if (!$filePath || !Storage::exists($filePath)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'File not found'
                ], 404);
            }

            $file = Storage::get($filePath);
            $mimeType = Storage::mimeType($filePath);

            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to serve file',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate Employment Contract PDF
     */
    public function generateEmploymentContract($id)
    {
        try {
            $endContract = $this->endContractRepository->getModel()->findOrFail($id);

            if (!$endContract->canGenerateContracts()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Contract cannot be generated for end contract in current status'
                ], 400);
            }

            $result = $this->pdfService->generateEmploymentContract($endContract);

            if ($result['success']) {
                return response()->download(
                    storage_path('app/' . $result['file_path']),
                    $result['file_name'],
                    ['Content-Type' => 'application/pdf']
                );
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to generate employment contract',
                    'error' => $result['error']
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to generate employment contract',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate Non-Renewal Contract PDF
     */
    public function generateNonRenewalContract($id)
    {
        try {
            $endContract = $this->endContractRepository->getModel()->findOrFail($id);

            if (!$endContract->canGenerateContracts()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Contract cannot be generated for end contract in current status'
                ], 400);
            }

            $result = $this->pdfService->generateNonRenewalContract($endContract);

            if ($result['success']) {
                return response()->download(
                    storage_path('app/' . $result['file_path']),
                    $result['file_name'],
                    ['Content-Type' => 'application/pdf']
                );
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to generate non-renewal contract',
                    'error' => $result['error']
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to generate non-renewal contract',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics
     */
    public function getStatistics()
    {
        try {
            $model = $this->endContractRepository->getModel();

            $statistics = [
                'total' => $model->count(),
                'draft' => $model->byStatus('Draft')->count(),
                'submitted' => $model->byStatus('Submitted')->count(),
                'under_review' => $model->byStatus('Under Review')->count(),
                'approved' => $model->byStatus('Approved')->count(),
                'rejected' => $model->byStatus('Rejected')->count(),
                'completed' => $model->byStatus('Completed')->count(),
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Statistics retrieved successfully',
                'data' => $statistics
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
