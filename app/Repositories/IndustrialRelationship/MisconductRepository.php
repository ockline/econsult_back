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
use App\Models\IndustrialRelationship\Misconduct\Misconduct;
use App\Models\IndustrialRelationship\Misconduct\MisconductWorkflow;
use App\Models\IndustrialRelationship\Misconduct\MisconductAttachment;


class MisconductRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Misconduct::class;


    protected $misconduct;
    protected $disciplinary;

    public function __construct(Misconduct $misconduct, DisciplinaryRepository $disciplinary)
    {
        $this->misconduct = $misconduct;
        $this->disciplinary = $disciplinary;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $misconducts = $this->misconduct->where("id", $id)->first();

        if (!is_null($misconducts)) {
            return $misconducts;
        }
        // throw new GeneralException(trans('exceptions.operation.data_not_found'));
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
        $misconducts = $this->misconduct->get();
        return $misconducts;
    }
    /**
     *@method to save annual leave paid according to  leave type
     */
    public function saveMisconduct($request)
    {
        try {
            DB::beginTransaction();
            $misconduct_exist = $this->checkMisconductExist($request);

            $misconduct = new Misconduct();
            $data = [
                // 'misconduct_cause' => !empty($request->misconduct_cause) ? json_encode($request->misconduct_cause) : json_encode([4]),
                'misconduct_cause' => implode(',', $request->input('misconduct_cause')),
                'employer_id' => !empty($request->employer_id) ? $request->employer_id : null,
                'employee_id' => !empty($request->employee_id) ? $request->employee_id : 2,
                'count' => !empty($misconduct_exist) ? (int)$misconduct_exist + 1 : 1,
                'investigation_report' => !empty($request->investigation_report) ? $request->investigation_report : 'null',
                'investigation_report_attachment' => !empty($request->investigation_report) ? 1 : 0,
                'misconduct_date' => $request->misconduct_date ?? null,
                'dismiss_date' => $request->dismiss_date ?? null,
                'incidence_remarks' =>  $request->incidence_remarks ?? null,
                'incidence_reported_by' => $request->incidence_reported_by ?? null,
                'incidence_reported_date' =>  $request->incidence_reported_date ?? null,
                'status' => 'Initiated',
                'stage' => 1, //'Priminary Stage',
                'show_cause_letter' => $request->show_cause_letter ?? 0,
                'employee_name' => !empty($request->firstname) ? ($request->firstname . " " . $request->middlename . " " . $request->lastname) : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'initiated_by' => Auth::user()->id,
                'initiated_date' => now(),
            ];

            $misconduct->fill($data); // Fill the model with data
            $misconduct->save();

            $misconductId = $misconduct->id;

            // Check if the misconduct was actually saved
            if (!$misconductId) {
                throw new \Exception("Failed to save misconduct");
            }

            // Continue workflow if misconduct saved
            $workflow = $this->initiateWorkflow($request, $misconductId);

            if (!$workflow) {
                throw new \Exception("Error on creating workflow");
            }

            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Misconduct successfully created']);
        } catch (\Exception $e) {
            Log::error('Failure to save misconduct error: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'Failed to create misconduct'], 500);
        }
    }
    /**
     *@method to check misconduct  if  exist before
     *if misconduct i greater than 2 should show warning that  this is  last misconduct
     */
    public function checkMisconductExist($request)
    {
        $data = DB::table('misconducts')
            ->where('employee_id', $request->employee_id)
            ->count();

        return $data;
    }



    /**
     *@method to  create workflow for misconduct
     */
    public function initiateWorkflow($request, $misconductId)
    {
        try {
            $workflow = new MisconductWorkflow();

            $data = [
                'misconduct_id' => $misconductId,
                'comments' => $request->incidence_remarks ?? null,
                'report_date' => $request->misconduct_date ?? null,
                'received_date' => now(),
                'user_id' => Auth::user()->id,
                'attended_by' => Auth::user()->id,
                'attended_date' => now(),
                'status' => 'Initiated',
                'stage' =>  1, //'Preliminary Stage',
                'function_name' => 'Misconduct Initiation',
                'previous_stage' => 'Misconduct Initiator',
                'next_stage' => 'Misconduct Reviewer', //IR Personell
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

    public function retrieveAllMisconduct()
    {

        $data = DB::table('misconducts as ms')->select(
            'ms.id',
            'ms.investigation_report',
            'ms.misconduct_cause',
            DB::raw("TO_CHAR(ms.misconduct_date::DATE, 'DD-Mon-YYYY') AS misconduct_date"),
            'ms.employee_name',
            'ms.count as misconduct_number',
            'ms.status',
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
            'mt.name as misconduct'
        )
            ->leftJoin('employees as e', 'ms.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', '=', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->leftJoin('misconduct_types as mt', function ($join) {
                $join->on(
                    DB::raw("CASE
                WHEN ms.misconduct_cause IS NOT NULL AND ms.misconduct_cause::text IS NOT NULL
                    AND ms.misconduct_cause::text ~ '^\\[.*\\]$'
                THEN (json_extract_path_text(ms.misconduct_cause::json, '0'))::bigint
                ELSE NULL
            END"),
                    '=',
                    'mt.id'
                );
            })
            ->orderBy('ms.id', 'DESC')
            ->get();

        return $data;
    }

    /**
     *@method to update misconduct
     */
    public function updateMisconduct($request, $id)
{
    try {
        $misconductCause = $request->input('misconduct_cause');
        $misconductCauseString = is_array($misconductCause) ? implode(',', $misconductCause) : $misconductCause;

        $updated = Misconduct::find($id)->update([
            'misconduct_cause' => $misconductCauseString,
            'dismiss_remarks' => !empty($request->dismiss_remarks) ? $request->dismiss_remarks : null,
            'dismiss_date' => $request->dismiss_date ?? null,
            'incidence_remarks' => $request->incidence_remarks ?? null,
            'incidence_reported_by' => $request->incidence_reported_by ?? null,
            'incidence_reported_date' => $request->incidence_reported_date ?? null,
            'investigation_report_attachment' => !empty($request->investigation_report_attachment) ? 1 : 0,
            'show_cause_letter' => !empty($request->show_cause_letter) ? 1 : 0,
            'updated_at' => Carbon::now(),
        ]);

        Log::info($request->all());

        if ($updated) {

            $this->saveSupportiveDocument($request, $id);
        }

        return response()->json(['status' => 200, 'message' => 'Misconduct successfully updated']);
    } catch (\Exception $e) {
        Log::error('Failure to update misconduct error: ' . $e->getMessage());
        return response()->json(['status' => 500, 'message' => 'Update failed']);
    }
}

/**
*@method to save supportive attachment
 */
  public function saveSupportiveDocument($request, $id)
    {

        try {
            $documents = [];
            $documentTypes = ['misconducts_supportive_doc', 'misconducts_supportive_signed', 'investigation_report_attachment', 'notice_appear_attachment', 'show_cause_letter_attachment'];

            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType) && $id) {
                    $files = $request->file($documentType);

                    foreach ($files as $file) {
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('industrials/misconducts/' . $id), $fileName);

                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType),
                            'description' => $fileName,
                            'document_group_id' => 15,
                            'misconduct_id' => $id,
                        ];
                    }
                }
            }
            foreach ($documents as $document) {
                MisconductAttachment::create($document);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to save misconduct document', ['error' => $e->getMessage()]);
            return false;
        }
    }

    public function getDocumentId($documentId)
    {
        // $document_id = [50,51]; required document
        //  $documentTypes = ['misconduct_supportive_doc','misconduct_supportive_signed', 'notice_appear',];
        switch ($documentId) {
        case 'misconduct_supportive_doc':
        return 52;
        break;
        case 'misconduct_supportive_signed':
            return 53;
            break;
        case 'investigation_report_attachment':
            return 54;
            break;
        case 'notice_appear_attachment':
            return 55;
            break;
        case 'show_cause_letter_attachment':
        return 56;
        break;
            default:
                return null;
        }
    }
    /**
     *@method to get paternity leave according to id
     */
    public function retrieveMisconductDetails($id)
    {
        $data = DB::table('misconducts as ms')
            ->select(
                'ms.id',
                'ms.investigation_report',
                'ms.misconduct_cause',
                DB::raw("TO_CHAR(ms.misconduct_date::DATE, 'DD-Mon-YYYY') AS misconduct_date"),
                DB::raw("TO_CHAR(ms.incidence_reported_date::DATE, 'DD-Mon-YYYY') AS incidence_reported_date"),
                'ms.show_cause_letter as show_cause',
                'ms.incidence_remarks',
                'ms.dismiss_remarks',
                DB::raw("TO_CHAR(ms.dismiss_date::DATE, 'DD-Mon-YYYY') AS dismiss_date"),
                'ms.employee_name',
                'ms.status',
                'ms.stage',
                'ms.count as misconduct_number',
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
                // DB::raw("STRING_AGG(DISTINCT mt.name, ', ') as misconduct")
            )
            ->leftJoin('employees as e', 'ms.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', '=', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            // ->leftJoin('misconduct_types as mt', DB::raw('misconduct_ids.value::bigint'), '=', 'mt.id')
            ->where('ms.id', $id)
            ->first();
        // Add the CROSS JOIN LATERAL for misconduct_ids
        // ->crossJoin(DB::raw('LATERAL CASE
        //                 WHEN jsonb_typeof(ms.misconduct_cause) = \'array\'
        //                 THEN jsonb_array_elements_text(CAST(ms.misconduct_cause AS jsonb))
        //                 ELSE jsonb_build_array(ms.misconduct_cause)::text[]
        //               END AS misconduct_ids(value)'))

        // ->groupBy(
        //     'ms.id',
        //     'ms.investigation_report',
        //     'ms.misconduct_cause',
        //     'ms.misconduct_date',
        //     'ms.show_cause_letter',
        //     'ms.employee_name',
        //     'ms.count',
        //     'e.employee_no',
        //     'e.middlename',
        //     'e.lastname',
        //     'e.firstname',
        //     'e.mobile_number',
        //     'e.job_title_id',
        //     'e.department_id',
        //     'jt.name',
        //     'dpt.name',
        //     'e.employer_id',
        //     'emp.name'
        // )
        // ->limit(1);

        // Get the result

        return $data;
    }
    /**
     *@method to  create workflow for misconduct
     */
    public function reviewWorkflow($request, $misconductId)
    {

        try {
            $workflow = new MisconductWorkflow();

            $data = [
                'misconduct_id' => $misconductId,
                'comments' => $request->incidence_remarks ?? null,
                'case_decision' => $request->case_decision ?? null,
                'action_taken' => $request->action_taken ?? null,
                'attended_by' => Auth::user()->id,
                'attended_date' => now(),
                'decision_release_date' => now(),
                'status' => 'Reviewed',
                'stage' =>  2, //'Secondary Stage',
                'function_name' => 'Misconduct Reviewal',
                'previous_stage' => 'Misconduct Reviewer', //IR officer
                'next_stage' => 'Misconduct Approver', //IR Personell
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
     *@method to retrieve  workflow based with misconduct id
     */
    public function retrieveWorkflowMisconduct($misconductId)
    {
        $data = DB::table('misconduct_workflows as mw')
            ->select(
                'mw.id',
                'mw.comments',
                'mw.action_taken',
                'mw.case_decision',
                'mw.misconduct_id',
                'mw.function_name',
                'mw.previous_stage',
                'mw.next_stage',
                DB::raw("TO_CHAR(mw.decision_release_date::DATE, 'DD-Mon-YYYY') AS decision_release_date"),
                'mw.status',
                DB::raw("CONCAT_WS(' ', u.firstname, u.middlename, u.lastname) as attender"),
                'mw.stage'
            )
            ->leftJoin('users as u', 'u.id', '=', 'mw.attended_by')
            ->where('mw.misconduct_id', $misconductId)
            ->orderBy('mw.id', 'ASC')
            ->get();

        return $data;
    }


    public function previewMisconductDocument($id)
    {

        $data =
            DB::table('misconducts as ms')
            ->select(
                'ms.id',
                'ms.investigation_report',
                'ms.misconduct_cause',
                DB::raw("TO_CHAR(ms.misconduct_date::DATE, 'DD-Mon-YYYY') AS misconduct_date"),
                'ms.show_cause_letter as show_cause',
                'ms.employee_name',
                'ms.count as misconduct_number',
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
                DB::raw("STRING_AGG(DISTINCT mt.name, ', ') as misconduct")
            )
            ->leftJoin('employees as e', 'ms.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', '=', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->crossJoin(DB::raw('LATERAL jsonb_array_elements_text(CAST(ms.misconduct_cause AS jsonb)) AS misconduct_ids(value)'))
            ->leftJoin('misconduct_types as mt', DB::raw('misconduct_ids.value::bigint'), '=', 'mt.id')
            ->where('ms.id', $id)
            ->groupBy(
                'ms.id',
                'ms.investigation_report',
                'ms.misconduct_cause',
                'ms.misconduct_date',
                'ms.show_cause_letter',
                'ms.employee_name',
                'ms.count',
                'e.employee_no',
                'e.middlename',
                'e.lastname',
                'e.firstname',
                'e.mobile_number',
                'e.job_title_id',
                'e.department_id',
                'jt.name',
                'dpt.name',
                'e.employer_id',
                'emp.name'
            )
            ->first();

        if (isset($data)) {
            $mpdf = new Mpdf();
            $mpdf->SetTitle('Misconduct Report');
            $sheet = view('Industrials.grievances', [
                'data' => $data,
                // 'reviewerDetails' => $reviewerDetails,
                // 'approverDetails' => $approverDetails
            ]);
            $mpdf->WriteHTML($sheet);
            $reviews = base64_encode($mpdf->Output('', 'S'));

            return $reviews;
        }

        return $data;
    }
public function reviewMisconductWorkflow($request)
{

    try {
        // Get the initial workflow for the given misconduct ID and status
        $initialWorkflow = MisconductWorkflow::where('misconduct_id', $request->misconduct_id)
            ->where('status', 'Initiated')
            ->first();

        // Ensure the initial workflow exists
        if (!$initialWorkflow) {
            throw new \Exception("Initial misconduct workflow not found");
        }
                  $misconductId =  $request->misconduct_id;
          if($request->case_decision === 'Gross Misconduct'){
                $this->disciplinary->disciplinaryInitatiation($request, $misconductId);
            }
        // Prepare data for the new workflow stage
        $data = [
            'misconduct_id'    => $request->misconduct_id,
            'parent_id'  =>  $initialWorkflow->id,
            'comments'         => $request->comments ?? null,
            'report_date'      => $request->misconduct_date ?? null,
            'case_decision' => $request->case_decision ?? null,
            'action_taken' => $request->action_taken ?? null,
            'received_date'    => now(),
            'user_id'          => Auth::user()->id,
            'attended_by'      => Auth::user()->id,
            'attended_date'    => now(),
            'status'           => 'Reviewed',
            'stage'            => 2, // e.g. Preliminary Stage
            'function_name'    => 'Misconduct Reviewal',
            'previous_stage'   => 'Misconduct Reviewer',
            'next_stage'       => null, // IR will decide the next stage
            'created_at'       => now(),
            'updated_at'       => now(),
        ];

        // Create and save the new workflow
        $workflow = new MisconductWorkflow();
        $workflow->fill($data);
        $workflow->save();

        // Verify that the workflow saved correctly
        if (!$workflow->id) {
            throw new \Exception("Failed to save workflow");
        }

        // Update the status in the misconduct table
        $updated = Misconduct::where('id', $request->misconduct_id)
            ->where('status', 'Initiated')
            ->update(['status' => 'Reviewed']);

        if (!$updated) {
            throw new \Exception("Failed to update misconduct status");
        }

        return true;

    } catch (\Throwable $th) {
        Log::error("Workflow review failed: " . $th->getMessage());
        throw new \Exception("Error on update workflow", 1);
    }
}

}
