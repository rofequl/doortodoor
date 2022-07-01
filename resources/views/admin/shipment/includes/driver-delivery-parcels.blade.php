
    @foreach($shipments as $shipment)
    <tr class="even pointer">
      <td><input type="checkbox" value="{{$shipment->id}}" class="checkbox" name="ids[]"></td>
      <td style="width:25%">
        Parcel ID: {{$shipment->id}}<br>
        Invoice ID: {{$shipment->invoice_id}}<br>
        Bulk ID: <?php $bulk_id = \DB::table('hub_shipment_boxes')->whereRaw('FIND_IN_SET(?,shipment_ids)',[$shipment->id])->pluck('bulk_id')->first();echo $bulk_id; ?> <br>
        Shop ID: {{$shipment->user->shop_name}}<br>

        Resource Hub: {{$shipment->area->hub->name}}<br>
        Delivry Hub: <?php $hubInfo = \App\Hub_shipment::where('shipment_id',$shipment->id)->get();?>
        @foreach($hubInfo as $hub) {{$hub->hub->name}} @endforeach
        <br>

      </td>
      <td style="width:20%">
        Name: {{$shipment->name}}<br>
        Phone No: {{$shipment->phone}}<br>
        Address: {{$shipment->address}}<br>
      </td>
      <td style="width:10%">
        Weight: {{$shipment->weight}} KG<br>
        Price: {{$shipment->price}}<br>
        @if($shipment->cod !=0)
        COD: Applied<br>
        COD value:{{$shipment->cod_value}}% @endif

        @if($shipment->price ==0) Pay by merchant @else Pay by Customer @endif
      </td>
      <td>
        @if($shipment->shipping_status>5)
          <?php $driver_id = \DB::table('driver_hub_shipment_box')->where('shipment_id',$shipment->id)->pluck('driver_id')->first();
          $dName = \DB::table('drivers')->where('id',$driver_id)->select('first_name','last_name')->first(); ?>
          @if($dName !=null) Delivery by <b class="label label-info">{{$dName->first_name.' '.$dName->last_name}}</b> <br> @endif
        @endif

        <?php $driver_id = \DB::table('driver_shipment')->where('shipment_id',$shipment->id)->pluck('driver_id')->first();?> 
        @if($driver_id !=null)
          <?php $dName = \DB::table('drivers')->where('id',$driver_id)->select('first_name','last_name')->first();?>
          Picked up by<br><b class="label label-info">{{$dName->first_name.' '.$dName->last_name}}</b>
        @else
          <?php $dName = \DB::table('admins')->where('id',Auth::guard('admin')->user()->id)->select('first_name','last_name')->first();?>
          @if($dName !=null) Picked up by<br><b class="label label-info">{{$dName->first_name.' '.$dName->last_name}}</b> @endif
        @endif
      </td>
      <td class="">Created at: {{date('M d, y H:i:s',strtotime($shipment->created_at))}}<br>
      Delivery at: 
      @if($shipment->shipping_status>5)
        <?php $created_at = \DB::table('driver_hub_shipment_box')->where('shipment_id',$shipment->id)->pluck('created_at')->first(); ?>
        {{date('M d, y H:i:s',strtotime($created_at))}}
      @endif
      </td>
      <td class="">
        Status:
        @include('admin.shipment.status',['status'=>$shipment->status,'shipping_status'=>$shipment->shipping_status]) <br><br>
        
        <b data-toggle="modal" data-target="#DriverNote" class="btn btn-xs btn-info pull-right" onclick="get_driver_note(<?php echo $shipment->id;?>)"> <i class="fa fa-info"></i> <i class="fa fa-plus-circle"></i></b>
        
        <button onclick="audit_log(<?php echo $shipment->id;?>)" class="btn btn-xs pull-left btn-warning" data-toggle="modal" data-target="#logModal">Audit log</button>
        <button onclick="print_page(<?php echo $shipment->id;?>)" class="btn btn-xs pull-left btn-primary" data-id="{{$shipment->id}}"><i class="fa fa-print"></i> Print</button>
      
      </td>
    </tr>
    @endforeach
      