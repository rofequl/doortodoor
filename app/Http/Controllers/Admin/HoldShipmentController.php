<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shipment;
use App\Hub;
use App\Driver_return_shipment_box;
use App\Hub_shipment_box;
use App\Driver_hub_shipment_box;
use App\Driver;
use App\Driver_shipment_delivery;
use App\Return_shipment_box;
use App\Hold_shipment;
use App\Return_shipment;
use App\User;
use Session; use Auth;
use App\Events\ShipmentMovement;

class HoldShipmentController extends Controller
{
    public function index($type)
    {
        if($type=='hold'){
            return view('admin.shipment.hold.hold-shipments',compact('type'));
        }
        elseif($type=='return'){
            return view('admin.shipment.hold.return-shipments',compact('type'));
        }else{
            $hub_box = Driver_hub_shipment_box::where(['status'=>$type,'status_in'=>null])->select('hub_shipment_box_id')
            ->groupBy('hub_shipment_box_id')->pluck('hub_shipment_box_id')->toArray();
            $hubInfo = Hub_shipment_box::whereIn('id',$hub_box)->get();
      
            if($hubInfo->count() !=0){
                foreach($hubInfo as $ship){ $hub_ids[] = $ship->hub_id;}
                $hubs = Hub::whereIn('id',$hub_ids)->get();
            } else $hubs = array();
          
            return view('admin.shipment.hold.shipments',compact('type','hubs'));
        }
    }
    function driver_hub_shipments($type){
        $shipments = Driver_hub_shipment_box::where(['status'=>$type,'status_in'=>null])->get();
        if($type=='hold'){
            return view('admin.shipment.hold.include.driver_hub_shipments',compact('type','shipments'));
        }elseif($type=='return'){
            $hub = Return_shipment::where('status','assigning')->select('hub_id')->groupBy('hub_id')->pluck('hub_id')->toArray();
            $hubs = Hub::whereIn('id',$hub)->get();
            return view('admin.shipment.hold.include.return-left',compact('type','shipments','hubs'));
        }

    }

    public function move_to_hold_shipment(Shipment $shipment, Hub $hub)
    {
        $check = Hold_shipment::where(['shipment_id'=>$shipment->id,'status'=>'pending']);
        if($check->count() <1)
        {
            Hold_shipment::create([
                'shipment_id'=>$shipment->id,'hub_id'=>$hub->id,
                'admin_id'=>Auth::guard('admin')->user()->id,'status'=>'assigning'
            ]);
            Driver_hub_shipment_box::where('shipment_id',$shipment->id)->update([
                'status_in'=>'assigning'
            ]);
        }
    }
    public function move_to_hold_shipmentWithInvoice($invoice_id)
    {
        $shipment = Shipment::where('invoice_id',$invoice_id)->first();
        $check = Hold_shipment::where(['shipment_id'=>$shipment->id,'status'=>'pending']);

        if($check->count() <1)
        {
            Hold_shipment::create([
                'shipment_id'=>$shipment->id,'hub_id'=>$shipment->area->hub->id,
                'admin_id'=>Auth::guard('admin')->user()->id,'status'=>'assigning'
            ]);
            Driver_hub_shipment_box::where('shipment_id',$shipment->id)->update([
                'status_in'=>'assigning'
            ]);
        }
    }
    public function move_to_hold_shipmentRider(Driver $driver)
    {
        $dds = Driver_shipment_delivery::where(['driver_id'=>$driver->id,'type'=>'hold'])->get();
        foreach($dds as $dd){
            $shipment = Shipment::where('id',$dd->shipment_id)->first();
            $check = Hold_shipment::where(['shipment_id'=>$shipment->id,'status'=>'pending']);
            if($check->count() <1)
            {
                Hold_shipment::create([
                    'shipment_id'=>$shipment->id,'hub_id'=>$shipment->area->hub->id,
                    'admin_id'=>Auth::guard('admin')->user()->id,'status'=>'assigning'
                ]);
                Driver_hub_shipment_box::where('shipment_id',$shipment->id)->update([
                    'status_in'=>'assigning'
                ]);
            }
        }
    }


