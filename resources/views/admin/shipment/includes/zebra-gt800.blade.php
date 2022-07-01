<div id="DivIdToPrint">
    
  <div id="invoice-POS">
    
    <center id="top">
      <div class="info"> 
            <?php echo DNS1D::getBarcodeHTML($shipment->tracking_code, 'UPCA'); ?>
            Tracking-code: {{$shipment->tracking_code}}
      </div><!--End Info-->
    </center><!--End InvoiceTop-->
    
    <div id="mid">
      <div class="info">
        <h2>Merchant information </h2>
        <p> Name   : {{$shipment->user->first_name}} {{$shipment->user->last_name}} <br>
            Email   : {{$shipment->user->email}} </br>
            Phone   : {{$shipment->user->phone}} </br>
            Date    : {{date('F m, Y',strtotime($shipment->created_at))}} <br>
        </p>
      </div>
    </div>
    
    <div id="bot">
        <div id="table">
            <table style="width:100%;float:left;text-align:center">
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
    </div>
  </div>
<style>
#invoice-POS{
    box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
    padding:2mm;
    margin: 0 auto;
    width: 104mm;
    background: #FFF;
    
    
    ::selection {background: #f31544; color: #FFF;}
    ::moz-selection {
        background: #f31544; color: #FFF;
    }

    h1{
        font-size: 1.5em;
        color: #222;
    }
    h2{font-size: .9em;}
    h3{
    font-size: 1.2em;
    font-weight: 300;
    line-height: 2em;
    }
    p{
    font-size: .7em;
    color: #666;
    line-height: 1.2em;
    }
    
    #top, #mid,#bot{ /* Targets all id with 'col-' */
    border-bottom: 1px solid #EEE;
    }

    #top{min-height: 100px;}
    #mid{min-height: 80px;} 
    #bot{ min-height: 50px;}

    .info{
    display: block;
    //float:left;
    margin-left: 0;
    }
    .title{
    float: right;
    }
    .title p{text-align: right;} 
    table{
    width: 100%;
    border-collapse: collapse;
    }
    td{
    //padding: 5px 0 5px 15px;
    //border: 1px solid #EEE
    }
    .tabletitle{
    //padding: 5px;
    font-size: .5em;
    background: #EEE;
    }
    .service{border-bottom: 1px solid silver;}
    .item{width: 24mm;}
    .itemtext{font-size: .5em;}

    #legalcopy{
    margin-top: 5mm;
    }
}
</style>
</div>

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