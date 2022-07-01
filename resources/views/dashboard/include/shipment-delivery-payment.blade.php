@extends('dashboard.layout.app')
@section('pageTitle','payment info')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">  Shipment Payment</div> <br>
                <div class="container table-responsive">
                    <table id="shipmnets" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                        <tr>
                            <th>##</th>  <th>Shipment info</th>
                            <th>Payment by</th>
                            <th>Amount</th> <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $key=>$payment)
                               <tr>
                                   <td>{{$key+1}}</td>
                                   <td>Customer: {{$payment->shipment->name}} <br>
                                    InvoiceID: {{$payment->shipment->invoice_id}} <br>
                                    </td>
                                    <td>
                                        {{$payment->admin->first_name.' '.$payment->admin->last_name}}
                                    </td>
                                    <td>{{$payment->amount}} Tk</td>
                                    <td>{{date('M d, Y',strtotime($payment->created_at))}}</td>
                               </tr>
                            @endforeach

                            @if ($payments->count() <1)
                                <tr><td colspan="5">No payment for this parcel by admin</td></tr>                                
                            @endif
                        </tbody>
                    </table> 
                </div>
                <div class="d-block text-center card-footer">

                </div>
            </div>
        </div>
    </div>
@endsection
