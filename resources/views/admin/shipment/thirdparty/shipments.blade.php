@foreach($shipments as $key=>$item)
	<table class="table table-xs" style="background:#f2f3f4;margin-bottom: 2em;font-size: 12px;">
      <tbody>
        <tr>
          <td>Invoice ID: {{$item->shipment->invoice_id}}</td>
          <td></td><td class="text-right"> 
            <select class="select select2_single" id="area{{$key}}" disabled>
              <option>{{$item->shipment->area->name}}</option>
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
          <td></td>
        </tr>
        
      </tbody>
</table>
@endforeach