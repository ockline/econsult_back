<?php

namespace App\Repositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Sysdef\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;


class DepartmentRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Department::class;


    protected $department;
    protected $users;

    public function __construct(Department $department, UserRepository $users)
    {
        $this->department = $department;
        $this->users = $users;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $departments = $this->department->where("id", $id)->first();

        if (!is_null($departments)) {
            return $departments;
        }
        // throw new GeneralException(trans('exceptions.backend.claim.notification_report_not_found'));
    }

    public function getDepartments()
    {
        $departments = $this->department->selectRaw(" * , CASE WHEN status = 0 THEN 'Iniactive' ELSE 'Active' END AS Status")->get();
        // $departments = Department::table('departments')->select('*');
        return $departments;
    }



    public function addDepartments($request)
    {

        //   Log::info('hapa atumefika');
        $input = $request->all();
        //  Log::info($input);
        $this->department->create([
            'name' => $input['name'],
            'unit' => $input['unit'],
            'status' => $input['status'],
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Department added Successfully'

        ]);
    }

 public function userDepartment(){
    $details =  DB::table('users as u')
                   ->select('u.name as user','u.designation_id','u.phone','u.fax_number','u.email','u.photo', 'd.name as department_name')
                    ->join('departments as d' , 'u.department_id','=','d.id')
                    ->orderBy('d.id', 'ASC')->get();
    return  $details;
}

// public function updateDepartment(){
// log::info('ndani');
// $input = request()->all();
// if ($input) {
//     $department = $this->department->id; // Assuming you have an 'id' field in your request

//     if ($department) {
//         $department->name = $input['name'];
//         $department->status = $input['status'];
//         $department->unit = $input['unit'];

//         $department->save();

//         return response()->json([
//             'status' => 200,
//             'message' => 'Successfully updated'
//         ]);
//     }
// else{
//     return response()->json([
//         'status' => 200,
//         'message' => 'Successful updated'

//      ]);
// }

// }
// }
}