    //ajax call
    function hold_shipment_rows($type){
        $shipments = Hold_shipment::where('status','assigning')->get();
        return view('admin.shipment.hold.include.hold_shipment_rows',compact('shipments','type'));
    }
    public function move_back2hold_shipment(Shipment $shipment,$type)
    {
        Hold_shipment::where(['shipment_id'=>$shipment->id,'status'=>'assigning'])->delete();
        
        Driver_hub_shipment_box::where(['shipment_id'=>$shipment->id,'status'=>$type])->update([
                'status_in'=>null
        ]);
        
    }
    // hold Shipments into Agent dispatch or save sorting
    public function sendToSorting(){
        $holdShipments = Hold_shipment::where(['admin_id'=>Auth::guard('admin')->user()->id,'status'=>'assigning']);
        foreach($holdShipments->get() as $holdShipment){
            $bulk_id_init = Hub_shipment_box::select('id')->where('hub_id',$holdShipment->hub_id)->first();
            if($bulk_id_init==null) $bulk_id = 1; else $bulk_id = $bulk_id_init->id;

            if(Session::get('admin_hub') !=null)
            $boxByHub_id = Session::get('admin_hub')->hub_id;
            else $boxByHub_id = null;

            $box = Hub_shipment_box::create([
                'bulk_id'=>rand().$bulk_id,
                'hub_id'=>$holdShipment->hub_id,
                'shipment_ids'=>$holdShipment->shipment_id,
                'admin_id'=>Auth::guard('admin')->user()->id,
                'box_by'=>$boxByHub_id,
                'status'=>'on-delivery'
            ]);
        }
        $holdShipments->update(['status'=>'assigned']);
        return back()->with('message','Parcels are been sorted and visble at Agent dispatch at logistics');
    }



