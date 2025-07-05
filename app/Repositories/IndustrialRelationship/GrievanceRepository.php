<?php

namespace App\Repositories\IndustrialRelationship;


use Exception;
use Mpdf\Mpdf;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\IndustrialRelationship\Grievance\Grievance;
use App\Models\IndustrialRelationship\Misconduct\Misconduct;
use App\Models\IndustrialRelationship\Grievance\GrievanceWorkflow;
use App\Models\IndustrialRelationship\Grievance\GrievanceAttachment;


class GrievanceRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Grievance::class;


    protected $grievances;


    public function __construct(Grievance $grievances)
    {
        $this->grievances = $grievances;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $grievances = $this->grievances->where("id", $id)->first();

        if (!is_null($grievances)) {
            return $grievances;
        }
    }

    /**
     *@method to get all employees according to id
     */

    public function retrieveEmployeeDetails($id)
    {
        $data = DB::table('employees as e')->select('e.employee_no as employee_id', 'e.firstname', 'e.middlename', 'e.lastname', 'e.job_title_id', 'e.department_id', 'jt.name as job_title', 'dpt.name as departments', 'e.employer_id', 'emp.name as employer')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->where('e.employee_no', $id)
            ->first();

        return $data;
    }

    public function getDatatable()
    {
        $grievances = $this->grievances->get();
        return $grievances;
    }
    /**
     *@method to save annual leave paid according to  leave type
     */
    public function initiateEmployeeGrievances($request)
    {


        try {
            DB::beginTransaction(); // Proper transaction start

            $grievance = new Grievance();

            $data = [
                'employer_id' => $request->employer_id ?? null,
                'employee_id' => $request->employee_id ?? 2,
                'grievance_reason' => $request->grievance_reason ?? null,
                'grievance_resolution' => $request->grievance_resolution ?? null,
                'report_date' => $request->grievance_date ?? null,
                'initiated_by' => Auth::user()->id,
                'initiated_date' => now(),
                'status' => !empty($request->resolution) ? 'Resolved' : 'Initiated',
                'resolution' => $request->resolution,
                'resolution_date' => !empty($request->resolution) ? now() : null,
                'stage' => 'Preliminary Stage',
                'source' => 'System',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $grievance->fill($data);
            $grievance->save();

            $grievanceId = $grievance->id;

            // Check if the grievance was actually saved
            if (!$grievanceId) {
                throw new \Exception("Failed to save grievance");
            }

            // Continue workflow if grievance saved
            $workflow = $this->initiateWorkflow($request, $grievanceId);

            if (!$workflow) {
                throw new \Exception("Error on creating workflow");
            }

            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Grievance successfully created.']);
        } catch (\Exception $e) {
            DB::rollBack(); // Don't forget to roll back
            Log::error('Failure to save grievance: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'Failed to create grievance'], 500);
        }
    }

    /**
     *@method to  create workflow for grievances
     */
    public function initiateWorkflow($request, $grievanceId)
    {
        try {
            $workflow = new GrievanceWorkflow();

            if ($request->resolution == 'Yes') {
                $data = [
                    'grievance_id' => $grievanceId,
                    'comments' => $request->grievance_resolution ?? null,
                    'report_date' => $request->grievance_date ?? null,
                    'received_date' => now(),
                    'attended_by' => Auth::user()->id,
                    'attended_date' => now(),
                    'status' => 'Resolved',
                    'stage' => 'Preliminary Stage',
                    'function_name' => 'Grievance Initiation',
                    'previous_stage' => 'Grievance Initiator',
                    'next_stage' => Null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            $data = [
                'grievance_id' => $grievanceId,
                'comments' => $request->grievance_resolution ?? null,
                'report_date' => $request->grievance_date ?? null,
                'received_date' => now(),
                'attended_by' => Auth::user()->id,
                'attended_date' => now(),
                'status' => 'Initiated',
                'stage' => 'Preliminary Stage',
                'function_name' => 'Grievance Initiation',
                'previous_stage' => 'Grievance Initiator',
                'next_stage' => 'Grievance Reviewer',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $workflow->fill($data);
            $workflow->save();

            return true;
        } catch (\Throwable $th) {
            Log::error("Workflow initiation failed: " . $th->getMessage());
            throw new \Exception("Error on creating workflow", 1);
        }
    }

    /**
     *@method to check misconduct  if  exist before
     *if misconduct i greater than 2 should show warning that  this is  last misconduct
     */
    // public function checkMisconductExist($request)
    // {
    //     $data = DB::table('misconducts')
    //         ->where('employee_id', $request->employee_id)
    //         ->count();

    //     return $data;
    // }
    public function retrieveAllGrievances()
    {

        $data = DB::table('grievances as gr')->select(
            'gr.id',
            'gr.grievance_reason',
            'gr.grievance_resolution',
            DB::raw("TO_CHAR(gr.report_date::DATE, 'DD-Mon-YYYY') AS grievance_date"),
            //    DB::raw("CONCAT_WS(' ', e.firstname, e.middlename, e.lastname) as employee_name"),
            'e.employee_name',
            'gr.status',
            'gr.stage',
            'e.employee_no as employee_id',
            'e.middlename',
            'e.lastname',
            'e.firstname',
            'e.mobile_number',
            'e.job_title_id',
            'e.department_id',
            'jt.name as job_title',
            'dpt.name as departments',
            'e.employer_id',
            'emp.name as employer',

        )
            ->leftJoin('employees as e', 'gr.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', '=', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->orderBy('gr.id', 'DESC')
            ->get();

        return $data;
    }

    /**
     *@method to update misconduct
     */
    public function updateGrievance($request)
    {
        try {
            DB::beginTransaction();

            // Fetch the grievance
            $grievance = Grievance::where('id', $request->grievance_id)->first();

            if (!$grievance) {
                throw new \Exception("Grievance not found.");
            }

            $data = [
                'grievance_reason' => $request->grievance_reason ?? null,
                'grievance_resolution' => $request->grievance_resolution ?? null,
                'report_date' => $request->grievance_date ?? $grievance->report_date,
                'modified_by' => Auth::user()->id,
                'modified_date' => now(),
                'updated_at' => now(),
            ];

            $grievance->fill($data);
            $grievance->save(); // Use save(), not update()

            $grievanceId = $grievance->id;

            if (!$grievanceId) {
                throw new \Exception("Failed to save grievance");
            }

            // Save grievance document
            $grievanceDocument = $this->saveGrievanceDocument($request, $grievanceId);

            if (!$grievanceDocument) {
                throw new \Exception("Error on creating grievance document");
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Grievance successfully updated.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failure to update grievance: ' . $e->getMessage());

            return response()->json([
                'status' => 500,
                'message' => 'Failed to update grievance',
            ], 500);
        }
    }
    /***
     *@method to store supportive aatachment like  signed attachment , letter
     */
    public function saveGrievanceDocument($request, $grievanceId)
    {
        

        try {
            $documents = [];
            $documentTypes = ['grievance_supportive_doc', 'grievance_supportive_signed'];

            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType) && $grievanceId) {
                    $files = $request->file($documentType);

                    foreach ($files as $file) {
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('industrials/grievances/' . $grievanceId), $fileName);

                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType),
                            'description' => $fileName,
                            'document_group_id' => 15,
                            'grievance_id' => $grievanceId,
                        ];
                    }
                }
            }

            Log::info('nataka kusave document');

            foreach ($documents as $document) {
                GrievanceAttachment::create($document);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to save grievance document', ['error' => $e->getMessage()]);
            return false;
        }
    }


    public function getDocumentId($documentId)
    {
        // $document_id = [50,51]; required document
        //  $documentTypes = ['grievance_supportive_doc','grievance_supportive_signed'];
        switch ($documentId) {

            case 'grievance_supportive_doc';
                return 50;
                break;
            case 'grievance_supportive_signed';
                return 51;
                break;
            default:
                return null;
        }
    }
    /**
     *@method to get paternity leave according to id
     */
    public function retrieveSpecificGrievance($grievanceId)
    {
        $data = DB::table('grievances as gr')->select(
            'gr.id',
            'gr.grievance_reason',
            'gr.grievance_resolution',
            DB::raw("TO_CHAR(gr.report_date::DATE, 'DD-Mon-YYYY') AS grievance_date"),
            //    DB::raw("CONCAT_WS(' ', e.firstname, e.middlename, e.lastname) as employee_name"),
            'e.employee_name',
            'gr.status',
            'gr.stage',
            'e.employee_no as employee_id',
            'e.middlename',
            'e.lastname',
            'e.firstname',
            'e.mobile_number',
            'e.job_title_id',
            'e.department_id',
            'jt.name as job_title',
            'dpt.name as departments',
            'e.employer_id',
            'emp.name as employer',

        )
            ->leftJoin('employees as e', 'gr.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', '=', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->where('gr.id', $grievanceId)
            ->first();

        return $data;
    }
    /**
     *@method to retrieve  workflow based with grivance id
     */
    public function retrieveWorkflowGrievance($grievanceId)
    {
        $data = DB::table('grievance_workflows as gw')
            ->select(
                'gw.id',
                'gw.comments',
                'gw.action_taken',
                'gw.recommendation',
                'gw.result',
                'function_name',
                'gw.previous_stage',
                'gw.next_stage',
                DB::raw("TO_CHAR(gw.received_date::DATE, 'DD-Mon-YYYY') AS received_date"),
                DB::raw("TO_CHAR(gw.attended_date::DATE, 'DD-Mon-YYYY') AS action_date"),
                'gw.status',
                DB::raw("CONCAT_WS(' ', u.firstname, u.middlename, u.lastname) as attender"),
                'gw.stage'
            )
            ->leftJoin('users as u', DB::raw('CAST(u.id AS TEXT)'), '=', 'gw.attended_by') // 👈 Fix type mismatch
            ->where('gw.grievance_id', $grievanceId)
            ->orderBy('gw.id', 'ASC')
            ->get();

        return $data;
    }

    public function reviewWorkflowGrievance($request)
    {

        try {
            $workflowId =  GrievanceWorkflow::where('grievance_id', $request->grievance_id)->where('status', 'Initiated')->orderBy('id', 'DESC')->first();

            $workflow = new GrievanceWorkflow();

            $data = [
                'grievance_id' => $request->grievance_id,
                'parent_id' => $workflowId ? $workflowId->id : null,
                'comments' => $request->comment ?? 'null',
                'report_date' => $request->grievance_date ?? null,
                'received_date' => now(),
                'action_taken' => $request->action_taken ?? null,
                'recommendation' => $request->recommendation ?? null,
                'result' => $request->result ?? null,
                'attended_by' => Auth::user()->id,
                'attended_date' => now(),
                'status' => 'Review',
                'stage' => 'Secondary Stage',
                'function_name' => 'Grievance Reviewal',
                'previous_stage' => 'Grievance Reviewer',
                'next_stage' => 'Grievance Approver',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $workflow->fill($data);
            $workflow->save();

            if ($workflow) {
                $grievance_id = $workflow->grievance_id;
                Grievance::where('id', $grievance_id)->update([
                    'status' => 'Reviewed',
                    'stage' => 'Secondary Stage'
                ]);
            }

            return true;
        } catch (\Throwable $th) {
            Log::error("Workflow initiation failed: " . $th->getMessage());
            throw new \Exception("Error on creating workflow", 1);
        }
    }

    public function reviewalReturnGrievanceWorkflow($request)
    {

        try {
            $workflowId =  GrievanceWorkflow::where('grievance_id', $request->grievance_id)->where('status', 'Initiated')->orderBy('id', 'DESC')->first();

            $workflow = new GrievanceWorkflow();

            $data = [
                'grievance_id' => $request->grievance_id,
                'parent_id' => $workflowId ? $workflowId->id : null,
                'comments' => $request->comment ?? 'null',
                'report_date' => $request->grievance_date ?? null,
                'received_date' => now(),
                'action_taken' => $request->action_taken ?? null,
                'recommendation' => $request->recommendation ?? null,
                'result' => $request->result ?? null,
                'attended_by' => Auth::user()->id,
                'attended_date' => now(),
                'status' => 'Returned',
                'stage' => 'Secondary Stage',
                'function_name' => 'Grievance Reviewal',
                'previous_stage' => 'Grievance Reviewer',
                'next_stage' => 'Grievance Initiator',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $workflow->fill($data);
            $workflow->save();

            if ($workflow) {
                $grievance_id = $workflow->grievance_id;
                Grievance::where('id', $grievance_id)->update([
                    'status' => 'Returned',
                    'stage' => 'Priminary Stage'
                ]);
            }

            return true;
        } catch (\Throwable $th) {
            Log::error("Workflow initiation failed: " . $th->getMessage());
            throw new \Exception("Error on creating workflow", 1);
        }
    }
    public function approveWorkflowGrievance($request)
    {

        try {
            $workflowId =  GrievanceWorkflow::where('grievance_id', $request->grievance_id)->where('status', 'Reviewed')->orderBy('id', 'DESC')->first();

            $workflow = new GrievanceWorkflow();

            $data = [
                'grievance_id' => $request->grievance_id,
                'parent_id' => $workflowId ? $workflowId->id : null,
                'comments' => $request->comment ?? 'null',
                'report_date' => $request->grievance_date ?? null,
                'received_date' => now(),
                'action_taken' => $request->action_taken ?? null,
                'recommendation' => $request->recommendation ?? null,
                'result' => $request->result ?? null,
                'attended_by' => Auth::user()->id,
                'attended_date' => now(),
                'status' => 'Approved',
                'stage' => 'Final Stage',
                'function_name' => 'Grievance Approval',
                'previous_stage' => 'Grievance Approver',
                'next_stage' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $workflow->fill($data);
            $workflow->save();

            if ($workflow) {
                $grievance_id = $workflow->grievance_id;
                Grievance::where('id', $grievance_id)->update([
                    'status' => 'Approved',
                    'stage' => 'Final Stage'
                ]);
            }

            return true;
        } catch (\Throwable $th) {
            Log::error("Workflow initiation failed: " . $th->getMessage());
            throw new \Exception("Error on creating workflow", 1);
        }
    }
    public function approvalReturnWorkflowGrievance($request)
    {

        try {
            $workflowId =  GrievanceWorkflow::where('grievance_id', $request->grievance_id)->where('status', 'Initiated')->orderBy('id', 'DESC')->first();

            $workflow = new GrievanceWorkflow();

            $data = [
                'grievance_id' => $request->grievance_id,
                'parent_id' => $workflowId ? $workflowId->id : null,
                'comments' => $request->comment ?? 'null',
                'report_date' => $request->grievance_date ?? null,
                'received_date' => now(),
                'action_taken' => $request->action_taken ?? null,
                'recommendation' => $request->recommendation ?? null,
                'result' => $request->result ?? null,
                'attended_by' => Auth::user()->id,
                'attended_date' => now(),
                'status' => 'Approval Returned',
                'stage' => 'Secondary Stage',
                'function_name' => 'Grievance Reviewal',
                'previous_stage' => 'Grievance Approver',
                'next_stage' => 'Grievance Reviewer',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $workflow->fill($data);
            $workflow->save();

            if ($workflow) {
                $grievance_id = $workflow->grievance_id;
                Grievance::where('id', $grievance_id)->update([
                    'status' => 'Approval Returned',
                    'stage' => 'Secondary Stage'
                ]);
            }

            return true;
        } catch (\Throwable $th) {
            Log::error("Workflow initiation failed: " . $th->getMessage());
            throw new \Exception("Error on creating workflow", 1);
        }
    }
    /**
     *@method to get preview of Grievance  document
     */
    public function previewGrievanceDocument($id)
    {

        $data = DB::table('grievances as gr')->select(
            'gr.id',
            'gr.grievance_reason',
            'gr.grievance_resolution',
            DB::raw("TO_CHAR(gr.report_date::DATE, 'DD-Mon-YYYY') AS grievance_date"),
            'e.employee_name',
            'gr.status',
            'gr.stage',
            'e.employee_no as employee_id',
            'e.middlename',
            'e.lastname',
            'e.firstname',
            'e.mobile_number',
            'e.job_title_id',
            'e.department_id',
            DB::raw("CASE e.gender WHEN 1 THEN 'Male' WHEN 2 THEN 'Female' ELSE 'Unknown' END AS gender"),
            'jt.name as job_title',
            'dpt.name as departments',
            'e.employer_id',
            'emp.name as employer',
            DB::raw("CONCAT_WS(' ', u.firstname, u.middlename, u.lastname) as attender"),

        )
            ->leftJoin('employees as e', 'gr.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', '=', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->leftJoin('users as u', DB::raw('CAST(u.id AS TEXT)'), '=', 'gr.initiated_by')
            ->where('gr.id', $id)
            ->first();


        $reviewerDetails =  DB::table('grievance_workflows as gw')
            ->select(
                'gw.id',
                'gw.comments',
                'gw.action_taken',
                'gw.recommendation',
                'gw.result',
                'function_name',
                'gw.previous_stage',
                'gw.next_stage',
                DB::raw("TO_CHAR(gw.received_date::DATE, 'DD-Mon-YYYY') AS received_date"),
                DB::raw("TO_CHAR(gw.attended_date::DATE, 'DD-Mon-YYYY') AS action_date"),
                'gw.status',
                DB::raw("CONCAT_WS(' ', u.firstname, u.middlename, u.lastname) as manager_name"),
                'gw.stage'
            )
            ->leftJoin('users as u', DB::raw('CAST(u.id AS TEXT)'), '=', 'gw.attended_by')
            ->where('gw.grievance_id', $id)
            ->where('gw.status', 'Reviewed')
            ->first();

        $approverDetails =  DB::table('grievance_workflows as gw')
            ->select(
                'gw.id',
                'gw.comments',
                'gw.action_taken',
                'gw.recommendation',
                'gw.result',
                'function_name',
                'gw.previous_stage',
                'gw.next_stage',
                DB::raw("TO_CHAR(gw.received_date::DATE, 'DD-Mon-YYYY') AS received_date"),
                DB::raw("TO_CHAR(gw.attended_date::DATE, 'DD-Mon-YYYY') AS action_date"),
                'gw.status',
                DB::raw("CONCAT_WS(' ', u.firstname, u.middlename, u.lastname) as attender"),
                'gw.stage'
            )
            ->leftJoin('users as u', DB::raw('CAST(u.id AS TEXT)'), '=', 'gw.attended_by')
            ->where('gw.grievance_id', $id)
            ->where('gw.status', 'Approved')
            ->first();


        if (isset($data)) {
            $mpdf = new Mpdf();
            $mpdf->SetTitle('Grievance Form');
            $sheet = view('Industrials.grievances', [
                'data' => $data,
                'reviewerDetails' => $reviewerDetails,
                'approverDetails' => $approverDetails
            ]);
            $mpdf->WriteHTML($sheet);
            $reviews = base64_encode($mpdf->Output('', 'S'));

            return $reviews;
        }

        return $data;
    }
}
