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
                'created_by' => 1, // admin after login will be authenticated user
            ]);

            // Save resignation documents
            if ($request->hasFile('resignation_notice_file')) {
                try {
                    $resignation->resignation_notice_file = $this->saveFile($request->file('resignation_notice_file'), $resignation->id, 'resignation_notice');
                    $resignation->save();
                } catch (\Exception $e) {
                    Log::error('Failed to save resignation notice file', ['error' => $e->getMessage()]);
                    throw $e;
                }
            }

            if ($request->hasFile('resignation_form_file')) {
                try {
                    $resignation->resignation_form_file = $this->saveFile($request->file('resignation_form_file'), $resignation->id, 'resignation_form');
                    $resignation->save();
                } catch (\Exception $e) {
                    Log::error('Failed to save resignation form file', ['error' => $e->getMessage()]);
                    throw $e;
                }
            }

            if ($request->hasFile('resignation_letter_file')) {
                try {
                    $resignation->resignation_letter_file = $this->saveFile($request->file('resignation_letter_file'), $resignation->id, 'resignation_letter');
                    $resignation->save();
                } catch (\Exception $e) {
                    Log::error('Failed to save resignation letter file', ['error' => $e->getMessage()]);
                    throw $e;
                }
            }

            if ($request->hasFile('certificate_of_service_file')) {
                try {
                    $resignation->certificate_of_service_file = $this->saveFile($request->file('certificate_of_service_file'), $resignation->id, 'certificate_of_service');
                    $resignation->save();
                } catch (\Exception $e) {
                    Log::error('Failed to save certificate of service file', ['error' => $e->getMessage()]);
                    throw $e;
                }
            }

            // Save documents to attachments table using the already saved file names
            try {
                $this->saveResignationDocumentFromSavedFiles($resignation);
            } catch (\Exception $e) {
                Log::error('Failed to save resignation documents', ['error' => $e->getMessage()]);
                throw $e; // This will trigger the rollback in the main transaction
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
*@method saveResignationDocument
*@param Request $request
*@return void
*/
private function saveResignationDocument($request,$resignationId)
    {
        // Log::info($request->all());

        try {

            $documents = [];

            $documentTypes = [
                'resignation_notice_file' => 'resignation_notice',
                'resignation_form_file' => 'resignation_form',
                'resignation_letter_file' => 'resignation_letter',
                'certificate_of_service_file' => 'certificate_of_service',
                'hr_signature_file' => 'hr_signature',
                'employee_signature_file' => 'employee_signature'
            ];

            foreach ($documentTypes as $fileField => $documentType) {
                if ($request->hasFile($fileField) && $resignationId) {
                    $file = $request->file($fileField);

                    if ($file) {
                        try {
                            $fileName = time() . '_' . $file->getClientOriginalName();
                            $directory = public_path('exit/resignation');

                            // Create directory if it doesn't exist
                            if (!file_exists($directory)) {
                                mkdir($directory, 0755, true);
                            }

                            // Check if file is valid
                            if (!$file->isValid()) {
                                Log::error('Invalid file upload', [
                                    'file_field' => $fileField,
                                    'error' => $file->getError(),
                                    'error_message' => $file->getErrorMessage()
                                ]);
                                continue;
                            }

                            $file->move($directory, $fileName);

                            Log::info('File uploaded successfully', [
                                'file_field' => $fileField,
                                'file_name' => $fileName,
                                'directory' => $directory
                            ]);

                            $documents[] = [
                                'name' => $documentType,
                                'document_id' => $this->getDocumentId($documentType),
                                'description' => $fileName,
                                'document_group_id' => 5,
                                'resignation_id' => $resignationId,
                            ];
                        } catch (\Exception $e) {
                            Log::error('File upload failed', [
                                'file_field' => $fileField,
                                'error' => $e->getMessage(),
                                'file_name' => $file->getClientOriginalName()
                            ]);
                            continue;
                        }
                    }
                }
            }
            Log::info('Documents to save', ['documents' => $documents]);

            foreach ($documents as $document) {
                try {
                    ResignationAttachment::create($document);
                    Log::info('Document saved successfully', ['document' => $document]);
                } catch (\Exception $e) {
                    Log::error('Failed to save document to database', [
                        'document' => $document,
                        'error' => $e->getMessage()
                    ]);
                    throw $e;
                }
            }



            Log::info('Saved document successfully');
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to save document', ['error' => $e->getMessage()]);
            throw $e; // Re-throw the exception to trigger rollback in main transaction
        }
    }

    /**
     * Save resignation documents to attachments table using already saved files
     */
    private function saveResignationDocumentFromSavedFiles($resignation)
    {
        try {
            $documents = [];

            // Map file fields to document types
            $fileMappings = [
                'resignation_notice_file' => 'resignation_notice',
                'resignation_form_file' => 'resignation_form',
                'resignation_letter_file' => 'resignation_letter',
                'certificate_of_service_file' => 'certificate_of_service',
            ];

            foreach ($fileMappings as $fileField => $documentType) {
                $fileName = $resignation->$fileField;
                if ($fileName) {
                    // Copy file to exit/resignation directory for document management system
                    $sourcePath = public_path("resignations/{$resignation->id}/{$fileName}");
                    $targetDirectory = public_path('exit/resignation');
                    $targetPath = $targetDirectory . '/' . $fileName;

                    // Create target directory if it doesn't exist
                    if (!file_exists($targetDirectory)) {
                        mkdir($targetDirectory, 0755, true);
                    }

                    // Copy file if source exists
                    if (file_exists($sourcePath)) {
                        copy($sourcePath, $targetPath);
                        Log::info('File copied to exit/resignation directory', [
                            'source' => $sourcePath,
                            'target' => $targetPath
                        ]);
                    }

                    $documents[] = [
                        'name' => $documentType,
                        'document_id' => $this->getDocumentId($documentType),
                        'description' => $fileName,
                        'document_group_id' => 5,
                        'resignation_id' => $resignation->id,
                    ];
                }
            }

            Log::info('Documents to save from saved files', ['documents' => $documents]);

            foreach ($documents as $document) {
                try {
                    ResignationAttachment::create($document);
                    Log::info('Document saved successfully from saved files', ['document' => $document]);
                } catch (\Exception $e) {
                    Log::error('Failed to save document to database from saved files', [
                        'document' => $document,
                        'error' => $e->getMessage()
                    ]);
                    throw $e;
                }
            }

            Log::info('Saved documents from saved files successfully');
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to save documents from saved files', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getDocumentId($documentId)
    {
        // $document_id = [29, 30];
        //  $documentTypes = [resignation_notice','resignation_form','resignation_letter','certificate_of_service','hr_signature','employee_signature'];
        switch ($documentId) {
            case 'resignation_notice':
                return 60;
                break;
            case 'resignation_form':
                return 61;
                break;
            case 'resignation_letter':
                return 62;
                break;
            case 'certificate_of_service':
                return 63;
                break;
            case 'hr_signature':
                return 64;
                break;
            case 'employee_signature':
                return 65;
                break;
            default:
                return null;
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
                'updated_by' => 1, // admin after login will be authenticated user
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

            if ($request->hasFile('certificate_of_service_file')) {
                $resignation->certificate_of_service_file = $this->saveFile($request->file('certificate_of_service_file'), $resignation->id, 'certificate_of_service');
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
                'updated_by' => 1, // admin after login will be authenticated user
            ]);

            // Create workflow entry
            $this->createWorkflow($resignation->id, 'Initiated', 'HR Review', 'Resignation Submitted');

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
                'created_by' => 1, // admin after login will be authenticated user
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
                ->get()
                ->map(function ($resignation) {
                    // Add employee_no to the resignation data
                    if ($resignation->employee) {
                        $resignation->employee_no = $resignation->employee->employee_no;
                    } else {
                        $resignation->employee_no = 'N/A';
                    }
                    return $resignation;
                });

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

            // Add employee_no to the resignation data
            if ($resignation->employee) {
                $resignation->employee_no = $resignation->employee->employee_no;
            } else {
                $resignation->employee_no = 'N/A';
            }

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
            'attended_by' => 1, // admin after login will be authenticated user
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
        try {
            $fileName = time() . '_' . $type . '_' . $file->getClientOriginalName();
            $directory = public_path("resignations/{$resignationId}");

            // Create directory if it doesn't exist
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Check if file is valid
            if (!$file->isValid()) {
                Log::error('Invalid file in saveFile method', [
                    'type' => $type,
                    'error' => $file->getError(),
                    'error_message' => $file->getErrorMessage()
                ]);
                throw new \Exception("Invalid file upload: " . $file->getErrorMessage());
            }

            $file->move($directory, $fileName);

            Log::info('File saved successfully in saveFile method', [
                'type' => $type,
                'file_name' => $fileName,
                'directory' => $directory
            ]);

            return $fileName;
        } catch (\Exception $e) {
            Log::error('Failed to save file in saveFile method', [
                'type' => $type,
                'error' => $e->getMessage(),
                'file_name' => $file->getClientOriginalName()
            ]);
            throw $e;
        }
    }


}
