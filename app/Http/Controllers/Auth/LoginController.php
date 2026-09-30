<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //Show login Page
    public function loginForm()
    {
        return view('auth.login');
    }
    //logging In
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email','password');
        $user = Auth::guard('web')->attempt($credentials);

        if ($user) {
           return to_route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    //Logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('admin');
    }
}
