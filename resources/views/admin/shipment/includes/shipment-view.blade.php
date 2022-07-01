@extends('admin.layout.app')
@section('title','Agent dispatch center')
@section('content')
<div class="right_col" role="main">
    <div class="x_panel">
        @include('admin.shipment.includes.zebra-gt800')

        <div class="row">
          <button value='Print' onclick='printDiv();' class="btn btn-info pull-right"><i class="fa fa-print"></i> Print Invoice</button>
        </div>
    </div>
</div>
@endsection
