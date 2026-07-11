<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Estimate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            margin: 0;
            padding: 20px;
        }
        .header-table {
            width: 100%;
            margin-bottom: 5px;
        }
        .header-table td {
            vertical-align: top;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }
        .company-details {
            font-size: 14px;
            line-height: 1.5;
        }
        .logo-img {
            max-width: 100px;
        }
        .blue-line {
            border-top: 2px solid #1785B1;
            margin: 10px 0;
        }
        .title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #1785B1;
            margin: 10px 0 20px;
        }
        .bill-to-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .bill-to-name {
            font-size: 16px;
            font-weight: bold;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .items-table th {
            background-color: #1785B1;
            color: white;
            padding: 10px;
            font-size: 14px;
            text-align: right;
        }
        .items-table th.left-align {
            text-align: left;
        }
        .items-table td {
            padding: 10px;
            font-size: 14px;
            text-align: right;
            border-bottom: 1px solid #eee;
        }
        .items-table td.left-align {
            text-align: left;
        }
        .total-row td {
            font-weight: bold;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
        }
        .footer-section {
            width: 100%;
            margin-top: 20px;
        }
        .footer-left {
            width: 60%;
            vertical-align: top;
            padding-right: 20px;
        }
        .footer-right {
            width: 40%;
            vertical-align: top;
        }
        .footer-heading {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .footer-text {
            font-size: 14px;
            margin-bottom: 20px;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 8px 10px;
            font-size: 14px;
        }
        .summary-table td:last-child {
            text-align: right;
        }
        .summary-total {
            background-color: #1785B1;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>

@php
if (!function_exists('numberToWords')) {
    function numberToWords($number) {
        $no = floor($number);
        $point = round($number - $no, 2) * 100;
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
        '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
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
                $plural = (($counter = count($str)) && $number > 9) ? '' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred
                    : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
            } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        return trim($result) . " Rupees only";
    }
}
@endphp

<table class="header-table">
    <tr>
        <td style="width: 70%;">
            <div class="company-name">SRI ANNAPOORANI CRACKERS</div>
            <div class="company-details">
                1/205-13, Sattur to Virudhunagar Main Road, R R<br>
                Nagar, Virudhunagar district.<br>
                Phone no: 9360353597<br>
                Email: sriannapooranicrackers@gmail.com
            </div>
        </td>
        <td style="width: 30%; text-align: right;">
            <img src="{{ public_path('assets/img/annapoorani-image.png') }}" alt="Logo" class="logo-img">
        </td>
    </tr>
</table>

<div class="blue-line"></div>

<div class="title">Estimate</div>

<div>
    <div class="bill-to-title">Bill To</div>
    <div class="bill-to-name">{{ $customer->name ?? 'Walk-in Customer' }}</div>
</div>

<table class="items-table">
    <thead>
        <tr>
            <th class="left-align" style="width: 5%;">S.NO</th>
            <th class="left-align" style="width: 40%;">Product</th>
            <th style="width: 10%;">Quantity</th>
            <th style="width: 10%;">Unit</th>
            <th style="width: 15%;">Price</th>
            <th style="width: 20%;">Amount</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalQty = 0;
            $netTotalAmount = isset($order->total) ? floatval($order->total) : 0;
        @endphp
        @foreach($items as $index => $item)
            @php
                $qty = isset($item->qty) ? (int)$item->qty : 0;
                $total = floatval($item->product_total ?? 0);
                $price = $qty > 0 ? $total / $qty : 0;
                $totalQty += $qty;
            @endphp
            <tr>
                <td class="left-align">{{ $index + 1 }}</td>
                <td class="left-align"><b>{{ $item->product_name ?? 'Product #' . $item->product_id }}</b></td>
                <td>{{ $qty }}</td>
                <td>-</td>
                <td style="white-space: nowrap;">Rs&nbsp;{{ number_format($price, 2) }}</td>
                <td style="white-space: nowrap;">Rs&nbsp;{{ number_format($total, 2) }}</td>
            </tr>
        @endforeach
        <tr class="total-row">
            <td colspan="2" class="left-align" style="text-align: center;">Total</td>
            <td>{{ $totalQty }}</td>
            <td></td>
            <td></td>
            <td style="white-space: nowrap;">Rs&nbsp;{{ number_format($netTotalAmount, 2) }}</td>
        </tr>
    </tbody>
</table>

<table class="footer-section">
    <tr>
        <td class="footer-left">
            <div class="footer-heading">Estimate Amount In Words</div>
            <div class="footer-text">{{ numberToWords($netTotalAmount) }}</div>
            <div class="footer-text">
                Thank you Purchasing enjoy the festival in our<br>
                crackers,<br>
                Make your Happiness sure with our crackers!
            </div>
        </td>
        <td class="footer-right">
            <table class="summary-table">
                <tr>
                    <td>Sub Total</td>
                    <td style="white-space: nowrap;">Rs&nbsp;{{ number_format($netTotalAmount, 2) }}</td>
                </tr>
                <tr class="summary-total">
                    <td>Total</td>
                    <td style="white-space: nowrap;">Rs&nbsp;{{ number_format($netTotalAmount, 2) }}</td>
                </tr>
                <tr>
                    <td>Received</td>
                    <td style="white-space: nowrap;">Rs&nbsp;{{ number_format($netTotalAmount, 2) }}</td>
                </tr>
                <tr>
                    <td>Previous Balance</td>
                    <td style="white-space: nowrap;">Rs&nbsp;0.00</td>
                </tr>
                <tr style="border-bottom: 2px solid #000;">
                    <td>Current Balance</td>
                    <td style="white-space: nowrap;">Rs&nbsp;0.00</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
