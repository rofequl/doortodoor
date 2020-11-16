<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $messages = [
            "name.required" => "Username is required",
            "password.required" => "Password is required",
            "password.min" => "Password must be at least 8 characters"
        ];

        $this->validate($request, [
            'name'   => 'required',
            'password' => 'required|min:8'
        ],$messages);

        if (Auth::guard('admin')->attempt(['name' => $request->name, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('/admin');
        }

        return back()->withInput($request->only('name', 'remember'))->withErrors([
            'name' => 'Wrong information or this account not login.',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:40',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|max:20',
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('admin')->login($admin);

        return redirect()->intended('/admin');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
