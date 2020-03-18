<html>
<title>Sales Transaction Report</title>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

</style>
<table class="table m-table m-table--head-bg-success">
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice</th>
            <th>Cashier</th>
            <th>Customer</th>
            <th>Bill Amount</th>
            <th>Pay Amount</th>
            <th>Change</th>
            <th>Discount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cashiers as $cashier)
            @foreach($cashier->cashier_transaction as $trans)
              <tr>
                <th>
                    {{ $loop->iteration }}
                </th>
                <td>{{ $trans->invoice }}</td>
                <td>{{ $trans->cashier->employee->first_name }}</td>
                <td>{{ optional($trans->customer)->name }}</td>
                <td>{{ \Helper::number_formats($trans->bill_amount, 'view', 0, ',') }}</td>
                <td>{{ \Helper::number_formats($trans->pay_amount, 'view', 0, ',') }}</td>
                <td>{{ \Helper::number_formats($trans->change, 'view', 0, ',') }}</td>
                <td>{{ \Helper::number_formats($trans->discount, 'view', 0, ',') }}</td>
                <td>{{ \Helper::tglIndo($trans->created_at, false) }}</td>
              </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
</html>