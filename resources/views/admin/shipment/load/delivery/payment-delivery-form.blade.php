<form class="form-horizontal" method="post" action="/admin/save-delivery-payment">@csrf
    
    @foreach ($shipments as $shipment)
    @php
        $check = \App\Shipment_delivery_payment::where('shipment_id',$shipment->id);
    @endphp
    @if($check->count() <1)
        <div class="form-group">
            <label class="control-label col-sm-5">To: {{$shipment->user->first_name.' '.$shipment->user->last_name}} <br><small>{{$shipment->area->name}}</small></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="amount[]" placeholder="Amount" required>
            </div>
        </div>
        <input type="hidden" name="shipment_ids[]" value="{{$shipment->id}}">
    @else 
        <div class="form-group">
            <label class="control-label col-sm-5"><i class="fa fa-check text-success"></i> {{$shipment->user->first_name.' '.$shipment->user->last_name}} <br><small>{{$shipment->area->name}}</small></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" placeholder="{{$check->first()->amount}}" readonly>
            </div>
        </div>
    @endif

    @endforeach
    <div class="form-group">
        <div class="col-sm-offset-5 col-sm-7 text-right">
          <button type="submit" class="btn btn-success">Submit payments</button>
        </div>
    </div>
    

</form>