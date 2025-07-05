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


    /**
     *@method to create initiate grievance
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
                    "message" => "Grievance successfully initiated.",
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
    /**
     *@method to retrieve all  misconduct details
     */
    public function retrieveAllGrievances()
    {

        $grievance =  $this->grievances->retrieveAllGrievances();

        return response()->json(["status" => 200, "grievance" => $grievance]);
    }
    /**
     *@method to update paternity leave
     */
    public function  updateGrievance(Request $request)
    {

        $validator = Validator::make($request->all(), [

'grievance_id' => 'required',
//   'grievance_supportive_doc' => 'required',
            // 'show_cause_letter_attachment' => 'required|',

        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {

            $grievances = $this->grievances->updateGrievance($request);

            $status = $grievances->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Grievance successfully updated.",
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
    public function retrieveSpecificGrievance($grievanceId)
    {

        $grievance =  $this->grievances->retrieveSpecificGrievance($grievanceId);

        return response()->json(["status" => 200, "grievance" => $grievance]);
    }
    public function retrieveWorkflowGrievance($grievanceId)
    {

        $grievance =  $this->grievances->retrieveWorkflowGrievance($grievanceId);

        return response()->json(["status" => 200, "grievance" => $grievance]);
    }
    /**
     *@method to review workflow
     */
    public function reviewWorkflowGrievance(Request $request)
    {
        $grievance =  $this->grievances->reviewWorkflowGrievance($request);

        return response()->json(["status" => 200, "grievance" => $grievance]);
    }
    /**
     *@method to return initiated Grievances
     */
    public function reviewalReturnGrievanceWorkflow(Request $request)
    {

        $grievance =  $this->grievances->reviewalReturnGrievanceWorkflow($request);

        return response()->json(["status" => 200, "grievance" => $grievance]);
    }
    /**
     *@method to approve grievance this don by menager and should have this role Grievance approver
     */
    public function approveWorkflowGrievance(Request $request)
    {

        $grievance =  $this->grievances->approveWorkflowGrievance($request);

        return response()->json(["status" => 200, "grievance" => $grievance]);
    }
    public function approvalReturnWorkflowGrievance(Request $request)
    {

        $grievance =  $this->grievances->approvalReturnWorkflowGrievance($request);

        return response()->json(["status" => 200, "grievance" => $grievance]);
    }
    /**
     *@method to retrieve  preview of  grievance document
     */
    public function previewGrievanceDocument($id)
    {
        $grievance =  $this->grievances->previewGrievanceDocument($id);

        return response()->json(["status" => 200, "grievance" => $grievance]);
    }
}
