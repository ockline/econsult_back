<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\GeneralException;
use App\Http\Traits\PasswordHistories;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

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

    use PasswordHistories;

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
    public function showResetForm(Request $request, $token = null)
    {
        // die;

        return view('frontend.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }


    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            //'captcha' => 'required|captcha',
        ]);

        $response = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        if ($response === Password::PASSWORD_RESET) {
            return redirect()->route('frontend.compliance')->with('status', trans($response));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }

    protected function resetPassword($user, $password)
    {

        $ispassword_in_history=$this->checkPasswords($user->id,$password);

        if($ispassword_in_history){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'password' => ['You have already used this password, kindly choose another password'],
            ]);
            throw $error;
        }

        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));
        $user->password_changed_at = Carbon::now()->toDateTimeString();
        $user->save();
        // $this->storePasswordHistory($user->id,Hash::make($password));
        // $this->deletePasswordHistory($user->id);

        // event(new PasswordReset($user));

        // $this->guard()->login($user);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker("users");
    }

}
