<?php

namespace App\Http\Controllers\RolePermission;

use Illuminate\Http\Request;
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
            return response()->json(['status' => 200, 'message' => 'Role created Successfully']);
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
}
