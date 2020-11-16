<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::guard('user')->check()) return Redirect('/dashboard');
        return view('auth.login');
    }

    public function register()
    {
        if (Auth::guard('user')->check()) return Redirect('/dashboard');
        return view('auth.register');
    }

    public function registerStore(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|max:100',
            'phone' => 'required|max:15',
            'password' => 'required|max:20|min:8|confirmed',
        ]);

        $user = User::create([
            'user_id' => 'UR' . rand(100, 999) . time(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('user')->login($user);

        return redirect()->intended('/dashboard');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|max:20|min:8',
        ]);


        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('/dashboard');
        }
        $request->session()->flash('login_error', 'Wrong information or this account not login.');
        return back()->withInput($request->only('email', 'remember'));

        dd($request->all());
    }



    public function update(Request $request, $id)
    {
        //
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        return redirect('/');
    }
}
