@extends('layouts.default')

@section('main-page')


<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="main-page-wrap">
<canvas id="fireworks-canvas"></canvas>
<div id="stars-container"></div>
<div class="smoke-overlay"></div>

<style>

:root {
    --gold:        #FFAE00;
    --gold-deep:   #FF6F00;
    --gold-light:  #FFD54F;
    --gold-pale:   #FFF8E1;
    --saffron:     #FF3D00;
    --emerald:     #00C896;


    --bg:          #FFFFFF;
    --surface-1:   #FFFFFF;
    --surface-2:   #F8F9FA;
    --surface-3:   #F1F3F5;
    --border:      rgba(0,0,0,0.06);
    --border-gold: rgba(255,174,0,0.25);
    --ink:         #1A1A2A;
    --muted:       #6B7280;
    --subtle:      #9CA3AF;


    --glow-gold:   rgba(255,174,0,0.3);
    --glow-fire:   rgba(255,61,0,0.4);
    --glow-soft:   rgba(255,174,0,0.08);


    --shadow-sm:   0 4px 16px rgba(255,110,0,0.08);
    --shadow-md:   0 12px 40px rgba(255,140,0,0.12);
    --shadow-lg:   0 20px 60px rgba(255, 140, 0, 0.18);
    --shadow-dark: 0 10px 30px rgba(0,0,0,0.05);


    --font-display: 'Outfit', sans-serif;
    --font-body:    'Outfit', sans-serif;


    --radius-sm:   8px;
    --radius-md:   20px;
    --radius-lg:   32px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }

body {
    background: var(--bg);
    color: var(--ink);
    font-family: var(--font-body);
    overflow-x: hidden;
}


#fireworks-canvas {
    position: fixed; inset: 0;
    pointer-events: none;
    z-index: 2;
    width: 100%; height: 100%;
}


#stars-container {
    position: fixed; inset: 0;
    pointer-events: none;
    z-index: 0;
    background: radial-gradient(circle at 50% 0%, #FFFDF7 0%, #FFFFFF 100%);
}
.nebula {
    position: absolute; border-radius: 50%;
    filter: blur(90px); pointer-events: none;
}
.star {
    position: absolute; background: #fff;
    border-radius: 50%; opacity: 0;
}
.star.twinkle {
    animation: twinkleStar var(--dur,3s) infinite alternate ease-in-out;
    animation-delay: var(--delay,0s);
}
@keyframes twinkleStar {
    0%   { opacity: 0.1; transform: scale(0.7); }
    100% { opacity: var(--op,0.9); transform: scale(1.15); box-shadow: 0 0 6px var(--glow-color,#fff); }
}
.shooting-star {
    position: absolute; height: 1px;
    background: linear-gradient(90deg, #fff 0%, rgba(255,174,0,0.6) 40%, transparent 100%);
    opacity: 0; transform-origin: left center;
    border-radius: 999px;
}
@keyframes shoot {
    0%   { opacity: 0; transform: translateX(0) rotate(-25deg) scaleX(0); }
    5%   { opacity: 1; }
    100% { opacity: 0; transform: translateX(-600px) rotate(-25deg) scaleX(1); }
}


.smoke-overlay {
    position: fixed; inset: 0;
    pointer-events: none; z-index: 1;
    background: radial-gradient(circle at 50% 50%, rgba(255,174,0,0.025) 0%, transparent 65%);
    animation: smokeDrift 22s linear infinite alternate;
}
@keyframes smokeDrift {
    0%   { transform: scale(1) translate(0,0); }
    100% { transform: scale(1.08) translate(-20px,10px); }
}


.ground-layer {
    position: fixed; bottom: 0; left: 0; right: 0;
    height: 120px; pointer-events: none; z-index: 3;
}
.chakkar {
    position: absolute; bottom: 12px;
    width: 36px; height: 36px;
}
.chakkar-inner {
    width: 100%; height: 100%;
    border: 3px solid var(--gold);
    border-top-color: var(--saffron);
    border-radius: 50%;
    animation: spin 0.3s linear infinite;
    box-shadow: 0 0 12px var(--glow-gold);
}
@keyframes spin { to { transform: rotate(360deg); } }

.sparkler-wrap { position: absolute; bottom: 0; }
.sparkler-stick {
    width: 4px; height: 60px;
    background: linear-gradient(to bottom, #888, #555);
    position: relative;
}
.sparkler-tip {
    width: 8px; height: 8px;
    background: var(--gold-light);
    border-radius: 50%;
    position: absolute; top: -4px; left: -2px;
    box-shadow: 0 0 12px 4px var(--glow-gold);
    animation: tipGlow 0.15s infinite alternate;
}
@keyframes tipGlow {
    to { box-shadow: 0 0 18px 8px var(--glow-fire); }
}

.flowerpot-wrap { position: absolute; bottom: 0; }
.flowerpot-body {
    width: 24px; height: 32px;
    background: linear-gradient(to bottom, #8B4513, #5C2D0A);
    clip-path: polygon(15% 0%, 85% 0%, 100% 100%, 0% 100%);
    box-shadow: 0 0 8px var(--glow-gold);
}

.roman-wrap { position: absolute; bottom: 0; }
.roman-tube {
    width: 12px; height: 50px;
    background: linear-gradient(to right, #444, #666, #444);
    border-radius: 2px;
}

.smoke-puff {
    position: fixed;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,180,140,0.25) 0%, transparent 70%);
    pointer-events: none; z-index: 2;
    animation: puffUp var(--sd,2s) ease-out forwards;
}
@keyframes puffUp {
    0%   { opacity: 0.7; transform: scale(0.5) translateY(0); }
    100% { opacity: 0;   transform: scale(1.8) translateY(var(--sy,-80px)); }
}

.atom-flash {
    position: fixed;
    left: var(--fx,50%); top: var(--fy,50%);
    transform: translate(-50%,-50%);
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(255,220,100,0.5) 0%, transparent 70%);
    border-radius: 50%;
    animation: flashOut 0.7s ease-out forwards;
    pointer-events: none; z-index: 100;
}
@keyframes flashOut { to { opacity: 0; transform: translate(-50%,-50%) scale(2); } }


::-webkit-scrollbar { width: 4px; }
::-webkit-scrollbar-track { background: var(--surface-1); }
::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 2px; }


.glass-card {
    background: rgba(255, 255, 255, 0.45);
    backdrop-filter: blur(20px) saturate(140%);
    -webkit-backdrop-filter: blur(20px) saturate(140%);
    border: 1px solid rgba(255, 255, 255, 0.4);
    box-shadow:
        0 20px 40px rgba(255, 140, 0, 0.08),
        0 1px 3px rgba(0,0,0,0.05),
        inset 0 1px 1px rgba(255,255,255,0.8);
    transition: all 0.45s cubic-bezier(0.22,1,0.36,1);
    border-radius: var(--radius-lg);
    position: relative; overflow: hidden;
}
.glass-card::after {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(circle at 20% 15%, rgba(255,255,255,0.04) 0%, transparent 55%);
    pointer-events: none; z-index: 1;
}
.glass-card:hover {
    background: rgba(255,255,255,0.7);
    border-color: rgba(255,174,0,0.4);
    box-shadow:
        0 32px 72px rgba(255,140,0,0.15),
        0 10px 28px rgba(255,174,0,0.08);
    transform: translateY(-8px);
}


.announce-bar {
    background: linear-gradient(90deg, #8B0000, var(--gold-deep) 30%, var(--saffron) 55%, var(--gold) 80%, #8B0000);
    background-size: 200% auto;
    animation: barShift 6s linear infinite;
    color: #fff;
    text-align: center;
    font-size: .76rem;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    padding: 11px 20px;
    position: relative; z-index: 100;
}
@keyframes barShift { to { background-position: 200% center; } }
.announce-bar span { margin: 0 20px; }
.announce-bar i { opacity: .8; margin-right: 5px; }


.hero-slider {
    position: relative;
    height: 100vh; min-height: 660px;
    overflow: hidden;
    background: var(--bg);
}
.slide {
    position: absolute; inset: 0;
    background-size: cover; background-position: center;
    opacity: 0; transition: opacity 1.4s ease;
    display: flex; align-items: center; justify-content: flex-start;
    padding: 0 8%;
}
.slide.active { opacity: 1; }
.slide::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(105deg,
        rgba(255,255,255,.85) 0%,
        rgba(255,255,255,.6) 38%,
        rgba(255,255,255,.2) 65%,
        transparent 100%);
}
.banner-video {
    position: absolute; inset: 0;
    width: 100%; height: 100%; object-fit: cover;
}
.slide-content {
    position: relative; z-index: 10;
    max-width: 620px;
}
.hero-eyebrow {
    display: inline-flex; align-items: center; gap: 10px;
    background: rgba(45,31,13,0.8);
    border: 1px solid var(--gold-light);
    color: var(--gold-light);
    font-size: .7rem; font-weight: 700;
    letter-spacing: 3.5px; text-transform: uppercase;
    padding: 7px 18px; margin-bottom: 28px;
    backdrop-filter: blur(8px);
}
.hero-eyebrow::before { content: '✦'; color: var(--gold); }

.hero-title {
    font-family: var(--font-display);
    font-size: clamp(2.8rem, 6vw, 5.8rem);
    font-weight: 900; line-height: 1.04;
    color: var(--ink); margin-bottom: 22px;
    text-shadow: 0 4px 20px rgba(255,255,255,0.8);
}
.hero-title em {
    font-style: normal;
    background: linear-gradient(135deg, var(--gold) 0%, var(--saffron) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
    filter: drop-shadow(0 0 20px var(--glow-fire));
}
.hero-title em::after {
    content: '';
    position: absolute; bottom: 2px; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--gold), var(--saffron));
    border-radius: 2px;
    -webkit-filter: none; filter: none;
}
.hero-sub {
    color: var(--muted);
    font-size: 1.06rem; line-height: 1.8;
    margin-bottom: 40px; max-width: 490px;
}
.hero-btns { display: flex; gap: 14px; flex-wrap: wrap; }

.btn-primary {
    display: inline-flex; align-items: center; gap: 10px;
    background: linear-gradient(135deg, var(--gold-deep) 0%, var(--saffron) 100%);
    color: #fff; font-weight: 700; font-size: .86rem;
    letter-spacing: 1.5px; text-transform: uppercase;
    text-decoration: none; padding: 15px 36px;
    border: none; cursor: pointer;
    border-radius: 3px;
    box-shadow: var(--shadow-md), 0 0 0 0 rgba(255,110,0,0);
    transition: all .3s ease;
    position: relative; overflow: hidden;
}
.btn-primary::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
    opacity: 0; transition: .3s;
}
.btn-primary:hover::before { opacity: 1; }
.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg), 0 0 0 6px rgba(255,110,0,0.12);
}

