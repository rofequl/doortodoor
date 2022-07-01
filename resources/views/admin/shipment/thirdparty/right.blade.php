@foreach ($shipments as $item)
@if($item->status_in !=null)
    <table class="table table-bordered" id="{{$item->id}}">
        <tr><td>Customer Name: {{$item->shipment->name}}</td> </tr>
        <tr><td>Invoice ID: {{$item->shipment->invoice_id}}</td></tr>
            
        <tr><td>Price: @if($item->shipment->price=='0') Pay by merchant @else Pay by customer @endif
            {{$item->shipment->price}}
            <button class="btn pull-right btn-xs btn-info {{$item->id}}" onClick="moveToLeft(<?php echo $item->id?>)"> 
                <i class="fa fa-long-arrow-left"></i> Move</button>
        </td>
        </tr>
    </table>
@endif
@endforeach

@if($shipments->count()>0)
<a href="/admin/thirdparty-sendToSort"><button class="btn btn-sm-btn-info pull-right" ><i class="fa fa-save"></i> Send to Sort</button></a>
<a href="/admin/thirdparty-csv-pdf/pdf" target="_blank"><button class="btn btn-sm-btn-info pull-right" target="_blank"><i class="fa fa-file-o"></i> Get PDF</button></a>
<a href="/admin/thirdparty-csv-pdf/csv" target="_blank"><button class="btn btn-sm-btn-primary pull-right" target="_blank"><i class="fa fa-file-o"></i> Get CSV</button></a>
@endif

<script type="text/javascript">
    function moveToLeft(third_id){
        $(".left-side").html('Working.....');
        $('.'+third_id).html('Moving..');
        $('.'+third_id).prop('disabled', true);
        $.ajax({
          type: "get",url: '/admin/thirdparty-moveTo-left/'+third_id,
          success: function(data){
            $('#'+third_id).remove();
            $(".left-side").load('/admin/thirdparty-left/<?php echo $hub->id;?>');
            $('.'+third_id).html('<i class="fa fa-long-arrow-left"></i> Move')
            $('.'+third_id).prop('disabled', false);
          }
        });
    }   


</script>