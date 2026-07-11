@extends('layouts.default')

@section('main-page')

@push('styles')
<style>
    @media screen and (width: 768px) and (height: 1024px) {
        .f-grid {
            grid-template-columns: 1fr 1fr !important;
        }
        tbody {
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            align-items: start;
        }
        .category, .cat-pagination-row {
            grid-column: 1 / -1;
            padding: 30px 0 10px !important;
        }
        .product-row {
            margin-bottom: 0 !important;
            height: 100%;
        }
    }
    @media screen and (width: 820px) and (height: 1024px) {
        .f-grid {
            grid-template-columns: 1fr 1fr !important;
        }
        tbody {
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            align-items: start;
        }
        .category, .cat-pagination-row {
            grid-column: 1 / -1;
            padding: 30px 0 10px !important;
        }
        .product-row {
            margin-bottom: 0 !important;
            height: 100%;
        }
    }
    @media screen and (width: 820px) and (height: 1180px) {
        .f-grid {
            grid-template-columns: 1fr 1fr !important;
        }
        tbody {
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            align-items: start;
        }
        .category, .cat-pagination-row {
            grid-column: 1 / -1;
            padding: 30px 0 10px !important;
        }
        .product-row {
            margin-bottom: 0 !important;
            height: 100%;
        }
    }
    @media screen and (width: 912px) and (height: 1368px) {
        .estimate-inner {
            max-width: 96% !important;
            padding: 10px !important;
        }
        .table-wrap {
            padding: 20px !important;
        }
        .f-grid {
            grid-template-columns: 1fr 1fr !important;
        }
        tbody {
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            align-items: start;
        }
        .category, .cat-pagination-row {
            grid-column: 1 / -1;
            padding: 30px 0 10px !important;
        }
        .product-row {
            margin-bottom: 0 !important;
            height: 100%;
        }
    }
        @media screen and (width: 540px) and (height: 720px) {
            .estimate-inner {
                max-width: 96% !important;
                padding: 10px !important;
            }
            .table-wrap {
                padding: 15px !important;
            }
            .product-row {
                grid-template-columns: 90px max-content 1fr auto !important;
                grid-template-rows: auto auto auto !important;
                gap: 5px 10px !important;
                align-items: center !important;
            }
            .product-row td:nth-child(1) {
                grid-column: 1 !important;
                grid-row: 1 / span 3 !important;
            }
            .product-row td:nth-child(2) {
                grid-column: 2 / span 2 !important;
                grid-row: 1 !important;
                font-size: 1.05rem !important;
            }
            .product-row td:nth-child(3) {
                grid-column: 2 / span 2 !important;
                grid-row: 2 !important;
            }
            .product-row td:nth-child(4) {
                grid-column: 2 !important;
                grid-row: 3 !important;
            }
            .product-row td:nth-child(6) {
                grid-column: 3 !important;
                grid-row: 3 !important;
                margin-left: 0 !important;
            }
            .product-row td:nth-child(5) {
                grid-column: 4 !important;
                grid-row: 1 !important;
                justify-self: end !important;
                align-self: start !important;
                margin-top: 2px !important;
            }
            .product-row td:nth-child(7) {
                grid-column: 4 !important;
                grid-row: 2 / span 2 !important;
                justify-self: end !important;
                align-self: center !important;
                margin-top: 0 !important;
            }
        }

        @media screen and (width: 344px) and (height: 882px) {
            .estimate-inner {
                padding: 5px !important;
            }
            .table-wrap {
                padding: 10px !important;
            }
            .category td {
                font-size: 1.2rem !important;
                padding: 20px 5px 10px !important;
            }
            .product-row {
                grid-template-columns: 75px 1fr max-content !important;
                grid-template-rows: auto auto auto auto !important;
                gap: 8px 10px !important;
                padding: 12px !important;
            }
            .product-row td:nth-child(1) {
                grid-column: 1 !important;
                grid-row: 1 / span 3 !important;
            }
            .product-row td:nth-child(1) img {
                width: 75px !important;
                height: 75px !important;
            }
            .product-row td:nth-child(2) {
                grid-column: 2 / span 2 !important;
                grid-row: 1 !important;
                font-size: 0.95rem !important;
            }
            .product-row td:nth-child(3) {
                grid-column: 2 / span 2 !important;
                grid-row: 2 !important;
            }
            .product-row td:nth-child(4) {
                grid-column: 2 !important;
                grid-row: 3 !important;
                justify-self: start !important;
            }
            .product-row td:nth-child(6) {
                grid-column: 2 !important;
                grid-row: 3 !important;
                margin-left: 45px !important; 
            }
            .product-row td:nth-child(5) {
                grid-column: 3 !important;
                grid-row: 3 !important;
                justify-self: end !important;
            }
            .product-row td:nth-child(7) {
                grid-column: 1 / span 3 !important;
                grid-row: 4 !important;
                width: 100% !important;
                display: flex !important;
                justify-content: center !important;
                margin-top: 8px !important;
            }
            .qty-wrapper {
                width: 100% !important;
                justify-content: center !important;
            }
            .qty-btn {
                width: 40px !important;
            }
            .qty {
                flex-grow: 1 !important;
            }
        }

        @media screen and (max-width: 855px) and (min-width: 850px) {
            .f-grid {
                grid-template-columns: 1fr 1fr !important;
            }
            tbody {
                display: grid !important;
                grid-template-columns: 1fr 1fr;
                gap: 15px;
                align-items: start;
            }
            .category, .cat-pagination-row {
                grid-column: 1 / -1;
                padding: 30px 0 10px !important;
            }
            .product-row {
                margin-bottom: 0 !important;
                height: 100%;
            }
        }

/* ===========================================
   PREMIUM ESTIMATE PAGE STYLES (GOLDEN LIGHT)
   =========================================== */

/* 1. Page & Layout */
.estimate-page { 
    background: #FFFFFF; 
    min-height: 100vh;
}

.top-summary {
    width: 100%;
    height: 95px;
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.12), rgba(255, 255, 255, 0.04));
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 2px solid rgba(255, 255, 255, 0.5);
    border-radius: 25px;
    display: flex;
    align-items: center;
    justify-content: space-evenly;
    z-index: 990;
    box-shadow: 
        0 12px 48px rgba(255, 255, 255, 0.15),
        0 0 0 1px rgba(255, 255, 255, 0.3),
        0 0 60px rgba(255, 255, 255, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.5);
    margin: 40px 0;
    transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
}

.top-summary.is-sticky {
    position: fixed;
    bottom: 25px;
    left: 50%;
    transform: translateX(-50%);
    width: min(100% - 40px, 1100px);
    height: 80px;
    background: rgba(15, 15, 28, 0.95);
    backdrop-filter: blur(30px);
    border: 2px solid rgba(255, 255, 255, 0.6);
    border-radius: 25px;
    margin-bottom: 0;
    box-shadow: 
        0 20px 80px rgba(255, 255, 255, 0.2),
        0 0 0 1px rgba(255, 255, 255, 0.4),
        0 0 100px rgba(255, 255, 255, 0.15),
        inset 0 1px 0 rgba(255, 255, 255, 0.6);
    animation: stickySlideUp 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
    z-index: 1000;
}

@keyframes stickySlideUp {
    from { transform: translateX(-50%) translateY(50px); opacity: 0; }
    to { transform: translateX(-50%) translateY(0); opacity: 1; }
}

.summary-item {
    display: flex;
    align-items: center;
    gap: 15px;
}

.summary-icon {
    width: 45px;
    height: 45px;
    background: var(--gold-deep);
    color: #fff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    box-shadow: 0 8px 15px rgba(184, 134, 11, 0.2);
}

.summary-label {
    display: block;
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--muted);
}

.summary-value {
    display: block;
    font-family: 'Outfit', sans-serif;
    font-size: 1.4rem;
    font-weight: 900;
    color: #fff !important;
    text-shadow: 0 0 15px rgba(255, 255, 255, 0.4);
}

.summary-divider {
    width: 1px;
    height: 30px;
    background: var(--clay);
}

.order-now-btn {
    background: linear-gradient(135deg, #0c689b, #043048);
    color: #ffffff;
    border: none;
    padding: 12px 30px;
    border-radius: 50px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1rem;
    font-weight: 800;
    cursor: pointer;
    position: relative;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    box-shadow: 
        0 10px 30px rgba(240, 168, 50, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.4);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.order-now-btn:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 
        0 20px 40px rgba(240, 168, 50, 0.4),
        0 0 20px rgba(240, 168, 50, 0.2);
     background: linear-gradient(135deg, #0c689b, #043048);
}

.order-now-btn i {
    font-size: 1.1rem;
}

.cart-count-pill {
    background: #111;
    color: #fff;
    min-width: 24px;
    height: 24px;
    padding: 0 6px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 900;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

/* 3. Hero Banner */
.estimate-hero {
    height: 55vh;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: var(--ink);
    text-align: center;
    margin-bottom: 0;
}

.hero-parallax-bg {
    position: absolute;
    inset: 0;
    background-image: url('{{ asset('assets/img/bg.jpg') }}');
    background-size: cover;
    background-position: center;
    opacity: 0.4;
    transform: scale(1.1);
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, transparent, var(--ink) 95%);
}

.hero-title {
    font-family: var(--font-display);
    font-size: 5rem;
    color: #fff;
    position: relative;
    z-index: 10;
    line-height: 1;
    text-shadow:
        0 2px 10px rgba(255, 255, 255, 0.3),
        0 0 40px rgba(255, 255, 255, 0.2),
        0 0 80px rgba(255, 255, 255, 0.1);
}

.hero-title span { 
    background: linear-gradient(135deg, var(--gold-light), var(--gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-family: var(--font-accent);
}

.hero-sub {
    font-size: 1.3rem;
    color: rgba(255,255,255,0.7);
    margin-top: 20px;
    position: relative;
    z-index: 10;
}

/* 4. Table & Products */
.estimate-content { padding-bottom: 120px; }

.search-wrap {
    max-width: 600px;
    margin: 20px auto 60px;
    position: relative;
    z-index: 20;
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    padding: 15px 30px;
    border-radius: 40px;
    border: 2px solid rgba(255, 255, 255, 0.5);
    box-shadow: 
        0 12px 48px rgba(255, 255, 255, 0.15),
        0 0 0 1px rgba(255, 255, 255, 0.3),
        0 0 60px rgba(255, 255, 255, 0.1),
        inset 0 1px 1px rgba(255, 255, 255, 0.3);
    display: flex;
    align-items: center;
    gap: 15px;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
}

.search-wrap:hover, .search-wrap:focus-within {
    transform: translateY(-5px);
    border-color: rgba(255, 255, 255, 0.8);
    box-shadow: 
        0 20px 60px rgba(255, 255, 255, 0.2),
        0 0 0 1px rgba(255, 255, 255, 0.4),
        0 0 80px rgba(255, 255, 255, 0.15),
        inset 0 1px 1px rgba(255, 255, 255, 0.4);
}

.search-wrap i { color: var(--gold-deep); font-size: 1.2rem; }

.search-wrap input {
    border: none !important;
    width: 100%;
    font-size: 1.1rem;
    font-weight: 500;
    background: transparent !important;
    color: #fff !important;
    box-shadow: none !important;
    padding: 0;
}

.search-wrap input::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.search-wrap input:focus { outline: none; box-shadow: none !important; }

.clear-search-btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
    opacity: 0;
    pointer-events: none;
    transform: scale(0.8);
    flex-shrink: 0;
}

.clear-search-btn.active {
    opacity: 1;
    pointer-events: auto;
    transform: scale(1);
}

.clear-search-btn:hover {
    background: #ff4757;
    border-color: #ff4757;
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(255, 71, 87, 0.4);
}

.table-wrap {
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03));
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border-radius: 40px;
    padding: 40px;
    box-shadow: 
        0 30px 60px rgba(0, 0, 0, 0.5),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
    border: 1.5px solid rgba(255, 255, 255, 0.3) !important;
    position: relative;
}

/* Halo effect behind table */
.table-wrap::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
    filter: blur(80px);
    z-index: -1;
}

