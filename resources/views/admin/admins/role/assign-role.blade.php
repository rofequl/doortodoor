@extends('admin.layout.app')
@section('title','Employee information')
@section('content')
    <div class="right_col" role="main">
        <div class="page-title">
            <div class="title_left">
                <h3>Admin-Roles dataTable</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{$error}}
                </div>
            @endforeach
        @endif
        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead>
                                <tr class="bg-dark">
                                    <th>Employee info</th>
                                    <th class="text-right">Role info</th>
                                </tr>
                                </thead>
                                @foreach($employees as $employe)
                                <tr>
                                    <td><b>{{$employe->first_name.' '.$employe->last_name}}</b> [ {{$employe->email}} ]-[ {{$employe->phone}} ] <br>
                                    <b>Join date: </b> {{date('F j Y',strtotime($employe->created_at))}}</td>
                                    <td class="text-right"><button data-toggle="modal" data-target=".add" class="btn view" data-id="{{$employe->id}}"><i class="fa fa-eye-slash"></i> Check roles</button></td>
                                </tr>
                                @endforeach
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade add" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
    	        <h5 class="modal-title" id="exampleModalLabel">Access routes for an employee
    	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    	          <span aria-hidden="true">&times;</span>
    	        </button> </h5>
    	    </div>
    	    <div class="modal-body">
    	    	<form id="save_change" method="post">@csrf
    	    		<span class="form_result">Loading...</span>
                    
    	    		<button class="btn btn-info pull-right" type="submit"><i class="fa fa-spinner"></i> Save Changes</button>
    	    	</form>
    	    </div>
        </div>
      </div>
    </div>


@endsection

@push('scripts')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function () {
            $('.view').on('click',function(e){
                let id = $(this).data('id');
                $('.form_result').html('Working....')
                $.ajax({
                    type: "get", url:"/admin/get-employee-roles/"+id,
                    success: function(data){
                        $('.form_result').html(data)
                    }
                });
            });
        });

    </script>
@endpush