.btn-outline {
    display: inline-flex; align-items: center; gap: 10px;
    background: rgba(255,255,255,0.06);
    backdrop-filter: blur(10px);
    border: 1.5px solid rgba(255,174,0,0.5);
    color: var(--gold-light); font-weight: 700; font-size: .86rem;
    letter-spacing: 1.5px; text-transform: uppercase;
    text-decoration: none; padding: 14px 32px;
    border-radius: 3px; transition: .3s;
}
.btn-outline:hover {
    background: var(--gold-pale);
    border-color: var(--gold);
    color: var(--gold);
    box-shadow: var(--shadow-sm);
    transform: translateY(-3px);
}

.btn-whatsapp {
    display: inline-flex; align-items: center; gap: 10px;
    background: #25D366 !important;
    border: 1.5px solid #25D366 !important;
    color: #fff !important; font-weight: 700; font-size: .86rem;
    letter-spacing: 1.5px; text-transform: uppercase;
    text-decoration: none; padding: 14px 32px;
    border-radius: 3px; transition: .3s;
}

.btn-whatsapp:hover {
    background: #1ebc59 !important;
    border-color: #1ebc59 !important;
    box-shadow: var(--shadow-sm);
    transform: translateY(-3px);
    color: #fff !important;
}

.hero-badges {
    display: flex; gap: 28px; margin-top: 44px; flex-wrap: wrap;
}
.hero-badge-item {
    display: flex; align-items: center; gap: 8px;
    font-size: .76rem; font-weight: 600;
    color: rgba(255,255,255,0.5);
}
.hero-badge-item i { color: var(--gold); }


.slider-dots {
    position: absolute; bottom: 34px; left: 8%;
    display: flex; gap: 10px; z-index: 20;
}
.dot {
    width: 8px; height: 8px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%; cursor: pointer; transition: .35s;
}
.dot.active {
    background: var(--gold); width: 28px;
    border-radius: 4px; box-shadow: 0 0 12px var(--glow-gold);
}


.scroll-hint {
    position: absolute; bottom: 42px; right: 8%;
    z-index: 20; display: flex; flex-direction: column;
    align-items: center; gap: 8px;
    font-size: .6rem; letter-spacing: 3px;
    text-transform: uppercase; color: rgba(255,255,255,0.3);
}
.scroll-line {
    width: 1px; height: 50px;
    background: linear-gradient(to bottom, var(--gold), transparent);
    animation: scrollPulse 2s infinite;
}
@keyframes scrollPulse { 0%,100%{opacity:.2;} 50%{opacity:1;} }


.hero-float-card {
    position: absolute; right: 6%; bottom: 12%;
    z-index: 15;
    background: rgba(13,13,22,0.9);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border-gold);
    box-shadow: var(--shadow-lg);
    padding: 22px 28px;
    display: flex; align-items: center; gap: 18px;
    min-width: 260px; border-radius: var(--radius-md);
    animation: floatCard 4s ease-in-out infinite;
}
@keyframes floatCard {
    0%,100% { transform: translateY(0); }
    50%      { transform: translateY(-10px); }
}
.float-card-icon {
    width: 54px; height: 54px;
    background: var(--gold-pale);
    border-radius: var(--radius-sm);
    display: flex; align-items: center;
    justify-content: center; font-size: 1.6rem;
}
.float-card-text { font-size: .8rem; color: var(--muted); }
.float-card-text strong {
    display: block; font-size: 1.22rem;
    font-family: var(--font-display); font-weight: 700;
    color: #fff; margin-top: 2px;
}


.section-eyebrow {
    display: inline-flex; align-items: center; gap: 10px;
    font-size: .68rem; font-weight: 700;
    letter-spacing: 4px; text-transform: uppercase;
    color: var(--gold); margin-bottom: 14px;
}
.section-eyebrow::before, .section-eyebrow::after {
    content: ''; display: block;
    width: 30px; height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold));
}
.section-eyebrow::after {
    background: linear-gradient(90deg, var(--gold), transparent);
}

.section-title {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4vw, 3.5rem);
    font-weight: 900; line-height: 1.08;
    color: var(--ink);
}
.section-title span {
    background: linear-gradient(135deg, var(--gold) 0%, var(--saffron) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    filter: drop-shadow(0 0 18px var(--glow-gold));
}
.section-subtitle {
    font-size: 1rem; color: var(--muted);
    line-height: 1.75; max-width: 520px;
    margin: 14px auto 0;
}
.section-bar {
    display: block; width: 52px; height: 3px;
    background: linear-gradient(90deg, var(--gold-deep), var(--gold-light));
    border-radius: 2px; margin: 18px auto 0;
    box-shadow: 0 0 12px var(--glow-gold);
}


.about-section {
    padding: 130px 40px;
    position: relative; overflow: hidden;
    background: transparent;
}
.about-section::before {
    content: '';
    position: absolute; top: -200px; right: -200px;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(255,174,0,.06) 0%, transparent 70%);
    border-radius: 50%; pointer-events: none;
}
.about-inner {
    max-width: 1240px; margin: 0 auto;
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 90px; align-items: center;
    position: relative; z-index: 2;
}
.about-img-col { position: relative; }
.about-img-main {
    width: 100%; display: block; object-fit: cover;
    border-radius: var(--radius-md);
    border: 1px solid var(--border-gold);
    box-shadow: var(--shadow-md);
    position: relative; z-index: 2;
}
.about-img-accent {
    position: absolute; bottom: -30px; right: -30px;
    width: 44%; border-radius: var(--radius-sm);
    border: 2px solid var(--border-gold);
    box-shadow: var(--shadow-md);
    z-index: 3; display: block; object-fit: cover;
}
.about-img-badge {
    position: absolute; top: -20px; left: -20px; z-index: 4;
    width: 96px; height: 96px; border-radius: var(--radius-sm);
    background: linear-gradient(135deg, var(--gold-deep), var(--saffron));
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    box-shadow: var(--shadow-md), 0 0 24px var(--glow-fire);
    color: #fff; font-family: var(--font-display);
    font-size: 2.2rem; font-weight: 900; line-height: 1;
}
.about-img-badge small {
    font-size: .58rem; font-weight: 600;
    letter-spacing: 2px; text-transform: uppercase;
}

.about-tag {
    display: inline-block;
    background: var(--gold-pale); border: 1px solid var(--border-gold);
    color: var(--gold); font-size: .68rem; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase;
    padding: 6px 14px; margin-bottom: 20px;
    border-radius: 3px;
}
.about-title {
    font-family: var(--font-display);
    font-size: clamp(2rem, 3.5vw, 3rem);
    font-weight: 900; line-height: 1.12;
    color: var(--ink); margin-bottom: 22px;
}
.about-title em {
    font-style: normal;
    background: linear-gradient(135deg, var(--gold), var(--saffron));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.about-body {
    color: var(--muted); font-size: 1rem;
    line-height: 1.88; margin-bottom: 34px;
}
.about-facts {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 14px; margin-bottom: 38px;
}
.fact-item {
    padding: 18px 22px;
    background: var(--surface-2);
    border: 1px solid var(--border);
    border-left: 3px solid var(--gold);
    border-radius: var(--radius-sm);
    transition: all 0.4s cubic-bezier(0.22,1,0.36,1);
}
.fact-item:hover {
    border-left-color: var(--saffron);
    background: var(--surface-3);
    transform: translateY(-4px);
    box-shadow: var(--shadow-sm);
}
.fact-number {
    font-family: var(--font-display);
    font-size: 2rem; font-weight: 900;
    background: linear-gradient(135deg, var(--gold), var(--saffron));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1; display: block;
}
.fact-label { font-size: .76rem; color: var(--subtle); margin-top: 4px; }


.offer-strip {
    background: linear-gradient(120deg, #4a0f00 0%, var(--gold-deep) 30%, var(--saffron) 60%, var(--gold) 85%, #4a0f00 100%);
    background-size: 200% auto;
    animation: barShift 8s linear infinite;
    padding: 52px 40px;
    overflow: hidden; position: relative; z-index: 5;
}
.offer-strip::before {
    content: '';
    position: absolute; inset: 0;
    background-image: repeating-linear-gradient(
        45deg, transparent, transparent 24px,
        rgba(255,255,255,.035) 24px, rgba(255,255,255,.035) 25px
    );
}
.offer-strip-inner {
    max-width: 1240px; margin: 0 auto;
    display: flex; align-items: center;
    justify-content: space-between;
    gap: 40px; flex-wrap: wrap;
    position: relative; z-index: 1;
}
.offer-strip-text h3 {
    font-family: var(--font-display);
    font-size: clamp(1.6rem,3vw,2.4rem);
    font-weight: 900; color: #fff; line-height: 1.2;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
}
.offer-strip-text p { color: rgba(255,255,255,.82); margin-top: 8px; font-size: .96rem; }
.offer-counters { display: flex; gap: 16px; }
.counter-box {
    background: rgba(255,255,255,.18);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.3);
    padding: 14px 20px; text-align: center;
    min-width: 72px; border-radius: var(--radius-sm);
}
.counter-num {
    font-family: var(--font-display);
    font-size: 2.2rem; font-weight: 900; color: #fff;
    line-height: 1; display: block;
    text-shadow: 0 2px 8px rgba(0,0,0,0.3);
}
.counter-lbl { font-size: .6rem; color: rgba(255,255,255,.75); letter-spacing: 2px; text-transform: uppercase; margin-top: 4px; }
.offer-btn {
    display: inline-flex; align-items: center; gap: 10px;
    background: #fff; color: var(--gold-deep);
    font-weight: 700; font-size: .88rem; letter-spacing: 1.5px;
    text-transform: uppercase; text-decoration: none;
    padding: 16px 34px; border-radius: 3px;
    box-shadow: 0 8px 28px rgba(0,0,0,.2);
    transition: .3s; white-space: nowrap;
}
.offer-btn:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(0,0,0,.3); }


