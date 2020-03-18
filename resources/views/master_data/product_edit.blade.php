@extends('layouts.base')
    @section('content')
    <style>
        .my_form{
            margin-bottom: 15px;
        }
    </style>
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
                                    Edit Product
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['route' => [$route_update, $product->id], 'id' => 'product_edit', 'class' => 'm-form m-form--fit m-form--label-align-left', 'enctype' => 'multipart/form-data']) !!}
                    {{method_field('PATCH')}}
                        <div class="m-portlet__body">
                            <!-- LEFT -->
                            <div class="col-md-6 col-sm-12">
                                <div class="row">

                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">1. Details</h3>
                                    </div>

                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('product_category') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Product Category
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::select('product_category', $product_category, $product->product_category_id, ['class' => 'form-control select2']) }}
                                                {!! $errors->first('product_category', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('brand') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Brand
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::select('brand', $brand, $product->brand_id, ['class' => 'form-control select2']) }}
                                                {!! $errors->first('brand', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Name
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('name', $product->name, ['class' => 'form-control']) }}
                                                {!! $errors->first('name', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('code') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Code
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('code', $product->code, ['class' => 'form-control']) }}
                                                {!! $errors->first('code', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('unit') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Unit
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::select('unit', $unit, $product->unit_id, ['class' => 'form-control select2']) }}
                                                {!! $errors->first('outlet', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>
                                        </div>
                                        <br />
                                    </div>
                                    
                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">2. Pricing</h3>
                                    </div>

                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('cost') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Cost
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                <div class="input-group">
                                                    <div class="input-group-append"><span class="input-group-text" id="basic-addon2">Rp</span></div>
                                                    {{ Form::text('cost', \Helper::number_formats($product->cost, 'view'), ['class' => 'form-control', 'placeholder' => 'Cost Value']) }}
                                                    {!! $errors->first('cost', '<span class="help-block error-help-block">:message</span>'); !!}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('price') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Price
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                <div class="input-group">
                                                    <div class="input-group-append"><span class="input-group-text" id="basic-addon2">Rp</span></div>
                                                    {{ Form::text('price', \Helper::number_formats($product->price, 'view'), ['class' => 'form-control', 'placeholder' => 'Price For Sale']) }}
                                                    {!! $errors->first('price', '<span class="help-block error-help-block">:message</span>'); !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- RIGHT -->
                            <div class="col-md-6 col-sm-12">
                                <div class="row">

                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">3. Inventory</h3>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('supplier') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Supplier
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::select('supplier', $supplier, $product->supplier_id, ['class' => 'form-control select2']) }}
                                                {!! $errors->first('outlet', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('storage') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Storage
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('storage', $product->storage, ['class' => 'form-control']) }}
                                                {!! $errors->first('storage', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>
                                        </div>
                                        <br />
                                    </div>
                                    
                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">4. Miscellaneous</h3>
                                    </div>
                                    
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('release_date') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Release Date
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                <div class="input-group date">
                                                    {{ Form::text('release_date', Helper::date_formats($product->release_date, 'view'), ['class' => 'form-control m-input', 'readonly' => 'readonly', 'placeholder' => 'Date Release Product']) }}
                                                    {!! $errors->first('release_date', '<span class="help-block error-help-block">:message</span>'); !!}
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('last_name') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Image
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail" style="width: 170px; height: 150px;">
                                                        <img src="{{ \Helper::getImage('product',$product->image) }}" alt=""> 
                                                        {{-- {!! $response !!} --}}
                                                    </div>
                                                    <div>
                                                        <span class="btn btn-info btn-file">
                                                            <span class="fileinput-new"> Select image </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <input type="file" name="image"> 
                                                        </span>
                                                            <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                                        <div class="clearfix margin-top-10">
                                                            <span class="label label-danger">NOTE!</span> <span class="required" style="color:red;">(Max: 2 MB | Type: .jpg .png)</span>
                                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('description') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Description
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::textarea('description', $product->description, ['class' => 'form-control', 'placeholder' => 'Optional']) }}
                                                {!! $errors->first('description', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="clearfix"></div>

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

{!! JsValidator::formRequest('App\Http\Requests\master_data\ProductRequest', '#product_edit') !!}

    <script type="text/javascript">
        $(document).ready(function(){
            $("select[name='product_category']").select2({ placeholder: "{{ \Lang::get('select2.select_product_category') }}" });
            $("select[name='brand']").select2({ placeholder: "{{ \Lang::get('select2.select_brand') }}" });
            $("select[name='unit']").select2({ placeholder: "{{ \Lang::get('select2.select_unit') }}" });
            $("select[name='supplier']").select2({ placeholder: "{{ \Lang::get('select2.select_supplier') }}" });

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
            
            /**
            * Action before submit form
            */
            $('#product_edit').on('submit', function (e) {
                // form is valid
                is_form_valid = $('#product_edit').valid();
                if(is_form_valid == true){
                    $('button[name="simpan"]').attr('disabled', 'disabled');
                    $('#execute-loading').css({'visibility': 'visible'});
                }
            });

            <?= \Helper::date_formats('$("input[name=\'release_date\']")', 'js') ?>
            <?= \Helper::number_formats('$("input[name=\'cost\']")', 'js', 0) ?>
            <?= \Helper::number_formats('$("input[name=\'price\']")', 'js', 0) ?>
        });
    </script>
@endsection