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
                                    Detail Supplier
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="m-form m-form--fit m-form--label-align-left">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">Province</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="text" class="form-control" value="{{ $supplier->district->regency->province->name }} "disabled>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">Regency</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="text" class="form-control" value="{{ $supplier->district->regency->name }} "disabled>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">District</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="text" class="form-control" value="{{ $supplier->district->name }} "disabled>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">Village</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="text" class="form-control" value="{{ $supplier->name }} "disabled>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">Name</label>
                                <div class="col-lg-6 col-sm-12">
                                    <input type="text" class="form-control" value="{{ $supplier->name }} "disabled>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">Description</label>
                                <div class="col-lg-6 col-sm-12">
                                    <textarea class="form-control" rows="4" cols="50" disabled>{{ $supplier->description }}</textarea>
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
                    </form>
               </div>  
                <!--end::Portlet-->    
            </div>
        </div>
    </div>
@endsection