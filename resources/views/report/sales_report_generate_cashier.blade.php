<html>
<title>Sales Cashier Report</title>
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
                <td>{{ \Helper::number_formats($cashier->total, 'view', 0, ',') }}</td>
                <td>{{ \Helper::number_formats($cashier->end_total, 'view', 0, ',') }}</td>
            </tr>
        @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ \Helper::number_formats($start_total, 'view', 0, ',') }}</td>
                <td>{{ \Helper::number_formats($end_total, 'view', 0, ',') }}</td>
            </tr>
    </tbody>
</table>
</html>