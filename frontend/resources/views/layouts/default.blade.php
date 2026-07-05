<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="{{ $global_settings->meta_title ?? 'Sri Annapoorani Crackers – India\'s Finest Fireworks About' }}">
    <title>{{ $global_settings->meta_title ?? 'Sri Annapoorani Crackers' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --gold: #0b6698;
            --gold-light: #ff5733;
            --gold-deep: #c92a0d;
            --gold-glimmer: linear-gradient(90deg, #ff5733, #0b6698, #ff5733);
            --ink: #080810;
            --text: #000000;
            --charcoal: #333333;
            --cream: #0f0f1a;
            --ivory: #13131f;
            --saffron: #0b6698;
            --clay: #f5f5f5;
            --font-display: 'Outfit', sans-serif;
            --font-body: 'Outfit', sans-serif;
            --font-accent: 'Outfit', sans-serif;
            --blur: saturate(180%) blur(20px);
            --glass: rgba(255, 255, 255, 0.95);
            --shadow-premium: 0 30px 60px rgba(0, 0, 0, 0.1), 0 0 80px rgba(229, 58, 18, 0.1);
            --luminous-border: 1.5px solid rgba(229, 58, 18, 0.3);
            --luminous-text: 0 0 15px rgba(229, 58, 18, 0.3);
        }
        html {
            scroll-behavior: smooth;
            /* Firefox Scrollbar styling */
            scrollbar-width: thin;
            scrollbar-color: #0c689b #f1f1f1;
        }
        /* Webkit-based browsers Scrollbar styling */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #0c689b;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #09527b;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition-duration: .25s !important;
            transition-timing-function: ease !important;
            animation-duration: .55s !important;
            animation-iteration-count: 1 !important;
            animation-timing-function: ease !important;
        }
        body {
            font-family: var(--font-body);
            color: var(--text);
            background: var(--cream);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }
        button, a, input, select, textarea {
            transition: background-color .25s ease, color .25s ease, transform .25s ease, box-shadow .25s ease, opacity .25s ease;
        }
        .animate__animated,
        .wow,
        [class*="animate"],
        [class*="fade"],
        [class*="slide"],
        [class*="bounce"],
        [class*="spinner"] {
            animation-duration: 0.55s !important;
            animation-timing-function: ease !important;
            animation-iteration-count: 1 !important;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: url('https://www.transparenttextures.com/patterns/p6.png');
            opacity: 0.03;
            pointer-events: none;
            z-index: 9999;
        }
        #preloader {
            position: fixed;
            inset: 0;
            background: #FFFFFF;
            z-index: 100000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease;
        }
        .preloader-inner {
            text-align: center;
            padding: 24px 28px;
            background: rgba(229, 58, 18, 0.06);
            backdrop-filter: blur(18px);
            border-radius: 24px;
            border: 1px solid rgba(229, 58, 18, 0.08);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
        }
        .preloader-logo {
            width: 220px;
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            filter: none;
            animation: preloaderPulse 1.8s ease-in-out infinite;
        }
        .preloader-bar {
            width: 180px;
            height: 4px;
            background: rgba(229, 58, 18, 0.12);
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }
        .preloader-progress {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            background: linear-gradient(135deg, #0c689b, #043048) !important;
            width: 100%;
            border-radius: 10px;
            opacity: 0.8;
        }
        @keyframes preloaderPulse {
            0%, 100% { opacity: 0.8; transform: translateY(0); }
            50% { opacity: 1; transform: translateY(-2px); }
        }
        #scrollProgress {
            position: fixed;
            top: 0;
            left: 0;
            height: 5px;
            background: linear-gradient(to right, #0c689b, #043048);
            box-shadow: 0 0 15px rgba(50, 112, 255, 0.4);
            width: 0%;
            z-index: 100001;
        }
        h1, h2, h3 {
            font-family: var(--font-display);
            font-weight: 800;
            color: #0b6698;
            text-shadow: 0 2px 10px rgba(229, 58, 18, 0.1);
        }
        .luminous-text {
            text-shadow: 0 2px 10px rgba(229, 58, 18, 0.2), 0 0 40px rgba(229, 58, 18, 0.1);
        }
        .accent-text {
            font-family: var(--font-accent);
            color: #0b6698;
            font-style: italic;
        }

        /* ── FAB SYSTEM ── */
        .luxury-fab-group {
            position: fixed;
            bottom: 30px;
            left: 30px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 90px;
        }
        .luxury-fab-group-right {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 90px;
            align-items: flex-end;
        }
        @media (max-width: 768px) {
            .fab-hide-estimate-mobile {
                display: none !important;
            }
        }
        .l-fab, .go-top-premium {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
            text-decoration: none;
            border: none;
            color: #ffffff;
            z-index: 1;
            flex-shrink: 0;
        }
        .l-fab i, .go-top-premium i {
            font-size: 1.3rem;
            position: relative;
            z-index: 2;
        }
        .l-fab.ph {
            background: linear-gradient(135deg, #ff5733, #d32f2f);
            box-shadow: 0 6px 20px rgba(255, 87, 51, 0.45);
            --ripple-color: rgba(255, 87, 51, 0.55);
        }
        .l-fab.wa {
            background: linear-gradient(135deg, #25D366, #128C7E);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.45);
            --ripple-color: rgba(37, 211, 102, 0.55);
        }
        .l-fab.est {
            background: linear-gradient(135deg, #0b6698, #053b59);
            box-shadow: 0 6px 20px rgba(11, 102, 152, 0.45);
            --ripple-color: rgba(11, 102, 152, 0.55);
        }
        .go-top-premium {
            opacity: 0;
            pointer-events: none;
            background: linear-gradient(135deg, #0c689b, #053b59);
            box-shadow: 0 6px 20px rgba(12, 104, 155, 0.45);
            --ripple-color: rgba(12, 104, 155, 0.55);
            transform: translateY(10px) scale(0.85);
            transition: opacity 0.35s ease, transform 0.35s ease;
        }
        .go-top-premium.active {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0) scale(1);
        }
        /* Ripple ring — expands outward from button edge, doesn't affect layout */
        .l-fab::after, .go-top-premium::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 2px solid var(--ripple-color);
            opacity: 0;
            transform: scale(1);
            animation: fab-ripple 2.8s infinite cubic-bezier(0.1, 0.8, 0.3, 1);
            pointer-events: none;
            z-index: 0;
        }
        .l-fab:hover {
            transform: scale(1.08);
        }
        .l-fab:hover i {
            transform: scale(1.1) translateY(-1px);
        }
        .l-fab.ph:hover i {
            animation: phone-shake 0.45s ease-in-out;
        }
        .go-top-premium:hover {
            transform: scale(1.08);
        }
        .go-top-premium.active:hover {
            transform: scale(1.08);
        }
        @keyframes fab-ripple {
            0%   { transform: scale(1);   opacity: 0.8; }
            70%  { opacity: 0.3; }
            100% { transform: scale(1.7); opacity: 0; }
        }
        @keyframes phone-shake {
            0%, 100% { transform: rotate(0); }
            15%  { transform: rotate(-14deg); }
            30%  { transform: rotate(14deg); }
            45%  { transform: rotate(-9deg); }
            60%  { transform: rotate(9deg); }
            75%  { transform: rotate(-4deg); }
        }
        @keyframes button-blink {
            0%, 100% { opacity: 1; filter: brightness(1); }
            50% { opacity: 0.65; filter: brightness(1.3); }
        }
        .l-fab, .go-top-premium.active {
            animation: button-blink 1.5s infinite ease-in-out !important;
        }
        .l-fab:hover, .go-top-premium.active:hover {
            animation-play-state: paused !important;
            opacity: 1 !important;
            filter: brightness(1.1) !important;
        }
        @media (max-width: 768px) {
            .luxury-fab-group {
                bottom: 20px;
                left: 16px;
                gap: 16px;
            }
            .luxury-fab-group-right {
                bottom: 20px;
                right: 16px;
                gap: 16px;
            }
            .l-fab, .go-top-premium {
                width: 48px;
                height: 48px;
            }
            .l-fab i, .go-top-premium i {
                font-size: 1.1rem;
            }
        }
    </style>
    @stack('styles')
    @include('layouts._home-theme-polish')
</head>
<body>
    <div id="preloader">
        <div class="preloader-inner">
            <img src="{{ asset('assets/img/logo1.png') }}" class="preloader-logo" alt="Loading">
            <div class="preloader-bar">
                <div class="preloader-progress"></div>
            </div>
        </div>
    </div>
    <div id="scrollProgress"></div>
    @include('layouts.header')
    <main class="site-main" id="mainContent">
        @php
            $pageOff = \App\Models\PageOff::first();
            $isOff = $pageOff && (int) $pageOff->status === 0 && !empty($pageOff->image);
        @endphp
        @if($isOff)
            <section class="maintenance-luxury">
                <div class="m-container">
                    <div class="m-visual">
                        <img src="{{ env('MAIN_URL') . $pageOff->image }}" alt="Maintenance">
                    </div>
                    <div class="m-content">
                        <h2>Under <span>Maintenance</span></h2>
                        <p>Our artisans are currently refining your experience. We will be back with even more brilliance shortly.</p>
                        <div class="m-divider"></div>
                    </div>
                </div>
            </section>
            <style>
                .maintenance-luxury {
                    min-height: 85vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: linear-gradient(135deg, #080810, #0C0C18);
                    padding: 100px 40px;
                    position: relative;
                    overflow: hidden;
                }
                .m-container {
                    max-width: 1000px;
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 60px;
                    align-items: center;
                    z-index: 2;
                }
                .m-visual img {
                    width: 100%;
                    border-radius: 40px;
                    border: var(--luminous-border);
                    box-shadow: var(--shadow-premium);
                    transform: rotate(-2deg);
                }
                .m-content h2 {
                    font-size: 4rem;
                    line-height: 1.1;
                    margin-bottom: 24px;
                    text-shadow: var(--luminous-text);
                }
                .m-content h2 span {
                    color: #FFFFFF;
                    display: block;
                    font-family: var(--font-accent);
                    opacity: 0.8;
                }
                .m-content p {
                    font-size: 1.2rem;
                    color: rgba(255, 255, 255, 0.6);
                    line-height: 1.8;
                }
                .m-divider {
                    width: 60px;
                    height: 3px;
                    background: #FFFFFF;
                    box-shadow: 0 0 15px #FFFFFF;
                    margin-top: 30px;
                }
            </style>
        @else
            @yield('main-page')
        @endif
    </main>
    @include('layouts.footer')

    <!-- LEFT FAB GROUP -->
    <div class="luxury-fab-group {{ Request::is('estimate') ? 'fab-hide-estimate-mobile' : '' }}">
        <a href="tel:{{ $global_settings->phone_number }}" class="l-fab ph" title="Call Us">
            <i class="fa-solid fa-phone"></i>
        </a>
        <a href="https://wa.me/{{ $global_settings->whatsapp_number }}" target="_blank" class="l-fab wa" title="WhatsApp Us">
            <i class="fa-brands fa-whatsapp"></i>
        </a>
    </div>

    <!-- RIGHT FAB GROUP -->
    <div class="luxury-fab-group-right {{ Request::is('estimate') ? 'fab-hide-estimate-mobile' : '' }}">
        @if(!Request::is('estimate'))
            <a href="{{ url('estimate') }}" class="l-fab est" title="Shop Now">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        @endif
        <div class="go-top-premium" id="goTopBtn" title="Back to Top">
            <i class="fa-solid fa-arrow-up"></i>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/parallax.min.js') }}"></script>
    <script src="{{ asset('assets/js/rangeSlider.min.js') }}"></script>
    <script src="{{ asset('assets/js/nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/meanmenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                const p = document.getElementById('preloader');
                if (p) {
                    p.style.opacity = '0';
                    p.style.pointerEvents = 'none';
                    setTimeout(() => p.remove(), 800);
                }
            }, 600);
        });
        window.addEventListener('scroll', () => {
            const top = document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            document.getElementById('scrollProgress').style.width = ((top / height) * 100) + '%';
            const btn = document.getElementById('goTopBtn');
            if (btn) btn.classList.toggle('active', top > 500);
        });
        const goTopBtnEl = document.getElementById('goTopBtn');
        if (goTopBtnEl) {
            goTopBtnEl.onclick = () => window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        @if(session('success'))
            Swal.fire({
                title: 'SUCCESS', text: '{{ session('success') }}', icon: 'success',
                confirmButtonColor: '#0c689b', background: '#fff',
                customClass: { popup: 'premium-swal' }
            });
        @endif
    </script>
    @stack('scripts')
</body>
</html>