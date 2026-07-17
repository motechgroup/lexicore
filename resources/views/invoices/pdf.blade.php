<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333333;
            font-size: 13px;
            line-height: 1.5;
            padding: 0;
            margin: 0;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        .header {
            width: 100%;
            margin-bottom: 30px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-logo-cell {
            width: 50%;
            vertical-align: top;
        }
        .header-info-cell {
            width: 50%;
            text-align: right;
            vertical-align: top;
        }
        .firm-title {
            font-size: 26px;
            font-family: Georgia, serif;
            font-weight: bold;
            color: #031635;
            margin: 0 0 5px 0;
        }
        .firm-subtitle {
            font-size: 11px;
            color: #775a19;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }
        .invoice-title {
            font-size: 22px;
            font-weight: bold;
            color: #031635;
            margin: 0 0 5px 0;
        }
        .meta-text {
            font-size: 11px;
            color: #666666;
            margin: 2px 0;
        }
        .billing-details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .billing-cell {
            width: 50%;
            vertical-align: top;
        }
        .section-title {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999999;
            font-weight: bold;
            margin: 0 0 8px 0;
        }
        .client-name {
            font-size: 14px;
            font-weight: bold;
            color: #333333;
            margin: 0 0 4px 0;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            color: #031635;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px;
            text-align: left;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }
        .text-right {
            text-align: right !important;
        }
        .summary-table {
            width: 250px;
            float: right;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .summary-table td {
            padding: 6px 10px;
            font-size: 12px;
        }
        .summary-label {
            color: #666666;
        }
        .summary-value {
            font-weight: bold;
            text-align: right;
            color: #333333;
        }
        .total-row td {
            border-top: 2px solid #031635;
            font-size: 14px;
            padding-top: 10px;
        }
        .total-value {
            font-size: 16px;
            color: #031635;
        }
        .footer {
            clear: both;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <!-- Logo and Invoice Meta -->
        <div class="header">
            <table class="header-table">
                <tr>
                    <td class="header-logo-cell">
                        <h1 class="firm-title">{{ config('system.firm_name', 'LexCore') }}</h1>
                        <p class="firm-subtitle">Legal Practice & Advocacy</p>
                    </td>
                    <td class="header-info-cell">
                        <h2 class="invoice-title">INVOICE</h2>
                        <p class="meta-text"><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</p>
                        <p class="meta-text"><strong>Date:</strong> {{ $invoice->created_at->format('M d, Y') }}</p>
                        <p class="meta-text"><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Billing details -->
        <table class="billing-details-table">
            <tr>
                <td class="billing-cell">
                    <h3 class="section-title">Billed To</h3>
                    <p class="client-name">{{ $invoice->client->name }}</p>
                    <p class="meta-text">{{ $invoice->client->email }}</p>
                </td>
                <td class="billing-cell" style="text-align: right;">
                    <h3 class="section-title">Case File Reference</h3>
                    <p class="client-name" style="font-size:12px;">{{ $invoice->matter->title ?? 'General Legal Counsel' }}</p>
                    @if($invoice->matter)
                        <p class="meta-text"><strong>Case Code:</strong> #{{ $invoice->matter->case_number }}</p>
                    @endif
                </td>
            </tr>
        </table>

        <!-- Invoice Line Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 55%;">Description</th>
                    <th style="width: 15%; text-align: right;">Rate</th>
                    <th style="width: 15%; text-align: right;">Hours / Qty</th>
                    <th style="width: 15%; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td class="text-right">${{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">{{ number_format($item->qty, 1) }}</td>
                        <td class="text-right">${{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals summary box -->
        <table class="summary-table">
            <tr>
                <td class="summary-label">Subtotal</td>
                <td class="summary-value">${{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
            @if($invoice->tax_amount > 0)
                <tr>
                    <td class="summary-label">Tax ({{ $invoice->tax_rate }}%)</td>
                    <td class="summary-value">${{ number_format($invoice->tax_amount, 2) }}</td>
                </tr>
            @endif
            @if($invoice->discount > 0)
                <tr>
                    <td class="summary-label">Discount</td>
                    <td class="summary-value">-${{ number_format($invoice->discount, 2) }}</td>
                </tr>
            @endif
            <tr class="total-row">
                <td class="summary-label"><strong>Total Balance</strong></td>
                <td class="summary-value total-value"><strong>${{ number_format($invoice->total, 2) }}</strong></td>
            </tr>
        </table>

        <div style="clear:both;"></div>

        <!-- Payment Note / Instructions -->
        @if($invoice->notes)
            <div style="margin-top: 30px; background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 8px;">
                <h4 style="margin: 0 0 5px 0; color: #031635; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Terms & Payment Instructions</h4>
                <p style="margin: 0; font-size: 11px; color: #666666; line-height: 1.4;">{{ $invoice->notes }}</p>
            </div>
        @endif

        <div class="footer">
            <p>LexCore Legal Practice Management System - Confidential Billing Document</p>
            <p>&copy; {{ date('Y') }} {{ config('system.firm_name', 'LexCore') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
