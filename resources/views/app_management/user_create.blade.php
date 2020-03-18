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
                                    Add User
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['route' => $route_store, 'id' => 'form_user_create', 'class' => 'm-form m-form--fit m-form--label-align-left']) !!}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Role
                                </label>
                                <div class="col-lg-5 col-sm-12 {{ $errors->has('role') ? 'has-error' :'' }}">
                                    {{ Form::select('role', $role, null, ['class' => 'form-control select2']) }}
                                    {!! $errors->first('role', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>

                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Employee
                                </label>
                                <div class="col-lg-5 col-sm-12 {{ $errors->has('emp') ? 'has-error' :'' }}">
                                    {{ Form::select('emp', $emp, null, ['class' => 'form-control select2']) }}
                                    {!! $errors->first('emp', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>

                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('username') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Username
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::text('username', '', ['class' => 'form-control', 'disabled']) }}
                                    {!! $errors->first('username', '<span class="help-block error-help-block">:message</span>'); !!}
                                    <span id="loading-username" style="display: none;"><img src="{{ asset('assets/demo/default/media/img/misc/loading.gif') }}"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('email') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    E-Mail
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::text('email', '', ['class' => 'form-control', 'disabled']) }}
                                    {!! $errors->first('email', '<span class="help-block error-help-block">:message</span>'); !!}
                                    <span id="loading-email" style="display: none;"><img src="{{ asset('assets/demo/default/media/img/misc/loading.gif') }}"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('is_owner') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">Owner</label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::select('is_owner', ['1' => 'Ya', '0' => 'Tidak'], null, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'style' =>'width: 100%']) }}
                                    {!! $errors->first('is_owner', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('password') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Password
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::password('password', ['class' => 'form-control']) }}
                                    {!! $errors->first('password', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('password_confirmation') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Confirm Password
                                </label>
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
                        </div>
                    {!! Form::close() !!}
               </div>  
                <!--end::Portlet-->    
            </div>
        </div>
    </div>

{!! JsValidator::formRequest('App\Http\Requests\app_management\UserRequest', '#form_user_create'); !!}

    <script type="text/javascript">
        $(document).ready(function(){
            $("select[name='role']").select2({ placeholder: "{{ \Lang::get('select2.select_role') }}" });
            $("select[name='emp']").select2({ placeholder: "{{ \Lang::get('select2.select_emp') }}" });

            $("select[name='emp']").on('change', function(){
                emp = $(this).val();
                // show loading
                $('#loading-username').css({'display': 'block'});
                $('#loading-email').css({'display': 'block'});
                $.ajax({
                    method: 'GET',
                    url: '{{ $url_ajax_get_emp_data }}',
                    data: {emp: emp},
                    success: function(data){
                        // hide loadingfullname
                        $('#loading-username').css({'display': 'none'});
                        $('#loading-email').css({'display': 'none'});

                        obj_emp  = JSON.parse(data);
                        if (typeof obj_emp != "undefined") {
                            if(obj_emp.last_name !== null){
                                lastname = ' '+obj_emp.last_name;
                            } else {
                                lastname = '';
                            }
                            $("input[name='username']").val(obj_emp.first_name+lastname);
                            $("input[name='email']").val(obj_emp.email);
                        }else{
                            alert('karyawan tidak ditemukan');
                        }
                    },
                    error: function(err){
                        alert(JSON.stringify(err));
                        // hide loading
                        $('#loading-username').css({'display': 'none'});
                        $('#loading-email').css({'display': 'none'});
                    }

                });
                
            });

            /**
            * Action before submit form
            */
            $('#form_user_create').on('submit', function (e) {
            // form is valid
                is_form_valid = $('#form_user_create').valid();
                if(is_form_valid == true){                  
                    $('button[name="simpan"]').attr('disabled', 'disabled');
                    $('#execute-loading').css({'visibility': 'visible'});
                }
            });
        });
    </script>
@endsection