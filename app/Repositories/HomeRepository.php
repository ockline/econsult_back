<?php

namespace App\Repositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Location\Region;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseREpository;
use App\Repositories\DistrictRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\Personal\Employee;


class HomeRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Employee::class;


    protected $employee;


    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $employees = $this->employee->where("id", $id)->first();

        if (!is_null($employees)) {
            return $employees;
        }
        // throw new GeneralException(trans('exceptions.backend.claim.notification_report_not_found'));
    }

    public function getAllEmployeeDetail()
    {
        $employees = DB::table('employees as e')
                        ->select(['e.*',
DB::raw('cs.name as contract'),
DB::raw('cf.name as contract_fixed'),
DB::raw('cs.employee_name as employee_name'),
DB::raw('cf.employee_name as fixed_employee'),
DB::raw('cs.start_date as contract_start'),
DB::raw('cs.expected_end_date as contract_end'),
DB::raw('cf.commencement_date as contract_start_date'),
DB::raw('cf.end_commencement_date as contract_end_date'),
DB::raw('jt.name as job'),
// DB::raw('cf.status as status'),
])
->leftJoin('contract_specific as cs', 'cs.employee_id','=' ,'e.id')
->leftJoin('contract_fixed as cf', 'cf.employee_id','=' ,'e.id')
->leftJoin('job_title as jt', 'e.job_title_id','=' ,'jt.id')
->distinct('e.employee_no')
->get();
// Log::info($employees);
        return $employees;
    }





    public function userRegion()
    {
        $details =  DB::table('users as u')
            ->select('u.name as user', 'u.designation_id', 'u.phone', 'u.fax_number', 'u.email', 'd.name as region_name')
            ->join('regions as d', 'u.region_id', '=', 'd.id')
            ->orderBy('d.id', 'ASC')->get();
        return  $details;
    }
}
