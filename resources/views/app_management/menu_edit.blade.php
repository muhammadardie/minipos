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
                                    Edit Menu
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['route' => [$route_update, $this_menu->id], 'id' => 'menu_edit', 'class' => 'm-form m-form--fit m-form--label-align-left']) !!}
                    {{method_field('PATCH')}}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                     Name
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::text('name', $this_menu->name, ['class' => 'form-control']) }}
                                    {!! $errors->first('name', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>

                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('folder') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                     Folder
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::text('folder', $this_menu->folder , ['class' => 'form-control']) }}
                                    {!! $errors->first('folder', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('class') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12"> File</label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::text('class', $this_menu->class, ['class' => 'form-control']) }}
                                    {!! $errors->first('class', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('parent') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12"> Parent</label>
                                <div class="col-lg-5 col-sm-12">
                                    <select name="parent" class='form-control m-select2-general'>
                                        <option value="0"><center>• root menu •</center></option>
                                        @foreach($menu as $item)
                                            @if($item->id == $this_menu->parent) @php($checked = 'selected') @else @php($checked = '') @endif
                                            <option value='{{ $item->id }}' {{ $checked }}>{{ $item->name }}</option>
                                            @php ($submenu1 = $item->childrenRecursive)
                                            @foreach($submenu1 as $item1)
                                                @if($item1->id == $this_menu->parent) @php($checked1 = 'selected') @else @php($checked1 = '') @endif
                                                <option value='{{ $item1->id }}' {{ $checked1 }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; › {{ $item1->name }}</option>
                                                @php ($submenu2 = $item1->childrenRecursive)
                                                @foreach($submenu2 as $item2)
                                                    @if($item2->id == $this_menu->parent) @php($checked2 = 'selected') @else @php($checked2 = '') @endif
                                                    <option value='{{ $item2->id }}' {{ $checked2 }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ›› {{ $item2->name }}</option>
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
                                    {{ Form::number('order', $this_menu->order , ['class' => 'form-control', 'min' => 1]) }}
                                    {!! $errors->first('order', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('icon_class') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12"> Icon</label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::text('icon_class', $this_menu->icon_class , ['class' => 'form-control', 'placeholder' => 'e.g. flaticon-user-settings, flaticon-file-1']) }}
                                    {!! $errors->first('icon_class', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('active') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">Status</label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::select('active', ['1' => 'Active', '0' => 'Inactive'], $this_menu->active, ['class' => 'form-control m-bootstrap-select m_selectpicker', 'style' =>'width: 100%']) }}
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
{!! JsValidator::formRequest('App\Http\Requests\app_management\MenuRequest', '#menu_edit') !!}

    <script type="text/javascript">
        $(document).ready(function(){
            /**
            * Action before submit form
            */
            $('#menu_edit').on('submit', function (e) {
                // form is valid
                is_form_valid = $('#menu_edit').valid();
                if(is_form_valid == true){
                    $('button[name="simpan"]').attr('disabled', 'disabled');
                    $('#execute-loading').css({'visibility': 'visible'});
                }
            });
        });
    </script>
@endsection