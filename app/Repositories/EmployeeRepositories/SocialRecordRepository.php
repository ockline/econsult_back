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




class SocialRecordRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = SocialRecord::class;


    protected $social_record;


    public function __construct(SocialRecord $social_record)
    {
        $this->social_record = $social_record;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */

    public function addSocialRecord($request)
    {

        // Log::info('************************************8');


        //   log::info($employee_no);

        DB::beginTransaction();

        try {
            $input = $request->all();


            // log::info('data' . $employee_no);
            $social =  SocialRecord::create([


                'firstname' => !empty($input['firstname']) ? $input['firstname'] : null,
                'middlename' => !empty($input['middlename']) ? $input['middlename'] : null,
                'lastname' => !empty($input['lastname']) ? $input['lastname'] : null,
                'military_service' => !empty($input['military_service']) ? $input['military_service'] : 2,
                'military_number' => !empty($input['military_number']) ? $input['military_number'] : null,
                'gender' => !empty($input['gender']) ? $input['gender'] : 2,
                'department_id' => !empty($input['department_id']) ? $input['department_id'] : null,
                'national_id' => !empty($input['national_id']) ? $input['national_id'] : null,
                'marital_status' => !empty($input['marital_status']) ? $input['marital_status'] : 2,
                'children_no' => !empty($input['children_no']) ? $input['children_no'] : null,
                'telephone_home' => !empty($input['telephone_home']) ? $input['telephone_home'] : null,
                'city_id' => !empty($input['city_id']) ? $input['city_id'] : null,
                'mobile_number' => !empty($input['mobile_number']) ? $input['mobile_number'] : null,
                'person_email' => !empty($input['person_email']) ? $input['person_email'] : null,
                'employee_street' => !empty($input['employee_street']) ? $input['employee_street'] : null,
                'employee_id' => !empty($input['employee_id']) ? $input['employee_id'] : null,
                'district_id' => !empty($input['district_id']) ? $input['district_id'] : null,
                'ward_id' => !empty($input['ward_id']) ? $input['ward_id'] : null,
                'expiration_date' => !empty($input['expiration_date']) ? $input['expiration_date'] : null,
                'dob' => !empty($input['dob']) ? $input['dob'] : null,
                'remark' => !empty($input['remark']) ? $input['remark'] : null,
                'section' => !empty($input['section']) ? $input['section'] : null,
                'passport_id' => !empty($input['passport_id']) ? $input['passport_id'] : null,
                'postal_address' => !empty($input['postal_address']) ? $input['postal_address'] : null,
                'relative_working' => !empty($input['relative_working']) ? $input['relative_working'] : null,
                'relative_name' => !empty($input['relative_name']) ? $input['relative_name'] : null,
                'tin' => !empty($input['tin']) ? $input['tin'] : null,
                'downloaded' => !empty($input['downloaded']) ? $input['downloaded'] : null,
                'uploaded' => !empty($input['uploaded']) ? $input['uploaded'] : 0,
                'uploaded_date' => !empty($input['uploaded_date']) ? $input['uploaded_date'] : null,
                'stage' => !empty($input['stage']) ? $input['stage'] : null,
                'progressive_stage' => 3,
                'status' => 0,

            ]);
            Log::info('vita iendeleee');
            $employee_id = $input['employee_id'];

            $this->updatePersonaDetail($employee_id); //to save compotencies
            $this->saveSocialRecordDocument($request, $employee_id); // To save attachment
            // $this->addEducation($request, $employee_id);
            DB::commit();

            Log::info('Saved done');
            return response()->json(['message' => 'Social record created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create Social record', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create Social record', 'status' => 500]);
        }
    }
    public function updatePersonaDetail($employee_id)
    {
        return  Employee::where('id', $employee_id)->update(['progressive_stage' => '4']);
    }

    public function getLastSocialRecord()
    {
        return $this->social_record->select('*')->latest()->first();
    }

    /**
     *@method to save hr cometency attachment

     */
    public function saveSocialRecordDocument($request, $employee_id)
    {
        // Log::info($request->all());

        DB::beginTransaction();

        try {

            $documents = [];

            $documentTypes = ['social_signed_doc','military_attach','osha_report_doc','marriage_cert','children_certificate'];

            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType) && $employee_id) {
                    $files = $request->file($documentType);


                    foreach ($files as $file) {
                        //  log::info($file); next time i want to add id of employer  as pass to reach interview candidate document
                        //   log::info($employee_id);
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('employees/social/'.$employee_id.'/'), $fileName);
                        // log::info('hureee'. json_encode($fileName));
                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType), // Implement a function to get the document ID based on the type
                            'description' => $fileName,
                            'document_group_id' => 8,
                            'employee_id' => $employee_id,
                        ];
                    }
                }
            }
            // log::info('document:'. ' '. $documents);
            foreach ($documents as $document) {
                // log::info('document: ******************');
                EmployeeDocument::create($document);
            }

            DB::commit();

            Log::info('Saved employee document ');
            return response()->json(['message' => 'Document created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save document', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save document', 'status' => 500]);
        }
    }
    public function getDocumentId($documentId)
    {
        // $document_id = [29, 30];
        //  $documentTypes = ['social_signed_doc','osha_report_doc','military_attach'];
        switch ($documentId) {
            case 'social_signed_doc';
                return 26;
                break;
            case 'military_attach';
                return 33;
                break;
            case 'marriage_cert';
                return 34;
                break;
           case 'osha_report_doc';
                return 41;
                break;
            case 'children_certificate';
                return 42;
                break;
            default:
                return null;
        }
    }
    /**
     * Method to Update assessed Candidate details
     */
    public function updateDetails($request, $id)
    {
    //    log::info($id);
    //     Log::info('*******************************');
    //        Log::info($request->all());
        $social_records = $this->social_record::where('employee_id', $id)->where('id', $request->social_record_id)->first();

        if (isset($social_records)) {


            DB::beginTransaction();
            try {
                $input = $request->all();

                $social_records->update([
                'firstname' => !empty($input['firstname']) ? $input['firstname'] : null,
                'middlename' => !empty($input['middlename']) ? $input['middlename'] : null,
                'lastname' => !empty($input['lastname']) ? $input['lastname'] : null,
                'military_service' => !empty($input['military_service']) ? $input['military_service'] : 2,
                'military_number' => !empty($input['military_number']) ? $input['military_number'] : null,
                'gender' => !empty($input['gender']) ? $input['gender'] : 2,
                'department_id' => !empty($input['department_id']) ? $input['department_id'] : null,
                'national_id' => !empty($input['national_id']) ? $input['national_id'] : null,
                'marital_status' => !empty($input['marital_status']) ? $input['marital_status'] : 2,
                'children_no' => !empty($input['children_no']) ? $input['children_no'] : null,
                'telephone_home' => !empty($input['telephone_home']) ? $input['telephone_home'] : null,
                'city_id' => !empty($input['city_id']) ? $input['city_id'] : null,
                'mobile_number' => !empty($input['mobile_number']) ? $input['mobile_number'] : null,
                'person_email' => !empty($input['person_email']) ? $input['person_email'] : null,
                'employee_street' => !empty($input['employee_street']) ? $input['employee_street'] : null,
                'employee_id' => !empty($input['employee_id']) ? $input['employee_id'] : null,
                'district_id' => !empty($input['district_id']) ? $input['district_id'] : null,
                'ward_id' => !empty($input['ward_id']) ? $input['ward_id'] : null,
                'expiration_date' => !empty($input['expiration_date']) ? $input['expiration_date'] : null,
                'dob' => !empty($input['dob']) ? $input['dob'] : null,
                'remark' => !empty($input['remark']) ? $input['remark'] : null,
                'section' => !empty($input['section']) ? $input['section'] : null,
                'passport_id' => !empty($input['passport_id']) ? $input['passport_id'] : null,
                'postal_address' => !empty($input['postal_address']) ? $input['postal_address'] : null,
                'relative_working' => !empty($input['relative_working']) ? $input['relative_working'] : null,
                'relative_name' => !empty($input['relative_name']) ? $input['relative_name'] : null,
                'tin' => !empty($input['tin']) ? $input['tin'] : null,
                'downloaded' => !empty($input['downloaded']) ? $input['downloaded'] : null,
                'uploaded' => !empty($input['uploaded']) ? $input['uploaded'] : 0,
                'uploaded_date' => !empty($input['uploaded_date']) ? $input['uploaded_date'] : null,
                'stage' => !empty($input['stage']) ? $input['stage'] : null,
                'progressive_stage' => 3,
                'status' => 0,

                ]);


                $employee_id = $social_records->employee_id;
                // $this->updateCompetencyTransaction($request, $interview_id);
                $this->saveSocialRecordDocument($request, $employee_id);
                // $this->updateCompetencyDocument($request, $interview_id);

                DB::commit();
                Log::info('updated done');

                return response()->json(['message' => 'Social Record Updated successfully', 'status' => 200], 200);
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Failed to update social record ', ['error' => $e->getMessage()]);

                return response()->json(['message' => 'Failed to Update  social record', 'status' => 500]);
            }
        }
    }
    public function addRelativeDetail($request)
    {

        DB::beginTransaction();
        $social_record =  $this->getLastSocialRecord();
        $social_record_id = $social_record->id;
        // log::info($employee_id);
        try {

            $input = $request->all();

            $relative_detail = new RelativeDetail();

            $relative_detail->create([
                'employee_id' => !empty($request['employee_id']) ? $request['employee_id'] : 1,
                'relative_id' => !empty($request['relative_id']) ? $request['relative_id'] : null,
                'description' => !empty($request['description']) ? $request['description'] : null,
                'relative_number' => !empty($request['relative_number']) ? $request['relative_number'] : null,
                'relative_name' => !empty($request['relative_name']) ? $request['relative_name'] : null,
                'relationship_id' => !empty($request['relationship_id']) ? $request['relationship_id'] : null,
                'social_record_id' => !empty($social_record_id) ? $social_record_id : null,
                'relative_address' => !empty($request['relative_address']) ? $request['relative_address'] : null,
                'emergency_number' => !empty($request['emergency_number']) ? $request['emergency_number'] : null,
                'other_relationship' => !empty($request['relationship_id'] != 16) ? null : $request['other_relationship'],
            ]);

            DB::commit();
            Log::info('Relative done');

            return response()->json(['message' => 'Relative detail successfully addedd', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to add relative detail ', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to add relative detail', 'status' => 500]);
        }
    }
    public function addDependantDetails($request)
    {

        DB::beginTransaction();
        $social_record =  $this->getLastSocialRecord();
        $social_record_id = $social_record->id;
        // log::info($employee_id);
        try {

            $input = $request->all();
            // Log::info('ndaniiiii'.$employee_id);
            // log::info($input);
            // log::info('mwamba dependant');

            $education_history = new Dependant();

            $education_history->create([
                'employee_id' => !empty($request['employee_id']) ? $request['employee_id'] : null,
                'social_record_id' => !empty($social_record_id) ? $social_record_id : null,
                'description' => !empty($request['description']) ? $request['description'] : null, // as remark
                'dependant_name' => !empty($request['dependant_name']) ? $request['dependant_name'] : null,
                'relationship' => !empty($request['relationship']) ? $request['relationship'] : null,
                'dob' => !empty($request['dob']) ? $request['dob'] : null,
                'dependant_type_id' => !empty($request['dependant_type_id']) ? $request['dependant_type_id'] : null,
                'dependent_id' => !empty($request['dependent_id']) ? $request['dependent_id'] : null,
                'other_relationship' => !empty($request['relationship_id'] != 16) ? null : $request['other_relationship'],
            ]);


            DB::commit();

            Log::info('Dependant done');

            return response()->json(['message' => 'Dependant detail successfully addedd', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to add dependant detail ', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to add dependant detail', 'status' => 500]);
        }
    }


    public function updateRelativeDetail($request, $id)
    {
        // log::info($id);
        // log::info($request->all());
        // DB::beginTransaction();
        //           Log::info('**********************************');
        $social_record = $request->social_record_id;

        try {

            $input = $request->all();

        $relative_details =  RelativeDetail::where('social_record_id', $social_record)->where('employee_id', $id)->where('relative_id', $request->relative_id);

            $relative_details->update([
                'employee_id' => !empty($request['employee_id']) ? $request['employee_id'] : 1,
                'relative_id' => !empty($request['relative_id']) ? $request['relative_id'] : null,
                'description' => !empty($request['description']) ? $request['description'] : null,
                'relative_number' => !empty($request['relative_number']) ? $request['relative_number'] : null,
                'relative_name' => !empty($request['relative_name']) ? $request['relative_name'] : null,
                'relationship_id' => !empty($request['relationship_id']) ? $request['relationship_id'] : null,
                'social_record_id' => !empty($request['social_record_id']) ? $request['social_record_id'] : null,
                'relative_address' => !empty($request['relative_address']) ? $request['relative_address'] : null,
                'other_relationship' => !empty($request['relationship_id'] != 16) ? null : $request['other_relationship'],
            ]);

            // $this->saveEmployeeDocument($request, $id);
            DB::commit();

            Log::info('relative done');

            return response()->json(['message' => 'Relative Details  successfully addedd', 'status' => 200], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update relative ', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to update relative', 'status' => 500]);
        }
    }
    public function updateDependantDetail($request, $id)
    {
            //  log::info($request->all());
        DB::beginTransaction();
        // $employee =  $this->getLastEmployee();
        $social_record = $request->social_record_id;
        try {

            $input = $request->all();

            $dependant_detail =  Dependant::where('social_record_id', $social_record)->where('employee_id', $id)->where('dependent_id', $request->dependent_id);
            $dependant_detail->update([
                 'employee_id' => !empty($request['employee_id']) ? $request['employee_id'] : null,
                 'social_record_id' => !empty($request['social_record_id']) ? $request['social_record_id'] : null,
                'description' => !empty($request['description']) ? $request['description'] : null, // as remark
                'dependant_name' => !empty($request['dependant_name']) ? $request['dependant_name'] : null,
                'relationship' => !empty($request['relationship']) ? $request['relationship'] : null,
                'dob' => !empty($request['dob']) ? $request['dob'] : null,
                'dependant_type_id' => !empty($request['dependant_type_id']) ? $request['dependant_type_id'] : null,
                'dependent_id' => !empty($request['dependent_id']) ? $request['dependent_id'] : null,
                'other_relationship' => !empty($request['relationship_id'] != 16) ? null : $request['other_relationship'],
            ]);
            // $this->saveEmployeeDocument($request, $id);
            DB::commit();
            Log::info('employment done');
            return response()->json(['message' => 'Dependant details successfully updated', 'status' => 200], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to add dependant details ', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to add dependant details', 'status' => 500]);
        }
    }

    /**
     * Method to fetch Employee person Details
     */
    public function getPersonalDocument()
    {
        // return $this->assessment->get();
        return  DB::table('employee_documents as ed')
            ->select('ed.id', 'ed.employee_id', 'ed.document_id', 'ed.document_group_id as group','ed.description', 'ed.updated_at as doc_modified', 'd.name as doc_name')
            ->leftJoin('documents as d', 'ed.document_id', '=', 'd.id')
            ->where('ed.document_group_id', 8)
            ->get();
    }


    public function showDownloadDetails()
    {
        $data =  DB::table('social_records as sr')
            ->select([
                DB::raw('sr.* '),
                DB::raw("CASE WHEN sr.military_service = 1 THEN 'Completed' ELSE 'Didnt Attend' END AS military_service "),
                DB::raw("CASE WHEN sr.marital_status  = 1 THEN 'Married' ELSE 'Single' END AS marital"),
                DB::raw("CASE WHEN sr.gender  = 1 THEN 'Male' ELSE 'Female' END AS genders"),
                DB::raw("CASE WHEN sr.downloaded  = 1 THEN 'Yes' ELSE 'No' END AS downloaded "),
                DB::raw("CASE WHEN sr.uploaded  = 1 THEN 'Yes' ELSE 'No' END AS uploaded "),
                // DB::raw("CASE WHEN sr.surgery_operation  = 1 THEN 'Yes' ELSE 'No' END AS surgery_operation "),

                DB::raw("CASE
                            WHEN sr.progressive_stage = 1 THEN 'Employee Details'
                            WHEN sr.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN sr.progressive_stage = 3 THEN 'Social Record'
                            WHEN sr.progressive_stage = 4 THEN 'Induction Training'
                            WHEN sr.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN sr.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS stage"),

                DB::raw('CONCAT(sr.firstname, \' \', sr.middlename, \' \', sr.lastname) as employee_name'),
                DB::raw('sr."section" as section'),
            DB::raw('dpt.name as department'),
            DB::raw('dt.name as district'),
            DB::raw('rg.name as city'),
            DB::raw('pc.ward_name as ward'),
           DB::raw('CONCAT(pc.ward_name, \' --\',  pc.postcode) as ward'),
            ])
            ->leftJoin('employees as e', 'sr.employee_id', '=', 'e.id')
            ->leftJoin('departments as dpt', 'sr.department_id', '=', 'dpt.id')
            ->leftJoin('districts as dt', 'sr.district_id','=', 'dt.id')
            ->leftJoin('regions as rg', 'sr.city_id', '=', 'rg.id')
            ->leftJoin('postcodes as pc', 'sr.ward_id', '=', 'pc.id')
            ->orderBy('e.id', 'DESC')
            ->get();

        return $data;
    }
    public function getSocialRecord()
    {
        return      DB::table('social_records as sr')
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
                        END AS stage"),
            ])
            ->leftJoin('employees as e', 'sr.employee_id', '=', 'e.id')
            ->where('sr.progressive_stage', 4)
            ->whereIn('e.progressive_stage', [3, 4])
            ->orderBy('sr.updated_at', 'DESC')
            ->get();
    }

    public function getSocialRecordDetail()
    {
        // $social = $this->getSocialRecord();

        // if (!empty($social)) {

        //     return $social;
        // } else {

        return DB::table('employees as e')
            ->select([
                DB::raw('e.* '),
                DB::raw("CASE WHEN e.military_service = 1 THEN 'Completed' ELSE 'Didnt Attend' END AS military_service "),
                DB::raw("CASE WHEN e.marital_status  = 1 THEN 'Married' ELSE 'Single' END AS marital"),
                DB::raw("CASE WHEN e.gender  = 1 THEN 'Male' ELSE 'Female' END AS genders"),
                DB::raw("CASE WHEN e.relative_working  = 1 THEN 'Yes' ELSE 'No' END AS relative_working "),
                DB::raw("CASE WHEN e.chronic_disease  = 1 THEN 'Yes' ELSE 'No' END AS chronic_disease "),
                DB::raw("CASE WHEN e.employed_before  = 1 THEN 'Yes' ELSE 'No' END AS employed_before "),
                DB::raw("CASE WHEN e.downloaded  = 1 THEN 'Yes' ELSE 'No' END AS downloaded "),
                DB::raw("CASE WHEN e.uploaded  = 1 THEN 'Yes' ELSE 'No' END AS uploaded "),
                DB::raw("CASE WHEN e.surgery_operation  = 1 THEN 'Yes' ELSE 'No' END AS surgery_operation "),
                DB::raw("CASE
                            WHEN e.driving_licence = 1 THEN 'Light'
                            WHEN e.driving_licence = 2 THEN 'Heavy'
                            WHEN e.driving_licence = 3 THEN 'Equipment'
                            ELSE 'None'
                        END AS driving"),
                DB::raw("CASE
                            WHEN e.progressive_stage = 1 THEN 'Employee Details'
                            WHEN e.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN e.progressive_stage = 3 THEN 'Social Record'
                            WHEN e.progressive_stage = 4 THEN 'Induction Training'
                            WHEN e.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN e.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS stage"),
                DB::raw('e.surgery_remark '),
                DB::raw('jt.name as job_title'),
                DB::raw('jt.name as recommended_title'),
                DB::raw('cc.name as cost_center'),
                DB::raw('c.description as nationality'),
                DB::raw('CONCAT(e.firstname, \' \', e.middlename, \' \', e.lastname) as employee_name'),
                // DB::raw('sr.*'),
            ])
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('cost_centers as cc', 'e.cost_center_id', '=', 'cc.id')
            ->leftJoin('users as u', 'u.employer_id', '=', 'e.id')
            ->leftJoin('countries as c', 'e.nationality_id', '=', 'c.id')
            ->leftJoin('social_records as sr', 'sr.employee_id', '=', 'e.id')
            ->whereIn('e.progressive_stage', [3, 4])
            ->orderBy('e.id', 'DESC')
            ->get();
    }

    //  public function getSocialRecord()
    // {
    //     return DB::table('social_records as sr')
    //         ->select([
    //             'sr.*',
    //             DB::raw('CONCAT(sr.firstname, \' \', sr.middlename, \' \', sr.lastname) as employee_name'),
    //             DB::raw("CASE
    //                         WHEN sr.progressive_stage = 1 THEN 'Employee Details'
    //                         WHEN sr.progressive_stage = 2 THEN 'Supportive Document'
    //                         WHEN sr.progressive_stage = 3 THEN 'Social Record'
    //                         WHEN sr.progressive_stage = 4 THEN 'Induction Training'
    //                         WHEN sr.progressive_stage = 5 THEN 'Contract Processing'
    //                         WHEN sr.progressive_stage = 6 THEN 'Person ID'
    //                         ELSE 'Registration Completed'
    //                     END AS stage"),
    //         ])
    //         ->leftJoin('employees as e', 'sr.employee_id', '=', 'e.id') // Fixed the join condition
    //         ->whereIn('sr.progressive_stage', [3, 4])
    //         ->whereIn('e.progressive_stage', [3, 4])
    //         ->orderBy('sr.updated_at', 'DESC')
    //         ->get();
    // }

    // public function getSocialRecordDetail()
    // {
    //    return  DB::table('social_records as sr')
    //         ->select([
    //             'sr.*',
    //             'e.*',
    //             DB::raw('jt.name as job_title'),
    //             DB::raw('cc.name as cost_center'),
    //             DB::raw('c.description as nationality'),
    //             DB::raw('CONCAT(e.firstname, \' \', e.middlename, \' \', e.lastname) as employee_name'),
    //             DB::raw("CASE
    //                     WHEN e.military_service = 1 THEN 'Completed'
    //                     ELSE 'Didn\`t Attend'
    //                 END AS military_service"),
    //             // ... Add other CASE statements for additional fields
    //         ])
    //         ->leftJoin('employees as e', 'sr.employee_id', '=', 'e.id')
    //         ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
    //         ->leftJoin('cost_centers as cc', 'e.cost_center_id', '=', 'cc.id')
    //         ->leftJoin('countries as c', 'e.nationality_id', '=', 'c.id')
    //         ->whereIn('e.progressive_stage', [3, 4])
    //         ->orWhereIn('sr.progressive_stage', [3, 4])
    //         ->orderBy('e.id', 'DESC')
    //         ->get();
    // }


}
