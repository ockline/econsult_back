<?php

namespace App\Repositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Sysdef\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use App\Repositories\DepartmentRepository;


class UnitRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Unit::class;


    protected $unit;
    protected $users;
   Protected $department;

    public function __construct(Unit $unit, UserRepository $users, DepartmentRepository $department)
    {
        $this->unit = $unit;
        $this->users = $users;
        $this->department = $department;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $units = $this->unit->where("id", $id)->first();

        if (!is_null($units)) {
            return $units;
        }
        // throw new GeneralException(trans('exceptions.backend.claim.notification_report_not_found'));
    }

    public function getUnits()
    {
        $units = $this->unit->selectRaw(" * , CASE WHEN status = 0 THEN 'Iniactive' ELSE 'Active' END AS Status")->get();
        // $units = unit::table('units')->select('*');
// Log::info($units);
        return $units;
    }



    public function addUnits($request)
    {

        //   Log::info('hapa atumefika');
        $input = $request->all();
        //  Log::info($input);
        $this->unit->create([
            'name' => $input['name'],
            'unit' => $input['unit'],
            'status' => $input['status'],
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Unit added Successfully'

        ]);
    }

 public function userUnit(){
    $details =  DB::table('users as u')
                   ->select('u.name as user','u.designation_id','u.phone','u.fax_number','u.email','u.photo', 'd.name as department_name')
                    ->join('departments as d' , 'u.department_id','=','d.id')
                    ->orderBy('d.id', 'ASC')->get();
    return  $details;
}


}

