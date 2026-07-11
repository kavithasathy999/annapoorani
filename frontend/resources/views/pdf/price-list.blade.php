<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Price List - Sri Annapoorani Crackers</title>
    <style>
        @page { margin: 1cm; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }
        .header-table {
            width: 100%;
            margin-bottom: 10px;
        }
        .header-left {
            width: 70%;
            vertical-align: top;
        }
        .header-right {
            width: 30%;
            text-align: right;
            vertical-align: top;
        }
        .company-name {
            font-size: 22px;
            font-weight: 800;
            text-transform: uppercase;
            margin: 0 0 5px 0;
            color: #000;
        }
        .company-details {
            font-size: 11px;
            color: #444;
        }
        .original-text {
            font-size: 12px;
            color: #777;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .logo {
            max-width: 120px;
            max-height: 120px;
        }
        .divider {
            border-top: 2px solid #007fb1;
            margin: 10px 0;
        }
        .doc-title {
            text-align: center;
            color: #007fb1;
            font-size: 24px;
            font-weight: 700;
            margin: 10px 0 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th {
            background-color: #007fb1;
            color: #ffffff;
            text-align: left;
            padding: 10px 8px;
            font-size: 12px;
            font-weight: 700;
        }
        td {
            padding: 8px 8px;
            border-bottom: 1px solid #eee;
            font-size: 12px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .product-name {
            font-weight: 600;
            color: #333;
        }
        .price-col {
            text-align: right;
        }
        .center-col {
            text-align: center;
        }
        .symbol {
            font-family: 'DejaVu Sans', sans-serif;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .category-header {
            background-color: #e6f7ff;
            color: #007fb1;
            font-weight: 700;
            padding: 8px;
            text-align: center;
            font-size: 13px;
            border: 1px solid #b3e0ff;
            margin-bottom: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    @php 
        $global = \App\Models\GlobalSetting::first();
    @endphp

    <table class="header-table">
        <tr>
            <td class="header-left">
                <h1 class="company-name">{{ $global->company_name ?? 'SRI ANNAPOORANI CRACKERS' }}</h1>
                <div class="company-details">
                    @if($global && $global->address)
                        <div>{{ $global->address }}</div>
                    @else
                        <div>1/205-13, Sattur to Virudhunagar Main Road, R R Nagar, Virudhunagar district.</div>
                    @endif
                    @if($global && $global->phone)
                        <div>Phone no: {{ $global->phone }}</div>
                    @else
                        <div>Phone no: 9360353597</div>
                    @endif
                    @if($global && $global->email)
                        <div>Email: {{ $global->email }}</div>
                    @else
                        <div>Email: sriannapooranicrackers@gmail.com</div>
                    @endif
                </div>
            </td>
            <td class="header-right">
                <div class="original-text">ORIGINAL</div>
                <img src="{{ public_path('assets/img/annapoorani-image.png') }}" class="logo" alt="Logo">
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="doc-title">Price List</div>

    @foreach($categories as $category)
        @if($category->products->count() > 0)
            <div class="category-header">{{ $category->category_name }}</div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 40px;">S.NO</th>
                        <th>Product</th>
                        <th class="center-col" style="width: 60px;">Unit</th>
                        <th class="price-col" style="width: 90px;">Actual Price</th>
                        <th class="center-col" style="width: 80px;">Discount</th>
                        <th class="price-col" style="width: 90px;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category->products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="product-name">{{ $product->product_name }}</td>
                            @php
                                $name = strtolower($product->product_name);
                                if (strpos($name, '1 pcs') !== false) {
                                    $unit = '1 Piece';
                                } elseif (strpos($name, 'pcs') !== false) {
                                    $unit = '1 Pieces';
                                } elseif (strpos($name, 'items') !== false) {
                                    $unit = '1 Box';
                                } elseif (strpos($name, 'kg') !== false || strpos($name, 'way') !== false) {
                                    $unit = '1';
                                } else {
                                    $unit = '1';
                                }
                            @endphp
                            <td class="center-col" style="color: #555; font-weight: 500;">{{ $unit }}</td>
                            <td class="price-col" style="color: #888; text-decoration: line-through;">
                                @if($product->show_mrp_in_pdf && $product->product_mrp_price > 0)
                                    <span class="symbol">₹</span>{{ number_format($product->product_mrp_price, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="center-col" style="color: #d93025; font-weight: 600;">
                                @if($product->show_discount_in_pdf && $product->product_mrp_price > 0 && $product->product_mrp_price > $product->product_regular_price)
                                    {{ round((($product->product_mrp_price - $product->product_regular_price) / $product->product_mrp_price) * 100) }}% OFF
                                @else
                                    -
                                @endif
                            </td>
                            <td class="price-col" style="font-weight: 700;">
                                <span class="symbol">₹</span>{{ number_format($product->product_regular_price, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach

    <div class="footer">
        <div>{!! str_replace(['Since 2000,', 'Since 2000'], '', $global->footer_content ?? 'Premium Sivakasi Fireworks • Pan India Delivery') !!}</div>
        <div>Thank you for choosing us for your festive celebrations!</div>
        <div style="margin-top: 5px;">&copy; {{ date('Y') }} {{ $global->company_name ?? 'Sri Annapoorani Crackers' }}. All Rights Reserved.</div>
    </div>
</body>
</html>
