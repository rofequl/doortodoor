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
                <button class="btn btn-xs btn-default" onclick="move_item(<?php echo $item->id.','.$item->user_id;?>)"><i class="fa fa-arrow-left"></i> Move </button>
            </td>
        </tr>
        
      </tbody>
</table>
@endforeach

<script type="text/javascript">
	function move_item(id, user_id){
    // alert(id +' '+ user_id);return false;
    $.ajax({
      type: "get",url: '/admin/remove-hub-parcel/'+id,
      success: function(data){
        $('.row'+id).remove();

        $(".receiving-parcels").load('/admin/receiving-parcels/'+user_id+'/1');

        let num =  parseInt($('.num<?php echo $id;?>').text());
        $('.num<?php echo $id;?>').text( num-1 );
      }
    });
    setTimeout(function(){
      let num =  parseInt($('.num<?php echo $id;?>').text());
      if(num===0) {
        $('.hub<?php echo $id;?>').remove();
        $('#viewParcel').modal('hide');
      }
    },1500);
	}

</script>
