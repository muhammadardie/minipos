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

        
        
    
        <!--begin::Base Styles -->
        <link href="{{ asset('assets/vendors/custom/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" /><!--RTL version:<link href="../../assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
        <link href="{{ asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" /><!--RTL version:<link href="../../assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
        <link href="{{ asset('assets/vendors/custom/datatables-yajra/zenburn.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/demo/default/base/custom.bundle.css') }}" rel="stylesheet" type="text/css" /><!--Put your custom css in this custom css -->
        <link href="{{ asset('assets/vendors/custom/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->

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
        
        <link rel="shortcut icon" href="{{ asset('icon.png') }}" /> 
        <script>
                $('input,textarea').attr('autocomplete', 'off');
            
        </script>
    </head>
    <!-- end::Head -->

    @if(Auth::check())
        <!-- begin::Body -->
        <body  class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-light m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >

        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            @include('layouts.header')             
            
            <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                @include('layouts.sidebar')
                <div class="m-grid__item m-grid__item--fluid m-wrapper">  
                    @include('layouts.breadcrumb')
                    @yield('content')
                </div>
            </div>
            <!-- end:: Body -->
      
            @include('layouts.footer')
        </div>
        <!-- end:: Page -->
         
        </body>
        <!-- end::Body -->
    @else
        @yield('content')
    @endif

</html>
