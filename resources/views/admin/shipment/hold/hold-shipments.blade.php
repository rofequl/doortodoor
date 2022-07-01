@extends('admin.layout.app')
@section('title','Hold shipment List')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left"><h3>{{$type}} Shipment List</h3></div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="x_panel">
                        <div class="x_content">
                            <input type="search" id="invoiceID" placeholder="Invoice ID" >
                            <?php $riders = \DB::table('drivers')->select('id','first_name','last_name','phone')->get();?>
                            
                            <select id="rider" style="padding:4.3px;">
                                <option value="">Choose Rider</option>
                                @foreach ($riders as $rider)
                                    <option value="{{$rider->id}}">{{$rider->first_name.' '.$rider->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="x_content part1"> </div>
                    </div> 
                </div>
                <div class="col-md-6">
                    <div class="x_panel">
                        <div class="x_content part2"></div>
                    </div> 
                </div>
            </div>
        </div>
    </div>


@endsection
@push('style')
    <style> .table{ border:1px solid sienna} </style>   
@endpush

@push('scripts')
<script>
    $(".part1").load('/admin/driver-hub-shipment-rows/<?php echo $type;?>');
    $(".part2").load('/admin/hold-shipment-rows/<?php echo $type;?>');
    $(function(){
        $('#invoiceID').keypress(function (e) {
            if (e.which == '13') {
                $('#invoiceID').prop('disabled',true); let invoiceID = $(this).val();
                $(".part1").html('Working...');$(".part2").html('Working...');
                $.ajax({
                    type: "get",url: '/admin/hold-agentDispatch-to-driverAssign-withInvoice/'+invoiceID,
                    success: function(data){
                        $(".part1").load('/admin/driver-hub-shipment-rows/<?php echo $type;?>');
                        $(".part2").load('/admin/hold-shipment-rows/<?php echo $type;?>');
                        $('#invoiceID').val('');
                    },error: function (request, error) { alert(error);},
                });
                $('#invoiceID').prop('disabled',false);
            }
        });

        $('#rider').change(function (e) {
            $(this).prop('disabled',true); let rider_id = $(this).val();
            $(".part1").html('Working...');$(".part2").html('Working...');
            $.ajax({
                type: "get",url: '/admin/hold-agentDispatch-to-driverAssign-rider/'+rider_id,
                success: function(data){
                    $(".part1").load('/admin/driver-hub-shipment-rows/<?php echo $type;?>');
                    $(".part2").load('/admin/hold-shipment-rows/<?php echo $type;?>');
                },error: function (request, error) { alert(error);},
            });
            $('#rider').prop('disabled',false);
        });
    })
</script>
@endpush
