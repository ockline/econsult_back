<?php
/*
Author: Ockline Msungu
Created date : 2024-01-15
*/

namespace App\Repositories;


use Exception;
use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseREpository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class UserRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = User::class;


    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $users = $this->user->where("id", $id)->first();

        if (!is_null($users)) {
            return $users;
        }
        // throw new GeneralException(trans('exceptions.backend.claim.notification_report_not_found'));
    }

    public function getAllUser()
    {
        $users =    DB::table('users as u')
            ->select('u.id', 'u.name as user', 'u.email', 'u.phone', 'u.dob', 'u.designation_id', 'd.name as department')
            ->join('departments as d', 'u.department_id', '=', 'd.id')
            ->get();

        return $users;
    }

    public function addUsers($request)
    {

        Log::info('hapaa');

        // $initialLetter = strtoupper(substr($input['firstname'], 0, 1));

    //    $creater = auth()->user()->id;

        // Continue processing with the $input data
       DB::beginTransaction();

    try {
        $input = $request->all();
    // log::info($request->all());
          $creater = 1;
        $this->user->create([
            'samaccountname' => $input['firstname'] . "." . $input['lastname'],
            'username' => $input['firstname'] . "." . $input['lastname'],
            'firstname' => (!empty($input['firstname'])) ? $input['firstname'] : null,
            'middlename' => (!empty($input['middlename'])) ? $input['middlename'] : null,
            'lastname' => (!empty($input['lastname'])) ? $input['lastname'] : null,
            'phone' => (!empty($input['phone'])) ? $input['phone'] : null,
            'dob' =>  (!empty($input['dob'])) ? $input['dob'] : null,
            'gender_id'  => (!empty($input['gender_id']))? $input['gender_id'] : null,
            'password' => !empty($input['password']) ? $input['password'] : null,
            'email' => !empty($input['email']) ? $input['email'] : null,
            'confirm_password' => !empty($input['confirm_password']) ? $input['confirm_password'] : null,
            'designation_id' => !empty($input['designation_id'])? $input['designation_id'] : null,
            'department_id' => !empty($input['department_id']) ? $input['department_id'] : null,
            'section_id' => !empty($input['section_id']) ? $input['section_id'] : null,
            'employer_id' => !empty($input['employer_id']) ? $input['employer_id'] : null,
            'role_id'  => !empty($input['role_id'])? $input['role_id'] : null,
            'project_name'  => !empty($input['project_name']) ?  $input['project_name'] :null,
            'location_project'  => !empty($input['location_project']) ? $input['location_project'] : null,
            'created_by' => !empty($creater) ? $creater : 1

        ]);


        // Handle the case where to send email to user that have register on ECMS
        //    $this->sendNotification($data);

        DB::commit();
Log::info('data saved.');
        Log::info('*******************');
        dump('hapaaaa chini');
        return response()->json(['message' => 'User created successfully'], 201);
    } catch (\Exception $e) {
        DB::rollback();

        return response()->json(['message' => 'Failed to create user', 'error' => $e->getMessage()], 500);
    }
    // public function updateUser(){

    // }
}


}
