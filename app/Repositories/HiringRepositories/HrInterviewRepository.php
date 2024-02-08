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
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Models\Hiring\JobApplication\JobDescTransaction;
use App\Repositories\EmployerRepositories\EmployerRepository;



class HrInterviewRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = CompetencyInterview::class;


    protected $employer;
    protected $assessment;

    public function __construct(CompetencyInterview $assessment, EmployerRepository $employer)
    {
        $this->employer = $employer;
        $this->assessment = $assessment;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */

    public function addAssessment($request, $overall)
    {
        // Log::info($overall);
        Log::info('************************************8');

        $candidate_number = $this->generateCandidateNo();
        //   log::info($candidate_number);

        DB::beginTransaction();

        try {
            $input = $request->all();
            // Log::info($input);
            //    Log::info($overall);
            log::info('mwamba juu');
            // log::info($employer_number);
            // log::info('mwamba chini');
            // $fileName = time().'.'.$request->file->extension();

            // $request->file->move(public_path('uploads'), $fileName);

       $assessment =  $this->assessment->create([
                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                'cost_center_id' => !empty($input['cost_center_id']) ? $input['cost_center_id'] : null,
                'cost_number' => !empty($input['cost_number']) ? $input['cost_number'] : null,
                'date' => !empty($input['date']) ? $input['date'] : null,
                'firstname' => !empty($input['firstname']) ? $input['firstname'] : null,
                'middlename' => !empty($input['middlename']) ? $input['middlename'] : null,
                'lastname' => !empty($input['lastname']) ? $input['lastname'] : null,
                'interviewer' => !empty($input['interviewer']) ? $input['interviewer'] : null,
                'military_service' => !empty($input['military_service']) ? $input['military_service'] : 2,
                'military_number' => !empty($input['military_number']) ? $input['military_number'] : null,
                'place_recruitment' => !empty($input['place_recruitment']) ? $input['place_recruitment'] : null,
                'year_experience' => !empty($input['year_experience']) ? $input['year_experience'] : null,
                'education_knowledge' => !empty($input['education_knowledge']) ? $input['education_knowledge'] : 0,
                'relevant_experience' => !empty($input['relevant_experience']) ? $input['relevant_experience'] : 0,
                'major_achievement' => !empty($input['major_achievement']) ? $input['major_achievement'] : 0,
                'language_fluency_id' => !empty($input['language_fluency_id']) ? $input['language_fluency_id'] : 0,
                'education_knowledge_remark' => !empty($input['education_knowledge_remark']) ? $input['education_knowledge_remark'] : null,
                'relevant_experience_remark' => !empty($input['relevant_experience_remark']) ? $input['relevant_experience_remark'] : null,
                'major_achievement_remark' => !empty($input['major_achievement_remark']) ? $input['major_achievement_remark'] : null,
                'language_fluency_remark' => !empty($input['language_fluency_remark']) ? $input['language_fluency_remark'] : null,
                'main_strength' => !empty($input['main_strength']) ? $input['main_strength'] : null,
                'main_weakness' => !empty($input['main_weakness']) ? $input['main_weakness'] : null,
                'birth_place' => !empty($input['birth_place']) ? $input['birth_place'] : null,
                'relative_inside' => !empty($input['relative_inside']) ? $input['relative_inside'] : 2,
                'relative_name' => !empty($input['relative_name']) ? $input['relative_name'] : null,
                'chronic_disease' => !empty($input['chronic_disease']) ? $input['chronic_disease'] : 2,
                'chronic_remarks' => !empty($input['chronic_remarks']) ? $input['chronic_remarks'] : null,
                'pregnant' => !empty($input['pregnant']) ? $input['pregnant'] : 2,
                'pregnancy_months' => !empty($input['pregnancy_months']) ? $input['pregnancy_months'] : null,
                'employed_before' => !empty($input['employed_before']) ? $input['employed_before'] : 2,
                'reference_check' => !empty($input['reference_check']) ? $input['reference_check'] : 2,
                'reference_remarks' => !empty($input['reference_remarks']) ? $input['reference_remarks'] : null,
                'current_packages' => !empty($input['current_packages']) ? $input['current_packages'] : null,
                'agreed_salary' => !empty($input['agreed_salary']) ? $input['agreed_salary'] : null,
                'required_notes' => !empty($input['required_notes']) ? $input['required_notes'] : null,
                'current_employed_entity' => !empty($input['current_employed_entity']) ? $input['current_employed_entity'] : 2,
                'social_insuarance_status' => !empty($input['social_insuarance_status']) ? $input['social_insuarance_status'] : 2,
                'work_site' => !empty($input['work_site']) ? $input['work_site'] : 2,
                'reallocation_place' => !empty($input['reallocation_place']) ? $input['reallocation_place'] : 2,
                'recruiter_recommendations' => !empty($input['recruiter_recommendations']) ? $input['recruiter_recommendations'] : 'null',
                'recommended_title' => !empty($input['recommended_title']) ? $input['recommended_title'] : $input['job_title_id'],
                'ranking_creterial_id' => !empty($input['ranking_creterial_id']) ? $input['ranking_creterial_id'] : null,
                'core_competence_id' => !empty($input['core_competence_id']) ? $input['core_competence_id'] : null,
                'core_remark' => !empty($input['core_remark']) ? $input['core_remark'] : null,
                'functional_competence_id' => !empty($input['functional_competence_id']) ? $input['functional_competence_id'] : null,
                'functional_remark' => !empty($input['functional_remark']) ? $input['functional_remark'] : null,
                'mgt_senior_competence_id' => !empty($input['mgt_senior_competence_id']) ? $input['mgt_senior_competence_id'] : null,
                'mgt_senior_remark' => !empty($input['mgt_senior_remark']) ? $input['mgt_senior_remark'] : null,
                'mgt_top_competence_id' => !empty($input['mgt_top_competence_id']) ? $input['mgt_top_competence_id'] : null,
                'mgt_top_remark' => !empty($input['mgt_top_remark']) ? $input['mgt_top_remark'] : null,
                'surgery_operation' => !empty($input['surgery_operation']) ? $input['surgery_operation'] : 2,
                'candidate_name' => !empty($input['candidate_name']) ? ($input['firstname'] . " " . $input['middlename'] . " " . $input['lastname']) : 2,
                'overall_rating' => !empty($overall) ? $overall : 3,
                'interview_number' => !empty($candidate_number) ? $candidate_number : 22202,
                'downloaded' => 0, // default before download
                'uploaded' => 0,
                'uploaded_date' => null,
                'status' => 0, // submitted

            ]);
               Log::info('vita iendeleee');
                 $assessment_id = $assessment->id;
                 $this->updateCompetencyTransaction($request,$assessment_id);

            DB::commit();

            Log::info('Saved done');
            return response()->json(['message' => 'Assessment created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create Assessment', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create Assessment', 'status' => 500]);
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
        $uniqueNumber = substr($checksum, -4);

        // Convert the result to an integer (optional)
        $uniqueNumber = hexdec($uniqueNumber);



        return  $uniqueNumber;
    }
/**
     * @param $id
     * @return mixed
     * @competency transactions
     */
  public function updateCompetencyTransaction($request,$assessment_id)
{
     Log::info('unyama sana');
      log::info($assessment_id);
      Log::info('###############');
      Log::info($request);

//   DB::beginTransaction();

        try {
            $input = $request->all();
            // Log::info($input);
            //    Log::info($overall);
            log::info('mwamba juu');

         $this->assessment->create([
                'interactive_communication' => !empty($request['interactive_communication']) ? $request['interactive_communication'] : 0,
                'accountability' => !empty($request['accountability']) ? $request['accountability'] : 0,
                'work_excellence' => !empty($request['work_excellence']) ? $request['work_excellence'] : 0,
                'planning_organizing' => !empty($request['planning_organizing']) ? $request['planning_organizing'] : 0,
                'problem_solving' => !empty($request['problem_solving']) ? $request['problem_solving'] : 0,
                'analytical_ability' => !empty($request['analytical_ability']) ? $request['analytical_ability'] : 0,
                'attention_Details' => !empty($request['attention_Details']) ? $request['attention_Details'] : 0,
                'initiative' => !empty($request['initiative']) ? $request['initiative'] : 0,
                'multi_tasking' => !empty($request['multi_tasking']) ? $request['multi_tasking'] : 0,
                'continuous_improvement' => !empty($request['continuous_improvement']) ? $request['continuous_improvement'] : 0,
                'compliance' => !empty($request['compliance']) ? $request['compliance'] : 0,
                'creativity_innovation' => !empty($request['creativity_innovation']) ? $request['creativity_innovation'] : 0,
                'negotiation' => !empty($request['negotiation']) ? $request['negotiation'] : 0,
                'team_work' => !empty($request['team_work']) ? $request['team_work'] : 0,
                'adaptability_flexibility' => !empty($request['adaptability_flexibility']) ? $request['adaptability_flexibility'] : 0,
                'leadership' => !empty($request['leadership']) ? $request['leadership'] : 0,
                'delegating_managing' => !empty($request['delegating_managing']) ? $request['delegating_managing'] : 0,
                'managing_change' => !empty($request['managing_change']) ? $request['managing_change'] : 0,
                'strategic_conceptual_thinking' => !empty($request['strategic_conceptual_thinking']) ? $request['strategic_conceptual_thinking'] : 0,
                'interactive_communication_remark' => !empty($input['interactive_communication_remark']) ? $input['interactive_communication_remark']: null,
                'accountability_remark' => !empty($input['accountability_remark']) ? $input['accountability_remark']: null,
                'work_excellence_remark' => !empty($input['work_excellence_remark']) ?$input['work_excellence_remark'] : null,
                'planning_organizing_remark' => !empty($input['planning_organizing_remark']) ?$input['planning_organizing_remark'] : null,
                'problem_solving_remark' => !empty($input['problem_solving_remark']) ? $input['problem_solving_remark'] : null,
                'analytical_ability_remark' => !empty($input['analytical_ability_remark']) ? $input['analytical_ability_remark']: null,
                'attention_Details_remark' => !empty($input['attention_Details_remark']) ? $input['attention_Details_remark'] : null,
                'initiative_remark' => !empty($input['initiative_remark']) ? $input['initiative_remark']: null,
                'multi_tasking_remark' => !empty($input['multi_tasking_remark']) ?$input['multi_tasking_remark'] : null,
                'continuous_improvement_remark' => !empty($input['continuous_improvement_remark']) ? $input['continuous_improvement_remark'] : null,
                'compliance_remark' => !empty($input['compliance_remark']) ? $input['compliance_remark'] : null,
                'creativity_innovation_remark' => !empty($input['creativity_innovation_remark']) ?$input['creativity_innovation_remark'] : null,
                'negotiation_remark' => !empty($input['negotiation_remark']) ?$input['negotiation_remark'] : null,
                'team_work_remark' => !empty($input['team_work_remark']) ?$input['team_work_remark']: null,
                'adaptability_flexibility_remark' => !empty($input['adaptability_flexibility_remark']) ? $input['adaptability_flexibility_remark']: null,
                'leadership_remark' => !empty($input['leadership_remark']) ? $input['leadership_remark']: null,
                'delegating_managing_remark' => !empty($input['delegating_managing_remark']) ? $input['delegating_managing_remark']: null,
                'managing_change_remark' => !empty($input['managing_change_remark']) ? $input['managing_change_remark']: null,
                'strategic_conceptual_thinking_remark' => !empty($input['strategic_conceptual_thinking_remark']) ?$input['strategic_conceptual_thinking_remark'] : null,

         ]);
         return response()->json(['message' => 'data creasaved successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create user', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save on competency transactions', 'status' => 500]);
        }
 }

    public function updateDetails($request, $id)
    {
    }
    public function getAssessedCandidate()
    {
        return $this->assessment->get();

    }

    // mzigo wa transaction

}
