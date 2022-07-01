<div class="table-responsive">
  <table class="table table-striped jambo_table bulk_action">
    <thead>
      <tr class="headings selected">
   
		<th><input type="checkbox"  id="checkall" onClick="checkAll();"/></th>
        <th class="column-title">Customer info </th>
        <th class="column-title">Invoice ID</th>
        <th class="column-title">Source Hub</th>
        <th class="column-title">Date </th>
        <th class="text-right">Status </th>			
      </tr>
    </thead>

    @foreach($shipments as $shipment)
      @if(is_in_reconcile_shipments($shipment->id))
      <tr class="row{{$shipment->id}}">
        <td> 
            <input type="checkbox" class="checkbox" id="ids" name="ids[]" value="{{$shipment->id}}">
        </td>
        <td>{{$shipment->name}} - {{$shipment->phone}}</td>
        <td>{{$shipment->invoice_id}}</td>
        <td>{{$shipment->area->hub->name}}</td>
        <td>{{date('M d, Y H:i',strtotime($shipment->created_at))}}</td>
        <td class="text-right">
         @include('admin.shipment.status',['status'=>$shipment->status,'shipping_status'=>$shipment->shipping_status])
        </td>
      </tr> @endif
    @endforeach
      
    </tbody>
  </table>
</div>

<script >

    function checkAll() {
        if($('#checkall').prop("checked") == true){
            $('.checkbox').prop('checked',true)
        }else if($('#checkall').prop("checked") == false){
            $('.checkbox').prop('checked',false)
        }        
    }

</script>