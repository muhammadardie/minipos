<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="{{ config('app.locale') }}">
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        
        <title>{{ config('app.name', 'Laravel - Template') }}</title>
        <meta name="description" content="Base portlet examples"> 
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!--begin::Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
          WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>
        <!--end::Web font -->
        <!-- jquery -->

        
        <link href="https://fonts.googleapis.com/css?family=Ubuntu+Condensed" rel="stylesheet">
    
        <!--begin::Base Styles -->
        {{-- <link href="{{ asset('assets/vendors/custom/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
        <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" /><!--RTL version:<link href="../../assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
        <link href="{{ asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" /><!--RTL version:<link href="../../assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
        <link href="{{ asset('assets/demo/default/base/custom.bundle.css') }}" rel="stylesheet" type="text/css" /><!--Put your custom css in this custom css -->
        
        <!--begin::Base Scripts -->    
        <script src="{{ asset('assets/vendors/custom/jquery/jquery.min.js') }}"></script>    
        <script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
        <!--end::Base Scripts -->   

        <!--begin::Vendor Scripts -->  
        <script src="{{ asset('assets/demo/default/custom/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/demo/default/custom/components/base/sweetalert2.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-select.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/custom/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-timepicker.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/custom/jquery-number/jquery.number.min.js') }}"></script>    
        <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}" type="text/javascript"></script>
        <!--end::Vendor Scripts -->  
        <script src="{{ asset('assets/app/js/my-script.js') }}"></script>   
        
        <link rel="shortcut icon" href="{{ \Helper::getImage('template','icon.png',20,20) }}" /> 
        <style>
        header {
                background-color: #34bfa3;
                box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
                border-color: #268d78;
            }
            .back_dashboard{
                position: absolute;
                right: 10px;
                top: 10px;
                list-style: none;    padding: 0;
                margin: 0;
                z-index: 1031;
            }
        </style>
    </head>
    
    <body>

        <header class="m-grid__item m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
        <div class="m-container m-container--fluid m-container--full-height">
            <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">   
                <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                    <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel">
                        <div class="input-group m-input-group">
                            <div class="input-group-prepend" style="margin-left: 100px !important"><span class="input-group-text"><i class="fa fa-home"></i></span></div>
                            <input type="text" class="form-control m-input" value="{{ $emp->outlet->name}}" disabled style="background-color:#ffffff">
                        </div>
                    </li>
                    <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel">
                        <div class="input-group m-input-group">
                            <div class="input-group-prepend" ><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
                            <input name="date_transaction" type="text" class="form-control m-input" value="{{ date('d M Y') }}" disabled style="background-color:#ffffff">
                        </div>
                    </li>
                    <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel">
                        <div class="input-group m-input-group">
                            <div class="input-group-prepend" ><span class="input-group-text"><i class="fa fa-user"></i></span></div>
                            <input name="cashier-emp" type="text" class="form-control m-input" value="{{ $theCashier->employee->first_name.' '.$theCashier->employee->last_name  }}" disabled style="background-color:#ffffff">
                        </div>
                    </li>
                    <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel">
                        <div class="input-group m-input-group">
                            <div class="input-group-prepend" ><span class="input-group-text"><i class="fa fa-hashtag"></i></span></div>
                            <input name="cashier-invoice" type="text" class="form-control m-input" value="{{ $saleInvoice  }}" disabled style="background-color:#ffffff">
                        </div>
                    </li>
                </ul>
            </div>
            
            <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
                <div class="back_dashboard">
                    <ul class="m-topbar__nav m-nav m-nav--inline">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--pill">
                            <span>
                                <i class="fa fa-arrow-alt-circle-left"></i>
                                <span>Back to Dashboard</span>
                            </span>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <br />
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body" style="margin: 100px 100px;">

            <div class="row">
                    <div class="col-md-6">  
                        <!--begin::Portlet-->
                        <div class="m-portlet">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <span class="m-portlet__head-icon">
                                            <i class="fa fa-check"></i>
                                        </span>
                                        <h3 class="m-portlet__head-text">
                                            Order Complete
                                        </h3>
                                    </div>          
                                </div>
                                <div class="m-portlet__head-tools">
                                    <ul class="m-portlet__nav">
                                        <li class="m-portlet__nav-item">
                                            <!-- <a href="#" class="m-portlet__nav-link btn btn-danger">
                                                <i class="fa fa-file-pdf"></i>
                                                Print Receipt
                                            </a> -->
                                            <a href="{{ route('cashier.cashier.ajax_print_receipt', $invoice) }}" target="_blank" class="m-portlet__nav-link btn btn-secondary m-btn m-btn--air m-btn--icon m-btn--icon-only m-btn--pill" data-container="body" data-toggle="m-tooltip" data-placement="top" title="Print Receipt">

                                                <i class="fa fa-print"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="m-portlet__body" style="margin: 10px 20px;">
                                <div class="input-group m-input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div>
                                    <input type="text" class="form-control m-input" placeholder="Email Receipt" aria-describedby="basic-addon1">
                                    <button type="button" class="btn btn-metal btn-send-receipt">Send Receipt</button>
                                </div>
                                <br />
                                <center>
                                    <a href="{{ route('cashier.cashier.index') }}">
                                        <button type="button" class="btn btn-success">Back to Cashier</button>
                                    </a>    
                                </center>
                            </div>
                        </div>  
                        <!--end::Portlet-->
                    </div>

                    <div class="col-md-4">
                        <!--begin::Portlet-->
                        <div class="m-portlet" style="width:600px">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title" style="font-style: italic">
                                        <h3 class="m-portlet__head-text">
                                            INVOICE #{{ $invoice }}
                                        </h3>
                                    </div>          
                                </div>
                                <div class="m-portlet__head-tools">
                                    
                                </div>
                            </div>
                            <div class="m-portlet__body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>                                          
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Discount</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead> 
                                        <tbody>  
                                            @foreach($cashTrans as $trans)
                                                @foreach($trans->cashier_transaction_detail as $order)
                                                    <tr>
                                                        <td>{{ $order->product->name }}</td>
                                                        <td>{{ \Helper::number_formats($order->product->price, 'view', 0) }}</td>
                                                        <td>{{ $order->qty }}</td>
                                                        <td>{{ $order->discount != null ? \Helper::number_formats($order->discount, 'view', 0) : 0 }}</td>
                                                        <td>{{ \Helper::number_formats($order->total, 'view', 0) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach                            
                                        </tbody> 
                                    </table>
                                </div>
                            </div>
                            <div class="m-portlet__foot">
                                @foreach($cashTrans as $trans)
                                    <div class="row">
                                        <div class="col-lg-10 text-right">
                                            <h5>Subtotal</h5>
                                        </div>
                                        <div class="col-lg-2">
                                            {{ \Helper::number_formats($trans->pay_amount, 'view', 0) }}
                                        </div>
                                        <div class="col-lg-10 text-right">
                                            <h5>Discount</h5>
                                        </div>
                                        <div class="col-lg-2">
                                            {{ $trans->discount != null ? \Helper::number_formats($trans->discount, 'view', 0) : 0}}
                                        </div>
                                        <div class="col-lg-10 text-right">
                                            <h5>Total</h5>
                                        </div>
                                        <div class="col-lg-2">
                                            {{ \Helper::number_formats($trans->bill_amount, 'view', 0) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>  
                        <!--end::Portlet-->
                    </div>
        
        
            
        </div>
    </div>

    </body>

</html>

<script type="text/javascript">
    $(document).ready(function(){   
       $('.btn-send-receipt').on('click', sendReceipt);
       
       function sendReceipt(){
            var $email = $(this).prev().val();
            var invoice = '{{ $invoice }}';

            if(validateEmail($email) === true){
                mApp.blockPage();

                $.ajax({
                  type: "POST",
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: '{{ route('cashier.cashier.ajax_send_receipt') }}',
                  data: { 
                          email: $email,
                          invoice: invoice,
                        },
                  dataType: 'json',
                  success: function(msg){
                    console.log(msg)
                    if('status' in msg && msg.status == 'success'){
                        mApp.unblockPage();
                        swal("success", "Email has been sent", "success");
                    } else {
                        console.log(msg);
                        mApp.unblockPage();
                        swal("Failed!", "Please retry again", "error");
                    }
                    
                  },
                  error: function(err){
                    mApp.unblockPage();
                    swal("Failed!", "Please retry again", "error");
                  }
                });
            } else {
                $(this).prev().val('');
                swal("Invalid e-mail address", "", "error");
            }
       } 

       function validateEmail(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }

    });
</script>

