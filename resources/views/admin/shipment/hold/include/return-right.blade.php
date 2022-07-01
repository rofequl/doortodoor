@foreach($hubs as $key=>$hub)
    <div class="row hub{{$hub->id}}" style="background:#f7f7f7;margin-bottom:1em">
    <div class="col-md-6">
        <p class="alert">
        Hub: {{$hub->name}} <br>Number of parcels: <b class="num{{$hub->id}}">{{ return_hub_count($hub->id,'assigning')}}</b>
        </p>
    </div>
    <div class="col-md-6 m-b-0 m-t-5">

        <button class="btn btn-xs btn-info form-control s{{$hub->id}}" onclick="sorting(<?php echo $hub->id;?>)">Send to sorting</button>

        <button class="btn btn-xs btn-default form-control viewParcel" data-toggle="modal" data-target="#viewParcel" data-hub_id="{{$hub->id}}">View Parcels</button>

        <div class="result2"></div>
    </div>
    </div>
@endforeach



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


<script>
    $('.viewParcel').on('click',function(){
      let id = $(this).data('hub_id');
      $('.hub-shipments').html('Loading...');
      $.ajax({
        type: "get",url: '/admin/return-shipments-parcels/'+id,
        success: function(data){$('.hub-shipments').html(data);}
      });
    });
    function sorting(hub_id){
      $('.s'+hub_id).text('Sorting progress...');
      $('.s'+hub_id).prop('disabled',true);
      $.ajax({
        type: "get",url: '/admin/return-sorting/'+hub_id,
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
</script>