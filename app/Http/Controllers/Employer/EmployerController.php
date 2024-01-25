<?php

namespace App\Http\Controllers\Employer;

use Illuminate\Http\Request;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\EmployerRepositories\EmployerRepository;

class EmployerController extends Controller
{
    protected $employer;

    public function __construct(EmployerRepository $employer)
    {
        $this->employer = $employer;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('hellow ndani');
        // log::info($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'contact_person' => 'required|max:191',
            'contact_person_phone' => 'required|max:191',
            'phone' => 'required|max:14|min:10',
            'tin' => 'required|max:191',
            'email' => 'email|max:191',
            'osha' => 'required|max:50|min:8',
            'wcf' => 'required|max:191',
            'nssf' => 'required|max:191',
            'nhif' => 'required|max:191',
            'vrn' => 'required|max:191',
            'telephone' => 'required|max:191',
            'fax' => 'required|max:191',
            'bank_id' => 'required|max:191',
            'bank_branch_id' => 'required|max:191',
            'account_no' => 'required|max:191',
            'account_name' => 'required|max:191',
            'postal_address' => 'required|max:191',
            'region_id' => 'required|max:191',
            'district_id' => 'required|max:191',
            'location_type_id' => 'required|max:191',
            'working_hours' => 'required|max:191',
            'working_days' => 'required|max:191',
            'shift_id' => 'required|max:191',
            'allowance_id' => 'required|max:191',

        ]);

        if ($validator->fails()) {
            $messages = [
                'name' => 'The Employer name is required',
                'contact_person' => 'The  Contact Person  name isrequired ',
                'contact_person_phone' => 'The Contact person number is required ',
                'phone' => 'The phone number is required ',
                'tin' => 'The  Tin number is required ',
                'email' => 'The  email is required',
                'osha' => 'The osha is required ',
                'wcf' => 'The wcf number is required ',
                'nssf' => 'The nssf number is required ',
                'nhif' => 'The Nhif number is required ',
                'vrn' => 'The vrn is required ',
                'telephone' => 'The Telephone number is  required ',
                'fax' => 'The Fax is required ',
                'bank_id' => 'The Bank name is required ',
                'bank_branch_id' => 'The Bank branch is required ',
                'account_no' => 'The Account number is required ',
                'account_name' => 'The Account name is required ',
                'postal_address' => 'The postal address is required ',
                'region_id' => 'The region is required ',
                'district_id' => 'The District is required ',
                'location_type_id' => 'The Location type required ',
                'working_hours' => 'The  Working hour required ',
                'working_days' => 'The Working day is required ',
                'shift_id' => 'The Shift is required ',
                'allowance_id' => 'The allowance is required ',

            ];
            $return =  [
                'validator_err' =>  $messages,
               ];
        } else {

         $data  =   $this->employer->addEmployers($request);
        //  $status = $data->getStatusCode();


            $return = ['status' => 200];
        }
        return response()->json($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $employer = $this->employer($id);
        if ($employer) {
            return response()->json([

                'status' => 200,
                'employer' => $employer,
            ]);
        } else {

            return response()->json([
                'status' => 404,
                'message' => "N data found",

            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        // $employer = $this->employer($id);

        // if ($employer) {
        //     $employer->name = $request->input('name');
        //     $employer->unit = $request->input('unit');
        //     $employer->status = $request->input('status');
        //     $employer->update();

        //     return response()->json([
        //         'status' => '200',
        //         "message" => "Update Successfully",
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => 500,
        //         'message' => 'Internal server error'


        //     ]);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $employer = $this->employer($id);
        $employer = $this->employer($id);
        // log::info($employer);
        // log::info('hapaa');
        if ($employer) {
            return response()->json([
                "status" =>  200,
                "employer" => $employer->delete(),
            ]);
        } else {
            return response()->json([
                "status" =>  404,
                "employer" => "Action Failed",
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */

    public function  employer()
    {
        // Log::info('anafikaaa mkali');
        $employer =    $this->employer->getemployers();
        // Log::info($employer);
        if ($employer) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'employers' => $employer,
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
    public function getEmployer()
    {
        $get_employer =  $this->employer->userEmployer();
        // Log::info($get_employer);
        if ($get_employer) {
            return response()->json([
                'status' => 200,
                'user_employer' => $get_employer,
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server Error',
            ]);
        }
    }
}
