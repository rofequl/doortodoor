<?php $areas = \DB::table('areas')->get(); ?>
@foreach($shipments as $key=>$item)
	<table class="table table-xs row{{$item->id}}">
      <tbody>
        <tr>
          <td>Invoice ID: {{$item->shipment->invoice_id}}</td>
          <td></td><td class="text-right">
            <select class="select select2_single" id="area{{$key}}" disabled>
              @foreach($areas as $area)
                <option value="{{$area->id}}" @if($item->shipment->area_id==$area->id)selected @endif >
                {{$area->name}}</option>
             @endforeach
          </select> </td>
        </tr>
        <tr>
          <td>Customer: {{$item->shipment->name}} </td>
          <td></td><td></td>
        </tr>
        <tr>
          <td>Price: {{$item->shipment->price}}</td>
          <td></td><td class="text-right">
            Weight: <input style="width:100px" type="number" id="weight{{$key}}" value="{{$item->shipment->weight}}" readonly=""></td>
        </tr>
        <tr>
          <td>Phone: {{$item->shipment->phone}} </td>
          <td></td><td class="text-right">Hub: {{hub_from_area($item->shipment->area_id)->name}}</td>
        </tr>
        <tr>
          <td colspan="3">Address: {{$item->shipment->address}} </td>  
        </tr>
        <tr class="text-right">
          <td class="text-left" style="width:50%">Date: <small>{{date('M d, Y',strtotime($item->shipment->created_at))}} (<b class="text-info">{{$item->shipment->created_at->diffForHumans()}}</b>)</small> </td>
          <td></td>
            <td>
                <button class="btn btn-xs btn-default" onclick="move(<?php echo $item->id.','.$item->hub_id;?>)"><i class="fa fa-arrow-left"></i> Move </button>
            </td>
        </tr>
        
      </tbody>
</table>
@endforeach

<script type="text/javascript">
    function move(shipment_id,hub_id){
        $('.mb'+shipment_id).text('Moving..');
        $('.mb'+shipment_id).prop('disabled',true);
        $.ajax({
            type: "get",url: '/admin/move-back-to-return_shipment/'+shipment_id+'/return',
            success: function(data){
                $('.row'+shipment_id).remove(); 
                $(".part1").load('/admin/driver-hub-shipment-rows/return');
            },error: function (request, error) {
                alert(" Can't do because: " + error);
            },
        });
    }
</script>
