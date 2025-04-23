<?php

namespace App\Repositories\IndustrialRelationship;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\IndustrialRelationship\Grievance\Grievance;
use App\Models\IndustrialRelationship\Misconduct\Misconduct;


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
            'initiated_by' => Auth::user()->user_id,
            'initiated_date' => Carbon::now(),
            'status' => 'Initiated',
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
            $grievance = new Grievance();
            $data = [
                'grievance_id' => $grievanceId,
                'comments' => !empty($request->grievance_resolution) ? $request->grievance_resolution : null,
                'report_date' => $request->grievance_date ?? null,
                'received_date' => now(),
                'attended_by' => Auth::user()->user_id,
                'attended_date' =>  Carbon::now(),
                'status' => 'Initiated',
                'stage' => 'Priminary Stage',
                'function_name' => 'Grievance Initiation',
                'previous_stage' => 'Grievance Initiator',
                'next_stage' => 'Grievance Reviewer',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $grievance->fill($data); // Fill the model with data
            $grievance->save();
        } catch (\Throwable $th) {
            throw new Exception("Error on creating workflow", $th->getMessage());
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
    public function retrieveAllMisconduct()
    {


        $data = DB::table('misconducts as ms')->select(
            'ms.id',
            'ms.investigation_report',
            'ms.misconduct_cause',
            DB::raw("TO_CHAR(ms.misconduct_date::DATE, 'DD-Mon-YYYY') AS misconduct_date"),
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
            ->get();

        return $data;
    }

    /**
     *@method to update misconduct
     */
    public function updateMisconduct($request, $id)
    {

        try {

            Misconduct::find($id)->update([
                // 'misconduct_date' => !empty($request->misconduct_date) ? $request->misconduct_date : null,
                'misconduct_cause' => implode(',', $request->input('misconduct_cause')),

                'dismiss_remarks' => !empty($request->dismiss_remarks) ? $request->dismiss_remarks : null,
                'dismiss_date' => $request->dismiss_date ?? null,
                'incidence_remarks' =>  $request->incidence_remarks ?? null,
                'incidence_reported_by' => $request->incidence_reported_by ?? null,
                'incidence_reported_date' =>  $request->incidence_reported_date ?? null,
                'investigation_report_attachment' => !empty($request->investigation_report_attachment) ? 1 : 0,
                'show_cause_letter' => !empty($request->show_cause_letter) ? 1 : 0,
                'updated_at' => Carbon::now(),
            ]);

            return response()->json(['status' => 200, 'message' => 'Paternity Leave successfuly updated']);
        } catch (\Exception $e) {
            log::error('Failure to  update paternity error: ' . $e->getMessage());
        }
    }
    /**
     *@method to get paternity leave according to id
     */
    public function retrieveMisconductDetails($id)
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



        return $data;
    }
}
