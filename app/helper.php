<?php

use App\BasicInformation;
use App\Shipment;
use App\Zone;
use App\Area;
use App\User;
use App\Driver_shipment;

function basic_information()
{
    $data = BasicInformation::all();
    if ($data->count() < 1) {
        $insert = new BasicInformation();
        $insert->status = 0;
        $insert->save();
    }
    $data = BasicInformation::all()->first();
    return $data;
}


function get_zone($id)
{
    return Zone::findOrFail($id);
}

function hub_from_area($id){
    $area = Area::find($id);
    return \App\Hub::where('id',$area->hub_id)->first();
}

function is_user_filled($id){
    $user = User::find($id);
    if(empty($user->shop_name) || empty($user->address) || empty($user->area_id)){
        request()->session()->flash('message', 'Please complete your profile first!');
        return 0;
    }else return 1;
}

function user_shipment($id, $status = 1,$shipping_status=0)
{
    return Shipment::where('user_id', $id)->where(['status'=>$status,'shipping_status'=>$shipping_status])->get();
}

function driver_shipments($driver_id, $user_id)
{
    $shipments = Shipment::where('user_id',$user_id)->where(['status'=>1,'shipping_status'=>1])->get();
    $num = array();
    foreach ($shipments as $key => $shipment) {
        $num[] = Driver_shipment::where(['driver_id'=>Auth::guard('driver')->user()->id,'shipment_id'=>$shipment->id])->count();
    } 
    return COUNT($num);
}

// driver received shipments
function pick_shipments($driver_id, $user_id)
{
    $shipments = Shipment::where('user_id',$user_id)->where(['status'=>1,'shipping_status'=>2])->get();
    $num = array();
    foreach ($shipments as $key => $shipment) {
        $num[] = Driver_shipment::where(['driver_id'=>Auth::guard('driver')->user()->id,'shipment_id'=>$shipment->id])->count();
    } 
    return COUNT($num);
}

function is_belongsTo_hub($userHub,$authHub){
    if(Auth::guard('admin')->user()->role_id ==1)  {
        return true;
    }else{
        if($userHub==$authHub) return true;else return false;
    }
}


function is_shipment_On_dispatch($id){
    return \App\Hub_shipment::where(['shipment_id'=>$id,'status'=>'on-dispatch'])->count();
}

function user_hub_count($hub_id,$user_id,$status){
    return \App\Hub_shipment::where(['user_id'=>$user_id,'hub_id'=>$hub_id,'status'=>$status])->count();
}

function hub_shipment_count($hub_id,$status){
    return \App\Hub_shipment::where(['hub_id'=>$hub_id,'status'=>$status])->count();
}

function hubAt_hub_shipment_box($hub_id){
    // return $hub_id;
    return \App\Hub_shipment_box::where(['hub_id'=>$hub_id,'status'=>'dispatch'])->count();
}

// helper function for agent-dispatch on logistic
function is_assigned2Driver($box_id, $shipment_id,$status){
    return \App\Driver_hub_shipment_box::where([
        'hub_shipment_box_id'=>$box_id,'shipment_id'=>$shipment_id,'status'=>$status
    ])->count();
}

function is_avail_agentSide($box_id, $shipment_id){
    $query = \App\Driver_hub_shipment_box::where([
        'hub_shipment_box_id'=>$box_id,'shipment_id'=>$shipment_id
    ])->get(); return $query->count();
}

function is_in_reconcile_shipments($shipment_id){
    $q = \App\Reconcile_shipment::where(['shipment_id'=>$shipment_id,'status'=>'pending']);
    if($q->count() >0) return false; else return true;
}

function is_admin_allow($admin_id, $route){
    return  \DB::table('admin_roles')
     ->where('admin_id', '=', $admin_id)
     ->where('route', '=', $route)->count();   
}

function return_hub_count($hub_id,$status){
    return \App\Return_shipment::where(['hub_id'=>$hub_id,'status'=>$status])->count();
}

function returnAt_return_shipment_box($hub_id){
    // return $hub_id;
    $data = \App\Return_shipment_box::select('shipment_ids')->where(['hub_id'=>$hub_id,'status'=>'dispatch'])->pluck('shipment_ids')->first();
    return COUNT(explode(',',$data));
}

function is_return_avail_agentSide($box_id, $shipment_id){
    $query = \App\Driver_return_shipment_box::where([
        'return_shipment_box_id'=>$box_id,'shipment_id'=>$shipment_id
    ])->get(); return $query->count();
}
function is_return_assigned2Driver($box_id, $shipment_id,$status){
    return \App\Driver_return_shipment_box::where([
        'return_shipment_box_id'=>$box_id,'shipment_id'=>$shipment_id,'status_in'=>'assigning'
    ])->count();
}


function checkAdminAccess($route){
    if(Auth::guard('admin')->user()->role_id ==1)  {
        return 1;
    }
    $access = \App\Admin_role::where('admin_id',Auth::guard('admin')->user()->id)->where('route',$route);
    return $access->count();
}