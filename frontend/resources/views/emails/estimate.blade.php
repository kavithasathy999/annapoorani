<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Estimate Terminal | Crakers</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f9f7f2; font-family: 'Outfit', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <div style="width: 100%; table-layout: fixed; background-color: #f9f7f2; padding: 40px 0;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0"
            style="max-width: 700px; margin: 0 auto; background-color: #ffffff; border-radius: 30px; overflow: hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.08); border: 1px solid #e5e0d5;">

            <!-- Cinematic Header -->
            <tr>
                <td style="background-color: #101010; padding: 50px 40px; text-align: center;">
                    <div
                        style="letter-spacing: 3px; color: #B8860B; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 12px;">
                        Order Confirmation</div>
                    <h1
                        style="margin: 0; color: #ffffff; font-size: 32px; font-weight: 400; font-family: 'Cormorant Garamond', Georgia, serif; letter-spacing: 1px;">
                        Price <span style="color: #B8860B;">Estimate</span></h1>
                    <div
                        style="margin-top: 15px; height: 1px; width: 60px; background-color: #B8860B; margin-left: auto; margin-right: auto;">
                    </div>
                </td>
            </tr>

            <!-- Client & Reference Info -->
            <tr>
                <td style="padding: 40px 40px 20px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="50%" style="vertical-align: top;">
                                <div
                                    style="font-size: 10px; font-weight: 800; color: #B8860B; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">
                                    Ref ID</div>
                                <div style="font-size: 18px; font-weight: 700; color: #101010;">#{{ $orderId }}</div>
                            </td>
                            <td width="50%" style="vertical-align: top; text-align: right;">
                                <div
                                    style="font-size: 10px; font-weight: 800; color: #B8860B; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">
                                    Recipient</div>
                                <div style="font-size: 18px; font-weight: 700; color: #101010;">{{ $customerName }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Selection Inventory -->
            <tr>
                <td style="padding: 20px 40px;">
                    <div
                        style="font-size: 12px; font-weight: 800; color: #101010; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; border-bottom: 2px solid #101010; padding-bottom: 10px; display: inline-block;">
                        Selection Inventory</div>

                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 30px; border-collapse: collapse; border: 1px solid #ccc;">
                        <thead>
                            <tr>
                                <th
                                    style="text-align: left; padding: 15px 10px; font-size: 11px; color: #999; text-transform: uppercase; border: 1px solid #ccc;">
                                    Product details</th>
                                <th
                                    style="text-align: center; padding: 15px 10px; font-size: 11px; color: #999; text-transform: uppercase; border: 1px solid #ccc;">
                                    MRP</th>
                                <th
                                    style="text-align: center; padding: 15px 10px; font-size: 11px; color: #999; text-transform: uppercase; border: 1px solid #ccc;">
                                    Discount</th>
                                <th
                                    style="text-align: center; padding: 15px 10px; font-size: 11px; color: #999; text-transform: uppercase; border: 1px solid #ccc;">
                                    Offer Price</th>
                                <th
                                    style="text-align: center; padding: 15px 10px; font-size: 11px; color: #999; text-transform: uppercase; border: 1px solid #ccc;">
                                    Qty</th>
                                <th
                                    style="text-align: center; padding: 15px 10px; font-size: 11px; color: #999; text-transform: uppercase; border: 1px solid #ccc;">
                                    Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                @php
                                    $showDiscount = \App\Models\GlobalSetting::first()->show_discount ?? true;
                                    $mrp = floatval($item['actual'] ?? $item['price'] ?? 0);
                                    $regular = floatval($item['price'] ?? 0);
                                @endphp
                                <tr>
                                    <td style="padding: 15px 10px; border: 1px solid #ccc;">
                                        <div style="font-size: 14px; font-weight: 700; color: #101010; margin-bottom: 3px;">
                                            {{ $item['product_name'] }}</div>
                                        <div style="font-size: 10px; color: #B8860B; font-weight: bold;">
                                            <i class="fa-solid fa-tags" style="margin-right: 4px;"></i> {{ !empty($item['category']) ? strtoupper($item['category']) : 'FIREWORKS CATEGORY' }}
                                        </div>
                                    </td>
                                    <td
                                        style="padding: 15px 10px; text-align: center; font-size: 14px; color: #666; border: 1px solid #ccc;">
                                        ₹{{ number_format($mrp, 2) }}
                                    </td>
                                    <td
                                        style="padding: 15px 10px; text-align: center; font-size: 14px; border: 1px solid #ccc;">
                                        @if($showDiscount && $mrp > $regular && $mrp > 0)
                                            <span style="color: #16A34A; font-weight: 700; text-decoration: none !important;">({{ round((($mrp - $regular) / $mrp) * 100) }}% OFF)</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td
                                        style="padding: 15px 10px; text-align: center; font-size: 14px; color: #666; border: 1px solid #ccc;">
                                        ₹{{ number_format($regular, 2) }}</td>
                                    <td
                                        style="padding: 15px 10px; text-align: center; font-size: 14px; color: #666; border: 1px solid #ccc;">
                                        {{ $item['qty'] }}</td>
                                    <td
                                        style="padding: 15px 10px; text-align: center; font-size: 14px; font-weight: 800; color: #101010; border: 1px solid #ccc;">
                                        ₹{{ number_format($item['total'] ?? 0, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>

            <!-- Financial Settlement -->
            <tr>
                <td style="padding: 0 40px 40px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="60%"></td>
                            <td width="40%"
                                style="background-color: #fbfaf8; border-radius: 20px; padding: 25px; border: 1px solid #efebe1;">
                                <div style="display: table; width: 100%; margin-bottom: 12px;">
                                    <div style="display: table-cell; font-size: 12px; color: #999; font-weight: 600;">
                                        MRP Total</div>
                                    <div
                                        style="display: table-cell; text-align: right; font-size: 12px; color: #999; font-weight: 600;">
                                        ₹{{ number_format($actualTotal, 2) }}</div>
                                </div>
                                @if(($actualTotal - $netTotal) > 0)
                                    <div
                                        style="display: table; width: 100%; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px dashed #efebe1;">
                                        <div
                                            style="display: table-cell; font-size: 12px; color: #28a745; font-weight: 700;">
                                            Club Discount</div>
                                        <div
                                            style="display: table-cell; text-align: right; font-size: 12px; color: #28a745; font-weight: 700;">
                                            - ₹{{ number_format($actualTotal - $netTotal, 2) }}</div>
                                    </div>
                                @endif
                                <div style="display: table; width: 100%;">
                                    <div
                                        style="display: table-cell; font-size: 14px; color: #101010; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">
                                        Net Payable</div>
                                    <div
                                        style="display: table-cell; text-align: right; font-size: 22px; color: #101010; font-weight: 900; font-family: 'Outfit';">
                                        ₹{{ number_format($netTotal, 2) }}</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Payment Terminal -->
            <tr>
                <td style="padding: 40px; background-color: #fbf9f2; border-top: 1px solid #e5e0d5;">
                    <div
                        style="font-size: 12px; font-weight: 800; color: #B8860B; text-transform: uppercase; letter-spacing: 2px; text-align: center; margin-bottom: 30px;">
                        Settlement Portals</div>

                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="48%"
                                style="vertical-align: top; background-color: #ffffff; border-radius: 20px; padding: 25px; border: 1px solid #e5e0d5;">
                                <div
                                    style="font-size: 13px; font-weight: 800; color: #101010; margin-bottom: 15px; border-bottom: 1px solid #f4f1ea; padding-bottom: 10px;">
                                    🏦 Bank Transfer</div>
                                <div style="font-size: 12px; color: #666; line-height: 1.8;">
                                    <strong style="color:#101010;">Bank:</strong> {{ $payment->bank_name ?? 'N/A' }}<br>
                                    <strong style="color:#101010;">A/C No:</strong> <span
                                        style="font-family:monospace; font-size:14px;">{{ $payment->account_number ?? 'N/A' }}</span><br>
                                    <strong style="color:#101010;">IFSC:</strong> {{ $payment->ifsc_code ?? 'N/A' }}<br>
                                    <strong style="color:#101010;">Holder:</strong>
                                    {{ $payment->account_name ?? 'N/A' }}
                                </div>
                            </td>
                            <td width="4%"></td>
                            <td width="48%"
                                style="vertical-align: top; background-color: #ffffff; border-radius: 20px; padding: 25px; border: 1px solid #e5e0d5;">
                                <div
                                    style="font-size: 13px; font-weight: 800; color: #101010; margin-bottom: 15px; border-bottom: 1px solid #f4f1ea; padding-bottom: 10px;">
                                    📱 Digital Wallets</div>
                                <div style="font-size: 12px; color: #666; line-height: 1.8;">
                                    <strong style="color:#101010;">GPay / PhonePe:</strong><br>
                                    <span
                                        style="font-family:monospace; font-size:14px; color:#101010;">{{ $payment->gpay_number ?? $payment->phonepe_number ?? 'N/A' }}</span>

                                    <div style="margin-top: 15px; text-align: center;">
                                        @if(!empty($payment->gpay_qr_code))
                                            <img src="{{ env('MAIN_URL') . $payment->gpay_qr_code }}" width="100"
                                                height="100"
                                                style="border: 1px solid #eee; border-radius: 10px; padding: 5px;"
                                                alt="UPI QR">
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    @if(!empty($payment->additional_notes))
                        <div
                            style="margin-top: 30px; padding: 20px; border: 1px dashed #B8860B; border-radius: 15px; background-color: #fffefb; font-size: 12px; color: #666; line-height: 1.6; font-style: italic;">
                            <strong
                                style="color:#B8860B; font-style: normal; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Dispatcher
                                Notes:</strong> {{ strip_tags($payment->additional_notes) }}
                        </div>
                    @endif
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td style="padding: 40px; text-align: center; color: #999;">
                    <div
                        style="font-size: 16px; color: #101010; font-weight: 400; font-family: 'Cormorant Garamond', Georgia, serif; margin-bottom: 10px;">
                        Sri Shyam <span style="color: #B8860B;">Crackers</span></div>
                    <div style="font-size: 11px; font-weight: 500; letter-spacing: 1px;">SIVAKASI • TAMIL NADU • QUALITY
                        GUARANTEED</div>
                    <div style="margin-top: 20px; font-size: 10px; opacity: 0.6;">This is an automated transaction
                        breakdown. No signature required.</div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>

</body>

</html>