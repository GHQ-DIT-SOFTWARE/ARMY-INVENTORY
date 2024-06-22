<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .address {
            text-align: left;
            width: 50%;
        }

        .issued-info {
            text-align: right;
            width: 50%;
        }

        .signature {
            margin-top: 30px;
            text-align: left;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin-top: 30px;
        }

        .footer {
            margin-top: 30px;
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .small-text {
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="address">
            <strong>Address:</strong><br>
            {{ $address }}
        </div>
        <div class="issued-info" style="float: right;">
            <strong>Authorized Date:</strong> {{ $date_issued }}<br>
            <strong>Confirmed Authorized:</strong> {{ $items->first()['confirmed_issued'] }}<br>
            <strong>Status:</strong> {{ $items->first()['STATUS'] }}
        </div>
    </div>
    <h2 class="small-text">Invoice No: {{ $invoice_no }}</h2>
    <br><br>
    <hr>
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
<br>
    <strong>Description: {{ $items->first()['Description'] }}<br></strong>

    <div class="signature">
        <div class="signature-line"></div>
        <strong>ISSUED BY:</strong> {{ $signature }}
    </div>


</body>

</html>