.products-section {
    padding: 130px 40px; background: transparent;
    position: relative;
}
.products-section::after {
    content: '';
    position: absolute; bottom: 0; left: 5%; right: 5%;
    height: 1px; background: linear-gradient(90deg, transparent, var(--border-gold), transparent);
}
.products-inner { max-width: 1320px; margin: 0 auto; }
.section-header { text-align: center; margin-bottom: 68px; }
.products-grid {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    gap: 22px;
}

.product-card {
    background: var(--surface-2);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    position: relative; overflow: hidden;
    transition: all 0.38s cubic-bezier(0.22,1,0.36,1);
    cursor: pointer;
    box-shadow: 0 8px 32px rgba(0,0,0,0.5);
}
.product-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-lg);
    border-color: var(--border-gold);
}
.product-card::before {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--gold-deep), var(--saffron), var(--gold-light));
    transform: scaleX(0); transition: .38s; transform-origin: left;
    z-index: 2;
}
.product-card:hover::before { transform: scaleX(1); }

.product-card.featured-card {
    grid-column: span 2;
    display: grid; grid-template-columns: 1fr 1fr;
    align-items: center;
}
.product-img-wrap {
    padding: 36px; background: var(--surface-1);
    display: flex; align-items: center;
    justify-content: center; min-height: 210px;
    transition: .38s;
}
.product-card.featured-card .product-img-wrap { min-height: 270px; }
.product-card:hover .product-img-wrap { background: var(--surface-3); }
.product-img-wrap img {
    max-width: 80%; max-height: 150px;
    object-fit: contain; transition: .42s;
}
.product-card:hover .product-img-wrap img { transform: scale(1.1); }
.product-info { padding: 28px 30px; position: relative; z-index: 1; }
.product-badge {
    display: inline-block;
    background: var(--gold-pale); color: var(--gold);
    font-size: .63rem; font-weight: 700; letter-spacing: 2px;
    text-transform: uppercase; padding: 4px 10px;
    border-radius: 3px; margin-bottom: 12px;
    border: 1px solid var(--border-gold);
}
.product-name {
    font-family: var(--font-display);
    font-size: 1.2rem; font-weight: 700;
    color: var(--ink); margin-bottom: 8px; line-height: 1.3;
}
.product-card.featured-card .product-name { font-size: 1.7rem; margin-bottom: 14px; }
.product-desc { font-size: .84rem; color: var(--muted); line-height: 1.68; margin-bottom: 16px; }
.product-divider {
    width: 30px; height: 2px;
    background: linear-gradient(90deg, var(--gold-deep), var(--saffron));
    margin-bottom: 14px; border-radius: 2px;
}
.product-cat { font-size: .7rem; font-weight: 600; color: var(--subtle); letter-spacing: 1.5px; text-transform: uppercase; }
.product-num {
    position: absolute; top: 14px; right: 16px;
    font-family: var(--font-display); font-size: 3.5rem;
    font-weight: 900; color: rgba(255,174,0,0.06); line-height: 1;
    pointer-events: none;
}


.categories-section {
    padding: 130px 40px; background: transparent;
}
.categories-inner { max-width: 1320px; margin: 0 auto; }
.categories-grid {
    display: grid;
    grid-template-columns: repeat(3,1fr);
    gap: 22px; margin-top: 64px;
}
.cat-card {
    position: relative; overflow: hidden;
    background: var(--surface-2);
    border: 1px solid var(--border);
    padding: 46px 38px;
    transition: all 0.42s cubic-bezier(0.22,1,0.36,1);
    cursor: pointer; text-align: center;
    border-radius: var(--radius-lg);
    box-shadow: 0 8px 32px rgba(0,0,0,0.5);
}
.cat-card::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(circle at 50% 50%, rgba(255,174,0,0.06) 0%, transparent 65%);
    opacity: 0; transition: .42s;
}
.cat-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
    border-color: var(--border-gold);
}
.cat-card:hover::before { opacity: 1; }
.cat-icon-wrap {
    width: 90px; height: 90px;
    background: var(--gold-pale);
    border: 2px solid var(--border-gold);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 2.4rem; margin: 0 auto 26px;
    transition: .42s; position: relative; z-index: 1;
}
.cat-card:hover .cat-icon-wrap {
    background: linear-gradient(135deg, var(--gold-deep), var(--saffron));
    border-color: var(--gold-deep);
    box-shadow: 0 12px 36px var(--glow-gold);
    transform: scale(1.1) rotate(-5deg);
}
.cat-name {
    font-family: var(--font-display);
    font-size: 1.3rem; font-weight: 700;
    color: var(--ink); margin-bottom: 10px;
    position: relative; z-index: 1;
}
.cat-desc { font-size: .84rem; color: var(--muted); line-height: 1.65; position: relative; z-index: 1; }
.cat-count {
    margin-top: 20px; display: inline-block;
    border: 1px solid var(--border-gold);
    color: var(--gold); font-size: .7rem; font-weight: 700;
    letter-spacing: 2px; padding: 6px 16px;
    text-transform: uppercase; position: relative; z-index: 1;
    border-radius: 3px; transition: .3s;
}
.cat-card:hover .cat-count {
    background: var(--gold-deep); color: #fff; border-color: var(--gold-deep);
    box-shadow: 0 4px 16px var(--glow-fire);
}


.how-section {
    padding: 130px 40px; background: transparent;
    position: relative; overflow: hidden;
}
.how-section::before {
    content: '';
    position: absolute; top: 50%; left: 50%;
    width: 800px; height: 800px;
    transform: translate(-50%,-50%);
    background: radial-gradient(circle, rgba(255,174,0,.04) 0%, transparent 70%);
    border-radius: 50%; pointer-events: none;
}
.how-inner { max-width: 1240px; margin: 0 auto; }
.how-steps {
    display: grid; grid-template-columns: repeat(4,1fr);
    gap: 0; margin-top: 68px;
    position: relative;
}
.how-steps::before {
    content: '';
    position: absolute; top: 45px; left: 12%; right: 12%;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold-light), var(--gold), var(--gold-light), transparent);
    z-index: 0; opacity: 0.4;
}
.step-item {
    text-align: center; padding: 0 24px;
    position: relative; z-index: 1;
}
.step-num-wrap {
    width: 92px; height: 92px;
    background: var(--surface-1);
    border: 1.5px solid var(--border);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 30px;
    position: relative; transition: .42s;
    box-shadow: var(--shadow-sm);
}
.step-item:hover .step-num-wrap {
    border-color: var(--gold);
    box-shadow: 0 0 0 8px var(--gold-pale), var(--shadow-md);
    background: var(--surface-1);
}
.step-num {
    font-family: var(--font-display);
    font-size: 2rem; font-weight: 900;
    background: linear-gradient(135deg, var(--gold), var(--saffron));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.step-icon-layer {
    position: absolute; top: -8px; right: -8px;
    width: 30px; height: 30px;
    background: linear-gradient(135deg, var(--gold-deep), var(--saffron));
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .74rem; color: #fff;
    border: 2px solid var(--bg);
    box-shadow: 0 4px 12px var(--glow-fire);
}
.step-title {
    font-family: var(--font-display);
    font-size: 1.15rem; font-weight: 700;
    color: var(--ink); margin-bottom: 10px;
}
.step-desc { font-size: .84rem; color: var(--muted); line-height: 1.68; }


.why-section {
    padding: 130px 40px;
    background: var(--surface-1);
    position: relative; overflow: hidden;
}
.why-section::before {
    content: '';
    position: absolute; inset: 0;
    background-image:
        radial-gradient(1px 1px at 15% 25%, rgba(255,174,0,.18) 0%, transparent 0%),
        radial-gradient(1px 1px at 75% 65%, rgba(255,213,79,.14) 0%, transparent 0%),
        radial-gradient(1px 1px at 45% 85%, rgba(255,174,0,.10) 0%, transparent 0%);
    background-size: 64px 64px, 48px 48px, 96px 96px;
}
.why-inner { max-width: 1240px; margin: 0 auto; position: relative; z-index: 1; }
.why-header { text-align: center; margin-bottom: 72px; }
.why-grid {
    display: grid; grid-template-columns: repeat(3,1fr);
    gap: 20px;
}
.why-cell {
    background: var(--surface-2);
    border: 1px solid var(--border);
    padding: 44px 36px; transition: all 0.38s cubic-bezier(0.22,1,0.36,1);
    position: relative; overflow: hidden;
    border-radius: var(--radius-md);
}
.why-cell::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--gold-deep), var(--saffron));
    transform: scaleX(0); transform-origin: left; transition: .42s;
}
.why-cell:hover {
    background: var(--surface-1);
    border-color: var(--gold-light);
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
}
.why-cell:hover::before { transform: scaleX(1); }
.why-icon {
    width: 58px; height: 58px;
    background: rgba(255,174,0,.1);
    border: 1px solid rgba(255,174,0,.25);
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; color: var(--gold);
    margin-bottom: 22px; transition: .38s;
}
.why-cell:hover .why-icon {
    background: linear-gradient(135deg, var(--gold-deep), var(--saffron));
    color: #fff; border-color: var(--gold-deep);
    box-shadow: 0 8px 28px var(--glow-gold);
    transform: scale(1.05);
}
.why-cell-title {
    font-family: var(--font-display);
    font-size: 1.2rem; font-weight: 700;
    color: var(--ink); margin-bottom: 12px;
}
.why-cell-desc { font-size: .86rem; color: var(--muted); line-height: 1.72; }
.why-pct {
    margin-top: 22px;
    font-family: var(--font-display);
    font-size: 2.4rem; font-weight: 900;
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    filter: drop-shadow(0 0 10px var(--glow-gold));
}
.why-track {
    height: 3px; background: rgba(255,255,255,.07);
    margin-top: 8px; overflow: hidden; border-radius: 2px;
}
.why-fill {
    height: 100%; width: 0;
    background: linear-gradient(90deg, var(--gold-deep), var(--gold-light));
    transition: width 1.6s cubic-bezier(.22,1,.36,1);
    box-shadow: 0 0 10px var(--glow-gold);
    border-radius: 2px;
}


