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
            "password.min" => "Password must be at least 3 characters"
        ];

        $this->validate($request, [
            'name'   => 'required',
            'password' => 'required|min:3'
        ],$messages);

        if (Auth::guard('admin')->attempt(['email' => $request->name, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('/admin');
        }

        return back()->withInput($request->only('name', 'remember'))->withErrors([
            'name' => 'Wrong information or this account not login.',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:40',
            'last_name' => 'required|max:40',
            'phone' => 'required|max:40',
            'address' => 'required|max:40',
            'email' => 'required|email|max:255',
            'password' => 'required|min:3|max:20',
        ]);

        $admin = Admin::create([
            'role_id' => 2,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
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
