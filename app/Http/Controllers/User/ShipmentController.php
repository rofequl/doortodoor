<?php

namespace App\Http\Controllers\User;

use App\Area;
use App\Http\Controllers\Controller;
use App\Shipment;
use App\ShippingPrice;
use App\Shipment_delivery_payment;
use Illuminate\Http\Request;
use Auth; use PDF;
use DataTables;
class ShipmentController extends Controller
{
    public function index()
    {
        $area = Area::where('status', 1)->get();
        return view('dashboard.shipment', compact('area'));
    }

    public function rateCheck(Request $request)
    {
        $price = 0;
        $total_price = 0;
        $cod_type = 0;
        $cod_amount = 0;
        if (!$request->area) {
            return ['status' => 'error', 'message' => 'Please select the area first.'];
        }
        $zone = Area::find($request->area);
        $shipping = ShippingPrice::where('zone_id', $zone->zone_id)->where('delivery_type', $request->delivery_type)->first();
        if (!$shipping) {
            return ['status' => 'error', 'message' => 'Sorry, not any shipping rate set this zone'];
        }
        if ($shipping->cod == 1) {
            $cod_type = 1;
            if (!$request->parcel_value) {
                // return ['status' => 'error', 'message' => 'Please declared your parcel value first.'];
                $cod_amount = 0;
            } else {
                $cod_amount = (int)(((int)$request->parcel_value / 100) * $shipping->cod_value);
            }
        }

        if (!$request->weight) {
            return ['status' => 'error', 'message' => 'Please enter your product weight'];
        } else {
            $weight = (float)$request->weight;
            if ($weight > $shipping->max_weight) {
                $ExtraWeight = ($weight - $shipping->max_weight) / $shipping->per_weight;
                if ((int)$ExtraWeight < $ExtraWeight) {
                    $ExtraWeight = (int)$ExtraWeight + 1;
                }
                $price = ($ExtraWeight * $shipping->price) + $shipping->max_price;
            } else {
                $price = (int)$shipping->max_price;
            }
        }

        $total_price = $price + $cod_amount + (int)$request->parcel_value;

        return ['status' => 'success', 'total_price' => $total_price, 'price' => $price, 'cod' => $cod_type, 'cod_amount' => $cod_amount, 'cod_rate' => $shipping->cod_value];
    }



