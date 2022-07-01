<?php $num = 0;  ?>
@foreach($boxes as $key=>$box)
  @foreach(explode(',',$box->shipment_ids) as $shipment_id)
  <?php $shipment = \App\Shipment::where('id',$shipment_id)->first();?>
  @if(is_return_avail_agentSide($box->id,$shipment->id) ==0)
    <!-- {{$box->id}},  {{$shipment->id}}  <br> -->
    <table class="table table-xs" id="{{$shipment->id}}">
        <tbody>
          <tr>
            <td colspan="2">Invoice ID: {{$shipment->invoice_id}}</td>
            <td><select style="float:right;">
              <option>{{$shipment->area->name}} </option>
            </select></td>
           </tr>
          <tr>
            <td colspan="3">Customer: {{$shipment->name}} </td>
          </tr>
          <tr>
            <td>Price: {{$shipment->price}}</td>
            <td></td><td class="text-right">
              Weight: <input style="width:80px;height:17px" type="number" readonly="" value="{{$shipment->weight}}"></td>
          </tr>
          <tr>
            <td>Phone: {{$shipment->phone}} </td>
            <td></td><td class="text-right hub0">Hub: {{hub_from_area($shipment->area_id)->name}}</td>
          </tr>
          <tr>
            <td colspan="3">Address: {{$shipment->address}} </td>  
          </tr>
          <tr class="text-right">
            <td class="text-left" style="width:50%">Date: <small>{{date('M d, Y',strtotime($shipment->created_at))}} (<b class="text-info">{{$shipment->created_at->diffForHumans()}}</b>)</small></td>
            <td></td>
              <td>
                <button class="btn btn-success btn-xs addBtn{{$shipment->id}}" onclick="moveToDriverAssign(<?php echo $box->id.','.$shipment->id?>);">Move <i class="fa fa-long-arrow-right"></i></button>
              </td>
          </tr>
        </tbody>
    </table> <?php $num++; ?>
  @endif
  @endforeach
@endforeach

@if($num == 0) <p class="text-danger">No data found yet</p> @endif

<script type="text/javascript">
  function moveToDriverAssign(box_id,shipment_id){
    $('.addBtn'+shipment_id).prop('disabled',true);
    $('.addBtn'+shipment_id).html('Moving...');
    // alert(box_id+' = '+shipment_id);return false;
    $.ajax({
        type: "get",url: '/admin/return-agentDispatch-to-driverAssign/'+box_id+'/'+shipment_id,
        success: function(data){ $('#'+shipment_id).remove();
          $(".driver-side").load('/admin/return-agent-dispatch-driverSide');
        },error: function (request, error) {
          alert(" Can't do because: " + error);
          $('.hub'+hub_id).html('<p class="alert text-danger"><i class="fa fa-times-circle"></i> Execution failed! Please try again!!</p>');
        },
    });
  }
</script>