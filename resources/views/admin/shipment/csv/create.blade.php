@extends('admin.layout.app')
@section('pageTitle','Upload CSV')
@section('content')

<div class="right_col" role="main">
	<div class="x_panel row">
		<div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="col-md-12">
                	 <i class="fa fa-file-excel-o text-success" aria-hidden="true"></i> Upload Excel file 
                     <a class="pull-right btn btn-success" href="/shopup-sample.csv" download=""><i class="fa fa-download"></i> Download sample file </a> 
                </div>
            </div>
        </div>
    </div> 

    <div class="main-card mb-3 card card-body">
    	<hr>
        <form id="upload_form" method="post" enctype="multipart/form-data">@csrf
            
            <div class="form-row">
                <div class="col-md-8 text-left">
                    <label for="name">Choose CSV-file</label>
                    <input type="file" id="name" class="form-control" name="file">
                </div>
                <div class="col-md-4 text-left">
                    <label style="width:100%"> &nbsp; </label><br>
                    <button class="btn btn-info form-control"> <i class="fa fa-upload"></i> Upload and View</button>
                </div>
            </div>
        </form>
	</div>
	</div>
	
</div>
@endsection