.why-stats {
    display: grid; grid-template-columns: repeat(4,1fr);
    margin-top: 20px; gap: 20px;
}
.stat-cell {
    background: var(--surface-2);
    border: 1px solid var(--border);
    padding: 36px 20px; text-align: center;
    border-radius: var(--radius-md);
    transition: all 0.38s cubic-bezier(0.22,1,0.36,1);
}
.stat-cell:hover {
    background: var(--surface-1);
    border-color: var(--gold-light);
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}
.stat-icon-wrap {
    width: 44px; height: 44px;
    background: rgba(255,174,0,.1);
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; color: var(--gold);
    margin: 0 auto 14px;
}
.stat-number {
    font-family: var(--font-display);
    font-size: 2.1rem; font-weight: 900; color: var(--gold-light);
    display: block;
    filter: drop-shadow(0 0 10px var(--glow-gold));
}
.stat-label { font-size: .74rem; color: var(--subtle); letter-spacing: 1px; margin-top: 4px; text-transform: uppercase; }


.brands-section {
    padding: 80px 0;
    background: transparent;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    overflow: hidden;
}
.brands-header { text-align: center; margin-bottom: 52px; }
.brands-marquee-wrap { overflow: hidden; position: relative; }
.brands-marquee-wrap::before,
.brands-marquee-wrap::after {
    content: '';
    position: absolute; top: 0; bottom: 0;
    width: 130px; z-index: 2;
}
.brands-marquee-wrap::before { left: 0; background: linear-gradient(90deg, var(--bg), transparent); }
.brands-marquee-wrap::after  { right: 0; background: linear-gradient(-90deg, var(--bg), transparent); }
.brands-track {
    display: inline-flex;
    animation: marquee 32s linear infinite;
}
@keyframes marquee {
    from { transform: translateX(0); }
    to   { transform: translateX(-50%); }
}
.brand-card {
    width: 180px; height: 80px;
    display: flex; align-items: center;
    justify-content: center; margin: 0 28px; flex-shrink: 0;
    filter: grayscale(100%) brightness(0.5);
    transition: .4s;
}
.brand-card:hover { filter: grayscale(0%) brightness(1); transform: scale(1.1); }
.brand-card img { max-width: 70%; max-height: 55px; object-fit: contain; }


.process-section {
    padding: 130px 40px;
    background: var(--surface-1);
    position: relative; overflow: hidden;
}
.process-inner { max-width: 1240px; margin: 0 auto; }
.process-layout {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 80px; align-items: center; margin-top: 68px;
}
.process-visual { position: relative; }
.process-main-img {
    width: 100%; display: block; object-fit: cover;
    border-radius: var(--radius-md);
    border: 2px solid var(--border-gold);
    box-shadow: var(--shadow-dark);
}
.process-badge-float {
    position: absolute; bottom: -24px; right: -24px;
    background: linear-gradient(135deg, var(--gold-deep), var(--saffron));
    color: #fff; padding: 22px 30px;
    box-shadow: var(--shadow-lg);
    font-family: var(--font-display); text-align: center;
    border-radius: var(--radius-sm);
}
.process-badge-float .big { font-size: 2.4rem; font-weight: 900; line-height: 1; }
.process-badge-float .small { font-size: .68rem; letter-spacing: 2px; text-transform: uppercase; opacity: .85; margin-top: 4px; }

.process-steps { display: flex; flex-direction: column; }
.process-step {
    display: flex; gap: 22px; align-items: flex-start;
    padding: 26px 0;
    border-bottom: 1px solid var(--border);
    transition: all .3s;
}
.process-step:last-child { border-bottom: none; }
.process-step:hover { padding-left: 10px; }
.process-step-num {
    width: 46px; height: 46px; min-width: 46px;
    background: var(--gold-pale);
    border: 1.5px solid var(--border-gold);
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-display); font-size: 1.1rem;
    font-weight: 900; color: var(--gold); transition: .3s;
}
.process-step:hover .process-step-num {
    background: var(--gold-deep); color: #fff;
    border-color: var(--gold-deep);
    box-shadow: 0 4px 16px var(--glow-fire);
}
.process-step-title { font-family: var(--font-display); font-size: 1.1rem; font-weight: 700; color: var(--ink); margin-bottom: 6px; }
.process-step-desc { font-size: .86rem; color: var(--muted); line-height: 1.68; }


.safety-section {
    padding: 100px 40px;
    background: transparent;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}
.safety-inner { max-width: 1240px; margin: 0 auto; }
.safety-layout {
    display: grid; grid-template-columns: 1fr 2fr;
    gap: 80px; align-items: center; margin-top: 64px;
}
.safety-callout {
    background: linear-gradient(135deg, var(--gold-deep), var(--saffron));
    padding: 54px 42px; text-align: center; color: #fff;
    position: relative; overflow: hidden;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-lg);
}
.safety-callout::after {
    content: '⚠';
    position: absolute; bottom: -15px; right: -5px;
    font-size: 9rem; opacity: .07; line-height: 1;
    pointer-events: none;
}
.safety-callout h3 { font-family: var(--font-display); font-size: 1.9rem; font-weight: 900; margin-bottom: 14px; }
.safety-callout p { font-size: .9rem; opacity: .88; line-height: 1.75; }
.safety-tips { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.safety-tip {
    display: flex; gap: 16px; align-items: flex-start;
    padding: 22px; background: var(--surface-2);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    transition: .35s;
}
.safety-tip:hover { border-color: var(--border-gold); box-shadow: var(--shadow-sm); background: var(--surface-3); transform: translateY(-3px); }
.safety-tip-icon {
    width: 44px; height: 44px; min-width: 44px;
    background: var(--gold-pale); border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; color: var(--gold);
    border: 1px solid var(--border-gold);
}
.safety-tip-title { font-weight: 700; font-size: .9rem; color: var(--ink); margin-bottom: 5px; }
.safety-tip-desc { font-size: .8rem; color: var(--muted); line-height: 1.65; }


.testimonials-section { padding: 130px 40px; background: transparent; }
.testimonials-inner { max-width: 1200px; margin: 0 auto; }
.testi-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 22px; margin-top: 64px; }
.testi-card {
    background: var(--surface-2);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 38px; position: relative; transition: .42s;
    box-shadow: 0 8px 32px rgba(0,0,0,0.5);
}
.testi-card::before {
    content: '"';
    position: absolute; top: 18px; right: 26px;
    font-family: var(--font-display); font-size: 5.5rem;
    color: rgba(255,174,0,.08); line-height: 1;
    pointer-events: none;
}
.testi-card:hover { border-color: var(--border-gold); box-shadow: var(--shadow-lg); transform: translateY(-6px); }
.testi-card::after {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 2px; border-radius: 0 0 var(--radius-lg) var(--radius-lg);
    background: linear-gradient(90deg, transparent, var(--gold-deep), var(--saffron), transparent);
    transform: scaleX(0); transition: .42s;
}
.testi-card:hover::after { transform: scaleX(1); }
.testi-stars { display: flex; gap: 3px; margin-bottom: 18px; }
.testi-stars span { color: var(--gold); font-size: .95rem; }
.testi-text { font-size: .96rem; color: var(--muted); line-height: 1.82; font-style: italic; margin-bottom: 24px; position: relative; z-index: 1; }
.testi-author-row { display: flex; align-items: center; gap: 14px; }
.testi-avatar {
    width: 46px; height: 46px; border-radius: 50%;
    background: var(--gold-pale); border: 2px solid var(--border-gold);
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-display); font-size: 1.15rem;
    font-weight: 700; color: var(--gold);
}
.testi-author { font-weight: 700; font-size: .88rem; color: var(--ink); }
.testi-location { font-size: .75rem; color: var(--subtle); margin-top: 2px; }


