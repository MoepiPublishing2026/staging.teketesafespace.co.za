<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

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

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // Laravel only sends a link when the address belongs to an account.
        // Keep the public response identical for sent, unknown, and throttled requests.
        Password::broker('users')->sendResetLink($this->credentials($request));

        $message = 'If an account matches that email address, a password reset link will be sent.';

        return $request->wantsJson()
            ? response()->json(['message' => $message], 200)
            : back()->with('status', $message);
    }
}
