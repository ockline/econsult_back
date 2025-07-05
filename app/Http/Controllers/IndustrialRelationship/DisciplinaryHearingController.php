<?php

namespace App\Http\Controllers\IndustrialRelationship;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\IndustrialRelationship\Disciplinary\Disciplinary;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use App\Repositories\IndustrialRelationship\DisciplinaryRepository;
use App\Models\IndustrialRelationship\Misconduct\MisconductWorkflow;

class DisciplinaryController extends Controller
{
    protected $disciplinaries;

    public function __construct(DisciplinaryRepository $disciplinaries)
    {
        $this->disciplinaries = $disciplinaries;
    }

    /**
     *@method to fetch employee details
     */
    public function retrieveEmployeeDetail($id)
    {

        $employee =  $this->disciplinaries->retrieveEmployeeDetail($id);

        return response()->json(["status" => 200, "employee" => $employee]);
    }

    /**
     *@method to retrieve all  disciplinary details
     */
    public function retrieveAllDisciplinary()
    {

        $disciplinary =  $this->disciplinaries->retrieveAllDisciplinary();

        return response()->json(["status" => 200, "disciplinary" => $disciplinary]);
    }
    /**
     *@method to update disciplinary
     */
    public function  updateDisciplinary(Request $request)
    {

        $validator = Validator::make($request->all(), [

            // 'investigation_report_attachment' => 'required|max:191',
            'charge_sheet_doc' => 'required|',
        ]);

        if ($validator->fails()) {
            $return = ['validator_err' => $validator->errors()->toArray()];
        } else {

            $disciplinaries = $this->disciplinaries->updateDisciplinary($request);

            if ($disciplinaries) {
                // log::info('ndani');
                $return = [
                    'status' => 200,
                    "message" => "Disciplinary successfully updated.",
                ];
            } else {
                $return = [
                    'status' => 500,
                    'message' => '!Sorry operation failed.'
                ];
            }
        }
        return response()->json($return);
    }
    public function retrieveDisciplinaryDetails($id)
    {

        $disciplinary =  $this->disciplinaries->retrieveDisciplinaryDetails($id);

        return response()->json(["status" => 200, "disciplinary" => $disciplinary]);
    }
    public function retrieveWorkflowDisciplinary($disciplinaryId)
    {

        $disciplinary =  $this->disciplinaries->retrieveWorkflowDisciplinary($disciplinaryId);

        return response()->json(["status" => 200, "disciplinary" => $disciplinary]);
    }
    /**
     *@method to review  disciplinary submitted by HR
     */
    public function reviewDisciplinaryWorkflow(Request $request)
    {
        $disciplinary =  $this->disciplinaries->reviewDisciplinaryWorkflow($request);

        return response()->json(["status" => 200, "disciplinary" => $disciplinary]);
    }
    public function initiateEmployeeAppeal(Request $request)
    {

        try {
            $checkTimeRange = $this->checkIfAppealValid($request);

            if ($checkTimeRange) {
                $checkIfExist = Disciplinary::find($request->disciplinary_id);

                if (!$checkIfExist) {
                    throw new NotFoundHttpException('Sorry! No disciplinary record exists');
                }

                $checkAppealExist = Disciplinary::where('id', $request->disciplinary_id)
                    ->where('is_employee_appeal', true)
                    ->where('is_notice_appeal', true)
                    ->count();

                if ($checkAppealExist) {
                    throw new HttpException(422, 'Sorry! Appeal request already exists');
                }

                $disciplinary = $this->disciplinaries->initiateEmployeeAppeal($request);
                return response()->json(["disciplinary" => $disciplinary, 'message' => 'success']);
            }

            throw new HttpException(403, 'Appeal not allowed at this time');
        } catch (HttpExceptionInterface $e) {
            return response()->json([
                'status' => $e->getStatusCode(),
                'message' => $e->getMessage()
            ], $e->getStatusCode());
        } catch (\Exception $e) {
            Log::error('Appeal initiation failed: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'An unexpected error occurred'
            ], 500);
        }
    }
    /**
     *@method to check if appeal is valid or its out of  period
     */
    public function  checkIfAppealValid($request)
    {
        $misconduct  = Disciplinary::where('id', $request->disciplinary_id)->select('misconduct_id')->first();

        $checkValidity = MisconductWorkflow::select('attended_date')
            ->where('misconduct_id', $misconduct->misconduct_id)
            ->where('status', 'Reviewed')
            ->where('case_decision', 'Gross Misconduct')
            ->orderBy('id', 'DESC')
            ->first();

        $isWithin5WorkingDays = false;

        if ($checkValidity && $checkValidity->attended_date) {
            $attendedDate = Carbon::parse($checkValidity->attended_date);
            $workingDaysAdded = 0;
            $date = $attendedDate->copy();

            while ($workingDaysAdded < 5) {
                $date->addDay();
                if (!$date->isWeekend()) {
                    $workingDaysAdded++;
                }
            }
            // Now $date is 5 working days after attended_date
            $isWithin5WorkingDays = Carbon::now()->lessThanOrEqualTo($date);
        }

        return $isWithin5WorkingDays;
    }
    public function reviewDisciplinaryAppeal(Request $request)
    {

        $disciplinary =  $this->disciplinaries->reviewDisciplinaryAppeal($request);

        return response()->json(["status" => 200, "disciplinary" => $disciplinary]);
    }
}
