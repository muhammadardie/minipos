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
                                    <i class="fa flaticon-add"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Add Discount
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['route' => $route_store, 'id' => 'discount_create', 'class' => 'm-form m-form--fit m-form--label-align-left']) !!}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Discount Type
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::select('discount_type', $discount_type, null, ['class' => 'form-control select2']) }}
                                    {!! $errors->first('discount_type', '<span class="help-block error-help-block">:message</span>'); !!}
                                    <span id="loading-discount_type" style="display:none"><img src="{{ asset('assets/demo/default/media/img/misc/loading.gif') }}"></span>
                                </div>

                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Name
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::text('name', '', ['class' => 'form-control']) }}
                                    {!! $errors->first('name', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>

                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('code') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Code
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::text('code', '', ['class' => 'form-control']) }}
                                    {!! $errors->first('code', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div style="margin-top: 20px;" class="form-buy-get hidden">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title">Buy Product</h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-2 col-sm-12">
                                        &emsp;&emsp;&emsp;
                                        <span style="color:red" title="Wajib diisi">*</span>Product
                                    </label>
                                    <div class="col-lg-5 col-sm-12">
                                        {{ Form::select('buy_product', $product, null, ['class' => 'form-control select2']) }}
                                        {!! $errors->first('buy_product', '<span class="help-block error-help-block">:message</span>'); !!}
                                    </div>

                                </div>
                                <div class="form-group m-form__group row {{ $errors->has('buy_qty') ? 'has-error' :'' }}">
                                    <label class="col-form-label col-lg-2 col-sm-12">
                                        &emsp;&emsp;&emsp;
                                        <span style="color:red" title="Wajib diisi">*</span>
                                        Quantity
                                    </label>
                                    <div class="col-lg-5 col-sm-12">
                                        {{ Form::text('buy_qty', '', ['class' => 'form-control']) }}
                                        {!! $errors->first('buy_qty', '<span class="help-block error-help-block">:message</span>'); !!}
                                    </div>
                                </div>

                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title">Get Product</h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-2 col-sm-12">
                                        &emsp;&emsp;&emsp;
                                        <span style="color:red" title="Wajib diisi">*</span>
                                        Product
                                    </label>
                                    <div class="col-lg-5 col-sm-12">
                                        {{ Form::select('get_product', $product, null, ['class' => 'form-control select2']) }}
                                        {!! $errors->first('get_product', '<span class="help-block error-help-block">:message</span>'); !!}
                                    </div>

                                </div>
                                <div style="margin-bottom: 20px;"class="form-group m-form__group row {{ $errors->has('buy_qty') ? 'has-error' :'' }}">
                                    <label class="col-form-label col-lg-2 col-sm-12">
                                        &emsp;&emsp;&emsp;
                                        <span style="color:red" title="Wajib diisi">*</span>
                                        Quantity
                                    </label>
                                    <div class="col-lg-5 col-sm-12">
                                        {{ Form::text('get_qty', '', ['class' => 'form-control']) }}
                                        {!! $errors->first('get_qty', '<span class="help-block error-help-block">:message</span>'); !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row form-discount-model hidden">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Discount Model
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::select('discount_model', $discount_model, null, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'placeholder' => '-- Select Discount Model --']) }}
                                    {!! $errors->first('discount_model', '<span class="help-block error-help-block">:message</span>'); !!}
                                    <span id="loading-discount_model" style="display:none"><img src="{{ asset('assets/demo/default/media/img/misc/loading.gif') }}"></span>
                                </div>

                            </div>
                            <div class="form-group m-form__group row form-percent hidden{{ $errors->has('percent') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Percent
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    <div class="input-group">
                                        {{ Form::text('percent', '', ['class' => 'form-control']) }}
                                        {!! $errors->first('percent', '<span class="help-block error-help-block">:message</span>'); !!}
                                        <div class="input-group-append"><span class="input-group-text" id="basic-addon2">%</span></div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group m-form__group row form-nominal hidden {{ $errors->has('nominal') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Nominal
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-append"><span class="input-group-text" id="basic-addon2">Rp</span></div>
                                        {{ Form::text('nominal', '', ['class' => 'form-control']) }}
                                        {!! $errors->first('nominal', '<span class="help-block error-help-block">:message</span>'); !!}
                                    </div>
                                </div>

                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('remark') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    Remark
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::textarea('remark', '', ['class' => 'form-control']) }}
                                    {!! $errors->first('remark', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <div class="row">
                                    <div class="col-md-offset-3">
                                        <span id="execute-loading" style="visibility: hidden;"><img src="{{ asset('assets/demo/default/media/img/misc/loading.gif') }}"></span>
                                        <button type="submit" name="simpan" class="btn btn-success">Submit</button>
                                        <a href="{{ route($route_index) }}" class="btn btn-secondary">Cancel</a>
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

{!! JsValidator::formRequest('App\Http\Requests\master_data\DiscountRequest', '#discount_create') !!}

    <script type="text/javascript">
        $(document).ready(function(){
            $("select[name='discount_type']").select2({ placeholder: "{{ \Lang::get('select2.select_discount_type') }}" });
            $("select[name='buy_product']").select2({ width: "100%", placeholder: "{{ \Lang::get('select2.select_product') }}" });
            $("select[name='get_product']").select2({ width: "100%", placeholder: "{{ \Lang::get('select2.select_product') }}" });

            var form_discount_model = $(".form-discount-model");
            var form_buy_get        = $(".form-buy-get");

            $("select[name='discount_type']").on('change', function(){
                discount_type = $(this).val();
                if(discount_type == 1){ // per item order
                    form_discount_model.removeClass('hidden');
                    form_buy_get.addClass('hidden');

                    $("select[name='buy_product']").val('').trigger('change.select2');
                    $("select[name='get_product']").val('').trigger('change.select2');
                    $('input[name="buy_qty"]').val('');
                    $('input[name="get_qty"]').val('');

                } else if(discount_type == 2){ // buy and get
                    form_discount_model.addClass('hidden');
                    form_buy_get.removeClass('hidden');

                    $("select[name='discount_model']").selectpicker('val','');

                }
            });

            $("select[name='discount_model']").on('change', function(){
                discount_model = $(this).val();
                if(discount_model == 1){ // percent
                    $('input[name="nominal"]').prop('value', 0);
                    $('.form-nominal').addClass('hidden');
                    $('.form-percent').removeClass('hidden');
                } else if(discount_model == 2){ // nominal
                    $('input[name="percent"]').prop('value', 0);
                    $('.form-percent').addClass('hidden');
                    $('.form-nominal').removeClass('hidden');
                } else {
                    $('input[name="nominal"]').prop('value', 0);
                    $('input[name="percent"]').prop('value', 0);
                    $('.form-percent').addClass('hidden');
                    $('.form-nominal').addClass('hidden');
                }
            });

            // force uppercase form input code
            $('input[name="code"]').on('input', function(e){
                // keyword = $(this).val().trim();
                this.value = this.value.toLocaleUpperCase();
            })
            // form input code not allowed using space
            $('input[name="code"]').on('keydown', function(e){
                if (e.keyCode == 32) {
                    swal('Error', 'Discount code not allowed using space', 'error');
                }
            })

            $("input[name='check_buy_subproduct']").on('change', function(){
                if(this.checked) {
                    $('.select-buy-subproduct').removeClass('hidden');
                } else {
                    $('.select-buy-subproduct').addClass('hidden');
                }
            });

            $("input[name='check_get_subproduct']").on('change', function(){
                if(this.checked) {
                    $('.select-get-subproduct').removeClass('hidden');
                } else {
                    $('.select-get-subproduct').addClass('hidden');
                }
            });

            /**
            * Action before submit form
            */
            $('#discount_create').on('submit', function (e) {
                if(discount_type == 1 && discount_model == ''){
                    swal('Error', 'Make sure discount model selected', 'error');
                } else {
                    // form is valid
                    is_form_valid = $('#discount_create').valid();
                    if(is_form_valid == true){
                        $('button[name="simpan"]').attr('disabled', 'disabled');
                        $('#execute-loading').css({'visibility': 'visible'});
                    }
                }
            });

            <?= \Helper::number_formats('$("input[name=\'nominal\']")', 'js', 0) ?>
            <?= \Helper::number_formats('$("input[name=\'percent\']")', 'js', 2) ?>
        });
    </script>
@endsection