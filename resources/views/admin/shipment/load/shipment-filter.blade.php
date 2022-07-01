<?php $allStatus = [
  '0'=>'Label created','1'=>'Pickup (driver end)','2'=>'Pickup (admin end)','3'=>'Dispatch center',
  '3'=>'In transit','4'=>'Out for delivery','5'=>'Delivered']; 
  $zones = \DB::table('zones')->select('id','name')->get(); ?>

<form class="col-md-12 col-sm-12  form-group pull-right">@csrf
   <select name="zone_id" style="width:15%">
     <option value="">Zone name</option>
     @foreach($zones as $zone)
     <option @if(request()->zone_id==$zone->id)selected @endif value="{{$zone->id}}">{{$zone->name}}</option>
     @endforeach
   </select>
   <select name="area_id" id="area" style="width:22%">
     <option value="">Area</option>
   </select>
   <input type="text" name="invoice_id" style="width:20%" placeholder="Invoice ID" value="{{request()->invoice_id}}">
   <input type="text" name="phone" placeholder="phone No" style="width:20%" value="{{request()->phone}}">
   <select name="status"style="width:12%">
     <option>Status</option>
     @foreach($allStatus as $key=>$status)
     <option @if(request()->status==$key)selected @endif  value="{{$key}}">{{$status}}</option>
     @endforeach
   </select>
    <button style="width:5%" type="submit">Go!</button>
</form>