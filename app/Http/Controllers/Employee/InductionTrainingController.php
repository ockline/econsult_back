<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\Personal\Employee;
use App\Models\Employee\Social\SocialRecord;
use App\Models\Hiring\JobApplication\JobVacancy;
use App\Models\Employee\Personal\EmployeeEducation;
use App\Models\Employee\Personal\EmploymentHistory;
use App\Models\Employee\Induction\InductionTraining;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Models\Employee\Personal\EmploymentReference;
use App\Repositories\EmployeeRepositories\EmployeeRepository;
use App\Repositories\HiringRepositories\HrInterviewRepository;
use App\Repositories\EmployeeRepositories\InductionTrainingRepository;

class InductionTrainingController extends Controller
{
    protected $induction;

    public function __construct(InductionTrainingRepository $induction)
    {
        $this->induction = $induction;
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
    public function storeTraining(Request $request)
    {
        // Log::info('hellow ndani');
        // log::info($request->all());

        $validator = Validator::make($request->all(), [
            'job_title_id' => 'required|max:191',
            'firstname' => 'required|max:191',
            'middlename' => 'required|max:191',
            'lastname' => 'required|max:191',
            'personal_contacts' => 'required|max:191',
            'personal_contacts' => 'required|max:191',
            'department_id' => 'required|max:191',
            // 'mobile_number' => 'required|max:191',
            'conducted_date' => 'required|max:191',
            'employment_date' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
            // Log::info('ndani ya nyumba');

            $new_induction = $this->induction->addInductionTraining($request);

            $status = $new_induction->getStatusCode();

            // Get HTTP status code
            $responseContent = $new_induction->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Induction Training Submitted",
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $details = $this->induction->showDownloadDetails();
        //   log::info($id);
        //  Log::info($details);
        $induction_training = $details->where('social_record_id', $id)->first();

        log::info(json_encode($induction_training));

        if (!empty($induction_training)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'induction_training' => $induction_training,
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }

    public function editInduction(string $id)
    {
        // Log::info($id);

        // $employeeList = $this->induction(); // Assuming $employeeList is an array of objects

        $induction_training = InductionTraining::where('social_record_id', $id)->first();
        //   Log::info(json_encode($induction_training));
        if (isset($induction_training)) {
            return response()->json([
                'status' => 200,
                'induction_training' => $induction_training,
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
    public function updateInductionTraining(Request $request, string $id)
    {
        //   log::info('tumeeanza');
        // Log::info($request->all());
        $employee = $this->induction->updateInductionDetails($request, $id);

        $status = $employee->getStatusCode();


        //$status
        if ($status === 200) {
            // log::info('ndani');
            return response()->json([
                'status' => 200,
                "message" => "Induction Training Updated Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Update process failed'
            ]);
        }
    }
    /**
     *@method to get complete stage 4 to next stage
     */
    public function completeInductionTraining(string $id)
    {
        // $social = SocialRecord::where('id', $id)->first();

        $induction_training = InductionTraining::where('social_record_id', $id)->first();


        if (!empty($induction_training)) {
            $data_update = $this->induction->updateStageData($induction_training);

                $status = $data_update->getStatusCode();
                log::info($status);

                // $status = $data_update->getStatusCode();

            if ($status === 200) {
                return response()->json([
                    'status' => 200,
                    'message' => "Induction Training Complete Successfuly",
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "No data found",

                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $assessment = InductionTraining::find($id);
        // log::info($vacancy);

        // $mployer_deactivation = $this->assessment->deactivateAssessment($id);

        if ($assessment) {
            return response()->json([
                "status" =>  200,
                "message" => 'Induction updated and deleted successfully'
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

    public function  inductionDetails()
    {
        // Log::info('anafikaaa mkali');
        $induction_detail =    $this->induction->getInductionDetail();

        if (!empty($induction_detail)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'induction_detail' => $induction_detail
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 404,
                'message' => "No data found"
            ]);
        }
    }

    // public function editEducationHistory(string $id)
    // {
    //     // log::info($id);
    //     $education_history = EmployeeEducation::select([
    //         '*',
    //         DB::Raw("ed.name as education"),
    //     ])
    //         ->join('education_histories as ed', 'employee_education_hist.education_id', '=', 'ed.id')
    //         ->where('employee_id', $id)
    //         ->get();
    //     //
    //     //   log::info('wpoo'. $education_history);
    //     if (isset($education_history)) {
    //         return response()->json([
    //             'status' => 200,
    //             'education_history' => $education_history,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 404,
    //             'message' => "No data found",

    //         ]);
    //     }
    // }
    // public function updateEducation(Request $request, string $id)
    // {
    //     //    Log::info($request->all());
    //     $education_history = $this->induction->updateEducationHistory($request, $id);

    //     $status = $education_history->getStatusCode();
    //     // Log::info($status);
    //     // Get HTTP status code
    //     $responseContent = $education_history->getContent();


    //     if ($status === 200) {
    //         // log::info('ndani');
    //         return response()->json([
    //             'status' => 200,
    //             "message" => "Education Updated Successfully",
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 500,
    //             'message' => 'Sorry! Operation failed'


    //         ]);
    //     }
    // }

    // public function editEmployment(string $id)
    // {

    //     $employment_history = EmploymentHistory::select([
    //         '*',
    //         //  DB::Raw("es.employee_name as education"),
    //     ])
    //         // ->leftJoin('employees as es', 'employee_employment_hist.employee_id', '=', 'es.id')
    //         ->where('employee_id', $id)
    //         ->get();

    //     if (isset($employment_history)) {
    //         return response()->json([
    //             'status' => 200,
    //             'employment_history' => $employment_history,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 404,
    //             'message' => "No data found",

    //         ]);
    //     }
    // }
    // public function updateEmployment(Request $request, string $id)
    // {
    //     // Log::info($request->all());
    //     $employment_history = $this->induction->updateEmploymentHistory($request, $id);

    //     $status = $employment_history->getStatusCode();
    //     // Log::info($status);
    //     // Get HTTP status code
    //     $responseContent = $employment_history->getContent();


    //     if ($status === 200) {
    //         // log::info('ndani');
    //         return response()->json([
    //             'status' => 200,
    //             "message" => "Employement Updated Successfully",
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 500,
    //             'message' => 'Sorry! Operation failed'


    //         ]);
    //     }
    // }
    // public function editReferenceCheckt(string $id)
    // {

    //     $reference_check = EmploymentReference::select('*')
    //         ->where('employee_id', $id)
    //         ->get();

    //     if (isset($reference_check)) {
    //         return response()->json([
    //             'status' => 200,
    //             'reference_check' => $reference_check,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 404,
    //             'message' => "No data found",

    //         ]);
    //     }
    // }

    // public function updateReferenceCheck(Request $request, string $id)
    // {
    //     // Log::info($request->all());
    //     $reference_check = $this->induction->updateEmploymentReference($request, $id);

    //     $status = $reference_check->getStatusCode();
    //     // Log::info($status);
    //     // Get HTTP status code
    //     $responseContent = $reference_check->getContent();


    //     if ($status === 200) {
    //         // log::info('ndani');
    //         return response()->json([
    //             'status' => 200,
    //             "message" => "Employement Updated Successfully",
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 500,
    //             'message' => 'Sorry! Operation failed'


    //         ]);
    //     }
    // }

    // // public function downloadJob(string $id)
    // // {
    // //     // log::info('ndanioiaiaiai');
    // //     $details = $this->assessment->getAssessedCandidate();
    // //     $assessment = $details->find($id);
    // //     //  Log::info($assessment);
    // //     if (isset($assessment)) {
    // //         // Log::info('111');
    // //         return response()->json([
    // //             'status' => 200,
    // //             'assessment' => $assessment
    // //         ]);
    // //     } else {
    // //         // log::info('222');
    // //         return response()->json([
    // //             'status' => 500,
    // //             'message' => "Internal server Error"
    // //         ]);
    // //     }
    // // }

    // public function getEmployeeDocument(string $id)
    // {
    //     $document = $this->induction->getPersonalDocument();
    //     //   log::info($document);
    //     $employee_document = $document->where('employee_id', $id);

    //     //   log::info($employee_document);
    //     if (isset($employee_document)) {
    //         // Log::info('111');
    //         return response()->json([
    //             'status' => 200,
    //             'employee_document' => $employee_document
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
