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
                                <h3 class="m-portlet__head-text">
                                    Detail Discount
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="m-form m-form--fit m-form--label-align-left">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">   
                                    Discount Type
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    <input type="text" class="form-control" value="{{ $discount->discount_type->name }} "disabled>
                                </div>

                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    Name
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    <input type="text" class="form-control" value="{{ $discount->name }} "disabled>
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('code') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    Code
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    <input type="text" class="form-control" value="{{ $discount->code }} "disabled>
                                </div>
                            </div>
                            @if($discount->discount_type_id == 2)
                                <div style="margin-top: 20px;" class="form-buy-get">
                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">Buy Product</h3>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-form-label col-lg-2 col-sm-12">
                                            &emsp;&emsp;&emsp;
                                            Product
                                        </label>
                                        <div class="col-lg-5 col-sm-12">
                                            <input type="text" class="form-control" value="{{ $discount->discount_bonus->buy_product_info->name }} "disabled>
                                        </div>

                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-form-label col-lg-2 col-sm-12">
                                            &emsp;&emsp;&emsp;
                                            Quantity
                                        </label>
                                        <div class="col-lg-5 col-sm-12">
                                            <input type="text" class="form-control" value="{{ $discount->discount_bonus->buy_qty }}" disabled>
                                        </div>
                                    </div>

                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">Get Product</h3>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-form-label col-lg-2 col-sm-12">
                                            &emsp;&emsp;&emsp;
                                            Product
                                        </label>
                                        <div class="col-lg-5 col-sm-12">
                                            <input type="text" class="form-control" value="{{ $discount->discount_bonus->get_product_info->name }}" disabled>
                                        </div>

                                    </div>
                                    <div style="margin-bottom: 20px;"class="form-group m-form__group row {{ $errors->has('buy_qty') ? 'has-error' :'' }}">
                                        <label class="col-form-label col-lg-2 col-sm-12">
                                            &emsp;&emsp;&emsp;
                                            Quantity
                                        </label>
                                        <div class="col-lg-5 col-sm-12">
                                            <input type="text" class="form-control" value="{{ $discount->discount_bonus->get_qty }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            @elseif($discount->discount_type_id == 1)
                                <div class="form-group m-form__group row form-discount-model ">
                                    <label class="col-form-label col-lg-2 col-sm-12">
                                        Discount Model
                                    </label>
                                    <div class="col-lg-5 col-sm-12">
                                        <input type="text" class="form-control" value="{{ $discount->discount_price->nominal == 0 ? 'Percent' : 'Nominal' }}" disabled>
                                    </div>

                                </div>
                                @if($discount->discount_price->nominal == 0)
                                    <div class="form-group m-form__group row form-percent {{ $errors->has('percent') ? 'has-error' :'' }}">
                                        <label class="col-form-label col-lg-2 col-sm-12">
                                            Percent
                                        </label>
                                        <div class="col-lg-5 col-sm-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="{{ $discount->discount_price->percent }}" disabled>
                                                <div class="input-group-append"><span class="input-group-text" id="basic-addon2">%</span></div>
                                            </div>
                                        </div>

                                    </div>
                                @else
                                    <div class="form-group m-form__group row form-nominal  {{ $errors->has('nominal') ? 'has-error' :'' }}">
                                        <label class="col-form-label col-lg-2 col-sm-12">
                                            Nominal
                                        </label>
                                        <div class="col-lg-5 col-sm-12">
                                            <div class="input-group">
                                                <div class="input-group-append"><span class="input-group-text" id="basic-addon2">Rp</span></div>
                                                <input type="text" class="form-control" value="{{ Helper::number_formats($discount->discount_price->nominal, 'view', 0) }}" disabled>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            @endif
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    Remark
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    <input type="text" class="form-control" value="{{ $discount->remark }}" disabled>
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

    <script type="text/javascript">
        $(document).ready(function(){
            
            <?= \Helper::number_formats('$("input[name=\'nominal\']")', 'js', 0) ?>
            <?= \Helper::number_formats('$("input[name=\'percent\']")', 'js', 0) ?>
        });
    </script>
@endsection