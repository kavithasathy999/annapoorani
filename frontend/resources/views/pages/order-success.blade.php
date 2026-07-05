@extends('layouts.default')

@section('main-page')

    @push('styles')
        <style>
            /* ===========================================
           PRISTINE SUCCESS TERMINAL (GOLDEN LIGHT - WHITE)
           =========================================== */

            :root {
                --ink: #111111;
                --gold-deep: #B8860B;
                --gold-soft: #f4ece1;
                --cream: #f9f7f2;
                --stone: #e8e4db;
                --glass-white: rgba(255, 255, 255, 0.8);
                --font-display: 'Outfit', sans-serif;
                --font-body: 'Outfit', sans-serif;
            }

            .success-page {
                background: var(--cream);
                min-height: 100vh;
                padding-bottom: 100px;
                position: relative;
                overflow-x: hidden;
                color: var(--ink);
            }

            /* 1. LIGHT CINEMATIC HERO */
            .success-hero {
                height: 65vh;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                overflow: hidden;
                background: #fff;
            }

            .hero-bg {
                position: absolute;
                inset: 0;
                background-image: url('{{ asset('brain/4d8ae542-7bd4-4c30-876d-25d65ee76364/success_light_heritage_1776426911549.png') }}');
                background-size: cover;
                background-position: center;
                transform: scale(1.1);
                filter: brightness(1.05);
                /* Make it bright */
                transition: transform 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            }

            .hero-overlay {
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at center, rgba(255, 255, 255, 0.4) 0%, var(--cream) 90%);
            }

            .success-hero-content {
                position: relative;
                z-index: 10;
                padding: 0 20px;
            }

            .success-check-orb {
                width: 110px;
                height: 110px;
                background: linear-gradient(145deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.05));
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                border: 2px solid rgba(255, 255, 255, 0.6);
                border-radius: 50%;
                margin: 0 auto 30px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2.5rem;
                color: #FFFFFF;
                box-shadow: 
                    0 0 30px rgba(255, 255, 255, 0.2),
                    inset 0 1px 0 rgba(255, 255, 255, 0.5);
                animation: orbPulse 3s infinite alternate;
                text-shadow: 0 0 15px rgba(255, 255, 255, 0.6);
            }

            .success-eyebrow {
                font-size: 0.9rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 6px;
                color: var(--gold-deep);
                margin-bottom: 15px;
            }

            .success-title {
                font-family: var(--font-display);
                font-size: clamp(2.5rem, 6vw, 4.5rem);
                line-height: 1;
                color: #fff;
                margin-bottom: 25px;
                font-weight: 900;
                text-shadow:
                    0 2px 10px rgba(255, 255, 255, 0.3),
                    0 0 40px rgba(255, 255, 255, 0.2),
                    0 0 80px rgba(255, 255, 255, 0.1);
            }

            .success-title span {
                display: block;
                font-style: italic;
                font-weight: 400;
                color: var(--gold-deep);
                opacity: 0.9;
            }

            .token-pill {
                display: inline-flex;
                align-items: center;
                gap: 15px;
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
                backdrop-filter: blur(10px);
                border: 1.5px solid rgba(255, 255, 255, 0.4);
                padding: 10px 25px;
                border-radius: 50px;
                box-shadow: 
                    0 10px 30px rgba(0, 0, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
            }

            .token-id {
                color: var(--gold-deep);
                font-weight: 900;
            }

            /* 2. LIGHT DATA TERMINALS */
            .success-container {
                width: min(100% - 40px, 950px);
                margin: -80px auto 0;
                position: relative;
                z-index: 20;
            }

            .terminal-card {
                background: linear-gradient(145deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03));
                backdrop-filter: blur(25px);
                -webkit-backdrop-filter: blur(25px);
                border: 2px solid rgba(255, 255, 255, 0.5) !important;
                border-radius: 40px;
                margin-bottom: 30px;
                overflow: hidden;
                box-shadow: 
                    0 24px 70px rgba(0, 0, 0, 0.45),
                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
                position: relative;
            }

            .terminal-card::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0; bottom: 0;
                background: radial-gradient(circle at 50% 0%, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
                pointer-events: none;
            }

            .terminal-header {
                background: #fafafafa;
                padding: 30px 40px;
                border-bottom: 1px solid var(--stone);
                display: flex;
                align-items: center;
                gap: 15px;
                font-family: var(--font-display);
                font-size: 1.5rem;
                color: var(--ink);
            }

            .terminal-header i {
                color: var(--gold-deep);
            }

            /* 3. SHOWCASE TABLE */
            .showcase-table-wrap {
                overflow-x: auto;
            }

            .showcase-table {
                width: 100%;
                border-collapse: collapse;
                min-width: 600px;
            }

            .showcase-table th {
                padding: 20px 40px;
                text-align: left;
                font-size: 0.75rem;
                font-weight: 800;
                text-transform: uppercase;
                color: var(--muted);
                letter-spacing: 2px;
            }

            .showcase-table td {
                padding: 20px 40px;
                border-top: 1px solid #f5f5f5;
            }

            .prod-preview {
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .prod-preview img {
                width: 55px;
                height: 55px;
                border-radius: 12px;
                object-fit: cover;
                border: 1px solid #eee;
            }

            .prod-name {
                font-weight: 800;
                color: var(--ink);
            }

            .val-box {
                color: #555;
                font-weight: 600;
                font-family: var(--font-body);
            }

            .qty-tag {
                background: var(--gold-soft);
                color: var(--gold-deep);
                padding: 5px 12px;
                border-radius: 10px;
                font-weight: 900;
                font-size: 0.8rem;
            }

            /* 4. FINANCIAL WRAP */
            .financial-strip {
                padding: 40px;
            }

            .fin-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 15px;
                font-weight: 700;
                color: #666;
            }

            .fin-row.savings {
                background: #f0fff4;
                border: 1px solid #c6f6d5;
                padding: 20px 30px;
                border-radius: 20px;
                color: #2f855a;
            }

            .fin-row.total {
                margin-top: 30px;
                padding-top: 30px;
                border-top: 1px dashed var(--stone);
                font-size: 2.2rem;
                color: var(--ink);
            }

            .fin-row.total .val {
                color: var(--gold-deep);
                font-weight: 900;
            }

            /* 5. PAYMENT HUB */
            .pay-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                padding: 40px;
            }

            .pay-slab {
                background: linear-gradient(145deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.02));
                border: 1.5px solid rgba(255, 255, 255, 0.3);
                padding: 30px;
                border-radius: 25px;
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2);
            }

            .slab-meta {
                font-size: 0.9rem;
                line-height: 2.2;
                color: #666;
            }

            .slab-meta strong {
                color: var(--ink);
                width: 110px;
                display: inline-block;
                font-weight: 800;
            }

            .slab-qr {
                margin-top: 25px;
                display: flex;
                gap: 20px;
            }

            .slab-qr img {
                width: 90px;
                height: 90px;
                border-radius: 15px;
                padding: 5px;
                background: #fff;
                border: 1px solid #eee;
            }

            /* 6. ACTIONS */
            .action-strip {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
                margin-top: 40px;
            }

            .a-btn {
                height: 70px;
                border-radius: 25px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
                font-weight: 900;
                text-transform: uppercase;
                text-decoration: none;
                transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
                border: none;
                cursor: pointer;
            }

            .a-btn:hover {
                transform: translateY(-8px);
            }

            .a-btn-dark {
                background: #fff;
                color: #080810;
                box-shadow: 0 15px 35px rgba(255, 255, 255, 0.2);
            }

            .a-btn-dark:hover {
                background: #f0f0f0;
                transform: translateY(-5px);
            }

            .a-btn-ghost {
                background: rgba(255, 255, 255, 0.1);
                color: #fff;
                border: 1.5px solid rgba(255, 255, 255, 0.5);
                backdrop-filter: blur(10px);
            }

            .a-btn-ghost:hover {
                background: #fff;
                color: #111;
                transform: translateY(-5px);
            }

            .a-btn-gold {
                background: linear-gradient(135deg, var(--gold-light), var(--gold));
                color: #111;
                box-shadow: 0 15px 35px rgba(240, 168, 50, 0.3);
            }

            @keyframes orbPulse {
                from {
                    transform: scale(1);
                    box-shadow: 0 0 20px rgba(184, 134, 11, 0.1);
                }

                to {
                    transform: scale(1.05);
                    box-shadow: 0 0 40px rgba(184, 134, 11, 0.3);
                }
            }

            @media (max-width: 900px) {

                .pay-grid,
                .action-strip {
                    grid-template-columns: 1fr;
                }

                .success-container {
                    margin-top: -40px;
                }

                .success-hero {
                    height: 50vh;
                }
            }

            /* Dark premium polish aligned with home/about/contact */
            .success-page {
                background:
                    linear-gradient(180deg, rgba(8,8,16,0.98), rgba(12,12,24,0.98));
                color: #fff;
            }

            .success-hero {
                min-height: 580px;
                background: #080810;
            }

            .hero-bg {
                filter: brightness(0.55) saturate(1.1);
            }

            .hero-overlay {
                background:
                    radial-gradient(circle at 50% 42%, rgba(240,168,50,0.16), transparent 18rem),
                    linear-gradient(to bottom, rgba(8,8,16,0.66), rgba(8,8,16,0.97));
            }

            .success-check-orb {
                background: rgba(15,15,28,0.92);
                border-color: rgba(240,168,50,0.5);
                color: var(--gold-light);
            }

            .success-title {
                color: #fff;
                font-weight: 900;
            }

            .success-title span,
            .token-id,
            .fin-row.total .val {
                color: var(--gold-light);
            }

            .token-pill,
            .terminal-card,
            .pay-slab,
            .a-btn-ghost {
                background: rgba(15,15,28,0.92);
                border-color: rgba(240,168,50,0.22);
                box-shadow: 0 24px 70px rgba(0,0,0,0.45);
            }

            .token-pill span:first-child,
            .terminal-header,
            .prod-name,
            .fin-row.total,
            .slab-meta strong,
            .a-btn-ghost {
                color: #fff !important;
            }

            .terminal-header {
                background: rgba(255,255,255,0.04);
                border-bottom-color: rgba(255,255,255,0.1);
            }

            .showcase-table th,
            .fin-row,
            .slab-meta {
                color: rgba(255,255,255,0.62);
            }

            .showcase-table td {
                border-top-color: rgba(255,255,255,0.08);
            }

            .qty-tag,
            .fin-row.savings {
                background: rgba(37,211,102,0.12);
                border-color: rgba(37,211,102,0.22);
            }

            .a-btn-dark {
                background: #fff;
                color: #080810;
            }

            .a-btn-gold {
                background: linear-gradient(135deg, var(--gold-light), var(--gold));
                color: #080810;
            }

            @media (max-width: 575px) {
                .success-container {
                    width: min(100% - 24px, 950px);
                }

                .terminal-header,
                .financial-strip,
                .pay-grid {
                    padding: 24px;
                }

                .fin-row.total {
                    font-size: 1.55rem;
                }
            }
        </style>
    @endpush

    <div class="success-page">

        <!-- 1. PRISTINE HERO -->
        <section class="success-hero">
            <div class="hero-bg" id="heroBg"></div>
            <div class="hero-overlay"></div>

            <div class="success-hero-content">
                <div class="success-check-orb wow scaleIn">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="success-eyebrow wow fadeInUp">Celebration Confirmed</div>
                <h1 class="success-title wow fadeInUp" data-wow-delay="0.2s">
                    Order Placed <span>Successfully</span>
                </h1>

                <div class="token-pill wow fadeInUp" data-wow-delay="0.4s">
                    <span
                        style="font-size:0.7rem; opacity:0.5; text-transform:uppercase; letter-spacing:2px; color:var(--ink);">Receipt
                        Hash</span>
                    <span class="token-id">#{{ $order_id }}</span>
                </div>
            </div>
        </section>

        <div class="success-container">

            <!-- 2. SELECTION SHOWCASE -->
            <div class="terminal-card wow fadeInUp">
                <div class="terminal-header">
                    <i class="fa-solid fa-box-open"></i> Selection Showcase ({{ count($cartItems) }})
                </div>
                <div class="showcase-table-wrap">
                    <table class="showcase-table">
                        <thead>
                            <tr>
                                <th>Product Information</th>
                                <th>Unit Rate</th>
                                <th>Count</th>
                                <th style="text-align:right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="prod-preview">
                                            @if(!empty($item['img']))
                                                <img src="{{ url($item['img']) }}"
                                                    onerror="this.src='{{ asset('assets/img/placeholder.jpg') }}'">
                                            @endif
                                            <span class="prod-name">{{ $item['product_name'] }}</span>
                                        </div>
                                    </td>
                                    <td><span class="val-box">₹{{ number_format($item['price'], 2) }}</span></td>
                                    <td><span class="qty-tag">×{{ $item['qty'] }}</span></td>
                                    <td style="text-align:right;"><span class="val-box"
                                            style="color:var(--ink); font-weight:800;">₹{{ number_format($item['total'], 2) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. FINANCIAL BREAKDOWN -->
            <div class="terminal-card wow fadeInUp">
                <div class="terminal-header">
                    <i class="fa-solid fa-receipt"></i> Settlement Details
                </div>
                <div class="financial-strip">
                    <div class="fin-row"><span>Actual Market Value</span><span>₹{{ number_format($actualTotal, 2) }}</span>
                    </div>
                    @if($actualTotal > $netTotal)
                        <div class="fin-row savings">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <i class="fas fa-gift"></i> Your Selection Bonus
                            </div>
                            <span>- ₹{{ number_format($actualTotal - $netTotal, 2) }}</span>
                        </div>
                    @endif
                    <div class="fin-row total">
                        <span>Net Payable</span>
                        <span class="val">₹{{ number_format($netTotal, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- 4. TERMINAL ACTIONS -->
            <div class="action-strip">
                <a href="/" class="a-btn a-btn-ghost"><i class="fa-solid fa-house"></i> Home</a>
                <button onclick="downloadOrderPDF()" class="a-btn a-btn-dark"><i class="fa-solid fa-file-pdf"></i> Download
                    Receipt</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        // PARALLAX EFFECT
        window.addEventListener('scroll', () => {
            const bg = document.getElementById('heroBg');
            if (bg) bg.style.transform = `scale(1.1) translateY(${window.scrollY * 0.4}px)`;
        });

        const ORDER_DATA = {
            orderId: "{{ $order_id }}",
            netTotal: {{ $netTotal }},
            items: @json($cartItems)
        };

        // PDF GENERATION
        async function downloadOrderPDF() {
            const btn = document.querySelector('.a-btn-dark');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> PREPARING...';

            try {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF('p', 'pt', 'a4');
                const A4_W = 1000;
                let rowsHtml = '';

                ORDER_DATA.items.forEach((item, i) => {
                    const bg = i % 2 === 0 ? '#ffffff' : '#fafafa';
                    rowsHtml += `
                        <tr style="background:${bg}; border-bottom: 1px solid #eee;">
                            <td style="padding:15px; width:45%; color:#111; font-weight:600;">${item.product_name}</td>
                            <td style="padding:15px; text-align:center; width:20%; color:#444;">₹${parseFloat(item.price).toFixed(2)}</td>
                            <td style="padding:15px; text-align:center; width:15%; color:#444;">x${item.qty}</td>
                            <td style="padding:15px; text-align:right; font-weight:800; width:20%; color:#111;">₹${parseFloat(item.total).toFixed(2)}</td>
                        </tr>`;
                });

                const receiptHtml = `
                    <div id="pdf-receipt-target" style="width: 1000px; background:#ffffff; color:#111; padding:60px 80px;">
                        <div style="border-bottom:5px solid #B8860B; padding-bottom:30px; margin-bottom:50px; display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <h1 style="color:#B8860B; margin:0; font-size:45px; letter-spacing:2px;">Sri Annapoorani CRACKERS</h1>
                                <p style="margin:5px 0 0; color:#888; text-transform:uppercase; letter-spacing:4px;">Official Sales Receipt</p>
                            </div>
                            <div style="text-align:right; background:#f9f9f9; padding:20px; border-radius:10px;">
                                <div style="color:#888; font-size:12px;">RECEIPT NO.</div>
                                <div style="font-size:28px; font-weight:800; color:#111;">#${ORDER_DATA.orderId}</div>
                            </div>
                        </div>
                        <table style="width:100%; border-collapse:collapse;">
                            <thead><tr style="background:#f4ece1; color:#B8860B;">
                                <th style="padding:15px; text-align:left; border:1px solid #e8e4db;">DESCRIPTION</th>
                                <th style="padding:15px; border:1px solid #e8e4db;">RATE</th>
                                <th style="padding:15px; border:1px solid #e8e4db;">QTY</th>
                                <th style="padding:15px; text-align:right; border:1px solid #e8e4db;">TOTAL</th>
                            </tr></thead>
                            <tbody>${rowsHtml}</tbody>
                        </table>
                        <div style="margin-top:50px; text-align:right; padding:30px; background:#f4ece1; border-radius:20px;">
                            <div style="font-size:28px; font-weight:900; color:#B8860B;">GRAND TOTAL: ₹${ORDER_DATA.netTotal.toLocaleString('en-IN', { minimumFractionDigits: 2 })}</div>
                            <p style="margin:10px 0 0; color:#888; font-style:italic;">This is an automated receipt generated bySri Annapoorani Crackers Selection Terminal.</p>
                        </div>
                    </div>`;

                const wrapper = document.createElement('div');
                wrapper.style.cssText = 'position:absolute;top:-9999px;width:1000px;';
                wrapper.innerHTML = receiptHtml;
                document.body.appendChild(wrapper);

                const canvas = await html2canvas(wrapper.querySelector('#pdf-receipt-target'), { scale: 2 });
                document.body.removeChild(wrapper);

                const imgData = canvas.toDataURL('image/jpeg', 0.95);
                doc.addImage(imgData, 'JPEG', 0, 0, 595.28, (canvas.height * 595.28) / canvas.width);
                doc.save(`Receipt_Sri Annapoorani_${ORDER_DATA.orderId}.pdf`);

            } catch (err) { alert('Receipt synchronization failed: ' + err.message); }
            finally { btn.innerHTML = originalText; }
        }
    </script>

    @include('pages._cracker-canvas')

@endsection
