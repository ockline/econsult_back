<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\HomeRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\Personal\Employee;


class HomeController extends Controller
{
    protected $employee;

    public function __construct(HomeRepository $employee)
    {
        $this->employee = $employee;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //   $employee = $this->employee->getSpecificEmployer($id);
    //    // Add more properties as needed

    //     if (isset($employee)) {
    //         // Log::info('111');
    //         return response()->json([
    //             'status' => 200,
    //             'employee' => $employee,
    //         ]);
    //     } else {
    //         // log::info('222');
    //         return response()->json([
    //             'status' => 500,
    //             'message' => "Internal server Error"
    //         ]);
    //     }
    // }

    public function edit(string $id)
    {

        $employee = Employee::find($id);
        //   Log::info($employeeList->$employee);
        if (isset($employee)) {
            return response()->json([
                'status' => 200,
                'employee' => $employee,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     */

    public function  getAllEmployee()
    {
        // Log::info('anafikaaa mkali');
        $employees =    $this->employee->getAllEmployeeDetail();
        // Log::info($employee);
        if ($employees) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'employees' => $employees,
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 404,
                'message' => "Sorry! No data found"
            ]);
        }
    }

public function getEmployedCount()
{

        $employed_count =    $this->employee->countAllEmployed();

        if ($employed_count) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'employed_count' => $employed_count,
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 404,
                'message' => "Sorry! No data found"
            ]);
        }


}


}
