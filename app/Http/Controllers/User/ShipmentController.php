<?php

namespace App\Http\Controllers\User;

use App\Area;
use App\Http\Controllers\Controller;
use App\Shipment;
use App\ShippingPrice;
use App\Zone;
use Illuminate\Http\Request;
use Auth;

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
                return ['status' => 'error', 'message' => 'Please declared your parcel value first.'];
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
                return response()->json(['status' => 'error', 'errors' => ['message' => 'Please declared your parcel value first.']], 422);
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
        $insert->tracking_code = rand(1000, 9999) . str_pad($new_id, 3, "0", STR_PAD_LEFT) . str_pad(Auth::guard('user')->user()->id, 3, "0", STR_PAD_LEFT);
        $insert->cod = $cod_type;
        $insert->cod_amount = $cod_amount;
        $insert->price = $price;
        $insert->total_price = $total_price;
        $insert->save();

        $output = array(
            'done' => 'done',
        );

        return json_encode($output);
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

    public function destroy($id)
    {
        //
    }
}
