<?php

namespace App\Http\Controllers\IndustrialRelationship;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\IndustrialRelationship\PerformanceAssessmentRepository;

class PerformanceAssessmentController extends Controller
{
 protected $capacity;

    public function __construct(PerformanceAssessmentRepository $capacity)
    {
        $this->capacity = $capacity;
    }

public function retrieveEmployeeCapacityDetail($id){

       $employee =  $this->capacity->retrieveEmployeeCapacityDetails($id);

      return response()->json(["status" => 200, "employee" => $employee]);
}
public function getPerfomanceCriterial(){

       $perfomance_criterial =  DB::table('perfomance_criterials')->select('id', 'name','rate')->get();

      return response()->json(["status" => 200, "perfomance_criterial" => $perfomance_criterial]);
}

/**
*@method to create paternity leave
 */
public function  createPerfomanceCapacity(Request $request)
{

             $validator = Validator::make($request->all(), [
            'capacity_id' => 'required|max:5',
            'employee_id' => 'required|max:191',
            'investigation_report' => 'required|max:191',
            'investigation_date' => 'required|max:191',
            'suffering_from' => 'required',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {


             $capacity = $this->capacity->createPerfomanceCapacity($request);

                log::info(json_encode($capacity));

            $status = $capacity->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Perfomance review successfully created.",
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
*@method to retrieve all  misconduct details
 */
public function retrieveAllPerformanceCapacity()
{

 $performance_capacity =  $this->capacity->retrieveAllPerformanceCapacity();

        return response()->json(["status" => 200, "performance_capacity" => $performance_capacity]);

}
/**
*@method to update paternity leave
 */
public function  updatePerformanceCapacity(Request $request, $id)
{

        $validator = Validator::make($request->all(), [

            'firstname' => 'required|max:191',
            // 'show_cause_letter_attachment' => 'required|',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        }  else {


    $capacity = $this->capacity->updatePerformanceCapacity($request, $id);

            $status = $capacity->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Performance capacity successfully updated.",
                ];
            } else {
                $return = [
                    'status' => 500,
                    'message' => 'Sorry! operation failed.'
                ];
            }
         }



        return response()->json($return);
}
public function retrievePerformanceCapacityDetail($id)
{

        $show_capacity =  $this->capacity->retrievePerformanceCapacityDetail($id);

        return response()->json(["status" => 200, "show_capacity" => $show_capacity]);

}

}
