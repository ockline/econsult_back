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
use App\Models\IndustrialRelationship\Disciplinary\DisciplinaryInvitation;
use App\Models\IndustrialRelationship\Disciplinary\AppealDisciplinaryWorkflow;

class DisciplinaryHearingRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = DisciplinaryInvitation::class;


    protected $hearing;


    public function __construct(DisciplinaryInvitation $hearing)
    {
        $this->hearing = $hearing;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $disciplinarys = $this->hearing->where("id", $id)->first();

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


}
