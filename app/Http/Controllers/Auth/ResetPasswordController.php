<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Traits\PasswordHistories;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    // use PasswordHistories;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Display the password reset view for the given token.
     *
     * @param Request $request
     * @param null $token
     * @return $this
     */
    // public function showResetForm(Request $request, $token = null)
    // {
    //     // die;

    //     return view('frontend.auth.passwords.reset')->with(
    //         ['token' => $token, 'email' => $request->email]
    //     );
    // }


    public function reset(Request $request, $token = null)
    {

        $request->validate([
            // 'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|min:8',
            //'captcha' => 'required|captcha',
        ]);

//         $response = $this->broker()->reset(

//             $request->only('email', 'password','new_password', 'confirm_password', ),
//             function ($user, $password) {
// log::info('ndaniii ya blocker');
//                 $this->resetPassword($user, $password);
//             }
//         );

    $response = $this->resetPassword($request);






//         if ($response === Password::PASSWORD_RESET) {
// log::info('ndaniii ya imefanikiwa ku resert');
//             return response()->json(['status' => 200, 'response' => $response]);
//         }

//         return back()
//             ->withInput($request->only('email'))
//             ->withErrors(['email' => trans($response)]);
    }

    protected function resetPassword($request){
        $ispassword_in_history  = $this->checkPasswords($request);

        if($ispassword_in_history){
            return response()->json(['status' => 200,
                'message' => 'Password Successfuly reset'
            ]);

        }
return response()->json(['status' => 422,
                'message' => 'Sorry Operation Failed'
            ]);

    }


public function checkPasswords($request)
{
// $user_exist = Auth::user()->id;
// log::info($user_exist);
// log::info('inatakiwa ureste');
    $user =  User::select('*')->first();
// log::info($user);
        if($request->email === $user->email){
        // if($request->password === $user->password){

                $password = $request->new_password;
                $confirm_password = $request->confirm_password;
                $user->password = Hash::make($password);
                $user->confirm_password = Hash::make($confirm_password);
// log::info($user);
                $user->save();

    //  }

return response()->json(['status' => 200]);
}
return response()->json(['status' => 422]);

}






    // /**
    //  * Get the broker to be used during password reset.
    //  *
    //  * @return \Illuminate\Contracts\Auth\PasswordBroker
    //  */
    // public function broker()
    // {
    //     return Password::broker("users");
    // }

}
