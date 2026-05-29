<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('admin_name')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session([
                'admin_name' => $admin->nama,
                'admin_id'   => $admin->id_admin,
            ]);
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'LOGIN GAGAL. Email atau password salah.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['admin_name', 'admin_id']);
        return redirect()->route('home');
    }
}
