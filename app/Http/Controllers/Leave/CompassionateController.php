<?php

namespace App\Http\Controllers\Leave;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\LeaveRepositories\CompassionateRepository;

class CompassionateController extends Controller
{
 protected $compassionate;

    public function __construct(CompassionateRepository $compassionate)
    {
        $this->compassionate = $compassionate;
    }

public function getEmployee($id){

       $employee =  $this->compassionate->retrieveEmployeeDetails($id);

      return response()->json(["status" => 200, "employee" => $employee]);
}
/**
*@method to create leave
 */
public function  createCompassionateLeave(Request $request)
{



        $validator = Validator::make($request->all(), [
            'leave_type' => 'required|max:5',
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'start_date' => 'required|max:191',
            'end_date' => 'required|',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        }  else {


    $compassionate = $this->compassionate->saveCompassionateLeave($request);

            $status = $compassionate->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Compassionate leave successfully created.",
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

public function retrieveCompassionateLeaveDetails()
{
 $compassionate =  $this->compassionate->getCompassionateLeave();

      return response()->json(["status" => 200, "compassionate" => $compassionate]);


}
/**
*@method to get compassionate according to id
 */
public function getCompassionateDetail($leaveId)
{
$compassionate =  $this->compassionate->retrieveCompassionateLeave($leaveId);

      return response()->json(["status" => 200, "compassionate" => $compassionate]);
}

/**
*@method to update  compassionate leave
 */
public function  updateCompassionateLeave(Request $request, $id)
{



        $validator = Validator::make($request->all(), [
            'leave_type' => 'required|max:5',
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'start_date' => 'required|max:191',
            'end_date' => 'required|',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        }  else {


    $compassionate = $this->compassionate->updateCompassionateLeave($request,$id);

            $status = $compassionate->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Compassionate leave successfully updated.",
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

}
