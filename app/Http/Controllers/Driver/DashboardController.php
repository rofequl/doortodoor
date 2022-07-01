<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use App\Driver_shipment;
use App\Driver_hub_shipment_box;
use App\Shipment;
class DashboardController extends Controller
{
    public function index(){
        return view('driver.dashboard');
    }

    public function shipments($type){
        if($type=='delivery'){
            return $this->delivery_shipments();
        }
        else if($type=='pickup'){
            return $this->pickup_shipments();
        }
        else if($type=='otp'){
            return $this->otp_shipments();
        }
    }

    public function shipments_dates($dates,$type)
    {
        $dateFrom = date('Y-m-d',strtotime(str_replace('~','/',explode('-',$dates)[0])));
        $dateTo = date('Y-m-d',strtotime(str_replace('~','/',explode('-',$dates)[1])));
        if($type=='delivery'){
            $shipments = Driver_hub_shipment_box::where(['driver_id'=>Auth::guard('driver')->user()->id])
            ->whereBetween('created_at', [$dateFrom." 00:00:00", $dateTo." 23:59:59"])
            ->orderBy('id', 'DESC')->get();
        }else{
            $shipments = Driver_shipment::where(['driver_id'=>Auth::guard('driver')->user()->id])
            ->whereBetween('created_at', [$dateFrom." 00:00:00", $dateTo." 23:59:59"])
            ->orderBy('id', 'DESC')->get();
        }
        
        return view('driver.includes.date-wize-shipments',compact('shipments'));
    }

    public function delivery_shipments()
    {
        return DataTables::of(Driver_hub_shipment_box::where('driver_id',Auth::guard('driver')->user()->id)
        ->where('status','!=','assigned')
        ->orderBy('id', 'DESC'))
                ->addColumn('date', function ($driverShipment) {
                    $data = 'Date: '.date('M d, Y H:i',strtotime($driverShipment->created_at)).'<br/>';
                    $data.= 'TracingCode: '.$driverShipment->shipment->tracking_code; return $data;
                })
                ->addColumn('customer_info', function ($driverShipment) {
                    $data =  $driverShipment->shipment->name.'<br/>';
                    $data .= $driverShipment->shipment->phone;
                    return  $data;
                })
                ->addColumn('merchant', function ($driverShipment) {
                    $data =  $driverShipment->shipment->user->first_name.' ';
                    $data .=  $driverShipment->shipment->user->last_name;
                    return $data;
                })
                ->addColumn('amount', function ($driverShipment) {
                    if($driverShipment->shipment->price==0){
                        $data = 'Pay by merchant ('.$driverShipment->shipment->price.')';
                    }else {$data = 'Pay by customer ('.$driverShipment->shipment->price.')';}
                    return $data;
                })
                ->addColumn('area', function ($driverShipment) {
                    return $driverShipment->shipment->area->name;
                })
                ->addColumn('status', function ($driverShipment) {
                    $status = $driverShipment->shipment->status;
                    $shipping_status = $driverShipment->shipment->shipping_status;
                    // return $shipping_status;
                    return view('dashboard.include.shipping-status',compact('status','shipping_status'));
                })->rawColumns(['date','customer_info','merchant','amount','area','status'])->make(true);
    }


