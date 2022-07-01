<div class="row">
	<input type="search" id="assignBulk" placeholder="Type Bulk ID">
</div>

@foreach($boxes as $key=>$row)
<div class="row" style="background: #f3f3f3;margin-bottom: 1em; padding: 5px;">
	<div class="col-md-8">
		<b>Bulk ID:</b> {{$row->bulk_id}} <br>
		Hub: @if($row->hub->status=='1' && $row->hub->zone->status=='1') {{$row->hub->zone->name}} @else {{$row->hub->name}} @endif <br>
		Parcel count: <b>{{ COUNT(explode(',',$row->shipment_ids))}}</b>
	</div>
	<div class="col-md-4">
		<button class="btn btn-xs btn-default form-control" onclick="dispatch_shipments(<?php echo $row->id;?>)">Parcels</button>

		<button class="btn btn-xs btn-info form-control rmtd{{$row->id}}" onclick="changeStatus(<?php echo $row->id;?>)"><i class="fa fa-long-arrow-left"></i> Move </button>
	</div>
</div>
@endforeach
	
@if($boxes->count() <1)
	<p class="alert alert-default text-center text-danger">No data available</p>
@else
	<a class="btn btn-success btn-sm pull-right" href="/admin/box-sorting/{{$hub->id}}">Send To Sorting</a>
@endif

<script>
	$('#assignBulk').keypress(function(event){
	    var keycode = (event.keyCode ? event.keyCode : event.which);
	    if(keycode == '13'){
	    	let bulk_id = $('#assignBulk').val();
	    	if(bulk_id.length <1) return false;
	    	$('#assignBulk').prop('disabled',true);
	       	$.ajax({
		       	type: "get",url: '/admin/change-box-status-bulk-id/'+bulk_id+'/on-transit',
		       	success: function(data){
		       		$(".status-dispatch").load('/admin/status-dispatch/<?php echo $hub->id;?>');
	 				$(".status-on-transit").load('/admin/status-on-transit/<?php echo $hub->id;?>');
	 				$('#assignBulk').prop('disabled',false);
		       	},error: function(xhr, status, error) {
				  alert(xhr.responseText);
				  $('#assignBulk').prop('disabled',false);
				}
		    });

	    }
	});

	function changeStatus(box_id){
 		$('.rmtd'+box_id).html('Progress...');
 		$('.rmtd'+box_id).prop('disabled',true);
 		$.ajax({
	       	type: "get",url: '/admin/change-box-status/'+box_id+'/dispatch',
	       	success: function(data){
	       		$(".status-dispatch").load('/admin/status-dispatch/<?php echo $hub->id;?>');
 				$(".status-on-transit").load('/admin/status-on-transit/<?php echo $hub->id;?>');
	       	},error: function(xhr, status, error) {
			  alert(xhr.responseText);
			}
	    });
 	}
</script>