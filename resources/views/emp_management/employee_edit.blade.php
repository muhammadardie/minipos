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
                                    <i class="fa flaticon-edit"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Edit Employee
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['route' => [$route_update, $emp->id], 'id' => 'emp_edit', 'class' => 'm-form m-form--fit m-form--label-align-left', 'enctype' => 'multipart/form-data']) !!}
                    {{method_field('PATCH')}}
                        <div class="m-portlet__body">
                            <!-- LEFT -->
                            <div class="col-md-6 col-sm-12">
                                <div class="row">

                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">1. Profile</h3>
                                    </div>

                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('first_name') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Firstname
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('first_name', $emp->first_name, ['class' => 'form-control']) }}
                                                {!! $errors->first('first_name', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('last_name') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Lastname
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('last_name', $emp->last_name, ['class' => 'form-control']) }}
                                                {!! $errors->first('last_name', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('outlet') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Outlet
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::select('outlet', $outlet, $emp->outlet_id, ['class' => 'form-control m-select2-general']) }}
                                                {!! $errors->first('outlet', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('birth_place') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Birth Place
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('birth_place', $emp->birth_place, ['class' => 'form-control']) }}
                                                {!! $errors->first('birth_place', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('birth_date') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Birth Date
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                <div class="input-group date">
                                                    {{ Form::text('birth_date', \Helper::date_formats($emp->birth_date, 'view'), ['class' => 'form-control m-input', 'readonly' => 'readonly', 'placeholder' => 'Pilih Tanggal Lahir']) }}
                                                    {!! $errors->first('birth_date', '<span class="help-block error-help-block">:message</span>'); !!}
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
                                        <div class="form-group m-form__group row {{ $errors->has('gender') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Gender
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::select('gender', ['1' => 'Laki - Laki', '2' => 'Wanita'], $emp->gender, ['class' => 'form-control m-bootstrap-select m_selectpicker']) }}
                                                {!! $errors->first('gender', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('marital_status') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Marital Status
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::select('marital_status', ['1' => 'Male', '2' => 'Female'], $emp->marital_status, ['class' => 'form-control m-bootstrap-select m_selectpicker']) }}
                                                {!! $errors->first('marital_status', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('last_name') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Email
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('email', $emp->email, ['class' => 'form-control']) }}
                                                {!! $errors->first('email', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('last_name') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Photo
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail" style="width: 170px; height: 150px;">
                                                        <img src="{{ $emp->photo }}" alt=""> 
                                                        {{-- {!! $response !!} --}}
                                                    </div>
                                                    <div>
                                                        <span class="btn btn-info btn-file">
                                                            <span class="fileinput-new"> Select image </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <input type="file" name="photo"> 
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
                                </div>
                            </div>

                            <!-- RIGHT -->
                            <div class="col-md-6 col-sm-12">
                                <div class="row">

                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">2. Address</h3>
                                    </div>

                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('address') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Address
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::textarea('address', $emp->address, ['class' => 'form-control' ,'size' => '-x-']) }}
                                                {!! $errors->first('address', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('mobile_phone') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                Mobile Phone
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('mobile_phone', $emp->mobile_phone, ['class' => 'form-control']) }}
                                                {!! $errors->first('mobile_phone', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>
                                        </div>
                                        <br />
                                    </div>
                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">3. Identitas</h3>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('identity') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Identity Type
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::select('identity', $identity, $emp->identity_id, ['class' => 'form-control m-bootstrap-select m_selectpicker']) }}
                                                {!! $errors->first('identity', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('identity_no') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Identity Number
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::text('identity_no', $emp->identity_no, ['class' => 'form-control']) }}
                                                {!! $errors->first('identity_no', '<span class="help-block error-help-block">:message</span>'); !!}
                                            </div>

                                        </div>
                                        <br />
                                    </div>
                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">4. Status Karyawan</h3>
                                    </div>
                                    <div class="col-md-12 my_form">
                                        <div class="form-group m-form__group row {{ $errors->has('is_active') ? 'has-error' :'' }}">
                                            <label class="col-form-label col-lg-4 col-sm-6">
                                                <span style="color:red" title="Wajib diisi">*</span>
                                                Status
                                            </label>
                                            <div class="col-lg-8 col-sm-6">
                                                {{ Form::select('is_active', ['1' => 'Active', '0' => 'Inactive'], $emp->is_active, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'style' =>'width: 100%']) }}
                                                {!! $errors->first('is_active', '<span class="help-block error-help-block">:message</span>'); !!}
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
                                        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                                        <a href="{{ route($route_index) }}" class="btn btn-secondary">Kembali</a>
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
{!! JsValidator::formRequest('App\Http\Requests\emp_management\EmployeeRequest', '#emp_edit') !!}

    <script type="text/javascript">
        $(document).ready(function(){
            /**
            * Action before submit form
            */
            $('#emp_edit').on('submit', function (e) {
                // form is valid
                is_form_valid = $('#emp_edit').valid();
                if(is_form_valid == true){
                    $('button[name="simpan"]').attr('disabled', 'disabled');
                    $('#execute-loading').css({'visibility': 'visible'});
                }
            });

            <?= \Helper::date_formats('$("input[name=\'birth_date\']")', 'js') ?>

        });
    </script>
@endsection