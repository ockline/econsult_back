<?php

namespace App\Repositories\EmployeeRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mews\Purifier\Facades\Purifier;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\Personal\Employee;
use App\Models\Employee\Personal\EmployeeDocument;
use App\Models\Employee\Personal\EmployeeEducation;
use App\Models\Employee\Personal\EmploymentHistory;
use App\Models\Hiring\Interview\CompetencyInterDoc;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Models\Employee\Personal\EmploymentReference;
use App\Models\Hiring\Interview\CompetencyTransaction;
use App\Models\Hiring\JobApplication\JobDescTransaction;




class UploadDocumentRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = EmployeeDocument::class;


    protected $employee;
    protected $upload;

    public function __construct(Employee $employee, EmployeeDocument $upload)
    {
        $this->employee = $employee;
        $this->upload = $upload;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */

    public function saveUpladedDocument($request, $id)
    {
        // Log::info($request->all());

        DB::beginTransaction();

        try {

            $documents = [];

            $documentTypes = [
                'passport_doc', 'id_copy', 'cv_doc', 'nssf_membership', 'induction_doc', 'guarantors',
                'referenc_doc', 'police_doc', 'osha_checkup', 'combined_certificate', 'bank_detail_doc'
            ];


            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType) && $id) {
                    $files = $request->file($documentType);


                    foreach ($files as $file) {
                        //  log::info($file); next time i want to add id of employer  as pass to reach interview candidate document
                        //   log::info($employee_id);
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('employees/documentation/' . $id . '/'), $fileName);
                        // log::info('hureee'. json_encode($fileName));
                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType), // Implement a function to get the document ID based on the type
                            'description' => $fileName,
                            'document_group_id' => 7,
                            'employee_id' => $id,
                        ];
                    }
                }
            }
            // log::info('document:'. ' '. $documents);
            $document_uploaded = null;
            foreach ($documents as $document) {
                // log::info('document: ******************');
                $document_uploaded[] =    EmployeeDocument::create($document);
            }

            DB::commit();
            $this->updateEmployeeUploaded($document_uploaded, $id);
            Log::info('Required document Saved ');
            return response()->json(['message' => 'Document created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save document', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save document', 'status' => 500]);
        }
    }
    public function getDocumentId($documentId)
    {

        //  $documentTypes = ['passport_doc','id_copy','cv_doc','nssf_membership','induction_doc','guarantors',
        // 'referenc_doc','police_doc','osha_checkup','combined_certificate','bank_detail_doc',];
        switch ($documentId) {
            case 'passport_doc';
                return 16;
                break;
            case 'cv_doc';
                return 18;
                break;
            case 'nssf_membership';
                return 19;
                break;
            case 'induction_doc';
                return 20;
                break;
            case 'guarantors';
                return 21;
                break;
            case 'referenc_doc';
                return 22;
                break;
            case 'certificate_service';
                return 23;
                break;
            case 'police_doc';
                return 24;
                break;
            case 'osha_checkup';
                return 25;
                break;
            case 'combined_certificate';
                return 38;
                break;
            case 'id_copy';
                return 39;
                break;
            case 'bank_detail_doc';
                return 40;
                break;
            default:
                return null;
        }
    }
    public function updateEmployeeUploaded($document_uploaded, $id)
    {
        // log::info(count($document_uploaded));
        // log::info('************************************');
        // Log::info($id);

        $uploade_doc = count($document_uploaded);

        if (isset($uploade_doc) && in_array($uploade_doc, [11, 12])) {

            Employee::where('id', $id)->update(['uploaded' => 1, 'uploaded_date' => now(), 'progressive_stage' => 3]);

            return response()->json(['message' => 'employee updated successfully', 'status' => 201], 201);
        } else {

            return response()->json(['message' => 'Failed to update employee', 'status' => 500]);
        }
    }

    public function getUploadedDocument()
    {

        $document = $this->getMandatoryDocument();

      $subquery = DB::table('employee_documents as ed')
    ->select(
        'es.id as employee_id',
        DB::raw('COUNT(ed.document_id) as employee_files')
    )
    ->leftJoin('employees as es', 'ed.employee_id', '=', 'es.id')
    ->whereIn('ed.document_id', $document)
    ->groupBy('es.id');

// Main query to get the details and sum the employee_files
return DB::table('employees as es')
    ->select(
        'es.id as employee_id',
        'es.employee_name as employee',
        DB::raw('COALESCE(SUM(sub.employee_files), 0) as total_employee_files')
    )
    ->leftJoinSub($subquery, 'sub', 'es.id', '=', 'sub.employee_id')
    ->where('sub.employee_id', 'IS NOT', null) // Only include employees with documents
    ->groupBy('es.id', 'es.employee_name') // Add GROUP BY clause
    ->get();

    }
    public function getMandatoryDocument()
    {
        $mandatory = [16, 39, 18, 19, 20, 21, 22, 23, 24, 25, 38, 40];

        return $mandatory;
    }

public function uploadedEmployeeDocument($id)
{

$document = $this->getMandatoryDocument();

    //   $data =
return DB::table('employee_documents as ed')
        ->select(
            'ed.id',
            'ed.employee_id',
            'ed.document_id',
            'ed.description',
            'ed.created_at',
            'es.employee_name as employee',
            'dg.name as document_group',
            'd.name as doc_name'
        )
        ->leftJoin('employees as es', 'ed.employee_id', '=', 'es.id')
        ->leftJoin('document_groups as dg', 'ed.document_group_id', '=', 'dg.id')
        ->leftJoin('documents as d', 'ed.document_id', '=', 'd.id')
        ->where('ed.employee_id', $id)
        ->whereIn('ed.document_id', $document)
        ->get();
// log::info($data);
}

public function uploadedEmployeeFile($id, $file_id)
{
 $document = $this->getMandatoryDocument();
return DB::table('employee_documents as ed')
        ->select(
            'ed.id',
            'ed.employee_id',
            'ed.document_id',
            'ed.description',
            'ed.created_at',
            'ed.updated_at',
            'es.employee_name as employee',
            'dg.name as document_group',
            'd.name as doc_name'
        )
        ->leftJoin('employees as es', 'ed.employee_id', '=', 'es.id')
        ->leftJoin('document_groups as dg', 'ed.document_group_id', '=', 'dg.id')
        ->leftJoin('documents as d', 'ed.document_id', '=', 'd.id')
        ->where('ed.employee_id', $id)
        ->where('ed.id', $file_id)
        ->whereIn('ed.document_id', $document)
        ->first();


}


}
