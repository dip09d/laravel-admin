<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            return response()->json([
                'success' => true,
                'redirect' => route('admin.dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid username or password.'
        ]);
    }



    public function dashboard()
    {
        return view('admin.dashboard'); // make this blade file
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
