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
                                <h3 class="m-portlet__head-text">
                                    Detail Cashier Transaction
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <div class="col-lg-6">
                                    <label>Employee</label>
                                    <input type="text" class="form-control m-input" value="{{ $cashier->employee->fullname }} "disabled>
                                    <br />
                                    <label>Open Cashier</label>
                                    <input type="text" class="form-control m-input" value="{{ Helper::tglIndo($cashier->created_at) }} "disabled>
                                    <br />
                                    <label>Cash open cashier</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input type="text" class="form-control m-input" value="{{ Helper::number_formats($cashier->total, 'view', 0) }} "disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Shift</label>
                                    <input type="text" class="form-control m-input" value="{{ $cashier->shift->name }} "disabled>
                                    <br />
                                    <label>Close Cashier</label>
                                    <input type="text" class="form-control m-input" value="{{ Helper::tglIndo($cashier->updated_at) }} "disabled>
                                    <br />
                                    <label>Cash end cashier</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <input type="text" class="form-control m-input" value="{{ Helper::number_formats($cashier->end_total, 'view', 0) }} "disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-lg-6">
                                    <h5>Paper Money</h5>
                                    @foreach(json_decode($cashier->papers_qty) as $paper)
                                        <br />
                                        <label>{{ $paper->name }}</label>
                                        <input type="text" class="form-control m-input" value="{{ $paper->value }} "disabled>
                                    @endforeach
                                </div>
                                <div class="col-lg-6">
                                    <h5>Coin Money</h5>
                                    @foreach(json_decode($cashier->coins_qty) as $coin)
                                        <br />
                                        <label>{{ $coin->name }}</label>
                                        <input type="text" class="form-control m-input" value="{{ $coin->value }} "disabled>
                                    @endforeach
                                </div>
                            </div>
                            <div class="container">
                                <br />
                                <h5>Detail Transaction</h5>
                                <br />
                                <div class="table-responsive">
                                    <table class="table m-table table-striped table-hover m-table--head-bg-success">
                                        <thead>
                                          <tr>
                                            <th>#</th>
                                            <th>Invoice</th>
                                            <th>Customer</th>
                                            <th>Bill Amount</th>
                                            <th>Pay Amount</th>
                                            <th>Change</th>
                                            <th>Discount</th>
                                            <th>Email Receipt</th>
                                            <th>Date</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cashier->cashier_transaction as $trans)
                                              <tr>
                                                <th class="row-detail" scope="row" style="cursor:pointer">
                                                    <span class="fa fa-plus-circle"></span></th>
                                                <td>{{ $trans->invoice }}</td>
                                                <td>{{ optional($trans->customer)->name }}</td>
                                                <td>{{ \Helper::number_formats($trans->bill_amount, 'view', 0) }}</td>
                                                <td>{{ \Helper::number_formats($trans->pay_amount, 'view', 0) }}</td>
                                                <td>{{ \Helper::number_formats($trans->change, 'view', 0) }}</td>
                                                <td>{{ \Helper::number_formats($trans->discount, 'view', 0) }}</td>
                                                <td>{{ $trans->email_receipt }}</td>
                                                <td>{{ \Helper::tglIndo($trans->created_at) }}</td>
                                              </tr>
                                              <tr class="d-none">
                                                <td colspan="9">
                                                    <table class="table m-table table-striped table-hover m-table--head-bg-success">
                                                        <tbody>
                                                            <tr style="background-color: #b4b5b4;">
                                                                <th>#</th>
                                                                <th>Product</th>
                                                                <th>Qty</th>
                                                                <th>Discount</th>
                                                                <th>Total</th>
                                                            </tr>
                                                            @foreach($trans->cashier_transaction_detail as $trans_detail)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $trans_detail->product->name }}</td>
                                                                <td>{{ $trans_detail->qty }}</td>
                                                                <td>{{ \Helper::number_formats($trans_detail->discount, 'view', 0) }}</td>
                                                                <td>{{  \Helper::number_formats($trans_detail->total, 'view', 0) }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                              </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-10 ml-lg-auto">
                                        <a href="{{ route($route_index) }}" class="btn btn-metal">Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
               </div>  
                <!--end::Portlet-->    
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.row-detail').on('click', function(){
            let plus  = $(this).find('.fa-plus-circle');
            let minus = $(this).find('.fa-minus-circle');

            if(plus.length > 0){
                $(plus).removeClass('fa fa-plus-circle');
                $(plus).addClass('fa fa-minus-circle');
                $(this).parent().next().removeClass('d-none');
            } if(minus.length > 0){
                $(minus).removeClass('fa fa-minus-circle');
                $(minus).addClass('fa fa-plus-circle');
                $(this).parent().next().addClass('d-none');   
            }
        })

        // $('body').on('click', '.fa-minus-circle', function(){
        //     $(this).removeClass('fa fa-minus-circle');
        //     $(this).addClass('fa fa-plus-circle');
        //     $(this).parent().parent().next().addClass('d-none');
        // })
    });
</script>
@endsection