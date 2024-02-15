<?php

namespace App\Repositories\HiringRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mews\Purifier\Facades\Purifier;
use App\Repositories\BaseREpository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Hiring\Interview\PracticalTestTranc;
use App\Models\Hiring\Interview\TechnicalInterview;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Models\Hiring\Interview\CompetencyTransaction;
use App\Models\Hiring\JobApplication\JobDescTransaction;
use App\Repositories\EmployerRepositories\EmployerRepository;



class TechnicalInterviewRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = TechnicalInterview::class;


    protected $employer;
    protected $candidate;

    public function __construct(TechnicalInterview $candidate, EmployerRepository $employer)
    {
        $this->employer = $employer;
        $this->candidate = $candidate;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */

    public function addCandidate($request)
    {

        Log::info($request->all());
        $candidate_number = $this->generateCandidateNo();
        //   log::info($candidate_number);

        DB::beginTransaction();

        try {
            $input = $request->all();

            $candidate =  $this->candidate->create([
                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                'cost_center_id' => !empty($input['cost_center_id']) ? $input['cost_center_id'] : null,
                'cost_number' => !empty($input['cost_number']) ? $input['cost_number'] : null,
                'date' => !empty($input['date']) ? $input['date'] : null,
                'firstname' => !empty($input['firstname']) ? $input['firstname'] : null,
                'middlename' => !empty($input['middlename']) ? $input['middlename'] : null,
                'lastname' => !empty($input['lastname']) ? $input['lastname'] : null,
                'interviewer' => !empty($input['interviewer']) ? $input['interviewer'] : null,
                'technical_skill' => !empty($input['technical_skill']) ? $input['technical_skill'] : 0,
                'relevant_experience' => !empty($input['relevant_experience']) ? $input['relevant_experience'] : 0,
                'knowledge_equipment' => !empty($input['knowledge_equipment']) ? $input['knowledge_equipment'] : 0,
                'quality_awareness' => !empty($input['quality_awareness']) ? $input['quality_awareness'] : 0,
                'skill_remark' => !empty($input['skill_remark']) ? $input['skill_remark'] : null,
                'experience_remark' => !empty($input['experience_remark']) ? $input['experience_remark'] : null,
                'equipment_remark' => !empty($input['equipment_remark']) ? $input['equipment_remark'] : null,
                'awareness_remark' => !empty($input['awareness_remark']) ? $input['awareness_remark'] : null,
                'physical_capability' => !empty($input['physical_capability']) ? $input['physical_capability'] : null,
                'capability_remark' => !empty($input['capability_remark']) ? $input['capability_remark'] : null,
                'practical_test_id' => !empty($input['practical_test_id']) ? $input['practical_test_id'] : null,
                'final_recommendation' => !empty($input['final_recommendation']) ? $input['final_recommendation'] : 0,
                'recommended_title' => !empty($input['recommended_title']) ? $input['recommended_title'] : $input['job_title_id'],
                'ranking_creterial_id' => !empty($input['ranking_creterial_id']) ? $input['ranking_creterial_id'] : null,
                'candidate_name' => ($input['firstname'] . " " . $input['middlename'] . " " . $input['lastname']),
                'overall_rating' => 0,
                'employer_id' =>  1,
                'interview_number' => !empty($candidate_number) ? $candidate_number : 22202,
                'downloaded' => 0, // default before download
                'uploaded' => 0,
                'uploaded_date' => null,
                'status' => 0, // submitted

            ]);

            DB::commit();

            // Log::info('Saved done');
            return response()->json(['message' => 'Technical Interview Created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create Technical Interview', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create Technical Interview', 'status' => 500]);
        }
    }
    public function generateCandidateNo()
    {
        // Get the current date and time
        $currentDateTime = date('Y-m-d H:i:s');

        // Concatenate the date and time
        $concatenatedString = $currentDateTime;

        // Generate an MD5 checksum
        $checksum = md5($concatenatedString);

        // Take the last 6 characters of the checksum
        $uniqueNumber = substr($checksum, -5);

        // Convert the result to an integer (optional)
        $uniqueNumber = hexdec($uniqueNumber);



        return  $uniqueNumber;
    }
    /**
     * @param $id
     * @return mixed
     * @competency transactions
     */
     public function practicalTestResult()
    {
        Log::info('Bondeni');

        $int = !empty($request['technical_skill']) ? $request['technical_skill'] : 0;
        $acc = !empty($request['relevant_experience']) ? $request['relevant_experience'] : 0;
        $wor = !empty($request['knowledge_equipment']) ? $request['knowledge_equipment'] : 0;
        $pl = !empty($request['quality_awareness']) ? $request['quality_awareness'] : 0;
        $pr = !empty($request['physical_capability']) ? $request['physical_capability'] : 0;


        $total_num = 5;
        $sum_competencies = ($int + $acc + $wor + $pl + $pr );
        $overall = $sum_competencies / $total_num;

        return round($overall);
    }
   public function getlastCandidate(){

  return  $this->candidate->select('*')->latest()->first();

}
    /**
     * @param $id
     * @return mixed
     * @competency transactions
     */
    public function savePracticalTestTranc($request, $candidate_id)
    {
        Log::info('unyama sana');
        $candidate = $this->getlastCandidate();
        // Log::info('###############');
        Log::info($request->all());

        // $overall = $this->practicalTestResult();

        // Log::info($overall);
        Log::info('************************************');



        DB::beginTransaction();

        try {
           // $input = $request->all();
            // Log::info($input);
            //    Log::info($overall);
            // log::info('mwamba competencies');

            $tech_candidate = new PracticalTestTranc();

            $tech_candidate->create([
                'practical_test_id' => !empty($practical_test_id) ? $practical_test_id : 1,
                'ranking_creterial_id' => !empty($request['ranking_creterial_id']) ? $request['ranking_creterial_id']: 0,
                'technical_interview_id' => !empty($candidate->id) ? $candidate->id : 1,
                 'test_marks' => !empty($request['test_marks']) ? $request['test_marks'] : 0,
                'practicl_test_remark' => !empty($request['practicl_test_remark']) ? $request['practicl_test_remark'] : 0,
                'description' => !empty($request['description']) ? $request['description'] : null,



            ]);
            DB::commit();

            return response()->json(['message' => 'Practical Test saved successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save practical test', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save on practical transactions', 'status' => 500]);
        }
        die;
    }
    /**
     * Method to Update assessed Candidate details
     */
    public function updateDetails($request, $id)
    {
        // Log::info('*******************************');

        $candidate_details = $this->candidate::where('id', $id)->first();

        //    die;
        if (isset($candidate_details)) {



            DB::beginTransaction();

            try {
                $input = $request->all();

                // $candidate_details->additional_comment = $request->input('additional_comment');

                //     $candidate_details->update();

                $candidate_details->update([
                    'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                    'cost_center_id' => !empty($input['cost_center_id']) ? $input['cost_center_id'] : null,
                    'cost_number' => !empty($input['cost_number']) ? $input['cost_number'] : null,
                    'date' => !empty($input['date']) ? $input['date'] : null,
                    'firstname' => !empty($input['firstname']) ? $input['firstname'] : null,
                    'middlename' => !empty($input['middlename']) ? $input['middlename'] : null,
                    'lastname' => !empty($input['lastname']) ? $input['lastname'] : null,
                    'interviewer' => !empty($input['interviewer']) ? $input['interviewer'] : null,
                    'technical_skill' => !empty($input['technical_skill']) ? $input['technical_skill'] : 0,
                    'relevant_experience' => !empty($input['relevant_experience']) ? $input['relevant_experience'] : 0,
                    'knowledge_equipment' => !empty($input['knowledge_equipment']) ? $input['knowledge_equipment'] : 0,
                    'quality_awareness' => !empty($input['quality_awareness']) ? $input['quality_awareness'] : 0,
                    'skill_remark' => !empty($input['skill_remark']) ? $input['skill_remark'] : null,
                    'experience_remark' => !empty($input['experience_remark']) ? $input['experience_remark'] : null,
                    'equipment_remark' => !empty($input['equipment_remark']) ? $input['equipment_remark'] : null,
                    'awareness_remark' => !empty($input['awareness_remark']) ? $input['awareness_remark'] : null,
                    'physical_capability' => !empty($input['physical_capability']) ? $input['physical_capability'] : null,
                    'capability_remark' => !empty($input['capability_remark']) ? $input['capability_remark'] : null,
                    'practical_test_id' => !empty($input['practical_test_id']) ? $input['practical_test_id'] : null,
                    'final_recommendation' => !empty($input['final_recommendation']) ? $input['final_recommendation'] : 0,
                    'recommended_title' => !empty($input['recommended_title']) ? $input['recommended_title'] : $input['job_title_id'],
                    'ranking_creterial_id' => !empty($input['ranking_creterial_id']) ? $input['ranking_creterial_id'] : null,
                    'candidate_name' => ($input['firstname'] . " " . $input['middlename'] . " " . $input['lastname']),
                    'overall_rating' => !empty($overall) ? $overall : 3,
                    'interview_number' => !empty($candidate_number) ? $candidate_number : 22202,
                    'downloaded' => 0, // default before download
                    'uploaded' => 0,
                    'uploaded_date' => null,
                    'status' => 0, // submitted

                ]);

                $interview_id = $candidate_details->id;
                $this->updateCompetencyTransaction($request, $interview_id);

                DB::commit();
                Log::info('updated done');

                return response()->json(['message' => 'Candidate Updated successfully', 'status' => 200], 200);
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Failed to update assessed candidate ', ['error' => $e->getMessage()]);

                return response()->json(['message' => 'Failed to Update assessed candidate', 'status' => 500]);
            }
        }
    }
    /**
     *Method to update competencies transaction
     */
    public function updateCompetencyTransaction($request, $interview_id)
    {


        $saved_data = $this->getCompetencyTransactions()->where('competency_interview_id', $interview_id)->first();
        // log::info($saved_data['interactive_communication']);
        // log::info('hureeee');
        // log::info($saved_data->interactive_communication);
        DB::beginTransaction();

        try {
            $input = $request->all();


            $competency =  CompetencyTransaction::where('competency_interview_id', $interview_id);

            $competency->update([
                'competency_id' => !empty($input['competency_id']) ? $input['competency_id'] : null,
                'competency__subject_id' => !empty($input['competency__subject_id']) ?: null,
                'competency_interview_id' => $interview_id,
                'description' => !empty($input['description']) ? $input['description'] : null,
                'interactive_communication' => !empty($input['interactive_communication']) ? $input['interactive_communication'] : $saved_data->interactive_communication,
                'accountability' => !empty($input['accountability']) ? $input['accountability'] : $saved_data->accountability,
                'work_excellence' => !empty($input['work_excellence']) ? $input['work_excellence'] : $saved_data->work_excellence,
                'planning_organizing' => !empty($input['planning_organizing']) ? $input['planning_organizing'] : $saved_data->planning_organizing,
                'problem_solving' => !empty($input['problem_solving']) ? $input['problem_solving'] : $saved_data->problem_solving,
                'analytical_ability' => !empty($input['analytical_ability']) ? $input['analytical_ability'] : $saved_data->analytical_ability,
                'attention_details' => !empty($input['attention_details']) ? $input['attention_details'] : $saved_data->attention_details,
                'initiative' => !empty($input['initiative']) ? $input['initiative'] : $saved_data->initiative,
                'multi_tasking' => !empty($input['multi_tasking']) ? $input['multi_tasking'] : $saved_data->multi_tasking,
                'continuous_improvement' => !empty($input['continuous_improvement']) ? $input['continuous_improvement'] : $saved_data->continuous_improvement,
                'compliance' => !empty($input['compliance']) ? $input['compliance'] : $saved_data->compliance,
                'creativity_innovation' => !empty($input['creativity_innovation']) ? $input['creativity_innovation'] : $saved_data->creativity_innovation,
                'negotiation' => !empty($input['negotiation']) ? $input['negotiation'] : $saved_data->negotiation,
                'team_work' => !empty($input['team_work']) ? $input['team_work'] : $saved_data->team_work,
                'adaptability_flexibility' => !empty($input['adaptability_flexibility']) ? $input['adaptability_flexibility'] : $saved_data->adaptability_flexibility,
                'leadership' => !empty($input['leadership']) ? $input['leadership'] : $saved_data->leadership,
                'delegating_managing' => !empty($input['delegating_managing']) ? $input['delegating_managing'] : $saved_data->delegating_managing,
                'managing_change' => !empty($input['managing_change']) ? $input['managing_change'] : $saved_data->managing_change,
                'strategic_conceptual_thinking' => !empty($input['strategic_conceptual_thinking']) ? $input['strategic_conceptual_thinking'] : $saved_data->strategic_conceptual_thinking,
                'interactive_communication_remark' => !empty($input['interactive_communication_remark']) ? $input['interactive_communication_remark'] : $saved_data->interactive_communication_remark,
                'accountability_remark' => !empty($input['accountability_remark']) ? $input['accountability_remark'] : $saved_data->accountability_remark,
                'work_excellence_remark' => !empty($input['work_excellence_remark']) ? $input['work_excellence_remark'] : $saved_data->work_excellence_remark,
                'planning_organizing_remark' => !empty($input['planning_organizing_remark']) ? $input['planning_organizing_remark'] : $saved_data->planning_organizing_remark,
                'problem_solving_remark' => !empty($input['problem_solving_remark']) ? $input['problem_solving_remark'] : $saved_data->problem_solving_remark,
                'analytical_ability_remark' => !empty($input['analytical_ability_remark']) ? $input['analytical_ability_remark'] : $saved_data->analytical_ability_remark,
                'attention_details_remark' => !empty($input['attention_details_remark']) ? $input['attention_details_remark'] : $saved_data->attention_details_remark,
                'initiative_remark' => !empty($input['initiative_remark']) ? $input['initiative_remark'] : $saved_data->initiative_remark,
                'multi_tasking_remark' => !empty($input['multi_tasking_remark']) ? $input['multi_tasking_remark'] : $saved_data->multi_tasking_remark,
                'continuous_improvement_remark' => !empty($input['continuous_improvement_remark']) ? $input['continuous_improvement_remark'] : $saved_data->continuous_improvement_remark,
                'compliance_remark' => !empty($input['compliance_remark']) ? $input['compliance_remark'] : $saved_data->compliance_remark,
                'creativity_innovation_remark' => !empty($input['creativity_innovation_remark']) ? $input['creativity_innovation_remark'] : $saved_data->creativity_innovation_remark,
                'negotiation_remark' => !empty($input['negotiation_remark']) ? $input['negotiation_remark'] : $saved_data->negotiation_remark,
                'team_work_remark' => !empty($input['team_work_remark']) ? $input['team_work_remark'] : $saved_data->team_work_remark,
                'adaptability_flexibility_remark' => !empty($input['adaptability_flexibility_remark']) ? $input['adaptability_flexibility_remark'] : $saved_data->adaptability_flexibility_remark,
                'leadership_remark' => !empty($input['leadership_remark']) ? $input['leadership_remark'] : $saved_data->leadership_remark,
                'delegating_managing_remark' => !empty($input['delegating_managing_remark']) ? $input['delegating_managing_remark'] : $saved_data->delegating_managing_remark,
                'managing_change_remark' => !empty($input['managing_change_remark']) ? $input['managing_change_remark'] : $saved_data->managing_change_remark,
                'strategic_conceptual_thinking_remark' => !empty($input['strategic_conceptual_thinking_remark']) ? $input['strategic_conceptual_thinking_remark'] : $saved_data->strategic_conceptual_thinking_remark,

            ]);



            DB::commit();
            //   Log::info('umefika kweli?');
            return response()->json(['message' => 'Competencie details updaded successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update competencies', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to update on competency transactions', 'status' => 500]);
        }
    }

    /**
     * Method to fetch HR Interviewed Candidate
     */
    public function getCandidate()
    {
        // return $this->assessment->get();

        return  DB::table('technical_interviews as ti')
            ->select([
                DB::raw('ti.job_title_id'),
                DB::raw('ti.id'),
                DB::raw('ti.date'),
                DB::raw('ti.interview_number'),
                DB::raw('ti.status'),
                DB::raw('ti.candidate_name'),
                DB::raw('ti.firstname'),
                DB::raw('ti.middlename'),
                DB::raw('ti.lastname'),
                DB::raw('ti.cost_number'),
                // DB::raw('ti.overall_rating'),
                DB::Raw("CASE WHEN ti.technical_skill = 0 THEN 'N/A (0)' WHEN ti.technical_skill = 1 THEN 'Below Average(1)' WHEN ti.technical_skill = 2 THEN 'Average (2)' WHEN ti.technical_skill = 3 THEN 'Good'  WHEN ti.technical_skill = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS technical_skill"),
                DB::Raw("CASE WHEN ti.relevant_experience = 0 THEN 'N/A (0)' WHEN ti.relevant_experience = 1 THEN 'Below Average(1)' WHEN ti.relevant_experience = 2 THEN 'Average (2)' WHEN ti.relevant_experience = 3 THEN 'Good'  WHEN ti.relevant_experience = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS relevant_experience"),
                DB::Raw("CASE WHEN ti.knowledge_equipment = 0 THEN 'N/A (0)' WHEN ti.knowledge_equipment = 1 THEN 'Below Average(1)' WHEN ti.knowledge_equipment = 2 THEN 'Average (2)' WHEN ti.knowledge_equipment = 3 THEN 'Good'  WHEN ti.knowledge_equipment = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS knowledge_equipment"),
                DB::Raw("CASE WHEN ti.quality_awareness = 0 THEN 'N/A (0)' WHEN ti.quality_awareness = 1 THEN 'Below Average(1)' WHEN ti.quality_awareness = 2 THEN 'Average (2)' WHEN ti.quality_awareness = 3 THEN 'Good'  WHEN ti.quality_awareness = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS quality_awareness"),
                DB::Raw("CASE WHEN ti.overall_rating = 0 THEN 'N/A' WHEN ti.overall_rating = 1 THEN 'Below Average' WHEN ti.overall_rating = 2 THEN 'Average' WHEN ti.overall_rating = 3 THEN 'Good'  WHEN ti.overall_rating = 4 THEN 'V.Good' ELSE 'Outstanding' END AS overall_rating"),
                DB::raw('ti.physical_capability'),
                DB::raw('ti.capability_remark'),
                DB::raw("CASE WHEN ti.downloaded  = 'true' THEN 'Yes' ELSE 'No' END AS downloaded "),
                DB::raw("CASE WHEN ti.uploaded  = 'true' THEN 'Yes' ELSE 'No' END AS uploaded "),
                DB::raw("CASE WHEN ti.final_recommendation  = 'true' THEN 'Accepted'  ELSE 'Not Accepted' END AS final_recommendation"),
                DB::raw('ti.skill_remark '),
                DB::raw('ti.experience_remark '),
                DB::raw('ti.equipment_remark '),
                DB::raw('ti.awareness_remark '),
                DB::raw('jt.name as job_title'),
                DB::raw('ti.skill_remark'),
                DB::raw('jt.name as recommended_title'),
                DB::raw('cc.name as cost_center'),
                // DB::raw(' ptt.accountability_remark  '),
                // DB::raw(' ptt.work_excellence_remark '),
                // DB::raw(' ptt.planning_organizing_remark '),
                // DB::raw(' ptt.problem_solving_remark  '),
                // DB::raw(' ptt.analytical_ability_remark '),
                DB::raw('CONCAT(u.firstname, \' \', u.middlename, \'.\', u.lastname) as interviewer_name'),

            ])
            ->leftJoin('job_title as jt', 'ti.job_title_id', '=', 'jt.id')
            ->leftJoin('cost_centers as cc', 'ti.cost_center_id', '=', 'cc.id')
            ->leftJoin('practical_test_tranc as ptt', 'ptt.technical_interview_id', '=', 'ti.id')
            ->leftJoin('employers as e', 'ti.employer_id', '=', 'e.id')
            ->leftJoin('users as u', 'u.employer_id', '=', 'e.id')
            ->orderBy('ti.id', 'DESC')
            ->get();
        //  log::info($assessed_candidate);
        //  return $assessed_candidate;
    }
    public function getCompetencyTransactions()
    {
return  DB::table('practical_test_tranc')->select('*')->get();
    }

    // public function showDownloadDetails()
    // {

    //     return  DB::table('competency_interviews as ci')
    //         ->select([
    //             DB::raw('ti.job_title_id'),
    //             DB::raw('ti.id'),
    //             DB::raw('ti.date'),
    //             DB::raw('ti.interview_number'),
    //             DB::raw('ti.status'),
    //             DB::raw('ti.candidate_name'),
    //             DB::raw('ti.firstname'),
    //             DB::raw('ti.middlename'),
    //             DB::raw('ti.lastname'),
    //             DB::raw('ti.cost_number'),
    //             // DB::raw('ti.overall_rating'),
    //             DB::Raw("CASE WHEN ti.technical_skill = 0 THEN 'N/A' WHEN ti.technical_skill = 1 THEN 'Below Average' WHEN ti.technical_skill = 2 THEN 'Average' WHEN ti.technical_skill = 3 THEN 'Good'  WHEN ti.technical_skill = 4 THEN 'V.Good' ELSE 'Outstanding' END AS technical_skill"),
    //             DB::Raw("CASE WHEN ti.relevant_experience = 0 THEN 'N/A' WHEN ti.relevant_experience = 1 THEN 'Below Average' WHEN ti.relevant_experience = 2 THEN 'Average' WHEN ti.relevant_experience = 3 THEN 'Good'  WHEN ti.relevant_experience = 4 THEN 'V.Good' ELSE 'Outstanding' END AS relevant_experience"),
    //             DB::Raw("CASE WHEN ti.knowledge_equipment = 0 THEN 'N/A' WHEN ti.knowledge_equipment = 1 THEN 'Below Average' WHEN ti.knowledge_equipment = 2 THEN 'Average' WHEN ti.knowledge_equipment = 3 THEN 'Good'  WHEN ti.knowledge_equipment = 4 THEN 'V.Good' ELSE 'Outstanding' END AS knowledge_equipment"),
    //             DB::Raw("CASE WHEN ti.quality_awareness = 0 THEN 'N/A' WHEN ti.quality_awareness = 1 THEN 'Below Average' WHEN ti.quality_awareness = 2 THEN 'Average' WHEN ti.quality_awareness = 3 THEN 'Good'  WHEN ti.quality_awareness = 4 THEN 'V.Good' ELSE 'Outstanding' END AS quality_awareness"),
    //             DB::Raw("CASE WHEN ti.overall_rating = 0 THEN 'N/A' WHEN ti.overall_rating = 1 THEN 'Below Average' WHEN ti.overall_rating = 2 THEN 'Average' WHEN ti.overall_rating = 3 THEN 'Good'  WHEN ti.overall_rating = 4 THEN 'V.Good' ELSE 'Outstanding' END AS overall_rating"),
    //             DB::raw('ti.physical_capability'),
    //             DB::raw('ti.capability_remark'),
    //             DB::raw('ti.practical_test_id'),
    //             DB::raw("CASE WHEN ti.downloaded  = 1 THEN 'Yes' ELSE 'No' END AS downloaded "),
    //             DB::raw("CASE WHEN ti.uploaded  = 1 THEN 'Yes' ELSE 'No' END AS uploaded "),
    //             DB::raw("CASE WHEN ti.final_recommendation  = 1 THEN 'Accepted' WHEN ti.final_recommendation  = 2 THEN 'Not Accepted' ELSE 'Waiting List' END AS final_recommendation "),
    //             DB::raw("CASE WHEN ti.surgery_operation  = 1 THEN 'Yes' ELSE 'No' END AS surgery_operation "),
    //             DB::raw('ti.skill_remark '),
    //             DB::raw('ti.experience_remark '),
    //             DB::raw('ti.equipment_remark '),
    //             DB::raw('ti.awareness_remark '),
    //             DB::raw('ti.surgery_operation_remark '),
    //             DB::raw('jt.name as job_title'),
    //             DB::raw('ti.skill_remark'),
    //             DB::raw('jt.name as recommended_title'),
    //             DB::raw('cc.name as cost_center'),
    //             DB::raw(' ptt.problem_solving_remark  '),
    //             DB::raw(' ptt.analytical_ability_remark '),
    //             DB::raw('CONCAT(u.firstname, \' \', u.middlename, \'.\', u.lastname) as interviewer_name'),
    //         ])
    //         ->leftJoin('job_title as jt', 'ti.job_title_id', '=', 'jt.id')
    //         ->leftJoin('cost_centers as cc', 'ti.cost_center_id', '=', 'cc.id')
    //         ->leftJoin('competencies_transactions as ptt', 'ptt.competency_interview_id', '=', 'ti.id')
    //         ->leftJoin('employers as e', 'ti.employer_id', '=', 'e.id')
    //         ->leftJoin('users as u', 'u.employer_id', '=', 'e.id')
    //         ->orderBy('ti.id', 'DESC')
    //         ->get();
    // }
}
