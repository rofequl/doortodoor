@extends('dashboard.layout.app')
@section('pageTitle', 'Shipment view')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fa fa-truck text-success">
                    </i>
                </div>
                <div> @include('dashboard.include.shipping-status',['status'=>$shipment->status,'shipping_status'=>$shipment->shipping_status])
                    <div class="page-title-subheading">The shipment current status
                    </div>
                </div>
            </div>
        </div>
    </div>
<div id="DivIdToPrint">
    <link href="{{asset('dashboards/main.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/plugins/font-awesome-4.6.1/css/font-awesome.min.css')}}"/>

    <div class="row">
        <div class="col-6">
            <?php echo DNS1D::getBarcodeHTML($shipment->tracking_code, 'UPCA'); ?>
            Tracking-code: {{$shipment->tracking_code}}
        </div>
        <div class="col-6 text-right">
            {{date('F m, Y',strtotime($shipment->created_at))}}
        </div>
    </div>
    <br>
    <div class="row">
         <div class="col-5">Merchant information <hr>
            <p><b class="text-success"><i class="fa fa-user"></i> {{$shipment->user->first_name}} {{$shipment->user->last_name}}</b> <br>
            <i class="fa fa-phone-square"></i> {{$shipment->user->phone}} <br>
            <i class="fa fa-envelope"></i> {{$shipment->user->email}} <br>
            <i class="fa fa-map-marker"></i> {{$shipment->user->address}} </p> 
         </div>
         <div class="col-2 text-center"><i style="font-size:2em;" class="fa fa-long-arrow-right"></i></div>
         <div class="col-5">Customer information <hr>
            <p><b class="text-success"><i class="fa fa-user"></i> {{$shipment->name}}</b> <br>
            <i class="fa fa-phone-square"></i> {{$shipment->phone}} <br>
            <i class="fa fa-map-marker"></i> {{$shipment->address}} </p> 
         </div>
    </div> 

    <div class="row" style="margin-top:1em">
        <div class="col-12">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>No. of Piece</th>
                    <th>Shipping Type</th>
                    <th>Weight</th>
                    <th>Good Value</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{$shipment->delivery_type}}</td>
                        <td>{{$shipment->weight}}</td>
                        <td>{{$shipment->paracel_value}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row" style="margin-top:1em">
         <div class="col-4">
            <p>Service-type: @if($shipment->delivery_type=='1') Regular Delivery @else Express delivery @endif
         </div>
         <div class="col-4">
            Price: {{$total_price}}
         </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
         <button value='Print' onclick='printDiv();' class="btn btn-info pull-right"><i class="fa fa-print"></i> Print Invoice</button>
     </div>
</div>
@endsection

<script type="text/javascript">
    function printDiv() 
    {

      var divToPrint=document.getElementById('DivIdToPrint');

      var newWin=window.open('','Print-Window');

      newWin.document.open();

      newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

      newWin.document.close();

      setTimeout(function(){newWin.close();},10);

    }
</script>