@foreach($reconciles as $reconcile)
<tr class="rows row_{{$reconcile->shipment_id}}">
  <td>{{$reconcile->shipment->name}}</td>
  <td>{{$reconcile->shipment->invoice_id}}</td>
  <td><button class="btn pull-right btn-xs btn-info n{{$reconcile->shipment_id}}" onclick="back2shipment(<?php echo $reconcile->shipment_id;?>);"><i class="fa fa-long-arrow-left"></i> Move</button></td>
</tr> @endforeach

@if($reconciles->count()>0)
<tr class="text-right btnLink">
	<td colspan="3"><a class="btn btn-warning" href="/admin/return-reconcile2receive">Return to Recevie</a></td>
</tr> @endif

<script>
	function back2shipment(id){
		$('.n'+id).html('Moving...');
		$.ajax({
	        type: "get", url: '/admin/remove-reconcile/'+id,
	        success: function(data){
	         	$(".shipment-side").load('/admin/load-shipment-reconcilable');
	         	$('.row_'+id).remove();
	         	if($('.rows').length==0){
	         		$('.btnLink').slideUp();
	         	}
	        }
	    });
	}
</script>