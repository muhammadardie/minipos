@extends('layouts.app')
    @section('content')

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEAD-->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>User
                        <!-- <small>statistics, charts, recent events and reports</small> -->
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD-->

            <!-- BEGIN PAGE BREADCRUMB -->
            @include('layouts.breadcumb')
            <!-- END PAGE BREADCRUMB -->

            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="row">
                <div class="col-md-12">

                    <div class="portlet light bordered">
                       <div class="portlet-title">
                          <div class="caption">
                             <i class="fa fa-pencil font-red-sunglo"></i>
                             <span class="caption-subject font-red-sunglo bold uppercase">Ubah Password</span>
                             <!-- <span class="caption-helper">form actions on top...</span> -->
                          </div>
                          <div class="actions">
                             <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;" title="Refresh Halaman" onclick="location.reload()">
                                <i class="fa fa-refresh"></i>
                             </a>
                          </div>
                       </div>
                       <div class="portlet-body form">
                          
                          {!! Form::open(['route' => $route_update, 'id' => 'form_user_edit_password']) !!}
                             <div class="form-body">
                                <!--@left-->
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <table class="table table-siak borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td><span style="color:red" title="Wajib diisi">*</span> Nama Role</td>
                                                            <td>:</td>
                                                            <td>
                                                                {{ Form::text('role', $role, ['class' => 'form-control', 'readonly']) }}
                                                                {!! $errors->first('role', '<span class="help-block form-messages">:message</span>'); !!}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <table class="table table-siak borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td><span style="color:red" title="Wajib diisi">*</span> Username</td>
                                                            <td>:</td>
                                                            <td>
                                                                {{ Form::text('username', $user->username, ['class' => 'form-control', 'readonly']) }}
                                                                {!! $errors->first('username', '<span class="help-block form-messages">:message</span>') !!}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <table class="table table-siak borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td><span style="color:red" title="Wajib diisi">*</span> Nama Lengkap</td>
                                                            <td>:</td>
                                                            <td>
                                                                {{ Form::text('name', $user->name, ['class' => 'form-control', 'readonly']) }}
                                                                {!! $errors->first('name', '<span class="help-block form-messages">:message</span>') !!}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <table class="table table-siak borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td><span style="color:red" title="Wajib diisi">*</span> E-Mail</td>
                                                            <td>:</td>
                                                            <td>
                                                                {{ Form::text('email', $user->email, ['class' => 'form-control', 'readonly']) }}
                                                                {!! $errors->first('email', '<span class="help-block form-messages">:message</span>'); !!}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <table class="table table-siak borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td>Password</td>
                                                            <td>:</td>
                                                            <td>
                                                                {{ Form::password('password', ['class' => 'form-control']) }}
                                                                {!! $errors->first('password', '<span class="help-block form-messages">:message</span>'); !!}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <table class="table table-siak borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td>Confirm Password</td>
                                                            <td>:</td>
                                                            <td>
                                                                {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                                                                {!! $errors->first('password_confirmation', '<span class="help-block form-messages">:message</span>'); !!}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div><!--/row-->
                                </div><!--/@left-->

                                <!--@right-->
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                        </div>
                                    </div>
                                </div><!--/@right-->
                             </div>
                            <div class="clearfix"></div>

                            <div class="form-actions">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <table class="table table-siak borderless">
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <span id="execute-loading" style="visibility: hidden;"><img src="{{ asset('assets/theme/global/img/loading.gif') }}"></span>
                                                        <button type="submit" name="simpan" class="btn green">Simpan</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                          {!! Form::close() !!}
                          
                       </div>
                    </div>

                </div>
            </div>
            <!-- END PAGE BASE CONTENT -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->


    {!! JsValidator::formRequest('App\Http\Requests\app_management\Edit_passwordRequest', '#form_user_edit_password'); !!}

    <script type="text/javascript">
        /**
        * Action before submit form
        */
        $('#form_user_edit_password').on('submit', function (e) {
            // form is valid
            is_form_valid = $('#form_user_edit_password').valid();
            if(is_form_valid == true){
                $('button[name="simpan"]').attr('disabled', 'disabled');
                $('#execute-loading').css({'visibility': 'visible'});
            }
        });

    </script>

@endsection