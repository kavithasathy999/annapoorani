<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $order->order_no }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #000; padding: 20px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid #000; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #f2f2f2; }
        .header-top { display: table; width: 100%; }
        .header-top-row { display: table-row; }
        .header-top-cell { display: table-cell; }
        .invoice-title { font-size: 24px; font-weight: bold; margin-bottom: 5px; }
        .address { font-size: 11px; line-height: 1.4; }
        .customer-info { display: table; width: 100%; margin-top: 10px; border: 1px solid #000; }
        .customer-col { display: table-cell; width: 50%; border: 1px solid #000; padding: 5px; vertical-align: top; }
        .meta-col { display: table-cell; width: 50%; border: 1px solid #000; padding: 5px; vertical-align: top; }
        .total-row { font-weight: bold; }
        .footer-info { margin-top: 20px; font-size: 11px; }
        .footer-signatures { display: table; width: 100%; margin-top: 50px; text-align: center; }
        .footer-sig-cell { display: table-cell; width: 33%; }
        .amount-words { border: 1px solid #000; border-top: none; padding: 5px; font-weight: bold; }
        .gst-scheme { background: #000; color: #fff; padding: 3px 5px; display: inline-block; font-size: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <div style="text-align: right; font-size: 10px; font-weight: bold;">
        GST.No.33AASFC9078N1ZK
    </div>
    
    <div class="text-center" style="margin-top: 5px;">
        <div class="invoice-title">C ANNAPOORANI PATTASU KADAI</div>
        <div class="address">
            1/205-13 Sattur to Virudhunagar Main Road<br>
            Vachakarapatti, R.R.Nagar, Virudhunagar-626 204
        </div>
    </div>

    <div class="customer-info">
        <div class="customer-col">
            <div class="font-bold">To,</div>
            <div style="margin-top: 5px;">
                M/S: <strong>{{ $customer->name ?? 'Walk-in Customer' }}</strong><br>
                {{ $customer->address ?? '' }}<br>
                {{ $customer->city ?? '' }}, {{ $customer->state ?? '' }} - {{ $customer->pincode ?? '' }}<br>
                Phone: {{ $customer->phone_number ?? '' }}
            </div>
            <div style="margin-top: 10px;">
                PARTY'S Adhaar NO:
            </div>
        </div>
        <div class="meta-col">
            <div class="header-top">
                <div class="header-top-cell text-center font-bold" style="width: 50%;">HSN-3604</div>
                <div class="header-top-cell font-bold" style="background-color: yellow; text-align: center;">INVOICE</div>
            </div>
            <div style="margin-top: 15px;">
                <strong>INVOICE NO :</strong> {{ $order->order_no }}<br><br>
                <strong>INVOICE DATE :</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">S.NO</th>
                <th style="width: 35%;">Particulars</th>
                <th style="width: 10%;">Quantity</th>
                <th style="width: 13%;">MRP (Rs.)</th>
                <th style="width: 12%;">Discount (%)</th>
                <th style="width: 10%;">Rate (Rs.)</th>
                <th style="width: 15%;">Amount (Rs.)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->product_name ?? 'Product #' . $item->product_id }}</td>
                <td class="text-center">{{ $item->qty }}</td>
                @php
                    $rate = $item->qty > 0 ? $item->product_total / $item->qty : 0;
                    $mrp = $item->product && $item->product->product_mrp_price > 0 ? $item->product->product_mrp_price : $rate;
                    $discount_amount = max(0, $mrp - $rate);
                    $discount_percentage = $mrp > 0 ? ($discount_amount / $mrp) * 100 : 0;
                @endphp
                <td class="text-right">{{ number_format($mrp, 2) }}</td>
                <td class="text-right">{{ round($discount_percentage) }}%</td>
                <td class="text-right">{{ number_format($rate, 2) }}</td>
                <td class="text-right">{{ number_format($item->product_total, 2) }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="7" style="border: none; padding: 20px;">
                    <span class="gst-scheme">COMPOSITION SCHEME UNDER GST</span>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6" class="text-right">MRP :</td>
                <td class="text-right">{{ number_format($order->sub_total, 2) }}</td>
            </tr>
            @if($order->additional_charge_amount > 0)
            <tr class="total-row">
                <td colspan="6" class="text-right">Additional Charge ({{ $order->additional_charge_type }}) :</td>
                <td class="text-right">{{ number_format($order->additional_charge_amount, 2) }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td colspan="6" class="text-right">TOTAL :</td>
                <td class="text-right">{{ number_format($order->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="amount-words">
        @php
            function numberToWords($number) {
                $no = (int) floor($number);
                $point = (int) round(($number - $no) * 100);
                $hundred = null;
                $digits_1 = strlen($no);
                $i = 0;
                $str = array();
                $words = array('0' => '', '1' => 'One', '2' => 'Two',
                '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
                '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
                '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
                '13' => 'Thirteen', '14' => 'Fourteen',
                '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
                '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty',
                '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
                '60' => 'Sixty', '70' => 'Seventy',
                '80' => 'Eighty', '90' => 'Ninety');
                $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
                while ($i < $digits_1) {
                    $divider = ($i == 2) ? 10 : 100;
                    $number = floor($no % $divider);
                    $no = floor($no / $divider);
                    $i += ($divider == 10) ? 1 : 2;
                    if ($number) {
                        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                        $str [] = ($number < 21) ? $words[$number] .
                            " " . $digits[$counter] . $plural . " " . $hundred
                            :
                            $words[floor($number / 10) * 10] .
                            " " . $words[$number % 10] . " " .
                            $digits[$counter] . $plural . " " . $hundred;
                    } else $str[] = null;
                }
                $str = array_reverse($str);
                $result = implode('', $str);
                return $result ?: 'Zero';
            }
        @endphp
        Amount in Words: <span style="font-weight: normal; font-style: italic;">Rupees {{ numberToWords($order->total) }} Only</span>
    </div>
    
    <div style="border: 1px solid #000; border-top: none; padding: 5px; padding-bottom: 20px;">
        <div class="header-top">
            <div class="header-top-cell" style="width: 50%;">Dispatched Bundles ........................................</div>
            <div class="header-top-cell" style="width: 50%;">From ........................................</div>
        </div>
        <div style="margin-top: 10px;">
            Dispatched Through ........................................................................
        </div>
    </div>

    <div class="footer-signatures">
        <div class="footer-sig-cell">Prepared By</div>
        <div class="footer-sig-cell">Created By</div>
        <div class="footer-sig-cell font-bold">
            For ANNAPOORANI PATTASU KADAI<br><br><br>
            Partner/Manager
        </div>
    </div>
</body>
</html>
