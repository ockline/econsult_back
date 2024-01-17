<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sysdef\Designation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Repositories\DesignationRepository;

class DesignationController extends Controller
{
    protected $designation;

    public function __construct(DesignationRepository $designation)
    {
        $this->designation = $designation;
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
        log::info($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'status'  => 'required',

        ]);

        if ($validator->fails()) {
            $return  = ['validator_err' => $validator->messages()];
        } else {

            $this->designation->addDesignations($request);

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
        $designation = Designation::find($id);
        if ($designation) {
            return response()->json([

                'status' => 200,
                'designation' => $designation,
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


        $designation = Designation::find($id);;

        if ($designation) {
            $designation->name = $request->input('name');
            $designation->unit = $request->input('unit');
            $designation->status = $request->input('status');
            $designation->update();

            return response()->json([
                'status' => '200',
                "message" => "Update Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error'


            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $designation = $this->designation($id);
        $designation = Designation::find($id);
        log::info($designation);
        log::info('hapaa');
        if ($designation) {
            return response()->json([
                "status" =>  200,
                "designation" => $designation->delete(),
            ]);
        } else {
            return response()->json([
                "status" =>  404,
                "designation" => "Action Failed",
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */

    public function  designation()
    {
        // Log::info('anafikaaa mkali');
        $designation =    $this->designation->getDesignations();
        // Log::info($department);
        if ($designation) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'designations' => $designation,
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
    public function getDesignation()
    {
        $get_designation =  $this->designation->userDesignation();
        Log::info($get_designation);
        if ($get_designation) {
            return response()->json([
                'status' => 200,
                'user_designation' => $get_designation,
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server Error',
            ]);
        }
    }
}
