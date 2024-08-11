<?php

namespace App\Repositories;


use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Sysdef\Role;
use App\Models\Location\Region;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseREpository;
use Illuminate\Support\Facades\Validator;


class RolePermissionRepository extends  BaseRepository
{
    // use  FileHandler, AttachmentHandler, DefaultTrait;


    const MODEL = Role::class;


    protected $roles;


    public function __construct(Role $roles)
    {
        $this->roles = $roles;
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
                foreach ($request->role_id as $role) {
                    DB::table('role_user')->insert([
                        'user_id' => !empty($request->user_id) ? $request->user_id : 0,
                        'role_id' => !empty($role) ? $role : 0,
                        'created_at' => Carbon::now()

                    ]);
                }
            }
            DB::commit();

            Log::info('Saved done');
            return response()->json(['message' => 'User role created successfully', 'status' => 201], 201);
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
    ->get();


return $users;
}

}
