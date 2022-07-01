@foreach ($shipments as $item)
    <table class="table tbl2{{$item->shipment_id}}">
        <tr><td><b>Customer Name: </b>{{$item->shipment->name}}</td></tr>
        <tr><td><b>Invoice ID: </b>{{$item->shipment->invoice_id}} </td></tr>
        <tr><td><b>Tracking Code: </b>{{$item->shipment->tracking_code}}</td></tr>
        <tr><td><b>Parcel Value: </b>{{$item->shipment->total_price}}
            <button class="btn btn-info btn-xs pull-right mb{{$item->shipment_id}}" onclick="move(<?php echo $item->shipment_id;?>)"><i class="fa fa-long-arrow-left"></i> Move back</button>
        </td></tr>
    </table>
@endforeach
@if($shipments->count()>0)
<tr><td><a href="/admin/sendToSorting-hold_shipment" class="btn btn-warning pull-right">Send to Sorting</a></td></tr>
@endif
<script>
    function move(shipment_id){
        $('.mb'+shipment_id).text('Moving..');
        $('.mb'+shipment_id).prop('disabled',true);
        $.ajax({
            type: "get",url: '/admin/move-back-to-hold_shipment/'+shipment_id+'/<?php echo $type;?>',
            success: function(data){
                $('.tbl2'+shipment_id).remove();
                $(".part1").load('/admin/driver-hub-shipment-rows/<?php echo $type;?>');
            },error: function (request, error) {
                alert(" Can't do because: " + error);
            },
        });
    }
</script>