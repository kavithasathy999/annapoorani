<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .wrap {
            max-width: 650px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: #111111;
            padding: 40px 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            color: #ffffff;
            font-size: 28px;
            font-weight: 900;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .header p {
            margin: 10px 0 0;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
        }

        .body {
            padding: 35px 30px;
            background: #ffffff;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .info-col {
            flex: 1;
        }

        .info-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #999;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .info-value {
            font-size: 15px;
            color: #111;
            font-weight: 700;
        }

        .section-title {
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #111;
            margin-bottom: 15px;
            background: #f8f8f8;
            padding: 8px 12px;
            border-left: 4px solid #111;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table.items th {
            padding: 12px;
            background: #fdfdfd;
            color: #666;
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-align: left;
            border-bottom: 2px solid #eeeeee;
        }

        table.items td {
            padding: 15px 12px;
            color: #444;
            font-size: 14px;
            border-bottom: 1px solid #f5f5f5;
        }

        table.items .text-right {
            text-align: right;
        }

        table.items .font-bold {
            font-weight: 700;
            color: #111;
        }

        .summary-grid {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }

        .summary-box {
            width: 100%;
            max-width: 250px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #666;
        }

        .summary-row.savings {
            color: #28a745;
            font-weight: 600;
        }

        .summary-row.grand {
            border-bottom: none;
            padding-top: 15px;
            color: #111;
        }

        .summary-row.grand span {
            font-size: 16px;
            font-weight: 800;
        }

        .summary-row.grand .val {
            font-size: 24px;
            font-weight: 900;
            color: #000;
        }

        .payment-section {
            background: #fffcf5;
            border: 1px solid #f3e6c5;
            border-radius: 12px;
            padding: 25px;
            margin-top: 20px;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 15px;
        }

        .payment-method {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .pm-title {
            font-size: 13px;
            font-weight: 800;
            color: #111;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pm-detail {
            font-size: 13px;
            color: #555;
            line-height: 1.6;
        }

        .qr-img {
            width: 100px;
            height: 100px;
            margin-top: 10px;
            border: 1px solid #eee;
            padding: 5px;
            border-radius: 4px;
        }

        .footer {
            padding: 30px;
            text-align: center;
            color: #999;
            font-size: 12px;
            background: #fdfdfd;
            border-top: 1px solid #eee;
        }

        .footer strong {
            color: #333;
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div style="background:#f4f4f4; padding:20px 10px;">
        <div class="wrap">

            <div class="header">
                <h1>Order Invoice</h1>
                <p>Confirmation of your order with <strong>Bluvel Crackers</strong></p>
            </div>

            <div class="body">

                <table style="width: 100%; margin-bottom: 30px;">
                    <tr>
                        <td style="width: 50%; vertical-align: top;">
                            <div class="info-label">Order Number</div>
                            <div class="info-value">#{{ $orderId }}</div>
                        </td>
                        <td style="width: 50%; vertical-align: top; text-align: right;">
                            <div class="info-label">Customer Name</div>
                            <div class="info-value">{{ $customerName }}</div>
                        </td>
                    </tr>
                </table>

                <div class="section-title">Order Breakdown</div>
                <table class="items">
                    <thead>
                        <tr>
                            <th>Product Details</th>
                            <th class="text-right">Price</th>
                            <th class="text-right">Qty</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>
                                    <div style="font-weight: 700; color:#111;">{{ $item['product_name'] }}</div>
                                    <div style="font-size: 11px; color:#999;">Fireworks Category</div>
                                </td>
                                <td class="text-right">₹{{ number_format($item['price'], 2) }}</td>
                                <td class="text-right">× {{ $item['qty'] }}</td>
                                <td class="text-right font-bold">₹{{ number_format($item['total'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="summary-grid">
                    <div class="summary-box">
                        <div class="summary-row">
                            <span>Subtotal (MRP)</span>
                            <span>₹{{ number_format($actualTotal, 2) }}</span>
                        </div>
                        @if(($actualTotal - $netTotal) > 0)
                            <div class="summary-row savings">
                                <span>Savings</span>
                                <span>- ₹{{ number_format($actualTotal - $netTotal, 2) }}</span>
                            </div>
                        @endif
                        <div class="summary-row grand">
                            <span>Net Total</span>
                            <span class="val">₹{{ number_format($netTotal, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="payment-section">
                    <div class="section-title"
                        style="background:transparent; padding:0; border:none; margin-bottom:10px;">Payment Instructions
                    </div>
                    <p style="font-size: 13px; color:#666; margin-bottom: 15px;">Please complete your payment using any
                        of the methods below and share the screenshot with us.</p>

                    <table style="width: 100%;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width: 50%; vertical-align: top; padding-right: 10px;">
                                <div class="payment-method">
                                    <div class="pm-title">🏦 Bank Transfer</div>
                                    <div class="pm-detail">
                                        <strong>Bank:</strong> {{ $payment->bank_name ?? 'N/A' }}<br>
                                        <strong>A/C:</strong> {{ $payment->account_number ?? 'N/A' }}<br>
                                        <strong>IFSC:</strong> {{ $payment->ifsc_code ?? 'N/A' }}<br>
                                        <strong>Name:</strong> {{ $payment->account_name ?? 'N/A' }}
                                    </div>
                                </div>
                            </td>
                            <td style="width: 50%; vertical-align: top; padding-left: 10px;">
                                <div class="payment-method">
                                    <div class="pm-title">📱 Mobile / UPI</div>
                                    <div class="pm-detail">
                                        <strong>{{ $payment->gpay_label ?? 'Google Pay' }}:</strong><br>{{ $payment->gpay_number ?? 'N/A' }}<br>
                                        @if(!empty($payment->gpay_qr_code))
                                            <img src="{{ env('MAIN_URL') . $payment->gpay_qr_code }}" class="qr-img"
                                                alt="GPay QR">
                                        @endif
                                        <br><br>
                                        <strong>{{ $payment->phonepe_label ?? 'PhonePe' }}:</strong><br>{{ $payment->phonepe_number ?? 'N/A' }}<br>
                                        @if(!empty($payment->phonepe_qr_code))
                                            <img src="{{ env('MAIN_URL') . $payment->phonepe_qr_code }}" class="qr-img"
                                                alt="PhonePe QR">
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    @if(!empty($payment->additional_notes))
                        <div
                            style="margin-top:20px; padding:15px; border-top:1px dashed #ddd; font-size:12px; font-style:italic; color:#777;">
                            <strong>Notes:</strong> {{ strip_tags($payment->additional_notes) }}
                        </div>
                    @endif
                </div>

            </div>

            <div class="footer">
                <strong>Bluvel Crackers</strong>
                Sivakasi, Tamil Nadu<br>
                Quality Fireworks at Best Prices
            </div>

        </div>
    </div>
</body>

</html>