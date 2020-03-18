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
                                        <a class="btn btn-primary" href="{{ route($route_create) }}"><i class="fa fa-plus"></i> Add Role</a>
                                    @endif
                                </h3>
                            </div>          
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover" id="role-table">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Name</th>
                                    <th>Description</th>
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
        var t = $('#role-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ $url_ajax_datatable }}',
            columns: [
                {data: 'rownum', searchable: false},
                {data: 'name'},
                {data: 'description'},
                {data: 'action', orderable:false, searchable: false},
            ],
            "drawCallback": function(settings) {
                //
            },            
            pageLength: 10,
            "order": [[ 1, 'asc' ]],
            stateSave: true,
        });

        $('.dataTables_wrapper .col-xs-12:first').removeClass();
        $('div#role-table_length.dataTables_length').css("margin-bottom", "10px");
        $('div.col-xs-6').addClass("col-sm-6").removeClass('col-xs-6');
        $('.sorting').addClass("no-sortable");

    });

    $('div#role-table_length.dataTables_length').css("margin-bottom", "10px");

    $(document).ready(function(){
        $('body').on('click', '.delete_this', function(){
            var role_id = $(this).attr('data-role');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN':   $('meta[name="csrf-token"]').attr('content')
                }
            });

            swal({
                title: "Are you sure?",
                text: "You can't undo this process!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonText: "Cancel",
                confirmButtonText: "Yes, delete it!"
                })
                .then( function (result) {
                    if (result.value) {  
                        $.ajax({
                            type: "DELETE",
                            dataType: "JSON",
                            url: ' {{ $route_destroy }}/'+role_id,
                            success: function(data){
                                if(data === true){
                                    swal("Success!", "Role has been deleted", "success");
                                    $('#role-table').DataTable().ajax.reload();
                                } else {
                                    console.log(data);
                                    swal("Failed!", "Unable to delete role.", "error");
                                }
                            }
                        });
                    }
                  
                });
        });
    });
    </script>

@endsection