    function pickup_shipments(){
        return DataTables::of(Driver_hub_shipment_box::where(['driver_id'=>Auth::guard('driver')->user()->id,'status'=>'assigned'])->orderBy('id', 'DESC'))
        ->addColumn('date', function ($driverShipment) {
            $data = 'Date: '.date('M d, Y H:i',strtotime($driverShipment->created_at)).'<br/>';
            $data.= 'TracingCode: '.$driverShipment->shipment->tracking_code; return $data;
        })
        ->addColumn('customer_info', function ($driverShipment) {
            $data =  $driverShipment->shipment->name.'<br/>';
            $data .= $driverShipment->shipment->phone;
            return  $data;
        })
        ->addColumn('merchant', function ($driverShipment) {
            $data =  $driverShipment->shipment->user->first_name.' ';
            $data .=  $driverShipment->shipment->user->last_name;
            return $data;
        })
        ->addColumn('amount', function ($driverShipment) {
            if($driverShipment->shipment->price==0){
                $data = 'Pay by merchant ('.$driverShipment->shipment->price.')';
            }else {$data = 'Pay by customer ('.$driverShipment->shipment->price.')';}
            return $data;
        })
        ->addColumn('area', function ($driverShipment) {
            return $driverShipment->shipment->area->name;
        })
        ->addColumn('status', function ($driverShipment) {
            $status = $driverShipment->shipment->status;
            $shipping_status = $driverShipment->shipment->shipping_status;
            // return $shipping_status;
            return view('dashboard.include.shipping-status',compact('status','shipping_status'));
        })->rawColumns(['date','customer_info','merchant','amount','area','status'])->make(true);

        // return DataTables::of(Driver_shipment::where(['driver_id'=>Auth::guard('driver')->user()->id])->orderBy('id', 'DESC'))
        // ->addColumn('date', function ($driverShipment) {
        //     $data = 'Date: '.date('M d, Y H:i',strtotime($driverShipment->created_at)).'<br/>';
        //     $data.= 'TracingCode: '.$driverShipment->shipment->tracking_code; return $data;
        // })
        // ->addColumn('customer_info', function ($driverShipment) {
        //     $data =  $driverShipment->shipment->name.'<br/>';
        //     $data .= $driverShipment->shipment->phone;
        //     return  $data;
        // })
        // ->addColumn('merchant', function ($driverShipment) {
        //     $data =  $driverShipment->shipment->user->first_name.' ';
        //     $data .=  $driverShipment->shipment->user->last_name;
        //     return $data;
        // })
        // ->addColumn('amount', function ($driverShipment) {
        //     if($driverShipment->shipment->price==0){
        //         $data = 'Pay by merchant ('.$driverShipment->shipment->price.')';
        //     }else {$data = 'Pay by customer ('.$driverShipment->shipment->price.')';}
        //     return $data;
        // })
        // ->addColumn('area', function ($driverShipment) {
        //     return $driverShipment->shipment->area->name;
        // })
        // ->addColumn('status', function ($driverShipment) {
        //     $status = $driverShipment->shipment->status;
        //     $shipping_status = $driverShipment->shipment->shipping_status;
        //     return view('dashboard.include.shipping-status',compact('status','shipping_status'));
        // })->rawColumns(['date','customer_info','merchant','amount','area','status'])->make(true);
    }

    public function otp_shipments()
    {
        return DataTables::of(Shipment::where('shipping_status','LIKE','on%')
        ->where('status','!=','assigned')
        ->orderBy('id', 'DESC'))
            ->addColumn('date', function ($shipment) {
                $data = 'Date: '.date('M d, Y H:i',strtotime($shipment->created_at)).'<br/>';
                $data.= 'TracingCode: '.$shipment->tracking_code; return $data;
            })
            ->addColumn('customer_info', function ($shipment) {
                $data =  $shipment->name.'<br/>';
                $data .= $shipment->phone;
                return  $data;
            })
            ->addColumn('merchant', function ($shipment) {
                $data =  $shipment->user->first_name.' ';
                $data .=  $shipment->user->last_name;
                return $data;
            })
            ->addColumn('amount', function ($shipment) {
                if($shipment->price==0){
                    $data = 'Pay by merchant ('.$shipment->price.')';
                }else {$data = 'Pay by customer ('.$shipment->price.')';}
                return $data;
            })
            ->addColumn('area', function ($shipment) {
                return $shipment->area->name;
            })
            ->addColumn('status', function ($shipment) {
                $status = $shipment->status; $shipping_status = $shipment->shipping_status;
            
                return  view('dashboard.include.shipping-status',compact('status','shipping_status')). ' <button class="btn btn-warning btn-xs openModal" id="'.$shipment->id.'"> Confirm OTP</button>';
            })->rawColumns(['date','customer_info','merchant','amount','area','status'])->make(true);
    }

}
