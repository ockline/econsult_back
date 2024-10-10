<?php

namespace App\Repositories\HiringRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mews\Purifier\Facades\Purifier;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Hiring\Interview\CompetencyInterDoc;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Models\Hiring\Interview\CompetencyTransaction;
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
        // Log::info('************************************8');

        $candidate_number = $this->generateCandidateNo();
        //   log::info($candidate_number);

        DB::beginTransaction();

        try {
            $input = $request->all();
            // Log::info($input['surgery_operation']);
            //    Log::info($overall);
            // log::info('mwamba juu');
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
                'residence_place' => !empty($input['residence_place']) ? $input['residence_place'] : null,
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
                'surgery_operation_remark' => !empty($input['surgery_operation_remark']) ? $input['surgery_operation_remark'] : null,
                'candidate_name' => ($input['firstname'] . " " . $input['middlename'] . " " . $input['lastname']),
                'overall_rating' => !empty($overall) ? $overall : 3,
                'interview_number' => !empty($candidate_number) ? $candidate_number : 22202,
                'downloaded' => 0, // default before download
                'uploaded' => 0,
                'uploaded_date' => null,
                'status' => 0, // submitted

            ]);
            // Log::info('vita iendeleee');
            $assessment_id = $assessment->id;
            $this->saveCompetencyTransaction($request, $assessment_id); //to save compotencies
            $this->saveCompetencyDocument($request, $assessment_id); // To save
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
    public function saveCompetencyTransaction($request, $assessment_id)
    {
        // Log::info('unyama sana');
        // log::info($assessment_id);
        // Log::info('###############');
        // Log::info($request);

        DB::beginTransaction();

        try {
            $input = $request->all();
            // Log::info($input);
            //    Log::info($overall);
            // log::info('mwamba competencies');

            $competency = new CompetencyTransaction();

            $competency->create([
                'competency_id' => !empty($request['competency_id']) ? $request['competency_id'] : null,
                'competency__subject_id' => !empty($request['competency__subject_id']) ?: null,
                'competency_interview_id' => $assessment_id,
                'description' => !empty($request['description']) ? $request['description'] : null,
                'interactive_communication' => !empty($request['interactive_communication']) ? $request['interactive_communication'] : 0,
                'accountability' => !empty($request['accountability']) ? $request['accountability'] : 0,
                'work_excellence' => !empty($request['work_excellence']) ? $request['work_excellence'] : 0,
                'planning_organizing' => !empty($request['planning_organizing']) ? $request['planning_organizing'] : 0,
                'problem_solving' => !empty($request['problem_solving']) ? $request['problem_solving'] : 0,
                'analytical_ability' => !empty($request['analytical_ability']) ? $request['analytical_ability'] : 0,
                'attention_details' => !empty($request['attention_details']) ? $request['attention_details'] : 0,
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
                'interactive_communication_remark' => !empty($input['interactive_communication_remark']) ? $input['interactive_communication_remark'] : null,
                'accountability_remark' => !empty($input['accountability_remark']) ? $input['accountability_remark'] : null,
                'work_excellence_remark' => !empty($input['work_excellence_remark']) ? $input['work_excellence_remark'] : null,
                'planning_organizing_remark' => !empty($input['planning_organizing_remark']) ? $input['planning_organizing_remark'] : null,
                'problem_solving_remark' => !empty($input['problem_solving_remark']) ? $input['problem_solving_remark'] : null,
                'analytical_ability_remark' => !empty($input['analytical_ability_remark']) ? $input['analytical_ability_remark'] : null,
                'attention_details_remark' => !empty($input['attention_details_remark']) ? $input['attention_details_remark'] : null,
                'initiative_remark' => !empty($input['initiative_remark']) ? $input['initiative_remark'] : null,
                'multi_tasking_remark' => !empty($input['multi_tasking_remark']) ? $input['multi_tasking_remark'] : null,
                'continuous_improvement_remark' => !empty($input['continuous_improvement_remark']) ? $input['continuous_improvement_remark'] : null,
                'compliance_remark' => !empty($input['compliance_remark']) ? $input['compliance_remark'] : null,
                'creativity_innovation_remark' => !empty($input['creativity_innovation_remark']) ? $input['creativity_innovation_remark'] : null,
                'negotiation_remark' => !empty($input['negotiation_remark']) ? $input['negotiation_remark'] : null,
                'team_work_remark' => !empty($input['team_work_remark']) ? $input['team_work_remark'] : null,
                'adaptability_flexibility_remark' => !empty($input['adaptability_flexibility_remark']) ? $input['adaptability_flexibility_remark'] : null,
                'leadership_remark' => !empty($input['leadership_remark']) ? $input['leadership_remark'] : null,
                'delegating_managing_remark' => !empty($input['delegating_managing_remark']) ? $input['delegating_managing_remark'] : null,
                'managing_change_remark' => !empty($input['managing_change_remark']) ? $input['managing_change_remark'] : null,
                'strategic_conceptual_thinking_remark' => !empty($input['strategic_conceptual_thinking_remark']) ? $input['strategic_conceptual_thinking_remark'] : null,

            ]);
            DB::commit();

            return response()->json(['message' => 'Competencie saved successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save competencies', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save on competency transactions', 'status' => 500]);
        }
    }
    /**
     *@method to save hr cometency attachment

     */
    public function saveCompetencyDocument($request, $assessment_id)
    {
        // Log::info($request->all());

        DB::beginTransaction();

        try {

            $documents = [];

            $documentTypes = ['military_doc'];

            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType) && $assessment_id) {
                    $file = $request->file($documentType);

                    if ($file) {
                        //  log::info($file); next time i want to add id of employer  as pass to reach interview candidate document
                        //   log::info($assessment_id);
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('hiring/hrInterview'), $fileName);
                        // log::info('hureee'. json_encode($fileName));
                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType), // Implement a function to get the document ID based on the type
                            'description' => $fileName,
                            'document_group_id' => 5,
                            'competency_interview_id' => $assessment_id,
                        ];
                    }
                }
            }
            // log::info('document:'. ' '. $documents);
            foreach ($documents as $document) {
                // log::info('document: ******************');
                CompetencyInterDoc::create($document);
            }



            DB::commit();

            Log::info('Saved document ');
            return response()->json(['message' => 'Document created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save document', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save document', 'status' => 500]);
        }
    }
    public function getDocumentId($documentId)
    {
        // $document_id = [29, 30];
        //  $documentTypes = [job_request_doc','shortlisted_doc'];
        switch ($documentId) {
            case 'military_doc';
                return 30;
                break;
            case 'hr_signed_doc';
                return 31;
                break;
            default:
                return null;
        }
    }
    /**
     * Method to Update assessed Candidate details
     */
    public function updateDetails($request, $id)
    {
        // Log::info('*******************************');
        //    Log::info($request->all());
        $candidate_details = $this->assessment::where('id', $id)->first();

        $candidate_number = $candidate_details->interview_number;
        if (isset($candidate_details)) {



            DB::beginTransaction();

            try {
                $input = $request->all();

                // $candidate_details->additional_comment = $request->input('additional_comment');
                $candidate_details->update([
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
                    'residence_place' => !empty($input['residence_place']) ? $input['residence_place'] : null,
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
                    'recruiter_recommendations' => !empty($input['recruiter_recommendations']) ? $input['recruiter_recommendations'] : 2,
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
                    'surgery_operation_remark' => !empty($input['surgery_operation_remark']) ? $input['surgery_operation_remark'] : null,
                    'candidate_name' => ($input['firstname'] . " " . $input['middlename'] . " " . $input['lastname']),
                    'overall_rating' => !empty($overall) ? $overall : 3,
                    'interview_number' => !empty($candidate_number) ? $candidate_number : 200002, //system number
                    'downloaded' => 0, // default before download
                    'uploaded' => 0,
                    'uploaded_date' => null,
                    'status' => 0, // submitted

                ]);


                $interview_id = $candidate_details->id;
                $this->updateCompetencyTransaction($request, $interview_id);
                $this->updateCompetencyDocument($request, $interview_id);

                DB::commit();
                Log::info('updated done');

                return response()->json(['message' => 'Assessed Candidate Updated successfully', 'status' => 200], 200);
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
     *@method to update hr cometency attachment

     */
    public function updateCompetencyDocument($request, $interview_id)
    {
        Log::info($request->all());

        DB::beginTransaction();

        try {

            $documents = [];

            $documentTypes = ['military_doc', 'hr_signed_doc'];

            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType) && $interview_id) {
                    $files = $request->file($documentType);


                    foreach ($files as $file) {
                        //  log::info($file);
                        //   log::info($id);
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        // $file->move(public_path('hiring/vacancies'), $fileName);
                        $file->move(public_path('hiring/hrInterview'), $fileName);
                        // log::info('hureee'. json_encode($fileName));
                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType), // Implement a function to get the document ID based on the type
                            'description' => $fileName,
                            'document_group_id' => 5,
                            'competency_interview_id' => $interview_id,
                        ];
                    }
                }
            }
            // log::info('document:'. ' '. $documents);
            foreach ($documents as $document) {
                log::info('document: ******************');
                CompetencyInterDoc::create($document);
            }



            DB::commit();

            Log::info('Saved document ');
            return response()->json(['message' => 'Document created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save document', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save document', 'status' => 500]);
        }
    }


    /**
     * Method to fetch HR Interviewed Candidate
     */
    public function getAssessedCandidate()
    {
        // return $this->assessment->get();

        return  DB::table('competency_interviews as ci')
            ->select([
                DB::raw('ci.job_title_id'),
                DB::raw('ci.id'),
                DB::raw('ci.date'),
                DB::raw('ci.interview_number'),
                DB::raw('ci.status'),
                DB::raw('ci.candidate_name'),
                DB::raw('ci.firstname'),
                DB::raw('ci.middlename'),
                DB::raw('ci.lastname'),
                DB::raw('ci.military_number'),
                DB::raw('ci.place_recruitment'),
                DB::raw('ci.year_experience'),
                DB::raw('ci.cost_number'),
                // DB::raw('ci.overall_rating'),
                DB::Raw("CASE WHEN ci.education_knowledge = 0 THEN 'N/A (0)' WHEN ci.education_knowledge = 1 THEN 'Below Average(1)' WHEN ci.education_knowledge = 2 THEN 'Average (2)' WHEN ci.education_knowledge = 3 THEN 'Good'  WHEN ci.education_knowledge = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS education_knowledge"),
                DB::Raw("CASE WHEN ci.relevant_experience = 0 THEN 'N/A (0)' WHEN ci.relevant_experience = 1 THEN 'Below Average(1)' WHEN ci.relevant_experience = 2 THEN 'Average (2)' WHEN ci.relevant_experience = 3 THEN 'Good'  WHEN ci.relevant_experience = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS relevant_experience"),
                DB::Raw("CASE WHEN ci.major_achievement = 0 THEN 'N/A (0)' WHEN ci.major_achievement = 1 THEN 'Below Average(1)' WHEN ci.major_achievement = 2 THEN 'Average (2)' WHEN ci.major_achievement = 3 THEN 'Good'  WHEN ci.major_achievement = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS major_achievement"),
                DB::Raw("CASE WHEN ci.language_fluency_id = 0 THEN 'N/A (0)' WHEN ci.language_fluency_id = 1 THEN 'Below Average(1)' WHEN ci.language_fluency_id = 2 THEN 'Average (2)' WHEN ci.language_fluency_id = 3 THEN 'Good'  WHEN ci.language_fluency_id = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS language_fluency_id"),
                DB::Raw("CASE WHEN ci.overall_rating = 0 THEN 'N/A' WHEN ci.overall_rating = 1 THEN 'Below Average' WHEN ci.overall_rating = 2 THEN 'Average' WHEN ci.overall_rating = 3 THEN 'Good'  WHEN ci.overall_rating = 4 THEN 'V.Good' ELSE 'Outstanding' END AS overall_rating"),
                DB::raw('ci.main_strength'),
                DB::raw('ci.main_weakness'),
                DB::raw('ci.birth_place'),
                DB::raw('ci.residence_place '),
                DB::raw('ci.relative_name'),
                DB::raw('ci.chronic_remarks'),
                DB::raw('ci.pregnant'),
                DB::raw('ci.pregnancy_months'),
                DB::raw('ci.reference_check'),
                DB::raw('ci.reference_remarks'),
                DB::raw('ci.current_packages'),
                DB::raw('ci.agreed_salary'),
                DB::raw('ci.required_notes'),
                DB::raw("CASE WHEN ci.current_employed_entity = 1 THEN 'Private Sector' ELSE 'Public Sector' END AS current_employed_entity"),
                DB::raw("CASE WHEN ci.military_service = 1 THEN 'Yes' ELSE 'No' END AS military_service "),
                DB::raw("CASE WHEN ci.relative_inside  = 1 THEN 'Yes' ELSE 'No' END AS relative_inside "),
                DB::raw("CASE WHEN ci.chronic_disease  = 1 THEN 'Yes' ELSE 'No' END AS chronic_disease "),
                DB::raw("CASE WHEN ci.pregnant  = 1 THEN 'Yes' ELSE 'No' END AS pregnant "),
                DB::raw("CASE WHEN ci.employed_before  = 1 THEN 'Yes' ELSE 'No' END AS employed_before "),
                DB::raw("CASE WHEN ci.reference_check  = 1 THEN 'Yes' ELSE 'No' END AS reference_check "),
                DB::raw("CASE WHEN ci.social_insuarance_status  = 1 THEN 'Yes' ELSE 'No' END AS social_insuarance_status "),
                DB::raw("CASE WHEN ci.work_site  = 1 THEN 'Yes' ELSE 'No' END AS work_site "),
                DB::raw("CASE WHEN ci.reallocation_place  = 1 THEN 'Yes' ELSE 'No' END AS reallocation_place "),
                DB::raw("CASE WHEN ci.downloaded  = 1 THEN 'Yes' ELSE 'No' END AS downloaded "),
                DB::raw("CASE WHEN ci.uploaded  = 1 THEN 'Yes' ELSE 'No' END AS uploaded "),
                DB::raw("CASE WHEN ci.recruiter_recommendations  = 1 THEN 'Accepted' WHEN ci.recruiter_recommendations  = 2 THEN 'Not Accepted' ELSE 'Waiting List' END AS recruiter_recommendations "),
                DB::raw("CASE WHEN ci.surgery_operation  = 1 THEN 'Yes' ELSE 'No' END AS surgery_operation "),
                DB::raw('ci.education_knowledge_remark '),
                DB::raw('ci.relevant_experience_remark '),
                DB::raw('ci.major_achievement_remark '),
                DB::raw('ci.language_fluency_remark '),
                DB::raw('ci.surgery_operation_remark '),
                DB::raw('jt.name as job_title'),
                DB::raw('ci.education_knowledge_remark'),
                // DB::raw('jt.name as recommended_title'),
                DB::raw('cc.name as cost_center'),
                DB::raw("CASE WHEN cots.interactive_communication = 0 THEN 'N/A (0)' WHEN cots.interactive_communication = 1 THEN 'Below Average(1)' WHEN cots.interactive_communication = 2 THEN 'Average (2)' WHEN cots.interactive_communication = 3 THEN 'Good'  WHEN cots.interactive_communication = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS interactive_communication"),
                DB::raw("CASE WHEN cots.accountability = 0 THEN 'N/A (0)' WHEN cots.accountability = 1 THEN 'Below Average(1)' WHEN cots.accountability = 2 THEN 'Average (2)' WHEN cots.accountability = 3 THEN 'Good'  WHEN cots.accountability = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS accountability"),
                DB::raw("CASE WHEN cots.work_excellence = 0 THEN 'N/A (0)' WHEN cots.work_excellence = 1 THEN 'Below Average(1)' WHEN cots.work_excellence = 2 THEN 'Average (2)' WHEN cots.work_excellence = 3 THEN 'Good'  WHEN cots.work_excellence = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS work_excellence"),
                DB::raw("CASE WHEN cots.planning_organizing = 0 THEN 'N/A (0)' WHEN cots.planning_organizing = 1 THEN 'Below Average(1)' WHEN cots.planning_organizing = 2 THEN 'Average (2)' WHEN cots.planning_organizing = 3 THEN 'Good'  WHEN cots.planning_organizing = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS planning_organizing"),
                DB::raw("CASE WHEN cots.problem_solving = 0 THEN 'N/A (0)' WHEN cots.problem_solving = 1 THEN 'Below Average(1)' WHEN cots.problem_solving = 2 THEN 'Average (2)' WHEN cots.problem_solving = 3 THEN 'Good'  WHEN cots.problem_solving = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS problem_solving"),
                DB::raw("CASE WHEN cots.analytical_ability = 0 THEN 'N/A (0)' WHEN cots.analytical_ability = 1 THEN 'Below Average(1)' WHEN cots.analytical_ability = 2 THEN 'Average (2)' WHEN cots.analytical_ability = 3 THEN 'Good'  WHEN cots.analytical_ability = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS analytical_ability"),
                DB::raw("CASE WHEN cots.attention_details = 0 THEN 'N/A (0)' WHEN cots.attention_details = 1 THEN 'Below Average(1)' WHEN cots.attention_details = 2 THEN 'Average (2)' WHEN cots.attention_details = 3 THEN 'Good'  WHEN cots.attention_details = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS attention_details"),
                DB::raw("CASE WHEN cots.initiative = 0 THEN 'N/A (0)' WHEN cots.initiative = 1 THEN 'Below Average(1)' WHEN cots.initiative = 2 THEN 'Average (2)' WHEN cots.initiative = 3 THEN 'Good'  WHEN cots.initiative = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS initiative"),
                DB::raw("CASE WHEN cots.multi_tasking = 0 THEN 'N/A (0)' WHEN cots.multi_tasking = 1 THEN 'Below Average(1)' WHEN cots.multi_tasking = 2 THEN 'Average (2)' WHEN cots.multi_tasking = 3 THEN 'Good'  WHEN cots.multi_tasking = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS multi_tasking"),
                DB::raw("CASE WHEN cots.continuous_improvement = 0 THEN 'N/A (0)' WHEN cots.continuous_improvement = 1 THEN 'Below Average(1)' WHEN cots.continuous_improvement = 2 THEN 'Average (2)' WHEN cots.continuous_improvement = 3 THEN 'Good'  WHEN cots.continuous_improvement = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS continuous_improvement"),
                DB::raw("CASE WHEN cots.compliance = 0 THEN 'N/A (0)' WHEN cots.compliance = 1 THEN 'Below Average(1)' WHEN cots.compliance = 2 THEN 'Average (2)' WHEN cots.compliance = 3 THEN 'Good'  WHEN cots.compliance = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS compliance"),
                DB::raw("CASE WHEN cots.creativity_innovation = 0 THEN 'N/A (0)' WHEN cots.creativity_innovation = 1 THEN 'Below Average(1)' WHEN cots.creativity_innovation = 2 THEN 'Average (2)' WHEN cots.creativity_innovation = 3 THEN 'Good'  WHEN cots.creativity_innovation = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS creativity_innovation"),
                DB::raw("CASE WHEN cots.negotiation = 0 THEN 'N/A (0)' WHEN cots.negotiation = 1 THEN 'Below Average(1)' WHEN cots.negotiation = 2 THEN 'Average (2)' WHEN cots.negotiation = 3 THEN 'Good'  WHEN cots.negotiation = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS negotiation"),
                DB::raw("CASE WHEN cots.team_work = 0 THEN 'N/A (0)' WHEN cots.team_work = 1 THEN 'Below Average(1)' WHEN cots.team_work = 2 THEN 'Average (2)' WHEN cots.team_work = 3 THEN 'Good'  WHEN cots.team_work = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS team_work"),
                DB::raw("CASE WHEN cots.adaptability_flexibility = 0 THEN 'N/A (0)' WHEN cots.adaptability_flexibility = 1 THEN 'Below Average(1)' WHEN cots.adaptability_flexibility = 2 THEN 'Average (2)' WHEN cots.adaptability_flexibility = 3 THEN 'Good'  WHEN cots.adaptability_flexibility = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS adaptability_flexibility"),
                DB::raw("CASE WHEN cots.leadership = 0 THEN 'N/A (0)' WHEN cots.leadership = 1 THEN 'Below Average(1)' WHEN cots.leadership = 2 THEN 'Average (2)' WHEN cots.leadership = 3 THEN 'Good'  WHEN cots.leadership = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS leadership"),
                DB::raw("CASE WHEN cots.delegating_managing = 0 THEN 'N/A (0)' WHEN cots.delegating_managing = 1 THEN 'Below Average(1)' WHEN cots.delegating_managing = 2 THEN 'Average (2)' WHEN cots.delegating_managing = 3 THEN 'Good'  WHEN cots.delegating_managing = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS delegating_managing"),
                DB::raw("CASE WHEN cots.managing_change = 0 THEN 'N/A (0)' WHEN cots.managing_change = 1 THEN 'Below Average(1)' WHEN cots.managing_change = 2 THEN 'Average (2)' WHEN cots.managing_change = 3 THEN 'Good'  WHEN cots.managing_change = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS managing_change"),
                DB::raw("CASE WHEN cots.strategic_conceptual_thinking = 0 THEN 'N/A (0)' WHEN cots.strategic_conceptual_thinking = 1 THEN 'Below Average(1)' WHEN cots.strategic_conceptual_thinking = 2 THEN 'Average (2)' WHEN cots.strategic_conceptual_thinking = 3 THEN 'Good'  WHEN cots.strategic_conceptual_thinking = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS strategic_conceptual_thinking"),
                DB::raw(' cots.interactive_communication_remark '),
                DB::raw(' cots.accountability_remark  '),
                DB::raw(' cots.work_excellence_remark '),
                DB::raw(' cots.planning_organizing_remark '),
                DB::raw(' cots.problem_solving_remark  '),
                DB::raw(' cots.analytical_ability_remark '),
                DB::raw(' cots.attention_details_remark  '),
                DB::raw(' cots.initiative_remark  '),
                DB::raw(' cots.multi_tasking_remark '),
                DB::raw(' cots.continuous_improvement_remark '),
                DB::raw(' cots.compliance_remark  '),
                DB::raw(' cots.creativity_innovation_remark  '),
                DB::raw(' cots.negotiation_remark  '),
                DB::raw(' cots.team_work_remark  '),
                DB::raw(' cots.adaptability_flexibility_remark '),
                DB::raw(' cots.leadership_remark  '),
                DB::raw(' cots.delegating_managing_remark '),
                DB::raw(' cots.managing_change_remark'),
                DB::raw(' cots.strategic_conceptual_thinking_remark'),
                DB::raw('CONCAT(u.firstname, \' \', u.middlename, \'.\', u.lastname) as interviewer_name'),

                //  DB::raw('CONCAT(u.firstname," ", LEFT(u.middlename, 1),".", u.lastname) as interviewer_name')
            ])
            ->leftJoin('job_title as jt', 'ci.job_title_id', '=', 'jt.id')
            ->leftJoin('cost_centers as cc', 'ci.cost_center_id', '=', 'cc.id')
            ->leftJoin('competencies_transactions as cots', 'cots.competency_interview_id', '=', 'ci.id')
            ->leftJoin('employers as e', 'ci.employer_id', '=', 'e.id')
            ->leftJoin('users as u', 'u.employer_id', '=', 'e.id')
            ->orderBy('ci.id', 'DESC')
            ->get();
        //  log::info($assessed_candidate);
        //  return $assessed_candidate;
    }
    public function getCompetencyTransactions()
    {
        return  DB::table('competencies_transactions')->select('*')->get();
    }

    public function showDownloadDetails()
    {
        return  DB::table('competency_interviews as ci')
            ->select([
                DB::raw('ci.job_title_id'),
                DB::raw('ci.id'),
                DB::raw('ci.date'),
                DB::raw('ci.interview_number'),
                DB::raw('ci.status'),
                DB::raw('ci.candidate_name'),
                DB::raw('ci.firstname'),
                DB::raw('ci.middlename'),
                DB::raw('ci.lastname'),
                DB::raw('ci.military_number'),
                DB::raw('ci.place_recruitment'),
                DB::raw('ci.year_experience'),
                DB::raw('ci.cost_number'),
                // DB::raw('ci.overall_rating'),
                DB::Raw("CASE WHEN ci.education_knowledge = 0 THEN 'N/A' WHEN ci.education_knowledge = 1 THEN 'Below Average' WHEN ci.education_knowledge = 2 THEN 'Average' WHEN ci.education_knowledge = 3 THEN 'Good'  WHEN ci.education_knowledge = 4 THEN 'V.Good' ELSE 'Outstanding' END AS education_knowledge"),
                DB::Raw("CASE WHEN ci.relevant_experience = 0 THEN 'N/A' WHEN ci.relevant_experience = 1 THEN 'Below Average' WHEN ci.relevant_experience = 2 THEN 'Average' WHEN ci.relevant_experience = 3 THEN 'Good'  WHEN ci.relevant_experience = 4 THEN 'V.Good' ELSE 'Outstanding' END AS relevant_experience"),
                DB::Raw("CASE WHEN ci.major_achievement = 0 THEN 'N/A' WHEN ci.major_achievement = 1 THEN 'Below Average' WHEN ci.major_achievement = 2 THEN 'Average' WHEN ci.major_achievement = 3 THEN 'Good'  WHEN ci.major_achievement = 4 THEN 'V.Good' ELSE 'Outstanding' END AS major_achievement"),
                DB::Raw("CASE WHEN ci.language_fluency_id = 0 THEN 'N/A' WHEN ci.language_fluency_id = 1 THEN 'Below Average' WHEN ci.language_fluency_id = 2 THEN 'Average' WHEN ci.language_fluency_id = 3 THEN 'Good'  WHEN ci.language_fluency_id = 4 THEN 'V.Good' ELSE 'Outstanding' END AS language_fluency_id"),
                DB::Raw("CASE WHEN ci.overall_rating = 0 THEN 'N/A' WHEN ci.overall_rating = 1 THEN 'Below Average' WHEN ci.overall_rating = 2 THEN 'Average' WHEN ci.overall_rating = 3 THEN 'Good'  WHEN ci.overall_rating = 4 THEN 'V.Good' ELSE 'Outstanding' END AS overall_rating"),
                DB::raw('ci.main_strength'),
                DB::raw('ci.main_weakness'),
                DB::raw('ci.birth_place'),
                DB::raw('ci.residence_place '),
                DB::raw('ci.relative_name'),
                DB::raw('ci.chronic_remarks'),
                DB::raw('ci.pregnant'),
                DB::raw('ci.pregnancy_months'),
                DB::raw('ci.reference_check'),
                DB::raw('ci.reference_remarks'),
                DB::raw('ci.current_packages'),
                DB::raw('ci.agreed_salary'),
                DB::raw('ci.required_notes'),
                DB::raw("CASE WHEN ci.current_employed_entity = 1 THEN 'Private Sector' ELSE 'Public Sector' END AS current_employed_entity"),
                DB::raw("CASE WHEN ci.military_service = 1 THEN 'Yes' ELSE 'No' END AS military_service "),
                DB::raw("CASE WHEN ci.relative_inside  = 1 THEN 'Yes' ELSE 'No' END AS relative_inside "),
                DB::raw("CASE WHEN ci.chronic_disease  = 1 THEN 'Yes' ELSE 'No' END AS chronic_disease "),
                DB::raw("CASE WHEN ci.pregnant  = 1 THEN 'Yes' ELSE 'No' END AS pregnant "),
                DB::raw("CASE WHEN ci.employed_before  = 1 THEN 'Yes' ELSE 'No' END AS employed_before "),
                DB::raw("CASE WHEN ci.reference_check  = 1 THEN 'Yes' ELSE 'No' END AS reference_check "),
                DB::raw("CASE WHEN ci.social_insuarance_status  = 1 THEN 'Yes' ELSE 'No' END AS social_insuarance_status "),
                DB::raw("CASE WHEN ci.work_site  = 1 THEN 'Yes' ELSE 'No' END AS work_site "),
                DB::raw("CASE WHEN ci.reallocation_place  = 1 THEN 'Yes' ELSE 'No' END AS reallocation_place "),
                DB::raw("CASE WHEN ci.downloaded  = 1 THEN 'Yes' ELSE 'No' END AS downloaded "),
                DB::raw("CASE WHEN ci.uploaded  = 1 THEN 'Yes' ELSE 'No' END AS uploaded "),
                DB::raw("CASE WHEN ci.recruiter_recommendations  = 1 THEN 'Accepted' WHEN ci.recruiter_recommendations  = 2 THEN 'Not Accepted' ELSE 'Waiting List' END AS recruiter_recommendations "),
                DB::raw("CASE WHEN ci.surgery_operation  = 1 THEN 'Yes' ELSE 'No' END AS surgery_operation "),
                DB::raw('ci.education_knowledge_remark '),
                DB::raw('ci.relevant_experience_remark '),
                DB::raw('ci.major_achievement_remark '),
                DB::raw('ci.language_fluency_remark '),
                DB::raw('ci.surgery_operation_remark '),
                DB::raw('jt.name as job_title'),
                DB::raw('ci.education_knowledge_remark'),
                // DB::raw('jt.name as recommended_title'),
                DB::raw('cc.name as cost_center'),
                DB::raw("CASE WHEN cots.interactive_communication = 0 THEN 'N/A' WHEN cots.interactive_communication = 1 THEN 'Below Average' WHEN cots.interactive_communication = 2 THEN 'Average' WHEN cots.interactive_communication = 3 THEN 'Good'  WHEN cots.interactive_communication = 4 THEN 'V.Good' ELSE 'Outstanding' END AS interactive_communication"),
                DB::raw("CASE WHEN cots.accountability = 0 THEN 'N/A' WHEN cots.accountability = 1 THEN 'Below Average' WHEN cots.accountability = 2 THEN 'Average' WHEN cots.accountability = 3 THEN 'Good'  WHEN cots.accountability = 4 THEN 'V.Good' ELSE 'Outstanding' END AS accountability"),
                DB::raw("CASE WHEN cots.work_excellence = 0 THEN 'N/A' WHEN cots.work_excellence = 1 THEN 'Below Average' WHEN cots.work_excellence = 2 THEN 'Average' WHEN cots.work_excellence = 3 THEN 'Good'  WHEN cots.work_excellence = 4 THEN 'V.Good' ELSE 'Outstanding' END AS work_excellence"),
                DB::raw("CASE WHEN cots.planning_organizing = 0 THEN 'N/A' WHEN cots.planning_organizing = 1 THEN 'Below Average' WHEN cots.planning_organizing = 2 THEN 'Average' WHEN cots.planning_organizing = 3 THEN 'Good'  WHEN cots.planning_organizing = 4 THEN 'V.Good' ELSE 'Outstanding' END AS planning_organizing"),
                DB::raw("CASE WHEN cots.problem_solving = 0 THEN 'N/A' WHEN cots.problem_solving = 1 THEN 'Below Average' WHEN cots.problem_solving = 2 THEN 'Average' WHEN cots.problem_solving = 3 THEN 'Good'  WHEN cots.problem_solving = 4 THEN 'V.Good' ELSE 'Outstanding' END AS problem_solving"),
                DB::raw("CASE WHEN cots.analytical_ability = 0 THEN 'N/A' WHEN cots.analytical_ability = 1 THEN 'Below Average' WHEN cots.analytical_ability = 2 THEN 'Average' WHEN cots.analytical_ability = 3 THEN 'Good'  WHEN cots.analytical_ability = 4 THEN 'V.Good' ELSE 'Outstanding' END AS analytical_ability"),
                DB::raw("CASE WHEN cots.attention_details = 0 THEN 'N/A' WHEN cots.attention_details = 1 THEN 'Below Average' WHEN cots.attention_details = 2 THEN 'Average' WHEN cots.attention_details = 3 THEN 'Good'  WHEN cots.attention_details = 4 THEN 'V.Good' ELSE 'Outstanding' END AS attention_details"),
                DB::raw("CASE WHEN cots.initiative = 0 THEN 'N/A' WHEN cots.initiative = 1 THEN 'Below Average' WHEN cots.initiative = 2 THEN 'Average' WHEN cots.initiative = 3 THEN 'Good'  WHEN cots.initiative = 4 THEN 'V.Good' ELSE 'Outstanding' END AS initiative"),
                DB::raw("CASE WHEN cots.multi_tasking = 0 THEN 'N/A' WHEN cots.multi_tasking = 1 THEN 'Below Average' WHEN cots.multi_tasking = 2 THEN 'Average' WHEN cots.multi_tasking = 3 THEN 'Good'  WHEN cots.multi_tasking = 4 THEN 'V.Good' ELSE 'Outstanding' END AS multi_tasking"),
                DB::raw("CASE WHEN cots.continuous_improvement = 0 THEN 'N/A' WHEN cots.continuous_improvement = 1 THEN 'Below Average' WHEN cots.continuous_improvement = 2 THEN 'Average' WHEN cots.continuous_improvement = 3 THEN 'Good'  WHEN cots.continuous_improvement = 4 THEN 'V.Good' ELSE 'Outstanding' END AS continuous_improvement"),
                DB::raw("CASE WHEN cots.compliance = 0 THEN 'N/A' WHEN cots.compliance = 1 THEN 'Below Average' WHEN cots.compliance = 2 THEN 'Average' WHEN cots.compliance = 3 THEN 'Good'  WHEN cots.compliance = 4 THEN 'V.Good' ELSE 'Outstanding' END AS compliance"),
                DB::raw("CASE WHEN cots.creativity_innovation = 0 THEN 'N/A' WHEN cots.creativity_innovation = 1 THEN 'Below Average' WHEN cots.creativity_innovation = 2 THEN 'Average' WHEN cots.creativity_innovation = 3 THEN 'Good'  WHEN cots.creativity_innovation = 4 THEN 'V.Good' ELSE 'Outstanding' END AS creativity_innovation"),
                DB::raw("CASE WHEN cots.negotiation = 0 THEN 'N/A' WHEN cots.negotiation = 1 THEN 'Below Average' WHEN cots.negotiation = 2 THEN 'Average' WHEN cots.negotiation = 3 THEN 'Good'  WHEN cots.negotiation = 4 THEN 'V.Good' ELSE 'Outstanding' END AS negotiation"),
                DB::raw("CASE WHEN cots.team_work = 0 THEN 'N/A' WHEN cots.team_work = 1 THEN 'Below Average' WHEN cots.team_work = 2 THEN 'Average' WHEN cots.team_work = 3 THEN 'Good'  WHEN cots.team_work = 4 THEN 'V.Good' ELSE 'Outstanding' END AS team_work"),
                DB::raw("CASE WHEN cots.adaptability_flexibility = 0 THEN 'N/A' WHEN cots.adaptability_flexibility = 1 THEN 'Below Average' WHEN cots.adaptability_flexibility = 2 THEN 'Average' WHEN cots.adaptability_flexibility = 3 THEN 'Good'  WHEN cots.adaptability_flexibility = 4 THEN 'V.Good' ELSE 'Outstanding' END AS adaptability_flexibility"),
                DB::raw("CASE WHEN cots.leadership = 0 THEN 'N/A' WHEN cots.leadership = 1 THEN 'Below Average' WHEN cots.leadership = 2 THEN 'Average' WHEN cots.leadership = 3 THEN 'Good'  WHEN cots.leadership = 4 THEN 'V.Good' ELSE 'Outstanding' END AS leadership"),
                DB::raw("CASE WHEN cots.delegating_managing = 0 THEN 'N/A' WHEN cots.delegating_managing = 1 THEN 'Below Average' WHEN cots.delegating_managing = 2 THEN 'Average' WHEN cots.delegating_managing = 3 THEN 'Good'  WHEN cots.delegating_managing = 4 THEN 'V.Good' ELSE 'Outstanding' END AS delegating_managing"),
                DB::raw("CASE WHEN cots.managing_change = 0 THEN 'N/A' WHEN cots.managing_change = 1 THEN 'Below Average' WHEN cots.managing_change = 2 THEN 'Average' WHEN cots.managing_change = 3 THEN 'Good'  WHEN cots.managing_change = 4 THEN 'V.Good' ELSE 'Outstanding' END AS managing_change"),
                DB::raw("CASE WHEN cots.strategic_conceptual_thinking = 0 THEN 'N/A' WHEN cots.strategic_conceptual_thinking = 1 THEN 'Below Average' WHEN cots.strategic_conceptual_thinking = 2 THEN 'Average' WHEN cots.strategic_conceptual_thinking = 3 THEN 'Good'  WHEN cots.strategic_conceptual_thinking = 4 THEN 'V.Good' ELSE 'Outstanding' END AS strategic_conceptual_thinking"),
                DB::raw(' cots.interactive_communication_remark '),
                DB::raw(' cots.accountability_remark  '),
                DB::raw(' cots.work_excellence_remark '),
                DB::raw(' cots.planning_organizing_remark '),
                DB::raw(' cots.problem_solving_remark  '),
                DB::raw(' cots.analytical_ability_remark '),
                DB::raw(' cots.attention_details_remark  '),
                DB::raw(' cots.initiative_remark  '),
                DB::raw(' cots.multi_tasking_remark '),
                DB::raw(' cots.continuous_improvement_remark '),
                DB::raw(' cots.compliance_remark  '),
                DB::raw(' cots.creativity_innovation_remark  '),
                DB::raw(' cots.negotiation_remark  '),
                DB::raw(' cots.team_work_remark  '),
                DB::raw(' cots.adaptability_flexibility_remark '),
                DB::raw(' cots.leadership_remark  '),
                DB::raw(' cots.delegating_managing_remark '),
                DB::raw(' cots.managing_change_remark'),
                DB::raw(' cots.strategic_conceptual_thinking_remark'),
                DB::raw('CONCAT(u.firstname, \' \', u.middlename, \'.\', u.lastname) as interviewer_name'),
            ])
            ->leftJoin('job_title as jt', 'ci.job_title_id', '=', 'jt.id')
            ->leftJoin('cost_centers as cc', 'ci.cost_center_id', '=', 'cc.id')
            ->leftJoin('competencies_transactions as cots', 'cots.competency_interview_id', '=', 'ci.id')
            ->leftJoin('employers as e', 'ci.employer_id', '=', 'e.id')
            ->leftJoin('users as u', 'u.employer_id', '=', 'e.id')
            ->orderBy('ci.id', 'DESC')
            ->get();
    }
    public function getAssessedDocument()
    {
        return DB::table('compentency_inter_documents as cid')->select('cid.id','cid.competency_interview_id','document_id','cid.description','cid.updated_at as doc_modified', 'd.name as doc_name')
                                ->leftJoin('documents as d', 'cid.document_id', '=', 'd.id')
                                ->get();
    }
}
