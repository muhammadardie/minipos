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
                                    <i class="fa flaticon-edit"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Edit User
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['route' => [$route_update, $user->id], 'id' => 'form_user_edit', 'class' => 'm-form m-form--fit m-form--label-align-left']) !!}
                    {{method_field('PATCH')}}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row {{ $errors->has('role') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Role
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::select('role', $role, $role_id, ['class' => 'form-control m-select2-general']) }}
                                    {!! $errors->first('role', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>

                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('emp') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Karyawan
                                </label>
                                <div class="col-lg-5 col-sm-12 {{ $errors->has('emp') ? 'has-error' :'' }}">
                                    {{ Form::select('emp', $emp, $user->emp_id, ['class' => 'form-control select2']) }}
                                    {!! $errors->first('emp', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>

                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('username') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Username
                                </label>
                                <div class="col-lg-5 col-sm-12" data-toggle=m-tooltip title='Untuk merubah username gunakan edit data karyawan' data-placement='top'>
                                    {{ Form::text('username', $user->employee->first_name.' '.$user->employee->last_name, ['class' => 'form-control', 'disabled']) }}
                                    {!! $errors->first('username', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('email') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12"> E-Mail</label>
                                <div class="col-lg-5 col-sm-12" data-toggle=m-tooltip title='Untuk merubah email gunakan edit data karyawan' data-placement='top'>
                                    {{ Form::text('email', $user->employee->email, ['class' => 'form-control', 'disabled']) }}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('is_owner') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">Owner</label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::select('is_owner', ['1' => 'Ya', '0' => 'Tidak'], $user->is_owner, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'style' =>'width: 100%']) }}
                                    {!! $errors->first('is_owner', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('password') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    Password
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::password('password', ['class' => 'form-control']) }}
                                    {!! $errors->first('password', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('password_confirmation') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">Confirm Password</label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                                    {!! $errors->first('password_confirmation', '<span class="help-block error-help-block">:message</span>'); !!}
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
                            {{-- <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-9 ml-lg-auto">
                                        <a href="{{ route($route_index) }}" class="btn btn-metal">Kembali</a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    {!! Form::close() !!}
               </div>  
                <!--end::Portlet-->    
            </div>
        </div>
    </div>
{!! JsValidator::formRequest('App\Http\Requests\app_management\UserRequest', '#form_user_edit') !!}

    <script type="text/javascript">
        $(document).ready(function(){
            $("select[name='role']").select2({ placeholder: "{{ \Lang::get('select2.select_role') }}" });
            $("select[name='emp']").select2({ placeholder: "{{ \Lang::get('select2.select_emp') }}" });
            /**
            * Action before submit form
            */
            $('#form_user_edit').on('submit', function (e) {
                // form is valid
                is_form_valid = $('#form_user_edit').valid();
                if(is_form_valid == true){
                    $('button[name="simpan"]').attr('disabled', 'disabled');
                    $('#execute-loading').css({'visibility': 'visible'});
                }
            });
        });
    </script>
@endsection