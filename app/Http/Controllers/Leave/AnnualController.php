<?php

namespace App\Http\Controllers\Leave;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\LeaveRepositories\AnnualRepository;

class AnnualController extends Controller
{
 protected $annual_leave;

    public function __construct(AnnualRepository $annual_leave)
    {
        $this->annual_leave = $annual_leave;
    }

public function getEmployee($id){

       $employee =  $this->annual_leave->retrieveEmployeeDetails($id);

      return response()->json(["status" => 200, "employee" => $employee]);
}
/**
*@method to create annual leave apid and un paid
 */
public function  createAnnualLeave(Request $request)
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
                if($request->leave_type == 1){

    $annual_leave = $this->annual_leave->saveAnnualLeave($request);

            $status = $annual_leave->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Annual Paid leave successfully created.",
                ];
            } else {
                $return = [
                    'status' => 500,
                    'message' => 'Sorry! Operation failed'
                ];
            }
} else {
  log::info('hapapapa chini 1');
        $annual_leave = $this->annual_leave->saveAnnualUnpaidLeave($request);

            $status = $annual_leave->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Unpaid leave successfully created.",
                ];
            } else {
                $return = [
                    'status' => 500,
                    'message' => 'Sorry! Operation failed'
                ];
            }

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
public function retrieveAnnualLeaveDetails()
{
 $annual_leave =  $this->annual_leave->getAnnualLeave();

      return response()->json(["status" => 200, "annual_leave" => $annual_leave]);


}

}