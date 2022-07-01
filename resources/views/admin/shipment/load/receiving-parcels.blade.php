@foreach($shipments as $key=>$shipment)
    @if(is_shipment_On_dispatch($shipment->id) <1)
        <table class="table table-xs" id="{{$shipment->id}}">
            <tbody>
            <tr>
                <td>Invoice ID: {{$shipment->invoice_id}}</td>
                <td></td>
                <td class="text-right">
                    <select class="select2 select2_single areaOp" data-key="{{$key}}" id="area{{$key}}">
                        @foreach($areas as $area)
                            <option value="{{$area->id}}" @if($shipment->area_id==$area->id)selected @endif >
                                {{$area->name}}</option>
                        @endforeach
                    </select></td>
            </tr>
            <tr>
                <td>Customer: {{$shipment->name}} </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Price: {{$shipment->price}}</td>
                <td></td>
                <td class="text-right">
                    Weight: <input style="width:100px" type="number" id="weight{{$key}}" value="{{$shipment->weight}}">
                </td>
            </tr>
            <tr>
                <td>Phone: {{$shipment->phone}} </td>
                <td></td>
                <td class="text-right hub{{$key}}">Hub: {{hub_from_area($shipment->area_id)->name}}</td>
            </tr>
            <tr>
                <td colspan="3">Address: {{$shipment->address}} </td>
            </tr>
            <tr class="text-right">
                <td class="text-left" style="width:50%">Date: <small>{{date('M d, Y',strtotime($shipment->created_at))}}
                        (<b class="text-info">{{$shipment->created_at->diffForHumans()}}</b>)</small></td>
                <td></td>
                <td>
                    <a href="{{route('shipment-print',$shipment->id)}}" class="btnPrint" target="_blank"><i
                            class="fa fa-print"></i> Print</a> &nbsp;
                    <button class="btn btn-xs btn-default"><i class="fa fa-undo"></i> Return</button>
                    <input type="hidden" id="user_id{{$key}}" value="{{$shipment->user_id}}">
                    <input type="hidden" id="hub_id{{$key}}" value="{{$shipment->area->hub_id}}">
                    <input type="hidden" id="shipment_id{{$key}}" value="{{$shipment->id}}">
                    <button class="btn btn-success btn-xs r{{$key}}" onclick="receive(<?php echo $key;?>);">Receive <i
                            class="fa fa-arrow-right"></i></button>
                </td>
            </tr>

            </tbody>
        </table>
    @endif
@endforeach
<script type="text/javascript">
    $(".btnPrint").printPage();
    $('.select2').select2({theme: "bootstrap", width: '100%'});
    $('.areaOp').on('change', function () {
        let area_id = $(this).val();
        let key = $(this).data('key');
        $.get("/admin/change-hub-with-area/" + area_id, function (data) {
            $(".hub" + key).html('Hub: ' + data.name);
            $("#hub_id" + key).val(data.id);
        });
    });

    function receive(key) {
        $('.r' + key).prop('disabled', true);
        $('.r' + key).html('Moving...');
        let user_id = $('#user_id' + key).val();
        let hub_id = $('#hub_id' + key).val();
        // alert(hub_id);
        let shipment_id = $('#shipment_id' + key).val();
        let weight = $('#weight' + key).val();
        let area = $('#area' + key).val();
        $.ajax({
            type: "get", url: '/admin/move-to-hub',
            data: {shipment_id: shipment_id, hub_id: hub_id, user_id: user_id, weight: weight, area_id: area},
            success: function (data) {
                $('.result').html(data);
                $('.r' + key).prop('disabled', false);
                $('.r' + key).html('Receive <i class="fa fa-arrow-right"></i>');
                $('#' + shipment_id).remove();
            }
        });
    }

</script>
