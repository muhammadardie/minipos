@extends('layouts.app')
    @section('content')

    <link href="{{ asset('assets/theme/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/theme/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEAD-->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>Menu
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
                             <i class="fa fa-plus font-red-sunglo"></i>
                             <span class="caption-subject font-red-sunglo bold uppercase">Tambah Menu</span>
                             <!-- <span class="caption-helper">form actions on top...</span> -->
                          </div>
                          <div class="actions">
                             <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;" title="Refresh Halaman" onclick="location.reload()">
                                <i class="fa fa-refresh"></i>
                             </a>
                          </div>
                       </div>
                       <div class="portlet-body form">
                          
                          {!! Form::open(['route' => $route_store, 'id' => 'form_number']) !!}
                             <div class="form-body">
                                <!--@left-->
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <table class="table table-siak borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td>number_1</td>
                                                            <td>:</td>
                                                            <td>
                                                                {{ Form::text('number_1', '', ['class' => 'form-control']) }}
                                                                {!! $errors->first('number_1', '<span class="help-block form-messages">:message</span>') !!}
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
                                                            <td>number_2</td>
                                                            <td>:</td>
                                                            <td>
                                                                {{ Form::text('number_2', '', ['class' => 'form-control']) }}
                                                                {!! $errors->first('number_2', '<span class="help-block form-messages">:message</span>') !!}
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
                                                            <td>texts (required)</td>
                                                            <td>:</td>
                                                            <td>
                                                                {{ Form::text('texts', '', ['class' => 'form-control']) }}
                                                                {!! $errors->first('texts', '<span class="help-block form-messages">:message</span>') !!}
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
                                                        <button type="submit" class="btn green">Simpan</button>
                                                        <a href="{{ route($route_index) }}" class="btn default">Kembali</a>
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

    <script src="{{ asset('assets/theme/global/plugins/jquery-number/jquery.number.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    <script type="text/javascript">
	<?= \Helper::number_formats('$("input[name=\'number_1\']")', 'js') ?>
	<?= \Helper::number_formats('$("input[name=\'number_2\']")', 'js') ?>



    </script>

	<!-- {!! JsValidator::formRequest('App\Http\Requests\app_management\NumberRequest', '#form_number'); !!} -->



@endsection