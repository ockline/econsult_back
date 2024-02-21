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
     *@method to cross check if  employer with that emeil or TIN  Exist
     */
    // public function checkEmployerExist(Request $request)
    // {
    //     //   log::info($request->email);
    //     //   log::info('wanjiiiii');
    //     $check_employer = $this->employer->getEmployers();
    //     //    Log::info($check_employer);

    //     $employer_exist = [];
    //     $employer_tin = [];
    //     foreach ($check_employer as $check) {
    //         $employer_exist[] = $check->email;
    //         $employer_tin[] = $check->tin;
    //     }
    //     if ($request->email === $employer_exist) {

    //         $return = [
    //             'status' => 404,
    //             'message' => 'Sorry! Client created already exists'


    //         ];
    //     }
    //     if ($request->tin === $employer_tin) {

    //         $return = [
    //             'status' => 404,
    //             'message' => 'Sorry! Client created already exists'


    //         ];
    //     }
    //     return response()->json($return);
    // }
    public function checkEmployerExist(Request $request)
    {
        $check_employer = $this->employer->getEmployers();

        $employer_exist = [];
        $employer_tin = [];

        foreach ($check_employer as $check) {
            $employer_exist[] = $check->email;
            $employer_tin[] = $check->tin;
        }

        $return = []; // Initialize $return here

        if (in_array($request->email, $employer_exist)) {

            $return = 404;
        } elseif (in_array($request->tin, $employer_tin)) {

            $return = 405;
        }
        return $return;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       log::info($request->all());
        $employer_check = $this->checkEmployerExist($request);

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
            'working_hours' => 'required|max:191',
            'working_days' => 'required|max:191',
            'shift_id' => 'required|max:191',
            'allowance_id' => 'required|max:191',
            'tin_doc' => 'required|max:3072',
            'osha_doc' => 'required|max:3072',
            'wcf_doc' => 'required|max:3072',
            'nssf_doc' => 'required|max:3072',
            'nhif_doc' => 'required|max:3072',
            'vrn_doc' => 'required|max:3072',
        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } elseif (in_array($employer_check, [404, 405])) {
            Log::info('hureeeeeeee' . ' ' . $employer_check);
            $return = [
                'status' => 404,
                "message" => "Client you want to create already exists",
            ];
        } else {
            Log::info('ndani ya nyumba');
            $new_client = $this->employer->addEmployers($request);

            $status = $new_client->getStatusCode();

            // Get HTTP status code
            $responseContent = $new_client->getContent();
            //    log::info('je?'. ' '. $status);
            if ($status === 201) {
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
      $employer = $this->employer->getSpecificEmployer($id);
       // Add more properties as needed

        if (isset($employer)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'employer' => $employer,
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
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
        Log::info('Form data received: ' . json_encode($request->all()));
        Log::info('welimbaaaaaa');
        // $employer = $this->employer($id);

        $employer = $this->employer->updateDetails($request, $id);



        // log::info($employer);

        $status = $employer->getStatusCode();
        Log::info($status);
        // Get HTTP status code
        $responseContent = $employer->getContent();


        if ($status === 200) {
            log::info('ndani');
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
        $employer =    $this->employer->getEmployers();
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

    public function getDocument(string $id)
    {
    //    log::info($id);
        $employer_document = $this->employer->getEmployerDocument($id);
    //   log::info('data'. " ". $employer_document);


        if (isset($employer_document)) {

            return response()->json([
                'status' => 200,
                'employer_document' => $employer_document,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No document found',
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
