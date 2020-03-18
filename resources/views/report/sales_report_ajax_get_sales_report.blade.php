<div class="m-portlet m-portlet--success m-portlet--head-solid-bg m-portlet--bordered hidden" id="report_result">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="fa fa-file-signature"></i>
                </span>
                <h3 class="m-portlet__head-text">
                    Sales Report
                </h3>
            </div>          
        </div>
        <div class="m-portlet__head-tools">
            <div class="m-btn-group m-btn-group--pill btn-group mr-2" role="group" aria-label="..." style="color:white">
                <a class="m-btn btn btn-outline-light generate-pdf" href="{{ route('report.sales_report.ajax_generate_sales_report', ['type' => 'cashier', 'file' => 'pdf', 'startDate' => $startDate, 'endDate' => $endDate]) }}" target="_blank"><i class="fa fa-file-pdf"></i> PDF</a>
                <a class="m-btn btn btn-outline-light generate-excel" href="{{ route('report.sales_report.ajax_generate_sales_report', ['type' => 'cashier', 'file' => 'xls', 'startDate' => $startDate, 'endDate' => $endDate]) }}"  target="_blank"><i class="fa fa-file-excel"></i> XLS</a>
            </div>
        </div>
    </div>
    
    <div class="m-portlet__body">
        <ul class="nav nav-tabs nav-fill m-tabs-line m-tabs-line--success" role="tablist">
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#tab_cashier" role="tab"><i class="fa fa-calculator"></i> Cashier</a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_transaction" role="tab"><i class="fa fa-hand-holding-usd"></i> Transaction</a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_product" role="tab"><i class="fa fa-cube"></i> Product</a>
            </li>
        </ul>                        


        <div class="tab-content">
            <div class="tab-pane active" id="tab_cashier" role="tabpanel">
                <table class="table m-table m-table--head-bg-success">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Open Cashier</th>
                            <th>Close Cashier</th>
                            <th>Employee</th>
                            <th>Shift</th>
                            <th>Start Total</th>
                            <th>End Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cashiers as $cashier)
                            @php
                                $start_total += $cashier->total;
                                $end_total   += $cashier->end_total;
                            @endphp
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ \Helper::tglIndo($cashier->created_at) }}</td>
                                <td>{{ \Helper::tglIndo($cashier->updated_at) }}</td>
                                <td>{{ $cashier->first_name.' '.$cashier->last_name }}</td>
                                <td>{{ $cashier->shift_name }}</td>
                                <td>Rp {{ \Helper::number_formats($cashier->total, 'view', 0) }}</td>
                                <td>Rp {{ \Helper::number_formats($cashier->end_total, 'view', 0) }}</td>
                            </tr>
                        @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>Start Total<br /> </strong> Rp {{ \Helper::number_formats($start_total, 'view', 0) }}</td>
                                <td><strong>End Total<br /> </strong> Rp {{ \Helper::number_formats($end_total, 'view', 0) }}</td>
                            </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="tab_transaction" role="tabpanel">
                <table class="table m-table m-table--head-bg-success">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Cashier</th>
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
                        @foreach($cashiers as $cashier)
                            @foreach($cashier->cashier_transaction as $trans)
                              <tr>
                                <th class="row-detail" scope="row" style="cursor:pointer">
                                    <span class="fa fa-plus-circle"></span>
                                </th>
                                <td>{{ $trans->invoice }}</td>
                                <td>{{ $trans->cashier->employee->first_name }}</td>
                                <td>{{ optional($trans->customer)->name }}</td>
                                <td>{{ \Helper::number_formats($trans->bill_amount, 'view', 0) }}</td>
                                <td>{{ \Helper::number_formats($trans->pay_amount, 'view', 0) }}</td>
                                <td>{{ \Helper::number_formats($trans->change, 'view', 0) }}</td>
                                <td>{{ \Helper::number_formats($trans->discount, 'view', 0) }}</td>
                                <td>{{ $trans->email_receipt }}</td>
                                <td>{{ \Helper::tglIndo($trans->created_at) }}</td>
                              </tr>
                              <tr class="d-none">
                                <td colspan="10">
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
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane" id="tab_product" role="tabpanel">
                <table class="table m-table m-table--head-bg-success">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Cost</th>
                            <th>Price</th>
                            <th>Sales</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            @php
                                $discount    += $product->discount;
                                $grand_total += ($product->count * $product->price) - $product->discount;
                            @endphp 
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $product->name }}</td>
                                <td>Rp {{ \Helper::number_formats($product->cost, 'view', 0) }}</td>
                                <td>Rp {{ \Helper::number_formats($product->price, 'view', 0) }}</td>
                                <td>{{ $product->count }}</td>
                                <td>Rp {{ \Helper::number_formats($product->count * $product->price, 'view', 0) }}</td>
                            </tr>
                        @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>Discount<br /> </strong> Rp {{ \Helper::number_formats($discount, 'view', 0) }}</td>
                                <td><strong>Grand Total<br /> </strong> Rp {{ \Helper::number_formats($grand_total, 'view', 0) }}</td>
                            </tr>
                    </tbody>
                </table>
            </div>

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