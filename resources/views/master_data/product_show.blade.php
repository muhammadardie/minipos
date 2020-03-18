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
                                    Detail Product
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
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Product Category
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('product_category', $product->product_category->name , ['class' => 'form-control', 'disabled']) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Brand
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('brand', $product->brand->name , ['class' => 'form-control', 'disabled']) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Name
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('name', $product->name , ['class' => 'form-control', 'disabled']) }}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Code
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('code', $product->code , ['class' => 'form-control', 'disabled']) }}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Unit
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('code', $product->unit->name , ['class' => 'form-control', 'disabled']) }}
                                            </div>
                                        </div>
                                        <br />
                                    </div>
                                    
                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">2. Pricing</h3>
                                    </div>

                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                        <label class="col-form-label col-lg-4 col-sm-6">
                                            
                                            Cost
                                        </label>
                                        <div class="col-lg-8 col-sm-6">
                                            <div class="input-group">
                                                <div class="input-group-append"><span class="input-group-text" id="basic-addon2">Rp</span></div>
                                                {{ Form::text('cost', \Helper::number_formats($product->cost, 'view', 0) , ['class' => 'form-control', 'disabled']) }}
                                        </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Price
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                <div class="input-group">
                                                    <div class="input-group-append"><span class="input-group-text" id="basic-addon2">Rp</span></div>
                                                    {{ Form::text('cost', \Helper::number_formats($product->price, 'view', 0) , ['class' => 'form-control', 'disabled']) }}
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
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                
                                                Supplier
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('supplier', $product->supplier->name , ['class' => 'form-control', 'disabled']) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Stock
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('stock', $product->stock , ['class' => 'form-control', 'disabled']) }}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Storage
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('storage', $product->storage , ['class' => 'form-control', 'disabled']) }}
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
                                                
                                                Release Date
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                <div class="input-group date">
                                                    {{ Form::text('release_date', \Helper::date_formats($product->release_date, 'view') , ['class' => 'form-control', 'disabled']) }}
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
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Image 
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                        <img src="{{ \Helper::getImage('product',$product->image) }}" alt=""> </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Description
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::textarea('description', $product->description, ['class' => 'form-control', 'disabled' => 'disabled']) }}
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