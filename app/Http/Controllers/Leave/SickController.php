<?php

namespace App\Http\Controllers\Leave;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\LeaveRepositories\SickRepository;


class SickController extends Controller
{
    protected $sick_leave;

    public function __construct(SickRepository $sick_leave)
    {
        $this->sick_leave = $sick_leave;
    }

    public function getEmployee($id)
    {

        $employee =  $this->sick_leave->retrieveEmployeeDetails($id);

        return response()->json(["status" => 200, "employee" => $employee]);
    }
    /**
     *@method to create annual leave apid and un paid
     */
    public function  createSickLeave(Request $request)
    {

        // $date_check = $this->checkIfOneWeekLess($request);

        $validator = Validator::make($request->all(), [
            'leave_type' => 'required|max:5',
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'start_date' => 'required|max:191',
            'end_date' => 'required|',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
            if ($request->leave_type == 5) {

                $sick_leave = $this->sick_leave->saveFullPaidLeave($request);

                $status = $sick_leave->getStatusCode();

                if ($status === 200) {
                    // log::info('ndani');
                    $return = [
                        'status' => 200,
                        "message" => "Full paid leave successfully created.",
                    ];
                } else {
                    $return = [
                        'status' => 500,
                        'message' => 'Sorry! Operation failed'
                    ];
                }
            } else if ($request->leave_type == 6) {
                log::info('hapapapa chini 2');
                $sick_leave = $this->sick_leave->saveHalfPaidLeave($request);

                $status = $sick_leave->getStatusCode();

                if ($status === 200) {
                    // log::info('ndani');
                    $return = [
                        'status' => 200,
                        "message" => "Half paid leave successfully created.",
                    ];
                } else {
                    $return = [
                        'status' => 500,
                        'message' => 'Sorry! Operation failed'
                    ];
                }
            } else {
                $sick_leave = $this->sick_leave->saveUnpaidLeave($request);

                $status = $sick_leave->getStatusCode();

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
    public function retrieveSickLeaveDetails()
    {
        $sick_leave =  $this->sick_leave->getSickLeave();

        return response()->json(["status" => 200, "sick_leave" => $sick_leave]);
    }
/**
*@method to get
 */
public function  getSickLeaveDetail($leaveId)
    {

        $employee =  $this->sick_leave->retrieveSickLeaveDetails($leaveId);

        return response()->json(["status" => 200, "employee" => $employee]);
    }


    public function updateSickLeave(Request $request, $id,)
    {
        if ($request->leave_type == 5) {

            $sick_leave = $this->sick_leave->updateFullPaidLeave($request, $id);

            $status = $sick_leave->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Full paid leave successfully updated.",
                ];
            } else {
                $return = [
                    'status' => 500,
                    'message' => 'Sorry! Operation failed'
                ];
            }
        } else if ($request->leave_type == 6) {
            log::info('hapapapa chini 2');
            $sick_leave = $this->sick_leave->updateHalfPaidLeave($request, $id);

            $status = $sick_leave->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Half paid leave successfully updated.",
                ];
            } else {
                $return = [
                    'status' => 500,
                    'message' => 'Sorry! Operation failed'
                ];
            }
        } else {

            $sick_leave = $this->sick_leave->updateUnpaidLeave($request, $id);

            $status = $sick_leave->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Unpaid leave successfully updated.",
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
