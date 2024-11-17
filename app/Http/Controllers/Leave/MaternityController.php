<?php

namespace App\Http\Controllers\Leave;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\LeaveRepositories\AnnualRepository;
use App\Repositories\LeaveRepositories\MaternityRepository;

class MaternityController extends Controller
{
    protected $maternity_leave;

    public function __construct(MaternityRepository $maternity_leave)
    {
        $this->maternity_leave = $maternity_leave;
    }

    public function getEmployee($id)
    {

        $employee =  $this->maternity_leave->retrieveEmployeeDetails($id);

        return response()->json(["status" => 200, "employee" => $employee]);
    }
    /**
     *@method to create annual leave apid and un paid
     */
    public function  createMaternityLeave(Request $request)
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


            $maternity_leave = $this->maternity_leave->saveMaternityLeave($request);
            log::info(json_encode($maternity_leave));
            $status = $maternity_leave->getStatusCode();
                log::info(json_encode($status));
            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Materinty leave successfully created.",
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
*@method to update  details
 */
 public function  updateMaternityLeave(Request $request, $id)
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


            $maternity_leave = $this->maternity_leave->updateMaternityLeave($request, $id);
                // log::info($maternity_leave);
            $status = $maternity_leave->getStatusCode();
        //    log::info($status);
            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Materinty leave successfully updated.",
                ];
            } else if($status === 500) {
                $return = [
                    'status' => 500,
                    'message' => 'Sorry! Operation failed'
                ];
                }else if($status === 422){
                     $return = [
                    'status' => 422,
                    'message' => 'Your leave exceeds your remaining balance'
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
    public function retrieveMaternityLeaveDetails()
    {
        $maternity_leave =  $this->maternity_leave->getMaternityLeave();

        return response()->json(["status" => 200, "maternity_leave" => $maternity_leave]);
    }
}
