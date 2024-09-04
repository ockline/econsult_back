<?php

namespace App\Http\Controllers\RolePermission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\RolePermissionRepository;



class RoleController extends Controller
{
    protected $roles;

    public function __construct(RolePermissionRepository $roles)
    {
        $this->roles = $roles;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */

    public function  retriveAllRoles()
    {
        // Log::info('anafikaaa mkali');
        $roles =    $this->roles->getRoles();
        // Log::info($employee);
        if ($roles) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'roles' => $roles,
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 404,
                'message' => "Sorry! No data found"
            ]);
        }
    }

    public function getAssignedRoleCount()
    {

        // $employed_count =    $this->roles->countAllEmployed();

        // if ($employed_count) {
        //     // Log::info('111');
        //     return response()->json([
        //         'status' => 200,
        //         'employed_count' => $employed_count,
        //     ]);
        // } else {
        //     // log::info('222');
        //     return response()->json([
        //         'status' => 404,
        //         'message' => "Sorry! No data found"
        //     ]);
        // }


    }
    /**
     *@method to  create roles to users
     */

    public function store(Request $request)
    {

        $data = $this->roles->saveUserRoles($request);

        $status = $data->getStatusCode();

        if ($status === 201) {
            return response()->json(['status' => 200, 'message' => 'Role successfully created.']);
        }
        return response()->json(['status' => 500, 'message' => 'Sorry! Operation Failed']);
    }

    /***
     *@method to get all user assigned roles
     */
    public function getUserRoles()
    {

        $user_roles =    $this->roles->getUserRoles();
        // Log::info($employee);
        if ($user_roles) {
            // Log::info('111');
            return response()->json([
                'status' => 200,
                'user_roles' => $user_roles,
            ]);
        } else {
            // log::info('222');
            return response()->json([
                'status' => 404,
                'message' => "Sorry! No data found"
            ]);
        }
    }
/***
*@method to check if   roles exist
 */
public function destroy(Request $request)
{
log::info($request->all());
    // Validate that role_id is an array and user_id is provided
    // $request->validate([
    //     'user_id' => 'required|integer',
    //     'role_id' => 'required|array',
    // ]);

    // Check if roles exist for the given user
    $check_exist = $this->checkIfRolesExist($request);

    if ($check_exist) {
        $data = $this->roles->removeUserRoles($request);

        $status = $data->getStatusCode();

        if ($status === 201) {
            return response()->json(['status' => 200, 'message' => 'Role removed Successfully']);
        }

        return response()->json(['status' => 500, 'message' => 'Sorry! Operation Failed']);
    }

    return response()->json(['status' => 404, 'message' => 'Sorry! Role not found']);
}

public function checkIfRolesExist($request)
{
    // Ensure role_id is an array
    if (!is_array($request->role_id)) {
        $request->role_id = [$request->role_id];
    }
        log::info( $request->role_id);
    // Check if any of the roles exist for the given user
    $exists = DB::table('role_user')
        ->where('user_id', $request->user_id)
        ->whereIn('role_id', $request->role_id)
        ->exists();

log::info(json_decode($exists));
    return $exists;
}

}
