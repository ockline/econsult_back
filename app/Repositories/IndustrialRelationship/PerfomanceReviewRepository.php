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
            $review_exist = $this->checkPerfomanceReviewExist($request);

            $perfomance_review = new PerfomanceReview();
            $data = [
                'rate_creterial' => !empty($request->rate_creterial) ? $request->rate_creterial : 3,
                'employer_id' => !empty($request->employer_id) ? $request->employer_id : null,
                'employee_id' => !empty($request->employee_id) ? $request->employee_id : 2,
                'count' => !empty($review_exist) ? (int)$review_exist + 1 : 1,
                'review_description' => !empty($request->review_description) ? $request->review_description : 'null',
                'review_attachment' => !empty($request->perfomance_review_attachment) ? 1 : 0,
                'review_date' => $request->review_date ?? null,
                'status' => null,
                'stage' => null,
                'employee_name' => !empty($request->firstname) ? ($request->firstname . " " . $request->middlename . " " . $request->lastname) : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ];

            $perfomance_review->fill($data); // Fill the model with data
            $perfomance_review->save();

            return response()->json(['status' => 200, 'message' => 'Perfomance review successfuly created']);
        } catch (\Exception $e) {
            log::error('Failure to save Perfomance Review error: ' . $e->getMessage());
        }
    }
    /**
     *@method to check perfomance review  if  exist before
     *if perfomance review i greater than 2 should show warning that  this is  last perfomance review
     */
    public function checkPerfomanceReviewExist($request)
    {
        $data = DB::table('perfomance_reviews')
            ->where('employee_id', $request->employee_id)
            ->count();

        return $data;
    }
    public function retrieveAllPerfomanceReview()
    {
        $data = DB::table('perfomance_reviews as pr')->select(
            'pr.id',
            'pr.review_description',
            'pr.rate_creterial',
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
            'pc.name as criterial',

        )
            ->leftJoin('employees as e', 'pr.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->leftJoin('perfomance_criterials as pc', 'pr.rate_creterial', '=', 'pc.rate')
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

        $data = DB::table('perfomance_reviews as pr')->select(
            'pr.id',
            'pr.review_description',
            'pr.rate_creterial',
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
            'pc.name as criterial',

        )
            ->leftJoin('employees as e', 'pr.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->leftJoin('perfomance_criterials as pc', 'pr.rate_creterial', '=', 'pc.rate')
            ->where('pr.id', $id)
            ->first();

        return $data;
    }
}
