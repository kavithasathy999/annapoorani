@extends('layouts.default')

@section('main-page')

    <style>
        /* ===========================================
       PREMIUM TERMS PAGE STYLES (GOLDEN LIGHT)
       =========================================== */

        /* 1. Page Background & Reading Bar */
        .terms-page {
            background: var(--cream);
            overflow-x: hidden;
        }

        #readProgress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 5px;
            background: linear-gradient(to right, #FFFFFF, var(--gold-light), #FFFFFF);
            z-index: 2005;
            transition: width 0.1s ease;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.6);
        }

        /* 2. Cinematic Hero Section */
        .terms-hero {
            height: 45vh;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
            background: var(--ink);
        }

        .terms-hero-bg {
            position: absolute;
            inset: 0;
            background-image: url('{{ asset('assets/img/bg.jpg') }}');
            background-size: cover;
            background-position: center;
            opacity: 0.3;
            transform: scale(1.1);
        }

        .terms-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent, var(--ink) 95%);
            z-index: 1;
        }

        .terms-hero-content {
            position: relative;
            z-index: 10;
            width: min(100% - 40px, 900px);
        }

        .terms-eyebrow {
            display: block;
            color: var(--gold-deep);
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 5px;
            margin-bottom: 20px;
        }

        .terms-hero h1 {
            font-family: var(--font-display);
            font-size: clamp(2.5rem, 5vw, 4rem);
            color: #fff;
            line-height: 1.1;
            margin-bottom: 10px;
            font-weight: 900;
            text-shadow:
                0 2px 10px rgba(255, 255, 255, 0.3),
                0 0 40px rgba(255, 255, 255, 0.2),
                0 0 80px rgba(255, 255, 255, 0.1);
        }

        .terms-hero p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* 3. Document Styling */
        .terms-section {
            padding: 100px 0;
            position: relative;
        }

        .terms-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .terms-card {
            background: #13131f;
            border-radius: 40px;
            padding: 80px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255,255,255,0.08);
            position: relative;
        }

        .terms-content-body {
            font-family: var(--font-body);
            font-size: 1.15rem;
            line-height: 1.9;
            color: rgba(255,255,255,0.72) !important;
            counter-reset: section;
        }

        /* Aggressive Universal Override for Summernote inline styles */
        .terms-content-body * {
            color: rgba(255,255,255,0.72) !important;
            background-color: transparent !important;
        }

        .terms-content-body h1,
        .terms-content-body h2,
        .terms-content-body h3,
        .terms-content-body h4,
        .terms-content-body h5,
        .terms-content-body h6,
        .terms-content-body h1 *,
        .terms-content-body h2 *,
        .terms-content-body h3 * {
            color: #ffffff !important;
        }

        .terms-content-body h1,
        .terms-content-body h2,
        .terms-content-body h3,
        .terms-content-body h4,
        .terms-content-body h5,
        .terms-content-body h6 {
            font-family: var(--font-display);
            color: #fff !important;
            text-shadow: 0 2px 10px rgba(255, 255, 255, 0.2);
            margin: 2.5em 0 1em;
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }

        .terms-content-body h2::before {
            content: counter(section) ".";
            counter-increment: section;
            color: var(--gold-light);
            font-family: var(--font-display);
            font-style: italic;
            font-size: 2.8rem;
            line-height: 0.8;
            opacity: 0.9;
        }

        .terms-content-body strong,
        .terms-content-body b {
            color: #fff !important;
            font-weight: 900;
        }

        .terms-content-body ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 2.5em;
        }

        .terms-content-body li {
            position: relative;
            padding-left: 35px;
            margin-bottom: 15px;
        }

        .terms-content-body li::before {
            content: '\f111';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 0.6rem;
            color: var(--gold-light);
            position: absolute;
            left: 0;
            top: 12px;
        }

        .terms-footer {
            text-align: center;
            margin-top: 80px;
            padding-bottom: 40px;
        }

        @media (max-width: 768px) {
            .terms-card {
                padding: 40px;
                border-radius: 25px;
            }

            .terms-hero h1 {
                font-size: 2.5rem;
            }
        }

        /* Dark premium polish aligned with home/about/contact */
        .terms-page {
            background:
                linear-gradient(180deg, rgba(8,8,16,0.98), rgba(12,12,24,0.98));
        }

        .terms-hero {
            min-height: 460px;
            background: #080810;
        }

        .terms-hero-bg {
            opacity: 0.45;
        }

        .terms-hero-overlay {
            background:
                radial-gradient(circle at 50% 42%, rgba(240,168,50,0.16), transparent 18rem),
                linear-gradient(to bottom, rgba(8,8,16,0.66), rgba(8,8,16,0.97));
        }

        .terms-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.05));
            /* border: 1.5px solid rgba(255, 255, 255, 0.6) !important; */
            /* color: #FFFFFF !important; */
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
            padding: 7px 18px;
            border-radius: 50px;
            box-shadow:
                0 0 20px rgba(255, 255, 255, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.6);
        }

        .terms-section {
            background:
                radial-gradient(circle at 50% 0, rgba(212,134,10,0.1), transparent 26rem),
                linear-gradient(180deg, rgba(8,8,16,0.98), rgba(12,12,24,0.98));
        }

        .terms-card {
            background: #13131f;
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 2px solid rgba(255, 255, 255, 0.15) !important;
            border-radius: 40px;
            padding: 80px;
            box-shadow: 
                0 40px 100px rgba(0, 0, 0, 0.45),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            position: relative;
        }
        
        .terms-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 50% 0%, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .terms-footer .btn-gold {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
            border: 1.5px solid rgba(255, 255, 255, 0.6);
            color: #FFFFFF;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 900;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 
                0 0 20px rgba(255, 255, 255, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
        }

        .terms-footer .btn-gold:hover {
            background: linear-gradient(135deg, #FFFFFF, #F0A832);
            color: #080810;
            transform: translateY(-5px);
            box-shadow: 
                0 15px 35px rgba(255, 255, 255, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.6);
        }

        @media (max-width: 575px) {
            .terms-container {
                padding: 0 18px;
            }

            .terms-card {
                padding: 28px;
            }
        }
    </style>

    <div class="terms-page">
        <!-- Reading Progress -->
        <div id="readProgress"></div>

        <!-- Cinematic Hero -->
        <section class="terms-hero">
            <div class="terms-hero-bg parallax-target"></div>
            <div class="terms-hero-overlay"></div>

            <div class="terms-hero-content">
                <span class="terms-eyebrow wow fadeInUp">Official Protocols</span>
                <h1 class="wow fadeInUp" data-wow-delay="0.1s">Terms & Conditions</h1>
                <p class="wow fadeInUp" data-wow-delay="0.2s">Effective Date: October 2023 | Version 2.1</p>
            </div>
        </section>

        <!-- Content Section -->
        <section class="terms-section">
            <div class="terms-container">
                <div class="terms-card wow fadeInUp">
                    <div class="terms-content-body">
                        @if($terms && $terms->content)
                            {!! $terms->content !!}
                        @else
                            <h2>1. Acceptance of Terms</h2>
                            <p>Welcome to <strong>Sri Annapoorani Crackers</strong>. By accessing this website, you acknowledge that
                                you have read, understood, and agreed to be bound by these Terms and Conditions. These terms
                                apply to all visitors, users, and others who access or use our services.</p>

                            <h2>2. Seasonal Ordering Policy</h2>
                            <p>As we deal in seasonal artisanal crackers from Sivakasi, orders are subject to stock availability
                                during peak festival periods. We ensure the highest quality standards for all products listed on
                                our platform.</p>

                            <h2>3. Safety Compliance</h2>
                            <p>Your safety is our priority. Users are strictly advised to follow all packaging instructions, use
                                crackers in open spaces, and maintain a safe distance. <strong>Sri Annapoorani Crackers</strong> is
                                not liable for any incidents resulting from improper handling.</p>

                            <h2>4. Delivery & Returns</h2>
                            <p>Deliveries are managed through vetted logistics partners. Due to the nature of our products,
                                returns are typically only accepted for damaged items reported within 24 hours of delivery.</p>
                        @endif
                    </div>
                </div>

                <div class="terms-footer wow fadeInUp">
                    <a href="/" class="btn-gold"
                        style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none; width:auto; padding: 15px 40px; border-radius: 50px;">
                        <i class="fa-solid fa-arrow-left" style="margin-right:15px; margin-top:2px; text-decoration:none;"></i> <span style="text-decoration:none;">Back to Home</span>
                    </a>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // 1. Reading Progress
                const bar = document.getElementById('readProgress');
                window.addEventListener('scroll', () => {
                    const h = document.documentElement,
                        b = document.body,
                        st = 'scrollTop',
                        sh = 'scrollHeight';
                    const pct = (h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight) * 100;
                    bar.style.width = pct + '%';

                    // Parallax
                    const target = document.querySelector('.parallax-target');
                    if (target) target.style.transform = `scale(1.1) translateY(${window.scrollY * 0.3}px)`;
                });

            });
        </script>
    @endpush

    @include('pages._cracker-canvas')

@endsection