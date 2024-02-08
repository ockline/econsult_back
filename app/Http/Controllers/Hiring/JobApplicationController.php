<?php

namespace App\Http\Controllers\Hiring;

use Illuminate\Http\Request;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Hiring\JobApplication\JobVacancy;
use App\Repositories\EmployerRepositories\EmployerRepository;
use App\Repositories\HiringRepositories\JobApplicationRepository;

class JobApplicationController extends Controller
{
    protected $vacancy;

    public function __construct(JobApplicationRepository $vacancy)
    {
        $this->vacancy = $vacancy;
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

            'employer_id' => 'required|max:191',
            'job_title_id' => 'required|max:191',
            'department_id' => 'required|max:191',
            'type_vacancy_id' => 'required|max:191',
            'position_vacant' => 'required|max:191',
            'date_application' => 'required|max:191',
            'deadline_date' => 'required|max:191',
            'hr_interview_date' => 'required|max:191',
            'tech_interview_date' => 'required|max:191',
            'apointment_date' => 'required|max:191',
            'work_station' => 'required|max:191',
            'age' => 'required|max:191',
            'accademic' => 'required|max:191',
            'professional' => 'required|max:191',
            'salary_range' => 'required|max:191',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
            Log::info('ndani ya nyumba');
            $new_vacancy = $this->vacancy->addVacancy($request);

            $status = $new_vacancy->getStatusCode();

            // Get HTTP status code
            $responseContent = $new_vacancy->getContent();

            if ($status) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Employer Registered Successfully",
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

    public function saveJobDescription()
    {

        // Log::info('ndani');
        $request = request()->all();

        if ($request['name'] === null) {
            log::info('hapa');
            $return = ["status" => 404, "message" => "No Job description fill please fill it before you submit"];
        } else {
            log::info('chini');
            $job = $this->vacancy->jobDescription();

            $status = $job->getStatusCode();

            // Get HTTP status code
            $responseContent = $job->getContent();
            if ($status) {
                $return = ["status" => 200, "message" => "Job description Successful added"];
            }
        }
        return response()->json([$return]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $details = $this->vacancy->getVacancies();
        $formData = $details->find($id);
        if (isset($formData)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'formData' => $formData
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }

    public function edit(string $id)
    {
        // Log::info($id);

        // $vacancyList = $this->vacancy(); // Assuming $vacancyList is an array of objects

        $vacancy = JobVacancy::find($id);
        //   Log::info($vacancyList->$vacancy);
        if (isset($vacancy)) {
            return response()->json([
                'status' => 200,
                'vacancy' => $vacancy,
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
        $vacancy = $this->vacancy->updateDetails($request, $id);

        $status = $vacancy->getStatusCode();
        // Log::info($status);
        // Get HTTP status code
        $responseContent = $vacancy->getContent();


        if ($status === 200) {
            // log::info('ndani');
            return response()->json([
                'status' => 200,
                "message" => "Vacancy Updated Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'


            ]);
        }
    }


    public function updateDescription(Request $request, string $id)
    {
        //    Log::info($request->all());
        $job_description = $this->vacancy->updateJobDescription($request, $id);

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

        $vacancy = JobVacancy::find($id);
        // log::info($vacancy);

        $mployer_deactivation = $this->vacancy->deactivateVacancy($id);

        if ($vacancy) {
            return response()->json([
                "status" =>  200,
                "message" => 'Record updated and deleted successfully'
            ]);
        } else {
            return response()->json([
                "status" =>  404,
                "vacancy" => "Action Failed",
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */

    public function  vacancy()
    {
        // Log::info('anafikaaa mkali');
        $vacancy =    $this->vacancy->getVacancies();
        // Log::info($vacancy;
        if ($vacancy) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'vacancy' => $vacancy
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
    public function downloadJob(string $id)
    {
        // log::info('ndanioiaiaiai');
        $details = $this->vacancy->getVacancies();
        $vacancy = $details->find($id);
        //  Log::info($vacancy);
        if (isset($vacancy)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'vacancy' => $vacancy
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
