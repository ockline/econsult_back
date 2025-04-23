<?php

namespace App\Http\Controllers\IndustrialRelationship;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\IndustrialRelationship\GrievanceRepository;


class GrievanceController extends Controller
{
    protected $grievances;

    public function __construct(GrievanceRepository $grievances)
    {
        $this->grievances = $grievances;
    }

    public function getEmployee($id)
    {

        $employee =  $this->grievances->retrieveEmployeeDetails($id);

        return response()->json(["status" => 200, "employee" => $employee]);
    }
    public function getMisconductType()
    {

        $misconduct_cause =  DB::table('misconduct_types')->select('id', 'name')->get();

        return response()->json(["status" => 200, "misconduct_cause" => $misconduct_cause]);
    }

    /**
     *@method to create paternity leave
     */
    public function  initiateEmployeeGrievance(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'grievance_reason' => 'required',
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'grievance_date' => 'required|max:191',
            'grievance_resolution' => 'required',

        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {


            $grievances = $this->grievances->initiateEmployeeGrievances($request);

            $status = $grievances->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Misconduct successfully created.",
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
    public function retrieveAllMisconduct()
    {

        $misconduct =  $this->grievances->retrieveAllMisconduct();

        return response()->json(["status" => 200, "misconduct" => $misconduct]);
    }
    /**
     *@method to update paternity leave
     */
    public function  updateMisconduct(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [

            'investigation_report_attachment' => 'required|max:191',
            // 'show_cause_letter_attachment' => 'required|',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {


            $grievances = $this->grievances->updateMisconduct($request, $id);

            $status = $grievances->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Misconduct successfully updated.",
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
    public function retrieveMisconductDetails($id)
    {

        $misconduct =  $this->grievances->retrieveMisconductDetails($id);

        return response()->json(["status" => 200, "misconduct" => $misconduct]);
    }
}
