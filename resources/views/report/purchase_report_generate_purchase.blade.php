<html>
<title>Purchase Report</title>
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
                <td>{{ \Helper::number_formats($purchase->total, 'view', 0, ',') }}</td>
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
                <td><strong>Total<br /> </strong> Rp {{ \Helper::number_formats($total, 'view', 0, ',') }}</td>
                <td></td>
            </tr>
    </tbody>
</table>
</html>