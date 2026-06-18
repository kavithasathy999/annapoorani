@extends('layouts.default')

@section('main-page')

    <canvas id="successCanvas"></canvas>

    <div class="success-page">
        <div class="success-inner">

            <!-- ── BANNER ── -->
            <div class="success-banner">
                <div class="success-check-ring notranslate">✅</div>
                <div class="success-eyebrow">bluvel Crackers</div>
                <h1 class="success-title">Order Placed!</h1>
                <div class="burn-line"></div>
                <p class="success-desc">Thank you! We'll contact you shortly to confirm your order.</p>
                <div class="success-order-pill">
                    <strong>Order ID &nbsp; {{ $order_id }}</strong>
                </div>
            </div>



            <!-- ── PRODUCT LIST CARD ── -->
            <div class="success-card" id="orderSummaryCard">
                <div class="card-header">
                    <i class="fa-solid fa-box-open"></i>
                    Your Items &nbsp;({{ count($cartItems) }} {{ count($cartItems) === 1 ? 'product' : 'products' }})
                </div>
                <div class="prod-table-scroll">
                    <table class="prod-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cartItems as $item)
                                <tr>
                                    <td>
                                        @if(!empty($item['img']))
                                            <img src="{{ $item['img'] }}" class="prod-img" onerror="this.style.display='none'">
                                        @endif
                                        <span class="prod-name">{{ $item['product_name'] }}</span>
                                    </td>
                                    <td>₹{{ number_format($item['price'], 2) }}</td>
                                    <td><span class="qty-chip">×{{ $item['qty'] }}</span></td>
                                    <td>₹{{ number_format($item['total'], 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align:center; color:rgba(255,200,140,0.4); padding:30px;">
                                        No items found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ── TOTALS CARD ── -->
            <div class="success-card">
                <div class="card-header">
                    <i class="fa-solid fa-receipt"></i>
                    Order Summary
                </div>
                <div class="totals-wrap">
                    <div class="total-row">
                        <span class="lbl">Actual Total (MRP)</span>
                        <span class="val">₹{{ number_format($actualTotal, 2) }}</span>
                    </div>
                    @if(($actualTotal - $netTotal) > 0)
                        <div class="total-row savings">
                            <span class="lbl">🎉 You Save</span>
                            <span class="val">₹{{ number_format($actualTotal - $netTotal, 2) }}</span>
                        </div>
                        <div class="total-row discount">
                            <span class="lbl">Discount</span>
                            <span class="val">{{ $actualTotal > 0 ? number_format((($actualTotal - $netTotal) / $actualTotal) * 100, 2) : '0.00' }}%</span>
                        </div>
                    @endif
                    <div class="total-row grand">
                        <span class="lbl">Net Payable</span>
                        <span class="val">₹{{ number_format($netTotal, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- ── PAYMENT INFORMATION CARD ── -->
            <div class="success-card">
                <div class="card-header">
                    <i class="fa-solid fa-credit-card"></i>
                    Payment Information
                </div>
                <div class="payment-instruction-text"
                    style="padding: 15px; color: rgba(255,255,255,0.6); font-size: 13px; line-height: 1.5; border-bottom: 1px solid rgba(255,255,255,0.05);">
                    Please complete your payment using one of the methods below and share the screenshot with us for order
                    confirmation.
                </div>
                <div class="payment-methods-grid"
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; padding: 15px;">
                    <!-- Bank Details -->
                    <div class="pm-box"
                        style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 15px;">
                        <div
                            style="font-weight: 700; color: #D4AF37; margin-bottom: 10px; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-university"></i> Bank Transfer
                        </div>
                        <div style="font-size: 13px; color: rgba(255,255,255,0.8); line-height: 1.8;">
                            <div><strong>Bank:</strong> {{ $payment->bank_name ?? 'N/A' }}</div>
                            <div><strong>A/C No:</strong> {{ $payment->account_number ?? 'N/A' }}</div>
                            <div><strong>IFSC:</strong> {{ $payment->ifsc_code ?? 'N/A' }}</div>
                            <div><strong>Name:</strong> {{ $payment->account_name ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <!-- UPI Details -->
                    <div class="pm-box"
                        style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 15px;">
                        <div
                            style="font-weight: 700; color: #D4AF37; margin-bottom: 10px; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-mobile-alt"></i> UPI / Mobile Pay
                        </div>
                        <div style="font-size: 13px; color: rgba(255,255,255,0.8); line-height: 1.8;">
                            <div style="margin-bottom: 10px;">
                                <strong>{{ $payment->gpay_label ?? 'Google Pay' }}:</strong><br>
                                {{ $payment->gpay_number ?? 'N/A' }}
                                @if(!empty($payment->gpay_qr_code))
                                    <div style="margin-top: 5px;">
                                        <img src="{{ env('MAIN_URL') . $payment->gpay_qr_code }}"
                                            style="width: 80px; height: 80px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.1);"
                                            alt="GPay QR">
                                    </div>
                                @endif
                            </div>
                            <div>
                                <strong>{{ $payment->phonepe_label ?? 'PhonePe' }}:</strong><br>
                                {{ $payment->phonepe_number ?? 'N/A' }}
                                @if(!empty($payment->phonepe_qr_code))
                                    <div style="margin-top: 5px;">
                                        <img src="{{ env('MAIN_URL') . $payment->phonepe_qr_code }}"
                                            style="width: 80px; height: 80px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.1);"
                                            alt="PhonePe QR">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if(!empty($payment->additional_notes))
                    <div
                        style="padding: 15px; border-top: 1px dashed rgba(255,255,255,0.1); font-size: 12px; font-style: italic; color: rgba(212, 175, 55, 0.6);">
                        <strong>Notes:</strong> {{ strip_tags($payment->additional_notes) }}
                    </div>
                @endif
            </div>

            <!-- ── ACTION BUTTONS ── -->
            <div class="success-actions">
                <a href="/" class="btn-home">
                    <i class="fa-solid fa-house"></i>
                    <span>Go Home</span>
                </a>
                <button onclick="downloadOrderPDF()" class="btn-pdf">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span>Download PDF</span>
                </button>
                <a href="{{ url('/bank') }}" class="btn-payment">
                    <i class="fa-solid fa-credit-card"></i>
                    <span>Proceed to Payment</span>
                </a>
            </div>

        </div>
    </div>

    <!-- Hidden data for JS -->
    <script>
        const ORDER_DATA = {
            orderId: "{{ $order_id }}",
            actualTotal: {{ $actualTotal }},
            netTotal: {{ $netTotal }},
            savings: {{ $actualTotal - $netTotal }},
            items: @json($cartItems),
            payment: {
                bank_name: "{{ $payment->bank_name ?? '' }}",
                account_number: "{{ $payment->account_number ?? '' }}",
                ifsc_code: "{{ $payment->ifsc_code ?? '' }}",
                account_name: "{{ $payment->account_name ?? '' }}",
                gpay_label: "{{ $payment->gpay_label ?? 'Google Pay' }}",
                gpay_number: "{{ $payment->gpay_number ?? '' }}",
                gpay_qr: "{{ $gpay_qr }}", // Pre-encoded Base64 from Backend
                phonepe_label: "{{ $payment->phonepe_label ?? 'PhonePe' }}",
                phonepe_number: "{{ $payment->phonepe_number ?? '' }}",
                phonepe_qr: "{{ $phonepe_qr }}" // Pre-encoded Base64 from Backend
            }
        };
    </script>

    <!-- Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>

        async function downloadOrderPDF() {
            const btn = document.querySelector('.btn-pdf');
            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Generating...</span>'; }

            try {
                const { jsPDF } = window.jspdf;
                const A4_W = 1000;   // Specified high-res width
                const A4_H = 848;    // Specified height per page/section

                // ── Build an off-screen HTML receipt ──────────────────────
                const now = new Date();

                // Build product rows HTML
                let rowsHtml = '';
                ORDER_DATA.items.forEach((item, i) => {
                    const bg = i % 2 === 0 ? '#ffffff' : '#fcfcfc';
                    const imgHtml = item.img
                        ? `<img src="${item.img}" style="width:50px;height:50px;object-fit:cover;border-radius:4px;border:1px solid #eee;margin-right:15px;vertical-align:middle;">`
                        : '';

                    rowsHtml += `
                                <tr style="background:${bg};">
                                    <td style="padding:15px 20px;border:1px solid #eee;font-size:14px;width:45%;color:#111;display:flex;align-items:center;">
                                        ${imgHtml}
                                        <span style="font-weight:600;">${item.product_name}</span>
                                    </td>
                                    <td style="padding:15px 20px;border:1px solid #eee;font-size:14px;text-align:center;width:20%;color:#444;">Rs.${parseFloat(item.price).toFixed(2)}</td>
                                    <td style="padding:15px 20px;border:1px solid #eee;font-size:14px;text-align:center;width:15%;color:#444;"><span style="background:#eee;padding:2px 10px;border-radius:12px;font-weight:700;">x${item.qty}</span></td>
                                    <td style="padding:15px 20px;border:1px solid #eee;font-size:15px;text-align:right;font-weight:800;width:20%;color:#111;">Rs.${parseFloat(item.total).toFixed(2)}</td>
                                </tr>`;
                });

                // Build payment QR images
                const gpayQrImg = ORDER_DATA.payment.gpay_qr
                    ? `<div style="text-align:center;"><img src="${ORDER_DATA.payment.gpay_qr}" style="width:90px;height:90px;border-radius:8px;border:1px solid #eee;padding:5px;background:#fff;"><div style="font-size:10px;font-weight:700;color:#555;margin-top:5px;">GPay Scan</div></div>` : '';
                const phonepeQrImg = ORDER_DATA.payment.phonepe_qr
                    ? `<div style="text-align:center;"><img src="${ORDER_DATA.payment.phonepe_qr}" style="width:90px;height:90px;border-radius:8px;border:1px solid #eee;padding:5px;background:#fff;"><div style="font-size:10px;font-weight:700;color:#555;margin-top:5px;">PhonePe Scan</div></div>` : '';

                const savingsRow = ORDER_DATA.savings > 0
                    ? `<tr><td style="padding:10px 20px;color:#555;font-size:14px;">Total Savings</td><td style="padding:10px 20px;text-align:right;color:#1a7a2e;font-weight:700;font-size:16px;">- Rs.${ORDER_DATA.savings.toFixed(2)}</td></tr>` : '';

                const receiptHtml = `
                        <div id="pdf-receipt" style="
                            width: 1000px !important;
                            min-height: 848px !important;
                            background:#ffffff !important;
                            font-family: 'Segoe UI', Arial, sans-serif;
                            color:#222 !important;
                            box-sizing:border-box !important;
                            padding:50px 70px !important;
                            margin:0 !important;
                            border: 1px solid #f0f0f0;
                        ">
                            <!-- ENTERPRISE HEADER -->
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:40px; border-bottom:4px solid #111; padding-bottom:25px;">
                                <div style="display:flex; align-items:center; gap:20px;">
                                    <img src="{{ env('MAIN_URL', '/') . $global_settings->logo }}" style="height:80px; object-fit:contain;" alt="Logo">
                                    <div style="height:60px; width:2px; background:#eee; margin:0 10px;"></div>
                                    <div style="text-align:left;">
                                        <div style="font-size:36px; font-weight:900; letter-spacing:1px; color:#111; margin-bottom:5px;">bluvel Crackers</div>
                                        <div style="font-size:12px; color:#666; letter-spacing:3px; text-transform:uppercase; font-weight:600;">Premier Fireworks Manufacturer</div>
                                    </div>
                                </div>
                                <div style="text-align:right; background:#f9f9f9; padding:15px 25px; border-radius:8px; border:1px solid #eee;">
                                    <div style="font-size:11px; color:#888; font-weight:700; margin-bottom:4px;">CONFIRMATION RECEIPT</div>
                                    <div style="font-size:18px; font-weight:800; color:#D4AF37;">#${ORDER_DATA.orderId}</div>
                                </div>
                            </div>

                            <!-- INFO STRIP -->
                            <div style="display:flex; justify-content:space-between; margin-bottom:35px; font-size:13px; color:#444; padding:0 5px;">
                                <div>📅 <strong>Order Date:</strong> ${now.toLocaleDateString('en-IN')}</div>
                                <div>🕒 <strong>Order Time:</strong> ${now.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit' })}</div>
                                <div>✅ <strong>Status:</strong> <span style="color:#1a7a2e; font-weight:700;">PENDING CONFIRMATION</span></div>
                            </div>

                            <!-- ITEMS SECTION -->
                            <div style="margin-bottom:40px;">
                                <div style="background:#111; color:#fff; padding:12px 20px; font-size:14px; font-weight:700; border-radius:6px 6px 0 0; letter-spacing:1px;">ORDERED PRODUCTS</div>
                                <table style="width:100% !important; border-collapse:collapse !important; table-layout:fixed !important;">
                                    <thead>
                                        <tr style="background:#f0f0f0; color:#444;">
                                            <th style="padding:15px 20px; text-align:left; font-size:11px; font-weight:800; border:1px solid #ddd; width:45%;">DESCRIPTION</th>
                                            <th style="padding:15px 20px; text-align:center; font-size:11px; font-weight:800; border:1px solid #ddd; width:20%;">UNIT RATE</th>
                                            <th style="padding:15px 20px; text-align:center; font-size:11px; font-weight:800; border:1px solid #ddd; width:15%;">QTY</th>
                                            <th style="padding:15px 20px; text-align:right; font-size:11px; font-weight:800; border:1px solid #ddd; width:20%;">SUBTOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>${rowsHtml}</tbody>
                                </table>
                            </div>

                            <!-- LOWER GRID: PAYMENT + TOTALS -->
                            <div style="display:grid; grid-template-columns: 1.1fr 0.9fr; gap:30px; margin-bottom:40px;">

                                <!-- Payment Methods (Fixed Height) -->
                                <div style="border:1px solid #eee; border-radius:12px; padding:25px; background:#fafafa; display:flex; flex-direction:column; min-height:220px;">
                                    <div style="font-size:14px; font-weight:800; color:#111; margin-bottom:15px; border-bottom:2px solid #D4AF37; padding-bottom:5px; align-self:start;">BANKING & UPI TRANSFERS</div>
                                    <div style="display:flex; gap:25px; flex:1;">
                                        <div style="flex:1;">
                                            <div style="font-size:14px; font-weight:700; color:#333; margin-bottom:4px;">${ORDER_DATA.payment.account_name}</div>
                                            <div style="font-size:13px; color:#555; line-height:1.7;">
                                                <strong>Bank:</strong> ${ORDER_DATA.payment.bank_name}<br>
                                                <strong>Account:</strong> ${ORDER_DATA.payment.account_number}<br>
                                                <strong>IFSC:</strong> ${ORDER_DATA.payment.ifsc_code}
                                            </div>
                                        </div>
                                        <div style="display:flex; gap:12px;">
                                            ${ORDER_DATA.payment.gpay_qr ? `<div style="text-align:center;"><img src="${ORDER_DATA.payment.gpay_qr}" style="width:75px;height:75px;border:1px solid #eee;padding:4px;background:#fff;border-radius:4px;"><div style="font-size:9px;font-weight:700;margin-top:4px;">GPay</div></div>` : ''}
                                            ${ORDER_DATA.payment.phonepe_qr ? `<div style="text-align:center;"><img src="${ORDER_DATA.payment.phonepe_qr}" style="width:75px;height:75px;border:1px solid #eee;padding:4px;background:#fff;border-radius:4px;"><div style="font-size:9px;font-weight:700;margin-top:4px;">PhonePe</div></div>` : ''}
                                        </div>
                                    </div>
                                    <div style="margin-top:10px; font-size:10px; color:#999; font-style:italic;">* Share screenshot on WhatsApp with ID: #${ORDER_DATA.orderId}</div>
                                </div>

                                <!-- Calculation Summary (Matching Height) -->
                                <div style="background:#111; color:#fff; border-radius:12px; padding:30px; display:flex; flex-direction:column; justify-content:center; min-height:220px;">
                                    <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                                        <span style="color:#aaa; font-size:14px;">Gross Total (MRP)</span>
                                        <span style="font-weight:600; font-size:14px;">Rs.${ORDER_DATA.actualTotal.toFixed(2)}</span>
                                    </div>
                                    ${ORDER_DATA.savings > 0 ? `
                                    <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                                        <span style="color:#aaa; font-size:14px;">Total Savings</span>
                                        <span style="font-weight:700; font-size:14px; color:#1a7a2e;">- Rs.${ORDER_DATA.savings.toFixed(2)}</span>
                                    </div>` : ''}
                                    <div style="height:1px; background:rgba(255,255,255,0.1); margin:15px 0;"></div>
                                    <div style="display:flex; justify-content:space-between; align-items:center;">
                                        <span style="font-size:22px; font-weight:800; color:#D4AF37;">GRAND TOTAL</span>
                                        <span style="font-size:30px; font-weight:900; color:#D4AF37; letter-spacing:1px;">Rs.${ORDER_DATA.netTotal.toFixed(2)}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- FOOTER & SIGNATURE -->
                            <div style="display:flex; justify-content:space-between; align-items:flex-end; border-top:1px solid #eee; padding-top:40px;">
                                <div style="text-align:left; max-width:60%;">
                                    <div style="font-size:14px; font-weight:800; color:#111; margin-bottom:8px;">TERMS & CONDITIONS</div>
                                    <div style="font-size:11px; color:#888; line-height:1.6;">
                                        This is an order inquiry receipt. Our team will contact you for final stock confirmation and delivery scheduling. Prices are subject to stock availability at the time of order confirmation.
                                    </div>
                                    <div style="margin-top:20px; font-size:11px; color:#444; font-weight:700;">
                                        📍 Sivakasi, Tamil Nadu | 📞 Customer Service Active | 🌐 www.bluvelcrakers.in
                                    </div>
                                </div>
                                <div style="text-align:center; padding-bottom:10px;">
                                    <div style="width:200px; border-bottom:2px solid #111; margin-bottom:12px;"></div>
                                    <div style="font-size:11px; font-weight:700; color:#111; text-transform:uppercase; letter-spacing:1px;">Authorized Signatory</div>
                                    <div style="font-size:9px; color:#999; margin-top:4px;">bluvel Crackers, India</div>
                                </div>
                            </div>
                        </div>`;

                // ── Inject off-screen wrapper ──────────────────────────────
                const wrapper = document.createElement('div');
                wrapper.style.cssText = 'position:absolute;top:0;left:0;z-index:-9999;width:3000px;background:#fff;';
                wrapper.innerHTML = receiptHtml;
                document.body.prepend(wrapper);

                const fontLink = document.createElement('link');
                fontLink.rel = 'stylesheet';
                fontLink.href = 'https://fonts.googleapis.com/css2?family=Noto+Sans+Tamil&display=swap';
                document.head.appendChild(fontLink);

                await new Promise(r => setTimeout(r, 1200));

                // ── Capture with html2canvas ───────────────────────────────
                const receiptEl = wrapper.querySelector('#pdf-receipt');
                const canvas = await html2canvas(receiptEl, {
                    scale: 2,
                    useCORS: true,
                    allowTaint: false,
                    backgroundColor: '#ffffff',
                    width: A4_W,
                    height: Math.max(receiptEl.offsetHeight, A4_H),
                    windowWidth: 1400,
                    logging: false
                });

                document.body.removeChild(wrapper);

                // ── Build PDF ─────────────────────────────────────────────
                const imgData = canvas.toDataURL('image/jpeg', 0.95);
                const doc = new jsPDF({ unit: 'px', format: 'a4', hotfixes: ['px_scaling'] });
                const pdfW = doc.internal.pageSize.getWidth();
                const pdfH = doc.internal.pageSize.getHeight();
                const imgH = (canvas.height * pdfW) / canvas.width;

                let posY = 0;
                let remaining = imgH;

                while (remaining > 0) {
                    doc.addImage(imgData, 'JPEG', 0, posY, pdfW, imgH);
                    remaining -= pdfH;
                    if (remaining > 0) {
                        doc.addPage();
                        posY -= pdfH;
                    }
                }

                doc.save('Order_' + ORDER_DATA.orderId + '.pdf');

            } catch (err) {
                console.error('PDF generation failed:', err);
                alert('PDF generation failed. Please try again.');
            } finally {
                if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-file-pdf"></i> <span>Download PDF</span>'; }
            }
        }

    </script>

    <!-- Spark canvas script -->
    <script>
        (function () {
            const canvas = document.getElementById('successCanvas');
            const ctx = canvas.getContext('2d');

            function resize() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            resize();
            window.addEventListener('resize', resize);

            const sparks = [];

            function mk() {
                return {
                    x: Math.random() * canvas.width,
                    y: canvas.height + 10,
                    vx: (Math.random() - 0.5) * 1.8,
                    vy: -(Math.random() * 3 + 1.2),
                    life: 1,
                    decay: Math.random() * 0.012 + 0.006,
                    size: Math.random() * 3 + 1,
                    color: Math.random() > 0.5
                        ? `hsl(${0 + Math.random() * 10}, 100%, ${30 + Math.random() * 20}%)`
                        : `hsl(${45 + Math.random() * 15}, 80%, 50%)`
                };
            }

            function loop() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                if (Math.random() < 0.4) sparks.push(mk());
                if (sparks.length > 150) sparks.splice(0, 5);

                for (let i = sparks.length - 1; i >= 0; i--) {
                    const s = sparks[i];
                    s.x += s.vx;
                    s.y += s.vy;
                    s.vy += 0.05;
                    s.life -= s.decay;
                    if (s.life <= 0) { sparks.splice(i, 1); continue; }

                    ctx.save();
                    ctx.globalAlpha = s.life * 0.75;
                    ctx.beginPath();
                    ctx.arc(s.x, s.y, s.size * s.life, 0, Math.PI * 2);
                    ctx.fillStyle = s.color;
                    ctx.shadowBlur = 10;
                    ctx.shadowColor = s.color;
                    ctx.fill();
                    ctx.restore();
                }
                requestAnimationFrame(loop);
            }
            loop();
        })();
    </script>

@endsection