@extends('layouts.default')

@section('main-page')

    @push('styles')
        <style>
            .qty-wrapper {
                display: inline-flex;
                align-items: center;
                border: 1px solid rgba(255, 100, 0, 0.3);
                border-radius: 5px;
                overflow: hidden;
            }

            .qty-btn {
                background: #0A0000;
                color: #D4AF37;
                border: none;
                width: 32px;
                height: 32px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: 0.2s;
                font-size: 14px;
            }

            .qty-btn:hover {
                background: #8B0000;
                color: white;
            }

            .qty {
                width: 46px !important;
                text-align: center;
                border: none !important;
                border-left: 1px solid rgba(255, 100, 0, 0.3) !important;
                border-right: 1px solid rgba(255, 100, 0, 0.3) !important;
                background: transparent !important;
                color: white !important;
                height: 32px !important;
                font-weight: 600 !important;
                padding: 0 !important;
                border-radius: 0 !important;
            }

            .qty::-webkit-outer-spin-button,
            .qty::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type=number].qty {
                -moz-appearance: textfield;
            }

            .mobile-sticky-bar {
                display: none;
            }

            .video-icon {
                margin-left: 12px;
                vertical-align: middle;
                transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275), filter 0.2s ease;
                display: inline-block;
                width: 32px;
                height: 22px;
                background: #ff0000;
                border-radius: 6px;
                position: relative;
                box-shadow: 0 2px 8px rgba(255, 0, 0, 0.3);
            }

            .video-icon::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 55%;
                transform: translate(-50%, -50%);
                border-left: 7px solid #fff;
                border-top: 4.5px solid transparent;
                border-bottom: 4.5px solid transparent;
            }

            .video-icon.active:hover {
                transform: scale(1.2);
                filter: brightness(1.2);
                box-shadow: 0 4px 12px rgba(255, 0, 0, 0.5);
            }

            .video-icon.disabled {
                background: #333;
                box-shadow: none;
                opacity: 0.5;
                cursor: not-allowed;
                filter: grayscale(1);
            }

            .video-icon.disabled::after {
                border-left-color: #666;
            }

            @media (max-width: 767px) {

                .fab,
                .go-top {
                    bottom: 95px !important;
                }
            }

            /* ===== MOBILE RESPONSIVE (theboyscrackers style) ===== */
            @media (max-width: 767px) {
                .top-summary {
                    display: none !important;
                }

                .estimate-hero {
                    padding: 40px 20px;
                }

                .hero-title {
                    font-size: 28px;
                }

                .search-wrap {
                    margin: 15px;
                }

                .table-wrap {
                    padding: 0 10px 100px 10px;
                    background: transparent;
                    box-shadow: none;
                }

                .table-wrap table,
                .table-wrap thead,
                .table-wrap tbody,
                .table-wrap th,
                .table-wrap td,
                .table-wrap tr {
                    display: block;
                }

                .table-wrap thead tr {
                    position: absolute;
                    top: -9999px;
                    left: -9999px;
                }

                .product-row {
                    position: relative;
                    background: #0A0000;
                    border: 1px solid rgba(139, 0, 0, 0.15);
                    border-radius: 12px;
                    margin-bottom: 12px;
                    padding: 12px;
                    display: grid !important;
                    grid-template-columns: 90px 1fr;
                    grid-template-areas:
                        "img name"
                        "img content"
                        "img price"
                        "img video"
                        "img qty"
                        ". subtotal";
                    gap: 5px 15px;
                    align-items: center;
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
                }

                .product-row td {
                    padding: 0 !important;
                    border: none !important;
                    text-align: left !important;
                }

                .product-row td:nth-child(1) {
                    grid-area: img;
                }

                .product-row td:nth-child(2) {
                    grid-area: name;
                    font-weight: 700;
                    color: #D4AF37;
                    font-size: 14px;
                    margin-top: 2px;
                }

                .product-row td:nth-child(3) {
                    grid-area: video;
                    margin-top: 2px;
                }

                .product-row td:nth-child(4) {
                    grid-area: content;
                    font-size: 11px;
                    opacity: 0.6;
                    margin-top: -2px;
                }

                .product-row td:nth-child(5),
                .product-row td:nth-child(6) {
                    display: inline-block;
                    font-size: 13px;
                }

                .product-row td:nth-child(5) {
                    grid-area: price;
                    text-decoration: line-through;
                    opacity: 0.4;
                    margin-right: 8px;
                }

                .product-row td:nth-child(6) {
                    grid-area: price;
                    color: #D4AF37;
                    font-weight: 600;
                    margin-left: 55px;
                }

                /* Offset for actual price */
                .product-row td:nth-child(6)::before {
                    content: "₹";
                }

                .product-row td:nth-child(7) {
                    grid-area: qty;
                    margin-top: 5px;
                }

                .product-row td:nth-child(8) {
                    grid-area: subtotal;
                    text-align: right !important;
                    font-size: 12px;
                    color: #fff;
                    background: rgba(255, 255, 255, 0.05);
                    padding: 4px 10px !important;
                    border-radius: 6px;
                    display: inline-block;
                    justify-self: end;
                }

                .product-row td:nth-child(8)::before {
                    content: "Item Total: ₹";
                }

                .product-row td:nth-child(1) img {
                    width: 90px;
                    height: 90px;
                    object-fit: cover;
                    border-radius: 10px;
                    border: 1px solid rgba(255, 255, 255, 0.1);
                }

                .category td {
                    background: linear-gradient(90deg, #0A0000, #4B0000);
                    color: #D4AF37;
                    padding: 12px !important;
                    border-radius: 8px;
                    font-weight: 800;
                    font-size: 13px;
                    letter-spacing: 1px;
                    margin: 25px 0 10px 0;
                    border: 1px solid rgba(212, 175, 55, 0.3) !important;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
                }

                /* Bottom Pill Summary */
                .mobile-sticky-bar {
                    position: fixed;
                    bottom: 25px;
                    left: 50%;
                    transform: translateX(-50%);
                    width: 92%;
                    background: linear-gradient(135deg, #8B0000, #5B0000);
                    height: 60px;
                    border-radius: 40px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 0 20px;
                    z-index: 1001;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6), 0 0 20px rgba(139, 0, 0, 0.3);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                }

                .msb-left {
                    display: flex;
                    align-items: center;
                    gap: 15px;
                    color: #fff;
                }

                .msb-cart-icon {
                    font-size: 20px;
                    position: relative;
                }

                .msb-count {
                    position: absolute;
                    top: -8px;
                    right: -10px;
                    background: #fff;
                    color: #8B0000;
                    width: 18px;
                    height: 18px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 10px;
                    font-weight: 900;
                }

                .msb-info {
                    display: flex;
                    flex-direction: column;
                    line-height: 1.2;
                }

                .msb-label {
                    font-size: 10px;
                    opacity: 0.8;
                    font-weight: 600;
                    text-transform: uppercase;
                }

                .msb-total {
                    font-size: 18px;
                    font-weight: 800;
                }

                .msb-btn {
                    background: #fff;
                    color: #8B0000;
                    padding: 8px 18px;
                    border-radius: 30px;
                    font-weight: 800;
                    font-size: 13px;
                    text-transform: uppercase;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                }
            }
        </style>
    @endpush

    {{-- ── Fetch minimum order amount ── --}}
    @php
        $priceList = \App\Models\PriceList::first();
        $minOrder = $priceList ? (float) $priceList->price_data : 0;
    @endphp

    <!-- ===== PAGE ===== -->
    <div class="estimate-page">

        <!-- ===== FIXED TOP SUMMARY ===== -->
        <div class="top-summary">

            <div class="summary-item">
                <div class="summary-icon"><i class="fa-solid fa-receipt"></i></div>
                <div>
                    <span class="summary-label">Total</span>
                    <span class="summary-value notranslate">₹<span id="netTotal">0</span></span>
                </div>
            </div>

            <div class="summary-divider"></div>

            <div class="summary-item">
                <div class="summary-icon"><i class="fa-solid fa-tag"></i></div>
                <div>
                    <span class="summary-label">You Save</span>
                    <span class="summary-value">₹<span id="youSave">0</span></span>
                </div>
            </div>

            <div class="summary-divider"></div>

            <div class="summary-item">
                <div class="summary-icon"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                <div>
                    <span class="summary-label">Overall Total</span>
                    <span class="summary-value">₹<span id="overallTotal">0</span></span>
                </div>
            </div>

            <div class="summary-divider"></div>

            <div class="cart-badge-wrap" onclick="openCart()">
                <i class="fa-solid fa-cart-shopping"></i>
                <div class="cart-count" id="cartCount">0</div>
            </div>

        </div>

        <!-- ===== HERO BANNER ===== -->
        <div class="estimate-hero">
            <div class="hero-ornament tl"></div>
            <div class="hero-ornament tr"></div>
            <div class="hero-ornament bl"></div>
            <div class="hero-ornament br"></div>

            <!-- <div class="hero-eyebrow">Sivakasi · Est. 2026</div> -->
            <h1 class="hero-title">Price Estimate</h1>
            <p class="hero-sub">Select your crackers &amp; calculate your order instantly</p>
        </div>

        <!-- ===== MAIN CONTENT ===== -->
        <div class="estimate-content">

            <div class="gold-fire-edge"></div>

            <!-- Search -->
            <div class="search-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Search for a product…">
            </div>

            <!-- Table -->
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-image"></i></th>
                            <th>Product Name</th>
                            <th><i class="fa-solid fa-play"></i> Video</th>
                            <th>Content</th>
                            <th>Actual Price</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody id="productTable">
                        @foreach($categories as $category)
                            @if($category->products->count() > 0)
                                <tr class="category">
                                    <td colspan="8"><i class="fa-solid fa-box-open"></i> {{ strtoupper($category->category_name) }}
                                    </td>
                                </tr>

                                @foreach($category->products as $product)
                                    <tr class="product-row" data-product-id="{{ $product->id }}">
                                        <td>
                                            <img src="{{ $product->product_image ? env('MAIN_URL') . $product->product_image : 'https://via.placeholder.com/100' }}"
                                                alt="{{ $product->product_name }}" loading="lazy">
                                        </td>
                                        <td class="product-name">
                                            {{ $product->product_name }}
                                        </td>
                                        <td>
                                            @if($product->product_video)
                                                <a href="{{ $product->product_video }}" target="_blank" class="video-icon active"
                                                    title="Watch Product Video"></a>
                                            @else
                                                <span class="video-icon disabled" title="No Video Available"></span>
                                            @endif
                                        </td>
                                        <td>{{ $product->product_content }}</td>
                                        <td class="actual notranslate">{{ $product->product_mrp_price }}</td>
                                        <td class="price notranslate">{{ $product->product_regular_price }}</td>
                                        <td>
                                            <div class="qty-wrapper">
                                                <button type="button" class="qty-minus qty-btn"><i
                                                        class="fa-solid fa-minus"></i></button>
                                                <input type="number" class="qty" value="0" min="0" max="999">
                                                <button type="button" class="qty-plus qty-btn"><i class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </td>
                                        <td class="rowTotal">0</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bottom-actions"></div>

        </div>

        <!-- Ember container -->
        <div id="emberContainerEst" style="position:fixed;inset:0;pointer-events:none;z-index:0;overflow:hidden;"></div>

        <!-- ===== CART OVERLAY ===== -->
        <div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>

        <!-- ===== CART DRAWER ===== -->
        <div class="cart-drawer" id="cartDrawer">

            <div class="cart-drawer-header">
                <div class="cart-drawer-title">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Order Estimate
                </div>
                <button class="cart-close-btn" onclick="closeCart()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="cart-drawer-body" id="cartDrawerBody"></div>

            <div class="cart-drawer-footer">
                <div class="cart-fire-edge"></div>

                {{-- ── MINIMUM ORDER WIDGET (only shown if min order is set) ── --}}
                @if($minOrder > 0)
                    <div class="min-order-wrap" id="minOrderWrap">
                        <div class="min-order-top">
                            <span class="min-order-label">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                Minimum Order
                            </span>
                            <span class="min-order-value">₹{{ number_format($minOrder, 0) }}</span>
                        </div>
                        <div class="min-order-bar-track">
                            <div class="min-order-bar-fill" id="minOrderBar" style="width:0%"></div>
                        </div>
                        <div class="min-order-status" id="minOrderStatus">
                            Add ₹{{ number_format($minOrder, 0) }} more to place an order
                        </div>
                    </div>
                @endif

                <div class="cart-summary-rows">
                    <div class="cart-summary-row">
                        <span class="label">Actual Total</span>
                        <span class="val">₹<span id="cartActual">0</span></span>
                    </div>
                    <div class="cart-summary-row savings">
                        <span class="label">You Save</span>
                        <span class="val">₹<span id="cartSave">0</span></span>
                    </div>
                    <div class="cart-summary-row discount">
                        <span class="label">Discount</span>
                        <span class="val"><span id="cartDiscount">0</span>%</span>
                    </div>
                    <div class="cart-summary-row total">
                        <span class="label">Total</span>
                        <span class="val">₹<span id="cartNet">0</span></span>
                    </div>
                </div>
                <div class="cart-action-btns">
                    <button class="btn-gold" id="confirmOrderBtn" onclick="closeCart(); checkOrder();">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Confirm Order</span>
                    </button>
                    <button class="btn-continue" id="continueShopBtn" onclick="closeCart()" style="display:none;">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Continue Shopping</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- ===== MOBILE STICKY BAR (Visible only on mobile) ===== -->
        <a href="javascript:void(0)" class="mobile-sticky-bar" onclick="openCart()">
            <div class="msb-left">
                <div class="msb-cart-icon">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <div class="msb-count" id="msbCount">0</div>
                </div>
                <div class="msb-info">
                    <span class="msb-label">Total Amount</span>
                    <span class="msb-total">₹<span id="msbTotal">0</span></span>
                </div>
            </div>
            <div class="msb-btn">View Cart</div>
        </a>

    </div>


    <div id="orderModal" class="order-modal-overlay">
        <div class="order-modal-box">

            <button onclick="closeOrderModal()" class="order-modal-close notranslate">&#x2715;</button>

            <div class="order-modal-header">
                <div class="order-modal-eyebrow">🎆 Bluvel Crackers</div>
                <h2 class="order-modal-title">Confirm Your Order</h2>
                <div class="order-modal-bar"></div>
            </div>

            <div class="order-net-strip">
                <span class="order-net-label">Total</span>
                <span class="order-net-value">₹<span id="modalNetTotal">0</span></span>
            </div>

            <form id="orderForm">
                @csrf
                <input type="hidden" id="cartDataInput" name="cart_data">
                <input type="hidden" id="subTotalInput" name="sub_total">
                <input type="hidden" id="totalInput" name="total">

                <div class="order-form-grid-2">
                    <div class="order-field">
                        <label class="order-label">NAME *</label>
                        <input type="text" name="name" id="orderName" required placeholder="Enter Full Name"
                            class="order-input">
                    </div>
                    <div class="order-field">
                        <label class="order-label">PHONE (Old User Enter Number)</label>
                        <input type="tel" name="phone_number" id="orderPhone" required placeholder="Enter Mobile number"
                            onblur="lookupCustomer(this.value)" class="order-input">
                    </div>
                </div>

                <div class="order-field">
                    <label class="order-label">EMAIL *</label>
                    <input type="email" name="email" id="orderEmail" required placeholder="Enter Email" class="order-input">
                </div>

                <div class="order-field">
                    <label class="order-label">ADDRESS *</label>
                    <textarea name="address" id="orderAddress" required rows="2" placeholder="Enter your Address"
                        class="order-input order-textarea"></textarea>
                </div>

                <div class="order-form-grid-2">
                    <div class="order-field">
                        <label class="order-label">STATE *</label>
                        <select name="state" id="stateSelect" required data-display="5" onchange="loadCities(this.value)"
                            class="order-input order-select">
                            <option value="">-- Select State --</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->state }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="order-field">
                        <label class="order-label">CITY *</label>
                        <select name="city" id="citySelect" required data-display="5" onchange="loadAreas(this.value)"
                            class="order-input order-select">
                            <option value="">-- Select State First --</option>
                        </select>
                    </div>
                </div>

                <div class="order-form-grid-2 order-form-last">
                    <div class="order-field">
                        <label class="order-label">AREA</label>
                        <select name="area" id="areaSelect" data-display="5" class="order-input order-select">
                            <option value="">-- Select City First --</option>
                        </select>
                    </div>
                    <div class="order-field">
                        <label class="order-label">PINCODE</label>
                        <input type="text" name="pincode" id="orderPincode" placeholder="Enter Your Pincode"
                            class="order-input">
                    </div>
                </div>

                <button type="button" onclick="placeOrder()" id="placeOrderBtn" class="order-submit-btn">
                    <i class="fa-solid fa-circle-check"></i> Place Order
                </button>
            </form>
        </div>
    </div>



    @push('scripts')
        <script>
            /* Pass PHP value to JS */
            const MIN_ORDER = {{ $minOrder }};

            document.addEventListener("DOMContentLoaded", function () {

                document.querySelectorAll(".qty").forEach(input => {
                    input.addEventListener("input", function () {
                        let value = parseInt(this.value) || 0;
                        if (value > 999) value = 999;
                        if (value < 0) value = 0;
                        this.value = value;
                        calculate();
                    });
                });

                document.querySelectorAll('.qty-minus').forEach(btn => {
                    btn.addEventListener('click', function () {
                        let input = this.nextElementSibling;
                        let val = parseInt(input.value) || 0;
                        if (val > 0) {
                            input.value = val - 1;
                            input.dispatchEvent(new Event('input'));
                        }
                    });
                });

                document.querySelectorAll('.qty-plus').forEach(btn => {
                    btn.addEventListener('click', function () {
                        let input = this.previousElementSibling;
                        let val = parseInt(input.value) || 0;
                        if (val < 999) {
                            input.value = val + 1;
                            input.dispatchEvent(new Event('input'));
                        }
                    });
                });

                document.getElementById("searchInput").addEventListener("keyup", function () {
                    const value = this.value.toLowerCase();
                    document.querySelectorAll(".product-row").forEach(row => {
                        const name = row.querySelector(".product-name").innerText.toLowerCase();
                        row.style.display = name.includes(value) ? "" : "none";
                    });
                });

                /* Ember particles */
                const container = document.getElementById("emberContainerEst");
                function spawnEmber() {
                    const el = document.createElement("div");
                    el.className = "ember-particle";
                    const x = Math.random() * 100;
                    const dur = 4 + Math.random() * 5;
                    const delay = Math.random() * 6;
                    const size = 2 + Math.random() * 3;
                    const colors = ["#8B0000", "#D4AF37", "#610000", "#B8860B", "#ffd700"];
                    const color = colors[Math.floor(Math.random() * colors.length)];
                    el.style.cssText = `left:${x}%;bottom:${Math.random() * 20}%;width:${size}px;height:${size}px;background:${color};box-shadow:0 0 5px ${color};animation-duration:${dur}s;animation-delay:${delay}s;`;
                    container.appendChild(el);
                    setTimeout(() => el.remove(), (dur + delay) * 1000);
                }
                setInterval(spawnEmber, 700);
            });

            /* --- Calculate totals --- */
            function calculate() {
                let netTotal = 0, actualTotal = 0, cartCount = 0;

                document.querySelectorAll(".product-row").forEach(row => {
                    const qty = parseInt(row.querySelector(".qty").value) || 0;
                    const price = parseFloat(row.querySelector(".price").innerText.replace('₹', '')) || 0;
                    const actualTd = row.querySelector(".actual");
                    const actual = actualTd ? parseFloat(actualTd.innerText) || 0 : 0;
                    const rowTotal = qty * price;
                    const actualRow = qty * actual;

                    row.querySelector(".rowTotal").innerText = rowTotal.toFixed(2);
                    netTotal += rowTotal;
                    actualTotal += actualRow;
                    if (qty > 0) cartCount++;
                });

                document.getElementById("netTotal").innerText = netTotal.toFixed(2);
                document.getElementById("overallTotal").innerText = netTotal.toFixed(2);
                document.getElementById("youSave").innerText = (actualTotal - netTotal).toFixed(2);
                document.getElementById("cartCount").innerText = cartCount;

                /* Update Mobile Sticky Bar */
                const msbTotal = document.getElementById("msbTotal");
                const msbCount = document.getElementById("msbCount");
                if (msbTotal) msbTotal.innerText = netTotal.toFixed(2);
                if (msbCount) msbCount.innerText = cartCount;
            }

            function updateMinOrderWidget(netTotal) {
                if (MIN_ORDER <= 0) return;

                const wrap = document.getElementById('minOrderWrap');
                const bar = document.getElementById('minOrderBar');
                const status = document.getElementById('minOrderStatus');
                const confirmBtn = document.getElementById('confirmOrderBtn');
                const continueBtn = document.getElementById('continueShopBtn');
                if (!wrap) return;

                const pct = Math.min((netTotal / MIN_ORDER) * 100, 100);
                const met = netTotal >= MIN_ORDER;
                const diff = (MIN_ORDER - netTotal).toLocaleString('en-IN', { maximumFractionDigits: 2 });

                bar.style.width = pct + '%';
                wrap.classList.toggle('met', met);
                confirmBtn.classList.toggle('min-not-met', !met);

                /* Show/hide Continue Shopping button */
                if (continueBtn) {
                    continueBtn.style.display = (!met && netTotal > 0) ? 'flex' : 'none';
                }

                if (met) {
                    status.innerHTML = '✅ Minimum order met! You\'re good to go.';
                } else if (netTotal === 0) {
                    status.innerHTML = `Add ₹${MIN_ORDER.toLocaleString('en-IN')} to place an order`;
                } else {
                    status.innerHTML = `₹${diff} more needed to place an order`;
                }
            }

            /* --- Check order --- */
            function checkOrder() {
                let cartData = [], netTotal = 0, actualTotal = 0;

                document.querySelectorAll('.product-row').forEach(row => {
                    const qty = parseInt(row.querySelector('.qty').value) || 0;
                    if (qty === 0) return;

                    const productId = row.dataset.productId;
                    const name = row.querySelector('.product-name').innerText;
                    const price = parseFloat(row.querySelector('.price').innerText.replace('₹', '')) || 0;
                    const actualTd = row.querySelector('.actual');
                    const actual = actualTd ? parseFloat(actualTd.innerText) || 0 : 0;
                    const imgSrc = row.querySelector('img')?.src || '';
                    const rowTotal = qty * price;
                    const actualRow = qty * actual;

                    netTotal += rowTotal;
                    actualTotal += actualRow;

                    cartData.push({
                        product_id: productId,
                        product_name: name,
                        qty: qty,
                        price: price,
                        actual: actual,
                        total: rowTotal,
                        img: imgSrc
                    });
                });

                if (cartData.length === 0) {
                    alert('Please add at least one item to your order.');
                    return;
                }

                /* Block if minimum not met (safety net for direct calls) */
                if (MIN_ORDER > 0 && netTotal < MIN_ORDER) {
                    const diff = (MIN_ORDER - netTotal).toLocaleString('en-IN', { maximumFractionDigits: 2 });
                    alert(`Minimum order is ₹${MIN_ORDER.toLocaleString('en-IN')}.\nAdd ₹${diff} more to proceed.`);
                    return;
                }

                document.getElementById('cartDataInput').value = JSON.stringify(cartData);
                document.getElementById('subTotalInput').value = netTotal.toFixed(2);
                document.getElementById('totalInput').value = netTotal.toFixed(2);
                document.getElementById('modalNetTotal').innerText = netTotal.toFixed(2);

                document.getElementById('orderModal').style.display = 'block';
                document.body.style.overflow = 'hidden';
            }

            function closeOrderModal() {
                document.getElementById('orderModal').style.display = 'none';
                document.body.style.overflow = '';
            }

            async function placeOrder() {
                const btn = document.getElementById('placeOrderBtn');
                const form = document.getElementById('orderForm');

                // Clear all previous errors
                document.querySelectorAll('.order-field-error').forEach(el => el.remove());
                document.querySelectorAll('.order-input.input-error').forEach(el => el.classList.remove('input-error'));

                const requiredFields = [
                    { id: 'orderName', label: 'Name' },
                    { id: 'orderPhone', label: 'Phone' },
                    { id: 'orderEmail', label: 'Email' },
                    { id: 'orderAddress', label: 'Address' },
                    { id: 'stateSelect', label: 'State' },
                    { id: 'citySelect', label: 'City' },
                ];

                let hasError = false;

                requiredFields.forEach(({ id, label }) => {
                    const input = document.getElementById(id);
                    if (!input.value.trim()) {
                        showFieldError(input, `${label} is required`);
                        hasError = true;
                    }
                });

                if (hasError) return;

                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Placing Order...';

                const formData = new FormData(form);

                try {
                    const response = await fetch('{{ route("order.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message || 'Something went wrong. Please try again.');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa-solid fa-circle-check"></i> Place Order';
                    }
                } catch (err) {
                    alert('Network error. Please check your connection and try again.');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-circle-check"></i> Place Order';
                }
            }

            function showFieldError(input, message) {
                input.classList.add('input-error');

                const msg = document.createElement('span');
                msg.className = 'order-field-error';
                msg.textContent = message;
                input.closest('.order-field').appendChild(msg);

                // Clear error on change/input
                const clearError = () => {
                    input.classList.remove('input-error');
                    msg.remove();
                    input.removeEventListener('input', clearError);
                    input.removeEventListener('change', clearError);
                };
                input.addEventListener('input', clearError);
                input.addEventListener('change', clearError); // for selects
            }

            /* --- Reset --- */
            function resetOrder() {
                if (!confirm("Reset all quantities?")) return;
                document.querySelectorAll(".qty").forEach(i => { i.value = 0; });
                document.querySelectorAll(".rowTotal").forEach(c => { c.innerText = "0"; });
                ["netTotal", "youSave", "overallTotal", "cartCount"].forEach(id => {
                    document.getElementById(id).innerText = "0";
                });
            }

            /* --- Fix summary top on scroll --- */
            function fixSummaryTop() {
                const summary = document.querySelector('.top-summary');
                const stickyHeader = document.getElementById('fireStickyHeader');
                const offerBar = document.querySelector('.top-offer-bar');
                const navbar = document.querySelector('.navbar-area');
                const fireEdge = document.querySelector('.fire-edge');
                const THRESHOLD = 120;

                if (window.scrollY > THRESHOLD) {
                    summary.style.top = stickyHeader.offsetHeight + 'px';
                } else {
                    const totalHeight = (offerBar?.offsetHeight || 0)
                        + (navbar?.offsetHeight || 0)
                        + (fireEdge?.offsetHeight || 0);
                    summary.style.top = totalHeight + 'px';
                }
            }

            fixSummaryTop();
            window.addEventListener('scroll', fixSummaryTop, { passive: true });
            window.addEventListener('resize', fixSummaryTop);



            function closeCart() {
                document.getElementById('cartDrawer').classList.remove('open');
                document.getElementById('cartOverlay').classList.remove('open');
                document.body.style.overflow = '';
            }

            function renderCartDrawer() {
                const body = document.getElementById('cartDrawerBody');
                let items = [], netTotal = 0, actualTotal = 0;

                document.querySelectorAll('.product-row').forEach(row => {
                    const qty = parseInt(row.querySelector('.qty').value) || 0;
                    if (qty === 0) return;

                    const name = row.querySelector('.product-name').innerText;
                    const price = parseFloat(row.querySelector('.price').innerText.replace('₹', '')) || 0;
                    const actual = parseFloat(row.querySelector('.actual').innerText) || 0;
                    const imgSrc = row.querySelector('img')?.src || '';
                    const rowTotal = qty * price;
                    const rowActual = qty * actual;

                    netTotal += rowTotal;
                    actualTotal += rowActual;
                    items.push({ name, price, actual, qty, rowTotal, rowActual, imgSrc });
                });

                if (items.length === 0) {
                    body.innerHTML = `
                                    <div class="cart-empty">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        <p>No items added yet.</p>
                                        <button class="btn-gold" onclick="closeCart()" style="margin-top:16px; padding:12px 24px; font-size:10px;">
                                            <i class="fa-solid fa-arrow-left"></i>
                                            <span>Continue Shopping</span>
                                        </button>
                                    </div>`;
                    document.getElementById('cartActual').innerText = '0';
                    document.getElementById('cartSave').innerText = '0';
                    document.getElementById('cartNet').innerText = '0';
                    updateMinOrderWidget(0);
                    return;
                }

                body.innerHTML = items.map((item, index) => `
                                <div class="cart-item" id="cart-item-${index}">
                                    <img class="cart-item-img" src="${item.imgSrc}" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                    <div class="cart-item-icon" style="display:none">🎆</div>
                                    <div class="cart-item-info">
                                        <div class="cart-item-name">${item.name}</div>
                                        <div class="cart-item-meta">₹${item.price} × ${item.qty}</div>
                                    </div>
                                    <div class="cart-item-total">₹${item.rowTotal.toFixed(2)}</div>
                                    <button class="cart-item-remove" onclick="removeCartItem('${item.name}')" title="Remove">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                            `).join('');

                const savings = actualTotal - netTotal;
                const discount = actualTotal > 0 ? (savings / actualTotal) * 100 : 0;
                document.getElementById('cartActual').innerText = actualTotal.toFixed(2);
                document.getElementById('cartSave').innerText = savings.toFixed(2);
                document.getElementById('cartDiscount').innerText = discount.toFixed(2);
                document.getElementById('cartNet').innerText = netTotal.toFixed(2);

                /* ── Update min order widget every time cart renders ── */
                updateMinOrderWidget(netTotal);
            }

            function removeCartItem(name) {
                document.querySelectorAll('.product-row').forEach(row => {
                    if (row.querySelector('.product-name').innerText === name) {
                        row.querySelector('.qty').value = 0;
                        row.querySelector('.rowTotal').innerText = '0';
                    }
                });
                calculate();
                renderCartDrawer();
            }


            /* ─── openCart fix (items was referenced before being defined) ─── */
            function openCart() {
                renderCartDrawer();
                document.getElementById('cartDrawer').classList.add('open');
                document.getElementById('cartOverlay').classList.add('open');
                document.body.style.overflow = 'hidden';
            }





            const ALL_CITIES = @json($cities);
            const ALL_AREAS = @json($areas);

            function loadCities(stateId) {
                const citySelect = document.getElementById('citySelect');
                const areaSelect = document.getElementById('areaSelect');

                areaSelect.innerHTML = '<option value="" style="background:#1a0a00;">-- Select City First --</option>';

                if (!stateId) {
                    citySelect.innerHTML = '<option value="" style="background:#1a0a00;">-- Select State First --</option>';
                    return;
                }

                const filtered = ALL_CITIES.filter(c => String(c.state_code) === String(stateId));

                citySelect.innerHTML = filtered.length === 0
                    ? '<option value="" style="background:#1a0a00;">No cities found</option>'
                    : '<option value="" style="background:#1a0a00;">-- Select City --</option>';

                filtered.forEach(city => {
                    const opt = document.createElement('option');
                    opt.value = city.id;
                    opt.textContent = city.city_name;
                    opt.style.background = '#1a0a00';
                    citySelect.appendChild(opt);
                });

                /* Refresh Nice Select after options change */
                if (typeof $ !== 'undefined' && $.fn.niceSelect) {
                    $('#citySelect').niceSelect('update');
                    $('#areaSelect').niceSelect('update');
                }
            }

            function loadAreas(cityId) {
                const areaSelect = document.getElementById('areaSelect');
                const pincodeField = document.getElementById('orderPincode').closest('.order-field');
                const areaField = areaSelect.closest('.order-field');

                // Clear pincode on city change
                document.getElementById('orderPincode').value = '';

                if (!cityId) {
                    areaSelect.innerHTML = '<option value="">-- Select City First --</option>';
                    areaField.style.display = '';
                    if (typeof $ !== 'undefined' && $.fn.niceSelect) $('#areaSelect').niceSelect('update');
                    return;
                }

                const filtered = ALL_AREAS.filter(a => String(a.city_id) === String(cityId));

                if (filtered.length === 0) {
                    areaField.style.display = 'none';
                    pincodeField.querySelector('.order-label').textContent = 'PINCODE *';
                    document.getElementById('orderPincode').required = true;
                    document.getElementById('orderPincode').focus();
                } else {
                    areaField.style.display = '';
                    pincodeField.querySelector('.order-label').textContent = 'PINCODE';
                    document.getElementById('orderPincode').required = false;

                    areaSelect.innerHTML = '<option value="">-- Select Area --</option>';
                    filtered.forEach(area => {
                        const opt = document.createElement('option');
                        opt.value = area.id;
                        opt.textContent = area.area_name;
                        areaSelect.appendChild(opt);
                    });


                    if (filtered.length === 1) {
                        areaSelect.value = filtered[0].id;
                        if (filtered[0].pincode) {
                            document.getElementById('orderPincode').value = filtered[0].pincode;
                        }
                    }

                    if (typeof $ !== 'undefined' && $.fn.niceSelect) $('#areaSelect').niceSelect('update');
                }

                if (typeof $ !== 'undefined' && $.fn.niceSelect) {
                    $('#areaSelect').niceSelect('update');

                    // Destroy and reinitialize to ensure change events bind correctly
                    $('#areaSelect').niceSelect('destroy');
                    $('#areaSelect').niceSelect();

                    // Re-bind change after reinit
                    $('#areaSelect').on('change', function () {
                        const areaId = $(this).val();
                        const area = ALL_AREAS.find(a => String(a.id) === String(areaId));
                        document.getElementById('orderPincode').value = area?.pincode ?? '';
                    });
                }
            }




            /* ── Bind events via jQuery to work with Nice Select ── */
            $(document).ready(function () {
                $('#stateSelect').on('change', function () {
                    loadCities($(this).val());
                });

                $('#citySelect').on('change', function () {
                    loadAreas($(this).val());
                });
            });

            async function lookupCustomer(phone) {
                phone = phone.trim();
                if (phone.length < 10) return;

                try {
                    const res = await fetch(`/customer/lookup/${phone}`);
                    const data = await res.json();

                    if (!data.found) return;

                    /* Auto-fill fields */
                    document.getElementById('orderName').value = data.name;
                    document.getElementById('orderEmail').value = data.email;
                    document.getElementById('orderAddress').value = data.address;
                    document.getElementById('orderPincode').value = data.pincode ?? '';

                    /* Lock name and phone — not editable */
                    document.getElementById('orderName').readOnly = true;
                    document.getElementById('orderPhone').readOnly = true;
                    document.getElementById('orderName').style.opacity = '0.6';
                    document.getElementById('orderPhone').style.opacity = '0.6';

                    /* Auto-select state if available */
                    if (data.state) {
                        const stateSelect = document.getElementById('stateSelect');
                        /* Find matching option by state name */
                        [...stateSelect.options].forEach(opt => {
                            if (opt.text.toUpperCase() === data.state.toUpperCase()) {
                                stateSelect.value = opt.value;
                            }
                        });
                        $('#stateSelect').niceSelect('update');

                        /* Load cities then select saved city */
                        loadCities(stateSelect.value);

                        /* Wait for cities to populate then select */
                        setTimeout(() => {
                            const citySelect = document.getElementById('citySelect');
                            [...citySelect.options].forEach(opt => {
                                if (opt.text.toUpperCase() === (data.city ?? '').toUpperCase()) {
                                    citySelect.value = opt.value;
                                }
                            });
                            $('#citySelect').niceSelect('update');
                            loadAreas(citySelect.value);
                        }, 100);
                    }

                } catch (e) {
                    console.error('Customer lookup failed', e);
                }
            }
        </script>
    @endpush
@endsection