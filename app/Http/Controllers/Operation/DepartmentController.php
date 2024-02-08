<?php

namespace App\Http\Controllers\Operation;

use Illuminate\Http\Request;
use App\Models\Sysdef\Department;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\DepartmentRepository;

class DepartmentController extends Controller
{
    protected $department;

    public function __construct(DepartmentRepository $department)
    {
        $this->department = $department;
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

            $this->department->addDepartments($request);

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
        $department = Department::find($id);
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


        $department = Department::find($id);

        if ($department) {
            $department->name = $request->input('name');
            $department->unit = $request->input('unit');
            $department->status = $request->input('status');
            $department->update();

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
        // $department = $this->department($id);
        $department = Department::find($id);
        // log::info($department);
        // log::info('hapaa');
        if ($department) {
            return response()->json([
                "status" =>  200,
                "department" => $department->delete(),
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

    public function  department()
    {
        // Log::info('anafikaaa mkali');
        $department =    $this->department->getDepartments();
        // Log::info($department);
        if ($department) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'departments' => $department,
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
    public function getDepartment()
    {
        $get_department =  $this->department->userDepartment();
        // Log::info($get_department);
        if ($get_department) {
            return response()->json([
                'status' => 200,
                'user_department' => $get_department,
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server Error',
            ]);
        }
    }
}
