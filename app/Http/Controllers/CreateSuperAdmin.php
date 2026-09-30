<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class CreateSuperAdmin extends Controller
{
    public function index()
    {
        return view('create-root');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Admin User
        $localAdmin = UserRepository::create([
                'email' => $request->email,
                'mobile' => '011' . rand(100000000, 999999999),
                'name' => 'Administrator',
                'email_verified_at' => now(),
                'status' => UserStatus::Approve->value,
                'password' => bcrypt($request->password),
            ]);

        $localAdmin->assignRole('Admin');

        // Redirect to the dashboard or any other page
        return redirect()->route('admin.login.view')->with('success', 'Spremni ste za korišćenje PepExch platforme! Prijavite se sa svojim podacima.');
    }
}
