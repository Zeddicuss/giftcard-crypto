<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function emailVerify()
    {
        return view('notify.email_verification');
    }

    public function verifyMail(Request $request)
    {  
        $request->validate([
            'verification_token' => 'required',
        ]);

        $user = User::where('verification_token', $request->verification_token)->first();

        if($user) {
            $user->email_verified_at = now();
            $user-> is_verified = true;
            $user->verification_token = null;
            
            $user->save();


        return redirect('/dashboard')->with('success', 'Email verified successfully!');        
    }
    return redirect('/verification')->with('error', 'Invalid Verification code!');
}

public function resend(Request $request)
{
    $user = $request->user();

    if (!$user) {
        // Handle case where user is not found or authenticated
        return redirect('/verification')->with('error', 'User not found.');
    }

    $user->VerifyEmail();

    return redirect('/verification')->with('message', 'Verification code sent!');
}
}
