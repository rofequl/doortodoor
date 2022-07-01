@foreach($shipments as $shipment)
  @if(is_in_reconcile_shipments($shipment->id))
  <tr class="row{{$shipment->id}}">
    <td>{{$shipment->name}} - {{$shipment->phone}}</td>
    <td>{{$shipment->invoice_id}}</td>
    <td class="text-right">
      <button class="btn btn-xs btn-info m{{$shipment->id}}" onclick="move2reconcile(<?php echo $shipment->id;?>);">Move <i class="fa fa-long-arrow-right"></i></button>
    </td>
  </tr> @endif
@endforeach

<script>
	function move2reconcile(id){
		$('.m'+id).html('Moving...');
		$.ajax({
	        type: "get", url: '/admin/create-reconcile/'+id,
	        success: function(data){
	        	$('.row'+id).remove();
	         	$(".reconcile-side").load('/admin/load-reconcile-shipments');
	        }
	    });
	}
</script>