<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Shipment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth; use Session;

class DashboardController extends Controller
{
    public function index()
    {
        $shipment = Shipment::orderBy('id','DESC')->where('user_id', Auth::guard('user')->user()->id)->get();
        return view('dashboard.index',compact('shipment'));
    }

    public function account(){ return view('dashboard.account');}

    public function ChangeMail(Request $request){
        $request->validate([
            'email' => 'required|max:100',
            'password' => 'required|max:20',
        ]);

        $admin = User::where('id', $request->id)->first();
        if (!empty($admin)) {
            if ($admin && Hash::check($request->password, $admin->password)) {
                $admin->email = $request->email;
                $admin->save();
                $request->session()->flash('message', 'Email Change successfully');
                return redirect('/account');
            } else {
                $request->session()->flash('message', 'Password not match');
                return redirect('/account');
            }
        } else {
            $request->session()->flash('message', 'Something wrong try again later');
            return redirect('/account');
        }

    }

    public function ChangePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|max:20',
            'password' => 'required|max:20|confirmed',
        ]);

        $admin = user::where('id', $request->id)->first();
        if (!empty($admin)) {
            if ($admin && Hash::check($request->old_password, $admin->password)) {
                $admin->password = Hash::make($request->password);
                $admin->save();
                $request->session()->flash('message', 'Password Change successfully');
                return redirect('/account');
            } else {
                $request->session()->flash('message', 'Password not match');
                return redirect('/account');
            }
        } else {
            $request->session()->flash('message', 'Something wrong try again later');
            return redirect('/account');
        }

    }

    public function profile()
    {

        return view('dashboard.profile');
    }

    public function ProfileEdit()
    {
        $areas = \App\Area::all();
        return view('dashboard.profile_edit',compact('areas'));
    }

    public function ProfileUpdate(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'phone' => 'required|max:20',
            'shop_name' => 'required|max:100',
            'address' => 'required|max:255',
            'area_id' => 'required|max:255',
            'website_link' => 'sometimes|nullable|max:255',
            'id' => 'required',
        ]);

        $register_user = User::find($request->id);
        $register_user->first_name = $request->first_name;
        $register_user->last_name = $request->last_name;
        $register_user->phone = $request->phone;
        $register_user->shop_name = $request->shop_name;
        $register_user->address = $request->address;
        $register_user->area_id = $request->area_id;
        $register_user->website_link = $request->website_link;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileStore3 = rand(10, 100) . time() . "." . $extension;
            $request->file('image')->storeAs('public/user', $fileStore3);
            $register_user->image = $fileStore3;
        }
        $register_user->save();

        $request->session()->flash('message', 'Profile update successfully');
        return redirect('/profile');

    }
}
