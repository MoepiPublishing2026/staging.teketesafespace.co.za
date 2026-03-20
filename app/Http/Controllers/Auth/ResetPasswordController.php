<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/school-admin';

   
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'string',
                'min:8',                         // Minimum 8 characters
                'max:50',                        // Maximum 50 characters
                'regex:/[A-Z]/',                 // Must contain at least one uppercase letter
                'regex:/[0-9]/',                 // Must contain at least one digit
                'regex:/[\W_]/',                 // Must contain at least one special character
            ],
        ];
    }

   
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password); // ✅ HASH the password
        $user->setRememberToken(Str::random(60));
        $user->save();

        $this->guard()->login($user);
    }
}