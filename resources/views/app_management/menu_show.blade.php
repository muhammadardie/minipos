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
                                    Menu Detail 
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="m-form m-form--fit m-form--label-align-left">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">Name</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" placeholder="{{ $this_menu->name }} "disabled>
                                </div>
                                <label class="col-form-label col-lg-2 col-sm-12">Folder</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" placeholder="{{ $this_menu->folder }} "disabled>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12"> File</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" placeholder="{{ $this_menu->class }} "disabled>
                                </div>
                                <label class="col-form-label col-lg-2 col-sm-12"> Parent</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" placeholder="{{ !empty($this_menu->theparent) ? $this_menu->theparent->name : '' }} " disabled>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">Order </label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" placeholder="{{ $this_menu->order }} "disabled>
                                </div>
                                <label class="col-form-label col-lg-2 col-sm-12"> Icon</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" placeholder="{{ $this_menu->icon_class }}  " disabled>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                @if($this_menu->active == 0)
                                    @php($status = 'Inactive')
                                @elseif($this_menu->active == 1)
                                    @php($status = 'Active')
                                @endif
                                <label class="col-form-label col-lg-2 col-sm-12">Status</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" placeholder="{{ $status }}"disabled>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-9 ml-lg-auto">
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