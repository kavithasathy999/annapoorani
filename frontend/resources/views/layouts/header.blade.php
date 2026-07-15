<!-- ===== HEADER ===== -->
<style>
    @media only screen and (min-width: 992px) {
    .hdr-topbar .hdr-ticker-wrap .hdr-ticker p {
        margin-top: 10px;
    }
}
</style>
<!-- Top Bar (ticker + contact) -->
<div class="hdr-topbar">
    <div class="hdr-topbar-inner">
        <div class="hdr-ticker-wrap">
            <div class="hdr-ticker" id="hdrTicker">
                @php $t = $global_settings->top_offer_text ?? '<span><i class="fa-solid fa-bolt"></i> Sivakasi Direct Delivery</span><span><i class="fa-solid fa-shield-halved"></i> Child-Safe Certified</span><span><i class="fa-solid fa-leaf"></i> Eco-Friendly Sparklers</span><span><i class="fa-solid fa-fire"></i> 80% OFF — Limited Time!</span>'; @endphp
                <div class="hdr-ticker-track">{!! $t !!}{!! $t !!}</div>
            </div>
        </div>
        <a href="tel:{{ $global_settings->phone_number }}" class="hdr-topbar-phone">
            <i class="fa-solid fa-phone"></i>
            {{ $global_settings->phone_number }}
        </a>
    </div>
</div>

<!-- Main Header -->
<header class="hdr" id="hdr">
    <div class="hdr-inner">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="hdr-logo">
            <img src="{{ asset('assets/img/logo1.png') }}" alt="Sri Annapoorani Crackers" id="hdrLogoImg">
        </a>

        <!-- Nav -->
        <nav class="hdr-nav" id="hdrNav">
            <a href="{{ url('/') }}"        class="hdr-link {{ request()->is('/') ? 'hdr-link--active' : '' }}">Home</a>
            <a href="{{ url('/about') }}"   class="hdr-link {{ request()->is('about') ? 'hdr-link--active' : '' }}">About</a>
            <a href="{{ url('/estimate') }}" class="hdr-link {{ request()->is('estimate') ? 'hdr-link--active' : '' }}">Products</a>
            <a href="{{ url('/safety-tips') }}"    class="hdr-link {{ request()->is('safety-tips*') ? 'hdr-link--active' : '' }}">Safety Tips</a>
            <a href="{{ url('/contact') }}" class="hdr-link {{ request()->is('contact') ? 'hdr-link--active' : '' }}">Contact</a>
        </nav>

        <!-- Right actions -->
        <div class="hdr-actions">
            <!-- Language switcher -->
            <div class="hdr-lang">
                <button class="hdr-lang-btn" id="langToggle" aria-label="Language">
                    <i class="fa-solid fa-globe"></i>
                    <span id="langLabel">EN</span>
                    <i class="fa-solid fa-chevron-down hdr-lang-arrow"></i>
                </button>
                <div class="hdr-lang-drop" id="langDrop">
                    <button onclick="changeLang('en')" class="hdr-lang-opt" id="btn-en">English</button>
                    <button onclick="changeLang('ta')" class="hdr-lang-opt" id="btn-ta">தமிழ்</button>
                    <button onclick="changeLang('kn')" class="hdr-lang-opt" id="btn-kn">ಕನ್ನಡ</button>
                </div>
            </div>

            <!-- Download Price List CTA -->
            <a href="{{ route('pricelist.download') }}" class="hdr-cta hdr-cta-download">
                <i class="fa-solid fa-download"></i>
                <span class="btn-text">Download Price List</span>
            </a>

            <!-- Shop Now CTA -->
            <a href="{{ url('estimate') }}" class="hdr-cta">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Shop Now</span>
            </a>

            <!-- Hamburger -->
            <button class="hdr-burger" id="hdrBurger" aria-label="Menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Menu Overlay -->
