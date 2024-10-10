<?php

namespace App\Repositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Sysdef\Designation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;


class DesignationRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Designation::class;


    protected $designation;
    protected $users;

    public function __construct(Designation $designation, UserRepository $users)
    {
        $this->designation = $designation;
        $this->users = $users;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $designations = $this->designation->where("id", $id)->first();

        if (!is_null($designations)) {
            return $designations;
        }
        // throw new GeneralException(trans('exceptions.backend.claim.notification_report_not_found'));
    }

    public function getDEsignations()
    {
        $designations = $this->designation->selectRaw(" * , CASE WHEN status = 0 THEN 'Iniactive' ELSE 'Active' END AS Status")->get();
        // $designations = designation::table('designations')->select('*');
        return $designations;
    }



    public function addDesignations($request)
    {

        //   Log::info('hapa atumefika');
        $input = $request->all();
        //  Log::info($input);
        $this->designation->create([
            'name' => $input['name'],
            'unit' => $input['unit'],
            'status' => $input['status'],
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'designation added Successfully'

        ]);
    }

 public function userDesignation(){
    $details =  DB::table('users as u')
                   ->select('u.name as user','u.designation','u.phone','u.fax_number','u.email','u.photo', 'd.name as designation_name')
                    ->join('designations as d' , 'u.designation_id','=','d.id')
                    ->orderBy('d.id', 'ASC')->get();
    return  $details;
}

// public function updateDesignation(){
// log::info('ndani');
// $input = request()->all();
// if ($input) {
//     $designation = $this->designation->id; // Assuming you have an 'id' field in your request

//     if ($designation) {
//         $designation->name = $input['name'];
//         $designation->status = $input['status'];
//         $designation->unit = $input['unit'];

//         $designation->save();

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

