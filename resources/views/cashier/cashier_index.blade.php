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
            body{
                /*font-family: 'Ubuntu Condensed', sans-serif;
                background-color: #ebedf2;*/
            }
            div.gallery {
              margin-left:20px;
              margin-top: 10px;
              border: 1px solid white;
              float: left;
              cursor: pointer;
              /*height: 150px;
              flex: 0 0 20%;*/
              flex: 0 0 25%;
              max-width: 25%;
              max-width: 20%;
            }

            div.gallery:hover {
              box-shadow: 0 2px 4px 0 rgba(0,0,0,0.12);
            }

            div.gallery img {
              width: 100%;
              height: auto;
            }

            div.desc {
              font: 400 12px "Helvetica Neue", Helvetica, Arial, "Cantarell", sans-serif;
              padding: 5px;
              text-align: center;
            }
            .back_dashboard{
                margin-left: 20px;
            }
            .table-sale-td{
                cursor:pointer;
            }
            input[name=grand_total_view] {    
                font-weight:bold;
            }   
            header {
                background-color: #34bfa3;
                box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
                border-color: #268d78;
            }
            .modal-header {
                background:#34bfa3;
                border-radius:4px;
                transition:all .5s ease-in-out;
             }
             .modal-header h5 {
                color: #fff !important;
             }
             .modal-header button {
                color: #fff !important;  
             }
            .toast-order {
                top: 9%;
                right: 2%;
            }
        </style>
    </head>
    <!-- end::Head -->

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
                            <input name="cashier-invoice" type="text" class="form-control m-input" value="{{ $invoice  }}" disabled style="background-color:#ffffff">
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <br />
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body" style="margin-left:50px;margin-top: 50px;">
            <div class="col-lg-6 col-xs-12"> 
                <button type="button" class="btn btn-outline-success" style="width:100px" data-toggle="modal" data-target="#modal_category">Category</button>
                <button type="button" class="btn btn-outline-success" style="width:100px;margin-left:20px;" data-toggle="modal" data-target="#modal_brand">Brand</button>

                <div class="row gallery-content" style="margin-top: 20px;">
                    @foreach($products as $product)
                        <div class="gallery" data-id="{{ $product->id }}" data-category="{{ $product->product_category->id }}" data-brand="{{ $product->brand->id }}" data-code="{{ $product->code}}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}" data-original-stock="{{ $product->stock }}">
                          <a>
                            <img src="{{ \Helper::getImage('product',$product->image) }}" alt="{{ $product->name}}" data-skin="dark" data-toggle="m-tooltip" data-placement="top" title="Stock : {{ $product->stock }}">
                          </a>
                          <div class="desc">{{ strlen($product->name) > 12 ? substr($product->name,0,12)."..." : $product->name }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
            <br />
            <div class="col-lg-6 col-xs-12"> 
                <div class="m-portlet m-portlet--success m-portlet--head-solid-bg m-portlet--bordered" style="margin-right: 50px;height:auto;">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                    <i class="fa fa-shopping-cart"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Current Sale
                                </h3>
                            </div>          
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <div class="m-input-icon m-input-icon--left">
                                        <select name="product" class="form-control" class="form-control form-control-sm m-input">
                                            <option value=""></option>
                                          @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option> 
                                          @endforeach
                                        </select>
                                    </div>
                                </li>                       
                                
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="table-responsive"  style="height:300px">
                            <table class="table table-sale" id="table-order">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody class='table-sale-tbody'>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="input-group m-input-group m-input-group--square" style="font-size: 24px;">                       
                        <div class="input-group-prepend total-info">
                            <span class="input-group-text"><strong>Total</strong></span>
                        </div>
                            <input name="grand_total_view" type="text" class="form-control m-input" disabled placeholder="">
                        <input style="display:none" name="grand_total" type="text" class="form-control m-input" placeholder="">
                    </div>
                </div>
            <div class="pull-right" style="margin-right: 50px;">
                <button type="button" class="btn btn-metal discount_order"><span class="fa fa-tag"></span>&nbsp;&nbsp; 
                Discount
                </button>
                <button type="button" class="btn btn-danger clear_order"><span class="fa fa-trash"></span>&nbsp;&nbsp; 
                Clear Order
                </button>
                <button type="button" class="btn btn-success text-left btn-pay-order" style="width:150px"><span class="fa fa-hand-holding-usd"></span>&nbsp;&nbsp; Pay: <span class="pay-total"></span></button>
            </div>
        </div>
    </div>
        <div class="back_dashboard">
            <ul class="m-topbar__nav m-nav m-nav--inline">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-success m-btn m-btn--icon m-btn--pill">
                    <span>
                        <i class="fa fa-arrow-alt-circle-left"></i>
                        <span>Back to Dashboard</span>
                    </span>
                </a>
            </ul>
        </div>
    
    <br />

        <!-- Modal Category -->
        <div class="modal fade" id="modal_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Category Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                @foreach($category as $c)
                    <button class="btn m-btn--pill m-btn--air btn-outline-info m-btn m-btn--custom m-btn--outline-2x btn-filter-category" data-id="{{ $c->id }}"><span class="fa fa-uncheck"></span> {{ $c->name }}</button>
                @endforeach
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary reset-category">Reset</button>
                <button type="button" class="btn btn-success set-category">Save changes</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal Category -->

        <!-- Modal Brand -->
        <div class="modal fade" id="modal_brand" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Brand Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
               @foreach($brands as $brand)
                    <button type="button" class="btn m-btn--pill m-btn--air btn-outline-info m-btn m-btn--custom m-btn--outline-2x btn-filter-brand" data-id="{{ $brand->id }}"><span class="fa fa-uncheck"></span> {{ $brand->name }}</button>
                @endforeach
              </div>
              <div class="modal-footer">    
                <button type="button" class="btn btn-secondary reset-brand">Reset</button>
                <button type="button" class="btn btn-success set-brand">Save changes</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal Category -->

        <!-- Modal Clear Order -->
        <div class="modal fade" id="modal_clear_order" tabindex="-1111" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Clear Order?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>
                    This will replace current order's item(s) with blank order.
                </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success set-order-clear">Ok</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Clear Order -->

        <!-- Modal Order -->
        <div class="modal fade" id="modal_order" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Discount (Nominal) <span class="mt-product-name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-right">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group">
                            <label>Qty</label>
                            <input type="number" name="modal-order-qty" class="form-control m-input">
                        </div>
                        <div class="form-group m-form__group">
                            <label>Discount</label>
                            <input type="text" name="modal-order-discount" class="form-control m-input">
                        </div>
                        <div class="form-group m-form__group">
                            <label>Total</label>
                            <input type="text" name="modal-order-total" class="form-control m-input">
                        </div>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success set-order-price">Save changes</button>
              </div>    
            </div>
          </div>
        </div>
        <!-- End Modal Category -->

        <!-- Modal Order Discount-->
        <div class="modal fade" id="modal_discount_order" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Discount (Nominal)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-right">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group">
                            <label>Discount</label>
                            <input type="text" name="modal-discount-discount" class="form-control m-input">
                        </div>
                        <div class="form-group m-form__group">
                            <label>Subtotal</label>
                            <input type="text" name="modal-discount-subtotal" class="form-control m-input" readonly>
                        </div>
                        <div class="form-group m-form__group">
                            <label>Total</label>
                            <input type="text" name="modal-discount-total" class="form-control m-input" readonly>
                        </div>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success set-order-discount">Save changes</button>
              </div>    
            </div>
          </div>
        </div>
        <!-- End Modal Order Discount -->

        <!-- Modal Pay Order -->
        <div class="modal fade" id="modal_pay_order" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Amount to pay: &nbsp; <strong><span class="amount-to-pay"></span></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-left">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <label class="col-4 col-form-label"><h4>Amount Tendered</h4></label>
                            <div class="col-8">
                                <div class="input-group m-input-group">
                                    <input style="font-size:16px;font-weight:bold" type="text" class="form-control m-input" name="amount-pay-input" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <a class="btn m-btn m-btn--pill m-btn--gradient-from-accent m-btn--gradient-to-success pull-right show-change" style="cursor:default;width:300px;font-style: italic;font-size:20px;font-weight:bold;margin-right: 20px;color:white;display:none">Change &nbsp;:&nbsp; <span class="amount-change"></span></a>

                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success proceed-pay-order">Proceed</button>
              </div>    
            </div>
          </div>
        </div>
        <!-- End Modal Category -->
</html>

<script type="text/javascript">
    $(document).ready(function(){
        $("select[name='product']").select2({minimumInputLength: 3, width: "resolve", placeholder: "Search product by name or code" });
        $("select[name='discount']").select2({width: "100%", placeholder: "-- Select Discount --" });

        if(jQuery.isEmptyObject({!! $theCashier !!})){
            swal({ 
                title: "Error",
                text: "Employee not found",
                type: "error" 
            }).then(function() {
                $(location).attr('href', '{{ route('dashboard') }}');
            });   
        }
        let total            = 0;
        var categorySelected = [];
        var brandSelected    = [];

        /*  FILTER PRODUCT */
        // set button behaviour and set array category and brand
        $('.btn-filter-category').on('click', function(){
            catId = $(this).attr('data-id');

            if($(this).hasClass('btn-outline-info')){
                $(this).find('.fa-uncheck').removeClass('fa-uncheck').addClass('fa-check');
                $(this).removeClass('btn-outline-info');
                $(this).addClass('btn-info');

                categorySelected.push(catId);
            } else {
                $(this).find('.fa-check').removeClass('fa-check').addClass('fa-uncheck');
                $(this).removeClass('btn-info');
                $(this).addClass('btn-outline-info');

                index = categorySelected.indexOf(catId);
                categorySelected.splice(index, 1);
            }
        })

        $('.btn-filter-brand').on('click', function(){
            brandId = $(this).attr('data-id');
            if($(this).hasClass('btn-outline-info')){
                $(this).find('.fa-uncheck').removeClass('fa-uncheck').addClass('fa-check');
                $(this).removeClass('btn-outline-info');
                $(this).addClass('btn-info');

                brandSelected.push(brandId);
            } else {
                $(this).find('.fa-check').removeClass('fa-check').addClass('fa-uncheck');
                $(this).removeClass('btn-info');
                $(this).addClass('btn-outline-info');

                index = brandSelected.indexOf(brandId);
                brandSelected.splice(index, 1);
            }
        })

        // reset category and brand function
        $('.reset-category').on('click', function(){
            categorySelected = [];
            theSelected = $("#modal_category").find('.btn-info');
            $(theSelected).each( function( i, v ) {
                $(this).find('.fa-check').removeClass('fa-check').addClass('fa-uncheck');
                $(this).removeClass('btn-info');
                $(this).addClass('btn-outline-info');
            });
                
            mApp.block("#modal_category .modal-content");

            filterProduct(categorySelected,brandSelected);

            mApp.unblock("#modal_category .modal-content");
            $("#modal_category").modal('hide');
        })

        $('.reset-brand').on('click', function(){
            brandSelected = [];
            theSelected = $("#modal_brand").find('.btn-info');
            $(theSelected).each( function( i, v ) {
                $(this).find('.fa-check').removeClass('fa-check').addClass('fa-uncheck');
                $(this).removeClass('btn-info');
                $(this).addClass('btn-outline-info');
            });
                
            mApp.block("#modal_brand .modal-content");

            filterProduct(categorySelected,brandSelected);

            
            mApp.unblock("#modal_brand .modal-content");
            $("#modal_brand").modal('hide');
        })
    
        // set category and brand function
        $('body').on('click', '.set-category', function(){
            $(this).attr('disabled', 'disabled');
            mApp.block("#modal_category .modal-content");

            filterProduct(categorySelected,brandSelected);

            $(this).removeAttr('disabled');
            mApp.unblock("#modal_category .modal-content");
            $("#modal_category").modal('hide');
        })        

        $('body').on('click', '.set-brand', function(){
            $(this).attr('disabled', 'disabled');
            mApp.block("#modal_brand .modal-content");

            filterProduct(categorySelected,brandSelected);

            $(this).removeAttr('disabled');
            mApp.unblock("#modal_brand .modal-content");
            $("#modal_brand").modal('hide');
        })

        // filter product function
        function filterProduct(categorySelected,brandSelected){
            $(".gallery-content").empty();
            $.ajax({
                method: 'GET',
                url: '{{ $url_ajax_filter_product }}',
                data: {catSelected: categorySelected,brandSelected:brandSelected},
                success: function(msg){

                    content       = "";

                    if(msg.length > 0){
                        $.each(msg, function(i,v){
                            content += '<div class="gallery col-lg-2" data-id="'+v._id+'" data-category="'+v.cat_id+'" data-brand="'+v.brand_id+'" data-code="'+v.code+'" data-price="'+v.price+'">';
                            content += '<a><img src="'+v.image.encoded+'" alt="'+v.desc+'"></a>';
                            content += '<div class="desc">'+v.desc+'</div></div>';
                        });
                    }
                    $(".gallery-content").append(content);
                    
                },
                error: function(err){
                    alert(JSON.stringify(err));
                }
            });
        }
        /*  END FILTER PRODUCT */

        /*  GALLERY PRODUCT */
        // on click product then add product to current sale
        $('body').on('click', '.gallery', function(){
            let id        = $(this).attr('data-id');
            let code      = $(this).attr('data-code');
            let price     = parseFloat($(this).attr('data-price'));
            let img       = $(this).find('img').attr('src');
            let name      = $(this).find('.desc').html();
            let stock     = parseInt($(this).attr('data-stock'));

            if(stock < 1){
                swal('Out of stock', 'Please fill stock', 'error');
                return false;
            } else {
                stock -= 1;
                setStock(this, stock);
            }
            

            total    += price;
            // check table is product listed
            checkContent = $('.table-sale-tbody').find('.table-sale-tr[data-id="'+id+'"]');

            if(checkContent.length > 0){
                oldQty   = parseInt(checkContent.find('.qty').html());
                oldTotal = parseFloat(checkContent.find('.total').html());
                checkContent.find('.qty').html(oldQty + 1);
                checkContent.find('.total').html(oldTotal + price);
                checkContent.find('.total-view').html(oldTotal + price);
            } else {
                // create content
                content  = '<tr class="table-sale-tr" data-id="'+id+'">';

                content += '<td class="table-sale-remove"><span class="fa delete-per-order fa-times m--font-danger" style="cursor:pointer"></span></td>';
                content += '<td class="table-sale-td name"> '+name+'</td>';
                content += '<td class="table-sale-td code"> '+code+'</td>';
                content += '<td class="table-sale-td qty" data-stock='+ stock +'>  '+1+'</td>';
                content += '<td class="table-sale-td price">'+price+'</td>';
                content += '<td class="table-sale-td discount" style="color:red;">&emsp;&emsp;-</td>';
                content += '<td class="table-sale-td total-view">'+price+'</td>';
                content += '<td class="total" style="display:none;">'+price+'</td>';
                content += '</tr>';
                $('.table-sale-tbody').append(content);
            }       

            $('input[name="grand_total"]').val(total);
            $('input[name="grand_total_view"]').val(total);
            $('.pay-total').html(total);

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": false,
              "positionClass": "toast-order",
              "preventDuplicates": true,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            };

            toastr.info("New order has been placed!");

            <?= \Helper::number_formats('$(".price")', 'js', 0) ?>
            <?= \Helper::number_formats('$(".total-view")', 'js', 0) ?>
            <?= \Helper::number_formats('$(".pay-total")', 'js', 0) ?>
            <?= \Helper::number_formats('$("input[name=\'grand_total_view\']")', 'js', 0) ?>
        });
        /*  END GALLERY PRODUCT */

        /*  CURRENT SALE */
        // on selected product then add product to current sale
        $('body').on('change', 'select[name="product"]', function(){
            let id          = $(this).children("option:selected").val();
            let galSelected = $('.gallery[data-id="'+id+'"]');
            let code        = $(galSelected).attr('data-code');
            let stock       = parseInt($(galSelected).attr('data-stock'));
            let price       = parseFloat($(galSelected).attr('data-price'));
            let img         = $(galSelected).find('img').attr('src');
            let name        = $(galSelected).find('.desc').html();

            if(stock < 1){
                $(this).val('').trigger('change.select2');
                swal('Out of stock', 'Please fill stock', 'error');
                return false;
            } else {
                stock -= 1;
                setStock(galSelected, stock);
            }

            total    += price;

            
            // check table is product listed
            checkContent = $('.table-sale-tbody').find('.table-sale-tr[data-id="'+id+'"]');

            if(checkContent.length > 0){
                oldQty   = parseInt(checkContent.find('.qty').html());
                oldTotal = parseFloat(checkContent.find('.total').html());
                checkContent.find('.qty').html(oldQty + 1);
                checkContent.find('.total').html(oldTotal + price);
                checkContent.find('.total-view').html(oldTotal + price);
            } else {
                // create content
                content  = '<tr class="table-sale-tr" data-id="'+id+'">';

                content += '<td class="table-sale-remove"><span class="fa delete-per-order fa-times m--font-danger" style="cursor:pointer"></span></td>';
                content += '<td class="table-sale-td name"> '+name+'</td>';
                content += '<td class="table-sale-td code"> '+code+'</td>';
                content += '<td class="table-sale-td qty" data-stock='+ stock +'>  '+1+'</td>';
                content += '<td class="table-sale-td price">'+price+'</td>';
                content += '<td class="table-sale-td discount" style="color:red;">&emsp;&emsp;-</td>';
                content += '<td class="table-sale-td total-view">'+price+'</td>';
                content += '<td class="total" style="display:none;">'+price+'</td>';
                content += '</tr>';
                $('.table-sale-tbody').append(content);
            }            
            $('input[name="grand_total"]').val(total);
            $('input[name="grand_total_view"]').val(total);
            $('.pay-total').html(total);
            $(this).val('').trigger('change.select2');

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": false,
              "positionClass": "toast-order",
              "preventDuplicates": true,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            };

            toastr.info("New order has been placed!");

            <?= \Helper::number_formats('$(".price")', 'js', 0) ?>
            <?= \Helper::number_formats('$(".total-view")', 'js', 0) ?> 
            <?= \Helper::number_formats('$(".pay-total")', 'js', 0) ?>
            <?= \Helper::number_formats('$("input[name=\'grand_total_view\']")', 'js', 0) ?>
        });
        $('body').on('click', '.clear_order', function(){
            $("#modal_clear_order").modal('toggle');
            // $('.table-sale-tbody').remove();
            // $('input[name="grand_total"]').val('');
            // $('input[name="grand_total_view"]').val('');
        });

        $('body').on('click', '.set-order-clear', function(){
            total = 0;
            // reset stock
            $.each( $('.gallery'), function( key, value ) {
              let oriStock = $(value).attr('data-original-stock');
              $(value).attr('data-stock', oriStock);
              $(value).find('img').attr('data-original-title', 'Stock : '+oriStock).tooltip('show');
            });

            $('.table-sale-tbody').empty();
            $('input[name="grand_total"]').val('');
            $('input[name="grand_total_view"]').val('');
            $('.pay-total').html('');
            $('.discount-info').remove();
            $("#modal_clear_order").modal('hide');            

            toastr.error("Order has been cleared!");
        })

        $('body').on('click', '.delete-per-order', function(){
            var thisTr    = $(this).parent().parent();
            var thisTotal = parseInt($(thisTr).find('.total').html());
            var idProduct = $(thisTr).attr('data-id');
            var oriStock  = $('.gallery[data-id='+ idProduct+']').attr('data-original-stock')
            var subtotal  = $('input[name="subtotal"]').length > 0 ? $('input[name="subtotal"]').val() : null;

            // restore stock
            $(thisTr).find('.qty').attr('data-stock', oriStock);
            $('.gallery[data-id='+ idProduct+']').attr('data-stock', oriStock);
            $('.gallery[data-id='+ idProduct+']').find('img').attr('data-original-title', 'Stock : '+oriStock).tooltip('show');

            total         = total - thisTotal;
            thisTr.remove();

            // if($('.table-sale-td').length < 1) {
            //     var disc = parseInt($('input[name=discount]').val());
            //     console.log(disc)
            //     total = total + disc;
            //     $('.discount-info').remove();
            // } else {
            //     $('input[name="subtotal"]').val(subtotal - thisTotal);                
            // }
            $('input[name="grand_total"]').val(total);
            $('input[name="grand_total_view"]').val(total);
            $('.pay-total').html(total);

            <?= \Helper::number_formats('$(".pay-total")', 'js', 0) ?>

            toastr.error("Order has been deleted!");
        })

        $('body').on('click', '.table-sale-td', function(){
            var thisTr   = $(this).parent();
            var mid      = $(thisTr).attr('data-id');
            var mname    = $(thisTr).find('.name').html();
            var mqty     = $(thisTr).find('.qty').html().trim();
            var maxStock = $(thisTr).find('.qty').attr('data-stock');
            var mprice   = $(thisTr).find('.price').html().replace('.','');
            var mtotal   = $(thisTr).find('.total').html().replace('.','');
            var mdisc    = $(thisTr).find('.discount').html().replace('.','');

            $('.mt-product-name').html(mname);
            $('.mt-product-name').parent().attr('data-id', mid);

            $('input[name="modal-order-qty"]').val(mqty);
            $('input[name="modal-order-qty"]').attr('data-stock', mqty);
            $('input[name="modal-order-qty"]').attr('max-stock', maxStock);
            $('input[name="modal-order-total"]').val(mtotal);
            $('input[name="modal-order-discount"]').val(mdisc);

            <?= \Helper::number_formats('$("input[name=\'modal-order-total\']")', 'js', 0) ?>
            <?= \Helper::number_formats('$("input[name=\'modal-order-total\']")', 'js', 0) ?>
            $("#modal_order").modal('show');
        })

        // discount cant higher than order price
        $('body').on('input', 'input[name=modal-order-discount]', function(){
            var discPrice  = parseInt($(this).val().replace('.',''));
            var id         = $('#modal_order').find('.modal-title').attr('data-id');
            var tdPrice    = parseInt($('.table-sale-tr[data-id='+id+']').find('.price').html().replace('.',''));
            var tdTotal    = parseInt($('.table-sale-tr[data-id='+id+']').find('.total').html().replace('.',''));
            var tdDisc     = parseInt($('.table-sale-tr[data-id='+id+']').find('.discount').html().replace('.',''));
            var qty        = $('input[name=modal-order-qty]').val().trim();
            var mtotal     = parseInt($('input[name=modal-order-total]').val());
            var fTotal     = qty * tdPrice;

            if(discPrice > mtotal){
                swal("discount not allowed higher than order price");
                $(this).val(tdDisc);
                $('input[name=modal-order-total]').val(tdTotal);
            } else {
                var total = fTotal - discPrice;
                $("input[name=modal-order-total]").val(total);
                <?= \Helper::number_formats('$("input[name=modal-order-total]")', 'js', 0) ?>                
            }
        
            
        })

        // qty min 1
        $('body').on('input', 'input[name=modal-order-qty]', function(){
            var _this     = $(this);
            var maxStock  = _this.attr('max-stock');
            var oldStock  = _this.attr('data-stock');
            var thisId    = $('#modal_order').find('.modal-title').attr('data-id');
            var price     = $('.table-sale-tr[data-id='+thisId+']').find('.price').html().replace('.','');
            var qty       = parseInt(_this.val().trim());
            var disc      = $('input[name=modal-order-discount]').val().replace('.','');

            if(qty > maxStock){
                swal('Out of stock', 'Please fill stock', 'error');
                _this.val(oldStock);
            }else if(qty < 1){
                swal("Quantity not allowed less than 1");
                _this.val('1');
            } else {
                var total = qty * price - disc; 
                $("input[name=modal-order-total]").val(total);
                <?= \Helper::number_formats('$("input[name=modal-order-total]")', 'js', 0) ?>               
            }
             
        })

        $('body').on('click', '.set-order-price', function(){
            $(this).attr('disabled', 'disabled');
            mApp.block("#modal_order .modal-content");

            var thisId     = $(this).parent().siblings('.modal-header').find('.modal-title').attr('data-id');
            var theTr      = $('.table-sale-tr[data-id='+thisId+']');
            var tdTotal    = $(theTr).find('.total');
            var oldTotal   = $(theTr).find('.total').html().replace('.','');
            var tdTotalV   = $(theTr).find('.total-view');
            var tdQty      = $(theTr).find('.qty');
            var tdDisc     = $(theTr).find('.discount');
            var grandTotal = $('input[name="grand_total"]').val();
            // get input value
            var mqty   = $('input[name="modal-order-qty"]').val();
            var mtotal = $('input[name="modal-order-total"]').val();
            var mdisc  = $('input[name="modal-order-discount"]').val();

            // if(mdisc != '' && mdisc != '0'){
            //     tdDisc.html(mdisc);
            //     total -= mdisc;
            // }

            var fTotal = (parseInt(grandTotal) - parseInt(oldTotal) + parseInt(mtotal));
            $('input[name="grand_total"]').val(fTotal);
            $('input[name="grand_total_view"]').val(fTotal);
            $('.pay-total').html(fTotal);

            tdQty.html(mqty);
            tdDisc.html(mdisc);
            tdTotal.html(mtotal);
            tdTotalV.html(mtotal);
            total = parseInt(total) - parseInt(oldTotal) + parseInt(mtotal);

            <?= \Helper::number_formats('$(".total-view")', 'js', 0) ?>
            <?= \Helper::number_formats('$(".discount")', 'js', 0) ?>
            <?= \Helper::number_formats('$(".pay-total")', 'js', 0) ?>
            <?= \Helper::number_formats('$("input[name=\'grand_total_view\']")', 'js', 0) ?>

            $(this).removeAttr('disabled');
            mApp.unblock("#modal_order .modal-content");
            $("#modal_order").modal('hide');
        })

        $('body').on('click', '.discount_order', function(){
            var total = $('input[name="grand_total"]').val();
            
            if($('.discount-info').length > 0){
                var subtotal = $('input[name="subtotal"]').val();
                var discount = $('input[name="discount"]').val();
                $('input[name=modal-discount-subtotal]').val(subtotal);
                $('input[name=modal-discount-total]').val(total);
                $('input[name=modal-discount-discount]').val(discount);
                <?= \Helper::number_formats('$("input[name=modal-discount-subtotal]")', 'js', 0) ?>
                <?= \Helper::number_formats('$("input[name=modal-discount-total]")', 'js', 0) ?>

                    $("#modal_discount_order").modal('toggle');
            } else {
                $('input[name=modal-discount-discount]').val('');
                if(total == ''){
                    swal('No order for discount');
                } else {
                    $('input[name=modal-discount-subtotal]').val(total);
                    $('input[name=modal-discount-total]').val(total);
                    <?= \Helper::number_formats('$("input[name=modal-discount-subtotal]")', 'js', 0) ?>
                    <?= \Helper::number_formats('$("input[name=modal-discount-total]")', 'js', 0) ?>

                    $("#modal_discount_order").modal('toggle');
                }
            }
            
        })

        // discount cant higher than order total
        $('body').on('input', 'input[name=modal-discount-discount]', function(){
            var disc     = parseInt($(this).val().replace('.',''));
            var total    = $('input[name="grand_total"]').val();
            var subtotal = $('input[name="modal-discount-subtotal"]').val();
            var subtotal = $('input[name="modal-discount-subtotal"]').val();

            if(disc > subtotal){
                swal("Discount not allowed higher than total");
                $(this).val('0');
                $("input[name=modal-discount-total]").val(subtotal);
            } else {
                var grandTotal = subtotal - disc;
                $("input[name=modal-discount-total]").val(grandTotal);
                <?= \Helper::number_formats('$("input[name=modal-discount-total]")', 'js', 0) ?>
            }            
        })

        $('body').on('click', '.set-order-discount', function(){
            $(this).attr('disabled', 'disabled');
            mApp.block("#modal_discount_order .modal-content");

            var subtotal = $('input[name="modal-discount-subtotal"]').val();
            var disc     = $("input[name=modal-discount-discount]").val();
            

            if(disc != '' && disc != '0'){
                total = total - disc;

                if($('.discount-info').length > 0){
                    $('input[name="subtotal"]').val(subtotal);
                    $('input[name="discount"]').val(disc);
                    $('input[name="grand_total"]').val(subtotal - disc);
                    $('input[name="grand_total_view"]').val(subtotal - disc);
                } else {
                    content  = '<div class="input-group-prepend discount-info">';
                    content += '<span class="input-group-text">Subtotal</span></div>';
                    content += '<input name="subtotal" type="text" class="form-control m-input discount-info" disabled value="'+subtotal+'">';
                    content += '<div class="input-group-prepend discount-info">';
                    content += '<span class="input-group-text" style="color:red">Discount</span></div>';
                    content += '<input name="discount" type="text" class="form-control m-input discount-info" disabled value="'+disc+'" style="color:red">';
                    $(content).insertBefore('.total-info');

                    $('input[name="grand_total"]').val(subtotal - disc);
                    $('input[name="grand_total_view"]').val(subtotal - disc);
                    $('.pay-total').html(subtotal - disc);
                }
                
                <?= \Helper::number_formats('$("input[name=subtotal]")', 'js', 0) ?>
                <?= \Helper::number_formats('$("input[name=discount]")', 'js', 0) ?> 
                <?= \Helper::number_formats('$(".pay-total")', 'js', 0) ?>   
            }
            

            $(this).removeAttr('disabled');
            mApp.unblock("#modal_discount_order .modal-content");
            $("#modal_discount_order").modal('hide');
        })

        $('.btn-pay-order').on('click', payThisOrder);
        $('.proceed-pay-order', '#modal_pay_order').on('click', proceedPayOrder);

        function payThisOrder(){
            var $tableTr     = $('.table-sale-tr');
            var $payBtn      = $('.pay-total', '.btn-pay-order').html();
            var $payTotal    = parseInt($payBtn.replace('.',''));
            var $payInput    = $('input[name=amount-pay-input]');
            var $changeInfo  = $('.show-change', '#modal_pay_order');
            $changeInfo.css('display', 'none');

            if($tableTr.length > 0){
                $('.amount-to-pay', '#modal_pay_order').html($payBtn);
                $payInput.val($payTotal);
                $('#modal_pay_order').modal('toggle');

                // pay behaviour
                $payInput.on('input', payBehaviour);

                function payBehaviour(){
                    thisVal = $(this).val();
                    if(thisVal > $payTotal){
                        var amount = parseInt(thisVal)-$payTotal;
                        $('.amount-change').html(amount);
                        <?= \Helper::number_formats('$(".amount-change")', 'js', 0) ?>
                        $changeInfo.css('display', 'block');

                    } else {
                        $changeInfo.css('display', 'none');
                    }
                }
            } else {
                swal('error', 'No order can be processed','error')
            }
        }

        function proceedPayOrder(){
            var $amountToPay    = $('.amount-to-pay', '#modal_pay_order').html().replace('.','');
            var $amountTendered = $('input[name=amount-pay-input]').val().replace('.','');
            var $change         = $('.amount-change').html().replace('.','');

            if(parseInt($amountTendered) < parseInt($amountToPay)){
                $('input[name=amount-pay-input]').val('0');
                swal('', 'Amount tendered less than amount to pay', 'error');
            } else {
                $(this).attr('disabled', 'disabled');
                mApp.block("#modal_pay_order .modal-content");

                if($('.table-sale-tr').length > 0){
                    var lastCashier = {!! $theCashier !!};
                    var invoice     = $('input[name=cashier-invoice]').val();
                    var products    = $('.table-sale-tr', '#table-order');
                    var order       = [];
                    for (var i = 0; i < products.length; i++) {
                        var product    = products[i];
                        var obj        = {}; 
                        obj['id']      = $(product).attr('data-id');
                        obj['qty']     = $(product).find('.qty').html().trim();
                        obj['disc']    = isNaN($(product).find('.discount').html()) === false ? 
                                         $(product).find('.discount').html().replace('.','') : 
                                         0;
                        obj['total']   = $(product).find('.total').html();
                        order.push(obj);
                    }

                    $.ajax({
                      type: "POST",
                      headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      url: '{{ route('cashier.cashier.ajax_pay_order') }}',
                      data: { 
                              cashierId: lastCashier.id,
                              invoice: invoice,
                              billAmount: $amountToPay,
                              payAmount: $amountTendered,
                              change:$change,
                              order: order
                            },
                      dataType: 'json',
                      success: function(msg){
                        if('invoice' in msg){
                            $(this).removeAttr('disabled');
                            mApp.unblock("#modal_pay_order .modal-content");
                            var redirect = "cashier/ajax_complete_order/"+msg.invoice;
                            $(location).attr('href', redirect);
                        } else {
                            $(this).removeAttr('disabled');
                            mApp.unblock("#modal-open-close-cashier .modal-content");
                            $("#modal-open-close-cashier").modal('hide');
                            swal("Failed!", "Please refresh the page and retry again", "error");
                        }
                        //     $("#modal-open-close-cashier").modal('hide');
                        //     var text = url == 'close-cashier' ? 'closed' : 'opened';
                        //     swal({ 
                        //         title: "Success",
                        //         text: "Cashier "+text+" successfully",
                        //         type: "success" 
                        //     }).then(function() {
                        //         if(url == 'open-cashier'){
                        //             $(location).attr('href',$($linkCashier).attr('href'));  
                        //         } else {
                        //             $(location).attr('href', '{{ route('dashboard') }}');
                        //         }
                        //     });    
                        // } else {
                        //     $(this).removeAttr('disabled');
                        //     mApp.unblock("#modal-open-close-cashier .modal-content");
                        //     $("#modal-open-close-cashier").modal('hide');
                        //     swal("Failed!", "Please refresh the page and retry again", "error");    
                        // }
                        
                      },
                      error: function(err){
                        $(this).removeAttr('disabled');
                        mApp.unblock("#modal-open-close-cashier .modal-content");
                        $("#modal-open-close-cashier").modal('hide');
                        swal("Failed!", "Please refresh the page and retry again", "error");
                      }
                    });
                        
                }
                
            }
        }

        function setStock(el, stock){
            
            $(el).attr('data-stock', stock);
            $(el).find('img').attr('data-original-title', 'Stock : '+stock).tooltip('show');
        }

        //$('input[name="grand_total"]').val(total);
        <?= \Helper::number_formats('$("input[name=modal-order-discount]")', 'js', 0) ?>
        <?= \Helper::number_formats('$("input[name=modal-discount-discount]")', 'js', 0) ?>
        <?= \Helper::number_formats('$("input[name=amount-pay-input]")', 'js', 0) ?>
        $('input[name=date_transaction]').datepicker({format: "d M yyyy"});
    });
</script>

