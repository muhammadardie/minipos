@extends('layouts.base')
    @section('content')

    <link href="{{ asset('assets/vendors/custom/datatables-yajra/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <div class="m-content">
        <div class="row">
            <div class="col-md-12"> 
                <!--begin::Portlet-->
                @if(Session::has('alert-success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ Session::get('alert-success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                @endif
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    @if(array_key_exists('create', $list_permission))
                                        <a class="btn btn-primary" href="{{ route($route_create) }}"><i class="fa fa-plus"></i> Add Unit</a>
                                    @endif
                                </h3>
                            </div>          
                        </div>
                    </div>
                    
                    <div class="table-responsive pos-table" data-delete-url="{{ $route_destroy }}" data-remark="unit">
                        <table class="table table-striped- table-bordered table-hover" id="unit-table">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th width="200px">Name</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="clearfix"> </div>

                </div>  
                <!--end::Portlet-->    
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/vendors/custom/datatables-yajra/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/custom/datatables-yajra/datatables.bootstrap.js') }}"></script>
    <script>

    $(function() {
        var t = $('#unit-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ $url_ajax_datatable }}',
            columns: [
                {data: 'rownum', searchable: false},
                {data: 'name'},
                {data: 'remark'},
                {data: 'action', orderable:false, searchable: false},
            ],
			"drawCallback": function(settings) {
				//
            },            
            pageLength: 10,
            "order": [[ 1, 'asc' ]],
            // stateSave: true,
        });
        $('.dataTables_wrapper .col-xs-12:first').removeClass();
        $('div#unit-table_length.dataTables_length').css("margin-bottom", "10px");
    });

    $('div#unit-table_length.dataTables_length').css("margin-bottom", "10px");
    </script>

@endsection