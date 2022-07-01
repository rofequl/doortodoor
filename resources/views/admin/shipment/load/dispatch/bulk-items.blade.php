@foreach($shipments as $key=>$shipment )
	<table class="table table-xs" style="background:#f2f3f4;margin-bottom: 2em;font-size: 12px;">
      <tbody>
        <tr>
          <td>Invoice ID: {{$shipment->invoice_id}}</td>
          <td></td><td class="text-right"> 
            <select class="select select2_single" id="area{{$key}}" disabled>
              <option>{{$shipment->area->name}}</option>
          </select> </td>
        </tr>
        <tr>
          <td>Customer: {{$shipment->name}} </td>
          <td></td><td></td>
        </tr>
        <tr>
          <td>Price: {{$shipment->price}}</td>
          <td></td><td class="text-right">
            Weight: <input style="width:100px" type="number" id="weight{{$key}}" value="{{$shipment->weight}}" readonly=""></td>
        </tr>
        <tr>
          <td>Phone: {{$shipment->phone}} </td>
          <td></td><td class="text-right">Hub: {{hub_from_area($shipment->area_id)->name}}</td>
        </tr>
        <tr>
          <td colspan="3">Address: {{$shipment->address}} </td>  
        </tr>
        <tr class="text-right">
          <td class="text-left" style="width:50%">Date: <small>{{date('M d, Y',strtotime($shipment->created_at))}} (<b class="text-info">{{$shipment->created_at->diffForHumans()}}</b>)</small> </td>
          <td></td>
          <td></td>
        </tr>
        
      </tbody>
</table>
@endforeach