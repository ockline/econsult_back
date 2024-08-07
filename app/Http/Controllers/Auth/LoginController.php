<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Middleware\Authenticate as Middleware;


class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $authenticationResult = $this->performAuthentication($credentials);

        if ($authenticationResult['status'] === 200) {
            // Authentication successful, redirect to intended page
            return redirect()->intended('dashboard');
        } else {
            // Authentication failed, redirect back to login with error message
            return redirect()->route('login')->with('error', $authenticationResult['message']);
        }
    }
    private function performAuthentication(array $credentials): array
    {
         log::info('hapaa');
        // Perform your authentication logic here
        if (Auth::attempt($credentials)) {
            // Authentication successful
log::info('ndani');
// In your Laravel controller
return ['status' => 200, 'message' => 'Login successful'];

            // return ['success' => true, 'message' => 'Login successful'];
        } else {
            // Authentication failed
            return response()->json(['success' => false, 'message' => 'Invalid credentials']);
        }
    }
}
