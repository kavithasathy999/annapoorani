@extends('layouts.default')

@section('main-page')




<!-- ===== PAGE HERO BANNER ===== -->
<section class="about-hero">
    <div class="about-hero-bg" 
        style="background-image: url('{{ $about->banner_image ? env('MAIN_URL', '/') . $about->banner_image : asset('assets/img/ab.jpg') }}');">
    </div>

    <div class="about-hero-content">
        <!-- <div class="about-hero-eyebrow">Est. 2016 · Sivakasi</div> -->
        <h1>About Us</h1>
        <p class="about-hero-breadcrumb"><a href="/">Home</a> → About Us</p>
    </div>
</section>


<!-- ===== ABOUT MAIN SECTION ===== -->
<section class="about-main-section">
    <div id="aboutEmberContainer"></div>

    <div class="about-inner">

        <!-- LEFT IMAGE -->
        <div class="about-image-wrap">
            <!-- Corner sparks -->
            <svg class="corner-spark tl" viewBox="0 0 40 40" fill="none">
                <line x1="2" y1="2" x2="14" y2="14" stroke="#ff6a00" stroke-width="2"/>
                <line x1="2" y1="2" x2="2" y2="12" stroke="#ffd700" stroke-width="1.5"/>
                <line x1="2" y1="2" x2="12" y2="2" stroke="#ffd700" stroke-width="1.5"/>
                <circle cx="2" cy="2" r="3" fill="#ff6a00"/>
            </svg>
            <svg class="corner-spark tr" viewBox="0 0 40 40" fill="none">
                <line x1="2" y1="2" x2="14" y2="14" stroke="#ff6a00" stroke-width="2"/>
                <line x1="2" y1="2" x2="2" y2="12" stroke="#ffd700" stroke-width="1.5"/>
                <line x1="2" y1="2" x2="12" y2="2" stroke="#ffd700" stroke-width="1.5"/>
                <circle cx="2" cy="2" r="3" fill="#ff6a00"/>
            </svg>
            <svg class="corner-spark bl" viewBox="0 0 40 40" fill="none">
                <line x1="2" y1="2" x2="14" y2="14" stroke="#ff6a00" stroke-width="2"/>
                <line x1="2" y1="2" x2="2" y2="12" stroke="#ffd700" stroke-width="1.5"/>
                <line x1="2" y1="2" x2="12" y2="2" stroke="#ffd700" stroke-width="1.5"/>
                <circle cx="2" cy="2" r="3" fill="#ff6a00"/>
            </svg>
            <svg class="corner-spark br" viewBox="0 0 40 40" fill="none">
                <line x1="2" y1="2" x2="14" y2="14" stroke="#ff6a00" stroke-width="2"/>
                <line x1="2" y1="2" x2="2" y2="12" stroke="#ffd700" stroke-width="1.5"/>
                <line x1="2" y1="2" x2="12" y2="2" stroke="#ffd700" stroke-width="1.5"/>
                <circle cx="2" cy="2" r="3" fill="#ff6a00"/>
            </svg>

            <img src="{{ env('MAIN_URL', '/') . $about->main_image }}" alt="The Crackers - Sivakasi">
        </div>

        <!-- RIGHT CONTENT -->
        <div class="about-content-right">
            <div class="about-eyebrow">{{ $about->eyebrow }}</div>

            <h2 class="about-title">{!! $about->heading !!}</h2>
            <span class="title-underline"></span>

            <p class="about-body">
                {!! $about->description !!}
            </p>

            <div class="about-badges">
                <div class="badge"><span class="badge-icon">🏆</span> {{ $about->badge1_text }}</div>
                <div class="badge"><span class="badge-icon">🔥</span> {{ $about->badge2_text }}</div>
                <div class="badge"><span class="badge-icon">🛡️</span> {{ $about->badge3_text }}</div>
            </div>
        </div>

    </div>
</section>

<!-- <div class="fire-edge"></div> -->


