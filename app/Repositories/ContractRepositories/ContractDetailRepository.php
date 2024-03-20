<?php

namespace App\Repositories\ContractRepositories;


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




class ContractDetailRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = ContractDetail::class;


    protected $contract_detail;


    public function __construct(ContractDetail $contract_detail)
    {
        $this->contract_detail = $contract_detail;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */

    public function addContractDetail($request)
    {
        // log::info($request->all());



        DB::beginTransaction();

        $dobString = $request->dob;

        // Create a DateTime object from the DOB string
        $dob = new \DateTime($dobString);

        // Get the current date
        $currentDate = new \DateTime();

        // Calculate the difference between the current date and the DOB
        $ageInterval = $currentDate->diff($dob);

        // Get the years part of the interval
        $age = $ageInterval->y;



        try {
            $input = $request->all();


            // log::info('data' . $employee_no);
            ContractDetail::create([
                'firstname' => !empty($input['firstname']) ? $input['firstname'] : null,
                'middlename' => !empty($input['middlename']) ? $input['middlename'] : null,
                'lastname' => !empty($input['lastname']) ? $input['lastname'] : null,
                'employee_id' => !empty($input['employee_id']) ? $input['employee_id'] : null,
                'contract_id' => !empty($input['contract_id']) ? $input['contract_id'] : null,
                'birth_place' => !empty($input['birth_place']) ? $input['birth_place'] : null,
                'dob' => !empty($input['dob']) ? $input['dob'] : null,
                'age' => isset($age) ? $age  : null,
                'gender' => !empty($input['gender']) ? $input['gender'] : null,
                'residence_place' => !empty($input['residence_place']) ? $input['residence_place'] : 1,
                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                'permanent_residence' => !empty($input['permanent_residence']) ? $input['permanent_residence'] : null,
                'email' => !empty($input['email']) ? $input['email'] : null,
                'postal_address' => !empty($input['postal_address']) ? $input['postal_address'] : 2,
                'phone_number' => !empty($input['phone_number']) ? $input['phone_number'] : null,
                'place_recruitment' => !empty($input['place_recruitment']) ? $input['place_recruitment'] : null,
                'work_station' => !empty($input['work_station']) ? $input['work_station'] : null,
                'employer_id' => !empty($input['employer_id']) ? $input['employer_id'] : null,
                'fullname_next1' => !empty($input['fullname_next1']) ? $input['fullname_next1'] : $input['firstname'],
                'residence1' => !empty($input['residence1']) ? $input['residence1'] : null,
                'phone_number1' => !empty($input['phone_number1']) ? $input['phone_number1'] : null,
                'relationship1' => !empty($input['relationship1']) ? $input['relationship1'] : null,
                'fullname_next2' => !empty($input['fullname_next2']) ? $input['fullname_next2'] : $input['firstname'],
                'residence2' => !empty($input['residence2']) ? $input['residence2'] : null,
                'phone_number2' => !empty($input['phone_number2']) ? $input['phone_number2'] : null,
                'relationship2' => !empty($input['relationship2']) ? $input['relationship2'] : null,
                'downloaded' => !empty($input['downloaded']) ? $input['downloaded'] : null,
                'date_employed' => !empty($input['date_employed']) ? $input['date_employed'] : 0,
                'uploaded_date' => !empty($input['uploaded_date']) ? $input['uploaded_date'] : null,
                'stage' => 0,
                'progressive_stage' => 5,
                'status' => 0,

            ]);
            // Log::info('vita iendeleee');
            $employee_id = $input['employee_id'];
            $this->saveContractDetailDocument($request, $employee_id);
            DB::commit();

            Log::info('Saved done');
            return response()->json(['message' => 'Contract Details created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create Contract Details', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create Contract Details', 'status' => 500]);
        }
    }
    public function updatePersonaDetail($employee_id)
    {
        return  Employee::where('id', $employee_id)->update(['progressive_stage' => '4']);
    }

    public function getLastSocialRecord()
    {
        return $this->contract_detail->select('*')->latest()->first();
    }

    /**
     *@method to save Contract Details attachment

     */
   public function saveContractDetailDocument($request, $employee_id)
    {
//         Log::info($request->all());
//  log::info($employee_id);

        DB::beginTransaction();

        try {

            $documents = [];

            $documentTypes = ['job_description_doc','contract_detail_signed'];

            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType) && $employee_id) {
                    $files = $request->file($documentType);


                    foreach ($files as $file) {
                        //  log::info($file); next time i want to add id of employer  as pass to reach interview candidate document
                        //   log::info($employee_id);
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('contracts/details/'.$employee_id), $fileName);
                        // log::info('hureee'. json_encode($fileName));
                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType), // Implement a function to get the document ID based on the type
                            'description' => $fileName,
                            'document_group_id' => 11,
                            'employee_id' => $employee_id,
                        ];
                    }
                }
            }
            // log::info('document:'. ' '. $documents);
            foreach ($documents as $document) {
                // log::info('document: ******************');
                ContractDocument::create($document);
            }

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
        //  $documentTypes = ['job_description_doc','contract_detail_signed','passport_doc','nida_doc','technical_signed_doc'];
        switch ($documentId) {

            case 'job_description_doc';
                return 43;
                break;
            case 'contract_detail_signed';
                return 44;
                break;
            // case 'passport_doc';
            //     return 16;
            //     break;
            // case 'nida_doc';
            //     return 17;
            //     break;
            // case 'technical_signed_doc';
            //     return 32;
            //     break;
            default:
                return null;
        }
    }
    /**
     * Method to Update assessed Candidate details
     */
    public function updateContractRequiredDetails($request, $id)
    {

        $contract_details = $this->contract_detail::where('employee_id', $id)->first();

        if (isset($contract_details)) {

            DB::beginTransaction();

            $dobString = $request->dob;

        // Create a DateTime object from the DOB string
        $dob = new \DateTime($dobString);

        // Get the current date
        $currentDate = new \DateTime();

        // Calculate the difference between the current date and the DOB
        $ageInterval = $currentDate->diff($dob);

        // Get the years part of the interval
        $age = $ageInterval->y;

            try {
                $input = $request->all();

                $contract_details->update([
                   'firstname' => !empty($input['firstname']) ? $input['firstname'] : null,
                'middlename' => !empty($input['middlename']) ? $input['middlename'] : null,
                'lastname' => !empty($input['lastname']) ? $input['lastname'] : null,
                'employee_id' => !empty($input['employee_id']) ? $input['employee_id'] : null,
                'contract_id' => !empty($input['contract_id']) ? $input['contract_id'] : null,
                'birth_place' => !empty($input['birth_place']) ? $input['birth_place'] : null,
                'dob' => !empty($input['dob']) ? $input['dob'] : null,
                'age' => isset($age) ? $age  : null,
                'gender' => !empty($input['gender']) ? $input['gender'] : null,
                'residence_place' => !empty($input['residence_place']) ? $input['residence_place'] : 1,
                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                'permanent_residence' => !empty($input['permanent_residence']) ? $input['permanent_residence'] : null,
                'email' => !empty($input['email']) ? $input['email'] : null,
                'postal_address' => !empty($input['postal_address']) ? $input['postal_address'] : 2,
                'phone_number' => !empty($input['phone_number']) ? $input['phone_number'] : null,
                'place_recruitment' => !empty($input['place_recruitment']) ? $input['place_recruitment'] : null,
                'work_station' => !empty($input['work_station']) ? $input['work_station'] : null,
                'employer_id' => !empty($input['employer_id']) ? $input['employer_id'] : null,
                'fullname_next1' => !empty($input['fullname_next1']) ? $input['fullname_next1'] : $input['firstname'],
                'residence1' => !empty($input['residence1']) ? $input['residence1'] : null,
                'phone_number1' => !empty($input['phone_number1']) ? $input['phone_number1'] : null,
                'relationship1' => !empty($input['relationship1']) ? $input['relationship1'] : null,
                'fullname_next2' => !empty($input['fullname_next2']) ? $input['fullname_next2'] : $input['firstname'],
                'residence2' => !empty($input['residence2']) ? $input['residence2'] : null,
                'phone_number2' => !empty($input['phone_number2']) ? $input['phone_number2'] : null,
                'relationship2' => !empty($input['relationship2']) ? $input['relationship2'] : null,
                'downloaded' => !empty($input['downloaded']) ? $input['downloaded'] : null,
                'date_employed' => !empty($input['date_employed']) ? $input['date_employed'] : 0,
                'uploaded_date' => !empty($input['uploaded_date']) ? $input['uploaded_date'] : null,
                'stage' => 0,
                'progressive_stage' => 5,
                'status' => 0,

                ]);


                $this->saveContractDetailDocument($request, $id);

                DB::commit();
                Log::info('updated done');

                return response()->json(['message' => 'Contract Detail Updated successfully', 'status' => 200], 200);
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Failed to update contract details ', ['error' => $e->getMessage()]);

                return response()->json(['message' => 'Failed to Update  contract details', 'status' => 500]);
            }
        }
    }


    /**
     * Method to fetch Employee person Details
     */
    public function getContractDoc()
    {

        return  DB::table('employee_documents as ed')
            ->select('ed.id', 'ed.employee_id', 'ed.document_id', 'ed.description', 'ed.updated_at as doc_modified', 'd.name as doc_name')
            ->leftJoin('documents as d', 'ed.document_id', '=', 'd.id')
            // ->where('ed.document_group_id', 8)
            ->whereIn('ed.document_id', [43,44])
            ->get();
    }


    public function showDownloadDetails()
    {
        $data =  DB::table('contract_details as cd')
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
                DB::raw('e.employee_no as employee'),
                DB::raw('c.name as contract_type'),

                DB::raw("CASE
                            WHEN cd.gender = 1 THEN 'Male'
                            ELSE 'Female'
                        END AS gender"),
                DB::raw('em.name as employer'),
                DB::raw('jt.name as job_title'),
                    // DB::raw("CASE
                    //         WHEN dt.name = 1 THEN 'Male'
                    //         ELSE 'Female'
                    //     END AS gender"),
                DB::raw('dt.name as relationship'),
            ])
            ->leftJoin('employees as e', 'cd.employee_id', '=', 'e.id')
            ->leftJoin('employers as em', 'cd.employer_id', '=', 'em.id')
             ->leftJoin('contracts as c', 'cd.contract_id', '=', 'c.id')
            ->leftJoin('job_title as jt', 'cd.job_title_id', '=', 'jt.id')
            ->leftJoin('dependent_types as dt', 'cd.relationship1', '=', 'dt.id')
            ->orderBy('cd.id', 'DESC')
            ->get();

        return $data;
    }


    public function getContractDetails()
    {

        return DB::table('induction_training as itg')
            ->select([
                DB::raw('itg.* '),
                DB::raw("CASE
                            WHEN itg.progressive_stage = 1 THEN 'Employee Details'
                            WHEN itg.progressive_stage = 2 THEN 'Supportive Document'
                            WHEN itg.progressive_stage = 3 THEN 'Social Record'
                            WHEN itg.progressive_stage = 4 THEN 'Induction Training'
                            WHEN itg.progressive_stage = 5 THEN 'Contract Processing'
                            WHEN itg.progressive_stage = 6 THEN 'Person ID'
                            ELSE 'Registration Completed'
                        END AS progressive"),
                DB::raw('CONCAT(e.firstname, \' \', e.middlename, \' \', e.lastname) as employee_name'),
                DB::raw('e.dob'),
                DB::raw('e.employee_no as employee'),
                DB::raw('sr.person_email as email'),
                DB::raw('sr.mobile_number as phone_number'),
                DB::raw('sr.postal_address'),
                DB::raw('sr.postal_address'),
                // DB::raw('cd.stage'),
                DB::raw("CASE
                            WHEN sr.gender = 1 THEN 'Male'
                            ELSE 'Female'
                        END AS gender"),
                DB::raw('cd.stage as stages'),
                DB::raw('CONCAT(cd.firstname, \' \', cd.middlename, \' \', cd.lastname) as contract_employee'),
                DB::raw('cd.created_at as contract_created'),
                 DB::raw('emp.name as employer'),
            ])
            // ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('employees as e', 'itg.employee_id', '=', 'e.id')
            ->leftJoin('social_records as sr', 'sr.employee_id', '=', 'itg.employee_id')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('contract_details as cd', 'cd.employee_id', '=', 'itg.employee_id')
           ->leftJoin('employers as emp', 'cd.employer_id', '=', 'emp.id')
            ->where('itg.progressive_stage', '>', 4)
            ->orderBy('sr.id', 'DESC')
            ->get();
    }
    public function updateStageData($contract_details)
    {
        //    log::info('data'.$contract_details);
        if (!empty($contract_details)) {
            ContractDetail::where('id', $contract_details->id)->update(['stage' => 1, 'progressive_stage' => 6]);
            DB::table('induction_training')->where('employee_id', $contract_details->employee_id)->update(['stage' => 1, 'progressive_stage' => 6]);
        }
    }
public function getContractDatatable(){
          return DB::table('contract_fixed as cf')->select(['cf.*'



])
// ->leftJoin();
->where('stage', 1)
->get();

}
}
