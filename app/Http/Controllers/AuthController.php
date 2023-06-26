<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('admin.guest')->except('logout');
    }

    // Show Admin Login Form
    public function showAdminLogin()
    {
        return view('auth.admin.login');
    }


    // Authenticate the Admin User
    public function Adminlogin(Request $request)
    {
        $input = $request->except('_token');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::guard('admin')->attempt($input))
        {
            $username = Auth::guard('admin')->user()->firstname." ".Auth::guard('admin')->user()->lastname;
            return redirect()->route('admin.dashboard')->with('success', 'Welcome '.$username);
        }

        return back()->with('error', 'Please Enter Valid Email & Password');
    }


    // Logout Admin
    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