<!-- ===== PURPOSE & DEDICATION SECTION ===== -->
<section class="purpose-section">
    <div class="purpose-inner">

        <div class="section-header">
            <div class="section-eyebrow">{{ $about->purpose_eyebrow }}</div>
            <h2 class="section-title-main">{!! $about->purpose_heading !!}</h2>
            <span class="section-title-bar"></span>
        </div>

        <div class="purpose-grid">

            <!-- Purpose -->
            <div class="purpose-card">
                <div class="purpose-icon-wrap">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <div class="purpose-card-title">{{ $about->p1_title }}</div>
                <div class="purpose-divider"></div>
                <p class="purpose-card-text">
                    {{ $about->p1_text }}
                </p>
            </div>

            <!-- Dedication -->
            <div class="purpose-card">
                <div class="purpose-icon-wrap">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
                <div class="purpose-card-title">{{ $about->p2_title }}</div>
                <div class="purpose-divider"></div>
                <p class="purpose-card-text">
                    {{ $about->p2_text }}
                </p>
            </div>

            <!-- Quality -->
            <div class="purpose-card">
                <div class="purpose-icon-wrap">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div class="purpose-card-title">{{ $about->p3_title }}</div>
                <div class="purpose-divider"></div>
                <p class="purpose-card-text">
                    {{ $about->p3_text }}
                </p>
            </div>

            <!-- Promise -->
            <div class="purpose-card">
                <div class="purpose-icon-wrap">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <div class="purpose-card-title">{{ $about->p4_title }}</div>
                <div class="purpose-divider"></div>
                <p class="purpose-card-text">
                    {{ $about->p4_text }}
                </p>
            </div>

        </div>
    </div>
</section>

<!-- <div class="fire-edge"></div> -->


<!-- ===== STATS SECTION ===== -->
<section class="stats-section">
    <div class="stats-inner">
        <div class="stats-grid">
            <div class="stat-cell">
                <span class="stat-icon">📦</span>
                <span class="stat-number counter" data-target="{{ $about->products_count }}">0</span>
                <span class="stat-label">Products</span>
            </div>
            <div class="stat-cell">
                <span class="stat-icon">🏆</span>
                <span class="stat-number counter" data-target="{{ $about->customers_count }}">0</span>
                <span class="stat-label">Happy Customers</span>
            </div>
            <div class="stat-cell">
                <span class="stat-icon">✅</span>
                <span class="stat-number" id="successStat" data-success="{{ $about->success_percentage }}">0%</span>
                <span class="stat-label">Client Success</span>
            </div>
        </div>
    </div>
</section>


<!-- ===== CTA SECTION ===== -->
<section class="cta-section">
    <div class="cta-inner">
        <div class="cta-box">
            <div class="cta-text-wrap">
                <div class="cta-label">✦ {!! $about->action_text !!}</div>
                <h3 class="cta-title">Let's Light Up Your<br>Next Celebration</h3>
            </div>
            <a href="{{ $about->action_button_link }}" class="cta-btn"><span>✦ {{ $about->action_button_text }}</span></a>
        </div>
    </div>
</section>

<!-- <div class="fire-edge"></div> -->


<!-- ===== EMBER JS ===== -->
<script>
(function () {
    const container = document.getElementById('aboutEmberContainer');
    if (!container) return;
    function spawnEmber() {
        const el = document.createElement('div');
        el.className = 'ember-particle';
        const x        = Math.random() * 100;
        const duration = 3 + Math.random() * 4;
        const delay    = Math.random() * 5;
        const size     = 2 + Math.random() * 3;
        const colors   = ['#ff6a00','#ffd700','#ff4500','#ffcc00'];
        const color    = colors[Math.floor(Math.random() * colors.length)];
        el.style.cssText = `
            left:${x}%;
            bottom:${Math.random() * 30}%;
            width:${size}px;
            height:${size}px;
            background:${color};
            box-shadow:0 0 6px ${color};
            animation-duration:${duration}s;
            animation-delay:${delay}s;
        `;
        container.appendChild(el);
        setTimeout(() => el.remove(), (duration + delay) * 1000);
    }
    setInterval(spawnEmber, 600);
})();
</script>

<!-- ===== COUNTER JS ===== -->
<script>
(function () {
    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    function startCounter(counter) {
        const target = +counter.getAttribute('data-target');
        let count = 0;
        const increment = Math.ceil(target / speed);

        const timer = setInterval(function () {
            count += increment;
            if (count >= target) {
                count = target;
                clearInterval(timer);
                if (target >= 1000) {
                    counter.innerText = target.toLocaleString() + '+';
                } else {
                    counter.innerText = target + '+';
                }
            } else {
                counter.innerText = count.toLocaleString();
            }
        }, 12);
    }

    // Success stat
    const successEl = document.getElementById('successStat');
    const successTarget = +successEl.getAttribute('data-success') || 100;
    function startSuccess() {
        let c = 0;
        const timer = setInterval(function () {
            c++;
            if (c >= successTarget) { 
                c = successTarget;
                clearInterval(timer); 
            }
            successEl.innerText = c + '%';
        }, 18);
    }

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                if (entry.target.classList.contains('counter')) {
                    startCounter(entry.target);
                } else if (entry.target.id === 'successStat') {
                    startSuccess();
                }
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.4 });

    counters.forEach(function (c) { observer.observe(c); });
    if (successEl) observer.observe(successEl);
})();
</script>

@endsection