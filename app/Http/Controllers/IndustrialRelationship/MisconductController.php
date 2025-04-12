<?php

namespace App\Http\Controllers\IndustrialRelationship;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\IndustrialRelationship\MisconductRepository;

class MisconductController extends Controller
{
    protected $misconducts;

    public function __construct(MisconductRepository $misconducts)
    {
        $this->misconducts = $misconducts;
    }

    public function getEmployee($id)
    {

        $employee =  $this->misconducts->retrieveEmployeeDetails($id);

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
    public function  createMisconduct(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'misconduct_cause' => 'required|max:5',
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'misconduct_date' => 'required|max:191',
            'investigation_report' => 'required|',
             'incidence_remarks' => 'required',
            'incidence_reported_by' =>'required',
            'incidence_reported_date' => 'required',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {


            $misconducts = $this->misconducts->saveMisconduct($request);

            $status = $misconducts->getStatusCode();

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

        $misconduct =  $this->misconducts->retrieveAllMisconduct();

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


            $misconducts = $this->misconducts->updateMisconduct($request, $id);

            $status = $misconducts->getStatusCode();

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

        $misconduct =  $this->misconducts->retrieveMisconductDetails($id);

        return response()->json(["status" => 200, "misconduct" => $misconduct]);
    }
}
