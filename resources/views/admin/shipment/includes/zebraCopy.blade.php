<div id="DivIdToPrint" style="box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
    padding:2mm;margin: 0 auto;width: 104mm; background: #FFF;border:1px solid silver;min-height:400px;
    ::selection {background: #f31544; color: #FFF;}::moz-selection {background: #f31544; color: #FFF;}">

    <div style="width:100%;float:left;border-bottom: 1px solid silver;margin-bottom: 11px;padding:4px;">
      <div style="width:23%;float:left;border-right: 1px solid silver;margin-right: 2%;">
        <img class="logo" style="max-width:100%" src="/images/{{basic_information()->company_logo}}"/></div>
      <div style="width:75%;float:left;">
      <h6 style="margin: 0"><b>Merchant</b>:  {{$shipment->user->first_name}} {{$shipment->user->last_name}}</h6> 
      <i>{{$shipment->user->address}}</i>  <br>
      <h6 style="margin: 0">{{$shipment->user->phone}}</h6>
      </div> 
    </div> <hr style="border-bottom:1px solid; margin:5px 0px">

    <div style="width:100%;float:left;border-bottom: 1px solid silver;margin-bottom: 11px;padding:4px;">
      <div style="width:63%;float:left;border-right: 1px solid silver;margin-right: 2%;">
        <h6 style="margin: 0"><b>Customer</b>:  {{$shipment->name}}</h6> 
        <h6 style="margin: 0">{{$shipment->phone}}</h6>
        <i>{{$shipment->address}}</i> 
        
      </div> 

      <div style="width:35%;float:left;">
         Area: {{$shipment->area->name}} <br>
         Hub: {{$shipment->area->hub->name}}
      </div>
    </div>

    <div style="width:100%;float:left;margin-bottom: 11px;padding:4px;border-bottom:1px solid silver; margin-bottom:10px">
      <div style="width:50%;float:left">
        <h6 style="margin: 0"><b>Invoice ID: </b> {{$shipment->invoice_id}}</h6>         
      </div> 
      <div style="width:50%;float:left;">
        <h6 style="margin: 0"><b>Cash: </b>  {{$shipment->total_price}}</h6>       
      </div>
    </div> 
    

    
    {{-- <div id="bot">
        <div id="table">
            <table class="table-bordered" style="width:100%;float:left;text-align:center">
                <tr class="tabletitle" style="border-bottom:1px solid silver">
                    <th>Qty</th> <th> Type</th>
                    <th>Weight</th><th>Value</th>
                </tr>
                <tr style="border-bottom:1px solid silver">
                    <td>1</td>
                    <td>@if($shipment->delivery_type=='1') Regular @else Express @endif</td>
                    <td>{{$shipment->weight}} Kg</td>
                    <td>{{$shipment->paracel_value}}</td>
                </tr>
                <tr class="tabletitle" style="border-bottom:1px solid silver">
                    <td></td>
                    <td class="Rate"><h2>Total</h2></td>
                    <td class="payment"><h2>{{$total_price}}</h2></td>
                </tr>
            </table>
        </div>

        <div id="legalcopy">
            <p class="legal"><strong>Thank you for your business!</strong> . 
            </p>
        </div>
    </div> --}}

    
      <div class="info" style="width:100%;float:left;margin-bottom: 11px;padding:4px;"> 
        <center>
            <?php echo DNS1D::getBarcodeHTML($shipment->tracking_code, 'UPCA'); ?>
            Tracking-code: {{$shipment->tracking_code}} </center>
      </div>
      <link href="{{asset('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
  </div>