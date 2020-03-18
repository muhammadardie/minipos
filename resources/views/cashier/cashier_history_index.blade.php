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
                            </div>          
                        </div>
                    </div>
                    
                    <div class="table-responsive pos-table" data-delete-url="{{ $route_destroy }}" data-remark="cashier-history">
                        <table class="table table-striped- table-bordered table-hover" id="cashier-history-table">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th width="150px">Open Cashier</th>
                                    <th width="150px">Close Cashier</th>
                                    <th>Employee</th>
                                    <th>Shift</th>
                                    <th>Start Total</th>
                                    <th>End Total</th>
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
        var t = $('#cashier-history-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ $url_ajax_datatable }}',
            columns: [
                {data: 'rownum', searchable: false},
                {data: 'start_date', name:'cashiers.created_at'},
                {data: 'end_date', name:'cashiers.updated_at'},
                {data: 'fullname', name:'employees.first_name'},
                {data: 'shift_name', name:'shifts.name'},
                {data: 'total', name:'cashiers.total'},
                {data: 'end_total', name:'cashiers.end_total'},
                {data: 'action', orderable:false, searchable: false},
            ],
            "drawCallback": function(settings) {
                //
            },            
            pageLength: 10,
            "order": [[ 2, 'asc' ]],
            // stateSave: true,
        });
        $('.dataTables_wrapper .col-xs-12:first').removeClass();
        $('div#cashier-historys-table_length.dataTables_length').css("margin-bottom", "10px");
        $('div.col-xs-6').addClass("col-sm-6").removeClass('col-xs-6');
        $('.sorting').addClass("no-sortable");
    });

    $('div#cashier-history-table_length.dataTables_length').css("margin-bottom", "10px");
    </script>

@endsection