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
                    
                    <div class="table-responsive pos-table" data-delete-url="{{ $route_destroy }}" data-remark="purchase-order">
                        <table class="table table-striped- table-bordered table-hover" id="purchase-order-table">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th width="200px">No PO</th>
                                    <th>Supplier</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
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
        var t = $('#purchase-order-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ $url_ajax_datatable }}',
            columns: [
                {data: 'rownum', searchable: false},
                {data: 'po_number', name:'purchasing_orders.po_number', className: 'po-name'},
                {data: 'supplier_name', name:'suppliers.name'},
                {data: 'fullname', name:'employees.first_name'},
                {data: 'date_created', name:'purchasing_orders.created_at'},
                {data: 'total', name:'purchasing_orders.total'},
                {data: 'received', name:'purchasing_orders.received'},
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
        $('div#purchase-order-table_length.dataTables_length').css("margin-bottom", "10px");

        $('body').on('click', '.set-return', function(){
            let poName = $(this).parent().parent().parent().parent().find('.po-name').html();
            let url    = $(this).attr('data-url');
            let id     = $(this).attr('data-id');

            Swal.fire({
              title: 'Are you sure you want to return order '+ poName +'?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#34bfa3',
              cancelButtonColor: '#a6a7c1',
              confirmButtonText: 'Yes, return order!'
            }).then((result) => {
                if (result.value) {

                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        data: { 'id': id},
                        success: function(response) {
                            if(response == 'success'){
                                swal(
                                "Success!",
                                "Order has been returned!",
                                "success"
                                )
                                $('#purchase-order-table').DataTable().ajax.reload();
                            } else {
                                swal(
                                "Internal Error",
                                "Oops, order failed to return", // had a missing comma
                                "error"
                                )
                            }
                            
                        },
                        failure: function (response) {
                            swal(
                            "Internal Error",
                            "Oops, order failed to return", // had a missing comma
                            "error"
                            )
                        }
                    });

                }
            })    
        })
        

    });

    $('div#purchase-order-table_length.dataTables_length').css("margin-bottom", "10px");
    </script>

@endsection