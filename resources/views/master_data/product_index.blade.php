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
                                        <a class="btn btn-primary" href="{{ route($route_create) }}"><i class="fa fa-plus"></i> Add Product</a>
                                    @endif
                                </h3>
                            </div>          
                        </div>
                    </div>
                    
                    <div class="table-responsive pos-table" data-delete-url="{{ $route_destroy }}" data-remark="product">
                        <table class="table table-striped- table-bordered table-hover" id="product-table">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th width="200px">Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Code</th>
                                    <th>Cost</th>
                                    <th>Price</th>
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
        var t = $('#product-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ $url_ajax_datatable }}',
            columns: [
                {data: 'rownum', searchable: false},
                {data: 'name', name:'products.name'},
                {data: 'product_category_name', name:'product_categories.name'},
                {data: 'brand_name', name:'brands.name'},
                {data: 'code', name:'products.code'},
                {data: 'cost', name:'products.cost'},
                {data: 'price', name:'products.price'},
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
        $('div#products-table_length.dataTables_length').css("margin-bottom", "10px");
        $('div.col-xs-6').addClass("col-sm-6").removeClass('col-xs-6');
        $('.sorting').addClass("no-sortable");
    });

    $('div#product-table_length.dataTables_length').css("margin-bottom", "10px");
    </script>

@endsection