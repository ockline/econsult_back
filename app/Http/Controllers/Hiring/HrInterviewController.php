<?php

namespace App\Http\Controllers\Hiring;

use Illuminate\Http\Request;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Hiring\JobApplication\JobVacancy;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Repositories\EmployerRepositories\EmployerRepository;
use App\Repositories\HiringRepositories\HrInterviewRepository;

class HrInterviewController extends Controller
{
    protected $assessment;

    public function __construct(HrInterviewRepository $assessment)
    {
        $this->assessment = $assessment;
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
            'place_recruitment' => 'required|max:191',
            'year_experience' => 'required|max:10',
            'education_knowledge' => 'required|max:191',
            'relevant_experience' => 'required|max:191',
            'major_achievement' => 'required|max:191',
            'language_fluency_id' => 'required|max:191',
            // 'overall_rating' => 'required|max:191',
            'birth_place' => 'required|max:191',
            'residence_place' => 'required|max:191',
            'agreed_salary' => 'required|max:191',
            'recommended_title' => 'required|max:191',
            //   'salary_range' => 'required|max:191',

        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
            // Log::info('ndani ya nyumba');
            $overall =  $this->competenciesResult($request);
            $new_assessment = $this->assessment->addAssessment($request, $overall);

            $status = $new_assessment->getStatusCode();

            // Get HTTP status code
            $responseContent = $new_assessment->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Candidate assessement submitted",
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
     * to calculate overall rating automatically .
     */
    public function competenciesResult(Request $request)
    {
        // Log::info('Bondeni');

        $int = !empty($request['interactive_communication']) ? $request['interactive_communication'] : 0;
        $acc = !empty($request['accountability']) ? $request['accountability'] : 0;
        $wor = !empty($request['work_excellence']) ? $request['work_excellence'] : 0;
        $pl = !empty($request['planning_organizing']) ? $request['planning_organizing'] : 0;
        $pr = !empty($request['problem_solving']) ? $request['problem_solving'] : 0;
        $an = !empty($request['analytical_ability']) ? $request['analytical_ability'] : 0;
        $att = !empty($request['attention_Details']) ? $request['attention_Details'] : 0;
        $in = !empty($request['initiative']) ? $request['initiative'] : 0;
        $mu = !empty($request['multi_tasking']) ? $request['multi_tasking'] : 0;
        $con = !empty($request['continuous_improvement']) ? $request['continuous_improvement'] : 0;
        $com = !empty($request['compliance']) ? $request['compliance'] : 0;
        $cr = !empty($request['creativity_innovation']) ? $request['creativity_innovation'] : 0;
        $ne = !empty($request['negotiation']) ? $request['negotiation'] : 0;
        $tea = !empty($request['team_work']) ? $request['team_work'] : 0;
        $ada = !empty($request['adaptability_flexibility']) ? $request['adaptability_flexibility'] : 0;
        $lea = !empty($request['leadership']) ? $request['leadership'] : 0;
        $de = !empty($request['delegating_managing']) ? $request['delegating_managing'] : 0;
        $ma = !empty($request['managing_change']) ? $request['managing_change'] : 0;
        $str = !empty($request['strategic_conceptual_thinking']) ? $request['strategic_conceptual_thinking'] : 0;

        $total_num = 19;
        $sum_competencies = ($int + $acc + $wor + $pl + $pr + $an + $att + $in +  $mu + $con + $com + $cr + $ne + $tea + $ada + $lea + $de + $ma + $str);
        $overall = $sum_competencies / $total_num;

        return round($overall);
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $details = $this->assessment->getVacancies();
    //     $formData = $details->find($id);
    //     if (isset($formData)) {
    //         // Log::info('111');
    //         return response()->json([
    //             'status' => 200,
    //             'formData' => $formData
    //         ]);
    //     } else {
    //         // log::info('222');
    //         return response()->json([
    //             'status' => 500,
    //             'message' => "Internal server Error"
    //         ]);
    //     }
    // }

    public function edit(string $id)
    {
        // Log::info($id);

        // $assessmentList = $this->assessment(); // Assuming $assessmentList is an array of objects

        $assessment = CompetencyInterview::find($id);
        //   Log::info($assessmentList->$assessment);
        if (isset($assessment)) {
            return response()->json([
                'status' => 200,
                'assessment' => $assessment,
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
    public function update(Request $request, string $id)
    {
        $assessment = $this->assessment->updateDetails($request, $id);

        // $status = $assessment->getStatusCode();
        // // Log::info($status);
        // // Get HTTP status code
        // $responseContent = $assessment->getContent();

        //$status
        if ($assessment === 200) {
            // log::info('ndani');
            return response()->json([
                'status' => 200,
                "message" => "Assessment Updated Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'


            ]);
        }
    }


    // public function updateDescription(Request $request, string $id)
    // {
    //     //    Log::info($request->all());
    //     $job_description = $this->assessment->updateJobDescription($request, $id);

    //     $status = $job_description->getStatusCode();
    //     // Log::info($status);
    //     // Get HTTP status code
    //     $responseContent = $job_description->getContent();


    //     if ($status === 200) {
    //         // log::info('ndani');
    //         return response()->json([
    //             'status' => 200,
    //             "message" => "Job Description Updated Successfully",
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 500,
    //             'message' => 'Sorry! Operation failed'


    //         ]);
    //     }
    // }
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

    public function  assessedCandidate()
    {
        // Log::info('anafikaaa mkali');
        $assessment =    $this->assessment->getAssessedCandidate();
        // Log::info($assessment;
        if ($assessment) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'assessment' => $assessment
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
}
