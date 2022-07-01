<?php

namespace App\Http\Controllers\Driver;

use App\Driver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('driver.auth.login');
    }
    public function login(Request $request)
    {
        $messages = [
            "email.required" => "Username is required",
            "password.required" => "Password is required",
            "password.min" => "Password must be at least 8 characters"
        ];

        $this->validate($request, [
            'email'   => 'required',
            'password' => 'required|min:3'
        ],$messages);

        if (Auth::guard('driver')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/driver');
        }
    
        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'email' => 'Wrong information or this account not login.',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:40',
            'last_name' => 'required|max:40',
            'phone' => 'required|max:15',
            'email' => 'required|email|max:255',
            'password' => 'required|min:3|max:20',
        ]);

        $driver = Driver::create([
            'driver_id' => rand(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('driver')->login($driver);
        return redirect()->intended('/driver');
    }
    public function logout(Request $request)
    {
        Auth::guard('driver')->logout();
        return redirect('driver/login');
    }
}
