<?php

namespace App\Repositories\WorkflowRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mews\Purifier\Facades\Purifier;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Workflow\WorkflowTrack;
use Illuminate\Support\Facades\Request;
use App\Models\Workflow\WorkflowHistory;
use Illuminate\Support\Facades\Validator;
use App\Models\Workflow\WorkflowHistories;
use App\Models\Hiring\JobApplication\JobVacancy;
use App\Models\Hiring\JobApplication\JobDescTransaction;
use App\Models\Hiring\JobApplication\JobVacancyDocument;
use App\Repositories\EmployerRepositories\EmployerRepository;



class WorkflowRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = WorkflowHistory::class;


    protected $employer;
    protected $history;

    public function __construct(WorkflowHistory $history, EmployerRepository $employer)
    {
        $this->employer = $employer;
        $this->history = $history;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */



public function saveInitiatedVacancy($request)
{


      DB::beginTransaction();

        try {
            $input = $request->all();

       $initiate_vacancy =     $this->history->create([
                // 'employer_id' => !empty($input['employer_id']) ? $input['employer_id'] : null,
                'workflow_id' => !empty($input['workflow_id']) ? $input['workflow_id'] : null,
                'comments' => !empty($input['initiate_comment']) ? $input['initiate_comment'] : null,
                'model_type' => 'App\Models\Hiring\JobApplication\JobVacancy',
                'user_id' => $input['user_id'],
                'attended_by' => $input['user_id'],
                'status' => 1, // submitted
                'parent_id' => null,
                'attended_date' => null,
                'level'  => 1, //will determine level of  workflow
                'stage' => 1
                ]);

           $this->saveWorkflowTrack($initiate_vacancy);
           DB::commit();

            return response()->json(['message' => 'Job workflow successfully initiated.', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create user', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create user', 'status' => 500]);
        }
}
public function saveWorkflowTrack($initiate_vacancy)
{
  DB::beginTransaction();

        try {

                $initiated = new WorkflowTrack();

                $initiated->user_id = $initiate_vacancy->user_id;
                $initiated->status = 0;
                $initiated->created_date = Carbon::now();
                $initiated->workflow_history_id = $initiate_vacancy->id;
                $initiated->save();

            DB::commit();

            return response()->json(['message' => 'workflow track created.', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create user', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create user', 'status' => 500]);
        }

}
//working on the  review vacancy workflow
public function saveReviewVacancy($request)
{

      DB::beginTransaction();

        try {
            $input = $request->all();

       $review_vacancy =     $this->history->create([
                // 'employer_id' => !empty($input['employer_id']) ? $input['employer_id'] : null,
                'workflow_id' => !empty($input['workflow_id']) ? $input['workflow_id'] : null,
                'comments' => !empty($input['review_comment']) ? $input['review_comment'] : null,
                'model_type' => 'App\Models\Hiring\JobApplication\JobVacancy',
                'user_id' => $input['user_id'],
                'attended_by' => $input['user_id'],
                'status' => 2, // Review
                'parent_id' => $input['parent_id'],
                'attended_date' => Carbon::now(),
                'level'  => 2, //will determine level of  workflow
                'stage' => 1
                ]);

           $this->saveWorkflowTrack($review_vacancy);
           DB::commit();

            return response()->json(['message' => 'Job workflow successfully review.', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to review job', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to review job', 'status' => 500]);
        }
}



public function retriveInitiatedVacancy($workflow)
{

  return WorkflowHistory::select('*')->where('workflow_id', $workflow)->first();

}













      public function getVacancies()
    {
        // return  $this->vacancy->get();
        return JobVacancy::select([
            DB::raw('job_vacancies.id'),
            DB::raw('job_vacancies.employer_id'),
            DB::raw('job_vacancies.job_title_id'),
            DB::raw('job_vacancies.department_id'),
            DB::Raw('position_vacant'),
            DB::raw('accademic'),
            DB::raw('date_application'),
            DB::raw('deadline_date'),
            DB::raw('hr_interview_date'),
            DB::raw('tech_interview_date'),
            DB::raw('apointment_date'),
            DB::raw('work_station'),
            DB::raw('replacement_reason'),
            DB::raw('age'),
            DB::raw('professional'),
            DB::raw('salary_range'),
            DB::raw('others'),
            DB::raw('additional_comment'),
            DB::Raw('e.name as employer'),
            DB::Raw('d.name as department'),
            DB::Raw('jt.name as job_title'),
            DB::Raw('tv.name as vacancy_type'),
            DB::Raw('jbt.name'),
            DB::Raw("CASE WHEN job_vacancies.status = 0 THEN 'Submitted' WHEN job_vacancies.status = 1 THEN 'Initiated' WHEN job_vacancies.status = 2 THEN 'Pending' WHEN job_vacancies.status = 3 THEN 'Approved' ELSE 'Rejected' END AS status"),


        ])
            ->join('employers as e', 'job_vacancies.employer_id', '=', 'e.id')
            ->join('departments as d', 'job_vacancies.department_id', '=', 'd.id')
            ->join('job_title as jt', 'job_vacancies.job_title_id', '=', 'jt.id')
            ->join('type_vacancies as tv', 'job_vacancies.type_vacancy_id', '=', 'tv.id')
            ->join('job_desc_transactions as jbt', 'job_vacancies.id', '=', 'jbt.job_vacancy_id')

            ->whereNull('job_vacancies.deleted_at')
            ->get();
    }
    public function getJobDocument()
    {
        return  JobVacancyDocument::select('*', 'name as vacancy_doc')->get();
    }

    public function addVacancy($request)
    {

        // Log::info('hapa atumefika');

        DB::beginTransaction();

        try {
            $input = $request->all();

       $new_vacancy =     $this->history->create([
                'employer_id' => !empty($input['employer_id']) ? $input['employer_id'] : null,
                'job_title_id' => !empty($input['job_title_id']) ? $input['job_title_id'] : null,
                'department_id' => !empty($input['department_id']) ? $input['department_id'] : null,
                'type_vacancy_id' => !empty($input['type_vacancy_id']) ? $input['type_vacancy_id'] : null,
                'position_vacant' => !empty($input['position_vacant']) ? $input['position_vacant'] : null,
                'date_application' => !empty($input['date_application']) ? $input['date_application'] : null,
                'deadline_date' => !empty($input['deadline_date']) ? $input['deadline_date'] : null,
                'hr_interview_date' => !empty($input['hr_interview_date']) ? $input['hr_interview_date'] : null,
                'tech_interview_date' => !empty($input['tech_interview_date']) ? $input['tech_interview_date'] : null,
                'apointment_date' => !empty($input['apointment_date']) ? $input['apointment_date'] : null,
                'work_station' => !empty($input['work_station']) ? $input['work_station'] : null,
                'replacement_reason' => !empty($input['replacement_reason']) ? $input['replacement_reason'] : null,
                'age' => !empty($input['age']) ? $input['age'] : null,
                'accademic' => !empty($input['accademic']) ? $input['accademic'] : null,
                'professional' => !empty($input['professional']) ? $input['professional'] : null,
                'salary_range' => !empty($input['salary_range']) ? $input['salary_range'] : null,
                'others' => !empty($input['others']) ? $input['others'] : null,
                'additional_comment' => !empty($input['additional_comment']) ? $input['additional_comment'] : null,
                'status' => 0, // submitted


            ]);
            DB::commit();

            Log::info('Saved done');
            return response()->json(['message' => 'User created successfully', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create user', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create user', 'status' => 500]);
        }
    }
    public function updateDetails($request, $id)
    {
        DB::beginTransaction();

        try {

            JobVacancy::where('id', $id)
                ->update([
                    'employer_id' => !empty($request['employer_id']) ? $request['employer_id'] : null,
                    'employer_id' => $request['employer_id'],
                    'job_title_id' => $request['job_title_id'],
                    'department_id' => $request['department_id'],
                    'type_vacancy_id' => $request['type_vacancy_id'],
                    'position_vacant' => $request['position_vacant'],
                    'date_application' => $request['date_application'],
                    'deadline_date' => $request['deadline_date'],
                    'hr_interview_date' => $request['hr_interview_date'],
                    'tech_interview_date' => $request['tech_interview_date'],
                    'apointment_date' => $request['apointment_date'],
                    'work_station' => $request['work_station'],
                    'replacement_reason' => $request['replacement_reason'],
                    'age' => $request['age'],
                    'accademic' => $request['accademic'],
                    'professional' => $request['professional'],
                    'salary_range' => $request['salary_range'],
                    'others' => $request['others'],
                    'additional_comment' => $request['additional_comment'],
                ]);



            DB::commit();
            Log::info('updated done');
            return response()->json(['message' => 'User Updated successfully', 'status' => 200], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create user', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to Update user', 'status' => 500]);
        }
        // }
    }


}
