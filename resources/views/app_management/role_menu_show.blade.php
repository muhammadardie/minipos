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
                                <h3 class="m-portlet__head-text">
                                    Role Menu
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['id' => 'role_menu_show', 'class' => 'm-form m-form--fit m-form--label-align-left']) !!}
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2 col-sm-12">
                                <span style="color:red" title="Wajib diisi">*</span>
                                Role Name
                            </label>
                            <div class="col-lg-3 col-sm-12">
                                <input type="text" class="form-control" value="{{ $role_name }} "disabled>
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
                                                            <label><b>Menu Name</b></label>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="rolemenu_scrollbody">
                                        <table class="table table-bordered">
                                            <tbody>
                                                @foreach($menu as $item)
                                                <tr>
                                                    <td><span class="glyphicon glyphicon glyphicon-folder-open" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;<b>{{ $item->name }}</b></td>
                                                </tr>

                                                    @php ($submenu1 = $item->childrenRecursive)
                                                    @foreach($submenu1 as $item1)
                                                    <tr>
                                                        <td style='padding-left:50px;'>{{ $item1->name }}</td>
                                                    </tr>

                                                        @php ($submenu2 = $item1->childrenRecursive)
                                                        @foreach($submenu2 as $item2)
                                                        <tr>
                                                            <td style='padding-left:75px;'>{{ $item2->name }}</td>
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
                                    <a href="{{ route($route_index) }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  <!--end::Portlet-->  
                {!! Form::close() !!}
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