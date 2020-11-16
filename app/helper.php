<?php

use App\BasicInformation;
use App\Shipment;
use App\Zone;

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

function user_shipment($id, $status = 1)
{
    return Shipment::where('user_id', $id)->where('status', $status)->get();
}
