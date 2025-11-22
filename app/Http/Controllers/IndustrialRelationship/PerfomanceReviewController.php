<?php

namespace App\Http\Controllers\IndustrialRelationship;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\IndustrialRelationship\PerfomanceReviewRepository;

class PerfomanceReviewController extends Controller
{
    protected $reviewes;

    public function __construct(PerfomanceReviewRepository $reviewes)
    {
        $this->reviewes = $reviewes;
    }

    public function retrieveEmployeeDetail($id)
    {

        $employee =  $this->reviewes->retrieveEmployeeDetails($id);

        return response()->json(["status" => 200, "employee" => $employee]);
    }
    public function getPerfomanceCriterial()
    {

        $perfomance_criterial =  DB::table('perfomance_criterials')->select('id', 'name', 'rate')->get();

        return response()->json(["status" => 200, "perfomance_criterial" => $perfomance_criterial]);
    }

    /**
     *@method to create paternity leave
     */
    public function  createPerfomanceReview(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // 'rate_creterial' => 'required|max:5',
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'review_date' => 'required|max:191',
            'review_description' => 'required',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {


            $reviewes = $this->reviewes->createPerfomanceReview($request);

            $status = $reviewes->getStatusCode();
            log::info('juuu');
            log::info(json_encode($status));

            if ($status == 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Perfomance review successfully created.",
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
    public function retrieveAllPerfomanceReview()
    {

        $perfomance_review =  $this->reviewes->retrieveAllPerfomanceReview();

        return response()->json(["status" => 200, "perfomance_review" => $perfomance_review]);
    }
    /**
     *@method to update paternity leave
     */
    public function  updatePerfomanceReview(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [

            'firstname' => 'required|max:191',
            // 'show_cause_letter_attachment' => 'required|',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {


            $reviewes = $this->reviewes->updatePerfomanceReview($request, $id);

            $status = $reviewes->getStatusCode();

            if ($status === 200) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Performance review successfully updated.",
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
    public function retrievePerfomanceReviewDetail($id)
    {

        $show_perfomance =  $this->reviewes->retrievePerfomanceReviewDetail($id);

        return response()->json(["status" => 200, "show_perfomance" => $show_perfomance]);
    }
    public function retrievePerfomanceReviewReport($id)
    {

        $performance_report =  $this->reviewes->retrievePerfomanceReviewReport($id);

        return response()->json(["status" => 200, "performance_report" => $performance_report]);
    }

    public function retrieveInitiatedPerfomance()
    {
        $reviews = $this->reviewes->retrieveInitiatedPerfomance();

        return response()->json(["status" => 200, "perfomance_review" => $reviews]);
    }

    public function retrievePerformanceWorkflow($performanceReviewId)
    {
        $workflow = $this->reviewes->retrievePerformanceWorkflow($performanceReviewId);

        return response()->json(["status" => 200, "performance_workflow" => $workflow]);
    }

    public function reInitiatePerformanceWorkflow(Request $request)
    {
        try {
            $this->reviewes->reInitiatePerformanceWorkflow($request);

            return response()->json([
                'status' => 200,
                'message' => 'Performance review successfully re-initiated.',
            ]);
        } catch (\Throwable $th) {
            Log::error('reInitiatePerformanceWorkflow error: ' . $th->getMessage());

            return response()->json([
                'status' => 500,
                'message' => 'Sorry! operation failed.',
            ], 500);
        }
    }

    public function reviewPerformanceWorkflow(Request $request)
    {
        try {
            $this->reviewes->reviewPerformanceWorkflow($request);

            return response()->json([
                'status' => 200,
                'message' => 'Performance review successfully reviewed.',
            ]);
        } catch (\Throwable $th) {
            Log::error('reviewPerformanceWorkflow error: ' . $th->getMessage());

            return response()->json([
                'status' => 500,
                'message' => 'Sorry! operation failed.',
            ], 500);
        }
    }

    public function returnPerformanceWorkflow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'performance_review_id' => 'required|integer',
            'return_to_user_id' => 'required|integer',
            'comments' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $this->reviewes->returnPerformanceWorkflow($request);

            return response()->json([
                'status' => 200,
                'message' => 'Performance review successfully returned.',
            ]);
        } catch (\Throwable $th) {
            Log::error('returnPerformanceWorkflow error: ' . $th->getMessage());

            return response()->json([
                'status' => 500,
                'message' => 'Sorry! operation failed.',
            ], 500);
        }
    }

    public function getPerformanceReturnRecipients($reviewId)
    {
        try {
            $recipients = $this->reviewes->getReturnRecipients($reviewId);

            return response()->json([
                'status' => 200,
                'recipients' => $recipients,
            ]);
        } catch (\Throwable $th) {
            Log::error('getPerformanceReturnRecipients error: ' . $th->getMessage());

            return response()->json([
                'status' => 500,
                'message' => 'Unable to load return recipients.',
            ], 500);
        }
    }

    public function approvePerformanceWorkflow(Request $request)
    {
        try {
            $this->reviewes->approvePerformanceWorkflow($request);

            return response()->json([
                'status' => 200,
                'message' => 'Performance review successfully approved.',
            ]);
        } catch (\Throwable $th) {
            Log::error('approvePerformanceWorkflow error: ' . $th->getMessage());

            return response()->json([
                'status' => 500,
                'message' => 'Sorry! operation failed.',
            ], 500);
        }
    }
    /**
     *@method to initiate performance review
     */
    public function initiatePerfomanceReview(Request $request, $id)
    {
        $reviewes = $this->reviewes->initiatePerfomanceReview($request, $id);



        $status = $reviewes->getStatusCode();

        if ($status === 200) {
            // log::info('ndani');
            $return = [
                'status' => 200,
                "message" => "Performance review successfully initiated.",
            ];
        } else {
            $return = [
                'status' => 500,
                'message' => 'Sorry! operation failed.'
            ];
        }

        return response()->json($return);
    }
     /**
     *@method to review/evaluate performance review
     */
    public function reviewInitiatedPerfomanceReview(Request $request, $id)
    {
        $reviewes = $this->reviewes->reviewInitiatedPerfomanceReview($request);



        $status = $reviewes->getStatusCode();

        if ($status === 200) {
            // log::info('ndani');
            $return = [
                'status' => 200,
                "message" => "Performance review successfully reviwed.",
            ];
        } else {
            $return = [
                'status' => 500,
                'message' => 'Sorry! operation failed.'
            ];
        }

        return response()->json($return);
    }
}
