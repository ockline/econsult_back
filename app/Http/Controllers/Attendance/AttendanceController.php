<?php

namespace App\Http\Controllers\Attendance;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;
use App\Repositories\AttendanceRepositories\AttendanceRepository;

class AttendanceController extends Controller
{
    protected $attendance;

    public function __construct(AttendanceRepository $attendance)
    {
        $this->attendance = $attendance;
    }

    public function getEmployee($id)
    {

        $employee =  $this->attendance->retrieveEmployeeDetails($id);

        return response()->json(["status" => 200, "employee" => $employee]);
    }
    /**
     *@method to create annual leave apid and un paid
     */
    public function  createAttendanceRecord(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'attendance_attachment' => 'required|mimes:xlsx'
        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
            $attendance = $this->attendance->createAttendanceRecord($request);

            $status = $attendance->getStatusCode();

            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Attendance successfully uploaded.",
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
     *method to retrive latest monthly attendance for  filtering
     */
    public function getMonthlyAttendanceDetails()
    {
        $attendance =  $this->attendance->getMonthlyAttendanceDetails();

        return response()->json(["status" => 200, "attendance" => $attendance]);
    }
    public function getAttendanceDetails($id)
    {
        $employee =  $this->attendance->retrieveAttendanceDetails($id);

        return response()->json(["status" => 200, "employee" => $employee]);
    }
    /**
     *@method to update attendance
     */
    public function updateAttendance(Request $request, $id)
    {

        $attendance = $this->attendance->updateAttendance($request, $id);

        $status = $attendance->getStatusCode();

        if ($status === 200) {
            // log::info('ndani');
            $return = [
                'status' => 200,
                "message" => "Attendance successfully updated.",
            ];
        } else {
            $return = [
                'status' => 500,
                'message' => 'Sorry! Operation failed'
            ];
        }

        return response()->json($return);
    }

public function generateMonthlyAttendance(Request $request)
{

 $attendance =  $this->attendance->exportAttendanceDetails($request);

        return response()->json(["status" => 200, "attendance" => $attendance]);

}




    /**
     * ********************************** OVERTIME BLOCK *****************************************
     */
    public function retrieveAllOverTimeDetails()
    {

        $attendance =  $this->attendance->getAllOverTimeDetails();

        return response()->json(["status" => 200, "attendance" => $attendance]);
    }
    /**
     *@method to save uploaded overtime request
     */
    public function  createOvertimeRecordUploaded(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'overtime_attachment' => 'required|mimes:xlsx'
        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
            $attendance = $this->attendance->createOvertimeRecordUploaded($request);

            $status = $attendance->getStatusCode();

            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Overtime successfully uploaded.",
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

    public function createOvertimeRecord(Request $request)
    {

        $days_check = $this->checkIfHourExceed($request);

        $validator = Validator::make($request->all(), [

            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'ot_hours' => 'required|max:191',
            'overtime_date' => 'required|',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } elseif ($days_check) {

            $return = [
                'status' => 404,
                "message" => "Sorry your overtime hour exceed  maximum time for overtime application  should not be greater than maximum",
            ];
        } else {


            $overtime = $this->attendance->saveOvertimeRequest($request);

            $status = $overtime->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Overtime successfully created.",
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
     *@method to check if overtime exceed 8 hour per day
     */
    public function checkIfHourExceed($request)
    {

        return $request->ot_hours > 8;
    }
}
