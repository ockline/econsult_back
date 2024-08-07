<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Password;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {

        return view('frontend.auth.passwords.email');
    }

    /**
     * password broker for admin guard.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker(){
        return Password::broker('users');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'captcha' => 'required|captcha',
        ]);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        if ($response === Password::RESET_LINK_SENT) {
            return back()->with('status', trans($response));
        }

        return back()
            ->withErrors(['email' => trans($response)])
            ->withInput($request->only('email'));
    }

}
