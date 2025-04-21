<?php

namespace App\Repositories\ContractRepositories;


use Exception;
use Mpdf\Mpdf;
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
use App\Models\ContractManagement\FixedContract;
use App\Models\ContractManagement\ContractDetail;
use App\Models\Employee\Personal\EmployeeDocument;
use App\Models\ContractManagement\ContractDocument;
use App\Models\Employee\Personal\EmployeeEducation;
use App\Models\Employee\Personal\EmploymentHistory;
use App\Models\Hiring\Interview\CompetencyInterDoc;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Models\Employee\Personal\EmploymentReference;
use App\Models\Hiring\Interview\CompetencyTransaction;
use App\Models\Hiring\JobApplication\JobDescTransaction;
use App\Models\Employee\Application\PersonnelApplication;




class FixedContractRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = FixedContract::class;


    protected $fixed_contract;


    public function __construct(FixedContract $fixed_contract)
    {
        $this->fixed_contract = $fixed_contract;
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

        $commencement = $request->commencement_date;

        // Create a DateTime object from the commencement date string
        $commencement_date = new \DateTime($commencement);

        // Clone the commencement date to avoid modifying the original object
        $currentDate = clone $commencement_date;

        // Modify the current date to add one year
        $end_commencement = $currentDate->modify('+1 year');

        // Format the end commencement date as needed
        $end_commencement = $end_commencement->format('Y-m-d');

        // Now $end_commencement_formatted contains the end date of the commencement period




        try {
            $input = $request->all();

            // log::info('data' . $end_commencement);
            FixedContract::create([
                'name' => !empty($input['name']) ? $input['name'] : null,
                'employee_name' => !empty($input['employee_name']) ? $input['employee_name'] : null,
                'employer_name' => !empty($input['employer_name']) ? $input['employer_name'] : null,
                'employee_id' => !empty($input['employee_id']) ? $input['employee_id'] : null,
                'dob' => !empty($input['dob']) ? $input['dob'] : null,
                'end_commencement_date' => isset($end_commencement) ? $end_commencement  : null,
                'basic_salary' => !empty($input['basic_salary']) ? $input['basic_salary'] : null,
                'remuneration' => !empty($input['remuneration']) ? $input['remuneration'] : 1,
                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                'probation_period' => !empty($input['probation_period']) ? $input['probation_period'] : null,
                'email' => !empty($input['email']) ? $input['email'] : null,
                'covered_statutory' => !empty($input['covered_statutory']) ? $input['covered_statutory'] : 2,
                'phone_number' => !empty($input['phone_number']) ? $input['phone_number'] : null,
                'place_recruitment' => !empty($input['place_recruitment']) ? $input['place_recruitment'] : null,
                'work_station' => !empty($input['work_station']) ? $input['work_station'] : null,
                'reporting_to' => !empty($input['reporting_to']) ? $input['reporting_to'] : null,
                'job_profile' => !empty($input['job_profile']) ? $input['job_profile'] : null,
                'staff_classfication' => !empty($input['staff_classfication']) ? $input['staff_classfication'] : null,
                'place_recruitment' => !empty($input['place_recruitment']) ? $input['place_recruitment'] : null,
                'commencement_date' => !empty($input['commencement_date']) ? $input['commencement_date'] : null,
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
                // 'date_employed' => !empty($input['date_employed']) ? $input['date_employed'] : 0,
                'uploaded_date' => !empty($input['uploaded_date']) ? $input['uploaded_date'] : null,
                'stage' => 0,
                'progressive_stage' => 5,
                'status' => 0,

            ]);
            // Log::info('vita iendeleee');
            $employee_id = $input['employee_id'];
            $this->saveFixedContractDocument($request, $employee_id);
            DB::commit();

            Log::info('Saved done');
            return response()->json(['message' => 'Fixed Contract  successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create fixed Contract ', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create fixed Contract ', 'status' => 500]);
        }
    }
    public function updatePersonaDetail($employee_id)
    {
        return  Employee::where('id', $employee_id)->update(['progressive_stage' => '4']);
    }

    public function getLastSocialRecord()
    {
        return $this->fixed_contract->select('*')->latest()->first();
    }

    /**
     *@method to save Contract Details attachment

     */
    public function saveFixedContractDocument($request, $employee_id)
    {
        // Log::info($request->all());
        //  log::info($employee_id);
        // die;
        DB::beginTransaction();

        try {

            $documents = [];

            $documentTypes = ['job_description_doc', 'fixed_contract_signed'];

            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType) && $employee_id && $request->name) {
                    $files = $request->file($documentType);


                    foreach ($files as $file) {
                        //  log::info('HELLOW', $file);  //next time i want to add id of employer  as pass to reach interview candidate document
                        //   log::info($employee_id);
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('contracts/fixed/' . $employee_id), $fileName);
                        // log::info('hureee'. json_encode($fileName));
                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType), // Implement a function to get the document ID based on the type
                            'description' => $fileName,
                            'document_group_id' => 11,
                            'employee_id' => $employee_id,
                            'contract_name' => $request->name,
                        ];
                        // dump('hellow');
                    }
                }
            }
            // log::info('document:'. ' '. $documents);
            // Initialize $uploaded as an empty array before the loop

            foreach ($documents as $document) {
                // log::info('document: ******************');
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
            case 'fixed_contract_signed';
                return 45;
                break;
            default:
                return null;
        }
    }
    /**
     * Method to Update assessed Candidate details
     */
    public function updateFixedContract($request, $id)
    {
        //   log::info($request->all());
        DB::beginTransaction();

        $commencement = $request->commencement_date;

        // Create a DateTime object from the commencement date string
        $commencement_date = new \DateTime($commencement);

        // Clone the commencement date to avoid modifying the original object
        $currentDate = clone $commencement_date;
        // Modify the current date to add one year
        $end_commencement = $currentDate->modify('+1 year');

        // Format the end commencement date as needed
        $end_commencement = $end_commencement->format('Y-m-d');

        try {
            $input = $request->all();
            //    log::info($input);
            FixedContract::where('employee_id', $id)->update([
                'name' => !empty($input['name']) ? $input['name'] : null,
                'employee_name' => !empty($input['employee_name']) ? $input['employee_name'] : null,
                'employer_name' => !empty($input['employer_name']) ? $input['employer_name'] : null,
                'employee_id' => !empty($input['employee_id']) ? $input['employee_id'] : null,
                'dob' => !empty($input['dob']) ? $input['dob'] : null,
                'end_commencement_date' => isset($end_commencement) ? $end_commencement  : null,
                'basic_salary' => !empty($input['basic_salary']) ? $input['basic_salary'] : null,
                'remuneration' => !empty($input['remuneration']) ? $input['remuneration'] : 1,
                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                'probation_period' => !empty($input['probation_period']) ? $input['probation_period'] : null,
                'email' => !empty($input['email']) ? $input['email'] : null,
                'covered_statutory' => !empty($input['covered_statutory']) ? $input['covered_statutory'] : 2,
                'phone_number' => !empty($input['phone_number']) ? $input['phone_number'] : null,
                'place_recruitment' => !empty($input['place_recruitment']) ? $input['place_recruitment'] : null,
                'work_station' => !empty($input['work_station']) ? $input['work_station'] : null,
                'reporting_to' => !empty($input['reporting_to']) ? $input['reporting_to'] : null,
                'job_profile' => !empty($input['job_profile']) ? $input['job_profile'] : null,
                'staff_classfication' => !empty($input['staff_classfication']) ? $input['staff_classfication'] : null,
                'place_recruitment' => !empty($input['place_recruitment']) ? $input['place_recruitment'] : null,
                'commencement_date' => !empty($input['commencement_date']) ? $input['commencement_date'] : null,
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

            $this->saveFixedContractDocument($request, $id);

            DB::commit();
            Log::info('updated done');

            return response()->json(['message' => 'Fixed Contract Updated successfully', 'status' => 200], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update fixed contract', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to Update  fixed contract', 'status' => 500]);
        }
    }


    /**
     * Method to fetch Employee person Details
     */
    public function getFixedContractDoc()
    {

        return  DB::table('contract_documents as cds')
            ->select('cds.id', 'cds.employee_id', 'cds.contract_name', 'cds.document_id', 'cds.description', 'cds.updated_at as doc_modified', 'd.name as doc_name')
            ->leftJoin('documents as d', 'cds.document_id', '=', 'd.id')
            // ->where('cds.document_group_id', 8)
            ->whereIn('cds.document_id', [43, 44, 45])
            ->get();
    }


    public function showDownloadFixed($id)
    {
        $data =  DB::table('contract_fixed as cf')
            ->select([
                DB::raw('cf.* '),
                DB::raw("CASE
                            WHEN cf.progressive_stage = 1 THEN 'Employee Details'
                            WHEN cf.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN cf.progressive_stage = 3 THEN 'Social Record'
                            WHEN cf.progressive_stage = 4 THEN 'Induction Training'
                            WHEN cf.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN cf.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS progressive"),
                // DB::raw('CONCAT(e.firstname, \' \', e.middlename, \' \', e.lastname) as employee_name'),
                DB::raw('e.employee_no as employee'),
                DB::raw('jt.name as job_title'),
            ])
            ->leftJoin('employees as e', 'cf.employee_id', '=', 'e.id')
            ->leftJoin('job_title as jt', 'cf.job_title_id', '=', 'jt.id')
            ->where('employee_id', $id)
            ->first();

        return $data;
    }


    public function getFixedContractDetails()
    {

        return DB::table('contract_details as cd')
            ->select([
                DB::raw('cd.* '),
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
                DB::raw("CASE
                            WHEN sr.gender = 1 THEN 'Male'
                            ELSE 'Female'
                        END AS gender"),
                DB::raw('cf.stage as stages'),
                DB::raw('CONCAT(cd.firstname, \' \', cd.middlename, \' \', cd.lastname) as contract_employee'),
                DB::raw('cd.created_at as contract_created'),
                DB::raw('emp.name as employer'),

            ])

            ->leftJoin('employees as e', 'cd.employee_id', '=', 'e.id')
            ->leftJoin('social_records as sr', 'sr.employee_id', '=', 'cd.employee_id')
            ->leftJoin('job_title as jt', 'cd.job_title_id', '=', 'jt.id')
            ->leftJoin('contract_fixed as cf', 'cf.employee_id', '=', 'cd.employee_id')
            // ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('employers as emp', 'cd.employer_id', '=', 'emp.id')
            ->where('cd.progressive_stage', '>=', 5)
            ->where('cd.contract_id', 1)
            ->orderBy('cd.id', 'DESC')
            ->get();
    }
    public function fixedDatatable($id)
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
                DB::raw('emp.name as employer_name'),
                DB::raw('jt.name as job_title'),
                DB::raw('c.name as name'),
            ])
            ->leftJoin('employees as e', 'cd.employee_id', '=', 'e.id')
            ->leftJoin('job_title as jt', 'cd.job_title_id', '=', 'jt.id')
            ->leftJoin('employers as emp', 'cd.employer_id', '=', 'emp.id')
            ->leftJoin('contracts as c', 'cd.contract_id', '=', 'c.id')
            ->where('cd.employee_id', $id)
            ->first();
    }


    public function updateStageData($fixed_contracts)
    {

        //    log::info('data'.$fixed_contracts);


        if (!empty($fixed_contracts)) {
            FixedContract::where('id', $fixed_contracts->id)->update(['stage' => 1, 'progressive_stage' => 6]);
            DB::table('induction_training')->where('employee_id', $fixed_contracts->employee_id)->update(['stage' => 1, 'progressive_stage' => 6]);
        }
    }
    /**
     *@method to update table when the fixed document have signed
     */
    public function checkSignedFixed($id) {}
    /**
     *@preview fixed contract into pdf
     */
    public function previewFixedTermContract($id)
    {

        $data =  DB::table('contract_fixed as cf')
            ->select([
                DB::raw('cf.employee_id as reg_number'),
                'cf.employer_name',
                'cf.employee_name',
                'cf.job_title_id',
                'cf.phone_number',
                'cf.email',
                'cf.dob',
                'cf.job_profile',
                'cf.reporting_to',
                'cf.staff_classfication',
                'cf.place_recruitment',
                'cf.work_station',
                'cf.commencement_date',
                'cf.end_commencement_date',
                'cf.probation_period',
                'cf.remuneration',
                'cf.basic_salary',
                'cf.house_allowance',
                'cf.meal_allowance',
                'cf.transport_allowance',
                'cf.risk_bush_allowance',
                'cf.normal_working',
                'cf.ordinary_working',
                'cf.working_from',
                'cf.working_to',
                'cf.saturday_from',
                'cf.saturday_to',
                'cf.covered_statutory',
                'cf.downloaded',
                'cf.uploaded',
                'cf.uploaded_date',
                'cf.stage',
                'cf.status',
                'cf.created_at',
                'cf.updated_at',
                'cf.deleted_at',
                DB::raw("CASE
                            WHEN cf.progressive_stage = 1 THEN 'Employee Details'
                            WHEN cf.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN cf.progressive_stage = 3 THEN 'Social Record'
                            WHEN cf.progressive_stage = 4 THEN 'Induction Training'
                            WHEN cf.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN cf.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS progressive"),
                // DB::raw('CONCAT(e.firstname, \' \', e.middlename, \' \', e.lastname) as employee_name'),
                DB::raw('e.employee_no as employee'),
                DB::raw('jt.name as job_title'),
            ])
            ->leftJoin('employees as e', 'cf.employee_id', '=', 'e.id')
            ->leftJoin('job_title as jt', 'cf.job_title_id', '=', 'jt.id')
            ->where('cf.employee_id', $id)
            ->first();

        if (isset($data)) {
            $mpdf = new Mpdf();
            $mpdf->SetTitle('Fixed Term Contract');
            $sheet = view('ContractTemplate.fixed_contract', [
                'data' => $data,
            ]);
            $mpdf->WriteHTML($sheet);
            $reviews = base64_encode($mpdf->Output('', 'S'));

            return $reviews;
        }

        return $data;
    }
}
