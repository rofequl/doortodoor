<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ShippingPrice;
use App\Zone;
use Illuminate\Http\Request;
use Session; use Auth;

class ShippingPriceController extends Controller
{
    public function shippingPrice()
    {
        $shipping = ShippingPrice::all();
        $zone = Zone::orderBy('name')->get();
        return view('admin.shipping_price.price', compact('zone', 'shipping'));
    }

    public function shippingPriceAdd(Request $request)
    {
        $messages = [
            "zone_id.required" => "Select distribution zone.",
            "delivery_type.required" => "Delivery type required",
            "max_weight.required" => "Input parcel maximum weight",
            "per_weight.required" => "Input parcel per weight",
        ];

        $this->validate($request, [
            'zone_id' => 'required',
            'delivery_type' => 'required',
            'max_weight' => 'required',
            'max_price' => 'required',
            'per_weight' => 'required',
            'price' => 'required',
        ], $messages);

        $shipping = ShippingPrice::where('zone_id', $request->zone_id)->where('delivery_type', $request->delivery_type)->first();
        if ($shipping) {
            return back()->withErrors(['message' => 'You are already entry this price setting.']);
        }

        $insert = new ShippingPrice();
        if ($request->cod) {
            if (!$request->cod_value) {
                return back()->withErrors(['message' => 'COD percent rate required.']);
            }
            $insert->cod = 1;
            $insert->cod_value = $request->cod_value;
        }
        $insert->zone_id = $request->zone_id;
        $insert->delivery_type = $request->delivery_type;
        $insert->max_weight = $request->max_weight;
        $insert->max_price = $request->max_price;
        $insert->per_weight = $request->per_weight;
        $insert->price = $request->price;
        $insert->save();

        Session::flash('message', 'Shipping price add successfully');
        return redirect('/admin/shipping-price-set');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(ShippingPrice $shippingPrice)
    {
        return ShippingPrice::find($shippingPrice->id);
    }

    public function shippingPriceEdit(Request $request)
    {
        // dd($request->all());
        $messages = [
            "zone_id.required" => "Select distribution zone.",
            "delivery_type.required" => "Delivery type required",
            "max_weight.required" => "Input parcel maximum weight",
            "per_weight.required" => "Input parcel per weight",
        ];

        $this->validate($request, [
            'zone_id' => 'required',
            'delivery_type' => 'required',
            'max_weight' => 'required',
            'max_price' => 'required',
            'per_weight' => 'required',
            'price' => 'required',
        ], $messages);
     

        if ($request->cod) {
            if (!$request->cod_value) {
                return back()->withErrors(['message' => 'COD percent rate required.']);
            }
            $cod = 1;
            $cod_value = $request->cod_value;
        }else{ $cod = 0; $cod_value = null;}
        $data = [
            'zone_id' => $request->zone_id,
            'cod'=>$cod,
            'cod_value'=>$cod_value,
            'delivery_type' => $request->delivery_type,
            'max_weight' =>  $request->max_weight,
            'max_price' =>  $request->max_price,
            'per_weight' =>  $request->per_weight,
            'price' => $request->price,
        ];
        ShippingPrice::where('id',$request->id)->update($data);

        Session::flash('message', 'Shipping price updaed successfully');
        return redirect('/admin/shipping-price-set');
    }


    public function destroy(ShippingPrice $shippingPrice)
    {
        if(Auth::guard('admin')->user()->role_id=='1'){
        $shippingPrice->delete();
        Session::flash('message', 'Shipping price updaed successfully');
       }else{
        Session::flash('message', 'Warning: You dont have access to delete!!');
       }
        return redirect('/admin/shipping-price-set');
    }
}
