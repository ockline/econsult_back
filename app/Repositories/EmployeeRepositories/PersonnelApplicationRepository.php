<?php

namespace App\Repositories\EmployeeRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mews\Purifier\Facades\Purifier;
use App\Repositories\BaseREpository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use App\Models\Employee\Social\Dependant;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\Personal\Employee;
use App\Models\Employee\Social\SocialRecord;
use App\Models\Employee\Social\RelativeDetail;
use App\Models\Employee\Personal\EmployeeDocument;
use App\Models\Employee\Personal\EmployeeEducation;
use App\Models\Employee\Personal\EmploymentHistory;
use App\Models\Hiring\Interview\CompetencyInterDoc;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Models\Employee\Personal\EmploymentReference;
use App\Models\Hiring\Interview\CompetencyTransaction;
use App\Models\Hiring\JobApplication\JobDescTransaction;
use App\Models\Employee\Application\PersonnelApplication;




class PersonnelApplicationRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = PersonnelApplication::class;


    protected $personnel_application;


    public function __construct(PersonnelApplication $personnel_application)
    {
        $this->personnel_application = $personnel_application;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */

    public function addPersonnelApplication($request)
    {
        //   log::info($request->all());



        DB::beginTransaction();

        try {
            $input = $request->all();


            // log::info('data' . $employee_no);
            PersonnelApplication::create([
                'firstname' => !empty($input['firstname']) ? $input['firstname'] : null,
                'middlename' => !empty($input['middlename']) ? $input['middlename'] : null,
                'lastname' => !empty($input['lastname']) ? $input['lastname'] : null,
                'department_id' => !empty($input['department_id']) ? $input['department_id'] : null,
                'national_id' => !empty($input['national_id']) ? $input['national_id'] : null,
                'birth_place' => !empty($input['birth_place']) ? $input['birth_place'] : null,
                'duration_deployment' => !empty($input['duration_deployment']) ? $input['duration_deployment'] : null,
                'employee_id' => !empty($input['employee_id']) ? $input['employee_id'] : null,
                'personal_type' => !empty($input['personal_type']) ? $input['personal_type'] : 1,
                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                'section' => !empty($input['section']) ? $input['section'] : null,
                'transfer_from' => !empty($input['transfer_from']) ? $input['transfer_from'] : null,
                'site_pass_type' => !empty($input['site_pass_type']) ? $input['site_pass_type'] : 2,
                'from_date' => !empty($input['from_date']) ? $input['from_date'] : null,
                'end_date' => !empty($input['end_date']) ? $input['end_date'] : null,
                'purpose' => !empty($input['purpose']) ? $input['purpose'] : null,
                'employer_id' => !empty($input['employer_id']) ? $input['employer_id'] : null,
                'downloaded' => !empty($input['downloaded']) ? $input['downloaded'] : null,
                // 'uploaded' => !empty($input['uploaded']) ? $input['uploaded'] : 0,
                'uploaded_date' => !empty($input['uploaded_date']) ? $input['uploaded_date'] : null,
                'stage' => 0,
                'progressive_stage' => 3,
                'status' => 0,

            ]);
            // Log::info('vita iendeleee');
            $employee_id = $input['employee_id'];
            $this->updateUploadedDocument($request);
            DB::commit();

            Log::info('Saved done');
            return response()->json(['message' => 'Personnel ID Application created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create personnel Id application', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create personnel Id application', 'status' => 500]);
        }
    }
    public function updatePersonaDetail($employee_id)
    {
        return  Employee::where('id', $employee_id)->update(['progressive_stage' => '4']);
    }

    public function getLastSocialRecord()
    {
        return $this->personnel_application->select('*')->latest()->first();
    }

    /**
     *@method to save hr cometency attachment

     */
    public function updateUploadedDocument($request)
    {

        DB::beginTransaction();

        try {

            $documents = [];

            // $documentTypes = ['social_signed_doc','military_attach','osha_report_doc','marriage_cert','children_certificate'];

            foreach (array_keys($request->document_verified) as $document) {


                PersonnelApplication::where('employee_id', $request->employee_id)->update([
                    'driving_licence_uploaded' => !empty($document == 7) ? 1 : null,
                    'practical_uploaded' => !empty($document == 8) ? 1 : null,
                    'national_id_uploaded' => !empty($document == 16 || $document == 17) ? 1 : null,
                    'technical_uploaded' => !empty($document == 32) ? 1 : null, // 'technical_signed_doc'

                ]);
            }
            DB::commit();

            Log::info('updated requide doc');
            return response()->json(['message' => 'Document created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save document', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save document', 'status' => 500]);
        }
    }

    public function getDocumentId($documentId)
    {
        // $document_id = [7,8,16,17,26]; required document
        //  $documentTypes = ['driving_licence_uploaded','practical_test_doc','passport_doc','nida_doc','technical_signed_doc'];
        switch ($documentId) {

            case 'driving_licence';
                return 7;
                break;
            case 'practical_test_doc';
                return 8;
                break;
            case 'passport_doc';
                return 16;
                break;
            case 'nida_doc';
                return 17;
                break;
            case 'technical_signed_doc';
                return 32;
                break;
            default:
                return null;
        }
    }
    /**
     * Method to Update assessed Candidate details
     */
    public function updateApplicationDetails($request, $id)
    {

        $personnel_applications = $this->personnel_application::where('employee_id', $request->employee_id)->first();

        if (isset($personnel_applications)) {


            DB::beginTransaction();
            try {
                $input = $request->all();

                $personnel_applications->update([
                    'firstname' => !empty($input['firstname']) ? $input['firstname'] : null,
                    'middlename' => !empty($input['middlename']) ? $input['middlename'] : null,
                    'lastname' => !empty($input['lastname']) ? $input['lastname'] : null,
                    'department_id' => !empty($input['department_id']) ? $input['department_id'] : null,
                    'national_id' => !empty($input['national_id']) ? $input['national_id'] : null,
                    'birth_place' => !empty($input['birth_place']) ? $input['birth_place'] : null,
                    'duration_deployment' => !empty($input['duration_deployment']) ? $input['duration_deployment'] : null,
                    'employee_id' => !empty($input['employee_id']) ? $input['employee_id'] : null,
                    'personal_type' => !empty($input['personal_type']) ? $input['personal_type'] : 1,
                    'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                    'section' => !empty($input['section']) ? $input['section'] : null,
                    'transfer_from' => !empty($input['transfer_from']) ? $input['transfer_from'] : null,
                    'site_pass_type' => !empty($input['site_pass_type']) ? $input['site_pass_type'] : 2,
                    'from_date' => !empty($input['from_date']) ? $input['from_date'] : null,
                    'end_date' => !empty($input['end_date']) ? $input['end_date'] : null,
                    'purpose' => !empty($input['purpose']) ? $input['purpose'] : null,
                    'employer_id' => !empty($input['employer_id']) ? $input['employer_id'] : null,
                    'downloaded' => !empty($input['downloaded']) ? $input['downloaded'] : null,
                    // 'uploaded' => !empty($input['uploaded']) ? $input['uploaded'] : 0,
                    'uploaded_date' => !empty($input['uploaded_date']) ? $input['uploaded_date'] : null,
                    'stage' => 0,
                    'progressive_stage' => 3,
                    'status' => 0,

                ]);


                $this->updateUploadedDocument($request);

                DB::commit();
                Log::info('updated done');

                return response()->json(['message' => 'Personnel Application Updated successfully', 'status' => 200], 200);
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Failed to update personnel application ', ['error' => $e->getMessage()]);

                return response()->json(['message' => 'Failed to Update  personnel application', 'status' => 500]);
            }
        }
    }


    /**
     * Method to fetch Employee person Details
     */
    public function getPersonnelDoc()
    {

        return  DB::table('employee_documents as ed')
            ->select('ed.id', 'ed.employee_id', 'ed.document_id', 'ed.description', 'ed.updated_at as doc_modified', 'd.name as doc_name')
            ->leftJoin('documents as d', 'ed.document_id', '=', 'd.id')
            // ->where('ed.document_group_id', 8)
            ->whereIn('ed.document_id', [7, 8, 16, 17, 32])
            ->get();
    }


    public function showDownloadDetails()
    {
        $data =  DB::table('employee_identifications as ei')
            ->select([
                DB::raw('ei.* '),
                DB::raw("CASE
                            WHEN ei.progressive_stage = 1 THEN 'Employee Details'
                            WHEN ei.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN ei.progressive_stage = 3 THEN 'Social Record'
                            WHEN ei.progressive_stage = 4 THEN 'Induction Training'
                            WHEN ei.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN ei.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS progressive"),
                DB::raw('CONCAT(ei.firstname, \' \', ei.middlename, \' \', ei.lastname) as employee_name'),
                DB::raw('e.employee_no as employee'),
                DB::raw('ei.personal_type as personal_type'),
                DB::raw("CASE
                            WHEN ei.personal_type = 1 THEN 'New Comers'
                            WHEN ei.personal_type = 2 THEN 'Change Job'
                            WHEN ei.personal_type = 3 THEN 'Vistor'
                           WHEN ei.personal_type = 4 THEN 'Transfer'
                            ELSE ''
                        END AS personal_type"),
                DB::raw("CASE
                            WHEN ei.site_pass_type = 1 THEN 'Permanent'
                            ELSE 'Temporary'
                        END AS site_pass_type"),
                DB::raw('em.name as employer'),
                DB::raw('jt.name as job_title'),
                DB::raw('d.name as department'),
            ])
            ->leftJoin('employees as e', 'ei.employee_id', '=', 'e.id')
            ->leftJoin('employers as em', 'ei.employer_id', '=', 'em.id')
            ->leftJoin('job_title as jt', 'ei.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as d', 'ei.department_id', '=', 'd.id')
            ->orderBy('ei.id', 'DESC')
            ->get();

        return $data;
    }
    public function getSocialRecord()
    {
        return      DB::table('personnel_applications as sr')
            ->select([
                'sr.*',
                DB::raw('CONCAT(sr.firstname, \' \', sr.middlename, \' \', sr.lastname) as employee_name'),
                DB::raw("CASE
                            WHEN sr.progressive_stage = 1 THEN 'Employee Details'
                            WHEN sr.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN sr.progressive_stage = 3 THEN 'Social Record'
                            WHEN sr.progressive_stage = 4 THEN 'Induction Training'
                            WHEN sr.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN sr.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS progressive"),
            ])
            ->leftJoin('employees as e', 'sr.employee_id', '=', 'e.id')
            ->where('sr.progressive_stage', 4)
            ->whereIn('e.progressive_stage', [3, 4])
            ->orderBy('sr.updated_at', 'DESC')
            ->get();
    }

    public function getApplicationDetail()
    {

        return DB::table('social_records as sr')
            ->select([
                DB::raw('sr.* '),
                DB::raw("CASE WHEN sr.military_service = 1 THEN 'Completed' ELSE 'Didnt Attend' END AS military_service "),
                DB::raw("CASE WHEN sr.marital_status  = 1 THEN 'Married' ELSE 'Single' END AS marital"),
                DB::raw("CASE WHEN sr.gender  = 1 THEN 'Male' ELSE 'Female' END AS genders"),
                DB::raw("CASE
                            WHEN sr.progressive_stage = 1 THEN 'Employee Details'
                            WHEN sr.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN sr.progressive_stage = 3 THEN 'Social Record'
                            WHEN sr.progressive_stage = 4 THEN 'Induction Training'
                            WHEN sr.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN sr.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS progressive"),
                DB::raw('CONCAT(sr.firstname, \' \', sr.middlename, \' \', sr.lastname) as employee_name'),
                DB::raw('e.employee_no as employee'),
                DB::raw('ei.personal_type as personal_type'),
                DB::raw("CASE
                            WHEN ei.personal_type = 1 THEN 'New Comers'
                            WHEN ei.personal_type = 2 THEN 'Change Job'
                            WHEN ei.personal_type = 3 THEN 'Vistor'
                           WHEN ei.personal_type = 4 THEN 'Transfer'
                            ELSE ''
                        END AS personal_type"),
                DB::raw("CASE
                            WHEN ei.site_pass_type = 1 THEN 'Permanent'
                            ELSE 'Temporary'
                        END AS site_pass_type"),

            ])

            // ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('employee_identifications as ei', 'ei.employee_id', '=', 'sr.employee_id')
            ->leftJoin('employees as e', 'sr.employee_id', '=', 'e.id')
            ->where('sr.progressive_stage', '>=', 5)
            ->orderBy('sr.id', 'DESC')
            ->get();
    }
    public function updateStageData($personnel_applications)
    {
        //    log::info('data'.$personnel_applications);
        if (!empty($personnel_applications)) {
            PersonnelApplication::where('id', $personnel_applications->id)->update(['stage' => 1, 'progressive_stage' => 7]);
            SocialRecord::where('employee_id', $personnel_applications->employee_id)->update(['stage' => 1, 'progressive_stage' => 7]);
        }
    }
}
