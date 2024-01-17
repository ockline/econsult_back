<?php

namespace App\Repositories\EmployerRepositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Employer\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseREpository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;


class EmployerRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Employer::class;


    protected $employer;
    protected $users;

    public function __construct(Employer $employer, UserRepository $users)
    {
        $this->employer = $employer;
        $this->users = $users;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        // $employers = $this->employer->where("id", $id)->first();

        // if (!is_null($employers)) {
        //     return $employers;
        // }
        // throw new GeneralException(trans('exceptions.backend.claim.notification_report_not_found'));
    }

    public function getEmployers()
    {
        // $employers = $this->employer->selectRaw(" * , CASE WHEN status = 0 THEN 'Iniactive' ELSE 'Active' END AS Status")->get();
        $employers = DB::table('employers')->select('*')->get();
        return $employers;
    }



    public function addEmployers($request)
    {

        //   Log::info('hapa atumefika');
        // $input = $request->all();
        // //  Log::info($input);
        // $this->employer->create([
        //     'name' => $input['name'],
        //     'unit' => $input['unit'],
        //     'status' => $input['status'],
        // ]);

        // return response()->json([
        //     'status' => 200,
        //     'message' => 'Department added Successfully'

        // ]);
    }

 public function userEmployer(){
    $details =  DB::table('users as u')
                   ->select('u.name as user','u.designation_id','u.phone','u.fax_number','u.email', 'd.name as department_name')
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

