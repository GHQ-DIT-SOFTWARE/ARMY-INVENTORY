<!DOCTYPE html>
<html>

<head>
    <title>Item Issued-pdf</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            /* Reduce padding for compact table */
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2,
        h3 {
            margin-top: 0;
        }

        .address {
            margin-bottom: 20px;
        }

        .issued-info {
            margin-top: 40px;
        }

        .signature {
            margin-top: 60px;
        }

        @page {
            margin: 20mm;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div class="address">
        <h3>GHANA ARMED FORCES</h3>
        <p>
            1234 Street Name<br>
            City, State, ZIP Code<br>
            Country<br>
            Phone: (123) 456-7890<br>
            Email: info@company.com
        </p>
    </div>

    <h2>Item Issued - {{ $invoice_no }}</h2>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Sub Category</th>
                <th>Item Name</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Description</th>
                <th>Status</th>
                <th>Invoice No</th>
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
                    <td>{{ $item['Description'] }}</td>
                    <td>{{ $item['Status'] }}</td>
                    <td>{{ $item['Invoice No'] }}</td>
                    <td>{{ $item['Confirm Qty'] }}</td>
                    <td>{{ $item['Remarks'] }}</td>
                </tr>
                @if ($loop->iteration % 20 == 0)
        </tbody>
    </table>
    <div class="page-break"></div>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Sub Category</th>
                <th>Item Name</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Description</th>
                <th>Status</th>
                <th>Invoice No</th>
                <th>Confirm Qty</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @endif
            @endforeach
        </tbody>
    </table>

    <div class="issued-info">
        <p><strong>Issued by:</strong> {{ $issued_by }}</p>
        <p><strong>Date Issued:</strong> {{ $date_issued }}</p>
    </div>

    <div class="signature">
        <p>__________________________</p>
        <p>Signature</p>
    </div>
</body>

</html>
