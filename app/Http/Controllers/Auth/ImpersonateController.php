<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Exceptions\GeneralException;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Auth;
use Carbon\Carbon;
use Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\Member\ImpersonateUser;
use Illuminate\Cache\RateLimiter;

class ImpersonateController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Impersonate Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for claim and
    | to be able to access user profile
    |
    */

    use AuthCheck;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Maximum number of login attempts
     *
     * @var int
     */
    protected $maxAttempts = 2;

    /**
     * Get the number of minutes to throttle for.
     *
     * @var int
     */
    protected $decayMinutes = 5.12;


    public function testAuth(Request $request)
    {
        $og_request = $request;
        $request = $this->decript_token($request->token);
        $request = json_decode($request) ?? 0;

        if (!$request->user) {
            return "Please contact admin ";
        }


        session()->put('officer_id', (int)$request->officer_id);
        session()->put('officer_name', $request->officer_name);
        $user = User::where('id', (int)$request->user)->first();
        $affected = ImpersonateUser::where('wcf_user_id', (int)$request->officer_id)
        ->whereDate('created_at', '<=', Carbon::now()->subHour())
        ->where('online_user_id', (int)$request->user)->where('pin',sha1($request->pin))->first();

        // dd($affected);
        if (!empty($affected) && !empty($user)) {
            $affected->updated_at = Carbon::now();

            Auth::login($user);
            return redirect()->route('backend.manage.organization.choose');
        } else {
            echo "Inncorect or expired pin";
            $this->logout();
            exit();
        }

    }


    public function logout()
    {
        session()->forget('officer_id');
        session()->forget('officer_name');
        //access()->logout();
    }

    public function decript_token($cipher_data)
    {
        $inter_key = "yN!VkiK9#-GoUwB@eUD8l~zoY@3ccVm";
        $encryption_key = base64_decode($inter_key);
        @list($cipher_data, $iv) = explode('::', base64_decode($cipher_data), 2);
        $plain =  @openssl_decrypt($cipher_data, 'aes-256-cbc', $encryption_key, 0, base64_decode($iv));
        return $plain;
    }


    function accessLimit(Request $request,$user){
        $request->username = $user;
        $attempts=$this->limiter()->hit(
            $this->throttleKey($request), $this->decayMinutes()
        );
        if($attempts>3){
            return true;
        }else{
            return false;
         }
    }

}
