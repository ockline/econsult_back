<?php

namespace App\Repositories\EmployerRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\Employer\Employer;
use App\Models\Employer\EmployerAttachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;


class EmployerRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Employer::class;


    protected $employer;
    protected $users;

    public function __construct(Employer $employer, UserRepository $users)
    {
        $this->employer = $employer;
        $this->users = $users;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        // $employers = $this->employer->where("id", $id)->first();

        // if (!is_null($employers)) {
        //     return $employers;
        // }

    }

    public function getEmployers()
    {
        $employers = $this->employer->selectRaw(" * , CASE WHEN active = 1 THEN 'Active' ELSE 'Not Active' END AS status")
            // , 'ema.name as document'
            // ->leftJoin('employer_attachments as ema', 'ema.employer_id', '=', 'employers.id')
           ->orderBy('id', 'DESC')
            ->withTrashed()
            ->get();
        // $employers = DB::table('employers')->select('*')->get();
        return $employers;
    }

    public function addEmployers($request)
    {


        DB::beginTransaction();

        try {
            $input = $request->all();
            //  Log::info($input);
            $employer_number = $this->generateUniqueNumber();

            $employer =  $this->employer->create([
                'name' => !empty($input['name']) ? $input['name'] : null,
                'alia' =>  !empty($input['alias']) ? $input['alias'] : $input['name'], //as alias
                'contact_person' => !empty($input['contact_person']) ? $input['contact_person'] : null,
                'contact_person_phone' => !empty($input['contact_person_phone']) ? $input['contact_person_phone'] : null,
                'phone' => !empty($input['phone']) ? $input['phone'] : null,
                'tin' => !empty($input['tin']) ? $input['tin'] : null,
                'email' => !empty($input['email']) ? $input['email'] : null,
                'osha' => !empty($input['osha']) ? $input['osha'] : null,
                'wcf' => !empty($input['wcf']) ? $input['wcf'] : null,
                'nssf' => !empty($input['nssf']) ? $input['nssf'] : null,
                'nhif' => !empty($input['nhif']) ? $input['nhif'] : null,
                'vrn' => !empty($input['vrn']) ? $input['vrn'] : null,
                'telephone' => !empty($input['telephone']) ? $input['telephone'] : null,
                'fax' => !empty($input['fax']) ? $input['fax'] : null,
                'bank_id' => !empty($input['bank_id']) ? $input['bank_id'] : null,
                'bank_branch_id' => !empty($input['bank_branch_id']) ? $input['bank_branch_id'] : null,
                'account_no' => !empty($input['account_no']) ? $input['account_no'] : null,
                'account_name' => !empty($input['account_name']) ? $input['account_name'] : null,
                'postal_address' => !empty($input['postal_address']) ? $input['postal_address'] : null,
                'region_id' => !empty($input['region_id']) ? $input['region_id'] : null,
                'district_id' => !empty($input['district_id']) ? $input['district_id'] : null,
                'location_type_id' => !empty($input['location_type_id']) ? $input['location_type_id'] : null,
                'cost_center' => !empty($input['cost_center']) ? $input['cost_center'] : null,
                'road' => !empty($input['road']) ? $input['road'] : null,
                'street' => !empty($input['street']) ? $input['street'] : null,
                'block_number' => !empty($input['block_number']) ? $input['block_number'] : null,
                'plot_number' => !empty($input['plot_number']) ? $input['plot_number'] : null,
                'ward_id' => !empty($input['ward_id']) ? $input['ward_id'] : null,
                'working_hours' => !empty($input['working_hours']) ? $input['working_hours'] : null,
                'working_days' => !empty($input['working_days']) ? $input['working_days'] : null,
                'shift_id' => !empty($input['shift_id']) ? $input['shift_id'] : null,
                'allowance_id' => !empty($input['allowance_id']) ? $input['allowance_id'] : null,
                'reg_no' => !empty($employer_number) ? intval("0000") . $employer_number : 001,
                'created_by' =>  1, // admin after login will be autheticated user

            ]);
            $employer_id = $employer->id;

            $this->saveEmployerDocument($request, $employer_id);
            // di
            DB::commit();

            Log::info('Saved done');
            return response()->json(['message' => 'User created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create user', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create user', 'status' => 500]);
        }
    }

    public function generateUniqueNumber()
    {
        // Generate a timestamp to include in the sequence
        $timestamp = now()->timestamp;

        // Combine the timestamp and three random numbers to form the unique number sequence
        $uniqueNumber = '000' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);

        return $uniqueNumber;
    }
    /**
     * @method to save employer document
     *@method with the generated employer id

     */
    public function saveEmployerDocument($request, $employer_id)
    {

        DB::beginTransaction();

        try {

            $tin = time() . '.' . $request->tin_doc[0]->getClientOriginalName();
            $osha = time() . '.' . $request->osha_doc[0]->getClientOriginalName();
            $wcf = time() . '.' . $request->wcf_doc[0]->getClientOriginalName();
            $nhif = time() . '.' . $request->nhif_doc[0]->getClientOriginalName();
            $nssf = time() . '.' . $request->nssf_doc[0]->getClientOriginalName();
            $vrn = time() . '.' . $request->vrn_doc[0]->getClientOriginalName();




            // $documents = [
            //     ['name' => 'nhif_doc.pdf', 'document_id' => 10, 'document_group_id' => 6, 'employer_id' => $employer_id, 'description' => $nhif, 'size' => null, 'ext' => null, 'mine' => null, 'document_used' => 0],
            //     ['name' => 'tin_doc.pdf', 'document_id' => 11, 'document_group_id' => 6, 'employer_id' => $employer_id, 'description' => $tin, 'size' => null, 'ext' => null, 'mine' => null, 'document_used' => 0],
            //     ['name' => 'nssf_doc.pdf', 'document_id' => 12, 'document_group_id' => 6, 'employer_id' => $employer_id, 'description' => $nssf, 'size' => null, 'ext' => null, 'mine' => null, 'document_used' => 0],
            //     ['name' => 'wcf_doc.pdf', 'document_id' => 13, 'document_group_id' => 6, 'employer_id' => $employer_id, 'description' => $wcf, 'size' => null, 'ext' => null, 'mine' => null, 'document_used' => 0],
            //     ['name' => 'osha_doc.pdf', 'document_id' => 14, 'document_group_id' => 6, 'employer_id' => $employer_id, 'description' => $osha, 'size' => null, 'ext' => null, 'mine' => null, 'document_used' => 0],
            //     ['name' => 'vrn_doc.pdf', 'document_id' => 29, 'document_group_id' => 6, 'employer_id' => $employer_id, 'description' => $vrn, 'size' => null, 'ext' => null, 'mine' => null, 'document_used' => 0],
            // ];



            $documentTypes = ['nhif_doc', 'tin_doc', 'nssf_doc', 'wcf_doc', 'osha_doc', 'vrn_doc'];

            foreach ($documentTypes as $documentType) {
                if ($request->has($documentType)) {
                    $files = $request->file($documentType);

                    foreach ($files as $file) {
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('employers'), $fileName);

                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType), // Implement a function to get the document ID based on the type
                            'description' => $fileName,
                            'document_group_id' => 6,
                            'employer_id' => $employer_id,
                        ];
                    }
                }
            }
            foreach ($documents as $document) {
                EmployerAttachment::create($document);
            }


            DB::commit();

            Log::info('Saved document');
            return response()->json(['message' => 'Document created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save document', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save document', 'status' => 500]);
        }
    }
    public function getDocumentId($documentId)
    {
        // $document_id = [10, 11, 12, 13, 14, 29];
        //  $documentTypes = [nhif_doc','tin_doc','nssf_doc','wcf_doc', 'osha_doc','vrn_doc'];
        switch ($documentId) {
            case 'nhif_doc';
                return 10;
                break;
            case 'tin_doc';
                return 11;
                break;
            case 'nssf_doc';
                return 12;
                break;
            case 'wcf_doc';
                return 13;
                break;
            case 'osha_doc';
                return 14;
                break;
            case 'vrn_doc';
                return 29;
                break;
            default:
                return null;
        }
    }


    public function updateDetails($request, $id)
    {
        // log::info('ndani');
        Log::info($request->all());
        Log::info("*************");
        $employer = Employer::find($id);
        if (isset($employer)) {
            // $department = $this->department->id; // Assuming you have an 'id' field in your request


            DB::beginTransaction();

            try {
                $input = $request->all();

                $employer_number = $this->generateUniqueNumber();
                // log::info($input);
                log::info('mwamba chini');
                // $fileName = time().'.'.$request->file->extension();

                // $request->file->move(public_path('uploads'), $fileName);


                $employer->name = $request->input('name');
                $employer->alia =  $request->input('alia'); //as alias
                $employer->contact_person = $request->input('contact_person');
                $employer->contact_person_phone = $request->input('contact_person_phone');
                $employer->phone = $request->input('phone');
                $employer->tin   = $request->input('tin');
                $employer->email = $request->input('email');
                $employer->osha  = $request->input('osha');
                $employer->wcf   = $request->input('wcf');
                $employer->nssf  = $request->input('nssf');
                $employer->nhif  = $request->input('nhif');
                $employer->vrn   = $request->input('vrn');
                $employer->telephone = $request->input('telephone');
                $employer->fax = $request->input('fax');
                $employer->bank_id = $request->input('bank_id');
                $employer->bank_branch_id = $request->input('bank_branch_id');
                $employer->account_no = $request->input('account_no');
                $employer->account_name = $request->input('account_name');
                $employer->postal_address = $request->input('postal_address');
                $employer->region_id = $request->input('region_id');
                $employer->district_id = $request->input('district_id');
                $employer->location_type_id = $request->input('location_type_id');
                $employer->cost_center = $request->input('cost_center');
                $employer->road = $request->input('road');
                $employer->street = $request->input('street');
                $employer->block_number = $request->input('block_number');
                $employer->plot_number = $request->input('plot_number');
                $employer->ward_id = $request->input('ward_id');
                $employer->working_hours = $request->input('working_hours');
                $employer->working_days = $request->input('working_days');
                $employer->shift_id = $request->input('shift_id');
                $employer->allowance_id = $request->input('allowance_id');
                $employer->reg_no = (intval("0000") . $employer_number);
                $employer->created_by =  1; // admin after login will be autheticated user
                $employer->update();


                $this->updateEmployerDocument($request, $employer->id);
                log::info('hureeeeee');
                DB::commit();
                // Log::info('updated done');
                return response()->json(['message' => 'User Updated successfully', 'status' => 200], 200);
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Failed to update employer', ['error' => $e->getMessage()]);

                return response()->json(['message' => 'Failed to Update user', 'status' => 500]);
            }
        }
    }
    /**
     * @method to update employer document
     *@method with the generated employer id

     */
    public function updateEmployerDocument($request, $employer_id)
    {
        Log::info($request->all());
        DB::beginTransaction();

        try {

            $tin = time() . '.' . $request->tin_doc[0]->getClientOriginalName();
            $osha = time() . '.' . $request->osha_doc[0]->getClientOriginalName();
            $wcf = time() . '.' . $request->wcf_doc[0]->getClientOriginalName();
            $nhif = time() . '.' . $request->nhif_doc[0]->getClientOriginalName();
            $nssf = time() . '.' . $request->nssf_doc[0]->getClientOriginalName();
            $vrn = time() . '.' . $request->vrn_doc[0]->getClientOriginalName();

            $documentTypes = ['nhif_doc', 'tin_doc', 'nssf_doc', 'wcf_doc', 'osha_doc', 'vrn_doc'];

            foreach ($documentTypes as $documentType) {
                if ($request->has($documentType)) {
                    $files = $request->file($documentType);

                    foreach ($files as $file) {
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('employers'), $fileName);

                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType), // Implement a function to get the document ID based on the type
                            'description' => $fileName,
                            'document_group_id' => 6,
                            'employer_id' => $employer_id,
                        ];
                    }
                }
            }
            foreach ($documents as $document) {
                Log::info('tunaanza kuwekaaaaa');
                EmployerAttachment::update($document);
            }


            DB::commit();

            Log::info('Saved document');
            return response()->json(['message' => 'Document updated successfully', 'status' => 200], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update document', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to update document', 'status' => 500]);
        }
    }

    public function deactivateEmployer($request, $id)
    {
        log::info('hapaa');
                Log::info($request->all());
              Log::info('katiiiii');
        // $input = request()->all();
        $activate_reason = $request->activate_reason;
        $deact_reason = !empty($request->deactivate_reason) ? $request->deactivate_reason : null;


        if (isset($activate_reason)) {
            Employer::where('id', $id)->update(['active' => 1, 'activate_reason' => $activate_reason, 'activate_date' => now()]);
        } else if (isset($deact_reason)) {
            Employer::where('id', $id)->update(['active' => 2, 'deactivate_reason' => $deact_reason, 'deactivate_date' => now()]);

            // Delete the record
            $employer = Employer::find($id);
            if ($employer) {
                $employer->delete();
                return response()->json(['status' => 200, 'message' => 'Record updated and deleted successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Record not found'], 404);
            }
        }
        return true;
    }
    public function getSpecificEmployer(string $id)
    {
        return $this->employer->select([
            '*',
           DB::raw('employers.name as employer_name'),
            DB::raw('b.name as bank'),
            DB::raw('bb.name as bank_branch'),
            DB::raw('r.name as region'),
            DB::raw('d.name as district'),
            DB::raw('lt.name as location'),
            DB::raw('st.name as shift_name'),
            DB::raw('al.name as allowance'),
            DB::raw('wd.ward_name as ward'),
            // DB::raw('ea.name as doc_name'),
            // DB::raw('ea.size as size'),
            // DB::raw('ea.updated_at as doc_updated'),
        ])
            ->leftJoin('banks as b', 'employers.bank_id', '=', 'b.id')
            ->leftJoin('bank_branches as bb', 'employers.bank_branch_id', '=', 'bb.id')
            ->leftJoin('regions as r', 'employers.region_id', '=', 'r.id')
            ->leftJoin('districts as d', 'employers.district_id', '=', 'd.id')
            ->leftJoin('postcodes as wd', 'wd.district_id', '=', 'wd.id')
            ->leftJoin('location_types as lt', 'employers.location_type_id', '=', 'lt.id')
            ->leftJoin('shifts as st', 'employers.shift_id', '=', 'st.id')
            ->leftJoin('allowances as al', 'employers.allowance_id', '=', 'al.id')
            // ->orderBy('employers.id', 'DESC')
            ->where('employers.id', $id)
            ->first();
    }
    public function getEmployerDocument(string $id)
    {
        return DB::table('employer_attachments as ea')->select([
            DB::raw('ea.size as size'),
            DB::raw('ea.description'),
            DB::raw('ea.employer_id'),
            DB::raw('ea.updated_at as doc_updated'),
            DB::raw('d.name doc_name'),
        ])
            ->leftJoin('documents as d', 'ea.document_id', '=', 'd.id')
            ->leftJoin('employers as e', 'ea.employer_id', '=', 'e.id')
            ->where('ea.employer_id', $id)
            ->get();
    }
}
