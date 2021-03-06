<title>#{{ $invoice}}</title>
<link href="{{ asset('assets/vendors/custom/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<!------ Include the above in your HEAD tag ---------->
<style>
.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-title">
                <p>Thanks for providing us the opportunity  to do business with you you will find the Invoice for the recent services or products provided by us, attached with this email.</p>
                <p>Please feel free to contact us if you have any questions or concerns about this invoice.</p>

                <p>Regards,</p>
                <p>Minipos</p>
            </div>
            <hr>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-title">
                <h2>Invoice</h2><h3 class="pull-right">#{{ $invoice }}</h3>
            </div>
            <hr>
        </div>
    </div>
    <br />
    <br />
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Order Summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed" style="width:700px;">
                            <thead>
                                <tr>
                                    <td style="width:300px;"><strong>Product</strong></td>
                                    <td class="text-center" style="width:100px;"><strong>Price</strong></td>
                                    <td class="text-center" style="width:100px;"><strong>Quantity</strong></td>
                                    <td class="text-right" style="width:200px;"><strong>Totals</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                @foreach($cashTrans as $trans)
                                    @foreach($trans->cashier_transaction_detail as $order)
                                        <tr>
                                            <td>{{ $order->product->name }}</td>
                                            <td class="text-center">{{ \Helper::number_formats($order->product->price, 'view', 0)}}</td>
                                            <td class="text-center">{{ $order->qty }}</td>
                                            <td class="text-right">{{ \Helper::number_formats($order->total, 'view', 0)}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                        <td class="thick-line text-right">{{ \Helper::number_formats($trans->pay_amount, 'view', 0)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center"><strong>Discount</strong></td>
                                        <td class="no-line text-right">{{ $trans->discount != null ? \Helper::number_formats($trans->discount, 'view', 0) : 0}}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center"><strong>Total</strong></td>
                                        <td class="no-line text-right">{{ \Helper::number_formats($trans->bill_amount, 'view', 0)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>