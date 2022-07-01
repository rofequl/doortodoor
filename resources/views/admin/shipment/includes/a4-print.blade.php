<div class="row">
    <div class="col-6">
        <p><?php echo DNS1D::getBarcodeHTML($shipment->tracking_code, 'UPCA'); ?></p>
        Tracking-code: {{$shipment->tracking_code}}
    </div>
    <div class="col-6 text-right">
        {{date('F m, Y',strtotime($shipment->created_at))}}
    </div>
</div>
<br>

<div class="row">
     <div class="col-md-5">Merchant information <hr>
        <p><b class="text-success"><i class="fa fa-user"></i> {{$shipment->user->first_name}} {{$shipment->user->last_name}}</b> <br>
        <i class="fa fa-phone-square"></i> {{$shipment->user->phone}} <br>
        <i class="fa fa-envelope"></i> {{$shipment->user->email}} <br>
        <i class="fa fa-map-marker"></i> {{$shipment->user->address}} </p> 
     </div>
     <div class="col-md-2 text-center"><i style="font-size:2em;" class="fa fa-long-arrow-right"></i></div>
     <div class="col-md-5">Customer information <hr>
        <p><b class="text-success"><i class="fa fa-user"></i> {{$shipment->name}}</b> <br>
        <i class="fa fa-phone-square"></i> {{$shipment->phone}} <br>
        <i class="fa fa-map-marker"></i> {{$shipment->address}} </p> 
     </div>
</div> 

<div class="row" style="margin-top:1em">
    <div class="col-md-12">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>No. of Piece</th>
                <th>Shipping Type</th>
                <th>Weight</th>
                <th>Good Value</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{$shipment->delivery_type}}</td>
                    <td>{{$shipment->weight}}</td>
                    <td>{{$shipment->paracel_value}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row" style="margin-top:1em">
   <div class="col-md-4">
      <p>Service-type: @if($shipment->delivery_type=='1') Regular Delivery @else Express delivery @endif
   </div>
   <div class="col-md-4">
      Price: {{$total_price}}
   </div>
</div>