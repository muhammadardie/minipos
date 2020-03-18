<div class="m-portlet m-portlet--success m-portlet--head-solid-bg m-portlet--bordered hidden" id="report_result">
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
        <div class="m-portlet__head-tools">
            <div class="m-btn-group m-btn-group--pill btn-group mr-2" role="group" aria-label="..." style="color:white">
                <a class="m-btn btn btn-outline-light generate-pdf" href="{{ route('report.purchase_report.ajax_generate_purchase_report', ['type' => 'purchase', 'file' => 'pdf', 'startDate' => $startDate, 'endDate' => $endDate]) }}" target="_blank"><i class="fa fa-file-pdf"></i> PDF</a>
                <a class="m-btn btn btn-outline-light generate-excel" href="{{ route('report.purchase_report.ajax_generate_purchase_report', ['type' => 'purchase', 'file' => 'xls', 'startDate' => $startDate, 'endDate' => $endDate]) }}"  target="_blank"><i class="fa fa-file-excel"></i> XLS</a>
            </div>
        </div>
    </div>
    
    <div class="m-portlet__body">
        <ul class="nav nav-tabs nav-fill m-tabs-line m-tabs-line--success" role="tablist">
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#tab_purchase" role="tab"><i class="fa fa-hand-holding-usd"></i> Purchase Order</a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab_product" role="tab"><i class="fa fa-cube"></i> Received Product</a>
            </li>
        </ul>                        


        <div class="tab-content">
            <div class="tab-pane active" id="tab_purchase" role="tabpanel">
                <table class="table m-table m-table--head-bg-success">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date Created</th>
                            <th>PO Number</th>
                            <th>Employee</th>
                            <th>Supplier</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchases as $purchase)
                            @php
                                $total += $purchase->total;
                            @endphp
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ \Helper::tglIndo($purchase->created_at, false) }}</td>
                                <td>{{ $purchase->po_number }}</td>
                                <td>{{ $purchase->first_name.' '.$purchase->last_name }}</td>
                                <td>{{ $purchase->supplier_name }}</td>
                                <td>Rp {{ \Helper::number_formats($purchase->total, 'view', 0) }}</td>
                                @if($purchase->approved === TRUE)
                                    <td><span class="m-badge m-badge--success m-badge--wide">Received</span></td>
                                @else
                                    <td><span class="m-badge m-badge--danger m-badge--wide">Returned</span></td>
                                @endif
                            </tr>
                        @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>Total<br /> </strong> Rp {{ \Helper::number_formats($total, 'view', 0) }}</td>
                            </tr>
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
                            <th>Purchased</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            @php
                                $grand_total += ($product->count * $product->price);
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
                                <td></td>
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