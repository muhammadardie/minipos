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
                        <table class="table table-striped- table-bordered table-hover" id="role-menu-table">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Role Name</th>
                                    <th>Menu</th>
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
    var load = 0;
    $(function() {
        var t = $('#role-menu-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ $url_ajax_datatable }}',
            columns: [
                {data: 'rownum', searchable: false},
                {data: 'name'},
                {data: 'menu_name', orderable: false, searchable: false},
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
        $('div#role-menu-table_length.dataTables_length').css("margin-bottom", "10px");
        $('div.col-xs-6').addClass("col-sm-12");
        $('div.col-xs-6').addClass("col-sm-6").removeClass('col-xs-6');
        $('.sorting').addClass("no-sortable");

    });

    $('div#role-menu-table_length.dataTables_length').css("margin-bottom", "10px");
    </script>

@endsection