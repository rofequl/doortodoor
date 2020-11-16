@extends('dashboard.layout.app')
@section('pageTitle','Merchant Dashboard')
@section('content')


    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Total Shipment</div>
                        <div class="widget-subheading">All shipment request</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span>0</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-arielle-smile">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Shipment Delivered</div>
                        <div class="widget-subheading">How many shipment Delivered</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span>0</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-grow-early">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Shipment Reject</div>
                        <div class="widget-subheading">If any shipment rejected</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span>0</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    Your Shipment
                </div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover text-center">
                        <thead>
                        <tr>
                            <th class="text-center">Status</th>
                            <th>Tracking No.</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Customer</th>
                            <th class="text-center">Delivery type</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shipment as $shipments)
                            <tr>
                                <td class="text-center">
                                    @if($shipments->status == 0)

                                        <span class="badge badge-danger text-capitalize">Reject</span>
                                    @else
                                        <div class="badge badge-info text-capitalize">
                                            {{$shipments->shipping_status==0?'Label Create':''}}
                                            {{$shipments->shipping_status==1?'Pickup':''}}
                                            {{$shipments->shipping_status==2?'Dispatch Center':''}}
                                            {{$shipments->shipping_status==3?'In Transit':''}}
                                            {{$shipments->shipping_status==4?'Out for Delivery':''}}
                                            {{$shipments->shipping_status==5?'Delivered':''}}
                                        </div>
                                    @endif
                                </td>
                                <td><a style="color: #495057;text-decoration: none"
                                       href="">{{$shipments->tracking_code}}
                                    </a></td>
                                <td class="text-center">
                                    <p style="color: black;font-size: 19px"
                                       class="mb-0">{{$shipments->updated_at->format('d M')}}</p>
                                    {{$shipments->updated_at->format('Y')}}
                                </td>
                                <td class="" style="font-size: 13px">
                                    <i class="fa fa-user mr-1" aria-hidden="true"></i>{{$shipments->name}}<br>
                                    <i class="fa fa-phone-square mr-1" aria-hidden="true"></i>{{$shipments->phone}}
                                </td>
                                <td>
                                    @if($shipments->delivery_type == 1)
                                        Regular
                                    @else
                                        Express
                                    @endif
                                </td>
                                <td>
                                    @if($shipments->status == 0)
                                        <a href=""
                                           class="text-success"><i
                                                class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a><br>
                                        <a href=""
                                           class="delete text-success"><i class="fa fa-trash-o fa-2x"
                                                                          aria-hidden="true"></i></a>
                                    @else
                                        <a href=""
                                           class="w-100 btn btn-sm btn-success">
                                            VIEW
                                        </a><br>
                                        <a href=""
                                           class="btn btn-sm btn-success mt-2 w-100">LABEL</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-block text-center card-footer">

                </div>
            </div>
        </div>
    </div>

@endsection