    // save shipment info at return_shipments (left to right)
    function move_to_return_shipment(Shipment $shipment,Hub $hub){
        $check = Return_shipment::where(['shipment_id'=>$shipment->id,'status'=>'assigning']);
        if($check->count() <1)
        {
            Return_shipment::create([
                'shipment_id'=>$shipment->id,
                'hub_id'=>$hub->id,
                'admin_id'=>Auth::guard('admin')->user()->id,
                'status'=>'assigning'
            ]);
            Driver_hub_shipment_box::where(['shipment_id'=>$shipment->id,'status'=>'return'])->update([
                'status_in'=>'assigning'
            ]);
        }
    }
    // save shipment info at return_shipments (left to right) with invoiceID
    function move_to_return_shipment_withInvoice($invoice_id){
        $shipment = Shipment::where('invoice_id',$invoice_id)->first();
        $check = Return_shipment::where(['shipment_id'=>$shipment->id,'status'=>'assigning']);
        if($check->count() <1)
        {
            Return_shipment::create([
                'shipment_id'=>$shipment->id,
                'hub_id'=>$shipment->area->hub->id,
                'admin_id'=>Auth::guard('admin')->user()->id,
                'status'=>'assigning'
            ]);
            Driver_hub_shipment_box::where(['shipment_id'=>$shipment->id,'status'=>'return'])->update([
                'status_in'=>'assigning'
            ]);
        }
    }
    // save shipment info at return_shipments (left to right) with driver id
    function move_to_return_shipment_withRider(Driver $driver){
        $dds = Driver_shipment_delivery::where(['driver_id'=>$driver->id,'type'=>'return'])->get();
        foreach($dds as $dd){
            $shipment = Shipment::where('id',$dd->shipment_id)->first();
            $check = Return_shipment::where(['shipment_id'=>$shipment->id,'status'=>'pending']);
            if($check->count() <1)
            {
                Return_shipment::create([
                    'shipment_id'=>$shipment->id,'hub_id'=>$shipment->area->hub->id,
                    'admin_id'=>Auth::guard('admin')->user()->id,'status'=>'assigning'
                ]);
                Driver_hub_shipment_box::where('shipment_id',$shipment->id)->update([
                    'status_in'=>'assigning'
                ]);
            }
        }
    }
    //ajax call
    function return_shipment_rows($type){
        $hub = Return_shipment::where('status','assigning')->select('hub_id')->groupBy('hub_id')->pluck('hub_id')->toArray();
        $hubs = Hub::whereIn('id',$hub)->get();
        return view('admin.shipment.hold.include.return-right',compact('type','hubs'));
    }
    function return_shipments_parcels(Hub $hub){
        $shipments = Return_shipment::where(['hub_id'=>$hub->id, 'status'=>'assigning'])->get();
        return view('admin.shipment.hold.include.return-parcels',compact('shipments'));
    }
    public function move_back2return_shipment(Return_shipment $return_shipment,$type)
    {   
        // dd($return_shipment);
        Return_shipment::where(['id'=>$return_shipment->id,'status'=>'assigning'])->delete();
        Driver_hub_shipment_box::where(['shipment_id'=>$return_shipment->shipment_id,'status'=>$type])->update([
                'status_in'=>null
        ]);
    }
    function return_sorting(Hub $hub){
        
        $return_shipments = Return_shipment::where([
            'hub_id'=>$hub->id,'status'=>'assigning'])->get();   

        foreach ($return_shipments as $key => $hubShipment) {
            // Shipment::where('id',$hubShipment->shipment_id)->update(['shipping_status'=>'3']);
            // event(new ShipmentMovement($hubShipment->shipment_id, 'admin', Auth::guard('admin')->user()->id,'admin-return-dispatch','Return-dispatch the shipment','return-dispatch'));
            $shipment_ids[] = $hubShipment->shipment_id; 
        }

        
        //get the last id of hub_shipment_boxes table
        $bulk_id_init = Return_shipment_box::where('hub_id',$hub->id)->orderBy('id','desc')->first();
        if($bulk_id_init==null) $bulk_id = 1; else $bulk_id = $bulk_id_init->id;
        
        //if action by superdamin, make box_by (hub_id) null
        // dd(Session::get('admin_hub'));
        if(Session::get('admin_hub') !=null)
            $boxByHub_id = Session::get('admin_hub')->hub_id;
        else $boxByHub_id = null;

        // $box= Return_shipment_box::select("id")->whereRaw("find_in_set($shipment->id ,shipment_ids)")->first();
       
        $pre_box = Return_shipment_box::where(['hub_id'=>$hub->id,'status'=>'dispatch']);
        // dd($pre_box->count());
        if($pre_box->count() =='0'){
            $pre_box->update([
                'shipment_ids'=>implode(',',$shipment_ids)
            ]);
            Return_shipment::where(['hub_id'=>$hub->id,'admin_id'=>Auth::guard('admin')->user()->id])->update(['status'=>'dispatch']);
            // return 'Data has been sorted into new bulkID at return-dispatch!';
        }else{ 
            $pre_box->update([
                'shipment_ids'=>$pre_box->first()->shipment_ids.','.implode(',',$shipment_ids)
            ]);
            Return_shipment::where(['hub_id'=>$hub->id,'admin_id'=>Auth::guard('admin')->user()->id])->update(['status'=>'dispatch']);
            // return 'Data has been sorted into previous bulkID at return-dispatch!';
        }

        Return_shipment_box::create([
            'bulk_id'=>rand().$bulk_id,
            'hub_id'=>$hub->id,
            'shipment_ids'=>implode(',',$shipment_ids),
            'admin_id'=>Auth::guard('admin')->user()->id,
            'box_by'=>$boxByHub_id,
        ]);

        $check = Return_shipment::where(['hub_id'=>$hub->id,'admin_id'=>Auth::guard('admin')->user()->id,'status'=>'dispatch']);
        if($check->count() <1){
            Return_shipment::where(['hub_id'=>$hub->id,'admin_id'=>Auth::guard('admin')->user()->id])->update(['status'=>'dispatch']);
        }
        return 'Data has been sorted to return-dispatch!';
    }

    function return_dispatch(){
        if(Auth::guard('admin')->user()->role_id=='1'){
            $shipment = Return_shipment_box::where('status','dispatch')
            ->orWhere('status','on-transit')
            ->select('hub_id')->groupBy('hub_id')->pluck('hub_id')->toArray();
        }else{
            // dd(Session::get('admin_hub')->hub_id);
            $hub = Hub::where('id',Session::get('admin_hub')->hub_id)->first();
            $shipment = Return_shipment_box::where(['box_by'=>$hub->id,'status'=>'dispatch'])
            ->orWhere('status','on-transit')
            ->select('hub_id')->groupBy('hub_id')->pluck('hub_id')->toArray();
        }
        $hubs = Hub::whereIn('id',$shipment)->get();

        return view('admin.shipment.hold.return-dispatch',compact('hubs'));
    }

    function dispatch_view(Hub $hub){
        return view('admin.shipment.hold.dispatch-view',compact('hub'));
    }
    function status_dispatch(Hub $hub){
        $boxes = Return_shipment_box::where(['hub_id'=>$hub->id,'status'=>'dispatch'])->get(); 
        return view('admin.shipment.hold.include.status-dispatch',compact('boxes','hub'));
    }