    public function PrepareShipmentSubmit(Request $request)
    {
        $messages = [
            "name.required" => "Please enter customer name.",
            "phone.required" => "Please enter customer phone number.",
            "address.required" => "Please enter customer address.",
            "weight.required" => "Parcel weight required",
            "parcel_value.max" => "The value of parcel must be 7 character",
            "area.required" => "Please select customer area",
        ];

        $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|max:20',
            'address' => 'required|max:255',
            'area' => 'required',
            'zip_code' => 'max:10',
            'parcel_value' => 'max:7',
            'invoice_id' => 'max:20',
            'merchant_note' => 'max:255',
            'weight' => 'required|max:5',
            'delivery_type' => 'required',
        ], $messages);

        $price = 0;
        $total_price = 0;
        $cod_type = 0;
        $cod_amount = 0;
        $zone = Area::find($request->area);
        $shipping = ShippingPrice::where('zone_id', $zone->zone_id)->where('delivery_type', $request->delivery_type)->first();
        if (!$shipping) {
            return response()->json(['status' => 'error', 'errors' => ['message' => 'Sorry, not any shipping rate set this zone']], 422);
        }
        if ($shipping->cod == 1) {
            $cod_type = 1;
            if (!$request->parcel_value) {
                // return response()->json(['status' => 'error', 'errors' => ['message' => 'Please declared your parcel value first.']], 422);
                $cod_amount = 0;
            } else {
                $cod_amount = ((int)$request->parcel_value / 100) * $shipping->cod_value;
            }
        }


        $weight = (float)$request->weight;
        if ($weight > $shipping->max_weight) {
            $ExtraWeight = ($weight - $shipping->max_weight) / $shipping->per_weight;
            if ((int)$ExtraWeight < $ExtraWeight) {
                $ExtraWeight = (int)$ExtraWeight + 1;
            }
            $price = ($ExtraWeight * $shipping->price) + $shipping->max_price;
        } else {
            $price = (int)$shipping->max_price;
        }
        $total_price = $price + $cod_amount + (int)$request->parcel_value;

        $insert = new Shipment();
        $insert->user_id = Auth::guard('user')->user()->id;
        $insert->zone_id = $zone->zone_id;
        $insert->area_id = $request->area;
        $insert->name = $request->name;
        $insert->phone = $request->phone;
        $insert->address = $request->address;
        $insert->zip_code = $request->zip_code;
        $insert->parcel_value = $request->parcel_value;
        $insert->invoice_id = $request->invoice_id;
        $insert->merchant_note = $request->merchant_note;
        $insert->weight = $request->weight;
        $insert->delivery_type = $request->delivery_type;
        $insert->delivery_type = $request->delivery_type;
        $new_id = Shipment::all()->first();
        $insert->tracking_code = rand();
        $insert->cod = $cod_type;
        $insert->cod_amount = $cod_amount;
        $insert->price = $price;
        $insert->total_price = $total_price;
        $insert->save();

        $output = array(
            'done' => 'done',
        );

        // return json_encode($output);
        return back()->with('message','Shipment has been saved successfully!');
    }

    public function PrepareShipmentEdit($id)
    {
        $earth = new Earth();
        $earth = $earth->getCountries()->toArray();
        $address = address::all();
        $shipment = shipment::where('user_id', session('user-id'))->where('id', $id)->first();
        if ($shipment->status == 1) {
            return redirect('dashboard');
        }
        return view('dashboard.shipment_edit', compact('shipment', 'address', 'earth'));
    }


    function show(Shipment $shipment){
        $zone = Area::find($shipment->area_id);
        $shipping = ShippingPrice::where('zone_id', $zone->zone_id)->where('delivery_type', $shipment->delivery_type)->first();
        
        if ($shipping ==null) {
            dd('ShippingPrice missing');
        }

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


        return view('dashboard.shipment-view', compact('shipment','price','total_price','shipping'));
    }

    function shipment_pdf(Shipment $shipment){
        $zone = Area::find($shipment->area_id);
        $shipping = ShippingPrice::where('zone_id', $zone->zone_id)->where('delivery_type', $shipment->delivery_type)->first();

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
        // return view('dashboard.shipment-pdf', compact('shipment','price','total_price','shipping'));
        $pdf = PDF::loadView('dashboard.shipment-pdf', compact('shipment','price','total_price','shipping'));
        return $pdf->download('Invoice-'.$shipment->invoice_id.'.pdf');
    }

    function payments(){  
        // $shipment = Shipment::orderBy('id','DESC')->where('user_id', Auth::guard('user')->user()->id)->get();
        return view('dashboard.shipment-payment');
    }

    function payments_loading(){  
        return DataTables::of(Shipment::orderBy('id', 'DESC'))
        ->addColumn('action', function ($shipment) {  
            return '<a href="/shipment-info/'.$shipment->id.'">View</a> | 
            <button type="button" class="btnNew" id="'.$shipment->id.'">Payment</button>';
        })
        ->addColumn('id', function ($shipment) {  
            return $shipment->id;
        })
        ->addColumn('tracking_code', function ($shipment) {  
            return $shipment->tracking_code;
        })
        ->addColumn('invoice_no', function ($shipment) {
           return $shipment->invoice_id;
        })
        ->addColumn('payment_by', function ($shipment) {
            if ($shipment->price==0) {
                $price = 'Merchant will pay';
            }else $price = 'User will pay';
            return $price;
        })
        ->addColumn('amount', function ($shipment) {
            $price = 0;
            $zone = Area::find($shipment->area_id);
            $shipping = ShippingPrice::where('zone_id', $zone->id)->first();
            if($shipping !=''){
                if ($shipping->cod == 1 && $shipping !=null) {
                    $cod_type = 1;
                    if (!$shipment->parcel_value) {
                        $cod_amount = 0;
                    } else {
                        $cod_amount = ((int)$shipment->parcel_value / 100) * $shipping->cod_value;
                    }
                }


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
                if($shipment->price==0) return $price.' Tk';
                else return $total_price.' Tk';
            }else{ return '<span class="text-danger">'.$shipment->price.' Tk</span>';}
            
           
        })
        ->rawColumns(['id','tracking_code','invoice_no','payment_by','amount','action'])->make(true);
    }

    function show_payment(Shipment $shipment){
        $payments =  Shipment_delivery_payment::where('shipment_id',$shipment->id)->get();
        return view('dashboard.include.shipment-delivery-payment',compact('payments'));
    }


    function edit(Shipment $shipment){
        $area = Area::where('status', 1)->get();
        return view('dashboard.edit-shipment', compact('area','shipment'));
    }

    function update(Shipment $shipment,Request $request){
        $messages = [
            "name.required" => "Please enter customer name.",
            "phone.required" => "Please enter customer phone number.",
            "address.required" => "Please enter customer address.",
            "weight.required" => "Parcel weight required",
            "parcel_value.max" => "The value of parcel must be 7 character",
            "area.required" => "Please select customer area",
        ];

        $price = 0;
        $total_price = 0;
        $cod_type = 0;
        $cod_amount = 0;
        $zone = Area::find($request->area);
        $shipping = ShippingPrice::where('zone_id', $zone->zone_id)->where('delivery_type', $request->delivery_type)->first();
        if (!$shipping) {
            return response()->json(['status' => 'error', 'errors' => ['message' => 'Sorry, not any shipping rate set this zone']], 422);
        }
        if ($shipping->cod == 1) {
            $cod_type = 1;
            if (!$request->parcel_value) {
                // return response()->json(['status' => 'error', 'errors' => ['message' => 'Please declared your parcel value first.']], 422);
                $cod_amount = 0;
            } else {
                $cod_amount = ((int)$request->parcel_value / 100) * $shipping->cod_value;
            }
        }


        $weight = (float)$request->weight;
        if ($weight > $shipping->max_weight) {
            $ExtraWeight = ($weight - $shipping->max_weight) / $shipping->per_weight;
            if ((int)$ExtraWeight < $ExtraWeight) {
                $ExtraWeight = (int)$ExtraWeight + 1;
            }
            $price = ($ExtraWeight * $shipping->price) + $shipping->max_price;
        } else {
            $price = (int)$shipping->max_price;
        }
        $total_price = $price + $cod_amount + (int)$request->parcel_value;

        $checkInvoice = Shipment::where('invoice_id',$request->invoice_id)->count();
        if($checkInvoice >0){
            $invoice_id = $request->invoice_id.rand(222,22);
        }else $invoice_id = $request->invoice_id;

        $data = [
            'user_id'=>Auth::guard('user')->user()->id,
            'zone_id'=>$zone->zone_id,
            'area_id'=> $request->area,
            'name'=>$request->name,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'zip_code'=>$request->zip_code,
            'parcel_value'=>$request->parcel_value,
            'invoice_id'=>$invoice_id,
            'merchant_note'=>$request->merchant_note,
            'weight'=>$request->weight,
            'delivery_type'=>$request->delivery_type,
            'cod'=> $cod_type,
            'cod_amount'=>$cod_amount,
            'price'=>$price,
            'tracking_code'=>rand(),
            'total_price'=>$total_price,
        ];
        $shipment->update($data);
        $output = array('done' => 'done',);

        // return json_encode($output);
        return back()->with('message','Shipment has been udated successfully!');
    }

    public function destroy($id)
    {
        //
    }
}
