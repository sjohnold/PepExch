<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\PasswordReset;
use App\Jobs\SendResetPasswordMail;

class PasswordResetController extends Controller
{
    //Show Reset Email Form Method
    public function emailForm()
    {
        return view('auth.email');
    }
    //After Click to "Send Rest Link" (Finding Email to Database)
    public function resetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'This email not found in our system.']);
        }
        PasswordReset::where('email', $user->email)->delete();
        $plainToken = Str::random(60);
        $hashedToken = Hash::make($plainToken);

        PasswordReset::create([
            'email' => $user->email,
            'token' => $hashedToken,
            'created_at' => Carbon::now(),
        ]);

        $resetLink = route('password.reset', ['token' => $plainToken, 'email' => $user->email]);
        SendResetPasswordMail::dispatch($user->email, $resetLink);
        return back()->with('status', 'We have e-mailed your password reset link!');
    }
    //Showing Reset Form
    public function resetForm(Request $request, $token = null)
    {
        $email = $request->query('email');
        return view('auth.reset_form', compact('token', 'email'));
    }
    //Password Changing Method
    public function resetPassword(PasswordResetRequest $request)
    {
        $data = $request->validated();
        //correction solve
        $passwordReset = PasswordReset::where('email',  $request->email)->first();
        if (!$passwordReset || !Hash::check($data['token'], $passwordReset->token)) {
            return back()->withErrors(['email' => 'Invalid token or email'])->withInput();
        }
        $user = User::where('email', $data['email'])->firstOrFail();
        $user->password = Hash::make($data['password']);
        $user->save();
        PasswordReset::where('email', $user->email)->delete();
        return redirect()->route('login')->with('status', 'Password reset successfully!');
    }

    //Forget Pass
}
