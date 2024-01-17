<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sysdef\Unit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UnitRepository;

class UnitController extends Controller
{
    protected $unit;

    public function __construct(UnitRepository $unit)
    {
        $this->unit = $unit;
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

            $this->unit->addUnits($request);

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
        $department = Unit::find($id);
        if ($department) {
            return response()->json([

                'status' => 200,
                'department' => $department,
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


        $unit = Unit::find($id);;

        if ($unit) {
            $unit->name = $request->input('name');
            $unit->unit = $request->input('unit');
            $unit->status = $request->input('status');
            $unit->update();

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
        // $unit = $this->unit($id);
        $unit = Unit::find($id);
        // log::info($department);
        // log::info('hapaa');
        if ($unit) {
            return response()->json([
                "status" =>  200,
                "unit" => $unit->delete(),
            ]);
        } else {
            return response()->json([
                "status" =>  404,
                "department" => "Action Failed",
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */

    public function  unit()
    {
        // Log::info('anafikaaa mkali');
        $section =    $this->unit->getUnits();
        // Log::info($section);
        if ($section) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'sections' => $section,
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
    public function getUnit()
    {
        $get_section =  $this->unit->userUnit();
        // Log::info($get_section);
        if ($get_section) {
            return response()->json([
                'status' => 200,
                'user_section' => $get_section,
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server Error',
            ]);
        }
    }
}
