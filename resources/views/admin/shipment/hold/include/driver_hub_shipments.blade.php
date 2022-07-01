@foreach ($shipments as $item)
    <table class="table tbl{{$item->shipment_id}}">
        <tr><td><b> Customer Name: </b>{{$item->shipment->name}}</td></tr>
        <tr><td><b>Invoice ID: </b>{{$item->shipment->invoice_id}}
        <i class="pull-right"><strong>{{$type}}</strong> at {{date('M d, Y H:i',strtotime($item->created_at))}}</i>
        </td></tr>
        <tr><td><b>Tracking Code: </b>{{$item->shipment->tracking_code}}</td></tr>
        <tr><td><b>Parcel Value: </b>{{$item->shipment->total_price}}
            <button class="btn btn-info btn-xs pull-right m{{$item->shipment_id}}" onclick="moveback(<?php echo $item->shipment_id.','.$item->hub_shipment_box->hub->id;?>)">Move <i class="fa fa-long-arrow-right"></i> </button>
        </td></tr>
    </table>
@endforeach

<script>
    function moveback(shipment_id,hub_id){
        $('.m'+shipment_id).text('Moving..');
        $('.m'+shipment_id).prop('disabled',true);
        // alert('Hi');return false;
        $.ajax({
            type: "get",url: '/admin/move-to-hold_shipment/'+shipment_id+'/'+hub_id,
            success: function(data){
                $('.tbl'+shipment_id).remove();
                $(".part2").load('/admin/hold-shipment-rows/<?php echo $type;?>');
            },error: function (request, error) {
                alert(" Can't do because: " + error);
            },
        });
    }
</script>