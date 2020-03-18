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
                                    Add Outlet
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['route' => $route_store, 'id' => 'outlet_create', 'class' => 'm-form m-form--fit m-form--label-align-left']) !!}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Province
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::select('province', $province, null, ['class' => 'form-control select2']) }}
                                    {!! $errors->first('province', '<span class="help-block error-help-block">:message</span>'); !!}
                                    <span id="loading-province" style="display:none"><img src="{{ asset('assets/demo/default/media/img/misc/loading.gif') }}"></span>
                                </div>

                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('regency') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Regency
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::select('regency', [], null, ['class' => 'form-control select2']) }}
                                    {!! $errors->first('regency', '<span class="help-block error-help-block">:message</span>'); !!}
                                    <span id="loading-regency" style="display:none"><img src="{{ asset('assets/demo/default/media/img/misc/loading.gif') }}"></span>
                                </div>

                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('district') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    District
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::select('district', [], null, ['class' => 'form-control select2']) }}
                                    {!! $errors->first('district', '<span class="help-block error-help-block">:message</span>'); !!}
                                    <span id="loading-district" style="display:none"><img src="{{ asset('assets/demo/default/media/img/misc/loading.gif') }}"></span>
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

{!! JsValidator::formRequest('App\Http\Requests\master_data\OutletRequest', '#outlet_create') !!}

    <script type="text/javascript">
        $(document).ready(function(){
            $("select[name='province']").select2({ placeholder: "{{ \Lang::get('select2.select_province') }}" });
            $("select[name='regency']").select2({ placeholder: "{{ \Lang::get('select2.select_regency') }}" });
            $("select[name='district']").select2({ placeholder: "{{ \Lang::get('select2.select_district') }}" });


            $("select[name='province']").on('change', function(){
                province = $(this).val();
                // show loading
                $('#loading-province').css({'display': 'block'});
                $.ajax({
                    method: 'GET',
                    url: '{{ $url_ajax_get_regencies }}',
                    data: {province: province},
                    success: function(msg){
                        $("select[name='regency']").html('');
                        $("select[name='district']").html('');
                        // hide loading
                        $('#loading-province').css({'display': 'none'});

                        obj_regencies  = JSON.parse(msg);
                        list_regencies = '<option></option>';
                        if(obj_regencies.length > 0){
                            $.each(obj_regencies, function(i,v){
                                list_regencies += "<option value='"+ v.id +"'>"+ v.name +"</option>";
                            });
                        }else{
                            list_regencies = "<option></option>";
                        }

                        
                        $("select[name='regency']").html(list_regencies);
                    },
                    error: function(err){
                        console.log(JSON.stringify(err));
                        swal("Failed!", "Unable to get data.", "error");
                        $('#loading-province').css({'display': 'none'});
                    }

                });
                
            });

            $("select[name='regency']").on('change', function(){
                regency = $(this).val();
                // show loading
                $('#loading-regency').css({'display': 'block'});
                $.ajax({
                    method: 'GET',
                    url: '{{ $url_ajax_get_districts }}',
                    data: {regency: regency},
                    success: function(msg){
                        $("select[name='district']").html('');
                        // hide loading
                        $('#loading-regency').css({'display': 'none'});

                        obj_districts  = JSON.parse(msg);
                        list_districts = '<option></option>';
                        if(obj_districts.length > 0){
                            $.each(obj_districts, function(i,v){
                                list_districts += "<option value='"+ v.id +"'>"+ v.name +"</option>";
                            });
                        }else{
                            list_districts = "<option></option>";
                        }

                        
                        $("select[name='district']").html(list_districts);
                    },
                    error: function(err){
                        console.log(JSON.stringify(err));
                        swal("Failed!", "Unable to get data.", "error");
                        $('#loading-regency').css({'display': 'none'});
                    }

                });
                
            });
            
            /**
            * Action before submit form
            */
            $('#outlet_create').on('submit', function (e) {
                // form is valid
                is_form_valid = $('#outlet_create').valid();
                if(is_form_valid == true){
                    $('button[name="simpan"]').attr('disabled', 'disabled');
                    $('#execute-loading').css({'visibility': 'visible'});
                }
            });
        });
    </script>
@endsection