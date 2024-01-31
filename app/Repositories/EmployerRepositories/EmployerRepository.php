<?php

namespace App\Repositories\EmployerRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseREpository;
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
        $employers = $this->employer->selectRaw(" * , CASE WHEN active = 1 THEN 'Active' ELSE 'Not Active' END AS status")->withTrashed()->get();
        // $employers = DB::table('employers')->select('*')->get();
        return $employers;
    }

    public function addEmployers($request)
    {
        // Log::info('hapa atumefika');

        DB::beginTransaction();

        try {
            $input = $request->all();
            //  Log::info($input);
            $employer_number = $this->generateUniqueNumber();
            //  log::info('mwamba juu');
            // log::info($employer_number);
            // log::info('mwamba chini');
            // $fileName = time().'.'.$request->file->extension();

            // $request->file->move(public_path('uploads'), $fileName);

            $this->employer->create([
                'name' => !empty($input['name']) ? $input['name'] : null,
                'alia' =>  !empty($input['alias']) ? $input['alias'] : $input['name'], //as alias
                'contact_person' => !empty($input['contact_person']) ?: null,
                'contact_person_phone' => !empty($input['contact_person_phone']) ?: null,
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
    public function updateDetails($request, $id)
    {
        // log::info('ndani');
        // Log::info($request);
        // Log::info("*************");
        $employer = Employer::find($id);
        if (isset($employer)) {
            // $department = $this->department->id; // Assuming you have an 'id' field in your request


            DB::beginTransaction();

            try {
                $input = $request->all();

                $employer_number = $this->generateUniqueNumber();
                // log::info($input);
                // log::info('mwamba chini');
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

                DB::commit();
                // Log::info('updated done');
                return response()->json(['message' => 'User Updated successfully', 'status' => 200], 200);
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Failed to create user', ['error' => $e->getMessage()]);

                return response()->json(['message' => 'Failed to Update user', 'status' => 500]);
            }
        }
    }

    public function getDocument(Request $request)
    {
        $employer = $this->addEmployers($request);
        $nhif_doc  = 10;
        $tin_doc =  11;
        $nssf_doc  = 12;
        $wcf_doc  = 13;
        $osha_doc  = 14;
        $vrn_doc  = 29;


        // $data = [
        //    'name'
        //    'employer_id'
        //    'document_id'
        //   'document_group_id'
        //   'description'
        //    ];



    }

public function deactivateEmployer($id)
{
// log::info('hapaa');
//         Log::info(request()->all());
//       Log::info('katiiiii');
      $input = request()->all();
$activate_reason = $input['activate_reason'];
$deact_reason = !empty($input['deactivate_reason']) ? $input['deactivate_reason']: null;


if(isset($activate_reason)){
   Employer::where('id', $id)->update(['active' => 1, 'activate_reason' => $activate_reason, 'activate_date' => now() ]);
}else if(isset($deact_reason)){
    Employer::where('id', $id)->update(['active' => 2, 'deactivate_reason' => $deact_reason, 'deactivate_date' => now() ]);

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
}
