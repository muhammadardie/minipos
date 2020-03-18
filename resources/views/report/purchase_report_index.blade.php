@extends('layouts.base')
    @section('content')
    <style>
        .datepicker {
            z-index: 100 !important;
        }
        .disabled.day {
            background-color: #cecece !important;
            border-radius: 0 !important;
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
                                    <i class="fa fa-file-signature"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Purchase Report
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class='m-form m-form--fit m-form--label-align-left'>
                        <div class="m-portlet__body">
                            <div class="col-md-12">
                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-2 col-sm-12">
                                        <span style="color:red" title="Wajib diisi">*</span>
                                        Start Date
                                    </label>
                                    <div class="col-lg-5 col-sm-12">
                                        <div class="input-group date">
                                            {{ Form::text('start_date', '', ['class' => 'form-control m-input', 'readonly' => 'readonly', 'placeholder' => 'Select Start Date']) }}
                                            {!! $errors->first('start_date', '<span class="help-block error-help-block">:message</span>'); !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-2 col-sm-12">
                                        <span style="color:red" title="Wajib diisi">*</span>
                                        End Date
                                    </label>
                                    <div class="col-lg-5 col-sm-12">
                                        <div class="input-group date">
                                            {{ Form::text('end_date', '', ['class' => 'form-control m-input', 'disabled' => 'disabled', 'placeholder' => 'Select End Date']) }}
                                            {!! $errors->first('end_date', '<span class="help-block error-help-block">:message</span>'); !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <br />
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <div class="row">
                                    <div class="col-md-offset-2">
                                        <span id="execute-loading" style="visibility: hidden;"><img src="{{ asset('assets/demo/default/media/img/misc/loading.gif') }}"></span>
                                        {{-- <a class="btn_submit btn btn-success" name="simpan">Submit</a> --}}
                                        <button type="button" name="simpan" class="btn btn-success">Submit</button>&nbsp;
                                        <a href="{{ route($route_index) }}" class="btn btn-secondary" class="cancel-report">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="loading-report hidden">
                            <center>
                                <img src="{{ asset('assets/images/loading.gif') }}" style="width:150px;height:150px;" />
                            </center>
                        </div>


                    </form>
               </div>  
                <!--end::Portlet-->    


            


            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        $(document).ready(function(){
            <?= \Helper::date_formats('$("input[name=\'start_date\']")', 'js') ?>

            $('input[name=start_date]').on('change', function(){
                let endDate = $(this).val().replace(/(..).(..).(....)/, "$3-$2-$1");
                $('input[name=end_date]').datepicker('destroy');
                $('input[name=end_date]').removeAttr('disabled');
                $('input[name=end_date]').datepicker({
                    format: 'dd-mm-yyyy',
                    startDate: new Date(endDate),
                    autoclose: true,
                });
            })

            /**
            * Action submit form
            */
            $('button[name=simpan]').on('click', function () {
                let startDate = $('input[name=start_date]').val();
                let endDate = $('input[name=end_date]').val();
                
                if(startDate != '' && endDate != ''){
                    $('#report_result').remove();
                    $('.loading-report').removeClass('hidden');
                    $('button[name=simpan]').attr('disabled', true);

                    $.ajax({
                      type: "POST",
                      headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      url: '{{ route('report.purchase_report.ajax_get_purchase_report') }}',
                      data: { 
                              startDate: startDate,
                              endDate: endDate,
                            },
                      dataType: 'html',
                      success: function(msg){
                            $('.loading-report').addClass('hidden');
                            $(msg).insertAfter('.loading-report');
                            $('button[name=simpan]').removeAttr('disabled');
                            $('body #report_result').removeClass('hidden');                        
                      },
                      error: function(err){
                        $('.loading-report').addClass('hidden');
                        $('button[name=simpan]').removeAttr('disabled');
                        swal("Failed!", "Please retry again", "error");
                      }
                    });
                    // $('button[name="simpan"]').attr('disabled', 'disabled');
                    // $('#execute-loading').css({'visibility': 'visible'});
                } else {
                    swal('Empty Date', 'Please fill start date and empty date', 'error');
                }
            });

            $('body').on('click', '.m-tabs__link' , function(){
                let href      = $(this).attr('href'),
                    startDate = $('input[name=start_date]').val(),
                    endDate   = $('input[name=end_date]').val(),
                    routePDF, 
                    routeXLS;

                if(href == '#tab_purchase'){

                    routePDF = '{{ route('report.purchase_report.ajax_generate_purchase_report', ['type' => 'purchase', 'file' => 'pdf', 'startDate' => 'startDate', 'endDate' => 'endDate']) }}';
                    routeXLS =  '{{ route('report.purchase_report.ajax_generate_purchase_report', ['type' => 'purchase', 'file' => 'xls', 'startDate' => 'startDate', 'endDate' => 'endDate']) }}';

                } else if(href == '#tab_product'){

                    routePDF = '{{ route('report.purchase_report.ajax_generate_purchase_report', ['type' => 'product', 'file' => 'pdf', 'startDate' => 'startDate', 'endDate' => 'endDate']) }}';
                    routeXLS =  '{{ route('report.purchase_report.ajax_generate_purchase_report', ['type' => 'product', 'file' => 'xls', 'startDate' => 'startDate', 'endDate' => 'endDate']) }}';

                }

                routePDF = routePDF.replace('startDate', startDate);
                routePDF = routePDF.replace('endDate', endDate);

                routeXLS = routeXLS.replace('startDate', startDate);
                routeXLS = routeXLS.replace('endDate', endDate);


                $('a.generate-pdf').attr('href', routePDF);
                $('a.generate-excel').attr('href', routeXLS);

            })
        });
    </script>
@endsection