<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shipment;
use App\Area;
use App\User;
use App\Hub;
use App\Hub_shipment;
use App\Hub_shipment_box;
use App\Driver_hub_shipment_box;
use App\Driver;
use App\Driver_return_shipment_box;
use App\ShippingPrice;
use App\Reconcile_shipment;
use App\Driver_shipment;
use App\Driver_shipment_delivery;
use Illuminate\Http\Request;
use Session; use Auth;use PDF;
use App\Events\ShipmentMovement;
use App\Events\SendingSMS;
use App\Shipment_delivery_payment;
use App\Thirdparty_shipment;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipment = Shipment::where('status',1)->select('user_id')->groupBy('user_id')->pluck('user_id')->toArray();
        $user = User::whereIn('id',$shipment)->get();
        return view('admin.shipment.shipment-list',compact('user'));
    }

    public function all_shipments(Request $request)
    {
        if (!$request->has('_token')) {
            $shipment = Shipment::latest();
        }else{
            $shipment = Shipment::where('zone_id',$request->zone_id)
            ->orWhere('area_id',$request->area_id)
            ->orWhere('invoice_id',$request->invoice_id)
            ->orWhere('phone',$request->phone)
            ->orWhere('shipping_status',$request->status);
        }

        $shipments = $shipment->paginate(30);
        return view('admin.shipment.all-shipments',compact('shipments'));
    }

    function shipment_detail(Shipment $shipment){
        $zone = Area::find($shipment->area_id);
        $shipping = ShippingPrice::where('zone_id', $zone->zone_id)->where('delivery_type', $shipment->delivery_type)->first();
        if ($shipping ==null) { dd('ShippingPrice missing');}

        $weight = (float)$shipment->weight;
        if ($weight > $shipping->max_weight) {
            $ExtraWeight = ($weight - $shipping->max_weight) / $shipping->per_weight;
            if ((int)$ExtraWeight < $ExtraWeight) {
                $ExtraWeight = (int)$ExtraWeight + 1;
            }
            $price = ($ExtraWeight * $shipping->price) + $shipping->max_price;
        } else {
            $price = (int)$shipping->max_price;
        }
        $total_price = $price + (int)$shipment->parcel_value;

        return view('admin.shipment.includes.shipment-view', compact('shipment','price','total_price','shipping'));
    }

    function shipment_print(Shipment $shipment){
        $zone = Area::find($shipment->area_id);
        $shipping = ShippingPrice::where('zone_id', $zone->zone_id)->where('delivery_type', $shipment->delivery_type)->first();
        if ($shipping ==null) { dd('ShippingPrice missing');}

        $weight = (float)$shipment->weight;
        if ($weight > $shipping->max_weight) {
            $ExtraWeight = ($weight - $shipping->max_weight) / $shipping->per_weight;
            if ((int)$ExtraWeight < $ExtraWeight) {
                $ExtraWeight = (int)$ExtraWeight + 1;
            }
            $price = ($ExtraWeight * $shipping->price) + $shipping->max_price;
        } else {
            $price = (int)$shipping->max_price;
        }
        $total_price = $price + (int)$shipment->parcel_value;

        return view('admin.shipment.includes.pos_printing', compact('shipment','price','total_price','shipping'));
    }


    public function shipment_received()
    {
        $date = \Carbon\Carbon::today()->subDays(7);
        $shipment = Shipment::where(['status'=>1,'shipping_status'=>2])->select('user_id')
        ->where('time_starts', '>=', $date)
        ->groupBy('user_id')->pluck('user_id')->toArray();

        $user = User::where('area_id','!=',null)->whereIn('id',$shipment)->get();
        if($user->count() ==0){
            echo '<script>alert("Merchant informatin may missing!!")</script>';
        }
        return view('admin.shipment.shipment-receive',compact('user'));
    }

    function shipment_cancelled(){
        $shipment = Shipment::where(['status'=>2])->select('user_id')->groupBy('user_id')->pluck('user_id')->toArray();
        $user = User::whereIn('id',$shipment)->get();
        return view('admin.shipment.shipment-list',compact('user'));
    }

    public function show($id,$status,$shipping_status)
    {
        $shipments = Shipment::where('user_id',$id)->where(['status'=>$status,'shipping_status'=>$shipping_status])->get();
        // dd($shipments);
        $user = User::find($id);
        $drivers = Driver::orderBy('first_name')->get();
        return view('admin.shipment.shipment-more',compact('shipments','drivers','user'));
    }

    // add a parcel under a merchant
    function add_parcel(Request $request){
        $total_price = 0;$cod_type = 0; $cod_amount = 0;

        $checkInvoice = Shipment::where('invoice_id',$request->invoice_id)->count();
        if($checkInvoice >0 && $checkInvoice !=null){
            $invoice_id = $request->invoice_id.rand(222,22);
        }else $invoice_id = $request->invoice_id;

        $data =[
            'user_id'=>$request->user_id,
            'zone_id'=>Area::where('id',$request->area)->first()->zone_id,
            'area_id'=>$request->area,
            'name'=>$request->name,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'zip_code'=>$request->zip_code,
            'parcel_value'=>$request->parcel_value,
            'invoice_id'=>$invoice_id,
            'merchant_note'=>$request->merchant_note,
            'weight'=>$request->weight,
            'delivery_type'=>$request->delivery_type,
            'tracking_code'=>rand(),
            'cod'=>$cod_type,
            'cod_amount'=>$cod_amount,
            'price'=>0,
            'total_price'=>$total_price,
            'shipping_status'=>2
        ];
        $shipment = Shipment::create($data);

        if($request->status !='0'){
            if($request->status=='1') $status = 'pending';

            if($request->status=='2') $status = 'received';
            Driver_shipment::create([
                'driver_id'=>$request->driver_id,
                'shipment_id'=>$shipment->id,
                'admin_id'=>Auth::guard('admin')->user()->id,
                'status'=>$status
            ]);
        }
        return back()->with('message','New parcel has been created successfully!!');
    }

    function save_driver_shipment($id,Request $request){
        // dd($request->all());
        if(is_numeric($request->shipment_id)){
            // dd('single');
            $check = Driver_shipment::where(['driver_id'=>$request->driver_id,'shipment_id'=>$request->shipment_id])->count();
            if($check >0){
                Session::flash('message', 'Data already exist!!'); return back();
            }
            Driver_shipment::create([
            'driver_id'=>$request->driver_id,'shipment_id'=>$request->shipment_id,
            'admin_id'=>Auth::guard('admin')->user()->id,'note'=>$request->note
           ]);
            Shipment::where('id',$request->shipment_id)->update(['shipping_status'=>1]);
        }else{
            // dd('multiple');
            foreach (explode(',', $request->shipment_id) as $key => $id) {
                if($id !='on'){
                    $check = Driver_shipment::where(['driver_id'=>$request->driver_id,'shipment_id'=>$id])->count();
                    if($check <1){
                        Driver_shipment::create([
                            'driver_id'=>$request->driver_id,'shipment_id'=>$id,
                            'admin_id'=>Auth::guard('admin')->user()->id,'note'=>$request->note
                        ]);

                        event(new ShipmentMovement($id, 'driver',$request->driver_id,'assing-driver-to-pickup','Assign rider to pickup from merchant','pickup'));
                    }
                    Shipment::where('id',$id)->update(['shipping_status'=>1]);
                }
            }

        }
        Session::flash('message', 'Shipments are handover to driver'); return back();
    }

    function cencelled_shippings($user_id){
        $shipments = Shipment::where('user_id',$user_id)->where(['status'=>2])->get();
        $user = User::find($user_id);
        $drivers = Driver::orderBy('first_name')->get();
        return view('admin.shipment.cencelled-shipments',compact('shipments','drivers','user'));

    }

    function back2shipment($id){
        Shipment::where('id',$id)->update(['status'=>'1','shipping_status'=>'0']);
        Session::flash('message', 'Shipment has been backed successfully!'); return back();
    }


    //delete a parcel
    public function destroy($id)
    {
        Shipment::where('id',$id)->delete();
        Session::flash('message', 'Shipment has been removed successfully!'); return back();
    }

    public function cencell($id,Request $request)
    {
        Shipment::where('id',$id)->update(['status'=>'2','shipping_status'=>'6']);
        Driver_shipment::where('shipment_id',$id)->update(['note'=>$request->note,'status'=>'cancelled']);
        Session::flash('message', 'Shipment has been Cencelled successfully!'); return back();
    }

    function assignToHub($id,$status,$shipping_status){
        $user = User::find($id);

        $hub = Hub_shipment::where(['user_id'=>$user->id,'status'=>'on-dispatch'])->select('hub_id')->groupBy('hub_id')->pluck('hub_id')->toArray();
        $hubs = Hub::whereIn('id',$hub)->get();

        return view('admin.shipment.assign-to-hub',compact('hubs','user','id','status','shipping_status'));
    }

    function receving_parcels($id,$status=1,$shipping_status=2){
        $date = \Carbon\Carbon::today()->subDays(7);
        $shipments = Shipment::where('user_id',$id)
        ->where(['status'=>$status,'shipping_status'=>$shipping_status])
        ->where('time_starts', '>=', $date)->get();

        $areas = Area::orderBy('name')->get();
        return view('admin.shipment.load.receiving-parcels',compact('shipments','areas','id','status','shipping_status'));
    }

    //ajax call form assign-to-hub route
    function MoveToHub(Request $request){
        // dd($request->all());
        $check = Hub_shipment::where(['shipment_id'=>$request->shipment_id,'status'=>'on-dispatch']);
        $user_id = $request->user_id;
        if($check->count()< 1 ){
            Hub_shipment::create([
                'user_id'=>$request->user_id,'shipment_id'=>$request->shipment_id, 'hub_id'=>$request->hub_id,'admin_id'=>Auth::guard('admin')->user()->id,
            ]);
        }
        Shipment::where('id',$request->shipment_id)->update( [
            'area_id'=>$request->area_id,'weight'=>$request->weight
        ]);

        $shipment = Hub_shipment::where(['user_id'=>$request->user_id,'status'=>'on-dispatch'])->select('hub_id')->groupBy('hub_id')->pluck('hub_id')->toArray();
        $hubs = Hub::whereIn('id',$shipment)->get();
        return view('admin.shipment.load.hub-shipments',compact('hubs','user_id'));
    }

    function MoveToHubWithPhone(Request $request){
        // dd($request->all());
        $shipments = Shipment::where('phone','LIKE','%'.$request->phone.'%')
        ->where('shipping_status','2')->get();
        foreach ($shipments as $key => $shipment) {
            $check = Hub_shipment::where(['shipment_id'=>$shipment->id,'status'=>'on-dispatch']);
            $user_id = $request->user_id;
            if($check->count()< 1 ){
                Hub_shipment::create([
                    'user_id'=>$shipment->user_id,
                    'shipment_id'=>$shipment->id,
                    'hub_id'=>$shipment->area->hub_id,
                    'admin_id'=>Auth::guard('admin')->user()->id,
                ]);
            }
        }

        $new_shipment = Hub_shipment::where(['user_id'=>$request->user_id,'status'=>'on-dispatch'])->select('hub_id')->groupBy('hub_id')->pluck('hub_id')->toArray();
        $hubs = Hub::whereIn('id',$new_shipment)->get();
        return view('admin.shipment.load.hub-shipments',compact('hubs','user_id'));
    }

     function MoveToHubWithInvoice(Request $request){
        $shipment = Shipment::where(['invoice_id'=>$request->invoice_id,'shipping_status'=>'2'])->first();

        $check = Hub_shipment::where(['shipment_id'=>$shipment->id,'status'=>'on-dispatch']);
        $user_id = $request->user_id;
        if($check->count()< 1 ){
            Hub_shipment::create([
                'user_id'=>$shipment->user_id,
                'shipment_id'=>$shipment->id,
                'hub_id'=>$shipment->area->hub_id,
                'admin_id'=>Auth::guard('admin')->user()->id,
            ]);
        }


        $new_shipment = Hub_shipment::where(['user_id'=>$request->user_id,'status'=>'on-dispatch'])->select('hub_id')->groupBy('hub_id')->pluck('hub_id')->toArray();
        $hubs = Hub::whereIn('id',$new_shipment)->get();
        return view('admin.shipment.load.hub-shipments',compact('hubs','user_id'));
    }

    // show hub_parcel data
    function hub_parcels(Hub $hub, $user_id,$status = 'on-dispatch'){
        $shipments = Hub_shipment::where(['hub_id'=>$hub->id,'user_id'=>$user_id,'status'=>$status])->get();
        $id = $hub->id;
        // dd($hub_id .' , '. $user_id);
        return view('admin.shipment.load.hub-parcels',compact('shipments','id'));
    }

    function hub_parcels_csv(Hub $hub, $user_id,$status = 'on-dispatch'){
        $shipment = Hub_shipment::where(['hub_id'=>$hub->id,'user_id'=>$user_id,'status'=>$status])->select('shipment_id')->groupBy('shipment_id')->pluck('shipment_id')->toArray();;
        $shipments = Shipment::whereIn('id',$shipment)->get();
        // dd($shipments);
        Shipment::where('status',1)->select('user_id')->groupBy('user_id')->pluck('user_id')->toArray();
        foreach ($shipments as $key => $shipment) {
            $rows[] =  [$shipment->invoice_id,$shipment->name,$shipment->phone,$shipment->address,$shipment->zip_code,$shipment->price,$shipment->weight,''];
        }
        $columnNames = ['Invoice', 'Customer Name', 'Contact No.','Customer Address','Post Code','Price','Weight','Product Selling Price'];
        return self::getCsv($columnNames, $rows,date('d/m/Y h i s').'.csv');
    }


    // remove an item from hub_shipment table
    function remove_hub_parcel(Hub_shipment $hub_shipment){
        // dd($hub_shipment);
        Shipment::where('id',$hub_shipment->shipment_id)->update(['shipping_status'=>'2']);
        $hub_shipment->delete();
    }

    function change_bub($area_id){
        $hub_id =  Area::find($area_id)->hub_id;
        return Hub::find($hub_id);
    }

    function hub_sorting(Hub $hub){

        $hub_shipments = Hub_shipment::where([
            'hub_id'=>$hub->id,'status'=>'on-dispatch'])->get();

        foreach ($hub_shipments as $key => $hubShipment) {
            Shipment::where('id',$hubShipment->shipment_id)->update(['shipping_status'=>'3']);

            event(new ShipmentMovement($hubShipment->shipment_id, 'admin', Auth::guard('admin')->user()->id,'admin-dispatch','Dispatch the shipment','dispatch'));

            $shipment_ids[] = $hubShipment->shipment_id;
            $message = 'Dear '.$hubShipment->shipment->name.', You have a parcel on '.basic_information()->wensote_link.' &  paracel is in Dispatch centen. We will get you soon!';
            event(new SendingSMS('customer',$hubShipment->shipment->phone ,$message));
        }

        //get the last id of hub_shipment_boxes table
        $bulk_id_init = Hub_shipment_box::where('hub_id',$hub->id)->orderBy('id','desc')->first();
        if($bulk_id_init==null) $bulk_id = 1; else $bulk_id = $bulk_id_init->id;

        //if action by superdamin, make box_by (hub_id) null
        // dd(Session::get('admin_hub'));
        if(Session::has('admin_hub') ) $boxByHub_id = Session::get('admin_hub')->hub_id;
        else $boxByHub_id = null;
        // dd($boxByHub_id);// if $boxByHub_id=null, it means, the shipment boxes by superadmin
        $checkBox = Hub_shipment_box::where('shipment_ids',implode(',',$shipment_ids))->count();
        if($checkBox < 1){
            $box = Hub_shipment_box::create([
                'bulk_id'=>rand().$bulk_id, 'hub_id'=>$hub->id,
                'shipment_ids'=>implode(',',$shipment_ids),
                'admin_id'=>Auth::guard('admin')->user()->id,
                'box_by'=>$boxByHub_id,
            ]);
        }

        $check = Hub_shipment::where(['hub_id'=>$hub->id,'admin_id'=>Auth::guard('admin')->user()->id,'status'=>'dispatch']);
        if($check->count() <1){
            Hub_shipment::where(['hub_id'=>$hub->id,'admin_id'=>Auth::guard('admin')->user()->id])->update(['status'=>'dispatch']);
        }

        // direct to sorting hub parcels into agent-dispatch
        if($hub->id== $boxByHub_id){
            $box->update(['status'=>'on-delivery']);
            foreach ($shipment_ids as $key => $shipment_id) {
                Shipment::where('id',$shipment_id)->update(['shipping_status'=>'5']);
                Hub_shipment::where('shipment_id',$shipment_id)->update(['status'=>'on-delivery']);
            }
        }

        return 'Data has been sorted to dispatch & sent SMS to customer mobile!';
    }

    function shipment_dispatch(){
        if(Auth::guard('admin')->user()->role_id=='1'){
            $shipment = Hub_shipment_box::where('status','dispatch')
            ->orWhere('status','on-transit')
            ->select('hub_id')->groupBy('hub_id')->pluck('hub_id')->toArray();
        }else{
            // dd(Session::get('admin_hub'));
            // $shipment = Hub_shipment_box::where(['box_by'=>Auth::guard('admin')->user()->hub_id,'status'=>'dispatch'])
            $shipment = Hub_shipment_box::where(['box_by'=>Session::get('admin_hub')->hub_id,'status'=>'dispatch'])
            ->orWhere('status','on-transit')
            ->select('hub_id')->groupBy('hub_id')->pluck('hub_id')->toArray();
        }
        $hubs = Hub::whereIn('id',$shipment)->get();

        return view('admin.shipment.shipment-dispatch',compact('hubs'));
    }

    function dispatch_view(Hub $hub){
        return view('admin.shipment.dispatch-view',compact('hub'));
    }

    //Hub_shipment_box shipments
    function dispatch_box_view(Hub_shipment_box $hub_shipment_box){
        $shipments = Shipment::whereIn('id',explode(',',$hub_shipment_box->shipment_ids))->get();
        return view('admin.shipment.load.dispatch.bulk-items',compact('hub_shipment_box','shipments'));
    }

    function status_dispatch(Hub $hub){
        $boxes = Hub_shipment_box::where(['hub_id'=>$hub->id,'status'=>'dispatch'])->get();
        return view('admin.shipment.load.dispatch.status-dispatch',compact('boxes','hub'));
    }

    function status_on_transit(Hub $hub){
        $boxes = Hub_shipment_box::where(['hub_id'=>$hub->id,'status'=>'on-transit'])->get();
        return view('admin.shipment.load.dispatch.status-on-transit',compact('boxes','hub'));
    }

    //ajax, change status to transit
    function box_status_changes(Hub_shipment_box $hub_shipment_box,$status){
        $check = Hub_shipment_box::where(['id'=>$hub_shipment_box->id,'status'=>$status]);
        if($check->count() <1){
            $hub_shipment_box->update(['status'=>$status]);
        }

    }

    function box_status_changes_bulk_id($bulk_id,$status){
        $check = Hub_shipment_box::where(['bulk_id'=>$bulk_id,'status'=>$status])->get();
        if($check->count() ==0){
            Hub_shipment_box::where('bulk_id',$bulk_id)->update(['status'=>$status]);
        }

    }

    function box_sorting(Hub $hub){
        $boxes = Hub_shipment_box::where('hub_id',$hub->id)->get();
        // dd($boxes);
        foreach ($boxes as $key => $box) {
            foreach (explode(',',$box->shipment_ids) as $key => $shipment_id) {
                Shipment::where('id',$shipment_id)->update(['shipping_status'=>'4']);
                if($hub->zone->status=='1' && $hub->status=='1'){
                    \App\Thirdparty_shipment::create([
                        'shipment_id'=>$shipment_id,'hub_id'=>$hub->id,
                        'admin_id'=>Auth::guard('admin')->user()->id,'status'=>'transit'
                    ]);
                    event(new ShipmentMovement($shipment_id, 'admin', Auth::guard('admin')->user()->id,'third-party','transit the shipment to a third party','transit'));
                }else{
                    event(new ShipmentMovement($shipment_id, 'admin', Auth::guard('admin')->user()->id,'admin-transit','transit the shipment','transit'));
                }
                $shipment_ids[] = $shipment_id;
            }
        }
        if($hub->zone->status=='1' && $hub->status=='1'){
            $status = 'third-party';
        }else $status = 'transit';

        Hub_shipment_box::where(['hub_id'=>$hub->id,'status'=>'on-transit'])->update(['status'=>$status]);

        $pdf = PDF::loadView('admin.shipment.shipment-pdf', compact('shipment_ids','hub'));
        return $pdf->download(' parcels for-'.$hub->name.' - '.date('y-m-d h:i:s').'.pdf');
    }


    function hub_receivable(){
        if(Session::has('admin_sub')){
            $hub = Hub::where('id',Session::get('admin_hub')->hub_id)->first();
        }else $hub=null;

        if($hub ==null){
            $boxes = Hub_shipment_box::where(['status'=>'transit'])->get();
            $title = 'Hub receivable for admin';
        }else{
            $boxes = Hub_shipment_box::where(['hub_id'=>$hub->id,'status'=>'transit'])->get();
            $title = 'Hub receivable for employee | '.Session::get('admin_hub')->name;
        }
        return view('admin.shipment.hub-receivable',compact('boxes','title'));
    }

    function box_back2Dispatch(Hub_shipment_box $hub_shipment_box){
        foreach (explode(',',$hub_shipment_box->shipment_ids) as $key => $shipment_id) {
            Shipment::where('id',$shipment_id)->update(['shipping_status'=>'3']);
            event(new ShipmentMovement($shipment_id, 'admin',Auth::guard('admin')->user()->id,'receive-at-hub','Hub receivable cancelled','back-to-dispatch'));
        }
       $hub_shipment_box->update(['status'=>'dispatch']);
    }
    //ajax call for sorting, from hub-receivable to on-delivery
    function sort2agentDispatch(Hub_shipment_box $hub_shipment_box){
        $hub_shipment_box->update(['status'=>'on-delivery']);
        foreach (explode(',',$hub_shipment_box->shipment_ids) as $key => $shipment_id) {
            Shipment::where('id',$shipment_id)->update(['shipping_status'=>'5']);
            event(new ShipmentMovement($shipment_id, 'admin',Auth::guard('admin')->user()->id,'sort-to-agnet-dispatch','Hub receivable','out-for-delivery'));
        }
    }

    // agent dispatch center view
    function agent_dispatch(){
        return view('admin.shipment.agent-dispatch');
    }

    function agent_dispatch_agentSide(){
        if(Session::has('admin_sub')){
            $hub = Hub::where('id',Session::get('admin_hub')->hub_id)->first();
        }else $hub=null;

        if($hub ==null){
            $boxes = Hub_shipment_box::where(['status'=>'on-delivery'])->get();
        }else{
            $boxes = Hub_shipment_box::where(['hub_id'=>$hub->id,'status'=>'on-delivery'])->get();
        }
        return view('admin.shipment.load.agent-dispatch.agent-side',compact('boxes'));
    }

    function agent_dispatch_driverSide(){
        if(Session::has('admin_sub')){
            $hub = Hub::where('id',Session::get('admin_hub')->hub_id)->first();
        }else $hub=null;
        if($hub ==null){
            $boxes = Hub_shipment_box::where(['status'=>'on-delivery'])->get();
        }else{
            $boxes = Hub_shipment_box::where(['hub_id'=>$hub->id,'status'=>'on-delivery'])->get();
        }
        $drivers = Driver::orderBy('first_name')->get();
        return view('admin.shipment.load.agent-dispatch.driver-side',compact('drivers','boxes'));
    }
    //ajax call
    function agentDispatch2DriverAssign(Hub_shipment_box $hub_shipment_box, Shipment $shipment){
        Driver_hub_shipment_box::create( [
            'hub_shipment_box_id'=>$hub_shipment_box->id,
            'shipment_id'=>$shipment->id,
            'admin_id'=>Auth::guard('admin')->user()->id,
            'status'=>'assigning'
        ]);

        event(new ShipmentMovement($shipment->id, 'admin',Auth::guard('admin')->user()->id,'assigned-driver-for-delivery','parcel hand over to Rider','assign-driver-for-delivery'));
    }
    //ajax call /get right side of dispatch agent with invoice id
    function agentDispatch2DriverAssignWithInvoice($invoice_id){
        $shipment = Shipment::where('invoice_id',$invoice_id)->first();
        $box= Hub_shipment_box::select("id")->whereRaw("find_in_set($shipment->id ,shipment_ids)")->first();
        // dd($box->id);
        Driver_hub_shipment_box::create( [
            'hub_shipment_box_id'=>$box->id,
            'shipment_id'=>$shipment->id,
            'admin_id'=>Auth::guard('admin')->user()->id,
            'status'=>'assigning'
        ]);

        event(new ShipmentMovement($shipment->id, 'admin',Auth::guard('admin')->user()->id,'assigned-driver-for-delivery','parcel hand over to Rider','assign-driver-for-delivery'));
    }

    //ajax call
    function driverAssign2Agent_dispatch(Hub_shipment_box $hub_shipment_box, Shipment $shipment){
        Driver_hub_shipment_box::where([
            'hub_shipment_box_id'=>$hub_shipment_box->id,
            'shipment_id'=>$shipment->id,
            'status'=>'assigning'
        ])->delete();
    }

    function agent_dispatchAssigning(Request $request){

        $box_ids = Driver_hub_shipment_box::where([
            'admin_id'=>Auth::guard('admin')->user()->id,'status'=>'assigning'
        ])->select('hub_shipment_box_id')->distinct()->get();
        Session::put('box_ids',$box_ids);

        Driver_hub_shipment_box::where([
            'admin_id'=>Auth::guard('admin')->user()->id,'status'=>'assigning'
        ])->update( [
            'driver_id'=>$request->driver_id,'status'=>'assigned'
        ]);

        $count = 0;
        foreach (Session::get('box_ids') as $key => $box) {
            $query = Hub_shipment_box::where('id',$box->hub_shipment_box_id)->first();
            foreach (explode(',',$query->shipment_ids) as $key => $shipment_id) {
               $count += Driver_hub_shipment_box::where(['hub_shipment_box_id'=>$box->hub_shipment_box_id,'shipment_id'=>$shipment_id])->count();
            }
            if($count==COUNT(explode(',',$query->shipment_ids))){
                Hub_shipment_box::where('id',$box->hub_shipment_box_id)->update([
                    'status'=>'delivery'
                ]);
            }
        }
        Session::forget('box_ids');

        $driver_hub_shipmentBox = Driver_hub_shipment_box::where([
            'admin_id'=>Auth::guard('admin')->user()->id,
            'driver_id'=>$request->driver_id,
            'status'=>'assigned'
        ])->get();

        $driver = Driver::find($request->driver_id)->first();

        foreach($driver_hub_shipmentBox as $row){
            $customer_message = 'Dear '.$row->shipment->name.', Your parcel on '.basic_information()->website_link.' is on delivery. '.$driver->first_name.' '.$driver->last_name.' ('.$driver->phone.') will carry your parcel.';
            event(new SendingSMS('customer',$row->shipment->phone ,$customer_message));
            $merchant_message = 'Dear '.$row->shipment->user->first_name.', Your parcel #'.$row->shipment->invoice_id.' is on delivery. '.$driver->first_name.' '.$driver->last_name.' ('.$driver->phone.') is responsible to delivery the parcel!';
            event(new SendingSMS('merchant',$row->shipment->user->phone ,$merchant_message));
        }


        return back();
    }


    function reconcile(){
        $date = \Carbon\Carbon::today()->subDays(7);
        $shipments = Shipment::where(['status'=>1,'shipping_status'=>2])
        ->where('time_starts', '<=', $date)->paginate(30);

        $reconciles = Reconcile_shipment::where('status','pending')->get();
        return view('admin.shipment.reconcile',compact('shipments','reconciles'));
    }
    function load_shipment_reconcilable(){
        $date = \Carbon\Carbon::today()->subDays(7);
        $shipments = Shipment::where(['status'=>1,'shipping_status'=>2])
        ->where('time_starts', '<=', $date)->paginate(30);
        return view('admin.shipment.load.reconcile.shipment-side',compact('shipments'));
    }
    function load_reconcil_shipments(){
        $reconciles = Reconcile_shipment::where('status','pending')->get();
        return view('admin.shipment.load.reconcile.reconcile-side',compact('reconciles'));
    }
    function create_reconcile(Shipment $shipment){
        $check = Reconcile_shipment::where(['shipment_id'=>$shipment->id,'status'=>'pending']);
        if($check->count() <1){
            Reconcile_shipment::create([
                'shipment_id'=>$shipment->id,
                'admin_id'=>Auth::guard('admin')->user()->id,
                'status'=>'pending' ]);
        }else{
            Reconcile_shipment::where('shipment_id',$shipment->id)
            ->update(['status'=>'pending']);
        }
    }
    function remove_reconcile(Shipment $shipment){
        $check = Reconcile_shipment::where(['shipment_id'=>$shipment->id])->delete();
    }
    function return_shipments2receive(){
        $records = Reconcile_shipment::where(['admin_id'=>Auth::guard('admin')->user()->id,'status'=>'pending'])->get();
        foreach ($records as $key => $record) {
            Reconcile_shipment::where('id',$record->id)
            ->update(['status'=>'moved-to-receive','loops'=>$record->loops+1]);
            Shipment::where('id',$record->shipment_id)->update([
                'time_starts'=> date("Y-m-d H:i:s")
            ]);
        }
        return back()->with('message','Shipments return to Receive for 7 days!');
    }

    function delivery(Request $request){
        $shipments = Shipment::get();
        if($request->area_id){
            $shipments = $shipments->where('area_id',$request->area_id);
        }

        if($request->phone){
            $shipments = $shipments->where('phone',$request->phone);
        }

        if($request->hub_id){
            $shipment = Hub_shipment::where('hub_id',$request->hub_id)->select('shipment_id')->groupBy('shipment_id')->pluck('shipment_id')->toArray();
            $shipments = $shipments->where('id',$shipment);
        }

        if($request->merchant_id){
            $shipments = $shipments->where('user_id',$request->merchant_id);
        }

        if($request->driver_id){
            $driver_shipment = Driver_shipment::where('driver_id',$request->driver_id)->select('shipment_id')->groupBy('shipment_id')->pluck('shipment_id')->toArray();
            $shipments = $shipments->where('id',$driver_shipment);
        }

        if($request->invoice_id){
            $shipments =  $shipments->whereIn('invoice_id',explode(',',$request->invoice_id));
        }

        if($request->status){
            $shipments =  $shipments->where('shipping_status',$request->status);
        }


        if($request->date1 && $request->date2){
            $date1= date('Y-m-d',strtotime($request->date1));
            $date2= date('Y-m-d',strtotime($request->date2));
            $shipments =  $shipments->whereBetween('created_at',[$date1." 00:00:00", $date2." 23:59:59"]);
        }

        // if(!$request->area_id && !$request->phone && !$request->hub_id && !$request->merchant_id && !$request->driver_id && !$request->invoice_id && !$request->status){
        //     $shipments =  $shipments->latest()->paginate(30);
        // }

        $users = User::where('status','!=','0')->get();
        $hubs = Hub::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();

        return view('admin.shipment.delivery',compact('hubs','users','areas','shipments'));
    }

    function shipment_search($field,$keyword){
        $shipments = Shipment::where($field,$keyword)->get();
        return view('admin.shipment.includes.delivery-parcels',compact('shipments'));
    }

    function driver_shipment_search(Driver $driver){
        $driver_shipment = Driver_shipment::where('driver_id',$driver->id)->select('shipment_id')->groupBy('shipment_id')->pluck('shipment_id')->toArray();
        $shipments = Shipment::whereIn('id',$driver_shipment)->get();
        return view('admin.shipment.includes.delivery-parcels',compact('shipments'));
    }

    function shipment_search_invoices($keyword){
        $keywords = explode(',',$keyword);
        $shipments = Shipment::whereIn('invoice_id',$keywords)->get();
        // dd($keywords); exit;
        return view('admin.shipment.includes.delivery-parcels',compact('shipments'));
    }
    function shipment_search_withHub(Hub $hub){
        $shipment = Hub_shipment::where('hub_id',$hub->id)->select('shipment_id')->groupBy('shipment_id')->pluck('shipment_id')->toArray();
        // dd($shipment);
        $shipments = Shipment::whereIn('id',$shipment)->get();
        return view('admin.shipment.includes.delivery-parcels',compact('shipments'));
    }

    function shipment_search_withStatus($status){
        $shipments = Shipment::where('shipping_status',$status)->get();
        return view('admin.shipment.includes.delivery-parcels',compact('shipments'));
    }

    function shipment_search_withDates(Request $request, $date1, $date2){
        $date1= date('Y-m-d',strtotime($date1));
        $date2= date('Y-m-d',strtotime($date2));
        // echo $date1.' = '.$date2.'<br/>';

        // dd($request->all());
        $driver_shipment = array();
        if($request->driver_id !=null){
            $driver_shipment = Driver_shipment::where('driver_id',$request->driver_id)
            ->whereBetween('created_at',[$date1." 00:00:00", $date2." 23:59:59"])
            ->select('shipment_id')->groupBy('shipment_id')->pluck('shipment_id')->toArray();
            // $shipments = Shipment::whereRaw(
            //     "(created_at >= ? AND created_at <= ?)", [$date1." 00:00:00", $date2." 23:59:59"]
            //   )->whereIn('id',$driver_shipment)->get();
            // dd('driver');
            $shipments = Shipment::where('id',$driver_shipment)
            ->whereBetween('created_at',[$date1." 00:00:00", $date2." 23:59:59"])
            ->orWhere('user_id',$request->merchant_id)
            ->orWhere('phone',$request->phone)
            ->orWhere('shipping_status',$request->status)
            ->orWhereIn('invoice_id',explode(',',$request->invoice_id))
            ->get();

            return view('admin.shipment.includes.delivery-parcels',compact('shipments'));
        }

        if($request->hub_id !=null){
            $shipment = Hub_shipment::where('hub_id',$request->hub_id)
            ->whereBetween('created_at',[$date1." 00:00:00", $date2." 23:59:59"])
            ->select('shipment_id')->groupBy('shipment_id')->pluck('shipment_id')->toArray();
            // $shipments = Shipment::whereIn('id',$shipment)
            // ->whereRaw("(created_at >= ? AND created_at <= ?)", [$date1." 00:00:00", $date2." 23:59:59"])->get();

            $shipments = Shipment::whereIn('id',$shipment)
            ->whereBetween('created_at',[$date1." 00:00:00", $date2." 23:59:59"])
            ->orWhere('area_id',$request->area_id)
            ->orWhere('user_id',$request->merchant_id)
            ->orWhere('phone',$request->phone)
            ->orWhere('shipping_status',$request->status)
            ->orWhereIn('invoice_id',explode(',',$request->invoice_id))

            // ->whereRaw( "(created_at >= ? AND created_at <= ?)", [$date1." 00:00:00", $date2." 23:59:59"])
            ->get();
            return view('admin.shipment.includes.delivery-parcels',compact('shipments'));
        }

        if($request->phone==null && $request->merchant_id==null && $request->driver_id==null &&$request->status==null && $request->area_id==null && $request->hub_id==null && $request->agent ==null && $request->invoice_id==null){

            $shipments = Shipment::whereBetween('created_at',[$date1." 00:00:00", $date2." 23:59:59"])->get();
            return view('admin.shipment.includes.delivery-parcels',compact('shipments'));
        }

        $shipments = Shipment::whereBetween('created_at',[$date1." 00:00:00", $date2." 23:59:59"])
        ->orWhere('area_id',$request->area_id)
        ->orWhere('user_id',$request->merchant_id)
        ->orWhere('phone',$request->phone)
        ->orWhere('shipping_status',$request->status)
        ->orWhereIn('invoice_id',explode(',',$request->invoice_id))
        // ->whereRaw( "(created_at >= ? AND created_at <= ?)", [$date1." 00:00:00", $date2." 23:59:59"])
        ->get();
        return view('admin.shipment.includes.delivery-parcels',compact('shipments'));

        // dd($request->all());

        // $shipments = Shipment::whereBetween('created_at',$date1,$date2)->get();
        // return view('admin.shipment.includes.delivery-parcels',compact('shipments'));
    }

    function export_shipments($shipment_ids){
        foreach (explode(',',$shipment_ids) as $key => $id) {
            $shipment = Shipment::find($id);
            $rows[] =  [$shipment->invoice_id,$shipment->name,$shipment->phone,$shipment->address,$shipment->zip_code,$shipment->price,$shipment->weight,''];
        }
        $columnNames = ['Invoice', 'Customer Name', 'Contact No.','Customer Address','Post Code','Price','Weight','Product Selling Price'];
        return self::getCsv($columnNames, $rows, date('d-m-Y - ').COUNT(explode(',',$shipment_ids)).'-parcels.csv');
    }

    function deliveryPaymentsForMerchant($shipment_ids){
        $shipments = Shipment::whereIn('id',explode(',',$shipment_ids))->get();
        return view('admin.shipment.load.delivery.payment-delivery-form',compact('shipments'));
    }

    function save_delivery_payment(Request $request){
        foreach($request->shipment_ids as $key=>$shipment_id){
            $count = \App\Shipment_delivery_payment::where('shipment_id',$shipment_id)->count();
            $data =[
                'shipment_id'=>$shipment_id,
                'admin_id'=>Auth::guard('admin')->user()->id,'amount'=>$request->amount[$key],
            ];
            if($count <1){
                \App\Shipment_delivery_payment::create($data);
            }
        }
        return back()->with('message','Shipment Payment for delivery is successfully saved!');
    }


    function shipment_audit(Shipment $shipment){
        // $driverAssign = \App\Shipment_movement::where(['shipment_id'=>$shipment->id,'status'=>'pickup','user_type'=>'driver'])->first();
        // $driverReceive = \App\Shipment_movement::where(['shipment_id'=>$shipment->id,'status'=>'receive','user_type'=>'driver'])->first();
        // $dispatch = \App\Shipment_movement::where(['shipment_id'=>$shipment->id,'status'=>'dispatch'])->first();
        // $transit = \App\Shipment_movement::where(['shipment_id'=>$shipment->id,'status'=>'transit'])->first();
        // $outForDelivery = \App\Shipment_movement::where(['shipment_id'=>$shipment->id,'status'=>'out-for-delivery'])->first();
        // $assignDriver = \App\Shipment_movement::where(['shipment_id'=>$shipment->id,'status'=>'assign-driver-for-delivery'])->first();
        // $deliverReport = \App\Shipment_movement::where(['shipment_id'=>$shipment->id,'user_type'=>'driver','report_type'=>'delivery-report'])->first();
        $audit_logs = \App\Shipment_movement::where('shipment_id',$shipment->id)->get();


        return view('admin.shipment.load.delivery.audit',compact('shipment','audit_logs'));
    }

    function download(){
        return view('admin.shipment.download');
    }
    function shipment_search_withBulkID($bulk_id){
        $shipment = Hub_shipment_box::where('bulk_id',$bulk_id)->select('shipment_ids')->first();
        if($shipment==null){
            dd('The bulk ID does not belongs To any shipments!!');
        }
        $shipments = Shipment::whereIn('id',explode(',',$shipment->shipment_ids))->get();
        return view('admin.shipment.load.download.shipments',compact('shipments'));
    }

    function download_file($type,$bulk_id){
        $shipment = Hub_shipment_box::where('bulk_id',$bulk_id)->select('shipment_ids')->first();
        if($shipment==null){
            dd('The bulk ID does not belongs To any shipments!!');
        }

        $shipments = Shipment::whereIn('id',explode(',',$shipment->shipment_ids))->get();

        if($type=='csv'){
            foreach ($shipments as $key => $shipment) {
                $rows[] =  [$shipment->invoice_id,$shipment->name,$shipment->phone,$shipment->address,$shipment->zip_code,$shipment->price,'',''];
            }
            $columnNames = ['Invoice', 'Customer Name', 'Contact No.','Customer Address','Post Code','Price','Instruction','Product Selling Price'];
            return self::getCsv($columnNames, $rows,$bulk_id.'.csv');
        }else{
            return view('admin.shipment.load.download.shipment-pdf',compact('shipments','bulk_id'));
            $pdf = \PDF::loadView('admin.shipment.load.download.shipment-pdf', compact('shipments','bulk_id'));
            return $pdf->download('Bulk-ID-'.$bulk_id.'.pdf');
        }
    }

    public static function getCsv($columnNames, $rows, $fileName = 'shipment-csv.csv') {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $fileName,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        $callback = function() use ($columnNames, $rows ) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columnNames);
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    function reset_shipment(Request $request){

        if($request->label=='0'){
            Driver_shipment::where('shipment_id',$request->id)->delete();
            \App\Shipment_movement::where('shipment_id',$request->id)->delete();
        }
        elseif($request->label=='1'){
            Driver_shipment::where('shipment_id',$request->id)
                ->where('status','!=','pending')
                ->where('status','!=','received')->delete();
            \App\Shipment_movement::where('shipment_id',$request->id)
                ->where('report_type','!=','assing-driver-to-pickup')->delete();
        }else{
            Driver_shipment::where('shipment_id',$request->id)
                ->where('status','!=','received')->delete();
            \App\Shipment_movement::where('shipment_id',$request->id)
                ->where('report_type','!=','receive-parcels')
                ->where('report_type','!=','assing-driver-to-pickup')->delete();
        }

        // hold_shipments
        \App\Hold_shipment::where('shipment_id',$request->id)->delete();

        // hub_shipments
        // dd($request->id);
        Hub_shipment::where('shipment_id',$request->id)->delete();

        // driver_hub_shipment_box
        Driver_hub_shipment_box::where('shipment_id',$request->id)->delete();

        $box= Hub_shipment_box::select("id",'shipment_ids')->whereRaw("find_in_set($request->id ,shipment_ids)")->first();
        if($box !=null){
            $new_ids = explode(',',$box->shipment_ids);
            $pos = array_search($request->id,$new_ids);
            unset($new_ids[$pos]);
            // dd('count: '.count(explode(',',$box->shipment_ids)));
            if(count(explode(',',$box->shipment_ids))==1){
                Hub_shipment_box::where('id',$box->id)->delete();
            }else{
                $box->update(['shipment_ids'=>implode(',',$new_ids)]);
            }
        }

        // driver_return_shipment_box
        Driver_return_shipment_box::where('shipment_id',$request->id)->delete();

        $return_box= \App\Return_shipment_box::select("id",'shipment_ids')->whereRaw("find_in_set($request->id ,shipment_ids)")->first();
        if($return_box !=null){
            $return_new_ids = explode(',',$return_box->shipment_ids);
            $pos = array_search($request->id,$new_ids);
            unset($return_new_ids[$pos]);
            if(count(explode(',',$return_box->shipment_ids))==1){
                \App\Return_shipment_box::where('id',$return_box->id)->delete();
            }else{
                \App\Return_shipment_box::whereRaw("find_in_set($request->id ,shipment_ids)")
                ->update(['shipment_ids'=>implode(',',$return_new_ids)]);
            }
        }

        // driver_shipment_delivery
        Driver_shipment_delivery::where('shipment_id',$request->id)->delete();

        Reconcile_shipment::where('shipment_id',$request->id)->delete();

        \App\Return_shipment::where('shipment_id',$request->id)->delete();

        Shipment_delivery_payment::where('shipment_id',$request->id)->delete();

        // shipment_opt_confirmations
        \App\Shipmnet_OTP_confirmation::where('shipment_id',$request->id)->delete();

        // thirdparty_shipments
        Thirdparty_shipment::where('shipment_id',$request->id)->delete();

        Shipment::where('id',$request->id)->update(['shipping_status'=>$request->label]);
        return back()->with('message','The Shipment has been reset successfully!!');
    }


    public function get_csv_pdf($type){

        if($type=='pdf'){
            $shipment_ids = Thirdparty_shipment::where('status_in','assigning')->get();
            // return view('admin.shipment.thirdparty.shipment-pdf',compact('shipment_ids'));
            $pdf = PDF::loadView('admin.shipment.thirdparty.shipment-pdf', compact('shipment_ids'));
            return $pdf->download('parcels for-'.$shipment_ids->count().' - '.date('y-m-d h:i:s').'.pdf');
        }
        if($type=='csv'){
            $shipment = Thirdparty_shipment::where('status_in','assigning')->select('shipment_id')->groupBy('shipment_id')->pluck('shipment_id')->toArray();
            $shipments = Shipment::whereIn('id',$shipment)->get();

            // dd($shipments);
            foreach ($shipments as $key => $shipment) {
                $rows[] =  [$shipment->invoice_id,$shipment->name,$shipment->phone,$shipment->address,$shipment->zip_code,$shipment->price,$shipment->weight,''];
            }
            $columnNames = ['Invoice', 'Customer Name', 'Contact No.','Customer Address','Post Code','Price','Weight','Product Selling Price'];

            return self::getCsv($columnNames, $rows,date('d/m/Y h i s').'.csv');
        }

    }

    function get_hub_csv($id,$status=1,$shipping_status=2){
        $date = \Carbon\Carbon::today()->subDays(7);
        $shipments = Shipment::where('user_id',$id)
        ->where(['status'=>$status,'shipping_status'=>$shipping_status])
        ->where('time_starts', '>=', $date)->get();

        foreach ($shipments as $key => $shipment) {
            $rows[] =  [$shipment->invoice_id,$shipment->name,$shipment->phone,$shipment->address,$shipment->zip_code,$shipment->price,$shipment->weight,''];
        }
        $columnNames = ['Invoice', 'Customer Name', 'Contact No.','Customer Address','Post Code','Price','Weight','Product Selling Price'];
        return self::getCsv($columnNames, $rows,date('d/m/Y h i s').'.csv');

    }

}
