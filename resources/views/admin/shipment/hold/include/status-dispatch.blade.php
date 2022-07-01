@foreach($boxes as $key=>$box)
<div class="row" style="background: #f3f3f3;margin-bottom: 1em; padding: 5px;">
	<div class="col-md-8">
		<b>Bulk ID:</b> {{$box->bulk_id}} <br>
		<b>Hub:</b> {{$box->hub->name}} <br>
		Parcel count: <b>{{ COUNT(explode(',',$box->shipment_ids))}}</b>
	</div>
	<div class="col-md-4">
		<button class="btn btn-xs btn-default form-control" onclick="dispatch_shipments(<?php echo $box->id;?>)">Parcels</button>

		<button class="btn btn-xs btn-success form-control mts{{$box->id}}" onclick="changeBoxStatus(<?php echo $box->id;?>)">Move <i class="fa fa-long-arrow-right"></i></button>
	</div>
</div>
@endforeach

@if($boxes->count() <1)<p class="alert alert-default text-center text-danger">No data available</p>@endif
