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
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover" id="menu-permission-table">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Role Name</th>
                                    <th>Menu Name</th>
                                    <th>Permission</th>
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
        var t = $('#menu-permission-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ $url_ajax_datatable }}',
            columns: [
                {data: 'rownum', searchable: false},
                {data: 'role_name', name: 'roles.name'},
                {data: 'menu_name', searchable: false,  orderable: false},
                {data: 'permission_name', orderable: false, searchable: false},
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
        $('div#menu-permission-table_length.dataTables_length').css("margin-bottom", "10px");
        $('div.col-xs-6').addClass("col-sm-6").removeClass('col-xs-6');
        $('.sorting').addClass("no-sortable");
    });

    $('div#menu-permission-table_length.dataTables_length').css("margin-bottom", "10px");

    $(document).ready(function(){
        //$( "input[type='search']" ).prop( "disabled", true );
    });
    </script>

@endsection