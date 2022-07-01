<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shipment;
use App\User;
use App\Driver_shipment; 
use App\Driver_hub_shipment_box;  
use App\Driver_return_shipment_box;
use App\Driver_shipment_delivery;
use App\Shipmnet_OTP_confirmation;
use Auth;
use App\Events\ShipmentMovement;
use App\Events\SendingSMS;
use Session;
class ShipmentController extends Controller
{

    public function index(){
        $shipment = Shipment::where('status',1)->select('user_id')->groupBy('user_id')->pluck('user_id')->toArray();
        $user = User::whereIn('id',$shipment)->get();
        return view('driver.shipment.index',compact('user'));
    }


    public function cencel_parcel($id, Request $request)
    {
        Driver_shipment::where('shipment_id',$id)->update(['note'=>$request->note,'status'=>'cancelled']);
        Shipment::where('id',$id)->update(['shipping_status'=>6]);
        // dd($id);
        return back();
    }
    // accept a paracel assigned from admin
    public function receive_parcel($id, Request $request)
    {
        $shipment = Shipment::find($id);
        // dd($shipment);
        Driver_shipment::where(['driver_id'=>Auth::guard('driver')->user()->id,'shipment_id'=>$id])->update(['status'=>'received']);
        // $shipments_id = Driver_shipment::where('id',$id)->pluck('shipment_id')->first();
        Shipment::where('id',$id)->update(['shipping_status'=>2]);
       
        $message = 'Dear '.$shipment->name.', We '.basic_information()->company_name.' has received your parcel & we at your hand soon. Price of parcel delivery is: '.$shipment->total_price;
        event(new SendingSMS('customer',$shipment->phone ,$message));
            
        return back();
    }

    public function my_shipments($type)
    {
        if($type='return'){
            $shipments = Driver_hub_shipment_box::latest()->where(['driver_id'=>Auth::guard('driver')->user()->id,'status'=>$type])->get();
        }
        
        return view('driver.shipment.my-shipments',compact('shipments','type'));
    }

    function my_parcels($type){
        $shipments = Driver_shipment::latest()->where(['driver_id'=>Auth::guard('driver')->user()->id,'status'=>$type])->get();
        return view('driver.shipment.my-parcels',compact('shipments','type'));
    }

    public function show($id,$status)
    {
       // $shipments = Shipment::where('user_id',$id)->where(['status'=>1,'shipping_status'=>1])->get();
        $shipments = Driver_shipment::where(['driver_id'=>Auth::guard('driver')->user()->id,'status'=>$status])->get();
        // dd($status);
        $user = User::find($id);
        return view('driver.shipment.shipment-more',compact('shipments','user'));
    }

    function receive_all_parcel(User $user){
        // dd($user);
        $shipments = Shipment::where('user_id',$user->id)->get();
        foreach ($shipments as $key => $shipment) {
            $check = Driver_shipment::where(['shipment_id'=>$shipment->id,'status'=>'received'])->get();
            if ($check->count() ==0) {
                Driver_shipment::where(['driver_id'=>Auth::guard('driver')->user()->id,'shipment_id'=>$shipment->id])->update(['status'=>'received']);
                Shipment::where('id',$shipment->id)->update(['shipping_status'=>2]);
                event(new ShipmentMovement($shipment->id, 'driver', Auth::guard('driver')->user()->id,'receive-parcels','Receive parcels for pickup','receive'));

                $message = 'Dear '.$shipment->name.', We '.basic_information()->company_name.' has received your parcel & we at your hand soon. Price of parcel delivery is: '.$shipment->total_price;
                event(new SendingSMS('customer',$shipment->phone ,$message));
            }
            // echo $shipment->id.' = '.$check->count().'<br/>';
        }
        // dd($user);
        return back();
    }

    public function agent_dispatch()
    {
        // show paracels date-wize
        // $boxes = Driver_hub_shipment_box::where('driver_id',Auth::guard('driver')->user()->id)
        // ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as date_count'))
        // ->groupBy('date')->get();

        $paracels = Driver_hub_shipment_box::where([
            'driver_id'=>Auth::guard('driver')->user()->id,
            'status'=>'assigned'
        ])->get();
        return view('driver.shipment.agent-dispatch',compact('paracels'));
    }

    //get more
    function shipment_info(Shipment $shipment){ 
        return view('driver.shipment.includes.shipment-info',compact('shipment'));
    }

