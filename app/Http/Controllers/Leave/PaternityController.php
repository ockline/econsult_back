<?php

namespace App\Http\Controllers\Leave;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\LeaveRepositories\AnnualRepository;
use App\Repositories\LeaveRepositories\PaternityRepository;

class PaternityController extends Controller
{
 protected $paternity_leave;

    public function __construct(PaternityRepository $paternity_leave)
    {
        $this->paternity_leave = $paternity_leave;
    }

public function getEmployee($id){

       $employee =  $this->paternity_leave->retrieveEmployeeDetails($id);

      return response()->json(["status" => 200, "employee" => $employee]);
}
/**
*@method to create paternity leave
 */
public function  createPaternityLeave(Request $request)
{

        $date_check = $this->checkIfOneWeekLess($request);

        $validator = Validator::make($request->all(), [
            'leave_type' => 'required|max:5',
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'start_date' => 'required|max:191',
            'end_date' => 'required|',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } elseif ($date_check) {

            $return = [
                'status' => 404,
                "message" => "Sorry your start date leave application  should be less than one week",
            ];
        } else {


    $paternity_leave = $this->paternity_leave->savePaternityLeave($request);

            $status = $paternity_leave->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Paternity leave successfully created.",
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
*@method to check if leave start date is less than one week
 */
public function checkIfOneWeekLess($request)
{
   $start = Carbon::now();
    $start_date = Carbon::parse($request->start_date);

    // Check if the start date is within one week of the reference date
    return $start->diffInDays($start_date) < 6;

}
public function retrievePaternityLeaveDetails()
{
 $paternity_leave =  $this->paternity_leave->getPaternityLeave();

      return response()->json(["status" => 200, "paternity_leave" => $paternity_leave]);


}
/**
*@method to update paternity leave
 */
public function  updatePaternityLeave(Request $request, $id)
{

        // $date_check = $this->checkIfOneWeekLess($request);

        $validator = Validator::make($request->all(), [

            'start_date' => 'required|max:191',
            'end_date' => 'required|',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        }  else {


    $paternity_leave = $this->paternity_leave->updatePaternityLeave($request, $id);

            $status = $paternity_leave->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Paternity leave successfully updated.",
                ];
            } else {
                $return = [
                    'status' => 500,
                    'message' => 'Sorry! Operation failed.'
                ];
            }
         }



        return response()->json($return);
}
public function getPaternityLeaveDetail($leaveId)
{

        $employee =  $this->paternity_leave->retrievePaternityLeaveDetails($leaveId);

        return response()->json(["status" => 200, "employee" => $employee]);

}

}
