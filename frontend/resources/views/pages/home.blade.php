@extends('layouts.default')

@section('main-page')

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="main-page-wrap">

    <style>
        /* =========================================
       GOLDEN LIGHT — PREMIUM LIGHT THEME
       Ivory · Warm Sand · Deep Saffron
       ========================================= */
        :root {
            /* Core Palette */
            --gold: #D4860A;
            --gold-deep: #B86E00;
            --gold-light: #F0A832;
            --gold-pale: rgba(212, 134, 10, 0.08);
            --saffron: #E87B2D;

            /* Neutrals - CLEAN WHITE THEME */
            --ivory: #FFFFFF;
            --cream: #F9F9F9;
            --sand: #F3F3F3;
            --stone: #E8E8E8;
            --charcoal: #F5F5F5;
            --ink: #1A1A1A;
            --muted: #555555;
            --subtle: #888888;

            /* Shadows */
            --shadow-sm: 0 2px 12px rgba(0, 0, 0, .08);
            --shadow-md: 0 8px 32px rgba(0, 0, 0, .12);
            --shadow-lg: 0 20px 60px rgba(0, 0, 0, .16);
            --glow-gold: rgba(212, 134, 10, .3);

            /* Fonts */
            --font-display: 'Outfit', sans-serif;
            --font-accent: 'Outfit', sans-serif;

            /* Border Beam Colors */
            --beam-1: #D4860A;
            --beam-2: #E87B2D;
            --beam-3: #F0A832;
        }

        .main-page-wrap {
            position: relative;
        }

        /* ========================
       PREMIUM BORDER BEAM
       ======================== */
        .premium-card {
            position: relative;
            z-index: 2;
            overflow: hidden;
            background: #fff;
            border-radius: 0px;
            /* Matching your theme */
        }

        .premium-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(transparent,
                    var(--beam-1),
                    var(--beam-2),
                    var(--beam-3),
                    transparent 30%);
            animation: borderRotate 4s linear infinite;
            z-index: -1;
        }

        .premium-card::after {
            content: '';
            position: absolute;
            inset: 2px;
            /* Border thickness */
            background: inherit;
            z-index: -1;
        }

        @keyframes borderRotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: #FFFFFF;
            color: #1A1A1A;
            font-family: var(--font-accent);
            overflow-x: hidden;
        }

        .main-page-wrap {
            background: #FFFFFF;
        }

        /* CUSTOM CURSOR REMOVED */

        /* ========================
       NAV ANNOUNCEMENT BAR
       ======================== */
        .announce-bar {
            background: linear-gradient(90deg, var(--gold-deep), var(--saffron), var(--gold));
            color: #fff;
            text-align: center;
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            padding: 10px 20px;
        }

        .announce-bar span {
            margin: 0 24px;
        }

        .announce-bar i {
            color: rgba(255, 255, 255, .75);
        }

        /* ========================
       COMBINED HERO & BRANDS SECTION
       ======================== */
        .hero-combined-section {
            position: relative;
            height: 100vh;
            min-height: 640px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background: #080810;
        }

        .hero-banner-half {
            height: 50% !important;
            width: 100% !important;
            position: relative;
            overflow: hidden;
        }

        .hero-brands-half {
            height: 38% !important;
            width: 100% !important;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #080810;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding: 20px;
            box-sizing: border-box;
        }

        .hero-slider {
            position: relative;
            width: 100% !important;
            height: 100% !important;
            min-height: unset !important;
            overflow: hidden;
            background: var(--cream);
        }

        .hero-brands-half .brand-card {
            width: 140px !important;
            height: 100px !important;
            margin: 0 12px !important;
            padding: 10px !important;
            background: #FFFFFF !important;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05) !important;
        }
        
        .hero-brands-half .brand-card img {
            width: 100%;
            height: 100%;
            object-fit: contain !important;
        }

        @media screen and (max-width: 852px) {
            .hero-combined-section {
                height: 60vh !important;
                min-height: 400px !important;
            }
        }

        .slide {
            position: absolute;
            inset: 0;
            opacity: 1;
            transform: translateX(100%);
            transition: transform 3s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #3d3d43;
            z-index: 1;
        }

        .slide.active {
            transform: translateX(0);
            z-index: 2;
        }

        .slide.prev {
            transform: translateX(-100%);
            z-index: 1;
        }
        
        .slide.no-transition {
            transition: none !important;
        }

        /* Blurred background for premium "Full Image" look */
        .slide-bg-blur {
            position: absolute;
            inset: -20px;
            background-size: cover;
            background-position: center;
            filter: blur(40px) brightness(0.4);
            opacity: 0.6;
            z-index: 1;
        }

        .banner-image,
        .banner-video {
            position: relative;
            z-index: 2;
            width: 100%;
            height: 100%;
            object-fill: cover;
            object-position: center;
            transition: transform 1.3s ease;
        }

        .slide.active .banner-image,
        .slide.active .banner-video {
            transform: scale(1.02);
        }

        .slide-content {
            position: relative;
            z-index: 10;
            max-width: 600px;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--gold-pale);
            border: 1px solid var(--gold-light);
            color: var(--gold-deep);
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            padding: 7px 16px;
            margin-bottom: 28px;
        }

        .hero-eyebrow::before {
            content: '✦';
            color: var(--gold);
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(2.8rem, 6vw, 5.5rem);
            font-weight: 900;
            line-height: 1.05;
            color: var(--ink);
            margin-bottom: 20px;
        }

        .hero-title em {
            font-style: normal;
            color: var(--gold-deep);
            position: relative;
        }

        .hero-title em::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--saffron));
            border-radius: 2px;
            box-shadow: 0 0 15px var(--glow-gold);
        }

        .hero-title {
            text-shadow: 0 0 30px rgba(212, 134, 10, 0.15);
        }

        .hero-sub {
            color: var(--muted);
            font-size: 1.05rem;
            line-height: 1.75;
            margin-bottom: 38px;
            max-width: 480px;
        }

        .hero-btns {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--gold-deep), var(--saffron));
            color: #fff;
            font-weight: 700;
            font-size: .88rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-decoration: none;
            padding: 15px 36px;
            box-shadow: var(--shadow-md), 0 0 0 0 rgba(212, 134, 10, 0);
            transition: .3s;
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg), 0 0 0 6px rgba(212, 134, 10, .12);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            border: 1.5px solid var(--gold);
            color: var(--gold);
            font-weight: 700;
            font-size: .88rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-decoration: none;
            padding: 14px 32px;
            transition: .3s;
        }

        .btn-outline:hover {
            background: var(--gold-pale);
            border-color: var(--gold-deep);
            box-shadow: var(--shadow-sm);
        }

        .btn-whatsapp {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #25D366 !important;
            border: 1.5px solid #25D366 !important;
            color: #fff !important;
            font-weight: 700;
            font-size: .88rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-decoration: none;
            padding: 14px 32px;
            transition: .3s;
        }

        .btn-whatsapp:hover {
            background: #1ebc59 !important;
            border-color: #1ebc59 !important;
            box-shadow: var(--shadow-sm);
            color: #fff !important;
        }

        /* Badge strip in hero */
        .hero-badges {
            display: flex;
            gap: 24px;
            margin-top: 44px;
            flex-wrap: wrap;
        }

        .hero-badge-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .78rem;
            font-weight: 600;
            color: var(--muted);
        }

        .hero-badge-item i {
            color: var(--gold);
        }

        /* Slider dots */
        .slider-dots {
            position: absolute;
            bottom: 36px;
            left: 8%;
            display: flex;
            gap: 10px;
            z-index: 20;
        }

        .dot {
            width: 8px;
            height: 8px;
            background: var(--stone);
            border-radius: 50%;
            cursor: pointer;
            transition: .3s;
        }

        .dot.active {
            background: var(--gold);
            width: 26px;
            border-radius: 4px;
            box-shadow: 0 0 10px var(--glow-gold);
        }

        /* Scroll hint */
        .scroll-hint {
            position: absolute;
            bottom: 44px;
            right: 8%;
            z-index: 20;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            font-size: .62rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--subtle);
        }

        .scroll-line {
            width: 1px;
            height: 48px;
            background: linear-gradient(to bottom, var(--gold), transparent);
            animation: scrollPulse 2s infinite;
        }

        @keyframes scrollPulse {

            0%,
            100% {
                opacity: .3;
            }

            50% {
                opacity: 1;
            }
        }

        /* Hero floating card */
        .hero-float-card {
            position: absolute;
            right: 6%;
            bottom: 12%;
            z-index: 15;
            background: var(--cream);
            border: 1px solid var(--stone);
            box-shadow: var(--shadow-lg);
            padding: 22px 28px;
            display: flex;
            align-items: center;
            gap: 18px;
            min-width: 260px;
            animation: floatCard 4s ease-in-out infinite;
        }

        @keyframes floatCard {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .float-card-icon {
            width: 54px;
            height: 54px;
            background: var(--gold-pale);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            flex-shrink: 0;
        }

        .float-card-text {
            font-size: .82rem;
            color: var(--muted);
        }

        .float-card-text strong {
            display: block;
            font-size: 1.2rem;
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--ink);
            margin-top: 2px;
        }

        /* ========================
       SECTION COMMONS
       ======================== */
        .section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--gold-deep);
            margin-bottom: 14px;
        }

        .section-eyebrow::before,
        .section-eyebrow::after {
            content: '';
            display: block;
            width: 28px;
            height: 1px;
            background: var(--gold-light);
        }

        .section-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 4vw, 3.4rem);
            font-weight: 900;
            line-height: 1.1;
            color: var(--ink);
        }

        .section-title span {
            background: linear-gradient(90deg, #FFFFFF, var(--gold-light), #FFFFFF);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-family: var(--font-accent);
            filter: drop-shadow(0 0 15px rgba(240, 168, 50, 0.4));
            animation: shimmer 5s linear infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 0% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        .section-subtitle {
            font-size: 1rem;
            color: var(--muted);
            line-height: 1.7;
            max-width: 520px;
            margin: 14px auto 0;
        }

        .section-bar {
            display: block;
            width: 48px;
            height: 3px;
            background: linear-gradient(90deg, #0b6698, var(--gold-light));
            border-radius: 2px;
            margin: 16px auto 0;
        }

        /* ========================
       ABOUT SECTION
       ======================== */
        /* ========================
       ABOUT SECTION — PREMIUM DARK UPLIFT
       ======================== */
        .about-section {
            padding: 70px 40px;
            /* background: #3d3d43; */
            position: relative;
            overflow: hidden;
        }

        /* Ambient top-right golden aurora */
        .about-section::before {
            content: '';
            position: absolute;
            top: -250px;
            right: -250px;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(212, 134, 10, .18) 0%, rgba(232, 123, 45, .06) 45%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            animation: auroraFloat 8s ease-in-out infinite alternate;
        }

        /* Ambient bottom-left blue counterpoint */
        .about-section::after {
            content: '';
            position: absolute;
            bottom: -180px;
            left: -180px;
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, rgba(100, 120, 255, .08) 0%, transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }

        @keyframes auroraFloat {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(30px, 20px) scale(1.08);
            }
        }

        .about-inner {
            max-width: 1240px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            position: relative;
            z-index: 1;

        }

        /* ── Image Column ── */
        .about-img-col {
            position: relative;
            padding-bottom: 44px;
        }

        /* Glowing halo behind main image */
        .about-img-col::before {
            content: '';
            position: absolute;
            top: 10%;
            left: 5%;
            right: 5%;
            bottom: 15%;
            border-radius: 30px;
            background: radial-gradient(ellipse at 50% 50%, rgba(255, 255, 255, .15) 0%, transparent 70%);
            filter: blur(40px);
            z-index: 0;
            pointer-events: none;
        }

        .about-img-main {
            width: 100%;
            border-radius: 28px;
            border: 2px solid rgba(255, 255, 255, .5);
            box-shadow:
                0 12px 48px rgba(255, 255, 255, .15),
                0 0 0 1px rgba(255, 255, 255, .3),
                0 0 60px rgba(255, 255, 255, .1),
                inset 0 1px 0 rgba(255, 255, 255, .4);
            display: block;
            object-fit: cover;
            position: relative;
            z-index: 2;
            transition: transform .45s cubic-bezier(.23, 1, .32, 1), box-shadow .45s ease;
        }

        .about-img-main:hover {
            transform: translateY(-8px) scale(1.015);
            box-shadow:
                0 28px 72px rgba(255, 255, 255, .25),
                0 0 0 1px rgba(255, 255, 255, .6),
                0 0 80px rgba(255, 255, 255, .2);
        }

        .about-img-accent {
            position: absolute;
            bottom: 0;
            right: -30px;
            width: 48%;
            border-radius: 20px;
            border: 2px solid rgba(255, 255, 255, .6);
            box-shadow:
                0 16px 52px rgba(255, 255, 255, .2),
                0 0 0 1px rgba(255, 255, 255, .4),
                0 0 40px rgba(255, 255, 255, .15);
            z-index: 3;
            display: block;
            object-fit: cover;
            transition: transform .4s cubic-bezier(.23, 1, .32, 1);
        }

        .about-img-accent:hover {
            transform: translateY(-6px) rotate(-2deg);
        }

        /* ── Badge ── */
        .about-img-badge {
            position: absolute;
            top: -28px;
            left: -28px;
            z-index: 4;
            width: 108px;
            height: 108px;
            background: linear-gradient(140deg, #FFFFFF 0%, #F0A832 50%, #D4860A 100%);
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow:
                0 0 0 5px rgba(255, 255, 255, .4),
                0 0 0 12px rgba(255, 255, 255, .15),
                0 8px 32px rgba(255, 255, 255, .3),
                0 0 60px rgba(255, 255, 255, .2);
            color: #111;
            font-family: var(--font-display);
            font-size: 2.1rem;
            font-weight: 900;
            line-height: 1;
            text-shadow: 0 1px 3px rgba(255, 255, 255, .8);
            animation: badgePulse 3s ease-in-out infinite;
        }

        .about-img-badge small {
            font-size: .56rem;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
            opacity: .9;
        }

        @keyframes badgePulse {

            0%,
            100% {
                box-shadow: 0 0 0 5px rgba(255, 255, 255, .4), 0 0 0 12px rgba(255, 255, 255, .15), 0 8px 32px rgba(255, 255, 255, .3), 0 0 60px rgba(255, 255, 255, .2);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(255, 255, 255, .6), 0 0 0 18px rgba(255, 255, 255, .25), 0 8px 40px rgba(255, 255, 255, .4), 0 0 80px rgba(255, 255, 255, .3);
            }
        }

        /* ── Text Column ── */
        .about-text-col {
            padding-left: 8px;
        }

        .about-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #0b6698, rgba(255, 255, 255, .05));
            border: 1.5px solid rgba(255, 255, 255, .6);
            /* color: #FFFFFF; */
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            padding: 7px 20px;
            border-radius: 50px;
            margin-bottom: 24px;
            box-shadow:
                0 0 20px rgba(255, 255, 255, .2),
                inset 0 1px 0 rgba(255, 255, 255, .5);
            text-shadow: 0 0 10px rgba(255, 255, 255, .8);
        }

        .about-tag::before {
            content: '';
            width: 7px;
            height: 7px;
            background: #FFFFFF;
            border-radius: 50%;
            box-shadow: 0 0 10px #FFFFFF, 0 0 20px rgba(255, 255, 255, .8);
            flex-shrink: 0;
            animation: dotBlink 2s ease-in-out infinite;
        }

        @keyframes dotBlink {

            0%,
            100% {
                opacity: 1;
                box-shadow: 0 0 10px #FFFFFF, 0 0 20px rgba(255, 255, 255, .8);
            }

            50% {
                opacity: .6;
                box-shadow: 0 0 4px #FFFFFF;
            }
        }

        /* Title with strong luminous text shadow */
        .about-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 3.6vw, 3.1rem);
            font-weight: 900;
            line-height: 1.18;
            color: black;
            margin-bottom: 24px;
            text-shadow:
                0 2px 10px rgba(255, 255, 255, .3),
                0 0 40px rgba(255, 255, 255, .2),
                0 0 80px rgba(255, 255, 255, .1);
            letter-spacing: -.5px;
        }

        .about-title em {
            font-style: normal;
            background: linear-gradient(135deg, #FFFFFF 0%, #F0A832 50%, #D4860A 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 16px rgba(255, 255, 255, .6)) drop-shadow(0 2px 4px rgba(255, 255, 255, .3));
        }

        /* Body text with improved contrast */
        .about-body {
            color: black;
            font-size: 1.02rem;
            line-height: 1.92;
            margin-bottom: 38px;
            padding-left: 18px;
            border-left: 3px solid rgba(255, 255, 255, .6);
            text-shadow: 0 1px 4px rgba(255, 255, 255, .2);
        }

        /* ── Fact Cards — Glassmorphism Lifted ── */
        .about-facts {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 42px;
        }

        .fact-item {
            padding: 22px 24px;
            background: linear-gradient(145deg, rgba(255, 255, 255, .15) 0%, rgba(255, 255, 255, .05) 100%);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .4);
            position: relative;
            overflow: hidden;
            transition: transform .35s cubic-bezier(.23, 1, .32, 1), box-shadow .35s ease, border-color .35s ease;
            box-shadow:
                0 8px 32px rgba(255, 255, 255, .1),
                inset 0 1px 0 rgba(255, 255, 255, .4);
            cursor: default;
        }

        /* Subtle corner glow on card */
        .fact-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 60px;
            height: 60px;
            background: radial-gradient(circle at 0% 0%, rgba(255, 255, 255, .3) 0%, transparent 70%);
            border-radius: inherit;
            opacity: 1;
            transition: opacity .3s;
        }

        .fact-item:hover {
            transform: translateY(-7px);
            border-color: rgba(255, 255, 255, .8);
            box-shadow:
                0 20px 52px rgba(255, 255, 255, .2),
                0 0 0 1px rgba(255, 255, 255, .5),
                0 0 40px rgba(255, 255, 255, .15),
                inset 0 1px 0 rgba(255, 255, 255, .6);
        }

        .fact-item:hover::before {
            opacity: 0;
        }

        .fact-icon {
            display: block;
            font-size: 1.5rem;
            margin-bottom: 8px;
            position: relative;
            z-index: 2;
            line-height: 1;
            filter: drop-shadow(0 2px 6px rgba(255, 255, 255, .4));
        }

        .fact-number,
        .fact-label {
            position: relative;
            z-index: 2;
        }

        .fact-number {
            font-family: var(--font-display);
            font-size: 2.1rem;
            font-weight: 900;
            background: linear-gradient(135deg, #0b6698 0%, #FFCC44 40%, #0b6698 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            display: block;
            filter: drop-shadow(0 0 16px rgba(255, 255, 255, .6)) drop-shadow(0 2px 4px rgba(255, 255, 255, .4));
        }

        .fact-label {
            font-size: .8rem;
            /* color: #ffffff; */
            margin-top: 6px;
            font-weight: 700;
            letter-spacing: .5px;
            text-shadow: 0 1px 4px rgba(255, 255, 255, .4);
        }

        /* ── CTA Button — Luminous Pill ── */
        .about-cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, #FFFFFF 0%, #0b6698 50%, #0b6698 100%);
            background-size: 200% 100%;
            color: #111;
            font-weight: 900;
            font-size: .92rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-decoration: none;
            padding: 17px 38px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, .6);
            box-shadow:
                0 8px 32px rgba(255, 255, 255, .3),
                0 0 0 0 rgba(255, 255, 255, .2),
                inset 0 1px 0 rgba(255, 255, 255, .8);
            transition: all .4s cubic-bezier(.23, 1, .32, 1);
            position: relative;
            overflow: hidden;
            text-shadow: 0 1px 3px rgba(255, 255, 255, .8);
        }

        .about-cta-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 65%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .8), transparent);
            transition: left .65s ease;
        }

        .about-cta-btn:hover {
            background-position: 100% 0;
            transform: translateY(-4px) scale(1.03);
            box-shadow:
                0 20px 52px rgba(255, 255, 255, .4),
                0 0 0 8px rgba(255, 255, 255, .2),
                inset 0 1px 0 rgba(255, 255, 255, .9);
            color: #000;
            text-decoration: none;
        }

        .about-cta-btn:hover::before {
            left: 150%;
        }

        .about-cta-btn .btn-arrow {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background: rgba(0, 0, 0, .15);
            border-radius: 50%;
            font-size: 1.1rem;
            transition: transform .3s ease;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .5);
        }

        .about-cta-btn:hover .btn-arrow {
            transform: translateX(5px);
        }




        /* ========================
       OFFER STRIP — PREMIUM DARK UPLIFT
       ======================== */
        .offer-strip {
            background: #0b0b14;
            padding: 50px 40px;
            overflow: hidden;
            position: relative;
            border-top: 1px solid rgba(255, 255, 255, .05);
            border-bottom: 1px solid rgba(255, 255, 255, .05);
        }

        /* Deep gold glow behind the strip */
        .offer-strip::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 60vw;
            height: 100%;
            transform: translate(-50%, -50%);
            background: radial-gradient(ellipse, rgba(240, 168, 50, .08) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .offer-strip-inner {
            max-width: 1240px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .offer-strip-text h3 {
            font-family: var(--font-display);
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            font-weight: 900;
            color: #fff;
            line-height: 1.2;
            text-shadow: 0 2px 10px rgba(255, 255, 255, .3), 0 0 30px rgba(255, 255, 255, .2);
        }

        .offer-strip-text p {
            color: #b8b8c8;
            margin-top: 8px;
            font-size: .96rem;
            text-shadow: 0 1px 3px rgba(0, 0, 0, .5);
        }

        .offer-counters {
            display: flex;
            gap: 20px;
        }

        .counter-box {
            background: rgba(255, 255, 255, .03);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, .1);
            padding: 14px 20px;
            text-align: center;
            min-width: 72px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .3), inset 0 1px 0 rgba(255, 255, 255, .05);
            transition: .3s;
        }

        .counter-box:hover {
            background: rgba(255, 255, 255, .08);
            border-color: rgba(240, 168, 50, .4);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .5), 0 0 20px rgba(240, 168, 50, .2);
        }

        .counter-num {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(135deg, #FFF 0%, #0b6698 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            display: block;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, .3));
        }

        .counter-lbl {
            font-size: .62rem;
            color: #b8b8c8;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 4px;
            font-weight: 700;
        }

        .offer-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #0b6698, #0b6698);
            color: #fff;
            font-weight: 800;
            font-size: .88rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-decoration: none;
            padding: 15px 32px;
            border-radius: 30px;
            box-shadow: 0 8px 24px rgba(240, 168, 50, .3), inset 0 1px 0 rgba(255, 255, 255, .4);
            transition: .3s cubic-bezier(.23, 1, .32, 1);
            white-space: nowrap;
        }

        .offer-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 36px rgba(240, 168, 50, .4), inset 0 1px 0 rgba(255, 255, 255, .6);
            color: #fff;
        }

        /* ========================
       PRODUCTS SECTION — PREMIUM DARK UPLIFT
       ======================== */
        .products-section {
            padding: 70px 40px;
            background: #080810;
            position: relative;
            overflow: hidden;
        }

        /* Ambient glow for the products section */
        .products-section::before {
            content: '';
            position: absolute;
            top: 20%;
            left: 10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(212, 134, 10, .05) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        .products-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .1), transparent);
        }

        .products-inner {
            max-width: 1320px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* ── Section Header Dark Mode ── */
        .products-section .section-header {
            text-align: center;
            margin-bottom: 64px;
        }

        .products-section .section-eyebrow {
            display: inline-block;
            color: #F0A832;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
            text-shadow: 0 0 10px rgba(240, 168, 50, .6);
        }

        .products-section .section-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 3vw, 2.8rem);
            font-weight: 900;
            color: #FFF;
            text-shadow: 0 2px 10px rgba(255, 255, 255, .3), 0 0 40px rgba(255, 255, 255, .2);
            margin-bottom: 16px;
        }

        .products-section .section-bar {
            display: block;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #F0A832, #D4860A);
            margin: 0 auto 20px;
            border-radius: 2px;
            box-shadow: 0 0 10px rgba(240, 168, 50, .5);
        }

        .products-section .section-subtitle {
            color: #e0e0e0;
            font-size: 1.05rem;
            max-width: 600px;
            margin: 0 auto;
            text-shadow: 0 1px 3px rgba(0, 0, 0, .5);
        }

        /* ── Products Grid ── */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .product-card {
            background: rgba(15, 15, 25, 0.7);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            transition: all 0.7s cubic-bezier(0.19, 1, 0.22, 1);
            box-shadow: 0 15px 40px rgba(0, 0, 0, .5);
            cursor: pointer;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-12px) scale(1.02);
            border-color: var(--gold-light);
            box-shadow: 0 30px 60px rgba(240, 168, 50, 0.15);
        }

        .product-card:hover {
            transform: translateY(-8px);
            border-color: rgba(255, 255, 255, .6);
            box-shadow:
                0 20px 52px rgba(255, 255, 255, .15),
                0 0 0 1px rgba(255, 255, 255, .3),
                0 0 40px rgba(255, 255, 255, .1),
                inset 0 1px 0 rgba(255, 255, 255, .5);
        }

        /* Rotating glowing border effect */
        .product-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(transparent, rgba(255, 255, 255, .8), rgba(240, 168, 50, .8), rgba(255, 255, 255, .8), transparent 30%);
            animation: borderRotate 4s linear infinite;
            z-index: 0;
            opacity: 0;
            transition: opacity .4s ease;
        }

        .product-card:hover::before {
            opacity: 1;
        }

        .product-card::after {
            content: '';
            position: absolute;
            inset: 1px;
            background: #0d0d16;
            /* Deep inner background */
            border-radius: 19px;
            z-index: 1;
        }

        .product-info,
        .product-img-wrap,
        .product-num {
            position: relative;
            z-index: 2;
        }

        .product-card.featured-card {
            grid-column: span 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
        }

        .product-img-wrap {
            padding: 30px;
            background: radial-gradient(circle at center, rgba(255, 255, 255, .08) 0%, transparent 70%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 220px;
            transition: .4s;
            border-bottom: 1px solid rgba(255, 255, 255, .05);
        }

        .product-card.featured-card .product-img-wrap {
            min-height: 280px;
            border-bottom: none;
            border-right: 1px solid rgba(255, 255, 255, .05);
        }

        .product-card:hover .product-img-wrap {
            background: radial-gradient(circle at center, rgba(240, 168, 50, .15) 0%, transparent 70%);
        }

        .product-img-wrap img {
            max-width: 85%;
            max-height: 160px;
            object-fit: contain;
            transition: transform .5s cubic-bezier(.23, 1, .32, 1), filter .5s ease;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, .6));
        }

        .product-card:hover .product-img-wrap img {
            transform: scale(1.12) translateY(-4px);
            filter: drop-shadow(0 15px 25px rgba(0, 0, 0, .8)) drop-shadow(0 0 20px rgba(255, 255, 255, .2));
        }

        .product-info {
            padding: 26px 28px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .product-badge {
            display: inline-block;
            align-self: flex-start;
            background: linear-gradient(135deg, rgba(255, 255, 255, .2), rgba(255, 255, 255, .05));
            border: 1px solid rgba(255, 255, 255, .5);
            color: #FFF;
            text-shadow: 0 0 8px rgba(255, 255, 255, .6);
            font-size: .65rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 6px 12px;
            margin-bottom: 16px;
            border-radius: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .3);
        }

        .product-name {
            font-family: var(--font-display);
            font-size: 1.3rem;
            font-weight: 800;
            color: #FFF;
            margin-bottom: 10px;
            line-height: 1.3;
            text-shadow: 0 2px 4px rgba(0, 0, 0, .8), 0 0 10px rgba(255, 255, 255, .2);
            transition: color .3s;
        }

        .product-card:hover .product-name {
            background: linear-gradient(135deg, #FFF 0%, #F0A832 50%, #D4860A 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .product-card.featured-card .product-name {
            font-size: 1.8rem;
            margin-bottom: 12px;
        }

        .product-desc {
            font-size: .88rem;
            color: #b8b8c8;
            line-height: 1.65;
            margin-bottom: 20px;
        }

        .product-divider {
            width: 35px;
            height: 2px;
            background: linear-gradient(90deg, #F0A832, transparent);
            margin-bottom: 16px;
            border-radius: 2px;
        }

        .product-cat {
            font-size: .75rem;
            font-weight: 700;
            color: #F0A832;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .product-num {
            position: absolute;
            top: 12px;
            right: 16px;
            font-family: var(--font-display);
            font-size: 4rem;
            font-weight: 900;
            color: transparent;
            -webkit-text-stroke: 1px rgba(255, 255, 255, .1);
            line-height: 1;
            transition: .4s;
            user-select: none;
        }

        .product-card:hover .product-num {
            -webkit-text-stroke: 1px rgba(240, 168, 50, .3);
            text-shadow: 0 0 20px rgba(240, 168, 50, .2);
        }

        /* ========================
       CATEGORY SHOWCASE — PREMIUM DARK UPLIFT
       ======================== */
        .categories-section {
            padding: 70px 40px;
            background: #f7f7f8;
            position: relative;
            overflow: hidden;
        }

        .categories-section::before {
            content: '';
            position: absolute;
            bottom: -10%;
            right: -5%;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(212, 134, 10, .06) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        .categories-inner {
            max-width: 1320px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* ── Section Header Dark Mode ── */
        .categories-section .section-header {
            text-align: center;
            margin-bottom: 64px;
        }

        .categories-section .section-eyebrow {
            display: inline-block;
            color: #0b6698 !important;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .categories-section .section-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 3vw, 2.8rem);
            font-weight: 900;
            color: #111111;
            margin-bottom: 16px;
        }

        .categories-section .section-title span {
            color: #0b6698;
            -webkit-text-fill-color: #0b6698;
        }

        .categories-section .section-bar {
            display: block;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #F0A832, #0b6698) !important;
            margin: 0 auto;
            border-radius: 2px;
        }

        /* ── Sort By Category styling ── */
        .section-header-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 64px;
            width: 100%;
        }

        .categories-section .section-header {
            margin-bottom: 0 !important;
        }

        .premium-sort-container {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 20;
        }

        .premium-sort-btn {
            background: #ffffff;
            border: 1.5px solid #0b6698;
            border-radius: 30px;
            color: #0b6698;
            font-size: 0.9rem;
            font-weight: 700;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 4px 15px rgba(11, 102, 152, 0.06);
            font-family: var(--font-accent);
            outline: none;
        }

        .premium-sort-btn:hover {
            background: #0b6698;
            color: #ffffff;
            box-shadow: 0 8px 24px rgba(11, 102, 152, 0.15);
        }

        .premium-sort-btn i {
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }

        .premium-sort-btn.active i {
            transform: rotate(180deg);
        }

        .premium-sort-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 12px);
            background: #ffffff;
            border: 1px solid #ebebeb;
            border-radius: 14px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            width: 250px;
            display: none;
            flex-direction: column;
            overflow: hidden;
            z-index: 100;
            padding: 8px 0;
            transform: translateY(-10px);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s cubic-bezier(0.165, 0.84, 0.44, 1), transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .premium-sort-dropdown.show {
            display: flex;
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .premium-sort-item {
            padding: 12px 20px;
            font-size: 0.9rem;
            color: #333333;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.25s ease, color 0.25s ease, padding-left 0.25s ease;
            font-family: var(--font-accent);
            font-weight: 600;
            width: 100%;
            background: transparent;
            border: none;
            text-align: left;
            cursor: pointer;
            outline: none;
        }

        .premium-sort-item:hover {
            background: rgba(11, 102, 152, 0.05);
            color: #0b6698;
            padding-left: 24px;
        }

        .premium-sort-item i {
            font-size: 0.8rem;
            opacity: 0;
            transform: translateX(-5px);
            transition: opacity 0.25s ease, transform 0.25s ease;
            color: #0b6698;
        }

        .premium-sort-item:hover i {
            opacity: 1;
            transform: translateX(0);
        }

        @media (max-width: 991px) {
            .section-header-wrapper {
                flex-direction: column;
                align-items: center;
                gap: 20px;
                margin-bottom: 48px !important;
            }

            .premium-sort-container {
                position: relative;
                right: auto;
                top: auto;
                transform: none;
                width: 100%;
                display: flex;
                justify-content: center;
            }

            .premium-sort-dropdown {
                right: auto;
                left: 50%;
                transform: translateX(-50%) translateY(-10px);
            }

            .premium-sort-dropdown.show {
                transform: translateX(-50%) translateY(0);
            }
        }

        /* ── Premium Categories Grid ── */
        /* ========================
           CATEGORIES — STYLE A: CLEAN WHITE CARDS
           ======================== */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 60px;
        }

        .cat-card-premium {
            background: #ffffff;
            border: 1px solid #ebebeb;
            border-radius: 16px;
            overflow: hidden;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            transition: transform 0.35s cubic-bezier(0.19,1,0.22,1),
                        box-shadow 0.35s cubic-bezier(0.19,1,0.22,1),
                        border-color 0.25s;
        }

        .cat-card-premium:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 48px rgba(0,0,0,0.1);
            border-color: #e0e0e0;
        }

        .cat-img-stage {
            width: 100%;
            height: 180px;
            overflow: hidden;
            background: #f5f5f5;
            flex-shrink: 0;
        }

        .cat-real-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 0.5s ease, transform 0.5s cubic-bezier(0.19,1,0.22,1);
            transform: scale(1.04);
        }

        .cat-real-image.loaded {
            opacity: 1;
            transform: scale(1);
        }

        .cat-card-premium:hover .cat-real-image {
            transform: scale(1.06);
        }

        .cat-content {
            padding: 16px 18px 18px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex: 1;
        }

        .cat-title {
            font-family: var(--font-display);
            font-size: 0.95rem;
            font-weight: 800;
            color: #111111;
            margin: 0;
            line-height: 1.3;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .cat-link {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: auto;
        }

        .cat-link span {
            font-size: 0.72rem;
            font-weight: 800;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            transition: color 0.25s;
        }

        .cat-card-premium:hover .cat-link span {
            color: #0b6698;
        }

        .cat-icon-wrap {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #f3f3f3;
            border: 1px solid #e8e8e8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            color: #888;
            transition: all 0.25s;
            flex-shrink: 0;
        }

        .cat-card-premium:hover .cat-icon-wrap {
            background: #0b6698;
            border-color: #0b6698;
            color: #fff;
            transform: translateX(3px);
        }

        /* Skeleton shimmer */
        .skeleton-loader {
            background: #f0f0f0 !important;
            position: relative;
            overflow: hidden;
        }
        .skeleton-loader::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.7), transparent);
            animation: skeleton-shimmer 1.2s infinite;
            z-index: 10;
        }
        @keyframes skeleton-shimmer {
            0%   { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .categories-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 768px) {
            .categories-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
            .cat-img-stage { height: 150px; }
        }
        @media (max-width: 480px) {
            .categories-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .cat-img-stage { height: 130px; }
            .cat-content { padding: 12px 14px 14px; }
        }

        /* ========================
       HOW IT WORKS — PREMIUM DARK UPLIFT
       ======================== */
        .how-section {
            padding: 70px 40px;
            background: #080810;
            /* Matching the deep dark theme */
            position: relative;
            overflow: hidden;
        }

        .how-section::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 700px;
            height: 700px;
            transform: translate(-50%, -50%);
            background: radial-gradient(circle, rgba(212, 134, 10, .05) 0%, transparent 70%);
            border-radius: 50%;
        }

        .how-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .1), transparent);
        }

        .how-inner {
            max-width: 1240px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* ── Section Header Dark Mode ── */
        .how-section .section-header {
            text-align: center;
            margin-bottom: 64px;
        }

        .how-section .section-eyebrow {
            display: inline-block;
            color: #0b6698 !important;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
            /* text-shadow: 0 0 10px rgba(240, 168, 50, .6); */
        }

        .how-section .section-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 3vw, 2.8rem);
            font-weight: 900;
            color: #0b6698;
            text-shadow: 0 2px 10px rgba(255, 255, 255, .3), 0 0 40px rgba(255, 255, 255, .2);
            margin-bottom: 16px;
        }

        .how-section .section-title span {
            background: linear-gradient(135deg, #FFF 0%, #0b6698 50%, #0b6698 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 16px rgba(255, 255, 255, .6)) drop-shadow(0 2px 4px rgba(255, 255, 255, .3));
        }

        .how-section .section-bar {
            display: block;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #F0A832, #D4860A);
            margin: 0 auto;
            border-radius: 2px;
            box-shadow: 0 0 10px rgba(240, 168, 50, .5);
        }

        .how-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
            margin-top: 64px;
            position: relative;
        }

        /* The connecting line between steps */
        .how-steps::before {
            content: '';
            position: absolute;
            top: 44px;
            left: 10%;
            right: 10%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .2), rgba(255, 255, 255, .5), rgba(255, 255, 255, .2), transparent);
            z-index: 0;
            box-shadow: 0 0 10px rgba(255, 255, 255, .3);
        }

        .step-item {
            text-align: center;
            padding: 0 24px;
            position: relative;
            z-index: 1;
        }

        .step-num-wrap {
            width: 90px;
            height: 90px;
            /* background: #0b0b14; */
            background: #0b0b14;
            border: 2px solid rgba(255, 255, 255, .2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            position: relative;
            transition: .4s cubic-bezier(.23, 1, .32, 1);
            box-shadow: 0 4px 16px rgba(0, 0, 0, .5), inset 0 0 20px rgba(255, 255, 255, .05);
        }

        .step-item:hover .step-num-wrap {
            border-color: rgba(255, 255, 255, .8);
            box-shadow: 0 0 0 8px rgba(255, 255, 255, .15), 0 10px 30px rgba(0, 0, 0, .6), inset 0 0 0 2px rgba(255, 255, 255, .5);
            transform: translateY(-5px);
        }

        .step-num {
            font-family: var(--font-display);
            font-size: 1.9rem;
            font-weight: 900;
            color: #ffffff !important;
            text-shadow: 0 1px 4px rgba(0, 0, 0, .8), 0 0 12px rgba(255, 255, 255, .3);
            transition: .3s;
        }

        .step-item:hover .step-num {
            background: linear-gradient(135deg, #FFF 0%, #F0A832 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, .4));
        }

        .step-icon-layer {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 30px;
            height: 30px;
            /* background: linear-gradient(135deg, #FFF 0%, #F0A832 50%, #D4860A 100%); */
            background: #0c689b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            color: #111;
            border: 2px solid #0c689b;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .5);
            transition: transform .3s ease;
        }

        .step-item:hover .step-icon-layer {
            transform: scale(1.15) rotate(10deg);
        }

        .step-title {
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 800;
            color: #FFF;
            margin-bottom: 12px;
            text-shadow: 0 1px 3px rgba(0, 0, 0, .8);
        }

        .step-desc {
            font-size: .88rem;
            color: #b8b8c8;
            line-height: 1.65;
        }

        /* ========================
       WHY CHOOSE US — LIGHT PROMINENCE
       ======================== */
        .why-section {
            padding: 70px 0;
            background: #fff;
            position: relative;
            overflow: hidden;
            color: var(--text);
        }

        .why-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(1px 1px at 15% 25%, rgba(229, 134, 18, .08) 0%, transparent 0%),
                radial-gradient(1px 1px at 75% 65%, rgba(0, 0, 0, .04) 0%, transparent 0%),
                radial-gradient(1px 1px at 45% 85%, rgba(229, 134, 18, .05) 0%, transparent 0%);
            background-size: 64px 64px, 48px 48px, 96px 96px;
            opacity: 0.15;
        }

        .why-inner {
            max-width: 1240px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .why-header {
            text-align: center;
            margin-bottom: 72px;
        }

        .why-header .section-eyebrow {
            display: inline-block;
            color: #0b6698;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
            text-shadow: none;
        }

        .why-header .section-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 3vw, 2.8rem);
            font-weight: 900;
            color: #111 !important;
            text-shadow: none;
            margin-bottom: 16px;
        }

        .why-header .section-title span {
            color: #0b6698 !important;
            background: none;
            -webkit-background-clip: unset;
            -webkit-text-fill-color: unset;
            background-clip: unset;
            filter: none;
            text-shadow: none;
        }

        .why-header .section-subtitle {
            color: rgba(0, 0, 0, 0.68) !important;
            max-width: 780px;
            margin: 0 auto;
        }

        .why-header .section-bar {
            display: block;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #0b6698, #d4570a);
            margin: 0 auto;
            border-radius: 2px;
            box-shadow: 0 0 10px rgba(229, 83, 18, .25);
        }

        /* Numbered Glass Grid Layout */
        .why-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 24px;
            counter-reset: whyBox;
        }

        .why-cell {
            background: black !important;
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 28px;
            padding: 40px 32px;
            transition: all .6s cubic-bezier(.19, 1, .22, 1);
            position: relative;
            overflow: hidden;
            box-shadow:
                0 15px 35px rgba(0, 0, 0, .4),
                inset 0 0 20px var(--accent)08 !important;
            /* Constant subtle inner glow */
            display: grid;
            grid-template-areas:
                "icon pct"
                "title title"
                "desc desc"
                "track track";
            grid-template-columns: 1fr auto;
            grid-template-rows: auto auto 1fr auto;
            gap: 20px;
        }

        .why-cell:nth-child(1) {
            --accent: #00d2ff;
        }

        .why-cell:nth-child(2) {
            --accent: #8E2DE2;
        }

        .why-cell:nth-child(3) {
            --accent: var(--gold-light);
        }

        .why-cell:nth-child(4) {
            --accent: #38ef7d;
        }

        .why-cell:nth-child(5) {
            --accent: #ff4b2b;
        }

        .why-cell:nth-child(6) {
            --accent: #00c6ff;
        }

        .why-cell:hover {
            transform: translateY(-15px);
            border-color: var(--accent) !important;
            box-shadow:
                0 40px 80px rgba(0, 0, 0, 0.7),
                0 0 30px var(--accent)33 !important;
            /* Stronger outer glow on hover */
        }

        .why-cell::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, var(--accent)15, transparent 65%);
            opacity: 0.5;
            /* Always visible but subtle */
            transition: 0.5s;
            pointer-events: none;
        }

        .why-cell:hover::after {
            opacity: 1;
            background: radial-gradient(circle at top right, var(--accent)22, transparent 70%);
        }

        .why-cell-mask {
            position: absolute;
            inset: 0;
            background: linear-gradient(145deg, rgba(255, 255, 255, .05) 0%, rgba(0, 0, 0, .2) 100%);
            z-index: 1;
            pointer-events: none;
            transition: opacity 0.5s;
        }

        /* UNIQUE MULTI-GRADIENT THEMES */
        /* 1. Quality - Gold */
        .why-cell:nth-child(1):hover {
            border-color: rgba(240, 168, 50, 0.4);
        }

        .why-cell:nth-child(1):hover .why-cell-mask {
            background: linear-gradient(135deg, rgba(212, 134, 10, 0.15) 0%, transparent 100%);
        }

        .why-cell:nth-child(1) .why-icon {
            color: #F0A832;
            background: rgba(240, 168, 50, 0.1);
        }

        .why-cell:nth-child(1) .why-fill {
            background: linear-gradient(90deg, #F0A832, #D4860A);
        }

        /* 2. Variety - Purple */
        .why-cell:nth-child(2):hover {
            border-color: rgba(142, 45, 226, 0.4);
        }

        .why-cell:nth-child(2):hover .why-cell-mask {
            background: linear-gradient(135deg, rgba(142, 45, 226, 0.15) 0%, transparent 100%);
        }

        .why-cell:nth-child(2) .why-icon {
            color: #a18cd1;
            background: rgba(161, 140, 209, 0.1);
        }

        .why-cell:nth-child(2) .why-fill {
            background: linear-gradient(90deg, #8E2DE2, #4A00E0);
        }

        /* 3. Safety - Green */
        .why-cell:nth-child(3):hover {
            border-color: rgba(56, 239, 125, 0.4);
        }

        .why-cell:nth-child(3):hover .why-cell-mask {
            background: linear-gradient(135deg, rgba(56, 239, 125, 0.15) 0%, transparent 100%);
        }

        .why-cell:nth-child(3) .why-icon {
            color: #38ef7d;
            background: rgba(56, 239, 125, 0.1);
        }

        .why-cell:nth-child(3) .why-fill {
            background: linear-gradient(90deg, #11998e, #38ef7d);
        }

        /* 4. Price - Red/Orange */
        .why-cell:nth-child(4):hover {
            border-color: rgba(245, 87, 108, 0.4);
        }

        .why-cell:nth-child(4):hover .why-cell-mask {
            background: linear-gradient(135deg, rgba(245, 87, 108, 0.15) 0%, transparent 100%);
        }

        .why-cell:nth-child(4) .why-icon {
            color: #f5576c;
            background: rgba(245, 87, 108, 0.1);
        }

        .why-cell:nth-child(4) .why-fill {
            background: linear-gradient(90deg, #f093fb, #f5576c);
        }

        /* 5. Fast Delivery - Blue */
        .why-cell:nth-child(5):hover {
            border-color: rgba(0, 198, 255, 0.4);
        }

        .why-cell:nth-child(5):hover .why-cell-mask {
            background: linear-gradient(135deg, rgba(0, 198, 255, 0.15) 0%, transparent 100%);
        }

        .why-cell:nth-child(5) .why-icon {
            color: #00c6ff;
            background: rgba(0, 198, 255, 0.1);
        }

        .why-cell:nth-child(5) .why-fill {
            background: linear-gradient(90deg, #00c6ff, #0072ff);
        }

        /* 6. Support - Midnight */
        .why-cell:nth-child(6):hover {
            border-color: rgba(75, 108, 183, 0.4);
        }

        .why-cell:nth-child(6):hover .why-cell-mask {
            background: linear-gradient(135deg, rgba(75, 108, 183, 0.15) 0%, transparent 100%);
        }

        .why-cell:nth-child(6) .why-icon {
            color: #4b6cb7;
            background: rgba(75, 108, 183, 0.1);
        }

        .why-cell:nth-child(6) .why-fill {
            background: linear-gradient(90deg, #4b6cb7, #182848);
        }

        .why-icon {
            grid-area: icon;
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            border-radius: 18px;
            transition: all .4s cubic-bezier(.23, 1, .32, 1);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .why-cell:hover .why-icon {
            transform: scale(1.1) rotate(-5deg);
            background: #FFF;
            color: #111 !important;
            border-color: #FFF;
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        }

        .why-cell-title {
            grid-area: title;
            font-family: var(--font-display);
            font-size: 1.4rem;
            font-weight: 800;
            color: #FFF;
            margin-top: 8px;
            transition: color .3s;
        }

        .why-cell:hover .why-cell-title {
            color: #FFF;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
        }

        .why-cell-desc {
            grid-area: desc;
            font-size: 0.95rem;
            color: white;
            line-height: 1.6;
            transition: color 0.3s;
        }

        .why-cell:hover .why-cell-desc {
            color: rgba(255, 255, 255, 0.9);
        }

        .why-pct {
            grid-area: pct;
            align-self: center;
            font-family: var(--font-display);
            font-size: 2.4rem;
            font-weight: 900;
            color: #0b6698;
            transition: all .4s;
        }

        .why-cell:hover .why-pct {
            color: #FFF;
            transform: scale(1.1);
        }

        .why-track {
            grid-area: track;
            height: 6px;
            background: rgba(255, 255, 255, .05);
            overflow: hidden;
            border-radius: 10px;
        }

        .why-fill {
            height: 100%;
            width: 0;
            transition: width 1.5s cubic-bezier(.22, 1, .36, 1);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
        }

        /* Stats bar */
        .why-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            margin-top: 60px;
            background: #0b0b18;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 30px 70px rgba(0, 0, 0, .5);
            position: relative;
        }

        .stat-cell {
            padding: 48px 24px;
            text-align: center;
            border-right: 1px solid rgba(255, 255, 255, .05);
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-cell::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.05), transparent);
            opacity: 0;
            transition: 0.4s;
        }

        .stat-cell:hover::before {
            opacity: 1;
        }

        .stat-cell:last-child {
            border-right: none;
        }

        .stat-cell:hover {
            background: rgba(255, 255, 255, .05);
            transform: translateY(-5px);
        }

        .stat-icon-wrap {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, .05);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #FFF;
            margin: 0 auto 16px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, .15);
            box-shadow: inset 0 0 15px rgba(255, 255, 255, .05);
            transition: all 0.4s;
        }

        .stat-cell:hover .stat-icon-wrap {
            background: #F0A832;
            color: #111;
            border-color: #F0A832;
            box-shadow: 0 0 30px rgba(240, 168, 50, 0.4);
            transform: scale(1.1) rotate(10deg);
        }

        .stat-number {
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 900;
            color: #FFF;
            display: block;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: .8rem;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 2px;
            text-transform: uppercase;
            display: block;
            font-weight: 700;
            transition: color 0.3s;
        }

        .stat-cell:hover .stat-label {
            color: #FFF;
        }

        /* ========================
       BRANDS MARQUEE — PREMIUM DARK UPLIFT
       ======================== */
        .brands-section {
            padding: 50px 0;
            background: #080810;
            border-top: 1px solid rgba(255, 255, 255, .05);
            border-bottom: 1px solid rgba(255, 255, 255, .05);
            overflow: hidden;
            position: relative;
        }

        /* ── Section Header Dark Mode ── */
        .brands-header {
            text-align: center;
            margin-bottom: 50px;
            position: relative;
            z-index: 1;
        }

        .brands-header .section-eyebrow {
            display: inline-block;
            color: #F0A832;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
            text-shadow: 0 0 10px rgba(240, 168, 50, .6);
        }

        .brands-header .section-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 3vw, 2.8rem);
            font-weight: 900;
            color: #FFF;
            text-shadow: 0 2px 10px rgba(255, 255, 255, .3), 0 0 40px rgba(255, 255, 255, .2);
            margin-bottom: 16px;
        }

        .brands-header .section-title span {
            background: linear-gradient(135deg, #FFF 0%, #F0A832 50%, #D4860A 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 16px rgba(255, 255, 255, .6)) drop-shadow(0 2px 4px rgba(255, 255, 255, .3));
        }

        .brands-header .section-bar {
            display: block;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #F0A832, #D4860A);
            margin: 0 auto;
            border-radius: 2px;
            box-shadow: 0 0 10px rgba(240, 168, 50, .5);
        }

        .brands-marquee-wrap {
            overflow: hidden;
            position: relative;
            width: 100%;
            padding: 20px 0;
            display: flex;
        }

        .brands-marquee-wrap::before,
        .brands-marquee-wrap::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 150px;
            z-index: 10;
            pointer-events: none;
        }

        .brands-marquee-wrap::before {
            left: 0;
            background: linear-gradient(90deg, #080810, transparent) !important;
        }

        .brands-marquee-wrap::after {
            right: 0;
            background: linear-gradient(-90deg, #080810, transparent) !important;
        }

        .brands-track {
            display: flex !important;
            width: max-content !important;
            animation: marquee 35s linear infinite !important;
            will-change: transform;
        }

        .brands-track:hover {
            animation-play-state: paused !important;
        }

        .brands-group {
            display: flex !important;
            align-items: center !important;
            justify-content: space-around !important;
            flex-shrink: 0 !important;
        }

        @keyframes marquee {
            0% {
                transform: translate3d(0, 0, 0);
            }
            100% {
                transform: translate3d(-50%, 0, 0);
            }
        }

        .brand-card {
            width: 190px;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 24px;
            flex-shrink: 0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
            background: #FFFFFF !important;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            border-radius: 18px !important;
            padding: 16px 24px !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04) !important;
            box-sizing: border-box;
            cursor: pointer;
        }

        .brand-card img {
            width: 100%;
            height: 100%;
            object-fit: contain !important;
            opacity: 0.9;
            transition: all 0.3s ease !important;
        }

        .brand-card:hover {
            transform: scale(1.05) !important;
            box-shadow: 0 12px 25px rgba(240, 168, 50, 0.15), 0 4px 10px rgba(0, 0, 0, 0.05) !important;
            border-color: rgba(240, 168, 50, 0.3) !important;
            z-index: 5;
        }

        .brand-card:hover img {
            opacity: 1 !important;
            filter: brightness(1.05);
        }

        /* Responsive Marquee Behavior */
        @media (max-width: 991px) {
            .brand-card {
                width: 160px !important;
                height: 100px !important;
                margin: 0 16px !important;
                border-radius: 14px !important;
                padding: 12px 18px !important;
            }
            .brands-marquee-wrap::before,
            .brands-marquee-wrap::after {
                width: 100px;
            }
        }

        @media (max-width: 480px) {
            .brand-card {
                width: 130px !important;
                height: 80px !important;
                margin: 0 10px !important;
                border-radius: 12px !important;
                padding: 10px 14px !important;
            }
            .brands-marquee-wrap::before,
            .brands-marquee-wrap::after {
                width: 60px;
            }
        }

        /* ========================
       PROCESS / ORDERING
       ======================== */
        .process-section {
            padding: 70px 40px;
            background: var(--sand);
            position: relative;
            overflow: hidden;
        }

        .process-inner {
            max-width: 1240px;
            margin: 0 auto;
        }

        .process-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            margin-top: 64px;
        }

        .process-visual {
            position: relative;
        }

        .process-main-img {
            width: 100%;
            border: 4px solid var(--stone);
            box-shadow: var(--shadow-lg);
            display: block;
            object-fit: cover;
        }

        .process-badge-float {
            position: absolute;
            bottom: -24px;
            right: -24px;
            background: linear-gradient(135deg, var(--gold-deep), var(--saffron));
            color: #fff;
            padding: 20px 28px;
            box-shadow: var(--shadow-md);
            font-family: var(--font-display);
            text-align: center;
        }

        .process-badge-float .big {
            font-size: 2.2rem;
            font-weight: 900;
            line-height: 1;
        }

        .process-badge-float .small {
            font-size: .7rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: .85;
            margin-top: 4px;
        }

        .process-steps {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .process-step {
            display: flex;
            gap: 24px;
            align-items: flex-start;
            padding: 28px 0;
            border-bottom: 1px solid var(--stone);
            transition: .3s;
        }

        .process-step:last-child {
            border-bottom: none;
        }

        .process-step:hover {
            padding-left: 8px;
        }

        .process-step-num {
            width: 44px;
            height: 44px;
            min-width: 44px;
            background: var(--gold-pale);
            border: 1.5px solid var(--gold-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 900;
            color: var(--gold-deep);
            transition: .3s;
        }

        .process-step:hover .process-step-num {
            background: var(--gold-deep);
            color: #fff;
            border-color: var(--gold-deep);
        }

        .process-step-title {
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .process-step-desc {
            font-size: .86rem;
            color: var(--muted);
            line-height: 1.65;
        }

        /* ========================
       SAFETY SECTION
       ======================== */
        .safety-section {
            padding: 70px 40px;
            background: linear-gradient(135deg, #fff7e8 0%, var(--ivory) 50%, #fff5e0 100%);
            border-top: 1px solid var(--stone);
            border-bottom: 1px solid var(--stone);
        }

        .safety-inner {
            max-width: 1240px;
            margin: 0 auto;
        }

        .safety-layout {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 80px;
            align-items: center;
            margin-top: 60px;
        }

        .safety-callout {
            background: linear-gradient(135deg, var(--gold-deep), var(--saffron));
            padding: 52px 40px;
            text-align: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .safety-callout::after {
            content: '⚠';
            position: absolute;
            bottom: -20px;
            right: -10px;
            font-size: 8rem;
            opacity: .08;
            line-height: 1;
        }

        .safety-callout h3 {
            font-family: var(--font-display);
            font-size: 1.8rem;
            font-weight: 900;
            margin-bottom: 12px;
        }

        .safety-callout p {
            font-size: .9rem;
            opacity: .85;
            line-height: 1.7;
        }

        .safety-tips {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .safety-tip {
            display: flex;
            gap: 16px;
            align-items: flex-start;
            padding: 20px;
            background: var(--cream);
            border: 1px solid var(--stone);
            box-shadow: var(--shadow-sm);
            transition: .3s;
        }

        .safety-tip:hover {
            border-color: var(--gold-light);
            box-shadow: var(--shadow-md);
        }

        .safety-tip-icon {
            width: 42px;
            height: 42px;
            min-width: 42px;
            background: var(--gold-pale);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: var(--gold-deep);
        }

        .safety-tip-title {
            font-weight: 700;
            font-size: .9rem;
            color: var(--ink);
            margin-bottom: 4px;
        }

        .safety-tip-desc {
            font-size: .8rem;
            color: var(--muted);
            line-height: 1.6;
        }

        /* ========================
       TESTIMONIALS
       ======================== */
        .testimonials-section {
            padding: 70px 40px;
            background: #0b0b14;
            position: relative;
            overflow: hidden;
        }

        .testimonials-section::before {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(142, 45, 226, 0.1) 0%, transparent 70%);
            filter: blur(60px);
            pointer-events: none;
        }

        .testi-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 36px;
            border-radius: 24px;
            position: relative;
            transition: all 0.6s cubic-bezier(0.19, 1, 0.22, 1);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        .testi-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(transparent, var(--gold), var(--saffron), transparent 40%);
            animation: borderRotate 8s linear infinite;
            z-index: 0;
            opacity: 0;
            transition: .4s;
        }

        .testi-card:hover::before {
            opacity: 1;
        }

        .testi-card-mask {
            position: absolute;
            inset: 0;
            background: transparent;
            z-index: 1;
        }

        .testi-text {
            color: rgba(255, 255, 255, 0.8) !important;
            font-style: italic;
            line-height: 1.8;
        }

        .testi-author-name {
            color: #fff !important;
            font-weight: 800;
        }

        .testi-stars,
        .testi-text,
        .testi-author-row {
            position: relative;
            z-index: 2;
        }

        .testi-card:hover {
            border-color: var(--gold-light);
            box-shadow: var(--shadow-lg);
            transform: translateY(-5px);
        }

        .testi-stars {
            display: flex;
            gap: 3px;
            margin-bottom: 16px;
        }

        .testi-stars span {
            color: var(--gold);
            font-size: .9rem;
        }

        .testi-text {
            font-size: .96rem;
            color: var(--muted);
            line-height: 1.8;
            font-style: italic;
            margin-bottom: 22px;
            position: relative;
            z-index: 1;
        }

        .testi-author-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .testi-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--gold-pale);
            border: 2px solid var(--gold-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--gold-deep);
        }

        .testi-author {
            font-weight: 700;
            font-size: .88rem;
            color: var(--ink);
        }

        .testi-location {
            font-size: .76rem;
            color: var(--subtle);
            margin-top: 2px;
        }

        /* ========================
       FAQ SECTION
       ======================== */
        .faq-section {
            padding: 70px 40px;
            background: var(--ivory);
        }

        .faq-inner {
            max-width: 860px;
            margin: 0 auto;
        }

        .faq-list {
            margin-top: 56px;
        }

        .faq-item {
            border-bottom: 1px solid var(--stone);
            overflow: hidden;
        }

        .faq-question {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            padding: 22px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            font-family: var(--font-body);
            font-size: 1.02rem;
            font-weight: 600;
            color: var(--ink);
            transition: .3s;
        }

        .faq-question:hover {
            color: var(--gold-deep);
        }

        .faq-q-icon {
            width: 34px;
            height: 34px;
            min-width: 34px;
            background: var(--gold-pale);
            border: 1px solid var(--gold-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold-deep);
            font-size: .8rem;
            transition: .3s;
        }

        .faq-item.open .faq-q-icon {
            background: var(--gold-deep);
            color: #fff;
            border-color: var(--gold-deep);
            transform: rotate(45deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height .45s ease, padding .45s ease;
            padding: 0 0;
            font-size: .92rem;
            color: var(--muted);
            line-height: 1.75;
        }

        .faq-item.open .faq-answer {
            max-height: 300px;
            padding-bottom: 22px;
        }

        /* ========================
       CTA BANNER — PREMIUM DARK UPLIFT
       ======================== */
        .cta-banner {
            padding: 70px 40px;
            /* background: #3d3d43; */
            text-align: center;
            position: relative;
            overflow: hidden;
            border-top: 1px solid rgba(255, 255, 255, .05);
        }

        .cta-banner::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 800px;
            height: 800px;
            transform: translate(-50%, -50%);
            background: radial-gradient(circle, rgba(212, 134, 10, .12) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .cta-banner-inner {
            position: relative;
            z-index: 1;
            max-width: 680px;
            margin: 0 auto;
        }

        .cta-banner h2 {
            font-family: var(--font-display);
            font-size: clamp(2rem, 4.5vw, 3.6rem);
            font-weight: 900;
            /* color: #fff; */
            line-height: 1.1;
            margin-bottom: 18px;
            text-shadow: 0 2px 10px rgba(255, 255, 255, .3), 0 0 40px rgba(255, 255, 255, .2);
        }

        .cta-banner h2 span {
            background: linear-gradient(135deg, #FFF 0%, #0b6698 50%, #0b6698 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 16px rgba(255, 255, 255, .6)) drop-shadow(0 2px 4px rgba(255, 255, 255, .3));
        }

        .cta-banner p {
            /* color: #b8b8c8; */
            font-size: 1.05rem;
            line-height: 1.7;
            margin-bottom: 40px;
        }

        .cta-btn-group {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* ========================
       WHATSAPP FLOAT
       ======================== */
        .wa-float {
            position: fixed;
            bottom: 32px;
            right: 32px;
            width: 58px;
            height: 58px;
            background: #25d366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.55rem;
            color: #fff;
            text-decoration: none;
            z-index: 9000;
            box-shadow: 0 4px 20px rgba(37, 211, 102, .35);
            animation: waFloat 3.5s ease-in-out infinite;
        }

        @keyframes waFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        /* ========================
       SCROLLBAR
       ======================== */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: var(--cream);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 2px;
        }

        /* ========================
         PREMIUM CATALOGUE SECTION
         ======================== */
        .premium-catalogue-section {
            background: #f7f7f8;
            padding: 90px 40px;
            overflow: hidden;
            position: relative;
        }

        .premium-catalogue-inner {
            max-width: 1240px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .premium-catalogue-text h2 {
            font-family: var(--font-display);
            font-size: clamp(2.2rem, 4vw, 3.5rem);
            font-weight: 900;
            color: #043048;
            line-height: 1.15;
            margin-bottom: 24px;
        }

        .premium-catalogue-text p {
            color: #000000;
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 40px;
            max-width: 95%;
        }

        .premium-catalogue-images {
            position: relative;
            height: 450px;
            width: 100%;
        }

        .premium-img-single {
            width: 100%;
            height: 100%;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            object-fit: cover;
            border: 3px solid rgba(0, 0, 0, 0.05);
        }

        @keyframes premium-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .catalogue-cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: #0B6698;
            color: #fff;
            font-weight: 700;
            font-size: .95rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none;
            padding: 16px 36px;
            border-radius: 4px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(11, 102, 152, 0.3);
            border: none;
        }

        .catalogue-cta-btn:hover {
            transform: translateY(-3px);
            background: #084c72;
            box-shadow: 0 12px 30px rgba(11, 102, 152, 0.4);
            color: #fff;
        }

        @media (max-width: 992px) {
            .premium-catalogue-inner {
                grid-template-columns: 1fr;
                text-align: center;
            }
            .premium-catalogue-text p {
                margin: 0 auto 40px;
            }
            .premium-catalogue-images {
                height: 400px;
                margin-top: 20px;
            }
        }

        @media (max-width: 576px) {
            .premium-catalogue-section {
                padding: 60px 20px;
            }
            .premium-catalogue-images {
                height: 280px;
            }
        }

        /* ========================
       RESPONSIVE
       ======================== */
        @media(max-width:1100px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .product-card.featured-card {
                grid-column: span 2;
            }

            .why-grid {
                grid-template-columns: 1fr 1fr;
            }

            .categories-grid {
                grid-template-columns: 1fr 1fr;
            }

            .how-steps {
                grid-template-columns: 1fr 1fr;
                gap: 40px;
            }

            .how-steps::before {
                display: none;
            }

            .safety-layout {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .testi-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media(max-width:768px) {

            .about-inner,
            .process-layout {
                grid-template-columns: 1fr;
                gap: 50px;
            }

            .about-img-accent {
                display: none;
            }

            .product-card.featured-card {
                grid-column: span 1;
                display: block;
            }

            .categories-grid,
            .testi-grid {
                grid-template-columns: 1fr;
            }

            .why-grid {
                grid-template-columns: 1fr;
            }

            .why-stats {
                grid-template-columns: 1fr 1fr;
            }

            .how-steps {
                grid-template-columns: 1fr;
            }

            /* .offer-strip-inner {
                flex-direction: column;
                text-align: center;
            } */

            .offer-counters {
                justify-content: center;
            }

            .hero-float-card {
                display: none;
            }

            .safety-tips {
                grid-template-columns: 1fr;
            }
        }

        @media screen and (max-width: 852px) {
            .hero-slider {
                height: 25vh !important;
                min-height: 207px !important;
            }

            .a-right {
                display: none !important;
            }

            .about-section {
                padding: 20px !important;
            }

            .about-img-badge {
                width: 64px;
                height: 64px;
                top: -2px;
                left: -4px;
            }

            .offer-counters {
                gap: 4px !important;
            }

            .why-grid {
                margin: 10px !important;
            }

            .why-stats {
                margin: 10px !important;
            }

            .f-grid {
                grid-template-columns: repeat(1, 1fr) !important;
            }

        }

        @media screen and (width: 768px) and (height: 1024px) {
            .hero-slider {
                height: 42vh !important;
            }

            .categories-grid {
                grid-template-columns: 1fr 1fr;
            }

            .why-grid {
                grid-template-columns: 1fr 1fr !important;
            }

            .why-stats {
                margin: 20px !important;
            }

            .f-grid {
                grid-template-columns: 1fr 1fr !important;
            }
        }

        @media screen and (width: 820px) and (height: 1180px) {
            .hero-slider {
                height: 42vh !important;
            }

            .categories-grid {
                grid-template-columns: 1fr 1fr;
            }

            .why-grid {
                grid-template-columns: 1fr 1fr !important;
            }

            .why-stats {
                margin: 20px !important;
            }

            .f-grid {
                grid-template-columns: 1fr 1fr !important;
            }

            .about-inner {
                grid-template-columns: 1fr;
                gap: 50px;
            }

            .about-img-col {
                padding: 44px;
            }

            .about-img-accent {
                right: -1px;
            }
        }

       @media screen and (max-height:1367px) and (min-height: 1366px)  {

            .hero-slider {
                height: 45vh !important;
                min-height: 207px !important;
            }

            .about-inner {
                grid-template-columns: 1fr;
                gap: 50px;
            }

            .about-img-col {
                padding: 44px;
            }

            .about-img-accent {
                right: -1px;
            }

        }

        @media screen and (width: 912px) and (height: 1368px) {

            .hero-slider {
                height: 45vh !important;
                min-height: 207px !important;
            }

            .about-inner {
                grid-template-columns: 1fr;
                gap: 50px;
            }

            .about-img-col {
                padding: 44px;
            }

            .about-img-accent {
                right: -1px;
            }

            .why-grid {
                margin: 10px !important;
            }

            .why-stats {
                margin: 20px !important;
            }

        }

        @media screen and (width: 540px) and (height: 720px) {
            .hero-slider {
                height: 40vh !important;
                min-height: 207px !important;
            }
        }

        @media screen and (max-width: 854px) and (min-width: 850px) {

            .hero-slider {
                height: 45vh !important;
                min-height: 207px !important;
            }

            .about-inner {
                grid-template-columns: 1fr;
                gap: 50px;
            }

            .about-img-col {
                padding: 44px;
            }

            .about-img-accent {
                right: -1px;
            }

            .why-grid {
                margin: 10px !important;
            }

            .why-stats {
                margin: 20px !important;
            }

        }
        @media screen and (width: 1280px) and (height: 800px) {
            .hero-slider {
                height: 95vh !important;
                min-height: 207px !important;
            }

        }
        @media screen and (width: 1024px) and (height: 600px) {

            .hero-slider {
                height: 95vh !important;
                min-height: 207px !important;
            }

            .about-inner {
                grid-template-columns: 1fr;
                gap: 50px;
            }

            .about-img-col {
                padding: 44px;
            }

            .about-img-accent {
                right: -1px;
            }

            .why-grid {
                margin: 10px !important;
            }

            .why-stats {
                margin: 20px !important;
            }

        }
    
    </style>

    <!-- Clean layout - no animations -->

    <!-- ========================
         ANNOUNCE BAR
         ======================== -->
    {{-- <div class="announce-bar">
            <span><i class="fa-solid fa-fire"></i> Diwali Sale — Up to 80% Off</span>
            <span>|</span>
            <span><i class="fa-solid fa-truck-fast"></i> Pan-India Delivery</span>
            <span>|</span>
            <span><i class="fa-solid fa-shield-halved"></i> Certified Sivakasi Crackers</span>
        </div> --}}

    <!-- ========================
         COMBINED HERO & BRANDS SECTION
         ======================== -->
    <section class="hero-combined-section">
        
        <!-- Top Half: Banner Slider -->
        <div class="hero-banner-half">
            <div class="hero-slider">
                @foreach($banners as $index => $banner)
                @php
                $bannerUrl = env('MAIN_URL', '/') . $banner->banner_image;
                $is_video = Str::endsWith($banner->banner_image, ['.mp4', '.webm', '.ogg']);
                @endphp
                <div class="slide {{ $index === 0 ? 'active' : '' }}">

                    <!-- Premium Blur Background -->
                    @if(!$is_video)
                    <div class="slide-bg-blur" style="background-image: url('{{ $bannerUrl }}');"></div>
                    <img src="{{ $bannerUrl }}" class="banner-image" alt="Banner {{ $index }}">
                    @else
                    <div class="slide-bg-blur" style="background: #000;"></div>
                    <video autoplay muted loop playsinline class="banner-video">
                        <source src="{{ $bannerUrl }}" type="video/mp4">
                    </video>
                    @endif
                </div>
                @endforeach

                <div class="slider-dots">
                    @foreach($banners as $index => $banner)
                    <div class="dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></div>
                    @endforeach
                </div>

                <!-- <div class="scroll-hint">
                    <div class="scroll-line"></div>
                    <span>Scroll</span>
                </div> -->
            </div>
        </div>

        <!-- Bottom Half: Brands Slider -->
        <div class="hero-brands-half">
            <div class="brands-header" style="margin-bottom: 15px; text-align: center;">
                <span class="section-eyebrow" style="font-size: 0.65rem; margin-bottom: 5px;">Certified &amp; Trusted</span>
                <h2 class="section-title" style="font-size: 1.6rem; color: #FFF; margin-bottom: 2px;">Our Brand <span>Partners</span></h2>
                <span class="section-bar" style="margin-top: 5px; width: 40px; height: 2px;"></span>
            </div>
            
            <div class="brands-marquee-wrap">
                <div class="brands-track" id="brandsTrack">
                    <div class="brands-group">
                        @foreach($brands as $brand)
                        <div class="brand-card">
                            <img src="{{ env('MAIN_URL', '/') . $brand->logo }}" alt="Brand Partner">
                        </div>
                        @endforeach
                    </div>
                    <div class="brands-group">
                        @foreach($brands as $brand)
                        <div class="brand-card">
                            <img src="{{ env('MAIN_URL', '/') . $brand->logo }}" alt="Brand Partner">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section>

@if($settings->offer_end_date && strtotime($settings->offer_end_date) > time())
<div class="offer-strip" id="offer-strip">
    <div class="offer-strip-inner">
        <div class="offer-strip-text">
            <h3>{!! $settings->offer_heading ?? '🔥 Festival Season Sale<br>Ends Soon!' !!}</h3>
            <p>{{ $settings->offer_subheading ?? 'Don\'t miss the biggest cracker sale of the year — limited stock available.' }}</p>
        </div>
        <div class="offer-counters">
            <div class="counter-box">
                <span class="counter-num" id="cnt-days">00</span>
                <div class="counter-lbl">Days</div>
            </div>
            <div class="counter-box">
                <span class="counter-num" id="cnt-hrs">00</span>
                <div class="counter-lbl">Hours</div>
            </div>
            <div class="counter-box">
                <span class="counter-num" id="cnt-min">00</span>
                <div class="counter-lbl">Mins</div>
            </div>
            <div class="counter-box">
                <span class="counter-num" id="cnt-sec">00</span>
                <div class="counter-lbl">Secs</div>
            </div>
        </div>
        <a href="{{ url($settings->offer_button_link ?? 'estimate') }}" class="offer-btn">
            <i class="fa-solid fa-bolt"></i> {{ $settings->offer_button_text ?? 'Shop Now' }}
        </a>
    </div>
</div>
@endif

<!-- ========================
         PREMIUM CATALOGUE SECTION
         ======================== -->
<section class="premium-catalogue-section">
    <div class="premium-catalogue-inner">
        <!-- Text Content -->
        <div class="premium-catalogue-text">
            <h2>Experience the Magic of Premium Crackers</h2>
            <p>Ready to light up your celebrations? Browse our exclusive collection of vibrant, high-quality fireworks crafted for the perfect festive moment. From sparkling fountains to magnificent aerial shots, we have it all.</p>
            <a href="{{ url('estimate') }}" class="catalogue-cta-btn">
                <i class="fa-solid fa-book-open"></i> Explore More Products
            </a>
        </div>
        
        <!-- Imagery -->
        <div class="premium-catalogue-images">
            <img src="{{ asset('assets/img/premium_crackers_boxes.png') }}" alt="Premium Crackers Display" class="premium-img-single">
        </div>
    </div>
</section>

<section class="about-section">
    <div class="about-inner">

        <div class="about-img-col">
            <div class="about-img-badge">
                {{ $settings->welcome_badge_count ?? '25' }}<small>{{ $settings->welcome_badge_label ?? 'Years' }}</small>
            </div>
            <img class="about-img-main" src="{{ env('MAIN_URL', '/') . $settings->welcome_image }}"
                alt="Crackers Store"> 
            <img class="about-img-accent" src="{{ asset('assets/images/night_rockets_bg.png') }}" alt="Crackers Store">
        </div>

        <div class="about-text-col">
            <div class="about-tag">{{ $settings->hero_eyebrow ?? 'Est. Since 1999' }}</div>
            <h2 class="about-title">
                {!! $settings->welcome_heading !!}
                <!-- <em>.</em> -->
            </h2>
            <p class="about-body">{!! strip_tags($settings->welcome_text) !!}</p>

            <div class="about-facts">
                @php
                $dynamicBadges = [
                ['text' => $settings->badge1_text ?? '5000+ Happy Customers', 'icon' => '🏆'],
                ['text' => $settings->badge2_text ?? '200+ Products Available', 'icon' => '🔥'],
                ['text' => $settings->badge3_text ?? '80% Maximum Discount', 'icon' => '🚀'],
                ['text' => $settings->badge4_text ?? '25+ Years of Trust', 'icon' => '🎉'],
                ];
                @endphp
                @foreach($dynamicBadges as $badge)
                @php
                // Attempt to split number and label for consistent styling
                $parts = explode(' ', $badge['text'], 2);
                $number = (preg_match('/[0-9%+\$₹]/', $parts[0])) ? $parts[0] : '';
                $label = $number ? ($parts[1] ?? '') : $badge['text'];
                @endphp
                <div class="fact-item">
                    <span class="fact-icon">{{ $badge['icon'] }}</span>
                    <span class="fact-number">{{ $number ?: '•' }}</span>
                    <div class="fact-label">{{ $label }}</div>
                </div>
                @endforeach
            </div>

            <a href="{{ $settings->welcome_button_link ?? url('estimate') }}" class="about-cta-btn">
                {{ $settings->welcome_button_text ?? 'Explore Collection' }}
                <span class="btn-arrow">→</span>
            </a>
        </div>

    </div>
</section>





{{-- <!-- ========================
         PRODUCTS SECTION
         ======================== -->
        <section class="products-section" id="products">
            <div class="products-inner">
                <div class="section-header">
                    <span class="section-eyebrow">{{ $settings->products_eyebrow ?? 'Handpicked Selection' }}</span>
<h2 class="section-title">{{ $settings->products_heading ?? 'Our Best Sellers' }}</h2>
<span class="section-bar"></span>
<p class="section-subtitle">Explore our curated collection of premium Sivakasi crackers for every
    celebration.</p>
</div>

<div class="products-grid">
    @foreach($products as $index => $product)
    @if($index === 0)
    <div class="product-card featured-card">
        <div class="product-img-wrap">
            <img src="{{ env('MAIN_URL', '/') . $product->product_image }}"
                alt="{{ $product->product_name }}">
        </div>
        <div class="product-info">
            <div class="product-badge">🎆 Featured Pick</div>
            <div class="product-name">{{ $product->product_name }}</div>
            <div class="product-desc">
                {{ $product->product_desc ?? 'Premium quality for every celebration.' }}
            </div>
            <div class="product-divider"></div>
            <div class="product-cat">{{ $product->category->category_name ?? 'Featured' }}</div>
        </div>
    </div>
    @else
    <div class="product-card">
        <span class="product-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
        <div class="product-img-wrap">
            <img src="{{ env('MAIN_URL', '/') . $product->product_image }}"
                alt="{{ $product->product_name }}">
        </div>
        <div class="product-info">
            <div class="product-name">{{ $product->product_name }}</div>
            <div class="product-desc">{{ $product->product_desc ?? 'Grandeur for every festive occasion.' }}
            </div>
            <div class="product-divider"></div>
            <div class="product-cat">{{ $product->category->category_name ?? 'Sivakasi' }}</div>
        </div>
    </div>
    @endif
    @endforeach
</div>
</div>
</section> --}}


<!-- ========================
         CATEGORY SHOWCASE
         ======================== -->
<section class="categories-section">
    <div class="categories-inner">
        @php
        // Fetching categories and their products similarly to the estimate page
        $homeCategories = \App\Models\Category::with('products')->get();
        @endphp

        <div class="section-header-wrapper">
            <div class="section-header">
                <span class="section-eyebrow">Browse by Type</span>
                <h2 class="section-title">Shop by <span>Category</span></h2>
                <span class="section-bar"></span>
            </div>

            <!-- Dynamic Sort By Category Dropdown -->
            <div class="premium-sort-container">
                <button class="premium-sort-btn" id="premiumSortBtn">
                    <span>Sort By Category</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="premium-sort-dropdown" id="premiumSortDropdown">
                    <button type="button" class="premium-sort-item" data-filter="all">
                        <span>All Categories</span>
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </button>
                    @foreach($homeCategories as $category)
                    <button type="button" class="premium-sort-item" data-filter="{{ strtolower($category->category_name) }}">
                        <span>{{ $category->category_name }}</span>
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </button>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="categories-grid">
            @foreach($homeCategories as $category)
            @php
            // Use category_image from DB with robust path handling
            $mainUrl = rtrim(env('MAIN_URL', url('/')), '/');
            $catImage = $category->category_image
            ? $mainUrl . '/' . ltrim($category->category_image, '/')
            : asset('assets/img/categories/img1.jpg');
            @endphp
            <a href="{{ url('estimate') }}?category={{ urlencode(strtolower($category->category_name)) }}" class="cat-card-premium" data-category="{{ strtolower($category->category_name) }}">
                <div class="cat-img-stage skeleton-loader">
                    <img src="{{ $catImage }}" alt="{{ $category->category_name }}" class="cat-real-image" loading="lazy" onload="this.classList.add('loaded'); this.parentElement.classList.remove('skeleton-loader')" onerror="this.src='{{ asset('assets/img/categories/img1.jpg') }}'; this.classList.add('loaded'); this.parentElement.classList.remove('skeleton-loader')">
                </div>
                <div class="cat-content">
                    <h3 class="cat-title">{{ $category->category_name }}</h3>
                    <div class="cat-link">
                        <span>Explore Range</span>
                        <div class="cat-icon-wrap"><i class="fa-solid fa-arrow-right"></i></div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<script>
    function revealImages() {
        // We add a small 500ms delay so the premium shimmer is actually visible 
        // to the user before the image fades in.
        setTimeout(() => {
            const catImages = document.querySelectorAll('.cat-real-image');
            catImages.forEach(img => {
                img.classList.add('loaded');
                if(img.parentElement) {
                    img.parentElement.classList.remove('skeleton-loader');
                }
            });
        }, 500); 
    }

    // Run on Load
    window.addEventListener('load', revealImages);
    // Run on DOM Content Ready
    document.addEventListener('DOMContentLoaded', revealImages);
    // Safety Net: Force reveal after 3 seconds if events fail
    setTimeout(revealImages, 3000);

    // Sort By Category Toggle & Filter
    document.addEventListener('DOMContentLoaded', () => {
        const sortBtn = document.getElementById('premiumSortBtn');
        const sortDropdown = document.getElementById('premiumSortDropdown');
        const catCards = document.querySelectorAll('.cat-card-premium');

        if (sortBtn && sortDropdown) {
            sortBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                sortBtn.classList.toggle('active');
                sortDropdown.classList.toggle('show');
            });

            document.addEventListener('click', (e) => {
                if (!sortDropdown.contains(e.target) && e.target !== sortBtn) {
                    sortBtn.classList.remove('active');
                    sortDropdown.classList.remove('show');
                }
            });

            // Filter items click event
            const filterItems = sortDropdown.querySelectorAll('.premium-sort-item');
            filterItems.forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    const filterValue = item.getAttribute('data-filter');

                    // Filter cards
                    catCards.forEach(card => {
                        const cardCat = card.getAttribute('data-category');
                        if (filterValue === 'all' || cardCat === filterValue) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Update sort button text
                    const btnText = sortBtn.querySelector('span');
                    if (btnText) {
                        if (filterValue === 'all') {
                            btnText.textContent = 'Sort By Category';
                        } else {
                            btnText.textContent = item.querySelector('span').textContent;
                        }
                    }

                    // Scroll to topside of categories section with sticky header offset
                    const categoriesSec = document.querySelector('.categories-section');
                    if (categoriesSec) {
                        const offset = 100;
                        const elementPosition = categoriesSec.getBoundingClientRect().top + window.pageYOffset;
                        const offsetPosition = elementPosition - offset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                    }

                    // Close dropdown
                    sortBtn.classList.remove('active');
                    sortDropdown.classList.remove('show');
                });
            });
        }
    });
</script>


<!-- ========================
         HOW IT WORKS
         ======================== -->
<section class="how-section">
    <div class="how-inner">
        <div class="section-header">
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
</section>


<!-- ========================
         WHY CHOOSE US
         ======================== -->
<section class="why-section" id="why-choose-us">
    <div class="why-inner">

        <div class="why-header">
            <span class="section-eyebrow">{{ $settings->why_heading_data['eyebrow'] ?? 'Our Promise' }}</span>
            <h2 class="section-title" style="color:#fff;">{!! str_replace(['Choose', 'Us'], ['<span>Choose</span>', '<span>Us</span>'], $settings->why_heading_data['title'] ?? 'Why Choose Us') !!}</h2>
            <span class="section-bar"></span>
            <p class="section-subtitle" style="color:rgba(255,255,255,.5);">{{ $settings->why_heading_data['subtitle'] ?? "Built on quality, safety, and unbeatable value — here's what sets us apart." }}</p>
        </div>

        <div class="why-grid">
            @php
            // Hardcoded icons for the 6 feature pillars
            $featureIcons = ['fa-solid fa-award', 'fa-solid fa-layer-group', 'fa-solid fa-shield-halved', 'fa-solid fa-hand-holding-dollar', 'fa-solid fa-truck-fast', 'fa-solid fa-headset'];

            $defaultPillars = [
            ['title' => 'Best Quality', 'desc' => 'Every cracker sourced directly from certified Sivakasi manufacturers.', 'pct' => 98],
            ['title' => 'Huge Variety', 'desc' => 'From sparklers to aerial shells — catalogue for every taste and budget.', 'pct' => 96],
            ['title' => 'Safety First', 'desc' => 'All products meet government safety standards. Family safety is our priority.', 'pct' => 100],
            ['title' => 'Lowest Prices', 'desc' => 'Up to 80% discount with direct factory pricing — no middlemen.', 'pct' => 97],
            ['title' => 'Fast Delivery', 'desc' => 'Pan India delivery with safe, compliant packaging at your doorstep.', 'pct' => 95],
            ['title' => '24/7 Support', 'desc' => 'Our team is always available to help with orders, queries and tracking.', 'pct' => 99],
            ];

            $rawPillars = $settings->why_pillars ?? [];
            @endphp
            @for($i=0; $i<6; $i++)
                @php
                $cell=[ 'icon'=> $featureIcons[$i],
                'title' => $rawPillars[$i]['title'] ?? ($defaultPillars[$i]['title'] ?? ''),
                'desc' => $rawPillars[$i]['desc'] ?? ($defaultPillars[$i]['desc'] ?? ''),
                'pct' => $rawPillars[$i]['pct'] ?? ($defaultPillars[$i]['pct'] ?? 0),
                ];
                @endphp
                <div class="why-cell">
                    <div class="why-cell-mask"></div>
                    <div class="why-icon"><i class="{{ $cell['icon'] }}"></i></div>
                    <div class="why-cell-title">{{ $cell['title'] }}</div>
                    <div class="why-cell-desc">{{ $cell['desc'] }}</div>
                    <div class="why-pct">{{ $cell['pct'] }}%</div>
                    <div class="why-track">
                        <div class="why-fill" data-width="{{ $cell['pct'] }}"></div>
                    </div>
                </div>
                @endfor
        </div>

        <!-- Stats -->
        <div class="why-stats">
            @php
            // Hardcoded icons for bottom stats
            $statIcons = ['fa-solid fa-users', 'fa-solid fa-box-open', 'fa-solid fa-percent', 'fa-solid fa-globe'];

            $defaultStats = [
            ['number' => '5000+', 'label' => 'Happy Customers'],
            ['number' => '200+', 'label' => 'Products'],
            ['number' => '80%', 'label' => 'Max Discount'],
            ['number' => 'PAN India', 'label' => 'Delivery'],
            ];

            $rawStats = $settings->why_stats ?? [];
            @endphp
            @for($i=0; $i<4; $i++)
                @php
                $stat=[ 'icon'=> $statIcons[$i],
                'number' => $rawStats[$i]['number'] ?? $rawStats[$i]['value'] ?? ($defaultStats[$i]['number'] ?? ''),
                'label' => $rawStats[$i]['label'] ?? ($defaultStats[$i]['label'] ?? ''),
                ];
                @endphp
                <div class="stat-cell">
                    <div class="stat-icon-wrap"><i class="{{ $stat['icon'] }}"></i></div>
                    <span class="stat-number">{{ $stat['number'] }}</span>
                    <span class="stat-label">{{ $stat['label'] }}</span>
                </div>
                @endfor
        </div>

    </div>
</section>




{{--
        <!-- ========================
         HOW TO ORDER / PROCESS
         ======================== -->
        <section class="process-section">
            <div class="process-inner">
                <div class="section-header" style="text-align:left; margin-bottom: 0;">
                    <span class="section-eyebrow" style="justify-content:flex-start;">Our Commitment</span>
                    <h2 class="section-title">Order With <span>Confidence</span></h2>
                </div>

                <div class="process-layout">
                    <div class="process-visual">
                        <img class="process-main-img" src="{{ env('MAIN_URL', '/') . $settings->welcome_image }}"
alt="Order Process">
<div class="process-badge-float">
    <div class="big">80%</div>
    <div class="small">Discount</div>
</div>
</div>

<div class="process-steps">
    @php
    $orderSteps = [
    ['num' => '01', 'title' => 'Direct from Sivakasi', 'desc' => 'We source all crackers directly from
    certified manufacturers in Sivakasi — no middlemen, maximum savings.'],
    ['num' => '02', 'title' => 'Safe & Legal Packaging', 'desc' => 'Every order is packed per government
    guidelines to ensure safe transit across all states in India.'],
    ['num' => '03', 'title' => 'Real-Time Order Tracking', 'desc' => 'Get live updates on your shipment
    via WhatsApp from the moment your order is dispatched.'],
    ['num' => '04', 'title' => 'Easy Returns & Support', 'desc' => 'Any issue with your order? Our
    dedicated team resolves it within 24 hours, no questions asked.'],
    ];
    @endphp
    @foreach($orderSteps as $os)
    <div class="process-step">
        <div class="process-step-num">{{ $os['num'] }}</div>
        <div>
            <div class="process-step-title">{{ $os['title'] }}</div>
            <div class="process-step-desc">{{ $os['desc'] }}</div>
        </div>
    </div>
    @endforeach
</div>
</div>
</div>
</section>


<!-- ========================
         SAFETY SECTION
         ======================== -->
<section class="safety-section">
    <div class="safety-inner">
        <div class="section-header">
            <span class="section-eyebrow">Your Family First</span>
            <h2 class="section-title">Safety <span>Guidelines</span></h2>
            <span class="section-bar"></span>
        </div>

        <div class="safety-layout">
            <div class="safety-callout">
                <h3>🛡️ We Prioritise Your Safety</h3>
                <p>All our products are sourced from government-certified manufacturers and comply with all Indian
                    safety regulations.</p>
            </div>
            <div class="safety-tips">
                @php
                $tips = [
                ['icon' => 'fa-solid fa-person-rays', 'title' => 'Adult Supervision', 'desc' => 'Always ensure
                crackers are lit by adults. Keep children at a safe distance at all times.'],
                ['icon' => 'fa-solid fa-bucket', 'title' => 'Keep Water Nearby', 'desc' => 'Always keep a bucket of
                water or sand handy to extinguish crackers quickly if needed.'],
                ['icon' => 'fa-solid fa-eye', 'title' => 'Eye Protection', 'desc' => 'Use safety glasses when
                lighting crackers to protect your eyes from sparks and debris.'],
                ['icon' => 'fa-solid fa-location-arrow', 'title' => 'Safe Distance', 'desc' => 'Maintain at least 5
                metres distance after lighting. Never lean over a lit firework.'],
                ];
                @endphp
                @foreach($tips as $tip)
                <div class="safety-tip">
                    <div class="safety-tip-icon"><i class="{{ $tip['icon'] }}"></i></div>
                    <div>
                        <div class="safety-tip-title">{{ $tip['title'] }}</div>
                        <div class="safety-tip-desc">{{ $tip['desc'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


<!-- ========================
         TESTIMONIALS
         ======================== -->
<section class="testimonials-section">
    <div class="testimonials-inner">
        <div class="section-header">
            <span class="section-eyebrow">What They Say</span>
            <h2 class="section-title">Happy <span>Customers</span></h2>
            <span class="section-bar"></span>
        </div>

        <div class="testi-grid">
            @php
            $testimonials = [
            ['text' => 'Best quality crackers! The delivery was prompt and the colors were magnificent. Absolutely
            loved the whole experience. Will definitely order again this Diwali.', 'author' => 'Rajesh Kumar',
            'location' => 'Chennai, Tamil Nadu', 'init' => 'R'],
            ['text' => 'Safety first! I only trust them for my kids. The non-noise collection is superb. Wonderful
            packaging and very fast delivery. Highly recommended!', 'author' => 'Ananya Sharma', 'location' =>
            'Mumbai, Maharashtra', 'init' => 'A'],
            ['text' => 'Amazing prices and top quality. Ordered for our community event and everyone was impressed.
            The aerial shells were simply spectacular!', 'author' => 'Suresh Venkat', 'location' => 'Bangalore,
            Karnataka', 'init' => 'S'],
            ];
            @endphp
            @foreach($testimonials as $t)
            <div class="testi-card">
                <div class="testi-card-mask"></div>
                <div class="testi-stars">
                    <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                </div>
                <p class="testi-text">"{{ $t['text'] }}"</p>
                <div class="testi-author-row">
                    <div class="testi-avatar">{{ $t['init'] }}</div>
                    <div>
                        <div class="testi-author">{{ $t['author'] }}</div>
                        <div class="testi-location">{{ $t['location'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- ========================
         FAQ SECTION
         ======================== -->
<section class="faq-section">
    <div class="faq-inner">
        <div class="section-header">
            <span class="section-eyebrow">Got Questions?</span>
            <h2 class="section-title">Frequently Asked <span>Questions</span></h2>
            <span class="section-bar"></span>
        </div>

        <div class="faq-list">
            @php
            $faqs = [
            ['q' => 'Is it safe to order crackers online?', 'a' => 'Absolutely. We are a licensed and
            government-certified retailer. All products are packed securely and shipped through approved carriers in
            compliance with all state and national regulations.'],
            ['q' => 'What is the minimum order value?', 'a' => 'Our minimum order value is ₹1,500. This ensures we
            can ship your order safely and economically via our partner logistics providers.'],
            ['q' => 'How long does delivery take?', 'a' => 'Delivery typically takes 3–7 business days depending on
            your location. We ship Pan-India. You\'ll receive a tracking number via WhatsApp once dispatched.'],
            ['q' => 'Do you offer bulk / wholesale pricing?', 'a' => 'Yes! We offer attractive wholesale pricing for
            bulk orders. Please contact us on WhatsApp or fill out the inquiry form with your requirements for a
            custom quote.'],
            ['q' => 'Can I return or exchange items?', 'a' => 'Due to the nature of the product, we do not accept
            returns. However, if you receive a damaged or incorrect item, please contact us within 48 hours of
            delivery and we will resolve it immediately.'],
            ['q' => 'How do I get the price list?', 'a' => 'Click the "Get Price List" button on the homepage to
            download our full product catalogue with current prices. It\'s updated regularly with festival
            discounts.'],
            ];
            @endphp
            @foreach($faqs as $faq)
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span>{{ $faq['q'] }}</span>
                    <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
                </button>
                <div class="faq-answer">{{ $faq['a'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section> --}}


<!-- ========================
         CTA BANNER
         ======================== -->
<section class="cta-banner">
    <div class="cta-banner-inner">
        <h2>{!! str_replace(['in Style?'], ['<span>in Style?</span>'], $settings->cta_data['title'] ?? 'Ready to Celebrate in Style?') !!}</h2>
        <p>{{ $settings->cta_data['desc'] ?? 'Download our price list, browse 200+ products, and order directly on WhatsApp. Pan India delivery — straight from Sivakasi to your doorstep.' }}</p>
        <div class="cta-btn-group">
            <a href="{{ route('pricelist.download') }}" class="btn-primary">
                <i class="fa-solid fa-download"></i> {{ $settings->cta_data['btn1_text'] ?? 'Download Price List' }}
            </a>
            <a href="https://wa.me/+916380195167" class="btn-whatsapp" target="_blank">
                <i class="fa-brands fa-whatsapp"></i> {{ $settings->cta_data['btn2_text'] ?? 'Chat on WhatsApp' }}
            </a>
        </div>
    </div>
</section>





<!-- ========================
         JAVASCRIPT
         ======================== -->
@push('scripts')
<script>
(function () {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    let current = 0;

    function goToSlide(n) {
        if (!slides.length) return;
        
        let oldCurrent = current;
        current = (n + slides.length) % slides.length;
        
        // 1) Make the old slide transition out to the left
        slides[oldCurrent].classList.remove('active');
        slides[oldCurrent].classList.add('prev');
        if (dots[oldCurrent]) dots[oldCurrent].classList.remove('active');
        
        // 2) Instantly position all other slides (including the new one) to the right
        slides.forEach((s, i) => {
            if (i !== oldCurrent) {
                s.classList.add('no-transition');
                s.classList.remove('prev');
                s.classList.remove('active');
            }
        });
        
        // 3) Force the browser to render them on the right side without animation
        void slides[current].offsetWidth; 
        
        // 4) Re-enable transitions and trigger the slide in from the right
        slides.forEach(s => s.classList.remove('no-transition'));
        slides[current].classList.add('active');
        if (dots[current]) dots[current].classList.add('active');
    }

    if (slides.length > 1) {
        // Initial setup for first slide
        slides.forEach((s, i) => {
            if (i !== current) {
                s.classList.add('no-transition');
            }
        });
        slides[current].classList.add('active');
        if (dots[current]) dots[current].classList.add('active');
        
        void slides[current].offsetWidth;
        slides.forEach(s => s.classList.remove('no-transition'));
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                if (current !== index) goToSlide(index);
            });
        });
        
        setInterval(() => goToSlide(current + 1), 5000);
    }

    const revealEls = document.querySelectorAll('.product-card, .why-cell, .step-item, .testi-card, .cat-card, .process-step, .safety-tip, .fact-item, .faq-item, .stat-cell');
    if ('IntersectionObserver' in window && revealEls.length) {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        revealEls.forEach(el => {
            el.style.opacity = 0;
            el.style.transform = 'translateY(18px)';
            el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(el);
        });
    }

    function updateCountdown() {
        const target = new Date("{{ $settings->offer_end_date ? date('Y-m-d H:i:s', strtotime($settings->offer_end_date)) : '2026-10-30 00:00:00' }}");
        const now = new Date();
        const diff = target - now;
        if (diff <= 0) return;
        const d = Math.floor(diff / 86400000),
            h = Math.floor((diff % 86400000) / 3600000),
            m = Math.floor((diff % 3600000) / 60000),
            s = Math.floor((diff % 60000) / 1000);
        const pad = n => String(n).padStart(2, '0');
        const dEl = document.getElementById('cnt-days'),
            hEl = document.getElementById('cnt-hrs'),
            mEl = document.getElementById('cnt-min'),
            sEl = document.getElementById('cnt-sec');
        if (dEl) dEl.textContent = pad(d);
        if (hEl) hEl.textContent = pad(h);
        if (mEl) mEl.textContent = pad(m);
        if (sEl) sEl.textContent = pad(s);
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);

    document.querySelectorAll('.faq-question, .faq-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const item = btn.closest('.faq-item');
            if (!item) return;
            document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
            item.classList.toggle('open');
        });
    });
})();
</script>
<!-- BRANDS MARQUEE ANIMATION HANDLED VIA CSS KEYFRAMES FOR 60FPS SMOOTHNESS -->
@endpush


</div>
@endsection