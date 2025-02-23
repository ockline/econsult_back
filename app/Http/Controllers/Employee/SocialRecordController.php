<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Employee\Social\Dependant;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\Personal\Employee;
use App\Models\Employee\Social\SocialRecord;
use App\Models\Employee\Social\RelativeDetail;
use App\Models\Hiring\JobApplication\JobVacancy;
use App\Models\Employee\Personal\EmployeeEducation;
use App\Models\Employee\Personal\EmploymentHistory;
use App\Models\Hiring\Interview\CompetencyInterview;
use App\Models\Employee\Personal\EmploymentReference;
use App\Repositories\EmployeeRepositories\EmployeeRepository;
use App\Repositories\HiringRepositories\HrInterviewRepository;
use App\Repositories\EmployeeRepositories\SocialRecordRepository;

class SocialRecordController extends Controller
{
    protected $social_record;

    public function __construct(SocialRecordRepository $social_record)
    {
        $this->social_record = $social_record;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function getSocialRecord(string $id)
    {
        
        $employee = Employee::find($id);
        //   Log::info($employee);
        if (isset($employee)) {
            return response()->json([
                'status' => 200,
                'employee' => $employee,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function storeSocial(Request $request)
    {
        // Log::info('hellow ndani');
        // log::info($request->all());

        $validator = Validator::make($request->all(), [

            'district_id' => 'required|max:191',
            'department_id' => 'required|max:191',
            'firstname' => 'required|max:191',
            'middlename' => 'required|max:191',
            'lastname' => 'required|max:191',
            'national_id' => 'required|max:191',
            'expiration_date' => 'required|max:191',
            'telephone_home' => 'required|max:191',
            'mobile_number' => 'required|max:191',
            'person_email' => 'required|max:191',
            'employee_street' => 'required|max:191',
            'postal_address' => 'required|max:191',
            'tin' => 'required|max:191',

        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
                // Log::info('ndani ya nyumba');
            ;
            $new_employee = $this->social_record->addSocialRecord($request);

            $status = $new_employee->getStatusCode();

            // Get HTTP status code
            $responseContent = $new_employee->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Social record successfully created.",
                ];
            } else {
                $return = [
                    'status' => 500,
                    'message' => 'Sorry! Operation failed.'


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
    //  log::info($id);
        $details = $this->social_record->showDownloadDetails();
        // //   log::info($id);
        //  Log::info($details);
        $social_details = $details->where('employee_id', $id)->first();

        if (!empty($social_details)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'social_details' => $social_details,
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

        // $employeeList = $this->social_record(); // Assuming $employeeList is an array of objects

        $social_records = SocialRecord::where('employee_id', $id)->first();
        //   Log::info($employee);
        if (isset($social_records)) {
            return response()->json([
                'status' => 200,
                'social_records' => $social_records,
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
    public function updateSocialRecord(Request $request, string $id)
    {
        //   log::info('tumeeanza');
        // Log::info($request->all());
        $employee = $this->social_record->updateDetails($request, $id);
    // log::info($employee);
    //          Log::info('katiii hapa');
        $status = $employee->getStatusCode();
        // Log::info($status);
        // // Get HTTP status code
        // $responseContent = $employeee->getContent();

        //$status
        if ($status === 200) {
            // log::info('ndani');
            return response()->json([
                'status' => 200,
                "message" => "Social Record Updated Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Update process failed'


            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {

    //     $assessment = CompetencyInterview::find($id);
    //     // log::info($vacancy);

    //     // $mployer_deactivation = $this->assessment->deactivateAssessment($id);

    //     if ($assessment) {
    //         return response()->json([
    //             "status" =>  200,
    //             "message" => 'Record updated and deleted successfully'
    //         ]);
    //     } else {
    //         return response()->json([
    //             "status" =>  404,
    //             "assessment" => "Action Failed",
    //         ]);
    //     }
    // }
    /**
     * Remove the specified resource from storage.
     */

    public function  socialDetails()
    {
        // Log::info('anafikaaa mkali');
        $social_record =    $this->social_record->getSocialRecordDetail();
        // Log::info($assessment;
        if ($social_record) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'social_record' => $social_record
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 500,
                'message' => "Internal server Error"
            ]);
        }
    }
    /**
     *Save Education histories
     */
    public function saveRelativeDetail(Request $request)
    {
        //  log::info($request->all());
        $validator = Validator::make($request->all(), [
            'relative_id' => 'required|max:191',
            'relative_name' => 'required|max:191',
            'relative_number' => 'required|max:191',
            'relationship_id' => 'required|max:191',
            'relative_address' => 'required|max:191',


        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
            Log::info('ndani ya nyumba');

            $education_level = $this->social_record->addRelativeDetail($request);

            $status = $education_level->getStatusCode();

            // Get HTTP status code
            $responseContent = $education_level->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Relative details successfully addedd.",
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
    public function saveDepandant(Request $request)
    {
        //  log::info($request->all());
        $validator = Validator::make($request->all(), [

            'dependant_name' => 'required|max:191',
            'dependent_id' => 'required|max:191',
            'dob' => 'required|max:191',
            'dependant_type_id' => 'required|max:191',

        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {
                // Log::info('ndani ya nyumba');
            ;
            $employment = $this->social_record->addDependantDetails($request);

            $status = $employment->getStatusCode();

            // Get HTTP status code
            $responseContent = $employment->getContent();
            //  log::info($status);
            if ($status === 201) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Dependant people Successfully addedd.",
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


    public function editRelativeDetail(string $id)
    {
        // log::info($id);
        $relative_detail = DB::table('employee_reletives as er')->select([
            'er.*',
            DB::Raw("sr.relative_name as relative"),
            DB::Raw("sr.firstname as firstname"),
            DB::Raw("sr.lastname as lastname"),
            DB::Raw("dt.name as relationship"),
        ])
            ->leftJoin('social_records as sr', 'er.social_record_id', '=', 'sr.id')
            ->leftJoin('dependent_types as dt', 'er.relationship_id', '=', 'dt.id')
            ->where('er.employee_id', $id)
            ->get();
        //
        //   log::info('wpoo'. $relative_detail);
        if (isset($relative_detail)) {
            return response()->json([
                'status' => 200,
                'relative_detail' => $relative_detail,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }
    public function updateRelative(Request $request, string $id)
    {
        //    Log::info($request->all());
        $relative_detail = $this->social_record->updateRelativeDetail($request, $id);

        $status = $relative_detail->getStatusCode();
        // Log::info($status);
        // Get HTTP status code
        $responseContent = $relative_detail->getContent();


        if ($status === 200) {
            // log::info('ndani');
            return response()->json([
                'status' => 200,
                "message" => "Relative Updated Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'


            ]);
        }
    }

    public function editDependant(string $id)
    {

        $dependant_detail = DB::table('dependants as de')->select([
            'de.*',
             DB::Raw("dt.name as relationship"),
        ])
           ->leftJoin('dependent_types as dt', 'de.dependant_type_id', '=', 'dt.id')
            ->where('employee_id', $id)
            ->get();

        if (isset($dependant_detail)) {
            return response()->json([
                'status' => 200,
                'dependant_detail' => $dependant_detail,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No data found",

            ]);
        }
    }
    public function updateDependant(Request $request, string $id)
    {
        // log::info($id);
        // Log::info($request->all());
        $social_records = $this->social_record->updateDependantDetail($request, $id);

    //    log::info($social_records);
    //          Log::info('katiii hapa');
        $status = $social_records->getStatusCode();
        // Log::info($status);
        // Get HTTP status code
        $responseContent = $social_records->getContent();


        if ($status === 200) {
            // log::info('ndani');
            return response()->json([
                'status' => 200,
                "message" => "Dependant Updated Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Sorry! Operation failed'


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

    public function getSocialRecordDocument(string $id)
    {
        //   log::info($id);
        $document = $this->social_record->getPersonalDocument();
        //   log::info($document);
        $employee_document = $document->where('employee_id', $id);

        //   log::info($employee_document);
        if (isset($employee_document)) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'employee_document' => $employee_document
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
