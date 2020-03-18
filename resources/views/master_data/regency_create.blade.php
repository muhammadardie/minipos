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
                                    Add Regency
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['route' => $route_store, 'id' => 'regency_create', 'class' => 'm-form m-form--fit m-form--label-align-left']) !!}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row {{ $errors->has('province') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Province
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::select('province', $province, null, ['class' => 'form-control select2']) }}
                                    {!! $errors->first('province', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>

                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Name
                                </label>
                                <div class="col-lg-5 col-sm-12 {{ $errors->has('name') ? 'has-error' :'' }}">
                                    {{ Form::text('name', '', ['class' => 'form-control']) }}
                                    {!! $errors->first('name', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>

                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('description') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    Description
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::textarea('description', '', ['class' => 'form-control']) }}
                                    {!! $errors->first('description', '<span class="help-block error-help-block">:message</span>'); !!}
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

{!! JsValidator::formRequest('App\Http\Requests\master_data\RegencyRequest', '#regency_create') !!}

    <script type="text/javascript">
        $(document).ready(function(){
            $("select[name='province']").select2({ placeholder: "{{ \Lang::get('select2.select_province') }}" });
            /**
            * Action before submit form
            */
            $('#regency_create').on('submit', function (e) {
                // form is valid
                is_form_valid = $('#regency_create').valid();
                if(is_form_valid == true){
                    $('button[name="simpan"]').attr('disabled', 'disabled');
                    $('#execute-loading').css({'visibility': 'visible'});
                }
            });
        });
    </script>
@endsection