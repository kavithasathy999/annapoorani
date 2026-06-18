<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="{{ $global_settings->meta_title ?? 'Bluvel Crackers – India\'s Best Crackers Store' }}">

    <title>{{ $global_settings->meta_title ?? 'Bluvel Crackers' }}</title>

    <link rel="icon" type="image/png"
        href="{{ $global_settings->favicon ? env('MAIN_URL', '/') . $global_settings->favicon : asset('assets/img/favicon.png') }}">

    <!-- Links of CSS files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rangeSlider.min.css') }}">

    @php
        $theme = \App\Models\ThemeSetting::first();
    @endphp

    <style>
        :root {
            --c-black:
                {{ $theme->primary_color }}
            ;
            --c-grey:
                {{ $theme->secondary_color}}
            ;
            --c-gold:
                {{ $theme->tertiary_color }}
            ;
            --c-navy:
                {{ $theme->quaternary_color }}
            ;

        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @stack('styles')
</head>

<body>

    @include('layouts.header')

    <!-- Start Search Overlay -->
    <div class="search-overlay">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="search-overlay-layer"></div>
                <div class="search-overlay-layer"></div>
                <div class="search-overlay-layer"></div>

                <div class="search-overlay-close">
                    <span class="search-overlay-close-line"></span>
                    <span class="search-overlay-close-line"></span>
                </div>

                <div class="search-overlay-form">
                    <form>
                        <input type="text" class="input-search" placeholder="Search here...">
                        <button type="submit"><i class='bx bx-search-alt'></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Search Overlay -->


    @php
        $pageOff = \App\Models\PageOff::first();
        $isOff = $pageOff && (int) $pageOff->status === 0 && !empty($pageOff->image);
    @endphp

    @if($isOff)


        <div class="page-off-section">
            <div class="page-off-inner">
                <img src="{{ env('MAIN_URL') . $pageOff->image }}" alt="We'll be back soon" class="page-off-img">
            </div>
        </div>

        <style>
            .page-off-section {
                background: #0a0000;
                min-height: 72vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 60px 20px;
                position: relative;
                overflow: hidden;
            }

            .page-off-section::before {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(ellipse 70% 60% at 50% 50%, rgba(255, 60, 0, 0.07), transparent 70%);
                pointer-events: none;
            }

            .page-off-inner {
                position: relative;
                z-index: 1;
                max-width: 900px;
                width: 100%;
                text-align: center;
                animation: pageOffFadeIn 0.7s ease both;
            }

            @keyframes pageOffFadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px) scale(0.97);
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            .page-off-img {
                width: 100%;
                max-width: 490px;
                height: auto;
                border-radius: 30px;
                border: 1px solid rgba(255, 100, 0, 0.18);
                box-shadow:
                    0 0 60px rgba(255, 60, 0, 0.12),
                    0 20px 60px rgba(0, 0, 0, 0.5);
                display: block;
                margin: 0 auto;
            }

            @media (max-width: 600px) {
                .page-off-section {
                    padding: 30px 14px;
                    min-height: 50vh;
                }

                .page-off-img {
                    border-radius: 10px;
                }
            }
        </style>

    @else


        @yield('main-page')

    @endif

    <!-- Start Footer Area -->
    @include('layouts.footer')
    <!-- End Footer Area -->

    @if(!Request::is('estimate'))
        <a href="{{ url('estimate') }}" class="floating-fab fab-quick-shop" aria-label="Quick Shop" title="Quick Shop">
            <span class="blast-wave"></span>
            <span class="blast-wave"></span>
            <svg viewBox="0 0 24 24">
                <path fill="white"
                    d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
            </svg>
        </a>


        <a href="tel:{{ $global_settings->phone_number ?? '9025978152' }}" class="floating-fab fab-call" aria-label="Call Now">
            <span class="blast-wave"></span>
            <span class="blast-wave"></span>
            <svg viewBox="0 0 24 24">
                <path fill="white"
                    d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
            </svg>
        </a>
    @endif

    <a href="https://wa.me/{{ $global_settings->whatsapp_number ?? '9025978152' }}" target="_blank"
        class="floating-fab fab-whatsapp" aria-label="WhatsApp">
        <span class="blast-wave"></span>
        <span class="blast-wave"></span>
        <svg viewBox="0 0 24 24">
            <path fill="white"
                d="M12.04 2C6.52 2 2 6.48 2 12c0 2.11.55 4.17 1.6 6L2 22l4.12-1.58c1.75.96 3.7 1.46 5.92 1.46 5.52 0 10-4.48 10-10 0-2.67-1.04-5.18-2.93-7.07C17.22 3.04 14.71 2 12.04 2zm0 18c-1.95 0-3.76-.53-5.35-1.53l-.38-.23-2.44.93.95-2.38-.25-.39C3.6 14.86 3.1 13.45 3.1 12c0-4.95 4.03-8.98 8.98-8.98 2.4 0 4.66.93 6.36 2.62 1.7 1.7 2.63 3.96 2.63 6.36 0 4.95-4.03 8.98-8.98 8.98zm5.1-6.35c-.28-.14-1.65-.82-1.9-.91-.26-.1-.45-.14-.64.14-.19.28-.73.91-.9 1.1-.16.19-.33.21-.61.07-.28-.14-1.17-.43-2.23-1.38-.82-.73-1.38-1.64-1.54-1.92-.16-.28-.02-.43.12-.57.12-.12.28-.33.43-.49.14-.16.19-.28.28-.47.09-.19.05-.35-.02-.49-.07-.14-.64-1.54-.88-2.1-.23-.55-.47-.47-.64-.48-.16-.01-.35-.01-.54-.01-.19 0-.49.07-.75.35-.26.28-.98.96-.98 2.35 0 1.38 1.01 2.72 1.15 2.91.14.19 1.98 3.02 4.8 4.24.67.29 1.19.46 1.6.59.67.21 1.28.18 1.76.11.54-.08 1.65-.67 1.88-1.32.23-.65.23-1.21.16-1.32-.07-.11-.26-.18-.54-.32z" />
        </svg>
    </a>

    <div class="go-top"><i class='bx bx-up-arrow-alt'></i></div>

    <!-- Links of JS files -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/parallax.min.js') }}"></script>
    <script src="{{ asset('assets/js/rangeSlider.min.js') }}"></script>
    <script src="{{ asset('assets/js/nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/meanmenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/sticky-sidebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/form-validator.min.js') }}"></script>
    <script src="{{ asset('assets/js/contact-form-script.js') }}"></script>
    <script src="{{ asset('assets/js/ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* ===== CUSTOM PREMIUM SWEETALERT THEME ===== */
        .swal2-popup {
            background: #110100 !important;
            border: 1px solid rgba(255, 100, 0, 0.3) !important;
            border-radius: 15px !important;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.8) !important;
        }

        .swal2-title {
            color: #ffd700 !important;
            font-family: 'Cinzel Decorative', cursive !important;
            font-size: 24px !important;
            text-shadow: 0 0 10px rgba(255, 100, 0, 0.3) !important;
        }

        .swal2-html-container {
            color: rgba(255, 220, 180, 0.8) !important;

            font-size: 16px !important;
        }

        .swal2-confirm {
            background: linear-gradient(135deg, #ff2200, #ff6a00) !important;
            box-shadow: 0 5px 15px rgba(255, 60, 0, 0.3) !important;
            border-radius: 5px !important;

            font-weight: 700 !important;
            letter-spacing: 1px !important;
            text-transform: uppercase !important;
        }

        .swal2-confirm:hover {
            filter: brightness(1.2) !important;
        }

        .swal2-icon.swal2-success .swal2-success-ring {
            border-color: rgba(255, 106, 0, 0.3) !important;
        }

        .swal2-icon.swal2-success [class^='swal2-success-line'] {
            background-color: #ff6a00 !important;
        }

        .swal2-icon.swal2-error {
            border-color: #ff2200 !important;
        }

        .swal2-icon.swal2-error [class^='swal2-x-mark-line'] {
            background-color: #ff2200 !important;
        }

        .swal2-timer-progress-bar {
            background: var(--fire-orange) !important;
        }

        /* Floating Buttons Shared Styles */
        .floating-fab {
            position: fixed;
            left: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .floating-fab:hover {
            transform: scale(1.15) rotate(5deg);
        }

        .floating-fab svg {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            padding: 12px;
            position: relative;
            z-index: 2;
        }

        /* Cracker Blast Wave Animation */
        .blast-wave {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
            opacity: 0;
        }

        .fab-whatsapp .blast-wave {
            /* border: 2px solid #25d366; */
            background: rgba(37, 211, 102, 0.2);
            animation: crackerBlast 2s infinite;
        }

        .fab-call .blast-wave {
            /* border: 2px solid #ff4500; */
            background: rgba(255, 69, 0, 0.2);
            animation: crackerBlast 2s infinite;
        }

        .fab-quick-shop .blast-wave {
            background: rgba(138, 43, 226, 0.2);
            animation: crackerBlast 2s infinite;
        }

        .blast-wave:nth-child(2) {
            animation-delay: 0.6s;
        }

        @keyframes crackerBlast {
            0% {
                transform: scale(1);
                opacity: 0.8;
                border-width: 4px;
            }

            50% {
                opacity: 0.4;
            }

            100% {
                transform: scale(2.2);
                opacity: 0;
                border-width: 1px;
            }
        }

        .fab-whatsapp {
            bottom: {{ Request::is('estimate') ? '90px' : '30px' }};
        }

        .fab-whatsapp svg {
            background: radial-gradient(circle at top left, #4cff7a, #0aa84f);
            box-shadow: 0 0 15px rgba(37, 211, 102, 0.6);
        }

        .fab-call {
            bottom: 135px;
        }

        .fab-call svg {
            background: radial-gradient(circle at top left, #ff8c00, #ff4500);
            box-shadow: 0 0 15px rgba(255, 69, 0, 0.6);
        }

        .fab-quick-shop {
            bottom: 60px;
            left: auto !important;
            right: 30px !important;
        }

        .fab-quick-shop svg {
            background: radial-gradient(circle at top left, #b15eff, #6a0dad);
            box-shadow: 0 0 15px rgba(106, 13, 173, 0.6);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'SUCCESS',
                    html: '{!! session('success') !!}',
                    timer: 4000,
                    showConfirmButton: false,
                    timerProgressBar: true
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR',
                    html: '{!! session('error') !!}',
                    confirmButtonText: 'OK'
                });
            @endif

            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'VALIDATION ERROR',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonText: 'TRY AGAIN'
                });
            @endif
        });
    </script>

    @stack('scripts')
</body>

</html>