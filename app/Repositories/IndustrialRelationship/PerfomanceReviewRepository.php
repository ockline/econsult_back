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
use App\Models\Workflow\PerformanceReviewWorkflow;
use App\Models\IndustrialRelationship\Misconduct\Misconduct;
use App\Models\IndustrialRelationship\PerfomanceReview\PerfomanceReview;


class PerfomanceReviewRepository extends  BaseRepository
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
     *@method to save perfomance review
     */
    public function createPerfomanceReview($request)
    {
        try {


            // Define rating fields
            $ratings = [
                'knowledge_skill_rating',
                'industry_knowledge_rating',
                'knowledge_effectively_rating',
                'work_accuracy_rating',
                'attention_to_detail_rating',
                'work_standards_rating',
                'workload_management_rating',
                'problem_solving_rating',
                'work_efficiency_rating',
                'communication_clarity_rating',
                'listening_skills_rating',
                'feedback_sharing_rating',
                'team_contribution_rating',
                'cooperation_rating',
                'work_environment_rating',
                'attendance_rating',
                'punctuality_rating',
                'absence_notification_rating',
                'adaptability_rating',
                'decision_making_rating',
                'innovation_rating',
                'customer_service_rating',
                'issue_resolution_rating',
                'customer_satisfaction_rating',
                'leadership_skills_rating',
                'team_guidance_rating',
                'decision_responsibility_rating'
            ];

            // Convert rating fields
            $ratingValues = [];
            foreach ($ratings as $field) {
                $ratingValues[$field] = is_numeric($request->input($field)) ? (int)$request->input($field) : 0;
            }

            Log::info('Processed Rating Values:', $ratingValues);

            // Calculate overall_rating
            $validRatings = array_filter($ratingValues, fn($value) => $value !== null);
            $overall_rating = !empty($validRatings) ? round(array_sum($validRatings) / count($validRatings), 2) : null;

            $review_exist = $this->checkPerfomanceReviewExist($request);

            $lastReviewer = PerfomanceReview::orderBy('reviewer_id', 'desc')->first();
            $nextReviewerId = $lastReviewer ? max($lastReviewer->reviewer_id + 1, 1001) : 1001;

            $perfomance_review = new PerfomanceReview();
            $data = [
                'reviewer_id' => $nextReviewerId,
                'rate_creterial' => $request->rate_creterial ?? 3,
                'employer_id' => $request->employer_id ?? null,
                'employer' => $request->employer ?? null,
                'employee_id' => $request->employee_id ?? 2,
                'count' => !empty($review_exist) ? (int)$review_exist + 1 : 1,
                'review_description' => $request->review_description ?? 'null',
                'review_attachment' => !empty($request->perfomance_review_attachment) ? 1 : 0,
                'review_date' => $request->review_date ?? null,
                'first_name' => $request->firstname ?? null,
                'middle_name' => $request->middlename ?? null,
                'last_name' => $request->lastname ?? null,
                'strengths' => $request->strength ?? null,
                'improvement_arears' => $request->improvement_areas ?? null,
                'improvement_plan' => $request->improvement_plan ?? null,
                'employee_comments' => $request->employee_comments ?? null,
                'final_rating_approval' => $request->final_rating_approval ?? null,
                'status' => 0,
                'stage' => 0,
                'employee_name' => trim("{$request->firstname} {$request->middlename} {$request->lastname}"),
                'overall_rating' => $overall_rating,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            // Merge rating values into $data
            $data = array_merge($data, $ratingValues);

            $perfomance_review->fill($data);
            $perfomance_review->save();

            return response()->json(['status' => 201, 'message' => 'Performance review successfully created'], 201);
        } catch (\Exception $e) {
            Log::error('Failure to save Performance Review error: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'An error occurred while saving the performance review'], 500);
        }
    }

    /**
     *@method to check perfomance review  if  exist before
     *if perfomance review i greater than 2 should show warning that  this is  last perfomance review
     */
    public function checkPerfomanceReviewExist($request)
    {
        $data = DB::table('performance_new_reviews')
            ->where('employee_id', $request->employee_id)
            ->orderBy('id', 'desc')->first();

        return $data;
    }
    public function retrieveAllPerfomanceReview()
    {
        $data = DB::table('performance_new_reviews as pr')->select(
            'pr.id',
            'pr.review_description',
            DB::raw("TO_CHAR(pr.review_date::DATE, 'DD-Mon-YYYY') AS review_date"),
            'pr.employee_name',
            'pr.count as review_number',
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
            DB::raw("
                CASE
                    WHEN ROUND(overall_rating) = 1 THEN 'Below'
                    WHEN ROUND(overall_rating) = 2 THEN 'Average'
                    WHEN ROUND(overall_rating) = 3 THEN 'GOOD'
                    WHEN ROUND(overall_rating) = 4 THEN 'V.GOOD'
                    WHEN ROUND(overall_rating) = 5 THEN 'OUTSTANDING'
                    ELSE 'NAN'
                END AS overall_rating
            "),
            DB::raw("
    CASE
        WHEN CAST(pr.status AS INTEGER) = 0 THEN 'Not Initiated'
        WHEN CAST(pr.status AS INTEGER) = 1 THEN 'Initiated'
        WHEN CAST(pr.status AS INTEGER) = 2 THEN 'Reviewed'
        WHEN CAST(pr.status AS INTEGER) = 3 THEN 'Approved'
        WHEN CAST(pr.status AS INTEGER) = 4 THEN 'Returned'
        WHEN CAST(pr.status AS INTEGER) = 5 THEN 'Rejected'
        ELSE 'NAN'
    END AS status
")


        )
            ->leftJoin('employees as e', 'pr.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')

            ->get();

        return $data;
    }

    /**
     *@method to update misconduct
     */
    public function updatePerfomanceReview($request, $id)
    {

        try {

            PerfomanceReview::find($id)->update([
                'review_date' => !empty($request->review_date) ? $request->review_date : null,
                'review_description' => !empty($request->review_description) ? $request->review_description : null,
                'review_attachment' => !empty($request->perfomance_review_attachment) ? 1 : 0,
                'updated_at' => Carbon::now(),
            ]);

            return response()->json(['status' => 200, 'message' => 'performance review successfuly updated']);
        } catch (\Exception $e) {
            log::error('Failure to  update performance error: ' . $e->getMessage());
        }
    }
    /**
     *@method to get paternity leave according to id
     */
    public function retrievePerfomanceReviewDetail($id)
    {

        $data = DB::table('performance_new_reviews as pr')->select(
            'pr.id',
            'pr.review_description',
            DB::raw("TO_CHAR(pr.review_date::DATE, 'DD-Mon-YYYY') AS review_date"),
            'pr.employee_name',
            'pr.count as review_number',
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
            DB::raw("
                CASE
                    WHEN ROUND(overall_rating) = 1 THEN 'Below'
                    WHEN ROUND(overall_rating) = 2 THEN 'Average'
                    WHEN ROUND(overall_rating) = 3 THEN 'GOOD'
                    WHEN ROUND(overall_rating) = 4 THEN 'V.GOOD'
                    WHEN ROUND(overall_rating) = 5 THEN 'OUTSTANDING'
                    ELSE 'NAN'
                END AS overall_rating
            "),
            DB::raw("
                    CASE
                        WHEN CAST(pr.status AS INTEGER) = 0 THEN 'Not Initiated'
                        WHEN CAST(pr.status AS INTEGER) = 1 THEN 'Initiated'
                        WHEN CAST(pr.status AS INTEGER) = 2 THEN 'Reviewed'
                        WHEN CAST(pr.status AS INTEGER) = 3 THEN 'Approved'
                        WHEN CAST(pr.status AS INTEGER) = 4 THEN 'Returned'
                        WHEN CAST(pr.status AS INTEGER) = 5 THEN 'Rejected'
                        ELSE 'NAN'
                    END AS status
                "),
            'knowledge_skill_rating',
            'industry_knowledge_rating',
            'knowledge_effectively_rating',
            'work_accuracy_rating',
            'attention_to_detail_rating',
            'work_standards_rating',
            'workload_management_rating',
            'problem_solving_rating',
            'work_efficiency_rating',
            'communication_clarity_rating',
            'listening_skills_rating',
            'feedback_sharing_rating',
            'team_contribution_rating',
            'cooperation_rating',
            'work_environment_rating',
            'attendance_rating',
            'punctuality_rating',
            'absence_notification_rating',
            'adaptability_rating',
            'decision_making_rating',
            'innovation_rating',
            'customer_service_rating',
            'issue_resolution_rating',
            'customer_satisfaction_rating',
            'leadership_skills_rating',
            'team_guidance_rating',
            'decision_responsibility_rating',
            'strengths',
            'improvement_areas',
            'improvement_plan',
            'employee_comments',
            'final_rating_approval',
            'performance_review_attachment',


        )
            ->leftJoin('employees as e', 'pr.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->where('pr.id', $id)
            ->first();

        return $data;
    }

    public function retrievePerfomanceReviewReport($id)
    {

        $data = DB::table('performance_new_reviews as pr')->select(
            'pr.id',
            'pr.review_description',
            DB::raw("TO_CHAR(pr.review_date::DATE, 'DD-Mon-YYYY') AS review_date"),
            'pr.employee_name',
            'pr.count as review_number',
            'e.employee_no as employee_id',
            'e.middlename',
            'e.lastname',
            'e.firstname',
            'e.mobile_number',
            'e.job_title_id',
            'e.department_id',
            'jt.name as job_title',
            'dpt.name as department',
            'e.employer_id',
            'emp.name as employer',
            DB::raw("
                CASE
                    WHEN ROUND(overall_rating) = 1 THEN 'Below'
                    WHEN ROUND(overall_rating) = 2 THEN 'Average'
                    WHEN ROUND(overall_rating) = 3 THEN 'GOOD'
                    WHEN ROUND(overall_rating) = 4 THEN 'V.GOOD'
                    WHEN ROUND(overall_rating) = 5 THEN 'OUTSTANDING'
                    ELSE 'NAN'
                END AS overall_rating
            "),
            DB::raw("
                    CASE
                        WHEN CAST(pr.status AS INTEGER) = 0 THEN 'Not Initiated'
                        WHEN CAST(pr.status AS INTEGER) = 1 THEN 'Initiated'
                        WHEN CAST(pr.status AS INTEGER) = 2 THEN 'Reviewed'
                        WHEN CAST(pr.status AS INTEGER) = 3 THEN 'Approved'
                        WHEN CAST(pr.status AS INTEGER) = 4 THEN 'Returned'
                        WHEN CAST(pr.status AS INTEGER) = 5 THEN 'Rejected'
                        ELSE 'NAN'
                    END AS status
                "),
            'knowledge_skill_rating',
            'industry_knowledge_rating',
            'knowledge_effectively_rating',
            'work_accuracy_rating',
            'attention_to_detail_rating',
            'work_standards_rating',
            'workload_management_rating',
            'problem_solving_rating',
            'work_efficiency_rating',
            'communication_clarity_rating',
            'listening_skills_rating',
            'feedback_sharing_rating',
            'team_contribution_rating',
            'cooperation_rating',
            'work_environment_rating',
            'attendance_rating',
            'punctuality_rating',
            'absence_notification_rating',
            'adaptability_rating',
            'decision_making_rating',
            'innovation_rating',
            'customer_service_rating',
            'issue_resolution_rating',
            'customer_satisfaction_rating',
            'leadership_skills_rating',
            'team_guidance_rating',
            'decision_responsibility_rating',
            'strengths',
            'improvement_areas',
            'improvement_plan',
            'employee_comments',
            'final_rating_approval',
            'performance_review_attachment',


        )
            ->leftJoin('employees as e', 'pr.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->where('pr.id', $id)
            ->first();

        $ratingMap = [
            5 => 'Excellent',
            4 => 'Good',
            3 => 'Satisfactory',
            2 => 'Needs Improvement',
            1 => 'Poor'
        ];


        if (isset($data)) {
            $mpdf = new Mpdf();
            $mpdf->SetTitle('Performance Review Report');
            $sheet = view('performance_reviews.performance_review', [
                'data' => $data,
                'ratingMap' => $ratingMap

            ]);
            $mpdf->WriteHTML($sheet);
            $reviews = base64_encode($mpdf->Output('', 'S'));

            // $details = ['data'  => $data,
            //           'reviews'  =>     $reviews
            //     ];
            return $reviews;
        }
    }
    public function initiatePerfomanceReview($request, $id)
    {

    log::info('ndaniiii');
log::info($request->all());

log::info('mchawi?'.  Auth::user()->id);

log::info($id);

        try {

            $review_workflow = new PerformanceReviewWorkflow();


            $review_workflow->review_id =$id;
            $review_workflow->comments =!empty($request->comments) ? $request->comments : null;
            $review_workflow->user_id =  Auth::user()->id;
            $review_workflow->attended_by = Auth::user()->id;
            $review_workflow->function_name = 'Review Initiation';
            $review_workflow->previous_stage = 'Review Initiator';
            $review_workflow->current_stage = 'Review Reviewer';
            $review_workflow->attended_date = Carbon::now();
            $review_workflow->status = 'Initiated';
         $initiation =   $review_workflow->save();


            if($initiation){
            //if create workflow successfully
                    PerfomanceReview::find($id)->update(["status"=> 1, 'stage' => 1]);
            }



            return response()->json(['status' => 200, 'message' => 'performance review successfuly initiated']);
        } catch (\Exception $e) {
            log::error('Failure to  initiate performance error: ' . $e->getMessage());
        }
    }
public function reviewInitiatedPerfomanceReview($request)
{
    try {

            $review_workflow = new PerformanceReviewWorkflow();


            $review_workflow->review_id =$request->id;
            $review_workflow->comments =!empty($request->comments) ? $request->comments : null;
            $review_workflow->user_id =  Auth::user()->id;
            $review_workflow->attended_by = Auth::user()->id;
            $review_workflow->function_name = 'Review Reviewal';
            $review_workflow->previous_stage = 'Review Reviewer';
            $review_workflow->current_stage = 'Review Approver';
            $review_workflow->attended_date = Carbon::now();
            $review_workflow->status = 'Reviewed';
            $reviewed =   $review_workflow->save();


            if($reviewed){
            //if create workflow successfully
                    PerfomanceReview::find($request->id)->update(["status"=> 2, 'stage' => 2]);
            }

            return response()->json(['status' => 200, 'message' => 'performance review successfuly reviewed']);
        } catch (\Exception $e) {
            log::error('Failure to  review performance error: ' . $e->getMessage());
        }

}

    protected function mapStageNumberToLabel($stageNumber): string
    {
        return match ((int) $stageNumber) {
            1 => 'Performance Review Reviewer',
            2 => 'Performance Review Approver',
            default => 'Performance Review Initiator',
        };
    }

    protected function mapStageLabelToNumber(?string $stageLabel): int
    {
        if (!$stageLabel) {
            return 0;
        }

        $label = strtolower($stageLabel);

        if (str_contains($label, 'approver')) {
            return 2;
        }

        if (str_contains($label, 'reviewer')) {
            return 1;
        }

        return 0;
    }

    public function retrievePerformanceWorkflow($performanceReviewId)
    {
        return DB::table('performance_review_workflows as prw')
            ->select(
                'prw.id',
                'prw.review_id',
                'prw.comments',
                'prw.status',
                'prw.function_name',
                'prw.previous_stage',
                'prw.current_stage',
                DB::raw('CAST(prw.attended_by AS BIGINT) AS attended_by'),
                'prw.return_to_user_id',
                'prw.return_to_user_name',
                DB::raw("TO_CHAR(prw.attended_date, 'DD-Mon-YYYY HH12:MI AM') AS attended_date"),
                DB::raw("CONCAT_WS(' ', u.firstname, u.middlename, u.lastname) as attender")
            )
            ->leftJoin('users as u', DB::raw('CAST(prw.attended_by AS BIGINT)'), '=', 'u.id')
            ->where('prw.review_id', $performanceReviewId)
            ->orderBy('prw.id', 'ASC')
            ->get();
    }

    public function getReturnRecipients($performanceReviewId)
    {
        $records = DB::table('performance_review_workflows as prw')
            ->select(
                'prw.id',
                DB::raw('CAST(prw.attended_by AS BIGINT) AS user_id'),
                'prw.previous_stage',
                'prw.current_stage',
                DB::raw("CONCAT_WS(' ', u.firstname, u.middlename, u.lastname) as name")
            )
            ->leftJoin('users as u', DB::raw('CAST(prw.attended_by AS BIGINT)'), '=', 'u.id')
            ->where('prw.review_id', $performanceReviewId)
            ->whereNotNull('prw.attended_by')
            ->orderBy('prw.id', 'DESC')
            ->get();

        return $records
            ->unique('user_id')
            ->filter(fn ($row) => !empty($row->user_id) && !empty($row->name))
            ->map(function ($row) {
                $stageLabel = $row->previous_stage ?? $row->current_stage ?? 'Performance Review Initiator';

                return [
                    'user_id' => (int) $row->user_id,
                    'name' => trim($row->name),
                    'stage_label' => $stageLabel,
                    'stage_value' => $this->mapStageLabelToNumber($stageLabel),
                ];
            })
            ->values();
    }

    public function retrieveInitiatedPerfomance()
    {
        return DB::table('performance_new_reviews as pr')
            ->select(
                'pr.id',
                'pr.employee_name',
                'pr.review_description',
                DB::raw("TO_CHAR(pr.review_date::DATE, 'DD-Mon-YYYY') AS review_date"),
                'pr.status',
                'pr.stage'
            )
            ->where('pr.status', 1)
            ->orderBy('pr.review_date', 'DESC')
            ->get();
    }

    public function reInitiatePerformanceWorkflow($request)
    {
        try {
            $reviewId = $request->performance_review_id;

            $workflow = new PerformanceReviewWorkflow();

            $workflow->fill([
                'review_id' => $reviewId,
                'comments' => $request->comment ?? null,
                'user_id' => Auth::user()->id,
                'attended_by' => Auth::user()->id,
                'function_name' => 'Performance Re-initiation',
                'previous_stage' => 'Performance Review Initiator',
                'current_stage' => 'Performance Review Reviewer',
                'attended_date' => Carbon::now(),
                'status' => 'Initiated',
            ]);
            $workflow->save();

            PerfomanceReview::find($reviewId)?->update(['status' => 1, 'stage' => 1]);

            return true;
        } catch (\Throwable $th) {
            Log::error('Performance review re-initiation failed: ' . $th->getMessage());
            throw $th;
        }
    }

    public function reviewPerformanceWorkflow($request)
    {
        try {
            $reviewId = $request->performance_review_id;

            $workflow = new PerformanceReviewWorkflow();
            $workflow->fill([
                'review_id' => $reviewId,
                'comments' => $request->comments ?? null,
                'user_id' => Auth::user()->id,
                'attended_by' => Auth::user()->id,
                'function_name' => 'Performance Review',
                'previous_stage' => 'Performance Review Reviewer',
                'current_stage' => 'Performance Review Approver',
                'attended_date' => Carbon::now(),
                'status' => 'Reviewed',
            ]);
            $workflow->save();

            PerfomanceReview::find($reviewId)?->update(['status' => 2, 'stage' => 2]);

            return true;
        } catch (\Throwable $th) {
            Log::error('Performance review evaluation failed: ' . $th->getMessage());
            throw $th;
        }
    }

    public function approvePerformanceWorkflow($request)
    {
        try {
            $reviewId = $request->performance_review_id;

            $workflow = new PerformanceReviewWorkflow();
            $workflow->fill([
                'review_id' => $reviewId,
                'comments' => $request->comments ?? null,
                'user_id' => Auth::user()->id,
                'attended_by' => Auth::user()->id,
                'function_name' => 'Performance Approval',
                'previous_stage' => 'Performance Review Approver',
                'current_stage' => 'Completed',
                'attended_date' => Carbon::now(),
                'status' => 'Approved',
            ]);
            $workflow->save();

            PerfomanceReview::find($reviewId)?->update(['status' => 3, 'stage' => 3]);

            return true;
        } catch (\Throwable $th) {
            Log::error('Performance review approval failed: ' . $th->getMessage());
            throw $th;
        }
    }

    public function returnPerformanceWorkflow($request)
    {
        try {
            $reviewId = $request->performance_review_id;
            $review = PerfomanceReview::find($reviewId);

            if (!$review) {
                throw new Exception('Performance review not found');
            }

            $returnToUserId = (int) ($request->return_to_user_id ?? 0);
            if ($returnToUserId <= 0) {
                throw new Exception('Return recipient is required.');
            }

            $targetWorkflow = PerformanceReviewWorkflow::where('review_id', $reviewId)
                ->where('attended_by', $returnToUserId)
                ->orderBy('id', 'DESC')
                ->first();

            $targetStageLabel = $targetWorkflow->previous_stage ?? $targetWorkflow->current_stage ?? 'Performance Review Initiator';
            $targetStage = $this->mapStageLabelToNumber($targetStageLabel);

            $recipientName = DB::table('users')
                ->select(DB::raw("CONCAT_WS(' ', firstname, middlename, lastname) as name"))
                ->where('id', $returnToUserId)
                ->value('name');

            $previousStage = $this->mapStageNumberToLabel($review->stage);

            $workflow = new PerformanceReviewWorkflow();
            $workflow->fill([
                'review_id' => $reviewId,
                'comments' => $request->comments ?? null,
                'user_id' => Auth::user()->id,
                'attended_by' => Auth::user()->id,
                'function_name' => 'Performance Return',
                'previous_stage' => $previousStage,
                'current_stage' => $targetStageLabel,
                'attended_date' => Carbon::now(),
                'status' => 'Returned',
                'return_to_user_id' => $returnToUserId,
                'return_to_user_name' => $recipientName,
            ]);
            $workflow->save();

            $review->update(['status' => 4, 'stage' => $targetStage]);

            return true;
        } catch (\Throwable $th) {
            Log::error('Performance review return failed: ' . $th->getMessage());
            throw $th;
        }
    }
}
