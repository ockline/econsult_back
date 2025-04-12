<?php

namespace App\Repositories\IndustrialRelationship;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\IndustrialRelationship\Misconduct\Misconduct;


class MisconductRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Misconduct::class;


    protected $misconduct;


    public function __construct(Misconduct $misconduct)
    {
        $this->misconduct = $misconduct;
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
                'status' => null,
                'stage' => null,
                'show_cause_letter' => $request->show_cause_letter ?? 0,
                'employee_name' => !empty($request->firstname) ? ($request->firstname . " " . $request->middlename . " " . $request->lastname) : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $misconduct->fill($data); // Fill the model with data
            $misconduct->save();

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
    public function retrieveAllMisconduct()
    {
        // $data = DB::table('misconducts as ms')->select(
        //     'ms.id',
        //     'ms.investigation_report',
        //     'ms.misconduct_cause',
        //     DB::raw("TO_CHAR(ms.misconduct_date::DATE, 'DD-Mon-YYYY') AS misconduct_date"),
        //     'ms.employee_name',
        //     'ms.count as misconduct_number',
        //     'e.employee_no as employee_id',
        //     'e.middlename',
        //     'e.lastname',
        //     'e.firstname',
        //     'e.mobile_number',
        //     'e.job_title_id',
        //     'e.department_id',
        //     'jt.name as job_title',
        //     'dpt.name as departments',
        //     'e.employer_id',
        //     'emp.name as employer',
        //     'mt.name as misconduct',
        // )
        //     ->leftJoin('employees as e', 'ms.employee_id', '=', 'e.employee_no')
        //     ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
        //     ->leftJoin('departments as dpt', 'e.department_id', '=', 'dpt.id')
        //     ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
        //     ->leftJoin('misconduct_types as mt', function ($join) {
        //         $join->on(
        //             DB::raw("(json_extract_path_text(ms.misconduct_cause::json, '0'))::bigint"),
        //             '=',
        //             'mt.id'
        //         );
        //     })
        //     ->get();

        // // Decode the misconduct_cause JSON after retrieval
        // foreach ($data as $item) {
        //     $item->misconduct_cause = json_decode($item->misconduct_cause, true); // Decode JSON to array
        // }

        // return $data;



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
