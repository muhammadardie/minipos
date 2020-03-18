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
                                    Add Menu
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['route' => $route_store, 'id' => 'menu_create', 'class' => 'm-form m-form--fit m-form--label-align-left']) !!}
                        <div class="m-portlet__body">
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
                            <div class="form-group m-form__group row {{ $errors->has('folder') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                     Folder
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::text('folder', '', ['class' => 'form-control']) }}
                                    {!! $errors->first('folder', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('class') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12"> File</label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::text('class', '', ['class' => 'form-control']) }}
                                    {!! $errors->first('class', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('parent') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12"> Parent</label>
                                <div class="col-lg-5 col-sm-12">
                                    <select name="parent" class='form-control m-select2-general' style="width: 100%">
                                        <option value="0"><center>• root menu •</center></option>
                                        @foreach($menu as $item)
                                            <option value='{{ $item->id }}'>{{ $item->name }}</option>
                                            @php ($submenu1 = $item->childrenRecursive)
                                            @foreach($submenu1 as $item1)
                                                <option value='{{ $item1->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $item1->name }}</option>
                                                @php ($submenu2 = $item1->childrenRecursive)
                                                @foreach($submenu2 as $item2)
                                                    <option value='{{ $item2->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $item2->name }}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                    {!! $errors->first('parent', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('order') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Order
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::number('order', '', ['class' => 'form-control', 'min' => 1]) }}
                                    {!! $errors->first('order', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('icon_class') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12"> Icon</label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::text('icon_class', '', ['class' => 'form-control', 'placeholder' => 'e.g. flaticon-user-settings, flaticon-file-1']) }}
                                    {!! $errors->first('icon_class', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('active') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">Status</label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::select('active', ['1' => 'Active', '0' => 'Inactive'], null, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'style' =>'width: 100%']) }}
                                    {!! $errors->first('active', '<span class="help-block error-help-block">:message</span>'); !!}
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

{!! JsValidator::formRequest('App\Http\Requests\app_management\MenuRequest', '#menu_create') !!}

    <script type="text/javascript">
        $(document).ready(function(){
            /**
            * Action before submit form
            */
            $('#menu_create').on('submit', function (e) {
                // form is valid
                is_form_valid = $('#menu_create').valid();
                if(is_form_valid == true){
                    $('button[name="simpan"]').attr('disabled', 'disabled');
                    $('#execute-loading').css({'visibility': 'visible'});
                }
            });
        });
    </script>
@endsection