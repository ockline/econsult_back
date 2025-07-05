<?php

namespace App\Repositories\IndustrialRelationship;


use Exception;
use Mpdf\Mpdf;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\throwException;
use App\Models\IndustrialRelationship\Misconduct\Misconduct;
use App\Models\IndustrialRelationship\Disciplinary\Disciplinary;
use App\Models\IndustrialRelationship\Disciplinary\AppealAttachment;

use App\Models\IndustrialRelationship\Misconduct\MisconductWorkflow;
use App\Models\IndustrialRelationship\Disciplinary\AppealDisciplinary;
use App\Models\IndustrialRelationship\Misconduct\MisconductAttachment;
use App\Models\IndustrialRelationship\Disciplinary\DisciplinaryWorkflow;
use App\Models\IndustrialRelationship\Disciplinary\DisciplinaryAttachment;
use App\Models\IndustrialRelationship\Disciplinary\AppealDisciplinaryWorkflow;

class DisciplinaryRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Disciplinary::class;


    protected $disciplinary;


    public function __construct(Disciplinary $disciplinary)
    {
        $this->disciplinary = $disciplinary;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $disciplinarys = $this->disciplinary->where("id", $id)->first();

        if (!is_null($disciplinarys)) {
            return $disciplinarys;
        }
        // throw new GeneralException(trans('exceptions.operation.data_not_found'));
    }
    public function retrieveEmployeeDetail($id)
    {
        $data = DB::table('employees as e')->select('e.employee_no as employee_id', 'e.firstname', 'e.middlename', 'e.lastname', 'e.job_title_id', 'e.department_id',  DB::raw("CONCAT(COALESCE(e.firstname, ''), ' ', COALESCE(e.middlename, ''), ' ', COALESCE(e.lastname, '')) AS employee_name"), 'jt.name as job_title', 'dpt.name as departments', 'e.employer_id', 'emp.name as employer', 'mw.misconduct_id', 'mw.case_decision', 'mw.comments', 'ds.id as disciplinary_id')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->leftJoin('disciplinaries as ds', 'ds.employee_id', '=', 'e.employee_no')
            ->join('misconduct_workflows as mw', 'mw.misconduct_id', '=', 'ds.misconduct_id')
            ->where('e.employee_no', $id)
            ->first();

        return $data;
    }

    /**
     *method to initiate disciplinary  action this   function are   called during Disciplinary
     */

    public function disciplinaryInitatiation($request, $misconductId)
    {


        try {
            $disciplinary = new Disciplinary();

            $deatils = Misconduct::where('id', $misconductId)->first();
            $existence = Disciplinary::where('employee_id', $deatils->employee_id)->get()->count();
            $data = [
                'misconduct_id' => $misconductId,
                'employer_id' => $deatils->employer_id,
                'employee_id' => $deatils->employee_id,
                'remarks' =>  $request->incidence_remarks ?? null,
                'case_decision' => $request->case_decision ?? null,
                'action_taken' => $request->action_taken ?? null,
                'count' => $existence + 1 ?? 1,
                'is_charge_sheet' => 0,
                'issue_charge_sheet_date' => null,
                'is_notice_appeal' => 0,
                'is_employee_notified' => 0,
                'employee_notification_date' => null,
                'is_employee_appeal' => 0,
                'appeal_date' => null,
                'initiated_by' => Auth::user()->id,
                'initiation_date' => now(),
                'decision_release_date' => now(),
                'status' => 'Waiting',
                'stage' =>  'Priminary Stage', //'Secondary Stage',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $disciplinary->fill($data);
            $disciplinary->save();

            return true;
        } catch (\Throwable $th) {
            Log::error("disciplinary initiation failed: " . $th->getMessage());
            throw new \Exception("Error on creating disciplinary", 1);
        }
    }

    public function retrieveAllDisciplinary()
    {
        // Step 1: Get the latest workflow per misconduct_id using ROW_NUMBER()
        $latestWorkflow = DB::table('misconduct_workflows')
            ->select(
                'id',
                'misconduct_id',
                'case_decision',
                'action_taken',
                DB::raw("TO_CHAR(attended_date::DATE, 'DD-Mon-YYYY') AS initiated_date"),
                DB::raw('ROW_NUMBER() OVER (PARTITION BY misconduct_id ORDER BY id DESC) as row_num')
            );

        // Step 2: Wrap the above query and filter for row_num = 1
        $latestWorkflow = DB::table(DB::raw("({$latestWorkflow->toSql()}) as mw"))
            ->mergeBindings($latestWorkflow)
            ->where('row_num', 1);

        // Step 3: Main query joining employees and the latest workflow
        $data = DB::table('disciplinaries as ds')
            ->select(
                'ds.id',
                DB::raw("TO_CHAR(ds.issue_charge_sheet_date::DATE, 'DD-Mon-YYYY') AS issue_charge_sheet_date"),
                DB::raw("TO_CHAR(ds.appeal_date::DATE, 'DD-Mon-YYYY') AS appeal_date"),
                DB::raw("TO_CHAR(ds.employee_notification_date::DATE, 'DD-Mon-YYYY') AS employee_notification_date"),
                'ds.is_notice_appeal',
                'ds.is_employee_notified',
                'ds.is_employee_appeal',
                'ds.remarks',
                'ds.count as disciplinary_number',
                'ds.status',
                'e.employee_no as employee_id',
                DB::raw("CONCAT(e.firstname, ' ', e.middlename, ' ', e.lastname) AS employee_name"),
                'e.firstname',
                'e.middlename',
                'e.lastname',
                'e.mobile_number',
                'jt.name as job_title',
                'dpt.name as departments',
                'emp.name as employer',
                'mw.case_decision',
                'mw.action_taken',
                'mw.initiated_date'
            )
            ->leftJoin('employees as e', 'ds.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', '=', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->leftJoinSub($latestWorkflow, 'mw', function ($join) {
                $join->on('mw.misconduct_id', '=', 'ds.misconduct_id');
            })
            ->orderBy('ds.id', 'DESC')
            ->get();

        return $data;
    }

    public function updateDisciplinary($request)
    {
        try {
            $disciplinary =  Disciplinary::where('id', $request->disciplinary_id)->first();

            if (!$disciplinary) {
                throw new Exception("Error No disciplinary found", 1);
            }

            $data = [

                'employer_id' => $request->employer_id,
                'employee_id' => $request->employee_id,
                'remarks' =>  $request->disciplinary_comment ?? null,
                'case_decision' => $request->case_decision ?? null,
                'action_taken' => $request->action_taken ?? null,
                'is_charge_sheet' => !empty($request->charge_sheet_doc) ? 1 : 0,
                'issue_charge_sheet_date' => now(),
                'is_employee_notified' => 1,
                'employee_notification_date' => now(),
                'updated_at' => now(),
            ];
            $disciplinary->fill($data);
            $success =  $disciplinary->save();
            if ($success) {
                $disciplinaryId = $disciplinary->id;
                $charge =  $this->saveDisciplinaryDocument($request, $disciplinaryId);
                if ($charge) {
                    // $this->sendChargeSheetNotification($request, $disciplinaryId); //to send sms and email to employee to receive charge sheet
                    $this->createDisciplinaryWorkflow($request, $disciplinaryId);
                }
            }

            return true;
        } catch (\Throwable $th) {
            Log::error("disciplinary update failed: " . $th->getMessage());
            throw new \Exception("Error on updating disciplinary", 1);
        }
    }
    public function retrieveDisciplinaryDetails($id)
    {
        $latestWorkflow = DB::table('misconduct_workflows')
            ->select(
                'id',
                'misconduct_id',
                'case_decision',
                'action_taken',
                'comments',
                DB::raw("TO_CHAR(attended_date::DATE, 'DD-Mon-YYYY') AS initiated_date"),
                DB::raw('ROW_NUMBER() OVER (PARTITION BY misconduct_id ORDER BY id DESC) as row_num')
            );

        // Step 2: Wrap the above query and filter for row_num = 1
        $latestWorkflow = DB::table(DB::raw("({$latestWorkflow->toSql()}) as mw"))
            ->mergeBindings($latestWorkflow)
            ->where('row_num', 1);

        // Step 3: Main query joining employees and the latest workflow
        $data = DB::table('disciplinaries as ds')
            ->select(
                'ds.id',
                DB::raw("TO_CHAR(ds.issue_charge_sheet_date::DATE, 'DD-Mon-YYYY') AS issue_charge_sheet_date"),
                DB::raw("TO_CHAR(ds.appeal_date::DATE, 'DD-Mon-YYYY') AS appeal_date"),
                DB::raw("TO_CHAR(ds.employee_notification_date::DATE, 'DD-Mon-YYYY') AS employee_notification_date"),
                'ds.is_notice_appeal',
                'ds.is_employee_notified',
                'ds.is_employee_appeal',
                'ds.remarks',
                'ds.count as disciplinary_number',
                'ds.status',
                'e.employee_no as employee_id',
                DB::raw("CONCAT(e.firstname, ' ', e.middlename, ' ', e.lastname) AS employee_name"),
                'e.firstname',
                'e.middlename',
                'e.lastname',
                'e.mobile_number',
                'jt.name as job_title',
                'dpt.name as departments',
                'emp.name as employer',
                'mw.case_decision',
                'mw.action_taken',
                'mw.comments as disciplinary_comment',
                'mw.initiated_date'
            )
            ->leftJoin('employees as e', 'ds.employee_id', '=', 'e.employee_no')
            ->leftJoin('job_title as jt', 'e.job_title_id', '=', 'jt.id')
            ->leftJoin('departments as dpt', 'e.department_id', '=', 'dpt.id')
            ->leftJoin('employers as emp', 'e.employer_id', '=', 'emp.id')
            ->leftJoinSub($latestWorkflow, 'mw', function ($join) {
                $join->on('mw.misconduct_id', '=', 'ds.misconduct_id');
            })

            ->where('ds.id', $id)
            ->first();
        return  $data;
    }
    public function retrieveWorkflowDisciplinary($disciplinaryId) {}
    public function reviewDisciplinaryWorkflow($request) {}
    public function initiateEmployeeAppeal($request)
    {


        try {
            DB::transaction(function () use ($request) {


                $appeal = new AppealDisciplinary();
                $appeal->comments = $request->comments ?? null;
                $appeal->appeal_date = now();
                $appeal->count = $checkAppealExist ?? 1;
                $appeal->source = 'System';
                $appeal->disciplinary_id = $request->disciplinary_id ?? null;
                $appeal->initiated_by = Auth::user()->id ?? null;
                $appeal->initiated_date = now();
                $appeal->is_employee_appeal = !empty($request->notice_appeal_attachment) ? 1 : 0;
                $appeal->is_notice_appeal = !empty($request->notice_appeal_attachment) ? 1 : 0;
                $appeal->updated_at = now();
                $appeal->stage = 'Appeal';

                $data =  $appeal->save();
                if ($data) {
                    Disciplinary::where('id', $request->disciplinary_id)->update([
                        'is_employee_appeal' => !empty($request->notice_appeal_attachment) ? 1 : 0,
                        'is_notice_appeal' => !empty($request->notice_appeal_attachment) ? 1 : 0,
                    ]);
                    $appealId = $appeal->id;
                    $this->createAppealWorkflow($request, $appealId);
                }
                $this->saveAppealDocument($request, $appeal->id);
            });

            return response()->json(['status' => 200, 'message' => 'Appeal successfully initiated']);
        } catch (\Exception $e) {
            Log::error('Failure to create appeal error: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'Initiate failed']);
        }
    }
    /**
     *@method to save document  for appeal like notice of appeal
     */
    public function saveAppealDocument($request, $id)
    {
        try {
            $documents = [];
            $documentTypes = ['notice_appeal_attachment', 'appeal_supportive_signed'];

            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType) && $id) {
                    $files = $request->file($documentType);

                    // Normalize to array if single file
                    $files = is_array($files) ? $files : [$files];

                    foreach ($files as $file) {
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path("industrials/disciplinary/appeals/{$id}"), $fileName);

                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType),
                            'description' => $fileName,
                            'document_group_id' => 13,
                            'appeal_id' => $id,
                        ];
                    }
                }
            }

            foreach ($documents as $document) {
                AppealAttachment::create($document);
            }

            Log::info('Appeal documents saved successfully');
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to save appeal document', ['error' => $e->getMessage()]);
            return false;
        }
    }



    public function getDocumentId($documentId)
    {
        // $document_id = [50,51]; required document
        //  $documentTypes = ['notice_appear_attachment','charge_sheet_doc'];
        switch ($documentId) {

            case 'notice_appeal_attachment';
                return 55;
                break;
            case 'charge_sheet_doc';
                return 57;
                break;
            default:
                return null;
        }
    }
    public function  createAppealWorkflow($request, $appealId)
    {

        try {

            DB::transaction(function () use ($request, $appealId) {
                $appealInitiator =  AppealDisciplinary::where('id', $appealId)->first();
                $checkIfExist = Disciplinary::where('id', $request->disciplinary_id)->first();

                if (!$checkIfExist) {
                    throw new \Exception('Sorry! No disciplinary record exists');
                }

                $appeal = new AppealDisciplinaryWorkflow();
                $appeal->comments = $request->comments ?? null;
                $appeal->appeal_id =  $appealId  ?? $request->appeal_id;
                $appeal->attended_date = now();
                // $appeal->appeal_outcome = !empty($request->appeal_outcome) ?? null;
                $appeal->updated_at = now();
                $appeal->stage = 'Appeal';
                $appeal->status = 'Initiated';
                $appeal->attended_by  = $appealInitiator->initiated_by;
                $appeal->function_name = 'Appeal Initiation';
                $appeal->previous_stage = 'Appeal Initiator';
                $appeal->next_stage = 'Appeal Reviewer';
                $data =  $appeal->save();
            });

            return response()->json(['status' => 200, 'message' => 'Appeal successfully initiated']);
        } catch (\Exception $e) {
            Log::error('Failure to create appeal error: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'Initiate failed']);
        }
    }
    /**
     *method to  review appeal
     */
    public function reviewDisciplinaryAppeal($request)
    {

        try {
            DB::transaction(function () use ($request) {
                $checkIfExist = AppealDisciplinaryWorkflow::where('id', $request->appeal_id)->first();

                if (!$checkIfExist) {
                    throw new \Exception('Sorry! No appeal record exists');
                }

                $appeal = new AppealDisciplinaryWorkflow();
                $appeal->comments = $request->comments ?? null;
                $appeal->appeal_id =  $appealId  ?? $request->appeal_id;
                $appeal->attended_date = now();
                $appeal->appeal_outcome = !empty($request->appeal_outcome) ?? null;
                $appeal->updated_at = now();
                $appeal->stage = 'Appeal';
                $appeal->status = 'Initiated';
                $appeal->function_name = 'Appeal Reviewal';
                $appeal->previous_stage = 'Appeal Reviewer';
                $appeal->next_stage = $request->appeal_outcome == 'Appeal Allowed' ? 'Appeal Reviewer' : null;
                $data =  $appeal->save();

                if ($data) {
                    if ($request->appeal_outcome == 'Appeal Allowed') {
                        AppealDisciplinary::where('id', $appeal->appeal_id)->update(['status' => 'Reviewed', 'stage' => 'Hearing']);
                    }
                    AppealDisciplinary::where('id', $appeal->appeal_id)->update(['status' => 'Reviewed', 'stage' => 'Decision']);
                }
            });


            return response()->json(['status' => 200, 'message' => 'Appeal successfully Reviewed']);
        } catch (\Exception $e) {
            Log::error('Failure to review appeal error: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'Reviewed failed']);
        }
    }
    /**
     *@method to save disciplinary attachmnet
     */
    public function saveDisciplinaryDocument($request, $disciplinaryId)
    {

        try {
            $documents = [];
            $documentTypes = ['notice_appeal_attachment', 'appeal_supportive_signed', 'charge_sheet_doc'];

            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType) && $disciplinaryId) {
                    $files = $request->file($documentType);

                    // Normalize to array if single file
                    $files = is_array($files) ? $files : [$files];

                    foreach ($files as $file) {
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path("industrials/disciplinary/{$disciplinaryId}"), $fileName);

                        $documents[] = [
                            'name' => $documentType,
                            'document_id' => $this->getDocumentId($documentType),
                            'description' => $fileName,
                            'document_group_id' => 13,
                            'disciplinary_id' => $disciplinaryId,
                        ];
                    }
                }
            }

            foreach ($documents as $document) {
                DisciplinaryAttachment::create($document);
            }
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to save disciplinary document', ['error' => $e->getMessage()]);
            return false;
        }
    }
    /**
     *@method to create  disciplinary workflows
     */
    public function createDisciplinaryWorkflow($request, $disciplinaryId)
    {
        try {

            DB::transaction(function () use ($request, $disciplinaryId) {

                $checkIfExist = Disciplinary::where('id', $request->disciplinary_id)->count();

                if (!$checkIfExist) {
                    throw new \Exception('Sorry! No disciplinary record exists');
                }

                $disciplinary = new DisciplinaryWorkflow();
                $disciplinary->comments = $request->disciplinary_comment ?? null;
                $disciplinary->disciplinary_id =  $disciplinaryId  ?? $request->disciplinary_id;
                $disciplinary->user_id = Auth::user()->id;
                $disciplinary->attended_date = now();
                // $disciplinary->disciplinary_outcome = !empty($request->disciplinary_outcome) ?? null;
                $disciplinary->updated_at = now();
                $disciplinary->stage = 'Disciplinary';
                $disciplinary->status = 'Initiated';
                $disciplinary->attended_by  = Auth::user()->id;
                $disciplinary->function_name = 'Disciplinary Initiation';
                $disciplinary->previous_stage = 'Disciplinary Initiator';
                $disciplinary->next_stage = 'Disciplinary Reviewer';
                $data =   $disciplinary->save();

                if ($data) {
                    Disciplinary::where('id', $disciplinaryId)->update(['status' => 'Initiated', 'stage' => 'Hearing Invitation']);
                }
            });

            return response()->json(['status' => 200, 'message' => 'Appeal successfully initiated']);
        } catch (\Exception $e) {
            Log::error('Failure to create appeal error: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'Initiate failed']);
        }
    }
}
