<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\Personal\Employee;
use App\Models\Hiring\JobApplication\JobVacancy;
use App\Models\Employee\Personal\EmployeeEducation;
use App\Models\Employee\Personal\EmploymentHistory;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Models\Employee\Personal\EmploymentReference;
use App\Repositories\EmployeeRepositories\EmployeeRepository;
use App\Repositories\HiringRepositories\HrInterviewRepository;
use App\Repositories\EmployeeRepositories\UploadDocumentRepository;

class UploadDocumentController extends Controller
{
    protected $upload;
    protected $employee;

    public function __construct(UploadDocumentRepository $upload, EmployeeRepository $employee)
    {
        $this->upload = $upload;
        $this->employee = $employee;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function uploadDocument(Request $request, string $id)
    {
        // Log::info('hellow ndani');
        // Log::info($id);
        // log::info($request->all());

        $validator = Validator::make($request->all(), [

            'passport_doc' => 'required|max:191',
            'id_copy' => 'required|max:191',
            'cv_doc' => 'required|max:191',
            'nssf_membership' => 'required|max:191',
            'induction_doc' => 'required|max:191',
            'guarantors' => 'required|max:191',
            'referenc_doc' => 'required|max:191',
            'police_doc' => 'required|max:191',
            'osha_checkup' => 'required|max:191',
            'combined_certificate' => 'required|max:3072',
            'bank_detail_doc' => 'required|max:191',

        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
                // Log::info('ndani ya nyumba');
            ;
            $new_upload = $this->upload->saveUpladedDocument($request, $id);

            $status = $new_upload->getStatusCode();

            // Get HTTP status code
            $responseContent = $new_upload->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Required Document uploaded successfully",
                ];
            } else {
                $return = [
                    'status' => 500,
                    'message' => 'Sorry! Operation failed'


                ];
            }
        }
        return response()->json($return);
    }

    public function getUpladed()
    {
        // Log::info('anafikaaa mkali');
        $employee =    $this->upload->getUploadedDocument();

        if ($employee) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'employee' => $employee
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
    public function getEmployeeUpload(string $id)
    {
            // Log::info('anafikaaa mkali');
        $employee_document =    $this->upload->uploadedEmployeeDocument($id);

        if ($employee_document) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'employee_document' => $employee_document
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
  public function getEmployeeFileUpload(string $id, $file_id)
{

 $employee_file =    $this->upload->uploadedEmployeeFile($id, $file_id);
//      $dd = json_encode($employee_file);
// log::info($dd);
        if (json_encode($employee_file)) {
            //Log::info('111');
            return response()->json([
                'status' => 200,
                'employee_file' => $employee_file
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }

}
}
