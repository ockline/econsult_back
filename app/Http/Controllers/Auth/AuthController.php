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
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AuthController extends Controller
{

// public function login(LoginRequest $request)
//     {
//             log::info('ndannniiiiii');
//         $credential = $request->validated();
//         if (!Auth::attempt($credential)){
//         // log::info('hapaaa nimefeli');
//             return response()->json([ 'status' => 422,
//                 'message' => 'Incorrect Email or Password'
//             ]);
//         }else{
//         /** @var User $user */
//         $user = Auth::user();

//      $user_roles = DB::table('role_user as ru')->select('r.name','r.alias')
//             ->join('roles as r', 'ru.role_id', '=', 'r.id')->where('ru.user_id', $user->id)->whereNull('ru.deleted_at')->get();
//         log::info(json_encode($user_roles));
//         $token = $user->createToken('main')->plainTextToken;
//         return response(compact('user','token','user_roles'));
//             log::info('imekubali ');
//             // return response()->json([ 'status' => 200 , 'token' =>$token]);
//         }

//     }



/**
*@method to logn with handling of three attempt
 */
public function login(LoginRequest $request)
{
    $email = $request->input('email'); // or username field if you're not using email
    $key = 'login.attempts.' . Str::lower($email); // unique key per user
    $maxAttempts = 3;
    $decayMinutes = 5;

    if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
        $seconds = RateLimiter::availableIn($key);
        return response()->json([
            'status' => 429,
            'message' => "Too many login attempts. Try again in " . ceil($seconds / 60) . " minute(s)."
        ]);
    }

    $credentials = $request->validated();

    if (!Auth::attempt($credentials)) {
        RateLimiter::hit($key, $decayMinutes * 60); // hit rate limiter
        return response()->json([
            'status' => 422,
            'message' => 'Incorrect Email or Password'
        ]);
    }

    RateLimiter::clear($key); // clear attempts on success

    /** @var User $user */
    $user = Auth::user();

    $user_roles = DB::table('role_user as ru')
        ->select('r.name', 'r.alias')
        ->join('roles as r', 'ru.role_id', '=', 'r.id')
        ->where('ru.user_id', $user->id)
        ->whereNull('ru.deleted_at')
        ->get();

    $token = $user->createToken('main')->plainTextToken;

    return response(compact('user', 'token', 'user_roles'));
}


public function logout(Request $request)
{
    // Revoke the token that was used to authenticate the current request
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Successfully logged out']);
}

/**
 * Logout from all devices - revoke all tokens for the current user
 */
public function logoutAllDevices(Request $request)
{
    $request->user()->tokens()->delete();

    return response()->json(['message' => 'Logged out from all devices successfully']);
}


    public function user(Request $request)
    {
        return response()->json($request->user());
    }

/**
*@method to get token and  user details
 */
    public function getToken(Request $request)
{
    $user = Auth::user();

     $user_roles = DB::table('role_user as ru')->select('r.name','r.alias')
            ->join('roles as r', 'ru.role_id', '=', 'r.id')->where('ru.user_id', $user->id)->whereNull('ru.deleted_at')->get();

        $token = $user->createToken('main')->plainTextToken;
        return response(compact('user','token','user_roles'));

}
}
