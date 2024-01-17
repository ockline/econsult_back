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
        // Log::info('hellow ndani');
        // log::info($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'status'  => 'required',

        ]);

        if ($validator->fails()) {
            $return  = ['validator_err' => $validator->messages()];
        } else {

            $this->employer->addEmployers($request);

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
