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

class ThirdpartyShipmentController extends Controller
{

    public function index(Hub $hub)
    {
        $hubs = Thirdparty_shipment::where('status','transit')->select('hub_id')->groupBy('hub_id')->get();
        return view('admin.shipment.thirdparty.index',compact('hub','hubs'));
    }

    function show_left_side(Hub $hub){
        $shipments = Thirdparty_shipment::where('status','transit')
        ->where('status_in',null)->get();
        // dd($shipments);
        return view('admin.shipment.thirdparty.left',compact('hub','shipments'));
    }

    function show_right_side(Hub $hub){
        $shipments = Thirdparty_shipment::where('status_in','assigning')->get();
        return view('admin.shipment.thirdparty.right',compact('hub','shipments'));
    }
    
    //ajax call to show all shipment within a hub
    function show(Hub $hub){
        $shipments = Thirdparty_shipment::where('hub_id',$hub->id)->get();
        // dd($shipments);
        return view('admin.shipment.thirdparty.shipments',compact('hub','shipments'));
    }

    public function moveToright(Thirdparty_shipment $thirdparty_shipment)
    {
        $thirdparty_shipment->update(['status_in'=>'assigning']);
    }
    public function moveToleft(Thirdparty_shipment $thirdparty_shipment)
    {
        $thirdparty_shipment->update(['status_in'=>null]);
    }
    function show_right_withInvoice($invoice_id){
        $shipment = \App\Shipment::where('invoice_id',$invoice_id)->first();
        if($shipment !=null){
            Thirdparty_shipment::where('shipment_id',$shipment->id)->update(['status_in'=>'assigning']);
        }
    }

    function sendToSort(){
        $shipments = Thirdparty_shipment::where('status_in','assigning')->get();
        foreach($shipments as $shipment){
            Shipment::where('id',$shipment->shipment_id)->update([
                'shipping_status'=>'10'    
            ]);
        }
        Thirdparty_shipment::where('status_in','assigning')->update([
            'status'=>'assigned','status_in'=>'assigned'
        ]);
        return back()->with('message','Send to sorted successfully to third-party!!');
    }

    public function get_csv_pdf($type){
     
        $shipments = Shipment::all();

        foreach ($shipments as $key => $shipment) {
            $rows[] =  [$shipment->invoice_id,$shipment->name,$shipment->phone,$shipment->address,$shipment->zip_code,$shipment->price,$shipment->weight,''];
        }
        $columnNames = ['Invoice', 'Customer Name', 'Contact No.','Customer Address','Post Code','Price','Weight','Product Selling Price'];     
        return self::getCsv($columnNames, $rows,date('d/m/Y h i s').'.csv');


        if($type=='pdf'){
            $shipment_ids = Thirdparty_shipment::where('status_in','assigning')->get();
            // return view('admin.shipment.thirdparty.shipment-pdf',compact('shipment_ids'));
            $pdf = PDF::loadView('admin.shipment.thirdparty.shipment-pdf', compact('shipment_ids'));
            return $pdf->download('parcels for-'.$shipment_ids.' - '.date('y-m-d h:i:s').'.pdf');
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
    
    
    
}