    function status_on_transit(Hub $hub){
        $boxes = Return_shipment_box::where(['hub_id'=>$hub->id,'status'=>'on-transit'])->get();
        return view('admin.shipment.hold.include.status-on-transit',compact('boxes','hub'));
    }

    //ajax, change status to transit
    function box_status_changes(Return_shipment_box $return_shipment_box,$status){
        $check = Return_shipment_box::where(['id'=>$return_shipment_box->id,'status'=>$status]);
        // dd($status);
        if($check->count() <1){
            $return_shipment_box->update(['status'=>$status]);
        }
        
    }

    function box_status_changes_bulk_id($bulk_id,$status){
        $check =Return_shipment_box::where(['bulk_id'=>$bulk_id,'status'=>$status])->get();
        if($check->count() ==0){
            Return_shipment_box::where('bulk_id',$bulk_id)->update(['status'=>$status]);
        }
        
    }

    function box_sorting(Hub $hub){
        $boxes = Return_shipment_box::where('hub_id',$hub->id)->get();
        foreach ($boxes as $key => $box) {
            foreach (explode(',',$box->shipment_ids) as $key => $shipment_id) {
                event(new ShipmentMovement($shipment_id, 'admin', Auth::guard('admin')->user()->id,'admin-return-transit','transit the return-shipment','return-transit'));
            }
        }
        Return_shipment_box::where(['hub_id'=>$hub->id,'status'=>'on-transit'])->update(['status'=>'transit']);

       return back();
    }

    function receive_from_hub(){
        // dd(Session::get('admin_hub')->hub_id);
        if(Session::has('admin_hub')){
            $boxes = Return_shipment_box::where(['hub_id'=>Session::get('admin_hub')->hub_id])->get(); 
        }else{
            $boxes = Return_shipment_box::orderBy('id')->get();
        }
        return view('admin.shipment.hold.receove-from-hub',compact('boxes'));
    }

    // agent dispatch center view
    function agent_dispatch(){
        return view('admin.shipment.hold.agent-dispatch');
    }

    //Return_shipment_box shipments
    function dispatch_box_view(Return_shipment_box $return_shipment_box){
        $shipments = Shipment::whereIn('id',explode(',',$return_shipment_box->shipment_ids))->get();
        return view('admin.shipment.load.dispatch.bulk-items',compact('return_shipment_box','shipments'));
    }

    function agent_dispatch_agentSide(){
        if(Session::has('admin_hub')){
            $hub = Hub::where('id',Session::get('admin_hub')->hub_id)->first();
        }else $hub = null;
        
        if($hub ==null){
            $boxes = Return_shipment_box::where(['status'=>'transit'])->get();
        }else{
            $boxes = Return_shipment_box::where(['hub_id'=>$hub->id,'status'=>'transit'])->get(); 
        }
        // dd($boxes);
        return view('admin.shipment.hold.agent.agent-side',compact('boxes'));
    }
     //ajax call
    function agentDispatch2DriverAssign(Return_shipment_box $return_shipment_box, Shipment $shipment){
        // dd($return_shipment_box);
        $check = Driver_return_shipment_box::where('shipment_id',$shipment->id);
        if($check->count() <1){
            Driver_return_shipment_box::create( [
                'return_shipment_box_id'=>$return_shipment_box->id,
                'shipment_id'=>$shipment->id,
                'admin_id'=>Auth::guard('admin')->user()->id,
                'status'=>'on-delivery','status_in'=>'assigning',
            ]);
            // event(new ShipmentMovement($shipment->id, 'admin',Auth::guard('admin')->user()->id,'assigned-driver-for-return-delivery','parcel hand over to Rider for return-delivery','assign-driver-for-return-delivery'));
        }
    }

    function agent_dispatch_driverSide(){
        if(Session::has('admin_hub')){
            $hub = Hub::where('id',Session::get('admin_hub')->hub_id)->first();
        }else $hub = null;

        if($hub ==null){
            $boxes = Return_shipment_box::where(['status'=>'transit'])->get();
        }else{
            $boxes = Return_shipment_box::where(['hub_id'=>$hub->id,'status'=>'transit'])->get(); 
        }
        $drivers = Driver::orderBy('first_name')->get();
        // dd($drivers);
        return view('admin.shipment.hold.agent.driver-side',compact('drivers','boxes'));
    }
    //ajax call
    function driverAssign2Agent_dispatch(Return_shipment_box $return_shipment_box, Shipment $shipment){
        Driver_return_shipment_box::where([
            'return_shipment_box_id'=>$return_shipment_box->id,
            'shipment_id'=>$shipment->id,
            'status_in'=>'assigning'
        ])->delete();
    }

