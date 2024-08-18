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
use App\Models\Hiring\Interview\TechnicalDocument;
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

        // Log::info($request->all());
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
    public function overallRatingResult(Request $request, string $id)
    {
        // Log::info('Bondeni');

        $int = !empty($request['technical_skill']) ? $request['technical_skill'] : 0;
        $acc = !empty($request['relevant_experience']) ? $request['relevant_experience'] : 0;
        $wor = !empty($request['knowledge_equipment']) ? $request['knowledge_equipment'] : 0;
        $pl = !empty($request['quality_awareness']) ? $request['quality_awareness'] : 0;
        $pr = !empty($request['physical_capability']) ? $request['physical_capability'] : 0;


        $total_num = 5;
        $sum_competencies = ($int + $acc + $wor + $pl + $pr);
        $overall = $sum_competencies / $total_num;

        return round($overall);
    }
    public function getlastCandidate()
    {

        return  $this->candidate->select('*')->latest()->first();
    }
    /**
     * @param $id
     * @return mixed
     * @get all ranking practical result according to last technical interview
     */
    public function getLastCandidatePracticals()
    {
        // log::info('hureeeeeeeeeeeeeeee');


        $candidate = $this->getlastCandidate();

        $details = DB::table('practical_test_tranc as ptt')->select('ptt.id', 'ranking_creterial_id', 'created_at', 'ranking_creterial_id', 'practical_test_id', 'technical_interview_id')
            ->where('technical_interview_id', $candidate->id)
            ->orderBy("ptt.id", 'Desc')
            ->get();


        $data = json_decode(json_encode($details), true); // Decode the JSON string into an array

        $technical =  array_sum([$candidate->technical_skill, $candidate->relevant_experience, $candidate->knowledge_equipment, $candidate->quality_awareness, $candidate->physical_capability]);
        $techn = 5;
        $factor = ($technical / $techn);
        //to count the number of ranking creterial  on practical test
        $rankingIds = [];

        foreach ($data as $tech) {
            if (isset($tech['ranking_creterial_id'])) {
                $rankingIds[] = $tech['ranking_creterial_id'];
            }
        }
        // Log::info('hellow');
        $sum_cand = array_sum(array_unique($rankingIds));
        $cand = count(array_unique($rankingIds));
        // Log::info($cand);

        $result =  round($sum_cand / $cand);
        //    Log::info('result'."". $result);

        $rating = (($factor + $result) / 2);


        $over_rating = round($rating);


        $rating_result =  $this->candidate->where('id', $candidate->id)->update(['overall_rating' => $over_rating]);
        // log::info($rating_result);
        if (isset($rating_result)) {
            return  response()->json(['status' => 200, 'message' => "Data successfull updated"]);
        } else {

            return  response()->json(['status' => 500, 'message' => "Failured to update"]);
        }
    }
    /**
     * @param $id
     * @return mixed
     * @practical test transactions
     */
    public function savePracticalTestTranc($request, $candidate_id)
    {
        // Log::info('unyama sana');
        $candidate = $this->getlastCandidate();

        DB::beginTransaction();

        try {

            $tech_candidate = new PracticalTestTranc();

            $tech_candidate->create([
                'practical_test_id' => !empty($request['$practical_test_id']) ? $request['$practical_test_id'] : 1,
                'ranking_creterial_id' => !empty($request['ranking_creterial_id']) ? $request['ranking_creterial_id'] : 0,
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

                log::info($input);
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
                    'overall_rating' => !empty($imput['overall_rating']) ? $input['overall_rating'] : 3,
                    'interview_number' => !empty($candidate_number) ? $candidate_number : 22202,
                    'downloaded' => 0, // default before download
                    'uploaded' => 0,
                    'uploaded_date' => null,
                    'status' => 0, // submitted

                ]);

                $interview_id = $candidate_details->id;
                // $this->updateCompetencyTransaction($request, $interview_id);

                  $this->updateTechnicalDocument($request,$interview_id);

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
    public function updatePracticalTestTranc($request, $interview_id)
    {
        // Log::info('ndaniii');

        // Log::info($request->all());
        // die;
        $saved_data = $this->getPracticalTestTransactions()->where('technical_interview_id', $interview_id)->first();

        DB::beginTransaction();

        try {
            $input = $request->all();
           $practical_id = $input['practical_test_id'];
            $technical =  PracticalTestTranc::where('practical_test_id', $practical_id);


    //   log::info($input['practical_test_id']);
            $technical->update([

                'practical_test_id' => !empty($input['practical_test_id']) ? $input['practical_test_id']: null,
                'technical_interview_id' => !empty($input['technical_interview_id']) ? $input['technical_interview_id']: null,
                'description' => !empty($input['description']) ? $input['description'] : null,
                'ranking_creterial_id' => !empty($input['ranking_creterial_id']) ? $input['ranking_creterial_id'] : $saved_data->ranking_creterial_id,
                'practicl_test_remark' => !empty($input['practicl_test_remark']) ? $input['practicl_test_remark'] : $saved_data->practicl_test_remark,
                'test_marks' => !empty($input['test_marks']) ? $input['test_marks'] : $saved_data->test_marks,

            ]);



            DB::commit();
              Log::info('practical test updated');
            return response()->json(['message' => 'Practical test details updaded successfully', 'status' => 200], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update practical test', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to update on practical test', 'status' => 500]);
        }
    }
    /**
     *@method to update hr cometency attachment

     */
    public function updateTechnicalDocument($request, $interview_id)
    {
        // Log::info($request->all());

        DB::beginTransaction();

        try {

            $documents = [];

            $documentTypes = ['technical_signed_doc'];

            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType) && $interview_id) {
                    $file = $request->file($documentType);


                    if(($file)) {
                         log::info($file);
                        //   log::info($id);
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        // $file->move(public_path('hiring/vacancies'), $fileName);
                        $file->move(public_path('hiring/technical'), $fileName);
                        // log::info('hureee'. json_encode($fileName));
                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType), // Implement a function to get the document ID based on the type
                            'description' => $fileName,
                            'document_group_id' => 4,
                            'technical_interview_id' => $interview_id,
                        ];
                    }
                }
            }
            // log::info('document:'. ' '. $documents);
            foreach ($documents as $document) {
                // log::info('document: ******************');
                TechnicalDocument::create($document);
            }



            DB::commit();

            Log::info('Saved document  billa');
            return response()->json(['message' => 'Document created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save document', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to save document', 'status' => 500]);
        }
    }
    /**
     * Method to get Document
     */
    public function getDocumentId($documentId)
    {
        // $document_id = [7, 8, 32];
        //  $documentTypes = ['practical_test_doc','driving_licence', 'technial_signed_doc'];
        switch ($documentId) {
            case 'practical_test_doc';
                return 7;
                break;
            case 'driving_licence';
                return 8;
                break;
            case 'technical_signed_doc';
                return 32;
                break;
            default:
                return null;
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
                DB::Raw("CASE WHEN ti.physical_capability = 0 THEN 'N/A (0)' WHEN ti.physical_capability = 1 THEN 'Below Average(1)' WHEN ti.physical_capability = 2 THEN 'Average (2)' WHEN ti.physical_capability = 3 THEN 'Good'  WHEN ti.physical_capability = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS physical_capability"),
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
                DB::raw('CONCAT(u.firstname, \' \', u.middlename, \'.\', u.lastname) as interviewer_name'),
            ])
            ->leftJoin('job_title as jt', 'ti.job_title_id', '=', 'jt.id')
            ->leftJoin('cost_centers as cc', 'ti.cost_center_id', '=', 'cc.id')
            // ->leftJoin('practical_test_tranc as ptt', 'ptt.technical_interview_id', '=', 'ti.id')
            ->leftJoin('employers as e', 'ti.employer_id', '=', 'e.id')
            ->leftJoin('users as u', 'u.employer_id', '=', 'e.id')
            ->orderBy('ti.id', 'DESC')
            ->get();
    }
    public function getPracticalTestTransactions()
    {
        return  DB::table('practical_test_tranc as ptt')
            ->select(['ptt.*', DB::Raw("CASE WHEN ptt.ranking_creterial_id = 0 THEN 'N/A (0)' WHEN ptt.ranking_creterial_id = 1 THEN 'Below Average(1)' WHEN ptt.ranking_creterial_id = 2 THEN 'Average (2)' WHEN ptt.ranking_creterial_id = 3 THEN 'Good'  WHEN ptt.ranking_creterial_id = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS ranking_creterial"),])->get();
    }

    public function showDownloadDetails()
    {

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
                DB::Raw("CASE WHEN ti.physical_capability = 0 THEN 'N/A (0)' WHEN ti.physical_capability = 1 THEN 'Below Average(1)' WHEN ti.physical_capability = 2 THEN 'Average (2)' WHEN ti.physical_capability = 3 THEN 'Good'  WHEN ti.physical_capability = 4 THEN 'V.Good (4)' ELSE 'Outstanding (5)' END AS physical_capability"),

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
                DB::raw('rc.description  '),
                DB::raw(' ptt.practical_test_id '),
                DB::raw(' ptt.ranking_creterial_id '),
                DB::raw(' ptt.practicl_test_remark  '),
                DB::raw(' ptt.test_marks '),
                DB::raw('CONCAT(u.firstname, \' \', u.middlename, \'.\', u.lastname) as interviewer_name'),
            ])
            ->leftJoin('job_title as jt', 'ti.job_title_id', '=', 'jt.id')
            ->leftJoin('cost_centers as cc', 'ti.cost_center_id', '=', 'cc.id')
            ->leftJoin('ranking_creterials as rc', 'ti.ranking_creterial_id', '=', 'rc.id')
            ->leftJoin('practical_test_tranc as ptt', 'ptt.technical_interview_id', '=', 'ti.id')
            ->leftJoin('employers as e', 'ti.employer_id', '=', 'e.id')
            ->leftJoin('users as u', 'u.employer_id', '=', 'e.id')
            ->orderBy('ti.id', 'DESC')
            ->get();
    }
 public function getCandidateDocument()
{
    return DB::table('tech_interview_documents as tid')->select('tid.id','tid.technical_interview_id','document_id','tid.description','tid.updated_at as doc_modified', 'd.name as doc_name')
                                ->leftJoin('documents as d', 'tid.document_id', '=', 'd.id')
                                ->get();
}
}
