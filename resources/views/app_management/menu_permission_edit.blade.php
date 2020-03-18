@extends('layouts.base')
    @section('content')
    <style>
    .table_rolemenu .rolemenu_scrollhead {
        height: 42px;
        overflow: hidden;
        position: relative;
        margin-bottom: -3px;
    }
    .table_rolemenu .rolemenu_scrollbody {
        overflow: auto;
        height: 300px;
        width: 100%;
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
                                    Edit Menu Permission
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['route' => [$route_update, $role->id], 'id' => 'menu_permission_edit', 'class' => 'm-form m-form--fit m-form--label-align-left']) !!}
                    {{method_field('PATCH')}}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Role Name
                                </label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" placeholder="{{ $role->name }} "disabled>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-md-12">
                                    <div class="table table-bordered m-table table_rolemenu">
                                        <div class="rolemenu_scrollhead">
                                            <div class="rolemenu_scrollheadinner">
                                                <table class="table m-table m-table--head-bg-primary">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>
                                                                <label><b>Menu Name</b><label>
                                                            </th>

                                                            @php($max_width_permission = 50)
                                                            @php($width_permission = $max_width_permission / ($m_permission->count()))
                                                            @foreach($m_permission as $p)
                                                            <th style='width:{{ $width_permission }}%' class='text-center'>
                                                                <label style='font-size: 12px'>{{ Form::checkbox('name', $p->id, '', ['style' => '', 'class' =>$p->name.'_top']) }} <b>{{ $p->name }}</b></label>
                                                            </th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="rolemenu_scrollbody">
                                            <table class="table m-table">
                                                <tbody>
                                                    <!-- root menu -->
                                                    @foreach($menu as $item)
                                                    <tr>
                                                        <td>
                                                            <label>
                                                                <span class="glyphicon glyphicon glyphicon-folder-open" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;<strong>{{ $item->name }}</strong>
                                                            </label>
                                                        </td>

                                                        <!-- loop master permission -->
                                                        @foreach($m_permission as $p)
                                                        <td style='width:{{ $width_permission }}%' class='text-center'>
                                                            @if(!empty($item->class))
                                                                <label style='font-size: 12px'>{{ Form::checkbox('m_id'.$item->id.'[]', $p->id, '', ['style' => '', 'class' => $p->name.'_item']) }}<label>
                                                            @endif
                                                        </td>
                                                        @endforeach
                                                    </tr>

                                                        <!-- submenu1 -->
                                                        @php ($submenu1 = $item->childrenRecursive)
                                                        @foreach($submenu1 as $item1)
                                                        <tr>
                                                            <td style='padding-left:50px;'>
                                                                <label>
                                                                    {{ $item1->name }}
                                                                </label>
                                                            </td>

                                                            <!-- check menu_id -->
                                                            @php($menu_id_exist1 = false)
                                                            @if(array_key_exists($item1->id, $list_permission))
                                                                @php($menu_id_exist1 = true)
                                                            @endif

                                                            <!-- loop master permission -->
                                                            @foreach($m_permission as $p)
                                                            <td style='width:{{ $width_permission }}%' class='text-center'>
                                                                @if(!empty($item1->class))
                                                                    @php($checked1 = false)

                                                                    <!-- checked checkbox permission -->
                                                                    @if($menu_id_exist1 == true)
                                                                        @if(in_array($p->id, $list_permission[$item1->id]['permission_id']))
                                                                            @php($checked1 = true)
                                                                        @endif
                                                                    @endif
                                                                    <label style='font-size: 12px'>{{ Form::checkbox('m_id'.$item1->id.'[]', $p->id, $checked1, ['style' => '', 'class' => $p->name.'_item']) }}<label>
                                                                @endif
                                                            </td>
                                                            @endforeach
                                                        </tr>

                                                            <!-- submenu2 -->
                                                            @php ($submenu2 = $item1->childrenRecursive)
                                                            @foreach($submenu2 as $item2)
                                                            <tr>
                                                                <td style='padding-left:75px;'>
                                                                    <label>
                                                                        {{ $item2->name }}
                                                                    </label>
                                                                </td>

                                                                <!-- check menu_id -->
                                                                @php($menu_id_exist2 = false)
                                                                @if(array_key_exists($item2->id, $list_permission))
                                                                    @php($menu_id_exist2 = true)
                                                                @endif

                                                                <!-- loop master permission -->
                                                                @foreach($m_permission as $p)
                                                                <td style='width:{{ $width_permission }}%' class='text-center'>
                                                                    @if(!empty($item2->class))
                                                                            @php($checked2 = false)

                                                                            <!-- checked checkbox permission -->
                                                                            @if($menu_id_exist2 == true)
                                                                                @if(in_array($p->id, $list_permission[$item2->id]['permission_id']))
                                                                                    @php($checked2 = true)
                                                                                @endif
                                                                            @endif
                                                                        <label style='font-size: 12px'>{{ Form::checkbox('m_id'.$item2->id.'[]', $p->id, $checked2, ['style' => '', 'class' => $p->name.'_item']) }}<label>
                                                                    @endif
                                                                </td>
                                                                @endforeach
                                                            </tr>

                                                            @endforeach
                                                        @endforeach
                                                    @endforeach

                                                    @if($menu->isEmpty())
                                                        <tr>
                                                            <td>Tidak ada menu</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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

    <script>
    $(document).ready(function(){
        /**
        * Action before submit form
        */
        $('#menu_permission_edit').on('submit', function (e) {
            // form is valid
            is_form_valid = $('#menu_permission_edit').valid();
            if(is_form_valid == true){
                $('button[name="simpan"]').attr('disabled', 'disabled');
                $('#execute-loading').css({'visibility': 'visible'});
            }
        });

        $('.show_top').on('click', function(){
            is_checked = $('.show_top').is(':checked');
            if(is_checked == true){
                $('.show_item').prop('checked', true);
            }else if(is_checked == false){
                $('.show_item').prop('checked', false);
            }
        });

        $('.create_top').on('click', function(){
            is_checked = $('.create_top').is(':checked');
            if(is_checked == true){
                $('.create_item').prop('checked', true);
            }else if(is_checked == false){
                $('.create_item').prop('checked', false);
            }
        });

        $('.edit_top').on('click', function(){
            is_checked = $('.edit_top').is(':checked');
            if(is_checked == true){
                $('.edit_item').prop('checked', true);
            }else if(is_checked == false){
                $('.edit_item').prop('checked', false);
            }
        });

         $('.destroy_top').on('click', function(){
            is_checked = $('.destroy_top').is(':checked');
            if(is_checked == true){
                $('.destroy_item').prop('checked', true);
            }else if(is_checked == false){
                $('.destroy_item').prop('checked', false);
            }
        });       
    });
    </script>

@endsection