<div class="hdr-mobile" id="hdrMobile" aria-hidden="true">
    <div class="hdr-mobile-panel">
        <div class="hdr-mobile-top">
            <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo" class="hdr-mobile-logo">
            <button class="hdr-mobile-close" id="hdrMobileClose" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <nav class="hdr-mobile-nav">
            <a href="{{ url('/') }}"        class="hdr-mobile-link {{ request()->is('/') ? 'hdr-mobile-link--active' : '' }}"><i class="fa-solid fa-house"></i> Home</a>
            <a href="{{ url('/about') }}"   class="hdr-mobile-link {{ request()->is('about') ? 'hdr-mobile-link--active' : '' }}"><i class="fa-solid fa-feather-pointed"></i> About</a>
            <a href="{{ url('/estimate') }}" class="hdr-mobile-link {{ request()->is('estimate') ? 'hdr-mobile-link--active' : '' }}"><i class="fa-solid fa-fire-extinguisher"></i> Products</a>
            <a href="{{ url('/safety-tips') }}"    class="hdr-mobile-link {{ request()->is('safety-tips*') ? 'hdr-mobile-link--active' : '' }}"><i class="fa-solid fa-shield-halved"></i> Safety Tips</a>
            <a href="{{ url('/contact') }}" class="hdr-mobile-link {{ request()->is('contact') ? 'hdr-mobile-link--active' : '' }}"><i class="fa-solid fa-paper-plane"></i> Contact</a>
        </nav>
        <div class="hdr-mobile-footer">
            <div class="hdr-mobile-langs">
                <button onclick="changeLang('en')" class="hdr-mlang-btn" id="btn-en">EN</button>
                <button onclick="changeLang('ta')" class="hdr-mlang-btn" id="btn-ta">தமிழ்</button>
                <button onclick="changeLang('kn')" class="hdr-mlang-btn" id="btn-kn">ಕನ்ನಡ</button>
            </div>
            <a href="{{ route('pricelist.download') }}" class="hdr-mobile-cta hdr-mobile-cta-download">
                <i class="fa-solid fa-download"></i> Download Price List
            </a>
            <a href="{{ url('estimate') }}" class="hdr-mobile-cta">
                <i class="fa-solid fa-cart-shopping"></i> Shop Now
            </a>
            <a href="tel:{{ $global_settings->phone_number }}" class="hdr-mobile-call">
                <i class="fa-solid fa-phone"></i> {{ $global_settings->phone_number }}
            </a>
        </div>
    </div>
</div>

<!-- Google Translate (hidden) -->
<div id="google_translate_element" style="display:none"></div>

<style>
/* ── Reset within header scope ── */
.hdr *, .hdr-topbar *, .hdr-mobile * { box-sizing: border-box; }

/* ── Top Bar ── */
.hdr-topbar {
    background: #111;
    color: #fff;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.8px;
    position: relative;
    z-index: 1002;
    line-height: 1;
}
.hdr-topbar-inner {
    max-width: 1360px;
    margin: 0 auto;
    padding: 0 32px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}
