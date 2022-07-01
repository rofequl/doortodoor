<table id="datatable"class="table table-striped table-bordered dataTable no-footer dtr-inline">
    <thead>
        <tr class="bg-dark">
            <th>Date</th>
            <th>Customer info</th>
            <th>Merchant</th>
            <th>Amount</th>
            <th>Area</th>
            <th>status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shipments as $driverShipment)
            <tr>
                <td>
                    Date: {{date('M d, Y H:i',strtotime($driverShipment->created_at))}} <br>
                    TracingCode: {{$driverShipment->shipment->tracking_code}}
                </td>
                <td>
                    {{$driverShipment->shipment->name}}<br/>
                    {{$driverShipment->shipment->phone}}
                </td>
                <td>
                    {{$driverShipment->shipment->user->first_name}}
                    {{$driverShipment->shipment->user->last_name}}
                </td>
                <td>
                    @if($driverShipment->shipment->price==0)
                        Pay by merchant ({{$driverShipment->shipment->price}}) 
                    @else Pay by customer ($driverShipment->shipment->price) @endif
                </td>
                <td>{{$driverShipment->shipment->area->name}}</td>
                <td>
                    @include('dashboard.include.shipping-status',['status'=>$driverShipment->shipment->status,'shipping_status'=>$driverShipment->shipment->shipping_status])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>