.faq-section { padding: 130px 40px; background: var(--surface-1); }
.faq-inner { max-width: 860px; margin: 0 auto; }
.faq-list { margin-top: 58px; }
.faq-item {
    border-bottom: 1px solid var(--border);
    overflow: hidden;
}
.faq-question {
    width: 100%; text-align: left;
    background: none; border: none; cursor: pointer;
    padding: 24px 0;
    display: flex; align-items: center;
    justify-content: space-between; gap: 20px;
    font-family: var(--font-body); font-size: 1.02rem;
    font-weight: 600; color: var(--ink); transition: .3s;
}
.faq-question:hover { color: var(--gold); }
.faq-q-icon {
    width: 36px; height: 36px; min-width: 36px;
    background: var(--gold-pale); border: 1px solid var(--border-gold);
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: .8rem; transition: .35s;
}
.faq-item.open .faq-q-icon {
    background: var(--gold-deep); color: #fff;
    border-color: var(--gold-deep); transform: rotate(45deg);
    box-shadow: 0 4px 14px var(--glow-fire);
}
.faq-answer {
    max-height: 0; overflow: hidden;
    transition: max-height .48s ease, padding .48s ease;
    font-size: .92rem; color: var(--muted); line-height: 1.8;
}
.faq-item.open .faq-answer { max-height: 320px; padding-bottom: 24px; }


.cta-banner {
    padding: 110px 40px;
    background: transparent;
    text-align: center; position: relative; overflow: hidden;
    z-index: 5;
}
.cta-banner::before {
    content: '';
    position: absolute; top: 50%; left: 50%;
    width: 900px; height: 900px;
    transform: translate(-50%,-50%);
    background: radial-gradient(circle, rgba(255,174,0,.08) 0%, transparent 70%);
    border-radius: 50%; pointer-events: none;
}
.cta-banner-inner { position: relative; z-index: 1; max-width: 700px; margin: 0 auto; }
.cta-banner h2 {
    font-family: var(--font-display);
    font-size: clamp(2.1rem, 4.5vw, 3.8rem);
    font-weight: 900; color: var(--ink); line-height: 1.1;
    margin-bottom: 18px;
    text-shadow: 0 4px 20px rgba(255,255,255,0.8);
}
.cta-banner h2 span {
    background: linear-gradient(135deg, var(--gold), var(--saffron));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    filter: drop-shadow(0 0 20px var(--glow-fire));
}
.cta-banner p { color: rgba(255,255,255,.5); font-size: 1rem; line-height: 1.75; margin-bottom: 42px; }
.cta-btn-group { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }


.wa-float {
    position: fixed; bottom: 32px; right: 32px;
    width: 60px; height: 60px; background: #25d366;
    border-radius: 50%; display: flex; align-items: center;
    justify-content: center; font-size: 1.6rem; color: #fff;
    text-decoration: none; z-index: 9000;
    box-shadow: 0 4px 24px rgba(37,211,102,.4);
    animation: waFloat 3.5s ease-in-out infinite;
}
@keyframes waFloat { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-9px);} }
.wa-float::before {
    content: '';
    position: absolute; inset: -4px;
    border: 2px solid rgba(37,211,102,.3);
    border-radius: 50%;
    animation: waPing 2s ease-out infinite;
}
@keyframes waPing { 0%{transform:scale(1);opacity:.7;} 100%{transform:scale(1.5);opacity:0;} }


@media(max-width:1100px){
    .products-grid { grid-template-columns: repeat(2,1fr); }
    .product-card.featured-card { grid-column: span 2; }
    .why-grid { grid-template-columns: 1fr 1fr; }
    .why-stats { grid-template-columns: 1fr 1fr; }
    .categories-grid { grid-template-columns: 1fr 1fr; }
    .how-steps { grid-template-columns: 1fr 1fr; gap: 40px; }
    .how-steps::before { display: none; }
    .safety-layout { grid-template-columns: 1fr; gap: 40px; }
    .testi-grid { grid-template-columns: 1fr 1fr; }
    .process-layout { grid-template-columns: 1fr; gap: 50px; }
}
@media(max-width:768px){
    .about-inner { grid-template-columns: 1fr; gap: 50px; }
    .about-img-accent { display: none; }
    .product-card.featured-card { grid-column: span 1; display: block; }
    .categories-grid, .testi-grid { grid-template-columns: 1fr; }
    .why-grid { grid-template-columns: 1fr; }
    .how-steps { grid-template-columns: 1fr; }
    .offer-strip-inner { flex-direction: column; text-align: center; }
    .offer-counters { justify-content: center; }
    .hero-float-card { display: none; }
    .safety-tips { grid-template-columns: 1fr; }
    .safety-layout { grid-template-columns: 1fr; }
    .process-layout { grid-template-columns: 1fr; }
}
</style>
<section class="hero-slider">
    @foreach($banners as $index => $banner)
        @php $is_video = Str::endsWith($banner->banner_image, ['.mp4', '.webm', '.ogg']); @endphp
        <div class="slide {{ $index === 0 ? 'active' : '' }}"
             @if(!$is_video) style="background-image: url('{{ env('MAIN_URL', '/') . $banner->banner_image }}');" @endif>

            @if($is_video)
                <video autoplay muted loop playsinline class="banner-video">
                    <source src="{{ env('MAIN_URL', '/') . $banner->banner_image }}" type="video/mp4">
                </video>
            @endif
        </div>
    @endforeach

    <div class="slider-dots">
        @foreach($banners as $index => $banner)
            <div class="dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></div>
        @endforeach
    </div>
    <div class="scroll-hint">
        <div class="scroll-line"></div>
        <span>Scroll</span>
    </div>
</section>


<section class="about-section">
    <div class="about-inner">
        <div class="about-img-col">
            <div class="about-img-badge">25<small>Years</small></div>
            <img class="about-img-main" src="{{ env('MAIN_URL', '/') . $settings->welcome_image }}" alt="Crackers Store">
            <img class="about-img-accent" src="{{ env('MAIN_URL', '/') . $settings->welcome_image }}" alt="">
        </div>
        <div class="about-text-col">
            <div class="about-tag">{{ $settings->hero_eyebrow ?? 'Est. Since 1999' }}</div>
            <h2 class="about-title">{!! $settings->welcome_heading !!}<em>.</em></h2>
            <p class="about-body">{!! strip_tags($settings->welcome_text) !!}</p>
            <div class="about-facts">
                @php
                    $facts = [
                        ['number'=>'5000+','label'=>'Happy Customers'],
                        ['number'=>'200+', 'label'=>'Products Available'],
                        ['number'=>'80%',  'label'=>'Maximum Discount'],
                        ['number'=>'25+',  'label'=>'Years of Trust'],
                    ];
                @endphp
                @foreach($facts as $fact)
                    <div class="fact-item">
                        <span class="fact-number">{{ $fact['number'] }}</span>
                        <div class="fact-label">{{ $fact['label'] }}</div>
                    </div>
                @endforeach
            </div>
            <a href="{{ $settings->welcome_button_link ?? url('estimate') }}" class="btn-primary">
                {{ $settings->welcome_button_text ?? 'Explore Collection' }} →
            </a>
        </div>
    </div>
</section>


<div class="offer-strip">
    <div class="offer-strip-inner">
        <div class="offer-strip-text">
            <h3>🔥 Festival Season Sale<br>Ends Soon!</h3>
            <p>Don't miss the biggest cracker sale of the year — limited stock available.</p>
        </div>
        <div class="offer-counters">
            <div class="counter-box"><span class="counter-num" id="cnt-days">00</span><div class="counter-lbl">Days</div></div>
            <div class="counter-box"><span class="counter-num" id="cnt-hrs">00</span><div class="counter-lbl">Hours</div></div>
            <div class="counter-box"><span class="counter-num" id="cnt-min">00</span><div class="counter-lbl">Mins</div></div>
            <div class="counter-box"><span class="counter-num" id="cnt-sec">00</span><div class="counter-lbl">Secs</div></div>
        </div>
        <a href="{{ url('estimate') }}" class="offer-btn"><i class="fa-solid fa-bolt"></i> Shop Now</a>
    </div>
</div>


<section class="products-section" id="products">
    <div class="products-inner">
        <div class="section-header">
            <span class="section-eyebrow">{{ $settings->products_eyebrow ?? 'Handpicked Selection' }}</span>
            <h2 class="section-title">{{ $settings->products_heading ?? 'Our <span>Best Sellers</span>' }}</h2>
            <span class="section-bar"></span>
            <p class="section-subtitle">Explore our curated collection of premium Sivakasi crackers for every celebration.</p>
        </div>
        <div class="products-grid">
            @foreach($products as $index => $product)
                @if($index === 0)
                    <div class="product-card featured-card">
                        <div class="product-img-wrap">
                            <img src="{{ env('MAIN_URL', '/') . $product->product_image }}" alt="{{ $product->product_name }}">
                        </div>
                        <div class="product-info">
                            <div class="product-badge">🎆 Featured Pick</div>
                            <div class="product-name">{{ $product->product_name }}</div>
                            <div class="product-desc">{{ $product->product_desc ?? 'Premium quality for every celebration.' }}</div>
                            <div class="product-divider"></div>
                            <div class="product-cat">{{ $product->category->category_name ?? 'Featured' }}</div>
                        </div>
                    </div>
                @else
                    <div class="product-card">
                        <span class="product-num">{{ str_pad($index+1,2,'0',STR_PAD_LEFT) }}</span>
                        <div class="product-img-wrap">
                            <img src="{{ env('MAIN_URL', '/') . $product->product_image }}" alt="{{ $product->product_name }}">
                        </div>
                        <div class="product-info">
                            <div class="product-name">{{ $product->product_name }}</div>
                            <div class="product-desc">{{ $product->product_desc ?? 'Grandeur for every festive occasion.' }}</div>
                            <div class="product-divider"></div>
                            <div class="product-cat">{{ $product->category->category_name ?? 'Sivakasi' }}</div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>


