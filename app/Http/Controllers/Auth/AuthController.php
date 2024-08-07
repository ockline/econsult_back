<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
// use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

public function login(LoginRequest $request)
    {

        $credential = $request->validated();
        if (!Auth::attempt($credential)){
        log::info('hapaaa nimefeli');
            return response()->json([ 'status' => 422,
                'message' => 'Incorrect Email or Password'
            ]);
        }else{
        /** @var User $user */
        $user = Auth::user();

     $user_roles = DB::table('role_user as ru')->select('r.name','r.alias')
            ->join('roles as r', 'ru.role_id', '=', 'r.id')->where('ru.user_id', $user->id)->get();
        log::info(json_encode($user_roles));
        $token = $user->createToken('main')->plainTextToken;
        return response(compact('user','token','user_roles'));
            log::info('imekubali ');
            // return response()->json([ 'status' => 200 , 'token' =>$token]);
        }

    }

public function logout(Request $request)
{
    // Revoke the token that was used to authenticate the current request
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Successfully logged out']);
}


    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