.hdr-ticker-wrap {
    flex: 1;
    min-width: 0;
    overflow: hidden;
    mask-image: linear-gradient(to right, transparent 0%, #000 5%, #000 95%, transparent 100%);
    -webkit-mask-image: linear-gradient(to right, transparent 0%, #000 5%, #000 95%, transparent 100%);
    display: flex;
    align-items: center;
}
.hdr-ticker {
    overflow: hidden;
    white-space: nowrap;
    display: flex;
    align-items: center;
}
.hdr-ticker-track {
    display: inline-flex;
    align-items: center;
    gap: 48px;
    white-space: nowrap;
    will-change: transform;
}
.hdr-ticker-track span {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    flex-shrink: 0;
    text-transform: uppercase;
}
.hdr-ticker-track i { color: #0b6698; }
.hdr-topbar-phone {
    display: flex;
    align-items: center;
    gap: 7px;
    color: #fff;
    text-decoration: none;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    white-space: nowrap;
    flex-shrink: 0;
    transition: color 0.2s;
}
.hdr-topbar-phone:hover { color: #0b6698; }
.hdr-topbar-phone i { color: #0b6698; }

/* ── Main Header ── */
.hdr {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: #fff;
    border-bottom: 1px solid #f0f0f0;
    transition: box-shadow 0.3s;
}
.hdr.hdr--scrolled {
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
}
.hdr-inner {
    max-width: 1360px;
    margin: 0 auto;
    padding: 0 32px;
    height: 68px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 32px;
}

/* Logo */
.hdr-logo { flex-shrink: 0; display: flex; align-items: center; }
.hdr-logo img { height: 70px; width: auto; display: block; transition: opacity 0.2s; }
.hdr-logo:hover img { opacity: 0.85; }

/* Nav */
.hdr-nav {
    display: flex;
    align-items: center;
    gap: 4px;
    flex: 1;
}
.hdr-link {
    display: inline-flex;
    align-items: center;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    color: #444;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.18s, color 0.18s;
}
.hdr-link:hover { background: #d5e8fd; color: #0b6698; }
.hdr-link--active { color: #0b6698; background: #d5e8fd; }

/* Actions */
.hdr-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
}

/* Language dropdown */
.hdr-lang { position: relative; }
.hdr-lang-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 12px;
    border: 1px solid #e8e8e8;
    border-radius: 8px;
    background: #fff;
    font-size: 0.8rem;
    font-weight: 600;
    color: #444;
    cursor: pointer;
    transition: border-color 0.18s, background 0.18s;
    white-space: nowrap;
}
.hdr-lang-btn:hover { border-color: #0b6698; background: #d5e8fd; color: #0b6698; }
.hdr-lang-arrow { font-size: 0.6rem; transition: transform 0.2s; }
.hdr-lang.open .hdr-lang-arrow { transform: rotate(180deg); }
.hdr-lang-drop {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    background: #fff;
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 6px;
    min-width: 130px;
    box-shadow: 0 8px 28px rgba(0,0,0,0.1);
    display: none;
    z-index: 999;
}
.hdr-lang.open .hdr-lang-drop { display: block; }
.hdr-lang-opt {
    display: block;
    width: 100%;
    padding: 8px 12px;
    border: none;
    border-radius: 7px;
    background: transparent;
    text-align: left;
    font-size: 0.82rem;
    font-weight: 600;
    color: #333;
    cursor: pointer;
    transition: background 0.15s, color 0.15s;
}
.hdr-lang-opt:hover { background: #d5e8fd; color: #0b6698; }

/* CTA */
.hdr-cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    background: #0b6698;
    color: #fff;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.2s, transform 0.2s;
    white-space: nowrap;
}
.hdr-cta:hover { background: #043048; transform: translateY(-1px); }

.hdr-cta-download {
    background: linear-gradient(135deg, #c92a0d, #0b6698) !important;
    color: #fff !important;
    border: none !important;
    padding: 10px 22px;
}
.hdr-cta-download:hover { 
    filter: brightness(1.1);
    transform: translateY(-1px);
}

/* Burger */
.hdr-burger {
    display: none;
    flex-direction: column;
    justify-content: center;
    gap: 5px;
    width: 42px;
    height: 42px;
    border: 1px solid #e8e8e8;
    border-radius: 8px;
    background: #fff;
    cursor: pointer;
    padding: 10px;
    transition: border-color 0.2s;
}
.hdr-burger:hover { border-color: #0b6698; }
.hdr-burger span {
    display: block;
    height: 2px;
    background: #333;
    border-radius: 2px;
    transition: transform 0.3s, opacity 0.3s;
}
.hdr-burger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.hdr-burger.open span:nth-child(2) { opacity: 0; }
.hdr-burger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* ── Mobile Overlay ── */
.hdr-mobile {
    position: fixed;
    inset: 0;
    z-index: 10000;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(4px);
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s;
}
.hdr-mobile.open {
    opacity: 1;
    pointer-events: all;
}
.hdr-mobile-panel {
    position: absolute;
    top: 0; right: 0;
    width: min(320px, 88vw);
    height: 100%;
    background: #fff;
    display: flex;
    flex-direction: column;
    transform: translateX(100%);
    transition: transform 0.35s cubic-bezier(0.19,1,0.22,1);
    overflow-y: auto;
}
.hdr-mobile.open .hdr-mobile-panel {
    transform: translateX(0);
}
.hdr-mobile-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid #f2f2f2;
    flex-shrink: 0;
}
.hdr-mobile-logo { height: 40px; width: auto; }
.hdr-mobile-close {
    width: 36px; height: 36px;
    border: 1px solid #eee;
    border-radius: 8px;
    background: #fff;
    font-size: 1rem;
    color: #555;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.15s, color 0.15s;
}
.hdr-mobile-close:hover { background: #d5e8fd; color: #0b6698; }
.hdr-mobile-nav {
    display: flex;
    flex-direction: column;
    padding: 16px 16px;
    gap: 2px;
    flex: 1;
}
.hdr-mobile-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 14px;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    color: #333;
    text-decoration: none;
    transition: background 0.15s, color 0.15s;
}
.hdr-mobile-link i { width: 18px; color: #aaa; font-size: 0.95rem; transition: color 0.15s; }
.hdr-mobile-link:hover,
.hdr-mobile-link--active { background: #d5e8fd; color: #0b6698; }
.hdr-mobile-link:hover i,
.hdr-mobile-link--active i { color: #0b6698; }
.hdr-mobile-footer {
    padding: 20px 20px 32px;
    border-top: 1px solid #f2f2f2;
    display: flex;
    flex-direction: column;
    gap: 10px;
    flex-shrink: 0;
}
.hdr-mobile-langs {
    display: flex;
    gap: 8px;
    margin-bottom: 4px;
}
.hdr-mlang-btn {
    flex: 1;
    padding: 8px;
    border: 1px solid #e8e8e8;
    border-radius: 8px;
    background: #fff;
    font-size: 0.8rem;
    font-weight: 700;
    color: #444;
    cursor: pointer;
    transition: all 0.15s;
}
.hdr-mlang-btn:hover,
.hdr-mlang-btn.active { background: #0b6698; border-color: #0b6698; color: #fff; }
.hdr-mobile-cta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px;
    background: #0b6698;
    color: #fff;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.2s;
}
.hdr-mobile-cta:hover { background: #c92a0d; }

.hdr-mobile-cta-download {
    background: linear-gradient(135deg, #c92a0d, #0b6698) !important;
    color: #fff !important;
    border: none !important;
    padding: 14px;
}
.hdr-mobile-cta-download:hover { 
    filter: brightness(1.1);
}

.hdr-mobile-call {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px;
    border: 1px solid #e8e8e8;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    color: #333;
    text-decoration: none;
    transition: border-color 0.2s, color 0.2s;
}
.hdr-mobile-call i { color: #0b6698; }
.hdr-mobile-call:hover { border-color: #0b6698; color: #0b6698; }

/* Translate hide */
.goog-te-banner-frame, .goog-te-balloon-frame, #goog-gt-tt,
.goog-text-highlight, .skiptranslate { display: none !important; }
body { top: 0 !important; }
.goog-logo-link, .goog-te-gadget .goog-te-combo { display: none !important; }
.goog-te-gadget { color: transparent !important; font-size: 0 !important; }

/* ── Responsive breakpoints ── */
@media (max-width: 1100px) {
    .hdr-nav { gap: 0; }
    .hdr-link { padding: 8px 10px; font-size: 0.82rem; }
}
@media (max-width: 960px) {
    .hdr-nav { display: none; }
    .hdr-burger { display: flex; }
    .hdr-cta span { display: none; }
    .hdr-cta { padding: 10px 14px; }
    .hdr-lang-btn span { display: none; }
}
@media (max-width: 640px) {
    .hdr-inner { padding: 0 16px; gap: 12px; height: 60px; }
    .hdr-topbar-inner { padding: 0 16px; }
    .hdr-topbar-phone { display: none; }
    .hdr-logo img { height: 40px; }
    .hdr-cta { display: none; }
    .hdr-lang { display: none; }
}
</style>

<script>
/* Scroll shadow */
window.addEventListener('scroll', () => {
    document.getElementById('hdr').classList.toggle('hdr--scrolled', window.scrollY > 40);
});

/* Burger toggle */
const hdrBurger = document.getElementById('hdrBurger');
const hdrMobile = document.getElementById('hdrMobile');
const hdrMobileClose = document.getElementById('hdrMobileClose');

function openMobileMenu() {
    hdrMobile.classList.add('open');
    hdrMobile.setAttribute('aria-hidden', 'false');
    hdrBurger.classList.add('open');
    hdrBurger.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
}
function closeMobileMenu() {
    hdrMobile.classList.remove('open');
    hdrMobile.setAttribute('aria-hidden', 'true');
    hdrBurger.classList.remove('open');
    hdrBurger.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
}

hdrBurger?.addEventListener('click', openMobileMenu);
hdrMobileClose?.addEventListener('click', closeMobileMenu);
hdrMobile?.addEventListener('click', (e) => { if (e.target === hdrMobile) closeMobileMenu(); });

/* Language dropdown */
const langToggle = document.getElementById('langToggle');
const langParent = langToggle?.closest('.hdr-lang');
langToggle?.addEventListener('click', (e) => {
    e.stopPropagation();
    langParent.classList.toggle('open');
});
document.addEventListener('click', () => langParent?.classList.remove('open'));

/* Language switcher */
let pendingLanguage = 'en';
let translateScriptRequested = false;
let translateApplyTimer = null;

function applyGoogleTranslation(lang) {
    const gTranslate = document.querySelector('.goog-te-combo');
    if (!gTranslate || !Array.from(gTranslate.options).some(option => option.value === lang)) {
        return false;
    }

    gTranslate.value = lang;
    if (gTranslate.value !== lang) return false;

    gTranslate.dispatchEvent(new Event('change', { bubbles: true }));
    return true;
}

function applyPendingTranslation() {
    clearInterval(translateApplyTimer);

    let attempts = 0;
    let successfulDispatches = 0;
    translateApplyTimer = setInterval(() => {
        attempts += 1;
        if (applyGoogleTranslation(pendingLanguage)) {
            successfulDispatches += 1;
        }

        // The Google widget renders its select before its translation engine is
        // always ready. Keep dispatching briefly so the first user click is not lost.
        if (successfulDispatches >= 6 || attempts >= 40) {
            clearInterval(translateApplyTimer);
            translateApplyTimer = null;
        }
    }, 250);
}

function loadGoogleTranslate(lang) {
    pendingLanguage = lang;
    if (applyGoogleTranslation(lang)) {
        applyPendingTranslation();
        return;
    }

    if (translateScriptRequested) {
        applyPendingTranslation();
        return;
    }

    translateScriptRequested = true;
    const script = document.createElement('script');
    script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
    script.async = true;
    script.onerror = () => {
        translateScriptRequested = false;
        script.remove();
    };
    document.head.appendChild(script);
}

function changeLang(lang) {
    pendingLanguage = lang;
    localStorage.setItem('user_lang', lang);
    const labels = { en: 'EN', ta: 'தமிழ்', kn: 'ಕನ್ನಡ' };
    document.getElementById('langLabel').textContent = labels[lang] || 'EN';
    document.querySelectorAll('.hdr-lang-opt, .hdr-mlang-btn').forEach(b => b.classList.remove('active'));
    ['btn-en', 'btn-ta', 'btn-kn'].forEach(id => {
        const el = document.getElementById(id);
        if (el && id === 'btn-' + lang) el.classList.add('active');
    });
    if (lang === 'en') {
        clearInterval(translateApplyTimer);
        translateApplyTimer = null;
        applyGoogleTranslation(lang);
    } else {
        loadGoogleTranslate(lang);
    }
}

/* Init saved language */
document.addEventListener('DOMContentLoaded', () => {
    const saved = localStorage.getItem('user_lang') || 'en';
    changeLang(saved);
});

/* Ticker marquee engine */
(function () {
    var wrap = document.querySelector('.hdr-ticker');
    var track = document.querySelector('.hdr-ticker-track');
    if (!wrap || !track) return;
    var pos = 0;
    var speed = 0.5;
    var paused = false;
    var cloneAdded = false;
    var lastFrame = 0;

    function init() {
        if (!cloneAdded) {
            var clone = track.cloneNode(true);
            track.parentNode.appendChild(clone);
            cloneAdded = true;
        }
        step();
    }

    function step(timestamp) {
        if (!paused && !document.hidden && timestamp - lastFrame >= 32) {
            lastFrame = timestamp;
            pos -= speed;
            var setW = track.offsetWidth + 48; /* 48 = gap */
            if (Math.abs(pos) >= setW) pos = 0;
            track.parentNode.querySelectorAll('.hdr-ticker-track').forEach(function(t) {
                t.style.transform = 'translateX(' + pos + 'px)';
            });
        }
        requestAnimationFrame(step);
    }

    wrap.addEventListener('mouseenter', function () { paused = true; });
    wrap.addEventListener('mouseleave', function () { paused = false; });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

/* Google Translate init */
function googleTranslateElementInit() {
    new google.translate.TranslateElement({ pageLanguage: 'en', includedLanguages: 'en,ta,kn', autoDisplay: false }, 'google_translate_element');
    applyPendingTranslation();
}

function handleSingleDownload(event, element) {
    if (element.classList.contains('downloading')) {
        event.preventDefault();
        return;
    }
    
    // Disable further clicks visually and functionally
    element.classList.add('downloading');
    element.style.pointerEvents = 'none';
    element.style.opacity = '0.7';
    
    // Change button text and icon to show loading state
    const textSpan = element.querySelector('.btn-text');
    const originalText = textSpan ? textSpan.innerText : '';
    const icon = element.querySelector('i');
    
    if (textSpan) textSpan.innerText = 'Downloading...';
    if (icon) icon.className = 'fa-solid fa-spinner fa-spin';
    
    // Reset the button after 3 seconds
    setTimeout(() => {
        element.classList.remove('downloading');
        element.style.pointerEvents = 'auto';
        element.style.opacity = '1';
        if (textSpan) textSpan.innerText = originalText;
        if (icon) icon.className = 'fa-solid fa-download';
    }, 3000);
}
</script>
