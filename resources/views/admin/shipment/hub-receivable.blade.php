@extends('admin.layout.app')
@section('title','Received on hub | '.$title)
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left"><h3>Dispatch Shipment List</h3></div>
            </div>
            <div class="clearfix"></div><hr>
           
            <div class="row">
                <div class="col-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="row">
                                <label for="checkAll">
                                <input id="checkAll" type="checkbox" name="checkAll"> Check All</label>

                                <button class="btn pull-right btn-xs btn-warning assignAll">Sorting all together</button>
                            </div>
                            @foreach($boxes as $key=>$box)
                            <div class="row row{{$box->id}}" style="background: #f3f3f3;margin-bottom: 1em; padding: 5px;">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-1 ids">
                                            <input type="checkbox" class="big-checkbox" id="ids" name="ids[]" value="{{$box->id}}"> 
                                                
                                        </div>
                                        <div class="col-md-11">
                                            <b>Bulk ID:</b> {{$box->bulk_id}} <br>
                                            <b>Hub:</b> {{$box->hub->name}} <br>
                                            Parcel count: <b>{{ COUNT(explode(',',$box->shipment_ids))}}</b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 text-right">
                                    <div class="row">
                                        <button class="btn btn-default" onclick="dispatch_shipments(<?php echo $box->id;?>)">View Parcels</button>

                                        <button class="btn btn-success mts{{$box->id}}" onclick="cancel_received(<?php echo $box->id;?>)">Cancel </button>

                                        <button class="btn btn-primary" onclick="sorting(<?php echo $box->id;?>)">Send to Sorting </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            @if($boxes->count() <1)<p class="alert alert-default text-center text-danger">No data available</p>@endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<!-- Modal to view hub base parcels -->
<div class="modal" id="myModal2">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Parcels view
          <button data-dismiss="modal" type="button" class="close">×</button></h4>
        </div><div class="container hub-parcles"></div>
        <div class="modal-body"></div>
        <div class="modal-footer" style="margin-top:-2em;">
          <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
      </div>
    </div>
</div>
@push('style')
<style>
    .big-checkbox { /* Double-sized Checkboxes */
      -ms-transform: scale(3); /* IE */
      -moz-transform: scale(3); /* FF */
      -webkit-transform: scale(3); /* Safari and Chrome */
      -o-transform: scale(3); /* Opera */;
        margin-top:1em;position: relative;top:21px;left:10px;
    }
</style>
@endpush
@push('scripts')
<script>
    $(function(){
        $('#checkAll').click(function () {    
            $('input:checkbox').prop('checked', this.checked);   
        });

        $('.assignAll').on('click',function(){
            var arr = $.map($('.ids input:checkbox:checked'), function(e,i) {
                return +e.value;
            });
            if(arr==''){alert('Please check some box/s '); return false;}
            $.each(arr, function(index, id) { sorting(id); });
        });
    })

    function sorting(box_id){
        $.ajax({
            type: "get",url: '/admin/sort-to-agent-dispatch/'+box_id,
            success: function(data){
                $('.row'+box_id).remove();
            }
        });
    }

    function dispatch_shipments(box_id){
        $('.hub-parcles').html('Loading...');
        $('#myModal2').modal('show');
        $.ajax({
           type: "get",url: '/admin/dispatch-box-view/'+box_id,
           success: function(data){$('.hub-parcles').html(data);}
        });
    }

    function cancel_received(box_id){
        if(confirm('Are you sure to cencel the items??')){
            $.ajax({
               type: "get",url: '/admin/back2-dispatch/'+box_id,
               success: function(data){$('.row'+box_id).remove();}
            });
        }
    }
</script>
@endpush

