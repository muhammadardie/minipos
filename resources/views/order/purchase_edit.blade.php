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
                                    <i class="fa flaticon-add"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Edit Purchase Order
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::open(['route' => [$route_update, $purchase_orders->id], 'id' => 'purchase_order_edit', 'class' => 'm-form m-form--fit m-form--label-align-left']) !!}
                    {{method_field('PATCH')}}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row {{ $errors->has('po_code') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Po Code
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::text('po_code', $purchase_orders->po_number, ['class' => 'form-control', 'readonly']) }}
                                    {!! $errors->first('po_code', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>

                            </div>
                            <div class="form-group m-form__group row {{ $errors->has('supplier') ? 'has-error' :'' }}">
                                <label class="col-form-label col-lg-2 col-sm-12">
                                    <span style="color:red" title="Wajib diisi">*</span>
                                    Supplier
                                </label>
                                <div class="col-lg-5 col-sm-12">
                                    {{ Form::select('supplier', $supplier, $purchase_orders->supplier_id, ['class' => 'form-control select2']) }}
                                    {!! $errors->first('supplier', '<span class="help-block error-help-block">:message</span>'); !!}
                                </div>
                            </div>     
                            @foreach($purchase_orders->purchase_order_detail as $pur_det)                
                                <div class="form-group m-form__group row form-repeat">
                                    <label class="col-form-label col-lg-2 col-sm-12">
                                        @if($loop->iteration == 1)
                                            <span style="color:red" title="Wajib diisi">*</span>
                                            Order
                                        @endif
                                    </label>
                                    
                                        <div class="col-lg-3 col-sm-12 for-count">
                                            {{ Form::select('product[]', $product, $pur_det->product_id, ['class' => 'form-control select2']) }}
                                                {!! $errors->first('product', '<span class="help-block error-help-block">:message</span>'); !!}
                                        </div>
                                        <div class="col-lg-2 col-sm-12">
                                            {{ Form::number('qty[]', $pur_det->qty , ['class' => 'form-control qty-product', 'placeholder' => 'Product Quantity']) }}
                                            {!! $errors->first('qty', '<span class="help-block error-help-block">:message</span>'); !!}
                                        </div>
                                </div>
                            @endforeach
                             <div class="m-form__group form-group row">
                                <label class="col-lg-2 col-form-label"></label>
                                <div class="col-lg-4">
                                    <div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide add-repeater">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span>Add</span>
                                        </span>
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

{!! JsValidator::formRequest('App\Http\Requests\order\Purchase_orderRequest', '#purchase_order_edit') !!}

    <script type="text/javascript">
        $(document).ready(function(){
            $("select[name='supplier']").select2({ placeholder: "{{ \Lang::get('select2.select_supplier') }}" });
            $("select[name='product[]']").select2({ placeholder: "{{ \Lang::get('select2.select_product') }}" });

            $('.repeater-button').on('click', function(){
                
            })

            
            
            // disable input on qty
            // $("[type='number']").keypress(function (evt) {
            //     evt.preventDefault();
            // });


            //$('body').on('change', '.select2-product', makeReadOnly);
            $('body').on('click', '.add-repeater', repeatOrder);
            $('body').on('click', '.delete-repeater', deleteOrder);
            $('body').on('change', '.qty-product', limitQty);

            /**
            * Action before submit form
            */
            $('#purchase_order_create').on('submit', function (e) {
                // form is valid
                let is_form_valid     = $('#purchase_order_create').valid();
                let select2Validation = $('select.select2').next('span');

                // move select2 validation below select2
                if(select2Validation.hasClass('help-block')){
                    $.each(select2Validation, function( index, value ) {
                      $(value).appendTo($(value).next());
                    });
                }

                if(is_form_valid == true){
                    $('button[name="simpan"]').attr('disabled', 'disabled');
                    $('#execute-loading').css({'visibility': 'visible'});
                }
            });

            function limitQty(){
                let qty = parseInt($(this).val());
                if (qty < 1){
                    swal("Error!", "Minimum quantity is 1", "error");
                    $(this).val('');
                }
            }

            function makeReadOnly(){
                $(this).addClass('readonly');
            }

            function deleteOrder(){

            }

            function repeatOrder(){
                var countOrder = $('.for-count').length;
                var products   = {!! $productJs !!};
                var prodLength = Object.keys(products).length;
                var lastForm   = $('.add-repeater').parent().parent(); 
                var content = '<div class="form-group m-form__group row">'
                    content+= '<label class="col-form-label col-lg-2 col-sm-12"></label>'
                    content+= '<div class="col-lg-3 col-sm-12 for-count">'
                    content+= '<select class="form-control select2" name="product['+countOrder+']">'
                    content+= '<option value=""></option>'
                    for (var j = 0; j < prodLength; j++) {
                        content+= '<option value='+products[j].id+'>'+products[j].name+'</option>'
                    }

                    content+= '</select></div>'
                    content+= '<div class="col-lg-2 col-sm-12">'
                    content+= '<input class="form-control" placeholder="Product Quantity" name="qty[]" type="number">'
                    content+= '</div></div>';
                $(content).insertBefore($(lastForm));
                $("select[name='product["+countOrder+"]']").select2({ placeholder: "{{ \Lang::get('select2.select_product') }}" });
                // // var content = '<div class="form-group m-form__group row">';
                //     content+= '<label class="col-form-label col-lg-2 col-sm-12"></label>';
                //     content+= '<div class="col-lg-3 col-sm-12">';
                //     content+= '<select class="form-control select2" name="product">';<option value="" selected="selected"></option><option value="8">Fiesta Chicken Nugget 250gr</option><option value="6">Green Tea 350 ml</option><option value="2">KACANG ALMOND 1kg USA-CALIFORNIA</option><option value="1">Ladang Lima Blackmond Cookies</option><option value="3">Milk Pie</option></select>
                                            
                //                     </div>
                //                     <div class="col-lg-2 col-sm-12">
                //                         <input class="form-control" placeholder="Product Quantity" name="qty" type="number" value="">
                                        
                //                     </div>
                //             </div>

            }
        });
    </script>
@endsection