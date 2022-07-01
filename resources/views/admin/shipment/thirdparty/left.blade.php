@foreach ($shipments as $item)
<table class="table table-bordered" id="{{$item->id}}">
    <tr><td>Customer Name: {{$item->shipment->name}}</td> </tr>
    <tr><td>Invoice ID: {{$item->shipment->invoice_id}}</td></tr>
        
    <tr><td>Price: @if($item->shipment->price=='0') Pay by merchant @else Pay by customer @endif
        {{$item->shipment->price}}
        <button class="btn pull-right btn-xs btn-info {{$item->id}}"  onClick="moveToRight(<?php echo $item->id?>)"> 
            Move <i class="fa fa-long-arrow-right"></i></button>
    </td>
    </tr>
</table>
@endforeach

<script type="text/javascript">
    function moveToRight(third_id){
        $(".right-side").html('Working.....');
        $('.'+third_id).html('Moving..');
        $('.'+third_id).prop('disabled', true);
        $.ajax({
          type: "get",url: '/admin/thirdparty-moveTo-right/'+third_id,
          success: function(data){
            $('#'+third_id).remove();
            $(".right-side").load('/admin/thirdparty-right/<?php echo $hub->id;?>');
            $('.'+third_id).html('Move <i class="fa fa-long-arrow-right"></i>')
            $('.'+third_id).prop('disabled', false);
          }
        });
    }   
</script>