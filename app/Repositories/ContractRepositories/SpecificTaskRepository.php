<?php

namespace App\Repositories\ContractRepositories;


use Exception;
use Mpdf\Mpdf;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use App\Models\Employee\Personal\Employee;
use App\Models\ContractManagement\SpecificTask;
use App\Models\ContractManagement\FixedContract;
use App\Models\ContractManagement\ContractDocument;

class SpecificTaskRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;

    const MODEL = SpecificTask::class;


    protected $specific_task;

    public function __construct(SpecificTask $specific_task)
    {
        $this->specific_task = $specific_task;
    }
    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */

    public function addFixedContract($request)
    {
        // log::info($request->all());

        // die;

        DB::beginTransaction();


        try {
            $input = $request->all();


            SpecificTask::create([
                'name' => !empty($input['name']) ? $input['name'] : null,
                'employee_name' => !empty($input['employee_name']) ? $input['employee_name'] : null,
                'employer_name' => !empty($input['employer_name']) ? $input['employer_name'] : null,
                'employee_id' => !empty($input['employee_id']) ? $input['employee_id'] : null,
                'reg_number' => !empty($input['reg_number']) ? $input['reg_number'] : null,
                'dob' => !empty($input['dob']) ? $input['dob'] : null,
                'bank_name' => !empty($input['bank_name']) ? $input['bank_name'] : 0,
                'bank_account_no' => !empty($input['bank_account_no']) ? $input['bank_account_no'] : 0,
                'bank_account_name' => !empty($input['bank_account_name']) ? $input['bank_account_name'] : 0,
                'night_shift' => !empty($input['night_shift']) ? $input['night_shift'] : 'No',
                'night_working_from' => !empty($input['night_working_from']) ? $input['night_working_from'] : 0,
                'night_working_to' => !empty($input['night_working_to']) ? $input['night_working_to'] : 0,
                'night_shift_hours' => !empty($input['night_shift_hours']) ? $input['night_shift_hours'] : 0,
                'expected_end_date' => !empty($input['expected_end_date']) ? $input['expected_end_date']  : null,
                'basic_salary' => !empty($input['basic_salary']) ? $input['basic_salary'] : null,
                'monthly_salary' => !empty($input['monthly_salary']) ? $input['monthly_salary'] : 1,
                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                'department_id' => !empty($input['department_id']) ? $input['department_id'] : null,
                'email' => !empty($input['email']) ? $input['email'] : null,
                'nssf_number' => !empty($input['nssf_number']) ? $input['nssf_number'] : 2,
                'phone_number' => !empty($input['phone_number']) ? $input['phone_number'] : null,
                'place_recruitment' => !empty($input['place_recruitment']) ? $input['place_recruitment'] : null,
                'work_station' => !empty($input['work_station']) ? $input['work_station'] : null,
                'supervisor' => !empty($input['supervisor']) ? $input['supervisor'] : null,
                'gender' => !empty($input['gender']) ? $input['gender'] : 'Male',
                'residence_place' => !empty($input['residence_place']) ? $input['residence_place'] : null,
                'place_recruitment' => !empty($input['place_recruitment']) ? $input['place_recruitment'] : null,
                'start_date' => !empty($input['start_date']) ? $input['start_date'] : null,
                'normal_working' => !empty($input['normal_working']) ? $input['normal_working'] : null,
                'house_allowance' => !empty($input['house_allowance']) ? $input['house_allowance'] : null,
                'meal_allowance' => !empty($input['meal_allowance']) ? $input['meal_allowance'] : null,
                'transport_allowance' => !empty($input['transport_allowance']) ? $input['transport_allowance'] : null,
                'risk_bush_allowance' => !empty($input['risk_bush_allowance']) ? $input['risk_bush_allowance'] : null,
                'ordinary_working' => !empty($input['ordinary_working']) ? $input['ordinary_working'] : null,
                'working_from' => !empty($input['working_from']) ? $input['working_from'] : null,
                'working_to' => !empty($input['working_to']) ? $input['working_to'] : null,
                'saturday_from' => !empty($input['saturday_from']) ? $input['saturday_from'] : null,
                'saturday_to' => !empty($input['saturday_to']) ? $input['saturday_to'] : null,
                'downloaded' => !empty($input['downloaded']) ? $input['downloaded'] : null,
                'uploaded_date' => !empty($input['uploaded_date']) ? $input['uploaded_date'] : null,
                'stage' => 0,
                'progressive_stage' => 5,
                'status' => 0,

            ]);
            // Log::info('vita iendeleee');
            $employee_id = $input['employee_id'];
            $this->saveSpecificContractDocument($request, $employee_id);
            DB::commit();

            Log::info('Saved done');
            return response()->json(['message' => 'Specific Task Contract  successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create specific Contract ', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create specific Contract ', 'status' => 500]);
        }
    }
    public function updatePersonaDetail($employee_id)
    {
        return  Employee::where('id', $employee_id)->update(['progressive_stage' => '4']);
    }

    public function getLastSocialRecord()
    {
        return $this->specific_task->select('*')->latest()->first();
    }
    /**
     *@method to save Contract Details attachment

     */
    public function saveSpecificContractDocument($request, $employee_id)
    {

        // die;
        DB::beginTransaction();

        try {

            $documents = [];

            $documentTypes = ['job_description_doc', 'specific_contract_signed'];


            foreach ($documentTypes as $documentType) {

                if ($request->hasFile($documentType) && $employee_id && $request->name) {
                    $files = $request->file($documentType);


                    foreach ($files as $file) {
                        // Handle each file individually
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('contracts/specific/' . $employee_id), $fileName);

                        // Add file details to $documents array
                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType),
                            'description' => $fileName,
                            'document_group_id' => 11,
                            'employee_id' => $employee_id,
                            'contract_name' => $request->name,
                        ];
                        // dump('hellow');
                    }
                }
            }
            //   log::info('documents: ' . json_encode($documents));

            // Initialize $uploaded as an empty array before the loop

            foreach ($documents as $document) {

                ContractDocument::create($document); // Append the created document to $uploaded
            }

            // log::info('huree', $uploaded); // Now $uploaded contains all the created documents


            DB::commit();

            Log::info('Saved contract details document ');
            return response()->json(['message' => 'Document created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save contract details document', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save  contract details document', 'status' => 500]);
        }
    }

    public function getDocumentId($documentId)
    {
        // $document_id = [43,44]; required document
        //  $documentTypes = ['job_description_doc','fixed_contract_signed','passport_doc','nida_doc','technical_signed_doc'];
        switch ($documentId) {

            case 'job_description_doc';
                return 43;
                break;
            case 'specific_contract_signed';
                return 46;
                break;
            default:
                return null;
        }
    }
    /**
     * Method to Update assessed Candidate details
     */
    public function updateSpecificContract($request, $id)
    {
        //   log::info($request->all());
        DB::beginTransaction();


        try {
            $input = $request->all();
            //    log::info($input);
            SpecificTask::where('employee_id', $id)->update([

                'name' => !empty($input['name']) ? $input['name'] : null,
                'employee_name' => !empty($input['employee_name']) ? $input['employee_name'] : null,
                'employer_name' => !empty($input['employer_name']) ? $input['employer_name'] : null,
                'employee_id' => !empty($input['employee_id']) ? $input['employee_id'] : null,
                'reg_number' => !empty($input['reg_number']) ? $input['reg_number'] : null,
                'dob' => !empty($input['dob']) ? $input['dob'] : null,
                'bank_name' => !empty($input['bank_name']) ? $input['bank_name'] : 0,
                'bank_account_no' => !empty($input['bank_account_no']) ? $input['bank_account_no'] : 0,
                'bank_account_name' => !empty($input['bank_account_name']) ? $input['bank_account_name'] : 0,
                'night_shift' => !empty($input['night_shift']) ? $input['night_shift'] : 'No',
                'night_working_from' => !empty($input['night_working_from']) ? $input['night_working_from'] : 0,
                'night_working_to' => !empty($input['night_working_to']) ? $input['night_working_to'] : 0,
                'working_to' => !empty($input['working_to']) ? $input['working_to'] : 0,
                'night_shift_hours' => !empty($input['night_shift_hours']) ? $input['night_shift_hours'] : 0,
                'expected_end_date' => !empty($input['expected_end_date']) ? $input['expected_end_date']  : null,
                'basic_salary' => !empty($input['basic_salary']) ? $input['basic_salary'] : null,
                'monthly_salary' => !empty($input['monthly_salary']) ? $input['monthly_salary'] : 1,
                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                'department_id' => !empty($input['department_id']) ? $input['department_id'] : null,
                'email' => !empty($input['email']) ? $input['email'] : null,
                'nssf_number' => !empty($input['nssf_number']) ? $input['nssf_number'] : 2,
                'phone_number' => !empty($input['phone_number']) ? $input['phone_number'] : null,
                'place_recruitment' => !empty($input['place_recruitment']) ? $input['place_recruitment'] : null,
                'work_station' => !empty($input['work_station']) ? $input['work_station'] : null,
                'supervisor' => !empty($input['supervisor']) ? $input['supervisor'] : null,
                'gender' => !empty($input['gender']) ? $input['gender'] : 'Male',
                'residence_place' => !empty($input['residence_place']) ? $input['residence_place'] : null,
                'place_recruitment' => !empty($input['place_recruitment']) ? $input['place_recruitment'] : null,
                'start_date' => !empty($input['start_date']) ? $input['start_date'] : null,
                'normal_working' => !empty($input['normal_working']) ? $input['normal_working'] : null,
                'house_allowance' => !empty($input['house_allowance']) ? $input['house_allowance'] : null,
                'meal_allowance' => !empty($input['meal_allowance']) ? $input['meal_allowance'] : null,
                'transport_allowance' => !empty($input['transport_allowance']) ? $input['transport_allowance'] : null,
                'risk_bush_allowance' => !empty($input['risk_bush_allowance']) ? $input['risk_bush_allowance'] : null,
                'ordinary_working' => !empty($input['ordinary_working']) ? $input['ordinary_working'] : null,
                'working_from' => !empty($input['working_from']) ? $input['working_from'] : null,
                'saturday_from' => !empty($input['saturday_from']) ? $input['saturday_from'] : null,
                'saturday_to' => !empty($input['saturday_to']) ? $input['saturday_to'] : null,
                'downloaded' => !empty($input['downloaded']) ? $input['downloaded'] : null,
                'uploaded_date' => !empty($input['uploaded_date']) ? $input['uploaded_date'] : null,
                'stage' => 0,
                'progressive_stage' => 5,
                'status' => 0,

            ]);

            $this->saveSpecificContractDocument($request, $id);


            DB::commit();
            Log::info('updated done');

            return response()->json(['message' => 'Specific Task Contract Updated successfully', 'status' => 200], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update specific contract', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to Update  specific contract', 'status' => 500]);
        }
    }


    /**
     * Method to fetch Employee person Details
     */
    public function getSpecificContractDoc($id)
    {

        return  DB::table('contract_documents as cds')
            ->select('cds.id', 'cds.employee_id', 'cds.contract_name', 'cds.document_id', 'cds.description', 'cds.updated_at as doc_modified', 'd.name as doc_name')
            ->leftJoin('documents as d', 'cds.document_id', '=', 'd.id')
            // ->where('cds.document_group_id', 8)
            ->whereIn('cds.document_id', [43, 44, 45])
            ->where('employee_id', $id)
            ->get();
    }


    public function showDownloadSpecific($id)
    {
        $data =  DB::table('contract_specific as csc')
            ->select([
                DB::raw('csc.* '),
                DB::raw("CASE
                            WHEN csc.progressive_stage = 1 THEN 'Employee Details'
                            WHEN csc.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN csc.progressive_stage = 3 THEN 'Social Record'
                            WHEN csc.progressive_stage = 4 THEN 'Induction Training'
                            WHEN csc.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN csc.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS progressive"),
                // DB::raw('CONCAT(e.firstname, \' \', e.middlename, \' \', e.lastname) as employee_name'),
                DB::raw('e.employee_no as employee'),
                DB::raw('jt.name as job_title'),
                DB::raw('dpt.name as department'),
            ])
            ->leftJoin('employees as e', 'csc.employee_id', '=', 'e.id')
            ->leftJoin('job_title as jt', 'csc.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'csc.department_id', '=', 'dpt.id')
            ->where('csc.employee_id', $id)
            ->first();

        return $data;
    }


    public function getSpecificTaskContract()
    {
        // log::info('hellow');

        return DB::table('contract_details as cd')
            ->select([
                DB::raw('cd.* '),
                // employee number from employees table (human-readable number like 9023)
                DB::raw('e.employee_no as employee_number'),
                // foreign key to employees table
                DB::raw('cd.employee_id as employee_db_id'),
                DB::raw("CASE
                            WHEN cd.progressive_stage = 1 THEN 'Employee Details'
                            WHEN cd.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN cd.progressive_stage = 3 THEN 'Social Record'
                            WHEN cd.progressive_stage = 4 THEN 'Induction Training'
                            WHEN cd.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN cd.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS progressive"),
                DB::raw('CONCAT(cd.firstname, \' \', cd.middlename, \' \', cd.lastname) as employee_name'),
                // DB::raw('e.dob'),
                // DB::raw('e.employee_no as employee'),
                DB::raw('sr.person_email as email'),
                DB::raw('sr.mobile_number as phone_number'),
                DB::raw('sr.postal_address'),
                DB::raw('sr.postal_address'),
                DB::raw('cd.stage'),
                DB::raw('csc.stage as stages'),
                DB::raw("CASE
                            WHEN sr.gender = 1 THEN 'Male'
                            ELSE 'Female'
                        END AS gender"),
                // department & job title from their master tables
                DB::raw('dpt.name as department_name'),
                DB::raw('jt.name as job_title'),
                DB::raw('CONCAT(cd.firstname, \' \', cd.middlename, \' \', cd.lastname) as contract_employee'),
                DB::raw('cd.created_at as contract_created'),
                DB::raw('emp.name as employer'),

            ])

            ->leftJoin('employees as e', 'cd.employee_id', '=', 'e.id')
            ->leftJoin('departments as dpt', 'e.department_id', '=', 'dpt.id')
            ->leftJoin('social_records as sr', 'sr.employee_id', '=', 'cd.employee_id')
            ->leftJoin('job_title as jt', 'cd.job_title_id', '=', 'jt.id')
            ->leftJoin('contract_fixed as cf', 'cf.employee_id', '=', 'cd.employee_id')
            ->leftJoin('contract_specific as csc', 'csc.employee_id', '=', 'cd.employee_id')
            ->leftJoin('employers as emp', 'cd.employer_id', '=', 'emp.id')
            ->where('cd.progressive_stage', '>=', 5)
            ->where('cd.contract_id', 2)
            ->orderBy('cd.id', 'DESC')
            ->get();
    }
    public function specificDatatable($id)
    {

        return DB::table('contract_details as cd')
            ->select([
                DB::raw('cd.*'),
                DB::raw("CASE
                            WHEN cd.progressive_stage = 1 THEN 'Employee Details'
                            WHEN cd.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN cd.progressive_stage = 3 THEN 'Social Record'
                            WHEN cd.progressive_stage = 4 THEN 'Induction Training'
                            WHEN cd.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN cd.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS progressive"),
                DB::raw('CONCAT(cd.firstname, \' \', cd.middlename, \' \', cd.lastname) as employee_name'),
                DB::raw("CASE
                            WHEN cd.gender = 1 THEN 'Male'
                            ELSE 'Female'
                        END AS gender"),
                DB::raw('cd.created_at as contract_created'),
                DB::raw('cd.date_employed as commencement_date'),
                DB::raw('e.nssf as nssf_number'),
                DB::raw('e.employee_no as reg_number'),
                DB::raw('e.account_number as bank_account_no'),
                DB::raw('e.account_name as bank_account_name'),
                DB::raw('dpt.name as department'),
                DB::raw('emp.name as employer_name'),
                DB::raw('jt.name as job_title'),
                DB::raw('c.name as name'),
            ])
            ->leftJoin('employees as e', 'cd.employee_id', '=', 'e.id')
            ->leftJoin('job_title as jt', 'cd.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', '=', 'dpt.id')
            ->leftJoin('employers as emp', 'cd.employer_id', '=', 'emp.id')
            ->leftJoin('contracts as c', 'cd.contract_id', '=', 'c.id')
            ->where('cd.employee_id', $id)
            ->first();
    }


    public function updateStageData($specific_contracts)
    {
        // log::info($specific_contracts);
        // Log::info('magugu');
        if (!empty($specific_contracts)) {
            SpecificTask::where('employee_id', $specific_contracts->employee_id)->update(['stage' => 1, 'progressive_stage' => 6]);
            DB::table('induction_training')->where('employee_id', $specific_contracts->employee_id)->update(['stage' => 1, 'progressive_stage' => 6]);
        }
    }
    /**
     *@method to update table when the specific document have signed
     */
    public function  checkSignedSpecificDocUploaded($id)
    {

        $uploaded = DB::table('contract_documents')
            ->select('*')->where('employee_id', $id)
            ->where('document_id', 46)
            ->latest()
           ->first();

        // log::info($uploaded);
        if (isset($uploaded)) {
            $return =   SpecificTask::where('employee_id', $id)->update(['uploaded' => 1, 'uploaded_date' => $uploaded->created_at]);
            //  log::info('hureee');
        } else {
            $return = [
                'status' => 500,
                'message' => "Sorry no Document uploaded",
            ];
        }
        return $return;
    }
 public function previewSpecificTaskContract($id)
{

  $data =  DB::table('contract_specific as csc')
            ->select([
                DB::raw('csc.* '),
                DB::raw("CASE
                            WHEN csc.progressive_stage = 1 THEN 'Employee Details'
                            WHEN csc.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN csc.progressive_stage = 3 THEN 'Social Record'
                            WHEN csc.progressive_stage = 4 THEN 'Induction Training'
                            WHEN csc.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN csc.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS progressive"),
                // DB::raw('CONCAT(e.firstname, \' \', e.middlename, \' \', e.lastname) as employee_name'),
                DB::raw('e.employee_no as employee'),
                DB::raw('jt.name as job_title'),
                DB::raw('dpt.name as department'),
            ])
            ->leftJoin('employees as e', 'csc.employee_id', '=', 'e.id')
            ->leftJoin('job_title as jt', 'csc.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'csc.department_id', '=', 'dpt.id')
            ->where('csc.employee_id', $id)
            ->first();

           if (isset($data)) {
         $mpdf = new Mpdf();
        $mpdf->SetTitle('Specific Task Contract');
        $sheet = view('ContractTemplate.specific_contract', [
            'data' => $data,
               ]);
        $mpdf->WriteHTML($sheet);
        $reviews = base64_encode($mpdf->Output('', 'S'));

        return $reviews;

        }

        return $data;

}

}
