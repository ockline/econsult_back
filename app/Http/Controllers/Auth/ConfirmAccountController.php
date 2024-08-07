<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Mail\RegisterMail;
use Mail;
use App\Services\Notifications\Sms;
use App\Http\Controllers\Frontend\Msdgapi;
use App\Exceptions\GeneralException;

class ConfirmAccountController extends Controller
{
    /**
     * @var
     */
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function confirm($token)
    {
        $this->user->confirmAccount($token);
        return redirect()->route('backend.manage.organization.registration')
        ->withFlashSuccess(trans('exceptions.frontend.auth.confirmation.success'))
        ->withFlashInfo(trans('alerts.backend.registration.organization.register'));
    }

    public function sendConfirmationEmail(User $user)
    {
        /* Send confirmation email */
        Mail::to($user->email)->send(new RegisterMail($user->confirmation_code,$user->name));

        // $sms_token = substr( uniqid(), -6);

        // $msg="Your online account has been registered,please confirm your account via email or using ".$sms_token." continue registering your organization.";
        
        // $phone = str_replace("+255", "0", $user->phone);
        // $sms = new Sms($phone, $msg);
        // $sms->send();
        // $user->sms_token = md5($sms_token);
        // $user->save();


        // $msdg = new Msdgapi();

        // $datetime = date('Y-m-d H:i:s');
        // $message  = array('message' =>  $msg,'datetime'=>$datetime, 'sender_id'=>'WCF', 'mobile_service_id'=>'222', 'recipients'=>$phone);
        // $json_data = json_encode($message);

        // var_dump($msdg->sendQuickSms(array('data'=>$json_data,'datetime'=>$datetime)));

        // $user->notify(new UserNeedsConfirmation($user->confirmation_code, $user->name));
        return redirect()->back()->withFlashSuccess(trans('alerts.frontend.auth.confirmation_sent'));
    }


    public function smsConfirmForm(){
        return view('frontend.auth.sms_verify');
    }

    public function smsConfirm(Request $request){


        $user = User::where('sms_token','=',md5($request->sms_token))->first();

        if(!$user){
            return redirect()->back()->withFlashWarning('Invalid Token');
        }


        if ($user->confirmed == 'true') {
            throw new GeneralException(trans('exceptions.frontend.auth.confirmation.already_confirmed'));
        }


        if ($user->sms_token == md5($request->sms_token)) {
            $user->confirmed = 't';
            $user->save();
            access()->login($user);
            return redirect()->route('backend.manage.organization.registration')
            ->withFlashSuccess(trans('exceptions.frontend.auth.confirmation.success'))
            ->withFlashInfo(trans('alerts.backend.registration.organization.register'));
        }
        throw new GeneralException(trans('exceptions.frontend.auth.confirmation.mismatch'));
    }


    public function sendConfirmationSMS(User $user)
    {

    }

}