table { width: 100%; border-collapse: collapse; border-spacing: 0; border: 1px solid #000000 !important; }

thead th {
    position: sticky;
    top: 76px;
    background: #ffffff;
    z-index: 900;
    padding: 20px;
    font-size: 0.8rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--muted);
    border: 1px solid #000000 !important;
    text-align: center;
}

.product-row { 
    transition: 0.3s cubic-bezier(0.19, 1, 0.22, 1);
}

.product-row td {
    padding: 25px 15px;
    vertical-align: middle;
    text-align: center;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid #000000 !important;
}

.product-row td:first-child { border-radius: 0; }
.product-row td:last-child { border-radius: 0; }

/* Desktop & Tablet Table Column Matrix */
@media (min-width: 851px) {
    table { table-layout: fixed; }
    th:nth-child(1) { width: 110px; } /* Image */
    th:nth-child(2) { width: auto; text-align: left; padding-left: 25px; } /* Product Name */
    th:nth-child(3) { width: 12%; } /* Box Content */
    th:nth-child(4) { width: 10%; } /* MRP */
    th:nth-child(5) { width: 12%; } /* Discount */
    th:nth-child(6) { width: 12%; } /* Offer Price */
    th:nth-child(7) { width: 160px; } /* Quantity */
    th:nth-child(8) { width: 10%; } /* Total */
    
    .product-row td:nth-child(2) { text-align: left; padding-left: 25px; }
}

.product-row:hover td { background: var(--off-white); }
.product-row:hover { transform: scale(1.01); }

