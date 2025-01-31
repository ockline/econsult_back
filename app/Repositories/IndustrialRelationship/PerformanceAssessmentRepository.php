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
use App\Models\IndustrialRelationship\capacity\capacity;
use App\Models\IndustrialRelationship\PerfomanceReview\PerfomanceReview;
use App\Models\IndustrialRelationship\PerformanceCapacity\PerformanceCapacity;
use App\Models\IndustrialRelationship\PerformanceCapacity\performanceAssessment;


class PerformanceAssessmentRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = performanceAssessment::class;


    protected $capacity;


    public function __construct(performanceAssessment $capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $capacity = $this->capacity->where("id", $id)->first();

        if (!is_null($capacity)) {
            return $capacity;
        }
        // throw new GeneralException(trans('exceptions.operation.data_not_found'));
    }

    /**
     *@method to get all employees according to id
     */

    public function retrieveEmployeeCapacityDetails($id)
    {
        $data = DB::table('performance_capacities as pc')
            ->select(
                'pc.id as performance_capacity_id',
                'pc.investigation_report',
                'pc.investigation_date',
                'pc.investigation_time',
                'pc.subject_matter',
                'pc.investigator_name',
                'pc.investigator_signature',
                'pc.investigator_designation',
                'pc.suffering_from',
                'pc.suffering_period',
                'pc.daily_duties',
                'pc.challenge_daily_duties',
                'pc.alternative_task',
                'pc.partient_suggestion',
                'pc.incapacity_type as capacity_type_id',
                DB::raw("CASE WHEN pc.incapacity_type = 1 THEN 'Illness' ELSE 'Poor Performance' END as capacity_type"),
                DB::raw("CONCAT(firstname, ' ', middlename, ' ', lastname) AS employee_name"),
            'e.employee_no as employee_id', 'e.firstname', 'e.middlename', 'e.lastname', 'e.job_title_id', 'e.department_id', 'jt.name as job_title', 'dpt.name as departments', 'e.employer_id', 'emp.name as employer')
            ->leftJoin('employees as e', 'pc.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->where('e.employee_no', $id)
            ->first();

        return $data;
    }

    public function getDatatable()
    {
        $capacity = $this->capacity->get();
        return $capacity;
    }
    /**
     *@method to save perfomance review
     */
    public function createPerfomanceAssessment($request)
    {

        try {
            $review_exist = $this->checkPerfomanceCapacityExist($request);

            $perfomance_assessment = new PerformanceAssessment();
            $data = [
                'count' => !empty($review_exist) ? (int)$review_exist + 1 : 1,
                'capacity_id' => !empty($request->capacity_id) ? $request->capacity_id : 'null',
                'illness_cause' => !empty($request->illness_cause) ? $request->illness_cause : null,
                'illness_degree' => !empty($request->illness_degree) ? $request->illness_degree : null,
                'occupation_illnsess' => !empty($request->occupation_illnsess) ? $request->occupation_illnsess : null,
                'occupation_justification' => !empty($request->occupation_justification) ? $request->occupation_justification : null,
                'assessor_name' => !empty($request->assessor_name) ? $request->assessor_name : null,
                'assessor_signanture' => !empty($request->assessor_signanture) ? $request->assessor_signanture  : null,
                'assessment_date' => !empty($request->assessment_date) ? $request->assessment_date : null,
                'assessor_designantion' => !empty($request->assessor_designantion) ? $request->assessor_designantion : null,
                'possible_nature_illness' => !empty($request->possible_nature_illness) ? $request->possible_nature_illness : null,
                'permanent_alternative_activity' => !empty($request->permanent_alternative_activity) ? $request->permanent_alternative_activity : null,
                'sequence' => $count?? 0,
                'total_recovery_activity' => !empty($request->total_recovery_activity) ? $request->total_recovery_activity : null,
                'suggested_task' => !empty($request->suggested_task) ? $request->suggested_task : null,
                'measure_taken' => !empty($request->measure_taken) ? $request->measure_taken  : null,
                'assessor_recommendnation' => $request->assessor_recommendation ?? null,
                'assessment_signed_attachment' => $request->assessment_signed_attachment ?? null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'status' => null,
                'stage' => null,

            ];

            $perfomance_assessment->fill($data); // Fill the model with data
            $perfomance_assessment->save();

            return response()->json(['status' => 200, 'message' => 'Perfomance assessment successfuly created']);
        } catch (\Exception $e) {
            log::error('Failure to save Perfomance assessment error: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'Failure to save Perfomance assessment error']);
        }
    }
    /**
     *@method to check perfomance review  if  exist before
     *if perfomance review i greater than 2 should show warning that  this is  last perfomance review
     */
    public function checkPerfomanceCapacityExist($request)
    {
        $data = DB::table('performance_capacities')
            ->where('capacity_id', $request->capacity_id)
            ->count();

        return $data;
    }
    public function retrieveAllPerformanceCapacity()
    {
        $data = DB::table('performance_capacities as pc')->select(
            'pc.id',
            'pc.investigation_report',
            'pc.investigation_time',
            DB::raw("TO_CHAR(pc.investigation_date::DATE, 'DD-Mon-YYYY') AS investigation_date"),
            // 'pc.employee_name',
            'pc.subject_matter',
            'pc.investigator_name',
            // 'pc.count as review_number',
            'e.employee_no as employee_id',
            'e.middlename',
            'e.lastname',
            'e.firstname',
            DB::raw("CONCAT(COALESCE(e.firstname, ''), ' ', COALESCE(e.middlename, ''), ' ', COALESCE(e.lastname, '')) AS employee_name"),
            'e.mobile_number',
            'e.job_title_id',
            'e.department_id',
            'jt.name as job_title',
            'dpt.name as departments',
            'e.employer_id',
            'emp.name as employer',
        DB::raw("CASE pc.incapacity_type
                     WHEN 1 THEN 'Illness'
                     ELSE 'Poor Performance'
                 END as capacity_type")

        )
            ->leftJoin('employees as e', 'pc.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            // ->leftJoin('perfomance_criterials as pc', 'pr.rate_creterial', '=', 'pc.rate')
            ->get();

        return $data;
    }

    /**
     *@method to update capacity
     */
    public function updatePerformanceCapacity($request, $id)
    {

        try {

            PerformanceAssessment::find($id)->update([
                'investigation_date' => !empty($request->investigation_date) ? $request->investigation_date : null,
                'investigation_report' => !empty($request->investigation_report) ? $request->investigation_report : null,
                'subject_matter' => !empty($request->subject_matter) ? $request->subject_matter : null,
                'investigator_name' => !empty($request->investigator_name) ? $request->investigator_name : null,
                'suffering_from' => !empty($request->suffering_from) ? $request->suffering_from : null,
                'suffering_period' => !empty($request->suffering_period) ? $request->suffering_period : null,
                'daily_duties' => !empty($request->daily_duties) ? $request->daily_duties : null,
                'challenge_daily_duties' => !empty($request->challenge_daily_duties) ? $request->challenge_daily_duties : null,
                'alternative_task' => !empty($request->alternative_task) ? $request->alternative_task : null,
                'partient_suggestion' => !empty($request->partient_suggestion) ? $request->partient_suggestion : null,
                // 'review_attachment' => !empty($request->perfomance_capacity_attachment) ? 1 : 0,
                'updated_at' => Carbon::now(),
            ]);

            return response()->json(['status' => 200, 'message' => 'performance review successfuly updated']);
        } catch (\Exception $e) {
            log::error('Failure to  update performance error: ' . $e->getMessage());
        }
    }
    /**
     *@method to get parformance capacity according to id
     */
    public function retrievePerformanceCapacityDetail($id)
    {

         $data = DB::table('performance_capacities as pc')->select(
            'pc.id',
            'pc.investigation_report',
            'pc.investigation_time',
            DB::raw("TO_CHAR(pc.investigation_date::DATE, 'DD-Mon-YYYY') AS investigation_date"),
            // 'pc.employee_name',
            'pc.subject_matter',
            'pc.investigator_name',
            'pc.investigator_signature',
            'pc.investigator_designation',
            'pc.suffering_from',
            'pc.suffering_period',
            'pc.daily_duties',
            'pc.challenge_daily_duties',
            'pc.alternative_task',
            'pc.partient_suggestion',
            // 'pc.count as review_number',
            'e.employee_no as employee_id',
            'e.middlename',
            'e.lastname',
            'e.firstname',
            DB::raw("CONCAT(COALESCE(e.firstname, ''), ' ', COALESCE(e.middlename, ''), ' ', COALESCE(e.lastname, '')) AS employee_name"),
            'e.mobile_number',
            'e.job_title_id',
            'e.department_id',
            'jt.name as job_title',
            'dpt.name as departments',
            'e.employer_id',
            'emp.name as employer',
        DB::raw("CASE pc.incapacity_type
                     WHEN 1 THEN 'Illness'
                     ELSE 'Poor Performance'
                 END as capacity_type")

        )
            ->leftJoin('employees as e', 'pc.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->where('pc.id', $id)
            ->first();

        return $data;
    }
}
