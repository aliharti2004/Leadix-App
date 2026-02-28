<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            padding: 40px;
        }

        .header {
            margin-bottom: 40px;
            border-bottom: 3px solid #ff7300;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #1a1a1a;
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .header .brand {
            color: #ff7300;
        }

        .header p {
            color: #666;
            font-size: 12px;
        }

        .invoice-details {
            display: table;
            width: 100%;
            margin-bottom: 40px;
        }

        .invoice-details .left,
        .invoice-details .right {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }

        .invoice-details h2 {
            font-size: 18px;
            color: #1a1a1a;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .invoice-details p {
            margin-bottom: 5px;
            color: #555;
        }

        .invoice-details strong {
            color: #1a1a1a;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 10px;
        }

        .status-paid {
            background-color: #10b981;
            color: white;
        }

        .status-pending {
            background-color: #f59e0b;
            color: white;
        }

        .status-overdue {
            background-color: #ef4444;
            color: white;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table thead {
            background-color: #f8f9fa;
        }

        .items-table th {
            padding: 12px;
            text-align: left;
            font-weight: 700;
            color: #1a1a1a;
            border-bottom: 2px solid #dee2e6;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
            color: #555;
        }

        .items-table .text-right {
            text-align: right;
        }

        .totals {
            float: right;
            width: 300px;
            margin-top: 20px;
        }

        .totals table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals td {
            padding: 8px 12px;
            font-size: 14px;
        }

        .totals .label {
            text-align: left;
            color: #666;
            font-weight: 600;
        }

        .totals .amount {
            text-align: right;
            color: #1a1a1a;
            font-weight: 600;
        }

        .totals .total-row {
            border-top: 2px solid #ff7300;
            margin-top: 8px;
            padding-top: 8px;
        }

        .totals .total-row .label {
            font-size: 16px;
            font-weight: 800;
            color: #1a1a1a;
        }

        .totals .total-row .amount {
            font-size: 18px;
            font-weight: 800;
            color: #ff7300;
        }

        .footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #999;
            font-size: 11px;
            clear: both;
        }

        .footer p {
            margin-bottom: 4px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <h1>Leadi<span class="brand">X</span></h1>
        <p>Revenue Operations Platform</p>
    </div>

    <!-- Invoice Details -->
    <div class="invoice-details">
        <div class="left">
            <h2>Bill To</h2>
            <p><strong>{{ $invoice->deal->lead->title ?? 'N/A' }}</strong></p>
            <p>{{ $invoice->deal->lead->contact_name ?? 'N/A'}}</p>
            <p>{{ $invoice->deal->lead->email ?? '' }}</p>
            <p>{{ $invoice->deal->lead->phone ?? '' }}</p>
        </div>

        <div class="right">
            <h2>Invoice Details</h2>
            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Issue Date:</strong> {{ $invoice->issue_date->format('M d, Y') }}</p>
            <p><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</p>

            <span class="status-badge status-{{ $invoice->status }}">
                {{ ucfirst($invoice->status) }}
            </span>
        </div>
    </div>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-right">Quantity</th>
                <th class="text-right">Rate</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @if($invoice->items && $invoice->items->count() > 0)
                @foreach($invoice->items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">${{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">${{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>{{ $invoice->deal->title ?? 'Service' }}</td>
                    <td class="text-right">1</td>
                    <td class="text-right">${{ number_format($invoice->total, 2) }}</td>
                    <td class="text-right">${{ number_format($invoice->total, 2) }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals">
        <table>
            <tr>
                <td class="label">Subtotal</td>
                <td class="amount">${{ number_format($invoice->total, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td class="label">Total</td>
                <td class="amount">${{ number_format($invoice->total, 2) }}</td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Thank you for your business!</strong></p>
        <p>Generated on {{ now()->format('M d, Y \a\t h:i A') }}</p>
        <p>© {{ now()->year }} LeadiX - Revenue Operations Platform</p>
    </div>

</body>

</html>