<?php

namespace App\Repositories\IndustrialRelationship;


use Exception;
use Mpdf\Mpdf;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;
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
    public function retrievePerfomaneReviewDetail($id)
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
            'knowledge_skill_rating', 'industry_knowledge_rating', 'knowledge_effectively_rating',
            'work_accuracy_rating', 'attention_to_detail_rating', 'work_standards_rating',
            'workload_management_rating', 'problem_solving_rating', 'work_efficiency_rating',
            'communication_clarity_rating', 'listening_skills_rating', 'feedback_sharing_rating',
            'team_contribution_rating', 'cooperation_rating', 'work_environment_rating',
            'attendance_rating', 'punctuality_rating', 'absence_notification_rating',
            'adaptability_rating', 'decision_making_rating', 'innovation_rating',
            'customer_service_rating', 'issue_resolution_rating', 'customer_satisfaction_rating',
            'leadership_skills_rating', 'team_guidance_rating', 'decision_responsibility_rating',
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

public function retrievePerfomaneReviewReport($id)
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
            'knowledge_skill_rating', 'industry_knowledge_rating', 'knowledge_effectively_rating',
            'work_accuracy_rating', 'attention_to_detail_rating', 'work_standards_rating',
            'workload_management_rating', 'problem_solving_rating', 'work_efficiency_rating',
            'communication_clarity_rating', 'listening_skills_rating', 'feedback_sharing_rating',
            'team_contribution_rating', 'cooperation_rating', 'work_environment_rating',
            'attendance_rating', 'punctuality_rating', 'absence_notification_rating',
            'adaptability_rating', 'decision_making_rating', 'innovation_rating',
            'customer_service_rating', 'issue_resolution_rating', 'customer_satisfaction_rating',
            'leadership_skills_rating', 'team_guidance_rating', 'decision_responsibility_rating',
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

}
