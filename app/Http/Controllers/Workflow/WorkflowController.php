<?php

namespace App\Http\Controllers\Workflow;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\Personal\Employee;
use App\Repositories\WorkflowRepositories\WorkflowRepository;


class WorkflowController extends Controller
{
    protected $workflows;

    public function __construct(WorkflowRepository $workflows)
    {
        $this->workflows = $workflows;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
*@method to initiate job vacancy workflow
 */
public function  initiateJobWorkflow(Request $request)
{

 $employees =    $this->workflows->saveInitiatedVacancy($request);
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


    public function review(string $id)
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

    // public function  getAllEmployee()
    // {
    //     // Log::info('anafikaaa mkali');
    //     $employees =    $this->workflows->getVacanciesDetail();
    //     // Log::info($employee);
    //     if ($employees) {
    //         // Log::info('111');
    //         return response()->json([
    //             'status' => 200,
    //             'employees' => $employees,
    //         ]);
    //     } else {
    //         // log::info('222');
    //         return response()->json([
    //             'status' => 404,
    //             'message' => "Sorry! No data found"
    //         ]);
    //     }
    // }

// public function getEmployedCount()
// {

//         $employed_count =    $this->workflows->countAllEmployed();

//         if ($employed_count) {
//             // Log::info('111');
//             return response()->json([
//                 'status' => 200,
//                 'employed_count' => $employed_count,
//             ]);
//         } else {
//             // log::info('222');
//             return response()->json([
//                 'status' => 404,
//                 'message' => "Sorry! No data found"
//             ]);
//


// }


}
