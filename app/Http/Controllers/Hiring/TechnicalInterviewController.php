<?php

namespace App\Http\Controllers\Hiring;

use Illuminate\Http\Request;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Hiring\JobApplication\JobVacancy;
use App\Models\Hiring\Interview\PracticalTestTranc;
use App\Models\Hiring\Interview\TechnicalInterview;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Repositories\EmployerRepositories\EmployerRepository;
use App\Repositories\HiringRepositories\TechnicalInterviewRepository;

class TechnicalInterviewController extends Controller
{
    protected $candidate;

    public function __construct(TechnicalInterviewRepository $candidate)
    {
        $this->candidate = $candidate;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log::info('hellow ndani');
        // log::info($request->all());

        $validator = Validator::make($request->all(), [
            'job_title_id' => 'required|max:191',
            'date' => 'required|max:191',
            'firstname' => 'required|max:191',
            'middlename' => 'required|max:191',
            'lastname' => 'required|max:191',
            'interviewer' => 'required|max:191',
            'technical_skill' =>  'required|max:191',
            'relevant_experience' =>  'required|max:191',
            'knowledge_equipment' =>  'required|max:191',
            'quality_awareness' =>  'required|max:191',
            'physical_capability' =>  'required|max:191',
            'final_recommendation' =>  'required|max:191',
            'recommended_title' => 'required|max:191',




        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
            Log::info('ndani ya nyumba');
            // $overall =  $this->competenciesResult($request);
            $new_candidate = $this->candidate->addCandidate($request);

            $status = $new_candidate->getStatusCode();

            // // Get HTTP status code
            // $responseContent = $new_candidate->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Candidate Assessment submitted",
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
    public function savePractical(Request $request)
    {
          $validator = Validator::make($request->all(), [
            'practical_test_id' => 'required|max:191',
            'test_marks' => 'required|max:191',
            'ranking_creterial_id' => 'required|max:191',
         ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
       $Practical_test = $this->candidate->savePracticalTestTranc($request, $id = null);

        $status = $Practical_test->getStatusCode();

            // // Get HTTP status code
            // $responseContent = $new_candidate->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Candidate Assessment submitted",
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
public function lastCandidate()
{

  $overall = $this->candidate->getLastCandidatePracticals();
 $status = $overall->getStatusCode();
    //  log::info($status);
    if($status){
   return  response()->json(['status' => 200, 'message' => "Action successfull Completed"]);
        } else {

            return  response()->json(['status' => 500, 'message' => "Failured to update"]);
        }
}


    /**
     * Display the specified resource.
     */
    public function showCandidate(string $id)
    {
        $details = $this->candidate->showDownloadDetails();
        //   log::info($id);
        //  Log::info($details);
        $assessed = $details->where('id', $id)->first();

        // log::info("Date: " . $assessed);
        // log::info("Assessed Candidate: " . json_encode($assessed));
        $assessed_candidate =    json_encode((array)$assessed);
        // Log::info($assessed_candidate);

        // Add more properties as needed
        if (isset($assessed_candidate)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'assessed_candidate' => $assessed_candidate
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }

    public function editCandidate(string $id)
    {
        // Log::info($id);

        // $assessmentList = $this->assessment(); // Assuming $assessmentList is an array of objects

        $assessed_candidate = TechnicalInterview::find($id);
        //   Log::info($assessmentList->$assessed_candidate);
        if (isset($assessed_candidate)) {
            return response()->json([
                'status' => 200,
                'assessed_candidate' => $assessed_candidate,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCandidate(Request $request, string $id)
    {
        //   log::info('tumeeanza');
        // Log::info($request->all());
        $candidate = $this->candidate->updateDetails($request, $id);

        $status = $candidate->getStatusCode();
        // // Log::info($status);
        // // Get HTTP status code
        // $responseContent = $candidate->getContent();

        //$status
        if ($status === 200) {
            // log::info('ndani');
            return response()->json([
                'status' => 200,
                "message" => "Assessment details Updated Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Update process failed'


            ]);
        }
    }
   public function editPracticalCandidate(string $id)
    {

       $practical_candidate = PracticalTestTranc::select(['*',
                     DB::Raw("CASE WHEN practical_test_tranc.ranking_creterial_id = 0 THEN 'N/A (0)' WHEN practical_test_tranc.ranking_creterial_id = 1 THEN 'Below Average(1)' WHEN practical_test_tranc.ranking_creterial_id = 2 THEN 'Average (2)' WHEN practical_test_tranc.ranking_creterial_id = 3 THEN 'Good'  WHEN practical_test_tranc.ranking_creterial_id = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS ranking_creterial"),])
                    ->where('technical_interview_id', $id)
                    ->get();
        //
    //   log::info($practical_candidate);
        if (isset($practical_candidate)) {
            return response()->json([
                'status' => 200,
                'practical_candidate' => $practical_candidate,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }

    public function updatePracticalCandidate(Request $request, string $id)
    {
        //    Log::info($request->all());
        $job_description = $this->candidate->updatePracticalTestTranc($request, $id);

        $status = $job_description->getStatusCode();
        // Log::info($status);
        // Get HTTP status code
        $responseContent = $job_description->getContent();


        if ($status === 200) {
            // log::info('ndani');
            return response()->json([
                'status' => 200,
                "message" => "Job Description Updated Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'


            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $assessment = CompetencyInterview::find($id);
        // log::info($vacancy);

        // $mployer_deactivation = $this->assessment->deactivateAssessment($id);

        if ($assessment) {
            return response()->json([
                "status" =>  200,
                "message" => 'Record updated and deleted successfully'
            ]);
        } else {
            return response()->json([
                "status" =>  404,
                "assessment" => "Action Failed",
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */

    public function  candidate()
    {
        // Log::info('anafikaaa mkali');
        $candidate =    $this->candidate->getCandidate();
        // Log::info($candidate;
        if ($candidate) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'candidate' => $candidate
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
    // public function downloadJob(string $id)
    // {
    //     // log::info('ndanioiaiaiai');
    //     $details = $this->assessment->getAssessedCandidate();
    //     $assessment = $details->find($id);
    //     //  Log::info($assessment);
    //     if (isset($assessment)) {
    //         // Log::info('111');
    //         return response()->json([
    //             'status' => 200,
    //             'assessment' => $assessment
    //         ]);
    //     } else {
    //         // log::info('222');
    //         return response()->json([
    //             'status' => 500,
    //             'message' => "Internal server Error"
    //         ]);
    //     }
    // }
    public function candidateDocument(string $id)
{
  $document = $this->candidate->getCandidateDocument();
//   log::info($document);
        $candidate_document = $document->where('technical_interview_id', $id);


        if (isset($candidate_document)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'candidate_document' => $candidate_document
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
}
}