    function delivery_report(Request $request){
        if($request->status=='partial' && $request->price==''){
            dd('Please set customer given price field');
        }
        $shipment_id = Driver_hub_shipment_box::where('id',$request->id)->pluck('shipment_id')->first();
        Session::put('shipment_id',$shipment_id);
    
        if($request->status=='delivered') $number = 'on-6';
        if($request->status=='partial') $number = 'on-6.5';
        elseif($request->status=='hold') $number = '7';
        elseif($request->status=='return') $number = 'on-8';
        else $number ='9';

        Shipment::where('id',Session::get('shipment_id') )->update(['shipping_status'=>$number]);

        if($request->status=='partial' && $request->price!=''){
            Shipment::where('id',Session::get('shipment_id') )->update(['price'=>$request->price]);
        }
  
        Driver_shipment_delivery::create([
            'driver_id'=>Auth::guard('driver')->user()->id,'shipment_id'=>Session::get('shipment_id'),
            'type'=>$request->status
        ]);

        event(new ShipmentMovement(Session::get('shipment_id'), 'driver', Auth::guard('driver')->user()->id,'delivery-report','Delivery Report for the shipment',$request->status));
        echo '<p class="alert alert-success">Your report has been successfully submited</p>';
          
    
        if($request->price=='0'){
            $this->send_otp(Session::get('shipment_id') ,$request->status,$request->otp);
        }

        if($request->status !='hold' && $request->status!='delivered'){
            $this->send_otp(Session::get('shipment_id') ,$request->status,$request->otp);
        }

     
        Driver_hub_shipment_box::where('id',$request->id)->update([
            'status'=>$request->status,'driver_note'=>$request->driver_note,
        ]);
        // dd($shipment_id);
        return back()->with('message','Your report has been successfully submited!');
    }

    private function send_otp($shipment_id,$status,$otp){
        if($status=='return'){
            // send sms to customer 
            $shipment = Shipment::find($shipment_id);
            $message = 'Dear '.$shipment->name.', You got an TOP for verifying your parcel on '.basic_information()->wensote_link.' is #'.rand(999,88888).'. Please save the code till your parcels on your hand!';
            event(new SendingSMS('customer',$shipment->phone ,$message));
            
            // send sms to merchant 
            $shipment = Shipment::find($shipment_id);
            $message = 'Dear '.$shipment->user->first_name.', You got an TOP for verifying parcel delivery for the item #'.$shipment->invoice_id.'.  Your OTP is: '.rand(999,88888).'. Please save the code till your parcels on your hand!';
            event(new SendingSMS('customer',$shipment->phone ,$message));
        }
        else if($status=='hold'){
            // send sms to customer 
            $shipment = Shipment::find($shipment_id);
            $message = 'Dear '.$shipment->name.', You got an TOP for verifying your parcel on '.basic_information()->wensote_link.' is #'.rand(999,88888).'. Please save the code till your parcels on your hand!';
            event(new SendingSMS('customer',$shipment->phone ,$message));
        }else{
            if($otp=='customer'){
                // send sms to customer 
                $shipment = Shipment::find($shipment_id);
                $message = 'Dear '.$shipment->name.', You got an TOP for verifying your parcel on '.basic_information()->wensote_link.' is #'.rand(999,88888).'. Please save the code till your parcels on your hand!';
                event(new SendingSMS('customer',$shipment->phone ,$message));
            }
            if($otp=='merchant'){
                $shipment = Shipment::find($shipment_id);
                $message = 'Dear '.$shipment->user->first_name.', You got an TOP for verifying parcel delivery for the item #'.$shipment->invoice_id.'.  Your OTP is: '.rand(999,88888).'. Please save the code till your parcels on your hand!';
                event(new SendingSMS('customer',$shipment->phone ,$message));
           }
        }
    }

    

    public function return_agent_dispatch()
    {
        $paracels = Driver_return_shipment_box::where([
            'driver_id'=>Auth::guard('driver')->user()->id,
            'status_in'=>'assigned'
        ])->get();
        // dd($paracels);
        return view('driver.shipment.return-agent-dispatch',compact('paracels'));
    }

    function return_delivery_report(Request $request){
        dd($request->all());
    }


    function otp_confirmation(Request $request){
        $shipment = Shipment::where('id',$request->shipment_id);
        $status = substr($shipment->first()->shipping_status, -1, strpos( $shipment->first()->shipping_status, '-'));
        Shipmnet_OTP_confirmation::create([
            'otp'=>$request->otp,
            'collect_by'=>$request->collect_by,
            'shipment_id'=>$shipment->first()->id,
            'driver_id'=>Auth::guard('driver')->user()->id,
        ]);
        $shipment->update(['shipping_status'=>$status]);
        return back()->with('message','The Shipment OTP has been confirmed successfully!');
    }

}
