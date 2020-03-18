@extends('layouts.base')
    @section('content')
    <!-- BEGIN CONTENT -->
    <div class="m-content">
        <div class="row">
            <div class="col-md-12"> 
                <!--begin::Portlet-->
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                    <i class="flaticon-search-1"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Detail Purchase Order
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="m-form m-form--fit m-form--label-align-left">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2 col-sm-12">
                                Po Code
                            </label>
                            <div class="col-lg-5 col-sm-12">
                                <input type="text" class="form-control" value="{{ $purchase_orders->po_number }} "disabled>
                            </div>

                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2 col-sm-12">
                                Supplier
                            </label>
                            <div class="col-lg-5 col-sm-12">
                                <input type="text" class="form-control" value="{{ $purchase_orders->supplier->name }} "disabled>
                            </div>
                        </div>     
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2 col-sm-12">
                                Ordered By
                            </label>
                            <div class="col-lg-5 col-sm-12">
                                <input type="text" class="form-control" value="{{ $purchase_orders->employee->fullname }} "disabled>
                            </div>
                        </div>   
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2 col-sm-12">
                                Date Ordered
                            </label>
                            <div class="col-lg-5 col-sm-12">
                                <input type="text" class="form-control" value="{{ \Helper::tglIndo($purchase_orders->created_at) }} "disabled>
                            </div>
                        </div>   
                        @foreach($purchase_orders->purchase_order_detail as $pur_det)                
                            <div class="form-group m-form__group row form-repeat">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    @if($loop->iteration == 1)
                                        Order
                                    @endif
                                </label>
                                
                                    <div class="col-lg-3 col-sm-12 for-count">
                                        <input type="text" class="form-control" value="{{ $pur_det->product->name }} "disabled>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <input type="text" class="form-control" value="{{ $pur_det->qty }} "disabled>
                                    </div>
                                    <div class=" col-lg-2 col-sm-12 input-group m-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp </span>
                                        </div>
                                        <input type="text" class="form-control m-input" value="{{ \Helper::number_formats($pur_det->total, 'view', 0) }}" disabled>
                                    </div>
                            </div>
                        @endforeach
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2 col-sm-12">
                                Total
                            </label>
                            <div class="input-group m-input-group col-lg-5 col-sm-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp </span>
                                </div>
                                <input type="text" class="form-control m-input" value="{{ \Helper::number_formats($purchase_orders->total, 'view', 0) }}" disabled>
                            </div>
                        </div>   
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-10 ml-lg-auto">
                                    <a href="{{ route($route_index) }}" class="btn btn-metal">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
               </div>  
                <!--end::Portlet-->    
            </div>
        </div>
    </div>
@endsection