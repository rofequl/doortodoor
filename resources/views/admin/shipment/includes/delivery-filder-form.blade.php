<div class="row">
    <div class="col-md-2">
        <select class="form-control select2" name="area_id" id="area_id" onchange="get_area()">
            <option value="">Search By Area</option>
            @foreach($areas as $area)
            <option @if(request()->area_id==$area->id)selected @endif value="{{$area->id}}">{{$area->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <input style="padding:18px;" class="form-control" type="search" name="phone" placeholder="Customer phone" value="{{request()->phone}}" />
    </div>
    <div class="col-md-2">
        <select class="form-control select2" name="hub_id" id="hub_id" onchange="get_hub()">
            <option value="">Search By Hub</option>
            @foreach($hubs as $hub)
            <option @if(request()->hub_id==$hub->id)selected @endif value="{{$hub->id}}">{{$hub->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select class="form-control select2" name="merchant_id" id="merchant_id" onchange="get_merchant()">
            <option value="">Search By merchant</option>
            @foreach($users as $user)
            <option @if(request()->merchant_id==$user->id)selected @endif value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
            @endforeach
        </select>
    </div> 
    <div class="col-md-2">
        @php $drivers = \App\Driver::where('status','1')->get(); @endphp

        <select class="form-control select2" name="driver_id" onchange="get_driver()">
            <option value="">Search By Rider</option>
            @foreach($drivers as $driver)
            <option @if(request()->driver_id==$driver->id)selected @endif  value="{{$driver->id}}">{{$driver->first_name}} {{$driver->last_name}}</option>
            @endforeach
        </select>
    </div>
</div>
<br/>
<div class="row"> 
    <div class="col-md-6">
        <input style="padding:18px;" type="text" class="form-control" id="invoice_id" name="invoice_id" placeholder="Type Invoice ID/s" value="{{request()->invoice_id}}" >
    </div>
    <div class="col-md-2">
        <select class="form-control select2" name="status" id="status" onchange="get_status()">
            <option value="">Status</option>
            <option value="0" @if(request()->status=='0')selected @endif >Pickup from merchant</option>
            <option value="1" @if(request()->status=='1')selected @endif >Assigned rider for pickup</option>
            <option value="2" @if(request()->status=='2')selected @endif >Receive parcel by Rider</option>
            <option value="3" @if(request()->status=='3')selected @endif >Sorted for Dispatch center</option>
            <option value="4" @if(request()->status=='4')selected @endif >In - transit</option>
            <option value="5" @if(request()->status=='5')selected @endif > Out for delivery</option>
            <option value="6" @if(request()->status=='6')selected @endif > Delivered</option>
            <option value="6.5" @if(request()->status=='6.5')selected @endif > Partially delivered</option>
            <option value="7" @if(request()->status=='7')selected @endif > Hold shipments</option>
            <option value="8" @if(request()->status=='8')selected @endif > Return shipments</option>
        </select>
    </div>
    <div class="col-md-2">
        <input class="form-control" type="date" name="date1" placeholder="date from" id="datepicker" value="{{request()->date1}}">
    </div>
    <div class="col-md-2">
        <input  class="form-control" type="date" name="date2" placeholder="date to" onchange="get_dates()"
        value="{{request()->date2}}">
    </div>
</div> <br>