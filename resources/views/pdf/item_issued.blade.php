<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            display: flex;
            justify-content: space-between;
        }

        .address {
            text-align: left;
        }

        .issued-info {
            text-align: right;
        }

        .signature {
            margin-top: 50px;
            text-align: left;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin-top: 50px;
        }

        .footer {
            position: fixed;
            bottom: 50px;
            left: 0;
            right: 0;
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="address">
            <strong>Address:</strong><br>
            {{ $address }}
        </div>
        <div class="issued-info">
            <strong>Authorized Date:</strong> {{ \Carbon\Carbon::parse($date_issued)->format('d F Y') }}<br>
            <strong>Confirmed Authorized:</strong>
            {{ \Carbon\Carbon::parse($items->first()['confirmed_issued'])->format('d F Y') }} <br>
            {{-- <strong>Status:</strong> {{ $item['STATUS'] == 'Issuance Issued' ? 'Issuance Issued' : 'Pending' }} --}}

        </div>
    </div>
    <h2>Invoice No: {{ $invoice_no }}</h2>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Sub Category</th>
                <th>Item Name</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Unit ID</th>
                <th>Confirm Qty</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item['Category'] }}</td>
                    <td>{{ $item['Sub Category'] }}</td>
                    <td>{{ $item['Item Name'] }}</td>
                    <td>{{ $item['Size'] }}</td>
                    <td>{{ $item['Quantity'] }}</td>
                    <td>{{ $item['Unit ID'] }}</td>
                    <td>{{ $item['Confirm Qty'] }}</td>
                    <td>{{ $item['Remarks'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <strong>Description:</strong><br>
        @foreach ($items as $item)
            {{ $item['Description'] }}<br>
        @endforeach
    </div>

    <div class="signature">
        <div class="signature-line"></div>
        <strong>Authorized By:</strong> {{ $signature }}
    </div>


</body>

</html>
