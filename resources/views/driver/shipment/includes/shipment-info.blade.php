<table class="table table-xs" id="{{$shipment->id}}">
      <tbody>
        <tr>
          <td>Invoice ID: {{$shipment->invoice_id}}</td>
          <td></td><td class="text-right">
            <select class="select2 select2_single areaOp">
             <option> {{$shipment->area->name}}</option>
          
          </select> </td>
        </tr>
        <tr>
          <td>Customer: {{$shipment->name}} </td>
          <td></td><td></td>
        </tr>
        <tr>
          <td>Price: {{$shipment->price}}</td>
          <td></td><td class="text-right">
            Weight: <input style="width:100px" type="number" value="{{$shipment->weight}}"></td>
        </tr>
        <tr>
          <td>Phone: {{$shipment->phone}} </td>
          <td></td><td class="text-right">Hub: {{hub_from_area($shipment->area_id)->name}}</td>
        </tr>
        <tr>
          <td colspan="3">Address: {{$shipment->address}} </td>  
        </tr>
        <tr>
          <td class="text-left" colspan="3">Date: {{date('M d, Y',strtotime($shipment->created_at))}} (<b class="text-info">{{$shipment->created_at->diffForHumans()}}</b>) </td>
        </tr>
        
      </tbody>
</table> 