<section class="categories-section">
    <div class="categories-inner">
        <div class="section-header">
            <span class="section-eyebrow">Browse by Type</span>
            <h2 class="section-title">Shop by <span>Category</span></h2>
            <span class="section-bar"></span>
        </div>
        <div class="categories-grid">
            @php
                $cats = [
                    ['icon'=>'✨','name'=>'Sparklers',      'desc'=>'Beautiful hand sparklers for kids and celebrations.','count'=>'24 Products'],
                    ['icon'=>'🎆','name'=>'Aerial Shells',  'desc'=>'Magnificent sky bursts to light up the night sky.','count'=>'36 Products'],
                    ['icon'=>'🎇','name'=>'Ground Chakkar', 'desc'=>'Spinning colour wheels and ground-spinning wonders.','count'=>'18 Products'],
                    ['icon'=>'🪄','name'=>'Fancy Items',    'desc'=>'Unique novelty crackers for every age group.','count'=>'42 Products'],
                    ['icon'=>'🎁','name'=>'Gift Boxes',     'desc'=>'Curated gift sets perfect for every celebration.','count'=>'15 Products'],
                    ['icon'=>'🔥','name'=>'Diwali Specials','desc'=>'Our bestselling Diwali crackers all in one place.','count'=>'60 Products'],
                ];
            @endphp
            @foreach($cats as $cat)
                <div class="cat-card">
                    <div class="cat-icon-wrap">{{ $cat['icon'] }}</div>
                    <div class="cat-name">{{ $cat['name'] }}</div>
                    <div class="cat-desc">{{ $cat['desc'] }}</div>
                    <div class="cat-count">{{ $cat['count'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<section class="how-section">
    <div class="how-inner">
        <div class="section-header">
            <span class="section-eyebrow">Simple Process</span>
            <h2 class="section-title">How to <span>Order</span></h2>
            <span class="section-bar"></span>
        </div>
        <div class="how-steps">
            @php
                $steps = [
                    ['num'=>'01','icon'=>'fa-solid fa-file-arrow-down','title'=>'Download Price List',    'desc'=>'Get our full product catalogue with festival discount prices instantly.'],
                    ['num'=>'02','icon'=>'fa-solid fa-cart-shopping',  'title'=>'Choose Your Products',   'desc'=>'Select from 200+ products — sparklers, aerial shells, gift boxes & more.'],
                    ['num'=>'03','icon'=>'fa-brands fa-whatsapp',      'title'=>'Place Order via WhatsApp','desc'=>'Send us your list on WhatsApp and confirm your delivery address.'],
                    ['num'=>'04','icon'=>'fa-solid fa-truck-fast',     'title'=>'Fast Pan India Delivery', 'desc'=>'We ship directly from Sivakasi. Safe packaging, on-time delivery guaranteed.'],
                ];
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


<section class="why-section" id="why-choose-us">
    <div class="why-inner">
        <div class="why-header">
            <span class="section-eyebrow">Our Promise</span>
            <h2 class="section-title">Why <span>Choose Us</span></h2>
            <span class="section-bar"></span>
            <p class="section-subtitle" style="margin:14px auto 0; color:var(--muted);">Built on quality, safety, and unbeatable value — here's what sets us apart.</p>
        </div>
        <div class="why-grid">
            @php
                $whyCells = [
                    ['icon'=>'fa-solid fa-award',              'title'=>'Best Quality',  'desc'=>'Every cracker sourced directly from certified Sivakasi manufacturers.',        'pct'=>98],
                    ['icon'=>'fa-solid fa-layer-group',        'title'=>'Huge Variety',  'desc'=>'From sparklers to aerial shells — catalogue for every taste and budget.',      'pct'=>96],
                    ['icon'=>'fa-solid fa-shield-halved',      'title'=>'Safety First',  'desc'=>'All products meet government safety standards. Family safety is our priority.','pct'=>100],
                    ['icon'=>'fa-solid fa-hand-holding-dollar','title'=>'Lowest Prices', 'desc'=>'Up to 80% discount with direct factory pricing — no middlemen.',              'pct'=>97],
                    ['icon'=>'fa-solid fa-truck-fast',         'title'=>'Fast Delivery', 'desc'=>'Pan India delivery with safe, compliant packaging at your doorstep.',          'pct'=>95],
                    ['icon'=>'fa-solid fa-headset',            'title'=>'24/7 Support',  'desc'=>'Our team is always available to help with orders, queries and tracking.',      'pct'=>99],
                ];
            @endphp
            @foreach($whyCells as $cell)
                <div class="why-cell">
                    <div class="why-icon"><i class="{{ $cell['icon'] }}"></i></div>
                    <div class="why-cell-title">{{ $cell['title'] }}</div>
                    <div class="why-cell-desc">{{ $cell['desc'] }}</div>
                    <div class="why-pct">{{ $cell['pct'] }}%</div>
                    <div class="why-track">
                        <div class="why-fill" data-width="{{ $cell['pct'] }}"></div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="why-stats">
            @php
                $stats = [
                    ['icon'=>'fa-solid fa-users',   'number'=>'5000+',    'label'=>'Happy Customers'],
                    ['icon'=>'fa-solid fa-box-open', 'number'=>'200+',    'label'=>'Products'],
                    ['icon'=>'fa-solid fa-percent',  'number'=>'80%',     'label'=>'Max Discount'],
                    ['icon'=>'fa-solid fa-globe',    'number'=>'PAN India','label'=>'Delivery'],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="stat-cell">
                    <div class="stat-icon-wrap"><i class="{{ $stat['icon'] }}"></i></div>
                    <span class="stat-number">{{ $stat['number'] }}</span>
                    <span class="stat-label">{{ $stat['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>


<section class="brands-section" id="brands">
    <div class="brands-header">
        <span class="section-eyebrow">Certified &amp; Trusted</span>
        <h2 class="section-title">Our Brand <span>Partners</span></h2>
        <span class="section-bar"></span>
    </div>
    <div class="brands-marquee-wrap">
        @php $brandsFull = $brands->concat($brands); @endphp
        <div class="brands-track">
            @foreach($brandsFull as $brand)
                <div class="brand-card">
                    <img src="{{ env('MAIN_URL', '/') . $brand->logo }}" alt="Brand Partner">
                </div>
            @endforeach
        </div>
    </div>
</section>


<section class="process-section">
    <div class="process-inner">
        <div class="section-header" style="text-align:left;">
            <span class="section-eyebrow" style="justify-content:flex-start;">Our Commitment</span>
            <h2 class="section-title">Order With <span>Confidence</span></h2>
        </div>
        <div class="process-layout">
            <div class="process-visual">
                <img class="process-main-img" src="{{ env('MAIN_URL', '/') . $settings->welcome_image }}" alt="Order Process">
                <div class="process-badge-float">
                    <div class="big">80%</div>
                    <div class="small">Discount</div>
                </div>
            </div>
            <div class="process-steps">
                @php
                    $orderSteps = [
                        ['num'=>'01','title'=>'Direct from Sivakasi',    'desc'=>'We source all crackers directly from certified manufacturers in Sivakasi — no middlemen, maximum savings.'],
                        ['num'=>'02','title'=>'Safe & Legal Packaging',  'desc'=>'Every order is packed per government guidelines to ensure safe transit across all states in India.'],
                        ['num'=>'03','title'=>'Real-Time Order Tracking','desc'=>'Get live updates on your shipment via WhatsApp from the moment your order is dispatched.'],
                        ['num'=>'04','title'=>'Easy Returns & Support',  'desc'=>'Any issue? Our dedicated team resolves it within 24 hours, no questions asked.'],
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
                <p>All our products are sourced from government-certified manufacturers and comply with all Indian safety regulations.</p>
            </div>
            <div class="safety-tips">
                @php
                    $tips = [
                        ['icon'=>'fa-solid fa-person-rays',   'title'=>'Adult Supervision','desc'=>'Always ensure crackers are lit by adults. Keep children at a safe distance at all times.'],
                        ['icon'=>'fa-solid fa-bucket',        'title'=>'Keep Water Nearby','desc'=>'Always keep a bucket of water or sand handy to extinguish crackers quickly if needed.'],
                        ['icon'=>'fa-solid fa-eye',           'title'=>'Eye Protection',  'desc'=>'Use safety glasses when lighting crackers to protect your eyes from sparks and debris.'],
                        ['icon'=>'fa-solid fa-location-arrow','title'=>'Safe Distance',   'desc'=>'Maintain at least 5 metres distance after lighting. Never lean over a lit firework.'],
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
                    ['text'=>'Best quality crackers! The delivery was prompt and the colors were magnificent. Absolutely loved the whole experience. Will definitely order again this Diwali.','author'=>'Rajesh Kumar',  'location'=>'Chennai, Tamil Nadu', 'init'=>'R'],
                    ['text'=>'Safety first! I only trust them for my kids. The non-noise collection is superb. Wonderful packaging and very fast delivery. Highly recommended!',            'author'=>'Ananya Sharma', 'location'=>'Mumbai, Maharashtra', 'init'=>'A'],
                    ['text'=>'Amazing prices and top quality. Ordered for our community event and everyone was impressed. The aerial shells were simply spectacular!',                      'author'=>'Suresh Venkat', 'location'=>'Bangalore, Karnataka','init'=>'S'],
                ];
            @endphp
            @foreach($testimonials as $t)
                <div class="testi-card">
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
                    ['q'=>'Is it safe to order crackers online?',      'a'=>'Absolutely. We are a licensed and government-certified retailer. All products are packed securely and shipped through approved carriers in compliance with all state and national regulations.'],
                    ['q'=>'What is the minimum order value?',          'a'=>'Our minimum order value is ₹1,500. This ensures we can ship your order safely and economically via our partner logistics providers.'],
                    ['q'=>'How long does delivery take?',              'a'=>"Delivery typically takes 3–7 business days depending on your location. We ship Pan-India. You'll receive a tracking number via WhatsApp once dispatched."],
                    ['q'=>'Do you offer bulk / wholesale pricing?',    'a'=>'Yes! We offer attractive wholesale pricing for bulk orders. Please contact us on WhatsApp or fill out the inquiry form for a custom quote.'],
                    ['q'=>'Can I return or exchange items?',           'a'=>'Due to the nature of the product, we do not accept returns. However, if you receive a damaged or incorrect item, contact us within 48 hours of delivery and we will resolve it immediately.'],
                    ['q'=>'How do I get the price list?',              'a'=>"Click the \"Get Price List\" button to download our full product catalogue with current prices. It's updated regularly with festival discounts."],
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
</section>


<section class="cta-banner">
    <div class="cta-banner-inner">
        <h2>Ready to Celebrate <span>in Style?</span></h2>
        <p>Download our price list, browse 200+ products, and order directly on WhatsApp. Pan India delivery — straight from Sivakasi to your doorstep.</p>
        <div class="cta-btn-group">
            <a href="{{ url('estimate') }}" class="btn-primary">
                <i class="fa-solid fa-download"></i> Download Price List
            </a>
            <a href="https://wa.me/{{ $settings->whatsapp_number ?? '' }}" class="btn-whatsapp">
                <i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp
            </a>
        </div>
    </div>
</section>


<a href="https://wa.me/{{ $settings->whatsapp_number ?? '' }}" class="wa-float" target="_blank">
    <i class="fa-brands fa-whatsapp"></i>
</a>


<div class="ground-layer" id="groundLayer"></div>


<script>
(function(){
    'use strict';


    const canvas = document.getElementById('fireworks-canvas');
    const ctx    = canvas.getContext('2d');
    let W, H;
    function resize(){ W = canvas.width  = window.innerWidth; H = canvas.height = window.innerHeight; }
    resize();
    window.addEventListener('resize', resize);

    const PI2 = Math.PI * 2;
    const rand  = (a,b) => Math.random()*(b-a)+a;
    const randI = (a,b) => Math.floor(rand(a,b+1));


    const particles = [];


    const groundEl = document.getElementById('groundLayer');


    function spawnSparklerParticle(x,y){
        const angle = rand(0,PI2), spd = rand(1,4);
        particles.push({ kind:'sparkle', x, y, vx:Math.cos(angle)*spd, vy:Math.sin(angle)*spd,
            hue:rand(30,60), alpha:1, life:rand(8,18), maxLife:18, size:rand(1,2.5), gravity:0.08, friction:0.93 });
    }
    function spawnFlowerPotParticle(x,y){
        const angle = rand(-Math.PI,0) - Math.PI/2 + rand(-0.6,0.6), spd = rand(2,8);
        particles.push({ kind:'flower', x, y, vx:Math.cos(angle)*spd, vy:Math.sin(angle)*spd,
            hue:rand(0,360), alpha:1, life:rand(25,55), maxLife:55, size:rand(1.5,3), gravity:0.12, friction:0.96 });
    }
    function spawnRomanBall(x,y){
        const hue = randI(0,360);
        particles.push({ kind:'romanball', x, y, vx:rand(-0.8,0.8), vy:rand(-9,-5),
            hue, alpha:1, life:rand(45,70), maxLife:70, size:rand(3,5), gravity:0.15, friction:0.99 });
    }
    function addSmoke(x,y){
        const puff = document.createElement('div');
        puff.className = 'smoke-puff';
        const sz = rand(30,80);
        puff.style.cssText = `left:${x-sz/2}px; top:${y-sz/2}px; width:${sz}px; height:${sz}px; --sy:-${rand(60,120)}px; --sd:${rand(1.5,3)}s;`;
        document.body.appendChild(puff);
        setTimeout(()=>puff.remove(), 3100);
    }


    window.addChakkar = function(){
        if(!groundEl) return;
        const el = document.createElement('div');
        el.className = 'chakkar'; el.style.left = rand(5,90)+'%';
        el.innerHTML = '<div class="chakkar-inner"></div>';
        groundEl.appendChild(el);
        const duration = rand(4000,8000);
        const iv = setInterval(()=>{
            const r = el.getBoundingClientRect();
            for(let i=0;i<4;i++){
                const a=rand(0,PI2), s=rand(1,4);
                particles.push({kind:'sparkle',x:r.left+18,y:r.top+18,vx:Math.cos(a)*s,vy:Math.sin(a)*s,
                    hue:rand(0,60),alpha:1,life:rand(10,22),maxLife:22,size:rand(1,2.5),gravity:0.07,friction:0.94});
            }
        }, 40);
        setTimeout(()=>{ clearInterval(iv); el.style.transition='opacity .5s'; el.style.opacity='0'; setTimeout(()=>el.remove(),600); }, duration);
    };
    window.addFlowerPot = function(){
        if(!groundEl) return;
        const wrap = document.createElement('div');
        wrap.className='flowerpot-wrap'; wrap.style.left=rand(5,90)+'%';
        wrap.innerHTML='<div class="flowerpot-body"></div>';
        groundEl.appendChild(wrap);
        const duration = rand(4000,7000);
        const iv = setInterval(()=>{ const r=wrap.getBoundingClientRect(); for(let i=0;i<5;i++) spawnFlowerPotParticle(r.left+12,r.top); }, 45);
        setTimeout(()=>{ clearInterval(iv); wrap.style.transition='opacity .5s'; wrap.style.opacity='0'; setTimeout(()=>wrap.remove(),600); }, duration);
    };
    window.addRomanCandle = function(){
        if(!groundEl) return;
        const wrap = document.createElement('div');
        wrap.className='roman-wrap'; wrap.style.left=rand(5,90)+'%';
        wrap.innerHTML='<div class="roman-tube"></div>';
        groundEl.appendChild(wrap);
        let shotCount=0; const maxShots=randI(5,12);
        function shootBall(){
            if(shotCount>=maxShots){ wrap.style.transition='opacity .5s'; wrap.style.opacity='0'; setTimeout(()=>wrap.remove(),600); return; }
            const r=wrap.getBoundingClientRect(); spawnRomanBall(r.left+5,r.top-5);
            shotCount++; setTimeout(shootBall,rand(400,900));
        }
        setTimeout(shootBall, rand(100,500));
    };


    function launchAerial(sx,sy,tx,ty){
        const hue=randI(0,360), style=randI(0,4);
        particles.push({kind:'rocket',x:sx,y:sy,tx,ty,vx:(tx-sx)/55,vy:(ty-sy)/55,
            life:55,maxLife:55,hue,style,trail:[],size:rand(2.5,3.5),done:false});
    }
    function explodeAerial(x,y,hue,style){
        particles.push({kind:'flash',x,y,life:12,maxLife:12,hue});
        const count=randI(70,130);
        const shell=(ax,ay,a,s,h,l,comet=false)=>{
            particles.push({kind:'shell',x:ax,y:ay,vx:Math.cos(a)*s,vy:Math.sin(a)*s,
                hue:h,life:l,maxLife:l,alpha:1,size:rand(1.2,2.8),gravity:0.055,friction:0.975,comet,trail:[],trailLen:comet?10:4});
        };
        if(style===1) for(let i=0;i<count;i++) shell(x,y,(PI2/count)*i,rand(3,5.5),hue,rand(40,70));
        else if(style===2) for(let i=0;i<count;i++) shell(x,y,(PI2/count)*i+rand(-.05,.05),rand(2,7),hue+rand(-20,20),rand(50,90),true);
        else if(style===3) for(let i=0;i<count*1.5;i++) shell(x,y,rand(0,PI2),rand(.5,4.5),hue+rand(-40,40),rand(30,55));
        else if(style===4) for(let i=0;i<count;i++){
            const a=(PI2/count)*i, s=rand(1.5,4.5);
            particles.push({kind:'willow',x,y,vx:Math.cos(a)*s,vy:Math.sin(a)*s,
                hue:hue+rand(-15,15),alpha:1,life:rand(60,100),maxLife:100,size:rand(1.5,2.5),gravity:0.09,friction:0.985,trail:[],trailLen:12});
        }
        else for(let i=0;i<count;i++) shell(x,y,(PI2/count)*i+rand(-.12,.12),rand(1.5,6.5),hue,rand(35,65));
        addSmoke(x,y);
    }
    window.triggerAtomBomb = function(x,y){
        for(let i=0;i<200;i++){
            const a=(PI2/200)*i, s=rand(5,14);
            particles.push({kind:'atom',x,y,vx:Math.cos(a)*s,vy:Math.sin(a)*s,
                hue:rand(0,60),alpha:1,life:rand(30,60),maxLife:60,size:rand(2,5),gravity:0.04,friction:0.93});
        }
        const flash=document.createElement('div');
        flash.className='atom-flash';
        flash.style.setProperty('--fx',(x/W*100)+'%');
        flash.style.setProperty('--fy',(y/H*100)+'%');
        document.body.appendChild(flash);
        setTimeout(()=>flash.remove(),700);
    };


    function render(){
        requestAnimationFrame(render);
        ctx.globalCompositeOperation='destination-out';
        ctx.fillStyle='rgba(0,0,0,0.42)';
        ctx.fillRect(0,0,W,H);
        ctx.globalCompositeOperation='lighter';

        const dead=[];
        for(let i=0;i<particles.length;i++){
            const p=particles[i]; p.life--;
            if(p.life<=0){
                if(p.kind==='rocket') explodeAerial(p.x,p.y,p.hue,p.style);
                if(p.kind==='romanball'){
                    for(let k=0;k<18;k++){
                        const a=rand(0,PI2),s=rand(1,3);
                        particles.push({kind:'sparkle',x:p.x,y:p.y,vx:Math.cos(a)*s,vy:Math.sin(a)*s,
                            hue:p.hue,alpha:1,life:rand(12,22),maxLife:22,size:rand(0.8,1.8),gravity:0.06,friction:0.95});
                    }
                }
                dead.push(i); continue;
            }
            switch(p.kind){
                case 'rocket':
                    p.trail.unshift([p.x,p.y]);
                    if(p.trail.length>8) p.trail.pop();
                    p.x+=p.vx; p.y+=p.vy;

                    for(let t=0;t<p.trail.length;t++){
                        ctx.beginPath(); ctx.arc(p.trail[t][0],p.trail[t][1],p.size*(1-t/p.trail.length),0,PI2);
                        ctx.fillStyle=`hsla(${p.hue},100%,70%,${0.5*(1-t/p.trail.length)})`; ctx.fill();
                    }
                    break;
                case 'flash':
                    const fa=p.life/p.maxLife, fr=(1-fa)*120;
                    const fg=ctx.createRadialGradient(p.x,p.y,0,p.x,p.y,fr);
                    fg.addColorStop(0,`hsla(${p.hue},100%,95%,${fa})`);
                    fg.addColorStop(1,'transparent');
                    ctx.fillStyle=fg; ctx.beginPath(); ctx.arc(p.x,p.y,fr,0,PI2); ctx.fill();
                    break;
                case 'shell': case 'willow': case 'flower': case 'romanball': case 'atom':
                    p.vy+=p.gravity; p.vx*=p.friction; p.vy*=p.friction;
                    p.x+=p.vx; p.y+=p.vy; p.alpha=p.life/p.maxLife; break;
                case 'sparkle':
                    p.vy+=p.gravity; p.vx*=p.friction; p.vy*=p.friction;
                    p.x+=p.vx; p.y+=p.vy; p.alpha=p.life/p.maxLife;
                    ctx.save(); ctx.globalAlpha=p.alpha;
                    ctx.strokeStyle=`hsl(${p.hue},100%,72%)`; ctx.lineWidth=p.size*.7;
                    ctx.beginPath(); ctx.moveTo(p.x-3,p.y); ctx.lineTo(p.x+3,p.y); ctx.stroke();
                    ctx.restore(); break;
            }
            if(['shell','willow','rocket','flower','romanball','atom'].includes(p.kind)){
                ctx.beginPath(); ctx.arc(p.x,p.y,p.size,0,PI2);
                ctx.fillStyle=`hsla(${p.hue},100%,70%,${p.alpha||1})`; ctx.fill();
            }
        }
        for(let i=dead.length-1;i>=0;i--) particles.splice(dead[i],1);
    }
    render();


    setInterval(()=>launchAerial(rand(W*.25,W*.75),H,rand(W*.05,W*.95),rand(H*.06,H*.45)), 2200);
    setInterval(()=>{
        if(Math.random()>.45) addChakkar();
        if(Math.random()>.5)  addFlowerPot();
        if(Math.random()>.65) addRomanCandle();
    }, 4000);


    document.addEventListener('mousemove', e=>{
        if(Math.random()>.82) spawnSparklerParticle(e.clientX, e.clientY);
    });


    window.addEventListener('click', e=>{
        if(e.target.closest('a,button,.product-card,.cat-card,.faq-question')) return;
        const t=randI(0,2);
        if(t===0) launchAerial(W/2,H,e.clientX,e.clientY);
        else triggerAtomBomb(e.clientX,e.clientY);
    });


    let curSlide=0;
    const slides=document.querySelectorAll('.slide');
    const dts   =document.querySelectorAll('.dot');
    window.goToSlide=function(n){
        slides[curSlide].classList.remove('active');
        if(dts[curSlide]) dts[curSlide].classList.remove('active');
        curSlide=(n+slides.length)%slides.length;
        slides[curSlide].classList.add('active');
        if(dts[curSlide]) dts[curSlide].classList.add('active');
    };
    if(slides.length>1) setInterval(()=>window.goToSlide(curSlide+1), 5000);


    function updateCountdown(){
        const target=new Date(); target.setDate(target.getDate()+12); target.setHours(0,0,0,0);
        const diff=target-new Date(), pad=n=>String(n).padStart(2,'0');
        const d=document.getElementById('cnt-days'), h=document.getElementById('cnt-hrs'),
              m=document.getElementById('cnt-min'),  s=document.getElementById('cnt-sec');
        if(d) d.textContent=pad(Math.floor(diff/86400000));
        if(h) h.textContent=pad(Math.floor((diff%86400000)/3600000));
        if(m) m.textContent=pad(Math.floor((diff%3600000)/60000));
        if(s) s.textContent=pad(Math.floor((diff%60000)/1000));
    }
    updateCountdown(); setInterval(updateCountdown,1000);


    window.toggleFaq=function(btn){
        const itm=btn.closest('.faq-item'), opn=itm.classList.contains('open');
        document.querySelectorAll('.faq-item.open').forEach(i=>i.classList.remove('open'));
        if(!opn) itm.classList.add('open');
    };


    const fills=document.querySelectorAll('.why-fill');
    function animateFills(){
        fills.forEach(f=>{
            if(!f.dataset.done){
                const r=f.closest('.why-cell').getBoundingClientRect();
                if(r.top<window.innerHeight-60){ f.dataset.done='1'; setTimeout(()=>f.style.width=f.dataset.width+'%',300); }
            }
        });
    }
    window.addEventListener('scroll',animateFills,{passive:true}); animateFills();


    const starsContainer=document.getElementById('stars-container');
    if(starsContainer){

        const nebulaData=[
            {x:'18%',y:'12%',sz:420,c:'rgba(255,110,0,0.07)'},
            {x:'72%',y:'8%', sz:380,c:'rgba(255,61,0,0.05)'},
            {x:'45%',y:'60%',sz:500,c:'rgba(100,50,200,0.04)'},
            {x:'88%',y:'55%',sz:350,c:'rgba(255,174,0,0.06)'},
        ];
        nebulaData.forEach(n=>{
            const el=document.createElement('div'); el.className='nebula';
            el.style.cssText=`width:${n.sz}px;height:${n.sz}px;left:${n.x};top:${n.y};background:${n.c};`;
            starsContainer.appendChild(el);
        });


        const starColors=['#ffffff','#fff8e7','#e8f4ff','#fff4cc','#ffedd5'];
        for(let i=0;i<220;i++){
            const s=document.createElement('div');
            const isTwinkle=Math.random()>.25;
            s.className='star'+(isTwinkle?' twinkle':'');
            const sz=rand(0.5,2.2), op=rand(0.25,0.95), col=starColors[Math.floor(Math.random()*starColors.length)];
            s.style.cssText=`width:${sz}px;height:${sz}px;left:${rand(0,100)}%;top:${rand(0,100)}%;` +
                `background:${col};--dur:${rand(2,5)}s;--delay:${rand(0,6)}s;--op:${op};--glow-color:${col};`;
            starsContainer.appendChild(s);
        }


        function createShootingStar(){
            const ss=document.createElement('div'); ss.className='shooting-star';
            const len=rand(80,200);
            ss.style.cssText=`left:${rand(20,85)}%;top:${rand(5,45)}%;width:${len}px;` +
                `animation:shoot ${rand(0.8,1.8)}s ease-out forwards;`;
            starsContainer.appendChild(ss);
            setTimeout(()=>ss.remove(),2000);
        }
        setInterval(()=>{ if(Math.random()>.65) createShootingStar(); }, 3500);
    }


    const revealEls=document.querySelectorAll(
        '.product-card,.why-cell,.step-item,.testi-card,.cat-card,.process-step,.safety-tip,.fact-item,.faq-item,.stat-cell'
    );
    const io=new IntersectionObserver(es=>{
        es.forEach((e,i)=>{
            if(e.isIntersecting){
                setTimeout(()=>{ e.target.style.opacity='1'; e.target.style.transform='translateY(0) rotateX(0)'; },i*55);
                io.unobserve(e.target);
            }
        });
    },{threshold:0.08});
    revealEls.forEach(el=>{
        el.style.opacity='0';
        el.style.transform='translateY(28px) rotateX(4deg)';
        el.style.transition='opacity .7s ease, transform .7s ease';
        io.observe(el);
    });

})();
</script>

@endsection