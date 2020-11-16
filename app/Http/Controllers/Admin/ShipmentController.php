<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shipment;
use App\User;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipment = Shipment::where('status',1)->select('user_id')->groupBy('user_id')->pluck('user_id')->toArray();
        $user = User::whereIn('id',$shipment)->get();
        return view('admin.shipment.shipment-list',compact('user'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
        //
    }
}
