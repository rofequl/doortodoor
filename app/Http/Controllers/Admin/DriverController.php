<?php

namespace App\Http\Controllers\Admin;

use App\Shipment;
use App\User;
use App\Driver;
use App\Driver_shipment;
use App\Driver_hub_shipment_box;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function index()
    {
        $driver = Driver::orderBy('id', 'DESC')->get();
        return view('admin.driver.driver', compact('driver'));
    }

    public function delivery_note(Shipment $shipment)
    {
        return Driver_hub_shipment_box::where('shipment_id',$shipment->id)->pluck('driver_note')->first();
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'email' => 'email|max:191',
            'phone' => 'required|max:191',
            'password' => 'required|max:20|min:6|confirmed',
        ]);

        $register_user = new Driver();
        $register_user->driver_id = 'DR' . rand(100, 999) . time();
        $register_user->first_name = $request->first_name;
        $register_user->last_name = $request->last_name;
        $register_user->email = $request->email;
        $register_user->phone = $request->phone;
        $register_user->password = Hash::make($request->password);
        $register_user->save();

        Session::flash('message', 'Driver add successfully');
        return redirect('/admin/driver-list');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Driver::find($id)->delete();
        Session::flash('message', 'Driver Delete successfully');
        return redirect('/admin/driver-list');
    }


    function assigned_shipments($id){
        Session::flash('message', 'Driver assigned shipments');
        $shipments = Driver_shipment::where('driver_id',$id)->get();
        return view('admin.driver.shipments', compact('shipments'));
    }
}
