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
        log::info($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'contact_person' => 'required|max:191',
            'contact_person_phone' => 'required|max:191',
            'phone' => 'required|min:10|max:14',
            'tin' => 'required|min:2|max:20',
            'email' => 'email|max:191',
            'osha' => 'required|max:50',
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
            'cost_center' => 'required|max:191',
            'working_hours' => 'required|max:191',
            'working_days' => 'required|max:191',
            'shift_id' => 'required|max:191',
            'allowance_id' => 'required|max:191',
            // 'tin_doc' => 'required|mimes:pdf|max:3072|file',
            // 'osha_doc' => 'required|mimes:pdf|max:3072|file',
            // 'wcf_doc' => 'required|mimes:pdf|max:3072|file',
            // 'nssf_doc' => 'required|mimes:pdf|max:3072|file',
            // 'nhif_doc' => 'required|mimes:pdf|max:3072|file',
            // 'vrn_doc' => 'required|mimes:pdf|max:3072|file',
        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
            Log::info('ndani ya nyumba');
            $new_client = $this->employer->addEmployers($request);

            $status = $new_client->getStatusCode();

            // Get HTTP status code
            $responseContent = $new_client->getContent();

            if ($status) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Employer Registered Successfully",
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        // Log::info($id);

        // $employerList = $this->employer(); // Assuming $employerList is an array of objects

        $employer = Employer::find($id);
        //   Log::info($employerList->$employer);
        if (isset($employer)) {
            return response()->json([
                'status' => 200,
                'employer' => $employer,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // log::info($request);

        // $employer = $this->employer($id);

        $employer = $this->employer->updateDetails($request, $id);



        // log::info($employer);

        $status = $employer->getStatusCode();
        // Log::info($status);
        // Get HTTP status code
        $responseContent = $employer->getContent();


        if ($status) {
            // log::info('ndani');
            return response()->json([
                'status' => 200,
                "message" => "Employer Updated Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'


            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    //    log::info($id);
        // $employer = $this->employer($id);
        $employer = Employer::find($id);
        // log::info($employer);

        $mployer_deactivation = $this->employer->deactivateEmployer($id);

        if ($employer) {
            return response()->json([
                "status" =>  200,
                "message" => 'Record updated and deleted successfully'
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
    // public function getEmployer()
    // {
    //     $get_employer =  $this->employer->userEmployer();
    //     // Log::info($get_employer);
    //     if ($get_employer) {
    //         return response()->json([
    //             'status' => 200,
    //             'user_employer' => $get_employer,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 500,
    //             'message' => 'Internal server Error',
    //         ]);
    //     }
    // }

}