.product-row img {
    width: 65px;
    height: 65px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.product-name {
    font-weight: 800;
    color: var(--ink);
    font-size: 1.1rem;
    text-align: left !important;
}

.actual { text-decoration: line-through; color: var(--muted); font-size: 0.9rem; }
.price { color: var(--gold-deep); font-weight: 900; font-size: 1.25rem; font-family: 'Outfit', sans-serif; }

.qty-wrapper {
    display: inline-flex;
    align-items: center;
    background: var(--off-white);
    padding: 5px;
    border-radius: 50px;
    border: 1px solid var(--clay);
}

.qty-btn {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: #fff;
    color: var(--ink);
    border: 1px solid var(--stone);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: 0.3s;
}

.qty-btn:hover { background: var(--gold-deep); color: #fff; transform: scale(1.1); }

.qty {
    width: 50px !important;
    background: none !important;
    border: none !important;
    text-align: center !important;
    font-weight: 800 !important;
    font-size: 1rem !important;
    color: var(--ink) !important;
}

.rowTotal {
    font-weight: 900;
    color: #fff;
    font-size: 1.15rem;
    font-family: 'Outfit', sans-serif;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
}

.category td {
    background: none !important;
    padding: 60px 0 20px !important;
    text-align: left !important;
    font-family: var(--font-display);
    font-size: 2.2rem;
    color: #fff !important;
    border: none !important;
    text-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
}

.category td span { 
    background: linear-gradient(135deg, var(--gold-light), var(--gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Video Icons */
.video-icon {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: #ff4757;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: 0.3s;
}

.video-icon::after {
    content: '\f04b';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    font-size: 0.8rem;
    margin-left: 2px;
}

.video-icon:hover { transform: scale(1.15); background: #eb3b5a; }
.video-icon.disabled { background: var(--clay); opacity: 0.4; }

/* Cart Drawer */
.cart-drawer {
    position: fixed;
    right: -450px;
    top: 0;
    width: 450px;
    height: 100vh;
    background: #fff;
    z-index: 2000;
    box-shadow: -20px 0 60px rgba(0,0,0,0.15);
    transition: 0.5s cubic-bezier(0.19, 1, 0.22, 1);
    display: flex;
    flex-direction: column;
}

.cart-drawer.active { right: 0; }

.cart-drawer-header {
    padding: 30px;
    background: var(--ink);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.cart-drawer-title { font-family: var(--font-display); font-size: 1.8rem; }
.cart-close-btn { background: none; border: none; color: #fff; font-size: 1.5rem; cursor: pointer; }

.cart-drawer-body { padding: 30px; flex-grow: 1; overflow-y: auto; }

.cart-item-row {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid var(--stone);
}

.cart-item-info { flex-grow: 1; }
.cart-item-title { font-weight: 800; font-size: 0.95rem; color: #fff !important; }
.cart-item-meta { font-size: 0.8rem; color: #fff !important; margin-top: 4px; }
.cart-item-total { color: #fff !important; font-weight: 700; }

.cart-drawer-footer {
    padding: 30px;
    background: var(--off-white);
    border-top: 1px solid var(--stone);
}

.cart-summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    font-weight: 700;
}

.cart-summary-row.total {
    font-size: 1.5rem;
    color: var(--ink);
    padding-top: 15px;
    border-top: 2px dashed var(--clay);
}

.btn-gold {
    width: 100%;
    background: var(--gold-deep);
    color: #fff;
    border: none;
    padding: 18px;
    border-radius: 15px;
    font-weight: 900;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-gold:hover { background: var(--ink); transform: translateY(-5px); }

/* Progress Bar */
.min-order-wrap { margin-bottom: 25px; }
.min-order-top { display: flex; justify-content: space-between; margin-bottom: 8px; font-weight: 800; font-size: 0.8rem; text-transform: uppercase; }
.min-order-bar-track { height: 8px; background: var(--clay); border-radius: 10px; overflow: hidden; }
.min-order-bar-fill { height: 100%; background: var(--gold-deep); transition: 0.5s; width: 0%; }
.min-order-status { font-size: 0.8rem; color: var(--muted); margin-top: 8px; font-weight: 600; }

/* --- ORDER MODAL REFINED --- */
.order-modal-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(10px);
    z-index: 2100; display: none; align-items: center; justify-content: center; padding: 20px;
}
.order-modal-box {
    background: #fff; width: min(100%, 650px); border-radius: 40px; position: relative;
    max-height: 90vh; overflow-y: auto; overflow-x: hidden;
    box-shadow: 0 50px 100px rgba(0,0,0,0.5);
    animation: modalPop 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
/* Hide scrollbar for Chrome, Safari and Opera */
.order-modal-box::-webkit-scrollbar { display: none; }
.order-modal-box { -ms-overflow-style: none; scrollbar-width: none; }
@keyframes modalPop { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }

.order-modal-close {
    position: absolute; top: 25px; right: 25px; background: var(--off-white); border: 1px solid var(--stone);
    width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
    cursor: pointer; z-index: 10; transition: 0.3s;
}
.order-modal-close:hover { background: var(--gold-deep); color: #fff; transform: rotate(90deg); }

.order-modal-header { padding: 40px 40px 10px; text-align: center; }
.order-modal-eyebrow { font-size: 0.75rem; font-weight: 800; color: var(--gold-deep); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 5px; }
.order-modal-title { font-family: var(--font-display); font-size: 2.2rem; line-height: 1; color: var(--ink); margin-bottom:15px; }

.order-net-strip {
    background: var(--ink); margin: 20px 40px; border-radius: 20px; padding: 25px 35px;
    display: flex; justify-content: space-between; align-items: center; color: #fff;
}
.net-label { font-size: 0.7rem; font-weight: 800; opacity: 0.6; letter-spacing: 1px; }
.net-value { font-size: 2rem; font-weight: 900; line-height: 1; }
.net-icon { font-size: 1.5rem; color: var(--gold-deep); opacity: 0.5; }

.order-form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
.order-field { display: flex; flex-direction: column; gap: 8px; }
.order-label { font-size: 0.75rem; font-weight: 800; color: var(--ink); letter-spacing: 0.5px; opacity: 0.8;margin-top : 20px}
.order-input {
    background: var(--off-white); border: 1px solid var(--stone); padding: 16px 20px; border-radius: 12px;
    font-size: 1rem; font-weight: 600; color: var(--ink); transition: 0.3s; width: 100%;
}
.order-input:focus { 
    border-color: var(--gold-light); 
    background: rgba(255,255,255,0.1); 
    outline: none; 
    box-shadow: 0 0 20px rgba(240, 168, 50, 0.15), inset 0 0 10px rgba(255,255,255,0.05); 
}
.order-textarea { resize: none; min-height: 80px; }
.order-select { 
    cursor: pointer; 
    -webkit-appearance: none; 
    appearance: none;
    color-scheme: dark;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23F0A832' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); 
    background-repeat: no-repeat; 
    background-position: right 15px center; 
    background-size: 15px; 
}

.order-select option {
    background-color: #0c0c18;
    color: #fff;
    padding: 10px;
}


.order-submit-btn {
    width: 100%; padding: 22px; background: var(--ink); color: #fff; border: none; border-radius: 15px;
    font-size: 1.1rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; transition: 0.3s; margin-top: 10px;
}
.order-submit-btn:hover { background: var(--gold-deep); transform: translateY(-5px); box-shadow: 0 15px 30px rgba(184,134,11,0.3); }

.mobile-sticky-bar { display: none; }

/* Mobile Sticky Summary */
@media (max-width: 991px) {
    .top-summary { display: none !important; }
    .hero-title { font-size: 3rem; }
    .table-wrap { padding: 0 !important; border-radius: 0; border: none !important; background: transparent; box-shadow: none; box-sizing: border-box !important; overflow: hidden; width: 100%; }
    
    /* Mobile Table: Convert to Modern Cards */
    table, tbody, tr, td, th {
        display: block;
        width: 100%;
        min-width: unset;
        border: none !important;
        box-sizing: border-box !important;
    }
    table {
        border-collapse: collapse;
        border: none !important;
    }
    thead {
        display: none !important;
    }
    
    .category td { 
        padding: 35px 12px 15px !important; 
        font-size: 1.15rem !important; 
        font-weight: 800 !important;
        background: transparent !important;
        text-align: left;
        color: #111 !important;
        border: none !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .product-row {
        display: grid !important;
        grid-template-columns: 85px max-content 1fr max-content;
        grid-template-rows: auto auto auto auto;
        gap: 6px 10px;
        background: #fff !important;
        border: 1px solid rgba(0,0,0,0.08) !important;
        border-radius: 12px;
        padding: 14px !important;
        margin-bottom: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        box-sizing: border-box !important;
        width: 100% !important;
        overflow: hidden;
    }
    
    .product-row td {
        padding: 0 !important;
        border: none !important;
        background: transparent !important;
        text-align: left !important;
        color: #333 !important;
        line-height: 1.3;
    }
    
    /* 1. Image */
    .product-row td:nth-child(1) {
        grid-column: 1;
        grid-row: 1 / span 4;
        display: flex;
        align-items: flex-start;
        justify-content: flex-start;
    }
    .product-row td:nth-child(1) img {
        width: 85px;
        height: 85px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin: 0;
    }
    
    /* 2. Product Name */
    .product-row td:nth-child(2) {
        grid-column: 2 / span 3;
        grid-row: 1;
        font-size: 0.95rem !important;
        font-weight: 700;
        color: #111 !important;
        margin-bottom: 2px;
        padding-right: 5px !important;
    }
    
    /* 3. Box Content */
    .product-row td:nth-child(3) {
        grid-column: 2 / span 3;
        grid-row: 2;
        font-size: 0.75rem !important;
        color: #000 !important;
        font-weight: 800;
        margin-bottom: 4px;
    }
    
    /* 4. MRP */
    .product-row td:nth-child(4) {
        grid-column: 2;
        grid-row: 3;
        font-size: 0.8rem !important;
        color: #888 !important;
        text-decoration: line-through;
        align-self: center;
        white-space: nowrap;
    }
    
    /* 5. Discount */
    .product-row td:nth-child(5) {
        grid-column: 4;
        grid-row: 3;
        font-size: 0.7rem !important;
        background: rgba(22, 163, 74, 0.1) !important;
        color: #16A34A !important;
        padding: 2px 6px !important;
        border-radius: 4px;
        align-self: center;
        justify-self: end;
        font-weight: 800;
        white-space: nowrap;
        margin-left: 5px;
        width: max-content !important;
    }
    
    /* 6. Offer Price */
    .product-row td:nth-child(6) {
        grid-column: 3;
        grid-row: 3;
        font-size: 1.15rem !important;
        color: #0b6698 !important;
        font-weight: 900;
        align-self: center;
        justify-self: start;
        white-space: nowrap;
        margin-left: 8px;
    }
    
    /* 7. Quantity */
    .product-row td:nth-child(7) {
        grid-column: 2 / span 3;
        grid-row: 4;
        align-self: center;
        margin-top: 6px;
    }
    
    /* 8. Total */
    .product-row td:nth-child(8) {
        display: none !important;
    }

    .mobile-sticky-bar {
        position: fixed;
        bottom: 25px;
        left: 50%;
        transform: translateX(-50%);
        width: min(92%, 400px);
        height: 75px;
        background: linear-gradient(135deg, var(--gold-deep), var(--saffron));
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 12px 0 20px;
        color: #fff;
        z-index: 1001;
        box-shadow: 
            0 20px 40px rgba(0,0,0,0.4),
            0 0 20px rgba(240, 168, 50, 0.2);
        text-decoration: none;
        border: 1px solid rgba(255,255,255,0.3);
        animation: slideUpPill 0.6s cubic-bezier(0.23, 1, 0.32, 1);
    }

    @keyframes slideUpPill {
        from { transform: translateX(-50%) translateY(100px); opacity: 0; }
        to { transform: translateX(-50%) translateY(0); opacity: 1; }
    }

    .msb-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .msb-cart-icon {
        position: relative;
        width: 45px;
        height: 45px;
        background: rgba(255,255,255,0.15);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .msb-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #fff;
        color: var(--gold-deep);
        min-width: 20px;
        height: 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 900;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        padding: 0 5px;
    }

    .msb-info {
        display: flex;
        flex-direction: column;
    }

    .msb-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.8;
        font-weight: 700;
    }
    
    .msb-total { 
        font-size: 1.4rem; 
        font-weight: 900; 
        line-height: 1;
        font-family: 'Outfit', sans-serif;
    }

    .msb-btn { 
        background: #fff; 
        color: var(--gold-deep); 
        padding: 0 25px; 
        height: 50px;
        border-radius: 16px; 
        font-weight: 900; 
        font-size: 0.85rem; 
        text-transform: uppercase; 
        display: flex;
        align-items: center;
        justify-content: center;
        letter-spacing: 1px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .order-modal-box { padding: 0; border-radius: 30px; width: 95%; background: rgba(15,15,28,0.98); }
    .order-form-grid-2 { grid-template-columns: 1fr; gap: 15px; }
    .order-modal-header { padding: 30px 20px 10px; }
    .order-net-strip { margin: 15px; padding: 20px; }
    .order-field { padding: 0 20px; }
    .order-submit-btn { border-radius: 0 0 30px 30px; margin-top: 20px; padding: 25px; }
}

/* Dark premium polish aligned with home/about/contact */
.estimate-page {
    background:
        linear-gradient(180deg, rgba(8,8,16,0.98), rgba(12,12,24,0.98));
    color: #fff;
}

.estimate-hero {
    min-height: 560px;
    background: #080810;
}

.hero-overlay {
    background:
        radial-gradient(circle at 50% 42%, rgba(240,168,50,0.16), transparent 18rem),
        linear-gradient(to bottom, rgba(8,8,16,0.66), rgba(8,8,16,0.97));
}

.hero-sub {
    color: rgba(255,255,255,0.82);
}

.hero-title span {
    background: linear-gradient(135deg, var(--gold-light), var(--gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.estimate-content {
    padding-top: 1px;
    background:
        radial-gradient(circle at 50% 0, rgba(212,134,10,0.1), transparent 28rem),
        linear-gradient(180deg, rgba(8,8,16,0.98), rgba(12,12,24,0.98));
}

.top-summary,
.search-wrap,
.table-wrap {
    background: rgba(15,15,28,0.92);
    border-color: rgba(240,168,50,0.22);
    box-shadow: 0 24px 70px rgba(0,0,0,0.45);
}

.top-summary.is-sticky {
    background: rgba(15,15,28,0.9);
    border-color: rgba(240,168,50,0.28);
}

.summary-value,
.product-name,
.rowTotal,
.category td,
.qty {
    color: #fff !important;
}

.summary-label,
thead th,
.min-order-status {
    color: rgba(255,255,255,0.58);
}

.search-wrap input {
    color: #fff;
}

.search-wrap input::placeholder {
    color: rgba(255,255,255,0.52);
}

.product-row td {
    background: rgba(255,255,255,0.045);
    border-color: rgba(255,255,255,0.1);
}

.product-row:hover td {
    background: rgba(212,134,10,0.1);
}

.actual {
    color: rgba(255,255,255,0.48);
}

.price {
    color: var(--gold-light);
}

.qty-wrapper {
    background: rgba(255,255,255,0.06);
    border-color: rgba(255,255,255,0.12);
}

.qty-btn {
    background: rgba(255,255,255,0.08);
    color: #fff;
    border-color: rgba(255,255,255,0.14);
}

@media (max-width: 767px) {
    .estimate-hero {
        min-height: 500px;
        height: 62vh;
    }
}
.table-wrap{
    overflow: visible;
}

/* ===========================================
   PREMIUM LIGHT MODALS STYLES
   =========================================== */

/* Backdrop Overlays */
.cart-overlay,
.order-modal-overlay {
    background: rgba(15, 23, 42, 0.45) !important;
    backdrop-filter: blur(8px) !important;
    -webkit-backdrop-filter: blur(8px) !important;
}

/* 1. Order Summary Modal (Cart Drawer) */
.cart-drawer {
    background: #FFFFFF !important;
    border-left: 1px solid #E5E7EB !important;
    box-shadow: -10px 0 30px rgba(0, 0, 0, 0.08) !important;
    border-top-left-radius: 24px !important;
    border-bottom-left-radius: 24px !important;
}

.cart-drawer-header {
    background: #FFFFFF !important;
    color: #111827 !important;
    border-bottom: 1px solid #E5E7EB !important;
    padding: 24px 30px !important;
}

.cart-drawer-title {
    font-family: var(--font-display) !important;
    font-size: 1.5rem !important;
    font-weight: 700 !important;
    color: #111827 !important;
}

.cart-drawer-title i {
    color: #FF5E36 !important; /* Premium branding color for header icon */
    margin-right: 8px;
}

.cart-close-btn {
    background: none !important;
    border: none !important;
    color: #4B5563 !important;
    font-size: 1.5rem !important;
    cursor: pointer !important;
    transition: color 0.2s, transform 0.2s !important;
}

.cart-close-btn:hover {
    color: #111827 !important;
    transform: scale(1.1);
}

.cart-close-btn:focus {
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(255, 94, 54, 0.4) !important;
    border-radius: 4px;
}

.cart-drawer-body {
    background: #FFFFFF !important;
    padding: 24px 30px !important;
}

/* Cart Items inside Drawer */
.cart-item-row {
    border-bottom: 1px solid #E5E7EB !important;
    padding: 16px 0 !important;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.cart-item-info {
    flex-grow: 1;
}

.cart-item-title {
    font-weight: 600 !important;
    font-size: 0.95rem !important;
    color: #1F2937 !important; /* Product names: #1F2937 */
}

.cart-item-meta-value {
    font-size: 0.85rem !important;
    color: #4B5563 !important; /* Labels: #4B5563 */
    margin-top: 4px;
}

.cart-item-total-price {
    color: #111827 !important; /* Prices and totals: #111827 */
    font-weight: 700 !important;
    font-size: 1rem !important;
}

/* Cart Drawer Footer */
.cart-drawer-footer {
    background: #FFFFFF !important;
    border-top: 1px solid #E5E7EB !important;
    padding: 24px 30px !important;
}

/* Progress bar inside Drawer */
.min-order-wrap {
    margin-bottom: 20px !important;
}

.min-order-top {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-weight: 700 !important;
    font-size: 0.8rem !important;
    text-transform: uppercase;
    color: #4B5563 !important; /* Labels: #4B5563 */
}

.min-order-label {
    color: #4B5563 !important;
}

.min-order-value {
    color: #111827 !important; /* Prices and totals: #111827 */
}

.min-order-bar-track {
    height: 8px !important;
    background: #E5E7EB !important; /* Light divider color for track */
    border-radius: 9999px !important;
    overflow: hidden;
}

.min-order-bar-fill {
    height: 100% !important;
    background: linear-gradient(135deg, #FF5E36, #F02D00) !important; /* Orange/red gradient */
    border-radius: 9999px !important;
    transition: 0.5s;
}

.order-status, #minOrderStatus {
    font-size: 0.85rem !important;
    color: #4B5563 !important;
    margin-top: 8px !important;
    font-weight: 600 !important;
}

/* Cart Summary Rows */
.cart-summary-rows {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 20px !important;
}

.cart-summary-row {
    display: flex;
    justify-content: space-between;
    font-weight: 600 !important;
    font-size: 0.95rem !important;
    color: #4B5563 !important; /* Labels: #4B5563 */
}

.cart-summary-row span:last-child {
    color: #111827 !important; /* Prices and totals: #111827 */
}

.cart-summary-row.total {
    font-size: 1.25rem !important;
    color: #111827 !important;
    padding-top: 16px !important;
    margin-top: 4px !important;
    border-top: 1px solid #E5E7EB !important;
}

.cart-summary-row.total span:last-child {
    font-size: 1.35rem !important;
    font-weight: 800 !important;
    color: #111827 !important;
}

/* Buttons inside Drawer */
.btn-gold#confirmOrderBtn {
    width: 100%;
    background: linear-gradient(135deg, #FF5E36, #F02D00) !important; /* Premium orange/red CTA */
    color: #FFFFFF !important;
    border: none !important;
    padding: 16px !important;
    border-radius: 12px !important;
    font-weight: 700 !important;
    font-size: 1rem !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.2s ease-in-out !important;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 14px rgba(240, 45, 0, 0.2) !important;
}

.btn-gold#confirmOrderBtn:hover {
    background: linear-gradient(135deg, #F02D00, #C22000) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(240, 45, 0, 0.3) !important;
}

.btn-gold#confirmOrderBtn:focus {
    outline: none !important;
    box-shadow: 0 0 0 4px rgba(255, 94, 54, 0.4) !important;
}

.btn-gold#confirmOrderBtn:disabled {
    background: #E5E7EB !important;
    color: #9CA3AF !important;
    box-shadow: none !important;
    cursor: not-allowed !important;
    transform: none !important;
}

.btn-continue#continueShopBtn {
    color: #4B5563 !important; /* Labels: #4B5563 */
    font-weight: 700 !important;
    margin-top: 12px !important;
    font-size: 0.9rem !important;
    transition: color 0.2s !important;
}

.btn-continue#continueShopBtn:hover {
    color: #111827 !important;
}

.btn-continue#continueShopBtn:focus {
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(75, 85, 99, 0.3) !important;
    border-radius: 4px;
}


/* 2. Estimate / Checkout Form Modal */
.order-modal-box {
    background: #FFFFFF !important;
    border-radius: 24px !important;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1) !important;
    border: 1px solid #E5E7EB !important;
    max-width: 650px !important;
    width: 100% !important;
}

@media (max-width: 850px) {
    .order-modal-box {
        width: 95% !important;
        border-radius: 24px !important;
    }
}

.order-modal-close {
    background: #F3F4F6 !important;
    border: 1px solid #E5E7EB !important;
    color: #4B5563 !important;
    width: 36px !important;
    height: 36px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    z-index: 10 !important;
    transition: all 0.2s ease-in-out !important;
    font-size: 1.25rem !important;
}

.order-modal-close:hover {
    background: #FF5E36 !important;
    color: #FFFFFF !important;
    border-color: #FF5E36 !important;
    transform: rotate(90deg) !important;
}

.order-modal-close:focus {
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(255, 94, 54, 0.4) !important;
}

.order-modal-header {
    padding: 32px 40px 10px !important;
    text-align: center !important;
}

@media (max-width: 850px) {
    .order-modal-header {
        padding: 24px 20px 10px !important;
    }
}

.order-modal-eyebrow {
    font-size: 0.75rem !important;
    font-weight: 800 !important;
    color: #FF5E36 !important; /* Eyebrow matching the orange/red */
    text-transform: uppercase !important;
    letter-spacing: 2px !important;
    margin-bottom: 8px !important;
}

.order-modal-title {
    font-family: var(--font-display) !important;
    font-size: 2rem !important;
    font-weight: 700 !important;
    color: #111827 !important; /* Headings: #111827 */
    margin-bottom: 12px !important;
}

.order-modal-bar {
    width: 40px !important;
    height: 3px !important;
    background: #FF5E36 !important; /* bar deep orange/red */
    margin: 12px auto !important;
    border-radius: 2px;
}

/* Net Strip inside Checkout Modal */
.order-net-strip {
    background: #F9FAFB !important;
    border: 1px solid #E5E7EB !important;
    margin: 15px 40px 25px !important;
    border-radius: 16px !important;
    padding: 20px 30px !important;
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    color: #111827 !important;
}

@media (max-width: 850px) {
    .order-net-strip {
        margin: 15px 20px 20px !important;
        padding: 16px 20px !important;
    }
}

.net-left {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.net-label {
    font-size: 0.75rem !important;
    font-weight: 700 !important;
    color: #4B5563 !important; /* Labels: #4B5563 */
    letter-spacing: 1px !important;
    opacity: 1 !important;
    text-transform: uppercase;
}

.net-value {
    font-size: 1.8rem !important;
    font-weight: 800 !important;
    color: #111827 !important; /* Prices and totals: #111827 */
}

.net-icon {
    font-size: 1.5rem !important;
    color: #FF5E36 !important; /* Brand orange/red */
    opacity: 0.8 !important;
}

/* Checkout Form spacing & layout */
#orderForm {
    padding: 0 40px 40px !important;
}

@media (max-width: 850px) {
    #orderForm {
        padding: 0 20px 30px !important;
    }
}

.order-form-grid-2 {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 20px !important;
    margin-bottom: 20px !important;
}

@media (max-width: 850px) {
    .order-form-grid-2 {
        grid-template-columns: 1fr !important;
        gap: 16px !important;
        margin-bottom: 16px !important;
    }
}

.order-field {
    display: flex !important;
    flex-direction: column !important;
    gap: 6px !important;
}

.order-label {
    font-size: 0.75rem !important;
    font-weight: 700 !important;
    color: #374151 !important; /* Labels: #374151 */
    letter-spacing: 0.5px !important;
    margin-top: 0 !important; /* Clean layout spacing */
    text-transform: uppercase !important;
    opacity: 1 !important;
}

/* Inputs, Textareas and Dropdowns styling */
.order-input {
    background: #FFFFFF !important;
    border: 1px solid #D1D5DB !important; /* Light gray border */
    padding: 12px 16px !important;
    border-radius: 8px !important;
    font-size: 0.95rem !important;
    font-weight: 500 !important;
    color: #111827 !important; /* Dark text */
    transition: all 0.2s ease-in-out !important;
    width: 100% !important;
    box-shadow: none !important;
}

.order-input::placeholder {
    color: #6B7280 !important; /* Placeholder color: #6B7280 */
    font-weight: 400 !important;
    opacity: 1 !important;
}

.order-input:focus {
    border-color: #FF5E36 !important; /* branding orange/red focus state */
    background: #FFFFFF !important;
    outline: none !important;
    box-shadow: 0 0 0 4px rgba(255, 94, 54, 0.15) !important; /* Visible focus state */
}

.order-textarea {
    resize: none !important;
    min-height: 80px !important;
    font-family: inherit !important;
}

.order-select {
    cursor: pointer !important;
    -webkit-appearance: none !important;
    appearance: none !important;
    color-scheme: light !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234B5563' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 15px center !important;
    background-size: 15px !important;
    padding-right: 40px !important;
}

.order-select option {
    background-color: #FFFFFF !important; /* light options background */
    color: #111827 !important; /* dark options text */
    padding: 10px !important;
}

/* Submit button inside Checkout Modal */
.order-submit-btn {
    width: 100% !important;
    padding: 16px 20px !important;
    background: linear-gradient(135deg, #FF5E36, #F02D00) !important; /* orange/red gradient */
    color: #FFFFFF !important;
    border: none !important;
    border-radius: 12px !important;
    font-size: 1rem !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    cursor: pointer !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 10px !important;
    transition: all 0.2s ease-in-out !important;
    margin-top: 10px !important;
    box-shadow: 0 4px 14px rgba(240, 45, 0, 0.2) !important;
}

.order-submit-btn:hover {
    background: linear-gradient(135deg, #F02D00, #C22000) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(240, 45, 0, 0.3) !important;
}

.order-submit-btn:focus {
    outline: none !important;
    box-shadow: 0 0 0 4px rgba(255, 94, 54, 0.4) !important;
}

@media (max-width: 850px) {
    .order-submit-btn {
        border-radius: 12px !important;
        margin-top: 15px !important;
        padding: 16px 20px !important;
    }
    .order-field {
        padding: 0 !important;
    }
}

@media (max-width: 500px) {
    .cart-drawer {
        width: 100% !important;
        right: -100% !important;
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }
    .cart-drawer.active {
        right: 0 !important;
    }
    .cart-drawer-header {
        padding: 18px 20px !important;
    }
    .cart-drawer-title {
        font-size: 1.3rem !important;
    }
    .cart-drawer-body {
        padding: 20px !important;
    }
    .cart-drawer-footer {
        padding: 20px !important;
    }
    .cart-item-row {
        padding: 12px 0 !important;
    }
    .cart-item-title {
        font-size: 0.9rem !important;
    }
}

/* ===========================================
   HOW TO PROCESS SECTION
   =========================================== */
.how-inner {
    margin-top: 0;
}

.how-inner .section-header {
    margin-bottom: 50px;
}

.how-inner .section-eyebrow {
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    background: linear-gradient(135deg, #C59341 0%, #E2B96B 50%, #C59341 100%) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    color: #C59341 !important;
    text-shadow: none !important;
    border: 1px solid rgba(197, 147, 65, 0.4) !important;
    border-radius: 30px;
    padding: 6px 18px;
    display: inline-block;
    margin-bottom: 15px;
}

.how-inner .section-eyebrow::before,
.how-inner .section-eyebrow::after {
    display: none !important;
}

.how-inner .section-title {
    font-size: 3rem;
    font-weight: 800;
    color: #0c689b !important;
    -webkit-text-fill-color: #0c689b !important;
    background: transparent !important;
    text-shadow: none !important;
    margin-bottom: 20px;
}

.how-inner .section-title span {
    background: linear-gradient(135deg, #C59341 0%, #E2B96B 50%, #C59341 100%) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    color: #C59341 !important;
}

.how-inner .section-bar {
    width: 60px;
    height: 3px;
    background: linear-gradient(135deg, #C59341 0%, #E2B96B 100%) !important;
    display: inline-block;
    border-radius: 2px;
}

.how-steps {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    position: relative;
}

.how-steps::before {
    content: '';
    position: absolute;
    top: 45px;
    left: 12%;
    right: 12%;
    height: 2px;
    background: rgba(0, 0, 0, 0.05);
    z-index: 1;
}

.step-item {
    position: relative;
    z-index: 2;
    text-align: center;
}

.step-num-wrap {
    width: 90px;
    height: 90px;
    background: #ffffff !important;
    border: 2px solid rgba(197, 147, 65, 0.3) !important;
    border-radius: 50%;
    margin: 0 auto 25px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.step-item:hover .step-num-wrap {
    border-color: #C59341 !important;
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(197, 147, 65, 0.2);
}

.step-num {
    font-size: 28px;
    font-weight: 900;
    background: linear-gradient(135deg, #C59341 0%, #E2B96B 50%, #C59341 100%) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    color: #C59341 !important;
    line-height: 1;
}

.step-icon-layer {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #C59341 0%, #E2B96B 100%) !important;
    color: #ffffff !important;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    box-shadow: 0 5px 15px rgba(197, 147, 65, 0.4);
}

.step-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: #0c689b !important;
    margin-bottom: 10px;
}

.step-desc {
    font-size: 0.95rem;
    color: #000000 !important;
    line-height: 1.6;
    padding: 0 10px;
}

@media (max-width: 991px) {
    .how-steps {
        grid-template-columns: repeat(2, 1fr);
        gap: 50px 30px;
    }
    .how-steps::before {
        display: none;
    }
}

@media (max-width: 768px) {
    .how-inner .section-title {
        font-size: 2.2rem;
    }
    .how-steps {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    .how-steps::before {
        display: block;
        width: 2px;
        height: 80%;
        left: 50%;
        top: 10%;
        transform: translateX(-50%);
        background: rgba(255, 255, 255, 0.15);
    }
}

/* Table Stretch Override to Full Screen Width */
.estimate-content .table-wrap {
    width: 100% !important;
    max-width: 100% !important;
    padding: 0 !important;
    border: none !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    background: transparent !important;
    margin: 40px 0 0 0 !important;
}
.estimate-content table {
    width: 100% !important;
    border-collapse: collapse !important;
}
</style>
@endpush

@php
    $priceList = \App\Models\PriceList::first();
    $global_settings = \App\Models\HomeSetting::first();
    $minOrder = $global_settings->min_order_value ?? 0;
    $globalGst = $global_settings->global_gst ?? 0;
    $globalSettingModel = \App\Models\GlobalSetting::first();
    $showDiscount = $globalSettingModel->show_discount ?? true;
@endphp

<div class="estimate-page">

    <!-- 1. CINEMATIC HERO -->
    <section class="estimate-hero" style="height: 55vh;">
        <div class="hero-parallax-bg" style="background-image: url('{{ asset('assets/img/contact-premium.png') }}'); background-size: cover; background-position: center;"></div>
        <div class="hero-overlay"></div>
        <div class="container relative z-10 text-center">
            <h1 class="hero-title wow fadeInUp">Price <span>Estimate</span></h1>
            <p class="hero-sub wow fadeInUp" data-wow-delay="0.2s">Direct Sivakasi wholesale rates at your fingertips.</p>
        </div>
    </section>

    <!-- HOW TO PROCESS -->
    <section class="how-to-process-section" style="padding: 80px 0; background: #f7f7f8;">
        <div class="container relative z-10 text-center">
            <div class="how-inner">
                <div class="section-header text-center">
                    <span class="section-eyebrow">Simple Process</span>
                    <h2 class="section-title">How to <span>Process</span></h2>
                    <span class="section-bar"></span>
                </div>

                <div class="how-steps">
                    @php
                    $default_steps = [
                    ['num' => '01', 'icon' => 'fa-solid fa-file-arrow-down', 'title' => 'Download Price List', 'desc' => 'Get our full product catalogue with festival discount prices instantly.'],
                    ['num' => '02', 'icon' => 'fa-solid fa-cart-shopping', 'title' => 'Choose Your Products', 'desc' => 'Select from 200+ products — sparklers, aerial shells, gift boxes & more.'],
                    ['num' => '03', 'icon' => 'fa-brands fa-whatsapp', 'title' => 'Place Order via WhatsApp', 'desc' => 'Send us your list on WhatsApp and confirm your delivery address.'],
                    ['num' => '04', 'icon' => 'fa-solid fa-truck-fast', 'title' => 'Fast Pan India Delivery', 'desc' => 'We ship directly from Sivakasi. Safe packaging, on-time delivery guaranteed.'],
                    ];

                    $raw_steps = $settings->order_steps ?? [];
                    $steps = [];

                    foreach($default_steps as $i => $ds) {
                    $steps[] = [
                    'num' => $ds['num'],
                    'icon' => $ds['icon'],
                    'title' => $raw_steps[$i]['title'] ?? $ds['title'],
                    'desc' => $raw_steps[$i]['desc'] ?? $ds['desc'],
                    ];
                    }
                    @endphp
                    @foreach($steps as $step)
                    <div class="step-item">
                        <div class="step-num-wrap">
                            <span class="step-num">{{ $step['num'] }}</span>
                            <div class="step-icon-layer"><i class="{{ $step['icon'] }}"></i></div>
                        </div>
                        <div class="step-title">{{ $step['title'] }}</div>
                        <div class="step-desc">{{ $step['desc'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    <!-- 2. PRODUCTION SELECTION -->
    <section class="estimate-content">
        <div class="container">
            
            <!-- FLOATING SUMMARY (Moved here for natural flow) -->
            <div id="dynamicSummary" class="top-summary wow fadeInUp">
                <div class="summary-item">
                    <div class="summary-icon"><i class="fa-solid fa-receipt"></i></div>
                    <div class="summary-info">
                        <span class="summary-label">Net Total</span>
                        <span class="summary-value notranslate">₹<span id="netTotal">0</span></span>
                    </div>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-item">
                    <div class="summary-icon" style="background: #2ecc71;"><i class="fa-solid fa-piggy-bank"></i></div>
                    <div class="summary-info">
                        <span class="summary-label">Total Gained</span>
                        <span class="summary-value">₹<span id="youSave">0</span></span>
                    </div>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-item">
                    <div class="summary-icon" style="background: var(--ink);"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                    <div class="summary-info">
                        <span class="summary-label">Final Value</span>
                        <span class="summary-value">₹<span id="overallTotal">0</span></span>
                    </div>
                </div>

                <div class="summary-divider"></div>

                <button class="order-now-btn" onclick="openCart()">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Order Now</span>
                    <div class="cart-count-pill" id="cartCount">0</div>
                </button>
            </div>

            <div class="search-wrap wow fadeInUp">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Search for crackers (e.g. Sparklers, Chakkars)...">
                <button type="button" id="clearSearchBtn" class="clear-search-btn" title="Clear Filter"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>

        <div class="table-wrap wow fadeInUp" data-wow-delay="0.1s">
            <table>
                    <thead class="notranslate">
                        <tr>
                            <th><i class="fa-solid fa-camera"></i></th>
                            <th>Product Details</th>
                            <th>Box Content</th>
                            <th>MRP</th>
                            <th>Discount</th>
                            <th>Offer Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="productTable">
                        @foreach($categories as $category)
                            @if($category->products->count() > 0)
                                <tr class="category notranslate" data-category="{{ strtolower($category->category_name) }}">
                                    <td colspan="8"><i class="fa-solid fa-tags" style="color: #B8860B; margin-right: 8px;"></i> {{ strtoupper($category->category_name) }}</td>
                                </tr>
                                @foreach($category->products as $product)
                                    <tr class="product-row" data-product-id="{{ $product->id }}" data-product-content="{{ $product->product_content }}" data-category="{{ strtolower($category->category_name) }}" data-mrp="{{ $product->product_mrp_price }}" data-gst="{{ $product->product_gst !== null && $product->product_gst !== '' ? $product->product_gst : '' }}" data-gst-active="{{ $product->is_product_gst_active ?? 1 }}">
                                        <td>
                                            <img src="{{ $product->product_image ? env('MAIN_URL') . $product->product_image : 'https://via.placeholder.com/100' }}" alt="{{ $product->product_name }}" loading="lazy">
                                        </td>
                                        <td class="product-name">{{ $product->product_name }}</td>
                                        <!-- <td>
                                            {{-- Video button removed for estimate page --}}
                                        </td> -->
                                        <td class="rowTotal notranslate">{{ $product->product_content }}</td>
                                        @php
                                            $mrp = floatval($product->product_mrp_price);
                                            $regular = floatval($product->product_regular_price);
                                        @endphp
                                        <td class="actual notranslate">
                                            {{ $product->product_mrp_price }}
                                        </td>
                                        <td class="notranslate" style="text-align: center; font-weight: 700; color: #16A34A;">
                                            @if($showDiscount && $mrp > $regular && $mrp > 0)
                                                {{ round((($mrp - $regular) / $mrp) * 100) }}% OFF
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="price notranslate">{{ $product->product_regular_price }}</td>
                                        <td>
                                            <div class="qty-wrapper">
                                                <button type="button" class="qty-minus qty-btn"><i class="fa-solid fa-minus"></i></button>
                                                <input type="number" class="qty" value="0" min="0" max="999">
                                                <button type="button" class="qty-plus qty-btn"><i class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </td>
                                        <td class="rowTotal notranslate">0</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
    </section>

    <!-- 4. CART DRAWER -->
    <div class="cart-drawer" id="cartDrawer">
        <div class="cart-drawer-header">
            <div class="cart-drawer-title"><i class="fa-solid fa-receipt"></i> Order Summary</div>
            <button class="cart-close-btn" onclick="closeCart()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="cart-drawer-body" id="cartDrawerBody">
            <!-- Items injected by Calculate() -->
        </div>
        <div class="cart-drawer-footer">
            @if($minOrder > 0)
                <div class="min-order-wrap" id="minOrderWrap">
                    <div class="min-order-top">
                        <span class="min-order-label">Minimum Target</span>
                        <span class="min-order-value">₹{{ number_format($minOrder, 0) }}</span>
                    </div>
                    <div class="min-order-bar-track">
                        <div class="min-order-bar-fill" id="minOrderBar"></div>
                    </div>
                    <div class="order-status" id="minOrderStatus"></div>
                </div>
            @endif
            <div class="cart-summary-rows">
                <div class="cart-summary-row"><span>Max Retail Price</span><span id="cartActual">₹0</span></div>
                <div class="cart-summary-row" id="cartGstRow" style="display:none; color: #555; font-weight: 700; margin-top:10px;"><span>GST</span><span id="cartGstAmount">₹0</span></div>
                <div class="cart-summary-row" style="color: #16A34A; font-weight: 700; margin-top:10px;"><span>Your Savings</span><span id="cartSave">- ₹0</span></div>
                
                @if(!empty($globalCharges['extra_charge_1_name']) && floatval($globalCharges['extra_charge_1_amount'] ?? 0) > 0)
                    <div class="cart-summary-row" style="color: #475569; font-weight: 600; margin-top:5px;">
                        <span>{{ $globalCharges['extra_charge_1_name'] }}</span>
                        <span id="extraCharge1Val">₹{{ number_format(floatval($globalCharges['extra_charge_1_amount']), 2) }}</span>
                    </div>
                @endif
                
                @if(!empty($globalCharges['extra_charge_2_name']) && floatval($globalCharges['extra_charge_2_amount'] ?? 0) > 0)
                    <div class="cart-summary-row" style="color: #475569; font-weight: 600; margin-top:5px;">
                        <span>{{ $globalCharges['extra_charge_2_name'] }}</span>
                        <span id="extraCharge2Val">₹{{ number_format(floatval($globalCharges['extra_charge_2_amount']), 2) }}</span>
                    </div>
                @endif


                <div class="cart-summary-row total"><span>Net Amount</span><span id="cartNet">₹0</span></div>
            </div>
            <button class="btn-gold" id="confirmOrderBtn" onclick="openCheckoutModal()">
                <span>Proceed to Checkout</span> <i class="fa-solid fa-arrow-right"></i>
            </button>
            <button class="btn-gold" id="generateOtpBtn" onclick="triggerOtpGeneration()" style="display:none; background:linear-gradient(135deg, #16A34A, #15803d);">
                <span>Generate OTP</span> <i class="fa-solid fa-paper-plane"></i>
            </button>
            <button class="btn-continue" id="continueShopBtn" onclick="closeCart()" style="display:none; width:100%; margin-top:10px; border:none; background:none; font-weight:800; color:var(--muted); cursor:pointer;">
                Continue Selecting
            </button>
        </div>
    </div>

    <!-- 5. MOBILE PILL -->
    <a href="javascript:void(0)" class="mobile-sticky-bar" onclick="openCart()">
        <div class="msb-left">
            <div class="msb-cart-icon">
                <i class="fa-solid fa-cart-shopping"></i>
                <div class="msb-count" id="msbCount">0</div>
            </div>
            <div class="msb-info">
                <span class="msb-label">Grand Total</span>
                <span class="msb-total" id="msbTotal">₹0</span>
            </div>
        </div>
        <div class="msb-btn">Checkout</div>
    </a>

    <!-- 6. NEW CHECKOUT MODAL -->
    <div id="checkoutModal" class="order-modal-overlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(5px); z-index:1999; align-items:center; justify-content:center;">
        <div class="order-modal-box" style="background:#fff; width:90%; max-width:500px; max-height:90vh; overflow-y:auto; border-radius:20px; padding:30px; position:relative; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
            <button onclick="closeCheckoutModal()" class="order-modal-close notranslate" style="position:absolute; top:15px; right:20px; background:none; border:none; font-size:24px; cursor:pointer; z-index:10; color:#333;">&times;</button>
            
            <div class="order-modal-header" style="text-align:center;">
                <div class="order-modal-eyebrow" style="color:#B8860B; font-size:12px; letter-spacing:2px; font-weight:800; text-transform:uppercase;">Final Step</div>
                <h2 class="order-modal-title" style="margin:5px 0; font-family:'Cormorant Garamond', serif; font-size:28px;">Checkout Details</h2>
                <div class="order-modal-bar" style="width:40px; height:3px; background:#B8860B; margin:15px auto;"></div>
            </div>

            <form id="checkoutForm" onsubmit="submitCheckoutDetails(event)" style="margin-top:20px;">
                <div class="order-field" style="margin-bottom:15px;">
                    <label class="order-label" style="display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:5px;">FULL NAME *</label>
                    <input type="text" id="checkoutName" required placeholder="John Doe" class="order-input" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" pattern="^[A-Za-z\s]+$" title="Only alphabets and spaces are allowed" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                </div>
                
                <div class="order-field" style="margin-bottom:15px;">
                    <label class="order-label" style="display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:5px;">PHONE NUMBER *</label>
                    <input type="text" id="checkoutPhone" required placeholder="+91 00000 00000" class="order-input" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" pattern="(\+91)?[6-9][0-9]{9}" title="Enter a valid 10-digit Indian mobile number starting with 6-9 (e.g. 9876543210 or +919876543210)" oninput="let v = this.value.replace(/[^\+0-9]/g, ''); if(v.startsWith('+91')){ this.value = v.substring(0,13); } else { this.value = v.replace(/\+/g, '').substring(0,10); }">
                </div>

                <div class="order-field" style="margin-bottom:15px;">
                    <label class="order-label" style="display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:5px;">EMAIL ADDRESS *</label>
                    <input type="email" id="checkoutEmail" required placeholder="john@example.com" class="order-input" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" title="Please enter a valid email address">
                </div>

                <div class="order-field" style="margin-bottom:15px;">
                    <label class="order-label" style="display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:5px;">STREET ADDRESS *</label>
                    <textarea id="checkoutAddress" required rows="2" placeholder="Door No, Street Name, Landmark..." class="order-input" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; resize:vertical; min-height:80px;" minlength="10" title="Please enter a detailed address (minimum 10 characters)"></textarea>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:15px;">
                    <div class="order-field">
                        <label class="order-label" style="display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:5px;">STATE *</label>
                        <select id="checkoutState" required class="order-input" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; background-color:#fff;" onchange="handleStateChange()">
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->state }}" data-code="{{ $state->id }}">{{ $state->state }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="order-field">
                        <label class="order-label" style="display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:5px;">CITY *</label>
                        <select id="checkoutCity" required class="order-input" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; background-color:#fff;" onchange="handleCityChange()">
                            <option value="">Select City</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->city_name }}" data-id="{{ $city->id }}" data-state="{{ $city->state_code }}">{{ $city->city_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="order-field" style="margin-bottom:25px;">
                    <label class="order-label" style="display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:5px;">PINCODE *</label>
                    <input type="text" id="checkoutPincode" required placeholder="600001" class="order-input" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;" pattern="[0-9]{6}" maxlength="6" title="Enter a valid 6-digit Pincode" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                
                <div id="checkoutError" style="color:red; font-size:13px; text-align:center; margin-bottom:15px; display:none;"></div>

                <button type="submit" id="checkoutSubmitBtn" class="order-submit-btn" style="width:100%; padding:15px; background:linear-gradient(135deg, #0c689b, #043048); color:#fff; border:none; border-radius:50px; font-weight:800; text-transform:uppercase; cursor:pointer;">
                     <span>Submit</span> <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- 7. OTP VERIFICATION MODAL -->
    <div id="otpModal" class="order-modal-overlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(5px); z-index:2000; align-items:center; justify-content:center;">
        <div class="order-modal-box" style="background:#fff; width:90%; max-width:400px; border-radius:20px; padding:30px; position:relative; text-align:center;">
            <button onclick="closeOtpModal()" class="order-modal-close notranslate" style="position:absolute; top:15px; right:20px; background:none; border:none; font-size:24px; cursor:pointer;">&times;</button>
            <div class="order-modal-header">
                <i class="fa-solid fa-envelope-circle-check" style="font-size:40px; color:#16A34A; margin-bottom:15px;"></i>
                <h2 class="order-modal-title" style="margin:5px 0; font-family:'Outfit', sans-serif; font-size:24px; font-weight:800;">Verify OTP</h2>
                <p style="font-size:14px; color:#666; margin-top:5px;">Enter the 4-digit code shown below.</p>
                <div id="generatedOtpDisplay" style="font-size: 20px; font-weight: bold; color: #0c689b; margin: 15px 0; padding: 10px; background: #f0f8ff; border: 1px dashed #0c689b; border-radius: 8px; display: none;"></div>
            </div>

            <form id="otpForm" onsubmit="verifyOtpSubmit(event)" style="margin-top:20px;">
                <div class="order-field" style="margin-bottom:20px; display:flex; justify-content:center;">
                    <input type="text" id="otpInput" required placeholder="0000" maxlength="4" style="width:150px; text-align:center; margin:0 auto; display:block; font-size:24px; letter-spacing:8px; padding:12px; border:2px solid #ddd; border-radius:8px; font-weight:800;" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                
                <div id="otpError" style="color:red; font-size:13px; margin-bottom:15px; display:none;"></div>

                <button type="submit" id="otpSubmitBtn" class="order-submit-btn" style="width:100%; padding:15px; background:linear-gradient(135deg, #16A34A, #108038); color:#fff; border:none; border-radius:50px; font-weight:800; text-transform:uppercase; cursor:pointer;">
                     <span>Verify & Order</span> <i class="fa-solid fa-check"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- 8. SUCCESS MODAL -->
    <div id="successModal" class="order-modal-overlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(8px); z-index:2005; align-items:center; justify-content:center;">
        <div class="order-modal-box" style="background:#fff; width:90%; max-width:500px; border-radius:25px; padding:40px; position:relative; text-align:center; box-shadow:0 30px 60px rgba(0,0,0,0.2);">
            <div style="width:80px; height:80px; background:#f4fbf7; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                <i class="fa-solid fa-check" style="font-size:40px; color:#16A34A;"></i>
            </div>
            
            <h2 class="order-modal-title" style="margin:5px 0 15px; font-family:'Cormorant Garamond', serif; font-size:32px; font-weight:700; color:#101010;">Thank You!</h2>
            
            <p style="font-size:15px; color:#555; line-height:1.6; margin-bottom:30px;">
                Your order estimate has been securely forwarded to our team via WhatsApp. We will review your selections and get back to you shortly. Your details have been safely stored.
            </p>

            <button onclick="window.location.reload()" class="order-submit-btn" style="width:100%; padding:15px; background:linear-gradient(135deg, #0c689b, #043048); color:#fff; border:none; border-radius:50px; font-weight:800; text-transform:uppercase; cursor:pointer; letter-spacing:1px;">
                 Continue Shopping
            </button>
        </div>
    </div>
</div>

<div id="cartOverlay" class="cart-overlay" style="position:fixed; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(5px); z-index:1998; display:none;" onclick="closeCart()"></div>

<div id="loading" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:9999; align-items:center; justify-content:center; color:#fff; flex-direction:column;">
    <div class="spinner-border text-warning" role="status"></div>
    <p class="mt-3">Processing your estimate...</p>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const MIN_ORDER = {{ $minOrder }};
    const GLOBAL_GST = {{ $globalGst }};
    let extraCharge1 = {{ floatval($globalCharges['extra_charge_1_amount'] ?? 0) }};
    let extraCharge2 = {{ floatval($globalCharges['extra_charge_2_amount'] ?? 0) }};

    function handleStateChange() {
        const stateSelect = document.getElementById("checkoutState");
        const citySelect = document.getElementById("checkoutCity");
        const selectedState = stateSelect.options[stateSelect.selectedIndex]?.dataset.code;

        Array.from(citySelect.options).forEach(option => {
            if (option.value === "") {
                option.style.display = "block";
            } else if (selectedState && option.dataset.state !== selectedState) {
                option.style.display = "none";
            } else {
                option.style.display = "block";
            }
        });
        citySelect.value = "";
        handleCityChange();
    }

    function handleCityChange() {
        calculate();
    }

    document.addEventListener("DOMContentLoaded", function () {

        // Quantity Controls
        document.querySelectorAll(".qty").forEach(input => {
            input.addEventListener("input", function () {
                let value = Math.max(0, Math.min(999, parseInt(this.value) || 0));
                this.value = value;
                calculate();
            });
        });

        document.querySelectorAll('.qty-minus').forEach(btn => {
            btn.addEventListener('click', function () {
                let input = this.nextElementSibling;
                input.value = Math.max(0, (parseInt(input.value) || 0) - 1);
                input.dispatchEvent(new Event('input'));
            });
        });

        document.querySelectorAll('.qty-plus').forEach(btn => {
            btn.addEventListener('click', function () {
                let input = this.previousElementSibling;
                input.value = Math.min(999, (parseInt(input.value) || 0) + 1);
                input.dispatchEvent(new Event('input'));
            });
        });

        // Search Logic
        const searchInput = document.getElementById("searchInput");
        const clearBtn = document.getElementById("clearSearchBtn");

        searchInput.addEventListener("keyup", function () {
            const value = this.value.toLowerCase();
            
            // Toggle Clear Button
            if (value.length > 0) {
                clearBtn.classList.add("active");
            } else {
                clearBtn.classList.remove("active");
            }

            document.querySelectorAll(".product-row").forEach(row => {
                const name = row.querySelector(".product-name").innerText.toLowerCase();
                const category = row.getAttribute("data-category") || "";
                
                row.style.display = (value.length === 0 || name.includes(value) || category.includes(value)) ? "" : "none";
            });

            // Hide categories if no products visible
            document.querySelectorAll(".category").forEach(catRow => {
                let next = catRow.nextElementSibling;
                let hasVisible = false;
                while(next && !next.classList.contains('category')) {
                    if(next.style.display !== 'none') { 
                        hasVisible = true; 
                        break; 
                    }
                    next = next.nextElementSibling;
                }
                catRow.style.display = hasVisible ? "" : "none";
            });
        });

        // Clear Filter Button
        clearBtn.addEventListener("click", function() {
            searchInput.value = "";
            searchInput.dispatchEvent(new Event("keyup"));
            
            // Clear the URL parameter without reloading the page
            const url = new URL(window.location);
            if (url.searchParams.has('category')) {
                url.searchParams.delete('category');
                window.history.replaceState({}, '', url);
            }
        });

        // URL Parameter Filtering
        const urlParams = new URLSearchParams(window.location.search);
        const categoryFilter = urlParams.get('category');
        if (categoryFilter) {
            searchInput.value = categoryFilter;
            searchInput.dispatchEvent(new Event("keyup"));
            
            setTimeout(() => {
                const table = document.querySelector('.table-wrap');
                if (table) table.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 500);
        }

        // Parallax & Dynamic Summary Logic
        window.addEventListener('scroll', () => {
            const bg = document.querySelector('.hero-parallax-bg');
            if (bg) bg.style.transform = `scale(1.1) translateY(${window.scrollY * 0.3}px)`;
            
            // Toggle Sticky Summary
            const summary = document.getElementById('dynamicSummary');
            if (window.scrollY > 450) {
                summary.classList.add('is-sticky');
            } else {
                summary.classList.remove('is-sticky');
            }
        });
    });

    // Cache products DOM elements and parsed data
    let cachedProducts = [];
    let isProductsCached = false;

    function cacheProductsIfNeeded() {
        if (isProductsCached) return;
        cachedProducts = [];
        document.querySelectorAll(".product-row").forEach(row => {
            const qtyInput = row.querySelector(".qty");
            const price = parseFloat(row.querySelector(".price").innerText) || 0;
            const actual = parseFloat(row.querySelector(".actual").innerText) || 0;
            const mrp = parseFloat(row.dataset.mrp) || 0;
            const productGstAttr = row.dataset.gst;
            const isGstActive = row.dataset.gstActive === "1";
            const gstPercent = (isGstActive && productGstAttr !== "") ? parseFloat(productGstAttr) : GLOBAL_GST;
            const rowTotalElement = row.querySelector(".rowTotal");
            const name = row.querySelector(".product-name").innerText;

            cachedProducts.push({
                rowElement: row,
                qtyInput: qtyInput,
                price: price,
                actual: actual,
                mrp: mrp,
                gstPercent: gstPercent,
                rowTotalElement: rowTotalElement,
                name: name
            });
        });
        isProductsCached = true;
    }

    function calculate() {
        cacheProductsIfNeeded();

        let netTotal = 0, actualTotal = 0, cartCount = 0, totalGst = 0;
        let cartItemsHtml = '';

        cachedProducts.forEach(item => {
            const qty = parseInt(item.qtyInput.value) || 0;
            const rowTotal = qty * item.price;
            const actualRow = qty * item.actual;

            const formattedTotal = rowTotal.toFixed(2);
            if (item.rowTotalElement.innerText !== formattedTotal) {
                item.rowTotalElement.innerText = formattedTotal;
            }

            netTotal += rowTotal;
            actualTotal += actualRow;

            const itemGst = (qty * item.mrp * item.gstPercent) / 100;
            totalGst += itemGst;

            if (qty > 0) {
                cartCount++;
                cartItemsHtml += `
                    <div class="cart-item-row">
                        <div class="cart-item-info">
                            <div class="cart-item-title">${item.name}</div>
                            <div class="cart-item-meta-value">${qty} x ₹${item.price.toFixed(2)}</div>
                        </div>
                        <div class="cart-item-total-price">₹${rowTotal.toFixed(2)}</div>
                    </div>
                `;
            }
        });

        document.getElementById("netTotal").innerText = netTotal.toLocaleString('en-IN');
        document.getElementById("overallTotal").innerText = netTotal.toLocaleString('en-IN');
        document.getElementById("youSave").innerText = (actualTotal - netTotal).toLocaleString('en-IN');
        document.getElementById("cartCount").innerText = cartCount;

        let additionalCharge = extraCharge1 + extraCharge2;
        const netWithCharge = netTotal + additionalCharge + totalGst;

        document.getElementById("cartActual").innerText = '₹' + actualTotal.toLocaleString('en-IN');
        document.getElementById("cartSave").innerText = '- ₹' + (actualTotal - netTotal).toLocaleString('en-IN');
        
        const gstRow = document.getElementById("cartGstRow");
        if (totalGst > 0) {
            gstRow.style.display = "flex";
            document.getElementById("cartGstAmount").innerText = '₹' + totalGst.toLocaleString('en-IN', { maximumFractionDigits: 2 });
        } else {
            gstRow.style.display = "none";
        }
        
        document.getElementById("cartNet").innerText = '₹' + netWithCharge.toLocaleString('en-IN', { maximumFractionDigits: 2 });

        // Update Mobile Summary
        const msbTotal = document.getElementById("msbTotal");
        const msbCount = document.getElementById("msbCount");
        if (msbTotal) msbTotal.innerText = '₹' + netWithCharge.toLocaleString('en-IN');
        if (msbCount) msbCount.innerText = cartCount;

        updateMinOrderWidget(netWithCharge);

        document.getElementById("cartDrawerBody").innerHTML = cartCount > 0 ? cartItemsHtml : '<div class="text-center py-5 opacity-50">Your selection is empty</div>';
    }

    function updateMinOrderWidget(netTotal) {
        if (MIN_ORDER <= 0) return;
        const bar = document.getElementById('minOrderBar');
        const status = document.getElementById('minOrderStatus');
        const confirmBtn = document.getElementById('confirmOrderBtn');
        const continueBtn = document.getElementById('continueShopBtn');
        
        const pct = Math.min((netTotal / MIN_ORDER) * 100, 100);
        const met = netTotal >= MIN_ORDER;
        bar.style.width = pct + '%';
        
        if (met) {
            status.innerHTML = '<span style="color:#16A34A; font-weight: 700;">✅ Minimum order requirement met!</span>';
            confirmBtn.disabled = false;
            confirmBtn.style.opacity = '1';
            if (continueBtn) continueBtn.style.display = 'none';
        } else {
            const diff = MIN_ORDER - netTotal;
            status.innerHTML = `Add ₹${diff.toLocaleString('en-IN')} more to proceed`;
            confirmBtn.disabled = true;
            confirmBtn.style.opacity = '0.5';
            if (continueBtn && netTotal > 0) continueBtn.style.display = 'block';
        }
    }

    function openCart() {
        document.getElementById("cartDrawer").classList.add("active");
        document.getElementById("cartOverlay").style.display = "block";
    }

    function closeCart() {
        document.getElementById("cartDrawer").classList.remove("active");
        document.getElementById("cartOverlay").style.display = "none";
    }

    function openCheckoutModal() {
        const netValue = parseFloat(document.getElementById("cartNet")?.innerText.replace(/[^0-9.-]+/g,"") || 0);
        if (netValue < MIN_ORDER) {
            Swal.fire('Oops!', `Minimum order value is ₹${MIN_ORDER}. Please add more items.`, 'warning');
            return;
        }
        closeCart();
        document.getElementById("checkoutModal").style.display = "flex";
    }

    function closeCheckoutModal() { 
        document.getElementById("checkoutModal").style.display = "none"; 
        document.getElementById("checkoutError").style.display = "none";
        openCart();
    }

    function closeOtpModal() { 
        document.getElementById("otpModal").style.display = "none"; 
        document.getElementById("otpError").style.display = "none";
    }

    function submitCheckoutDetails(e) {
        e.preventDefault();
        const submitBtn = document.getElementById("checkoutSubmitBtn");
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
        
        setTimeout(() => {
            document.getElementById("confirmOrderBtn").style.display = "none";
            document.getElementById("generateOtpBtn").style.display = "flex";
            closeCheckoutModal();
            submitBtn.innerHTML = '<span>Submit</span> <i class="fa-solid fa-arrow-right"></i>';
        }, 500);
    }

    function triggerOtpGeneration() {
        const name = document.getElementById("checkoutName").value.trim();
        const phone = document.getElementById("checkoutPhone").value.trim();
        const email = document.getElementById("checkoutEmail").value.trim();
        const address = document.getElementById("checkoutAddress").value.trim();
        const state = document.getElementById("checkoutState").value.trim();
        const city = document.getElementById("checkoutCity").value.trim();
        const pincode = document.getElementById("checkoutPincode").value.trim();
        
        const packingChecked = document.getElementById("radioPacking")?.checked;
        const shippingChecked = document.getElementById("radioShipping")?.checked;
        
        let chargeType = null;
        let chargeAmount = 0;
        if (packingChecked) {
            chargeType = 'packing';
            chargeAmount = currentPackingPrice;
        } else if (shippingChecked) {
            chargeType = 'shipping';
            chargeAmount = currentShippingPrice;
        }

        const btn = document.getElementById("generateOtpBtn");
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';

        fetch('/send-otp', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ 
                name, phone, email, address, state, city, pincode
            })
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<span>Generate OTP</span> <i class="fa-solid fa-paper-plane"></i>';
            if (data.success) {
                closeCart();
                const otpDisplay = document.getElementById("generatedOtpDisplay");
                if (otpDisplay) {
                    otpDisplay.innerText = "Your OTP is: " + data.otp;
                    otpDisplay.style.display = "block";
                }
                document.getElementById("otpModal").style.display = "flex";
            } else {
                Swal.fire('Error', data.message || "Failed to send OTP.", 'error');
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerHTML = '<span>Generate OTP</span> <i class="fa-solid fa-paper-plane"></i>';
            Swal.fire('Error', "Network error. Please try again.", 'error');
        });
    }

    function verifyOtpSubmit(e) {
        e.preventDefault();
        
        const otp = document.getElementById("otpInput").value.trim();
        const errorDiv = document.getElementById("otpError");
        const submitBtn = document.getElementById("otpSubmitBtn");

        const cartData = getSelectedCartItems();

        let additionalCharge = extraCharge1 + extraCharge2;

        const totalGst = cartData.reduce((sum, item) => sum + item.item_gst, 0);
        const actualTotal = cartData.reduce((sum, item) => sum + item.mrp_total, 0);
        const subTotalValue = cartData.reduce((sum, item) => sum + item.total, 0);
        const netValue = subTotalValue + additionalCharge + totalGst;
        
        errorDiv.style.display = "none";
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Verifying... <i class="fa-solid fa-spinner fa-spin"></i>';

        fetch('/verify-otp', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ 
                otp: otp,
                cart_data: JSON.stringify(cartData),
                sub_total: actualTotal,
                total: netValue
            })
        })
        .then(response => response.json())
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Verify & Order</span> <i class="fa-solid fa-check"></i>';
            if (data.success) {
                closeOtpModal();
                if (data.pdf_url) {
                    const iframe = document.createElement('iframe');
                    iframe.style.display = 'none';
                    iframe.src = data.pdf_url + '?download=1';
                    document.body.appendChild(iframe);
                }
                
                document.getElementById("successModal").style.display = "flex"; // Open success modal
                
                // Clear the cart
                document.querySelectorAll(".qty").forEach(input => {
                    input.value = 0;
                });
                calculate();
            } else {
                errorDiv.innerText = data.message || "Invalid OTP.";
                errorDiv.style.display = "block";
            }
        })
        .catch(error => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Verify & Order</span> <i class="fa-solid fa-check"></i>';
            errorDiv.innerText = "Network error. Please try again.";
            errorDiv.style.display = "block";
        });
    }

    function getSelectedCartItems() {
        cacheProductsIfNeeded();
        const cartData = [];
        cachedProducts.forEach(item => {
            const qty = parseInt(item.qtyInput.value) || 0;
            if (qty > 0) {
                cartData.push({
                    product_id: item.rowElement.dataset.productId,
                    product_name: item.name.trim(),
                    content: item.rowElement.dataset.productContent || '',
                    category: item.rowElement.dataset.category || '',
                    qty: qty,
                    price: item.price,
                    actual: item.actual,
                    total: qty * item.price,
                    mrp_total: qty * item.actual,
                    item_gst: (qty * item.mrp * item.gstPercent) / 100
                });
            }
        });
        return cartData;
    }

    function sendWhatsAppOrder(whatsappTab = null, chargeType = null, chargeAmount = 0, pdfUrl = null) {
        const netValue = parseFloat(document.getElementById("cartNet").innerText.replace(/[^0-9.-]+/g,"")) || 0;
        if (netValue < MIN_ORDER) {
            Swal.fire('Oops!', `Minimum order value is ₹${MIN_ORDER}. Please add more items.`, 'warning');
            if(whatsappTab) whatsappTab.close();
            return;
        }

        const cartData = getSelectedCartItems();
        if (!cartData.length) {
            Swal.fire('Oops!', 'Please add products before checkout.', 'warning');
            if(whatsappTab) whatsappTab.close();
            return;
        }

        const actualTotal = cartData.reduce((sum, item) => sum + item.mrp_total, 0);
        const savings = actualTotal - netValue;
        
        // Append customer details to WhatsApp message
        const name = document.getElementById("checkoutName").value.trim();
        const phone = document.getElementById("checkoutPhone").value.trim();
        
        let lines = [
            'Hello, I have placed an order.',
            '',
            `Name: ${name}`,
            `Phone: ${phone}`
        ];

        if (pdfUrl) {
            lines.push('');
            lines.push(`You can view and download my order invoice PDF here:`);
            lines.push(pdfUrl);
        }

        const whatsappUrl = `https://wa.me/916380195167?text=${encodeURIComponent(lines.join('\n'))}`;
        if(whatsappTab) {
            whatsappTab.location.href = whatsappUrl;
        } else {
            window.open(whatsappUrl, '_blank');
        }
        
        // Optional: clear cart or refresh page after successful order placement
        // setTimeout(() => window.location.reload(), 2000);
    }
</script>
@endpush

@include('pages._cracker-canvas')

@endsection
