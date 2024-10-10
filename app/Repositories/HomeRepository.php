<?php

namespace App\Repositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Location\Region;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
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
        $employees = DB::table('contract_details as cd')
            ->select([
                DB::raw('CONCAT(cd.firstname, \' \', cd.middlename, \' \', cd.lastname) as employee_name'),
                DB::raw('c.name as contract'),
                DB::raw('e.employee_no as employee_id'),
                DB::raw('cd.phone_number as phone'),
                DB::raw('cd.email'),
                DB::raw('cd.residence_place'),
                DB::raw('TO_CHAR(cd.dob, \'DD-Mon-YYYY\') as birth_date'),
                DB::raw('TO_CHAR(cd.date_employed, \'DD-Mon-YYYY\') as employement_date'),
                DB::raw('cd.postal_address as address'),
                DB::raw('cs.start_date as contract_start'),
                DB::raw('cs.expected_end_date as contract_end'),
                DB::raw('TO_CHAR(cf.end_commencement_date, \'DD-Mon-YYYY\') as contract_start_date'),
                DB::raw('TO_CHAR(cf.end_commencement_date, \'DD-Mon-YYYY\') as contract_end_date'),
                DB::raw('jt.name as job'),
                // DB::raw('cf.status as status'),
            ])
            ->leftJoin('contracts  as c', 'cd.contract_id', '=', 'c.id')
            ->leftJoin('employees as e', 'cd.employee_id', '=', 'e.id')
            ->leftJoin('contract_specific as cs', 'cs.employee_id', '=', 'e.id')
            ->leftJoin('contract_fixed as cf', 'cf.employee_id', '=', 'e.id')
            ->leftJoin('job_title as jt', 'cd.job_title_id', '=', 'jt.id')
            //is status 1 completed
            // ->where('e.status', 1)
            // ->where('cd.status', 1)
            // ->where('cd .is_active', 1)
            ->distinct('e.employee_no')
            ->get();

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

    public function countAllEmployed()
    {
        $employed =  DB::table('contract_details as cd')
            ->select([
                DB::raw('CONCAT(cd.firstname, \' \', cd.middlename, \' \', cd.lastname) as employee_name'),
                DB::raw('c.name as contract'),
                DB::raw('e.employee_no as employee_id'),
                DB::raw('cd.phone_number as phone'),
                DB::raw('cd.email'),
                DB::raw('cd.residence_place'),
                DB::raw('TO_CHAR(cd.dob, \'DD-Mon-YYYY\') as birth_date'),
                DB::raw('TO_CHAR(cd.date_employed, \'DD-Mon-YYYY\') as employement_date'),
                DB::raw('cd.postal_address as address'),
                DB::raw('cs.start_date as contract_start'),
                DB::raw('cs.expected_end_date as contract_end'),
                DB::raw('TO_CHAR(cf.end_commencement_date, \'DD-Mon-YYYY\') as contract_start_date'),
                DB::raw('TO_CHAR(cf.end_commencement_date, \'DD-Mon-YYYY\') as contract_end_date'),
                DB::raw('jt.name as job'),
                // DB::raw('cf.status as status'),
            ])
            ->leftJoin('contracts  as c', 'cd.contract_id', '=', 'c.id')
            ->leftJoin('employees as e', 'cd.employee_id', '=', 'e.id')
            ->leftJoin('contract_specific as cs', 'cs.employee_id', '=', 'e.id')
            ->leftJoin('contract_fixed as cf', 'cf.employee_id', '=', 'e.id')
            ->leftJoin('job_title as jt', 'cd.job_title_id', '=', 'jt.id')
            // ->where('cd .is_active', 1)
            ->distinct('e.employee_no')
            ->get()->count();

$active_employee =DB::table('contract_details as cd')
            ->select([
                DB::raw('CONCAT(cd.firstname, \' \', cd.middlename, \' \', cd.lastname) as employee_name'),
                DB::raw('c.name as contract'),
                DB::raw('e.employee_no as employee_id'),
                DB::raw('cd.phone_number as phone'),
                DB::raw('cd.email'),
                DB::raw('cd.residence_place'),
                DB::raw('TO_CHAR(cd.dob, \'DD-Mon-YYYY\') as birth_date'),
                DB::raw('TO_CHAR(cd.date_employed, \'DD-Mon-YYYY\') as employement_date'),
                DB::raw('cd.postal_address as address'),
                DB::raw('cs.start_date as contract_start'),
                DB::raw('cs.expected_end_date as contract_end'),
                DB::raw('TO_CHAR(cf.end_commencement_date, \'DD-Mon-YYYY\') as contract_start_date'),
                DB::raw('TO_CHAR(cf.end_commencement_date, \'DD-Mon-YYYY\') as contract_end_date'),
                DB::raw('jt.name as job'),
                // DB::raw('cf.status as status'),
            ])
            ->leftJoin('contracts  as c', 'cd.contract_id', '=', 'c.id')
            ->leftJoin('employees as e', 'cd.employee_id', '=', 'e.id')
            ->leftJoin('contract_specific as cs', 'cs.employee_id', '=', 'e.id')
            ->leftJoin('contract_fixed as cf', 'cf.employee_id', '=', 'e.id')
            ->leftJoin('job_title as jt', 'cd.job_title_id', '=', 'jt.id')
            ->whereNull('cs.deleted_at')
            ->whereNull('cf.deleted_at')
            ->distinct('e.employee_no')
            ->get()->count();

$all_client =  DB::table('employers as e')->select('e.*')
                    // ->whereNull('e.deleted_at')
                    ->get()->count();

$active_client =  DB::table('employers as e')->select('e.*')
                    ->where('e.active', '1')->get()->count();

$unactive_client = DB::table('employers as e')->select('e.*')
                ->where('e.active', '2')->get()->count();
$get_count = [
            'employed' => $employed,
            'active_client' => $active_client,
            'unactive_client' => $unactive_client,
            'all_client' => $all_client,
            'active_employee' => $active_employee,

            ];

return $get_count;

    }
}
