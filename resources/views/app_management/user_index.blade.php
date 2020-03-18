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
                                        <a class="btn btn-primary" href="{{ route($route_create) }}"><i class="fa fa-plus"></i> Add User</a>
                                    @endif
                                </h3>
                            </div>          
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover" id="user-table">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    {{-- <th data-toggle="m-tooltip" title="<code>Superadmin</code> dapat melakukan transaksi dan melihat semua project" data-html="true" data-placement="top">Owner</th> --}}
                                    <th>Owner</th>
                                    <th>Last Login</th>
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
        var t = $('#user-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ $url_ajax_datatable }}',
            columns: [
                {data: 'rownum', searchable: false},
                {data: 'fullname', name: 'employees.first_name'},
                {data: 'role_name', name: 'roles.name'},
                {data: 'email', name: 'employees.email'},
                {data: 'is_owner', name: 'users.is_owner'},
                {data: 'last_login', name: 'users.last_login'},
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
        $('div#user-table_length.dataTables_length').css("margin-bottom", "10px");
        $('div.col-xs-6').addClass("col-sm-6").removeClass('col-xs-6');
        $('.sorting').addClass("no-sortable");

    });

    $('div#user-table_length.dataTables_length').css("margin-bottom", "10px");

    $(document).ready(function(){
        $('body').on('click', '.delete_this', function(){
            var user_id = $(this).attr('data-user');
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
                            url: ' {{ $route_destroy }}/'+user_id,
                            success: function(data){
                                if(data === true){
                                    swal("Success!", "User has been deleted", "success");
                                    $('#user-table').DataTable().ajax.reload();
                                } else {
                                    console.log(data);
                                    swal("Failed!", "Unable to delete user.", "error");
                                }
                            }
                        });
                    }
                  
                });
        });
    });
    </script>

@endsection