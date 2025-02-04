<?php

namespace App\Repositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Sysdef\Role;
use App\Models\Location\Region;
use App\Models\Sysdef\RoleUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\Staffs\InitiateWorkflowMail;
use Illuminate\Support\Facades\Validator;


class RolePermissionRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Role::class;


    protected $roles;

    protected $notification;
    public function __construct(Role $roles, NotificationRepository $notification)
    {
        $this->roles = $roles;
        $this->notification = $notification;
    }
    public function getRoles()
    {
        $details =  DB::table('roles as r')
            ->select('*')
            // ->orderBy('d.id', 'ASC')
            ->get();
        return  $details;
    }

    public function saveUserRoles($request)
    {
        DB::beginTransaction();

        try {;
            if ($request) {

                $last_role = DB::table('role_user')->latest('id')->first();


    DB::statement("SELECT setval('public.role_user_id_seq', $last_role->id, false)");

                foreach ($request->role_id as $role) {
                    // RoleUser::insert([
                    //     'user_id' => !empty($request->user_id) ? $request->user_id : 0,
                    //     'role_id' => !empty($role) ? $role : 0,
                    //     'created_at' => Carbon::now()

                    // ]);
                RoleUser::create([
            'user_id'   => $request->user_id ?? 0,
            'role_id'   => $role ?? 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
                }
            }
                // $this->notification->smsNotification(); // send  sms
                // $this->sendEmailNotification(); // send Email Notification

            DB::commit();

            Log::info('Saved done');
            return response()->json(['message' => 'User role successfully created ', 'status' => 201], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create User role', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to create User role', 'status' => 500]);
        }
    }
public function getUserRoles()
{
      $users = DB::table('role_user as ru')
    ->select(
        'ru.user_id',
        DB::raw("CONCAT(u.firstname, ' ', u.lastname) as user_name"),
        'u.active as status',
        DB::raw("STRING_AGG(r.name, ', ') as role_names")
    )
    ->leftJoin('users as u', 'ru.user_id', '=', 'u.id')
    ->leftJoin('roles as r', 'ru.role_id', '=', 'r.id')
    ->groupBy('ru.user_id', 'u.firstname', 'u.lastname', 'u.active')
->whereNull('ru.deleted_at')
    ->get();


return $users;
}

public function removeUserRoles($request)
{
    DB::beginTransaction();

    try {
        // Ensure role_id is an array
        if (!is_array($request->role_id)) {
            $request->role_id = [$request->role_id];
        }

        // Delete the roles for the given user
        DB::table('role_user')
            ->where('user_id', $request->user_id)
            ->whereIn('role_id', $request->role_id)
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now(),
            ]);

        DB::commit();

        Log::info('Roles removed successfully');
        return response()->json(['message' => 'Role removed successfully', 'status' => 201], 201);
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Failed to remove roles', ['error' => $e->getMessage()]);

        return response()->json(['message' => 'Failed to remove roles', 'status' => 500]);
    }
}
/**
*@method to  send email notification
 */
public function sendEmailNotification()
{
        log::info('mwanzooo');


            //fetch data for cordinators
            $initator = DB::table('users as u')
                ->select('u.email', 'u.firstname')
                ->leftJoin('role_user as ru', 'ru.user_id', '=', 'u.id')
                ->where('ru.role_id', '=', 32)
                ->first();

            // $cemail = $profile->email;   //to uncomment when go live or test
            $cemail = 'ockline.msungu@econsult.co.tz';
            log::info('tunaipataata');
            $attender = $initator->firstname;
            Mail::to($cemail)->send(new InitiateWorkflowMail($attender));

}

}
