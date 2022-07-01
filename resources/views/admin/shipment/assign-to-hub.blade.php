@extends('admin.layout.app')
@section('title','Parcel assign to hub')
@section('content')
<div class="right_col" role="main">
    <div class="row">
      <div class="col-md-12">
        <button data-toggle="modal" data-target="#extraParcel" class="pull-right btn btn-info btn-xs"><i class="fa fa-plus"></i> Add extra parcel</button>
         @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
            </div>
         @endif
      </div>
      
        <div class="col-md-6 ">
            <div class="x_panel row">
              <p>Parcel Receiving panel 
                <a href="#" class="pull-right">my-hub parcels</a>
              </p><hr>
                <!-- <button class="btn-success btn-xs btn pull-right">Move all <i class="fa fa-arrow-right"></i> </button></p><hr> -->
              <div class="receiving-parcels"></div>
            </div>
        </div>

        <div class="col-md-6 ">
            <div class="x_panel row">
              <p>Hub existing panel 
                <input type="text" name="phoneNo" placeholder="Customer phone No.">
                <input type="text" name="invoice_id" placeholder="Invoice number">
              </p> <hr>
                <div class="x_content result">
                  @foreach($hubs as $key=>$hub)
                  <div class="row hub{{$hub->id}}" style="background:#f7f7f7;margin-bottom:1em">
                    <div class="col-md-6">
                      <p class="alert">  Hub:
                        @if($hub->status=='1' && $hub->zone->status=='1') {{$hub->zone->name}} ({{$hub->name}}) @else {{$hub->name}} @endif
                        <br>Number of parcels: <b class="num{{$hub->id}}">{{ user_hub_count($hub->id,$id,'on-dispatch')}}</b>
                      </p>
                    </div>
                    <div class="col-md-6 m-b-0 m-t-5">
                      <button class="btn btn-xs btn-info form-control s{{$hub->id}}" onclick="sorting(<?php echo $hub->id;?>)">Send to sorting</button>
                      <button class="btn btn-xs btn-default form-control viewParcel" data-toggle="modal" data-target="#viewParcel" data-hub_id="{{$hub->id}}">View Parcels</button>
                      <a class="btn btn-xs btn-success form-control" href="/admin/user-hub-parcels-csv/<?php echo $hub->id.'/'.$id;?>" > <i class="fa fa-file-excel-o"></i> Get CSV</a>
                      <div class="result2"></div>
                    </div>
                  </div>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal to add new paracel-->
<div class="modal fade" id="extraParcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" method="post" action="{{route('add-parcelBy-admin')}}">@csrf
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Extra parcel
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></h5>
      </div>
      <div class="modal-body">
          @include('admin.shipment.includes.parcel-entry-form')
          <input type="hidden" name="user_id" value="{{$id}}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Parcel</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal to view hub base parcels -->
<div class="modal fade" id="viewParcel" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Parcel View</h4>
      </div>
      <div class="modal-body hub-shipments"></div>
    </div>
    
  </div>
</div>

@endsection

@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
    <style type="text/css">
        .table {margin-bottom: 10px; border:2px solid;}
        .select{padding:2px;}
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 2px; line-height: 1.42857143;
            vertical-align: middle;border-top: 1px solid #ddd;
        }
        input[type='number']{padding:2px}
        .select2 {padding: 3px;line-height: 14px;}
    </style>
    
    <link rel="stylesheet" href="{{asset('vendors/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/select2/dist/css/bootstrap4-select2.css')}}">
@endpush

@push('scripts')
  <script src="{{asset('vendors/select2/dist/js/select2.min.js')}}"></script>
 
  <script type="text/javascript">
    function sorting(hub_id){
      $('.s'+hub_id).text('Sorting progress...');
      $('.s'+hub_id).prop('disabled',true);
      $.ajax({
        type: "get",url: '/admin/hub-sorting/'+hub_id,
        success: function(data){
          $('.hub'+hub_id).remove();
          $('.result2').html(data);
          $('.s'+hub_id).text('Send to Sorting');
          $('.s'+hub_id).prop('disabled',false);
        },error: function (request, error) {
          alert(" Can't do because: " + error);
          $('.hub'+hub_id).html('<p class="alert text-danger"><i class="fa fa-times-circle"></i> Execution failed! Please try again!!</p>');
        },
      });
    }

    $(function(){

      $(".receiving-parcels").load('/admin/receiving-parcels/<?php echo $id.'/'.$status.'/'.$shipping_status;?>');

       $('.viewParcel').on('click',function(){
          let id = $(this).data('hub_id');
          $('.hub-shipments').html('Loading...');
          $.ajax({
             type: "get",url: '/admin/user-hub-parcels/'+id+'/<?php echo $id;?>',
            success: function(data){$('.hub-shipments').html(data);}
          });
       });

      // with Customer phone no 
      $('[name=phoneNo]').on('keypress',function(e) {
        if(e.which == 13) {
          $.ajax({
            type: "get",url: '/admin/move2hub-withPhone/',
            data:{phone:$(this).val(),user_id:'<?php echo $id;?>'},
            success: function(data){$('.result').html(data);
              $('[name=phoneNo]').val('');
              $(".receiving-parcels").load('/admin/receiving-parcels/<?php echo $id.'/'.$status.'/'.$shipping_status;?>');
            }
          });
        }
      });

      // with invoice_id
      $('[name=invoice_id]').on('keypress',function(e) {
        if(e.which == 13) {
          $.ajax({
            type: "get",url: '/admin/move2hub-withInvoice/',
            data:{invoice_id:$(this).val(),user_id:'<?php echo $id;?>'},
            success: function(data){$('.result').html(data);
              $('[name=invoice_id]').val('');
              $(".receiving-parcels").load('/admin/receiving-parcels/<?php echo $id.'/'.$status.'/'.$shipping_status;?>');
            }
          });
        }
      });
    });


    $(".select2").select2({
      //here my options
      }).on("select2:opening", 
        function(){
          $("#extraParcel").removeAttr("tabindex", "-1");
      }).on("select2:close", 
        function(){ 
          $("#extraParcel").attr("tabindex", "-1");
      })
   
  </script>
@endpush
