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
                                    Edit Role Menu
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['route' => [$route_update, $role->id], 'id' => 'role_menu_edit', 'class' => 'm-form m-form--fit m-form--label-align-left']) !!}
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
                                                                <label>{{ Form::checkbox('name', 'value', '', ['class' => 'selectAllMenu']) }} <b>Menu Name</b></label>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="rolemenu_scrollbody">
                                            <table class="table m-table">
                                                <tbody>
                                                    @foreach($menu as $item)
                                                    <tr>
                                                        <td>
                                                            @php ($check_menu = false)
                                                            @if(in_array($item->id, $list_menu))
                                                                @php ($check_menu = true)
                                                            @endif

                                                            <label>
                                                                {{ Form::checkbox('menuid[]', $item->id, $check_menu, ['class' => 'item_menu', 'data-id' => $item->id]) }}
                                                                &nbsp;&nbsp;<span class="glyphicon glyphicon glyphicon-folder-open" aria-hidden="true"></span>&nbsp;&nbsp;<strong>{{ $item->name }}</strong>
                                                            </label>
                                                        </td>
                                                    </tr>

                                                        @php ($submenu1 = $item->childrenRecursive)
                                                        @foreach($submenu1 as $item1)
                                                        <tr>
                                                            <td style='padding-left:50px;'>
                                                                @php ($check_submenu1 = false)
                                                                @if(in_array($item1->id, $list_menu))
                                                                    @php ($check_submenu1 = true)
                                                                @endif

                                                                <label>
                                                                    {{ Form::checkbox('menuid[]', $item1->id, $check_submenu1, ['class' => 'item_menu', 'data-id' => $item1->id, 'data-parent' => $item1->parent]) }}
                                                                    {{ $item1->name }}
                                                                </label>
                                                            </td>
                                                        </tr>

                                                            @php ($submenu2 = $item1->childrenRecursive)
                                                            @foreach($submenu2 as $item2)
                                                            <tr>
                                                                <td style='padding-left:75px;'>
                                                                    @php ($check_submenu2 = false)
                                                                    @if(in_array($item2->id, $list_menu))
                                                                        @php ($check_submenu2 = true)
                                                                    @endif

                                                                    <label>
                                                                        {{ Form::checkbox('menuid[]', $item2->id, $check_submenu2, ['class' => 'item_menu', 'data-id' => $item2->id, 'data-parent' => $item2->parent, 'data-parenttop' => $item->id]) }}
                                                                        {{ $item2->name }}
                                                                    </label>
                                                                </td>
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
    /**
    * Select/Deselect all menu
    */
    $('.selectAllMenu').on('click', function(){
        isChecked = $(this).is(':checked');
        if(isChecked){
            $('.item_menu').prop('checked', true);
        }else{
            $('.item_menu').prop('checked', false);
        }
    });

    /*
    * Select/Deselect children menu
    */
    $('.item_menu').on('click', function(){
        thisMenu    = $(this);
        thisMenuId  = thisMenu.attr('data-id');
        isChecked   = thisMenu.is(':checked');

        if(isChecked){
            // search children menu
            $("input[data-parent='"+ thisMenuId +"']").prop('checked', 'true'); // submenu
            $("input[data-parenttop='"+ thisMenuId +"']").prop('checked', 'true'); // sub2ndmenu
            
            // search parent menu
            var attr_dataparent = $(thisMenu).attr('data-parent');
            if (typeof attr_dataparent !== typeof undefined && attr_dataparent !== false) {
                $('.item_menu[data-id="'+ attr_dataparent +'"]').prop('checked', 'true');
            }
            // search root menu
            var attr_dataparenttop = $(thisMenu).attr('data-parenttop');
            if (typeof attr_dataparenttop !== typeof undefined && attr_dataparenttop !== false) {
                $('.item_menu[data-id="'+ attr_dataparenttop +'"]').prop('checked', 'true');
            }
        }else{
            $("input[data-parent='"+ thisMenuId +"']").prop('checked', false);
            $("input[data-parenttop='"+ thisMenuId +"']").prop('checked', false);
        }   
    });

    $(document).ready(function(){
        /**
        * Action before submit form
        */
        $('#role_menu_edit').on('submit', function (e) {
            // form is valid
            is_form_valid = $('#role_menu_edit').valid();
            if(is_form_valid == true){
                $('button[name="simpan"]').attr('disabled', 'disabled');
                $('#execute-loading').css({'visibility': 'visible'});
            }
        });
    });
    </script>

@endsection