    function agent_dispatchAssigning(Request $request){
        // dd($request->all());
        $box_ids = Driver_return_shipment_box::where([
            'admin_id'=>Auth::guard('admin')->user()->id,'status_in'=>'assigning'
        ])->select('return_shipment_box_id','shipment_id')->distinct()->get();
        Session::put('box_ids',$box_ids);
      
        $count = 0;
        foreach (Session::get('box_ids') as $key => $box) {
            $shipment = Shipment::where('id',$box->shipment_id)->first();
            // Test if string contains the word 
            if(strpos($shipment->shipping_status, "on-") !== false){
                return 'OPT not confirmed by the Rider! Please confirm OTP first from Rider!!';
            }
        }
            
        Driver_return_shipment_box::where([
            'admin_id'=>Auth::guard('admin')->user()->id,'status_in'=>'assigning'
        ])->update( [
            'driver_id'=>$request->driver_id,'status_in'=>'assigned'
        ]);

        // dd(Session::get('box_ids'));
        
        $count = 0;
        foreach (Session::get('box_ids') as $key => $box) {
            $query = Return_shipment_box::where('id',$box->return_shipment_box_id)->first();
            foreach (explode(',',$query->shipment_ids) as $shipment_id) {
               $count += Driver_return_shipment_box::where(['return_shipment_box_id'=>$box->return_shipment_box_id,'shipment_id'=>$shipment_id])->count();
            }
            if($count==COUNT(explode(',',$query->shipment_ids))){
                Return_shipment_box::where('id',$box->return_shipment_box_id)->update([
                    'status'=>'return-delivery'
                ]);
            }
            Shipment::where('id',$box->shipment_id)->update(['shipping_status'=>'9']);
        }
        Session::forget('box_ids');
        return back();
    }


    function return2return_delivery(Request $request, $type,$hub_shipmentBoxID){
        $hub_box = Driver_hub_shipment_box::where(['status'=>$type,'hub_shipment_box_id'=>$hub_shipmentBoxID])->get();
        // dd($hub_box);
        foreach($hub_box as $hb){
            event(new ShipmentMovement($hb->shipment_id, 'admin',Auth::guard('admin')->user()->id,'return-to-return-delivery','parcel return for return-delivery','return-to-return-delivery'));
            Driver_hub_shipment_box::where('id',$hb->id)->update(['status'=>'return']);
        }
    }
    

    function merchant_handover(){
        if(Session::has('admin_hub')){
            $hub = Hub::where('id',Session::get('admin_hub')->hub_id)->first();
        }else $hub = null;
        
        if($hub ==null){
            $ids = Return_shipment_box::where(['status'=>'transit'])->select('shipment_ids')
            ->groupBy('shipment_ids')->pluck('shipment_ids')->toArray();
        }else{
            $ids = Return_shipment_box::where(['status'=>'transit'])->select('shipment_ids')
            ->where('hub_id',$hub->id)
            ->groupBy('shipment_ids')
            ->pluck('shipment_ids')->toArray();
        }
        
        $shipment = Shipment::whereIn('id',explode(',',implode(',',$ids)))->select('user_id')
        ->groupBy('user_id')->pluck('user_id')->toArray();
        $user = User::whereIn('id',$shipment)->get();
        // dd($user);
        return view('admin.shipment.hold.merchant-handover',compact('user'));
    }
    
    function merchant_handover_parcels(User $user){
        return view('admin.shipment.hold.merchant-handover');
    }

    function handover2merchant(User $user){
        $shipments = Shipment::where(['user_id'=>$user->id,'shipping_status'=>'on-8'])->get();

        $count = 0;
        foreach ($shipments as $key => $shipment) {
            echo $shipment->name.'<br/>';
            $box= Return_shipment_box::orderBy('id','desc')->select("id")->where('status','transit')
            ->whereRaw("find_in_set($shipment->id ,shipment_ids)")->first();
            $box->update(['status'=>'return-delivery']);
            
            event(new ShipmentMovement($shipment->id, 'admin',Auth::guard('admin')->user()->id,'handover-to-merchant','parcel hand over to merchant','handover-to-merchant'));
            
            Shipment::where('id',$shipment->id)->update(['shipping_status'=>'10']);
        }
        return back()->with('message','Parcels are handover to merchant successfully!!');
    }

}
