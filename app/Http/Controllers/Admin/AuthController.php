<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $adminCredentials = [
        'username' => 'admin',
        'password' => 'awedoosawe2'
    ];

    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($request->username === $this->adminCredentials['username'] && 
            $request->password === $this->adminCredentials['password']) {
            
            // Set admin session
            session(['admin_auth' => true]);
            session(['admin_username' => $request->username]);
            
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout(Request $request)
    {
        // Clear admin session
        $request->session()->forget(['admin_auth', 'admin_username']);
        
        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    }
}
