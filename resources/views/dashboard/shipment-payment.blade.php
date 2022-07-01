@extends('dashboard.layout.app')
@section('pageTitle','payment info')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">  Your Shipment </div> <br>
                <div class="container table-responsive">
                    <table id="shipmnets" class="align-middle mb-0 table table-borderless table-striped table-hover text-center">
                        <thead>
                        <tr>
                            <th>##</th>  <th>Tracking No.</th>
                            <th>Invoice No</th> <th>Payment-by</th>
                            <th>Amount</th> <th class="text-right">Actions</th>
                        </tr>
                        </thead>
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
    .btnNew{
        width: auto;  padding: 0px;
        border: 0px; color: blue;
    }
    .btnNew:hover{color:sienna}
    /*.app-theme-white .app-sidebar {z-index: 5;}*/
</style>
@endpush

@push('script')

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    function modal_btn_click() {
        $('#myModal').modal({ show: true });
    }
    $(function(){
        $('#dashboardDatatable').dataTable({
            order: [ [0, 'desc'] ]
        })

      // get data
        $(function () { table.ajax.reload(); });
        let table = $('#shipmnets').DataTable({
            processing: true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span>'
            },
            serverSide: true,ajax: "{{route('payments-load')}}",
            order: [ [0, 'desc'] ],
            columns: [
                {data: 'id'},
                {data: 'tracking_code'},
                {data: 'invoice_no'},
                {data: 'payment_by'},
                {data: 'amount'},
                {data: 'action', orderable: false, searchable: false, class:'text-right'}
            ]
        });

        $('#shipmnets').on('click', '.btnNew' ,function(e){
            let id = $(this).attr('id')
           window.open('/show-payment/'+id, 'Merchant Payment'); 
        })
    })
</script>
@endpush