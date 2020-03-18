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
                                    User
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="m-form m-form--fit m-form--label-align-left">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">Role</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" value="{{ $role_detail->name }} "disabled>
                                </div>
                                <label class="col-form-label col-lg-2 col-sm-12">Last Login</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" value="{{ $user->last_login }} "disabled>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">Username</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" value="{{ $user->employee->first_name.' '.$user->employee->last_name }} "disabled>
                                </div>
                                <label class="col-form-label col-lg-2 col-sm-12">Date Created</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" value="{{ \Helper::date_formats($role_detail->created_at, 'view') }} "disabled>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">Email</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" value="{{ $user->employee->email }} "disabled>
                                </div>
                                <label class="col-form-label col-lg-2 col-sm-12">Superadmin</label>
                                <div class="col-lg-3 col-sm-12">
                                    @if($user->is_owner == 0)
                                        @php($status = 'Tidak')
                                    @elseif($user->is_owner == 1)
                                        @php($status = 'Ya')
                                    @endif
                                    <input type="text" class="form-control" value="{{ $status }} "disabled>
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