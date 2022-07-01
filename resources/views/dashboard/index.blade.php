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
                        <?php $shipments = \DB::table('shipments')->where('user_id',Auth::guard('user')->user()->id)->count();?>
                        <div class="widget-numbers text-white"><span> {{ $shipments }}</span></div>
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
                         <?php $delivered = \DB::table('shipments')->where('user_id',Auth::guard('user')->user()->id)
                         ->where('shipping_status','6')->orWhere('shipping_status','6.5')->count();?>
                        <div class="widget-numbers text-white"><span> {{$delivered}}</span></div>
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
                        <?php $rejected = \DB::table('shipments')->where('user_id',Auth::guard('user')->user()->id)
                         ->where('shipping_status','5')->count();?>
                        <div class="widget-numbers text-white"><span> {{$rejected}}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">  Your Shipment </div> <br>
                <div class="container table-responsive">
                    <table id="dashboardDatatable" class="align-middle mb-0 table table-borderless table-striped table-hover text-center">
                        <thead>
                        <tr>
                            <th>##</th>
                            <th class="text-center">Status</th>
                            <th>Tracking No.</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Customer</th>
                            <th class="text-center">Delivery type</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shipment as $key=>$shipments)
                            <tr>
                                <td>{{$shipments->id}}</td>
                                <td class="text-center">
                                    @include('dashboard.include.shipping-status',
                                        ['status'=>$shipments->status,'shipping_status'=>$shipments->shipping_status])
                                </td>
                                <td><a style="color: #495057;text-decoration: none"
                                       href="/tracking?code={{$shipments->tracking_code}}" target="_blank">{{$shipments->tracking_code}}
                                    </a></td>
                                <td class="text-center">
                                    <p style="color: black;font-size: 15px"
                                       class="mb-0">{{$shipments->updated_at->format('d M')}}</p>
                                    {{$shipments->updated_at->format('Y')}}
                                </td>
                                <td class="" style="font-size: 13px">
                                    <i class="fa fa-user mr-1" aria-hidden="true"></i>{{$shipments->name}}<br>
                                    <i class="fa fa-phone-square mr-1" aria-hidden="true"></i>{{$shipments->phone}}
                                </td>
                                <td >
                                   @if($shipments->delivery_type=='1') Regular  @else Express @endif
                                </td>
                                <td>
                                    @if($shipments->status=='1' && $shipments->shipping_status=='0')
                                        <a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                        <a href="/edit-shipment/{{$shipments->id}}" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i></a>
                                    @endif
                                    <a href="/shipment-info/{{$shipments->id}}" class="btn btn-primary btn-sm viewMore"><i class="fa fa-search-plus"></i></a>
                                    <a href="/shipment-pdf/{{$shipments->id}}" class="btn btn-info btn-sm"><i class="fa fa-file-pdf"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table> <br>
                </div>
                <div class="d-block text-center card-footer">

                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>
<style type="text/css">
    .modal-backdrop{display:none;}
    .modal-dialog{ margin-top:6%;}
    /*.app-theme-white .app-sidebar {z-index: 5;}*/
</style>
@endpush

@push('script')

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>


<script type="text/javascript">
    $(function(){
        $('#dashboardDatatable').dataTable({
            order: [ [0, 'desc'] ]
        })
    })
</script>
@endpush