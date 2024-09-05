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
                                    Employee Detail
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['id' => 'employee_create', 'class' => 'm-form m-form--fit m-form--label-align-left', 'enctype' => 'multipart/form-data']) !!}
                        <div class="m-portlet__body">
                            <!-- LEFT -->
                            <div class="col-md-6 col-sm-12">
                                <div class="row">

                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">1. Profile</h3>
                                    </div>

                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Firstname
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('first_name', $emp->first_name , ['class' => 'form-control', 'disabled']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Lastname
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('last_name', $emp->last_name, ['class' => 'form-control' , 'disabled']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Outlet
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('outlet', $emp->outlet->name, ['class' => 'form-control' , 'disabled']) }}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Birth Place
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('birth_place', $emp->birth_place, ['class' => 'form-control' , 'disabled']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Birth Date
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                <div class="input-group date">
                                                    {{ Form::text('birth_date', \Helper::date_formats($emp->birth_date, 'view'), ['class' => 'form-control m-input', 'readonly' => 'readonly', 'placeholder' => 'Pilih Tanggal Lahir', 'disabled']) }}
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
                                                Gender
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::select('gender', ['1' => 'Laki - Laki', '2' => 'Wanita'], $emp->gender, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'disabled']) }}
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Marital Status
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::select('marital_status', ['1' => 'Menikah', '2' => 'Belum Menikah'], $emp->marital_status, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'disabled']) }}
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Email
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('email', $emp->email, ['class' => 'form-control' , 'disabled']) }}
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Photo 
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                        <img src="{{ $emp->photo }}" alt=""> </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
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
                                        <h3 class="m-form__heading-title">2. Address</h3>
                                    </div>

                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Address
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::textarea('address', $emp->address, ['class' => 'form-control' ,'size' => '-x-', 'disabled']) }}
                                                
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Mobile Phone
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('mobile_phone', $emp->mobile_phone, ['class' => 'form-control','disabled']) }}
                                                
                                            </div>
                                        </div>
                                        <br />
                                    </div>
                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">3. Identity</h3>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Identity Type
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('identity_no', $emp->identity->name , ['class' => 'form-control','disabled']) }}
                                                
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Identity Number
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('identity_no', $emp->identity_no , ['class' => 'form-control','disabled']) }}
                                            </div>
                                        </div>
                                        <br />
                                    </div>
                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">4. Employee Status</h3>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Status
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::select('is_active', ['1' => 'Active', '0' => 'Inactive'], $emp->is_active, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'style' =>'width: 100%', 'disabled']) }}
                                                
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
                                        {{-- <button type="submit" name="simpan" class="btn btn-success">Simpan</button> --}}
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

{!! JsValidator::formRequest('App\Http\Requests\emp_management\EmployeeRequest', '#employee_create') !!}

    <script type="text/javascript">
        $(document).ready(function(){
            $("select[name='dept']").select2({ placeholder: "{{ \Lang::get('select2.select_dept') }}" });
            $('input[name=dept_code]').keyup(function() {
                $(this).val($(this).val().toUpperCase());
            });

            /**
            * Action before submit form
            */
            $('#employee_create').on('submit', function (e) {
                // form is valid
                is_form_valid = $('#employee_create').valid();
                if(is_form_valid == true){
                    $('button[name="simpan"]').attr('disabled', 'disabled');
                    $('#execute-loading').css({'visibility': 'visible'});
                }
            });
        });
    </script>
@endsection