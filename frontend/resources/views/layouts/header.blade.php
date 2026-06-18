<!-- ===== SPARK PARTICLES CANVAS ===== -->
<canvas class="sparks-canvas" id="sparksCanvas"></canvas>

<!-- ===== GOOGLE TRANSLATE (hidden widget) ===== -->
<div id="google_translate_element" style="display:none"></div>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,ta',
            autoDisplay: false
        }, 'google_translate_element');
    }
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!-- ===== TOP OFFER BAR ===== -->
<div class="top-offer-bar">
    <div class="offer-slider-wrap">
        <div class="offer-slider">
            {!! $global_settings->top_offer_text ?? '
                <span>🎆 Sri Annapoorani Crackers welcomes you to our store 🎆</span>
                <span class="highlight">🔥 Flash 80% OFF — Limited Time Only!</span>
                <span>🚀 Free Shipping on Orders Above ₹500</span>
                <span class="highlight">✨ India\'s Biggest Crackers Sale — Shop Now!</span>
                <span>🎇 Diwali Special Deals Live Now</span>
            ' !!}
        </div>
    </div>
</div>

<!-- ===== MAIN NAVBAR ===== -->
<div class="navbar-area">
    <div class="navbar-inner">

        <svg class="burst-deco left" width="60" height="60" viewBox="0 0 60 60">
            <g fill="none" stroke="#ff6a00" stroke-width="1.5">
                <line x1="30" y1="5" x2="30" y2="20" />
                <line x1="30" y1="40" x2="30" y2="55" />
                <line x1="5" y1="30" x2="20" y2="30" />
                <line x1="40" y1="30" x2="55" y2="30" />
                <line x1="12" y1="12" x2="22" y2="22" />
                <line x1="38" y1="38" x2="48" y2="48" />
                <line x1="48" y1="12" x2="38" y2="22" />
                <line x1="22" y1="38" x2="12" y2="48" />
                <circle cx="30" cy="30" r="5" fill="#ff6a00" />
            </g>
        </svg>

        <!-- LOGO -->
        <a href="/" class="logo-wrap">

            <div class="logo-text">
                <img src="{{ env('MAIN_URL', '/') . $global_settings->logo }}" class="shadow" alt="image">
            </div>
            <div class="logo-icon">
                <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="fireGrad" x1="0%" y1="100%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#ff2200" />
                            <stop offset="50%" stop-color="#ff6a00" />
                            <stop offset="100%" stop-color="#ffd700" />
                        </linearGradient>
                    </defs>
                    <rect x="22" y="20" width="16" height="28" rx="3" fill="url(#fireGrad)" />
                    <path d="M30 20 Q35 12 28 6" stroke="#ffd700" stroke-width="2" stroke-linecap="round" fill="none" />
                    <circle cx="28" cy="6" r="3" fill="#fff" opacity="0.9">
                        <animate attributeName="opacity" values="0.5;1;0.5" dur="0.6s" repeatCount="indefinite" />
                        <animate attributeName="r" values="2;4;2" dur="0.6s" repeatCount="indefinite" />
                    </circle>
                    <rect x="22" y="28" width="16" height="4" fill="rgba(0,0,0,0.25)" />
                    <g fill="#ffd700" opacity="0.8">
                        <polygon points="8,10 9.5,14.5 14,14.5 10.5,17 12,21.5 8,19 4,21.5 5.5,17 2,14.5 6.5,14.5"
                            transform="scale(0.6) translate(2,2)" />
                        <polygon points="50,8 51,11 54,11 51.5,13 52.5,16 50,14.5 47.5,16 48.5,13 46,11 49,11"
                            transform="scale(0.5) translate(50,0)" />
                    </g>
                    <rect x="22" y="45" width="16" height="3" rx="1.5" fill="rgba(0,0,0,0.4)" />
                </svg>
            </div>
        </a>

        <ul class="nav-links">
            <li><a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ url('/about') }}" class="nav-link {{ request()->is('about') ? 'active' : '' }}">About Us</a>
            </li>
            <li><a href="{{ url('/estimate') }}"
                    class="nav-link {{ request()->is('estimate') ? 'active' : '' }}">Estimate</a></li>
            <li><a href="{{ url('/bank') }}" class="nav-link {{ request()->is('bank') ? 'active' : '' }}">Payment
                    Info</a></li>
            <li><a href="{{ url('/blog') }}" class="nav-link {{ request()->is('blog*') ? 'active' : '' }}">Blog</a></li>
            <li><a href="{{ url('/contact') }}" class="nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact
                    Us</a></li>
        </ul>

        <div class="nav-actions">
            <!-- Custom styled language toggle -->
            <div class="lang-switcher">
                <button class="lang-btn" id="btn-en" onclick="setLang('en')">
                    <!-- <span class="lang-flag">EN</span> -->
                    <span class="lang-label">EN</span>
                </button>
                <div class="lang-divider"></div>
                <button class="lang-btn" id="btn-ta" onclick="setLang('ta')">
                    <!-- <span class="lang-flag">🇮🇳</span> -->
                    <span class="lang-label">தமிழ்</span>
                </button>
            </div>
            <div class="hamburger"><span></span><span></span><span></span></div>
        </div>

        <svg class="burst-deco right" width="60" height="60" viewBox="0 0 60 60">
            <g fill="none" stroke="#ff6a00" stroke-width="1.5">
                <line x1="30" y1="5" x2="30" y2="20" />
                <line x1="30" y1="40" x2="30" y2="55" />
                <line x1="5" y1="30" x2="20" y2="30" />
                <line x1="40" y1="30" x2="55" y2="30" />
                <line x1="12" y1="12" x2="22" y2="22" />
                <line x1="38" y1="38" x2="48" y2="48" />
                <line x1="48" y1="12" x2="38" y2="22" />
                <line x1="22" y1="38" x2="12" y2="48" />
                <circle cx="30" cy="30" r="5" fill="#ff6a00" />
            </g>
        </svg>
    </div>
    <div class="fire-edge"></div>
</div>

<!-- ===== FIRE STICKY HEADER ===== -->
<div class="fire-sticky" id="fireStickyHeader">
    <div class="fire-sticky-bar">
        <svg class="sticky-burst left" width="50" height="50" viewBox="0 0 60 60">
            <g fill="none" stroke="#ff6a00" stroke-width="1.5">
                <line x1="30" y1="5" x2="30" y2="20" />
                <line x1="30" y1="40" x2="30" y2="55" />
                <line x1="5" y1="30" x2="20" y2="30" />
                <line x1="40" y1="30" x2="55" y2="30" />
                <line x1="12" y1="12" x2="22" y2="22" />
                <line x1="38" y1="38" x2="48" y2="48" />
                <line x1="48" y1="12" x2="38" y2="22" />
                <line x1="22" y1="38" x2="12" y2="48" />
                <circle cx="30" cy="30" r="5" fill="#ff6a00" />
            </g>
        </svg>

        <div class="fire-sticky-inner">
            <a href="/" class="sticky-logo">

                <div class="sticky-logo-text">
                    <img src="{{ env('MAIN_URL', '/') . $global_settings->logo }}" class="shadow" alt="image">
                </div>
                <div class="sticky-logo-icon">
                    <svg viewBox="0 0 60 60" fill="none">
                        <defs>
                            <linearGradient id="stickyFireGrad" x1="0%" y1="100%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#ff2200" />
                                <stop offset="50%" stop-color="#ff6a00" />
                                <stop offset="100%" stop-color="#ffd700" />
                            </linearGradient>
                        </defs>
                        <rect x="22" y="20" width="16" height="28" rx="3" fill="url(#stickyFireGrad)" />
                        <path d="M30 20 Q35 12 28 6" stroke="#ffd700" stroke-width="2" stroke-linecap="round"
                            fill="none" />
                        <circle cx="28" cy="6" r="3" fill="#fff" opacity="0.9">
                            <animate attributeName="opacity" values="0.5;1;0.5" dur="0.6s" repeatCount="indefinite" />
                            <animate attributeName="r" values="2;4;2" dur="0.6s" repeatCount="indefinite" />
                        </circle>
                        <rect x="22" y="28" width="16" height="4" fill="rgba(0,0,0,0.25)" />
                        <g fill="#ffd700" opacity="0.8">
                            <polygon points="8,10 9.5,14.5 14,14.5 10.5,17 12,21.5 8,19 4,21.5 5.5,17 2,14.5 6.5,14.5"
                                transform="scale(0.6) translate(2,2)" />
                        </g>
                        <rect x="22" y="45" width="16" height="3" rx="1.5" fill="rgba(0,0,0,0.4)" />
                    </svg>
                </div>
            </a>

            <ul class="sticky-nav-links">
                <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home
                        @if(request()->is('/')) <span class="nav-star">✦</span> @endif</a></li>
                <li><a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About Us</a></li>
                <li><a href="{{ url('/estimate') }}"
                        class="{{ request()->is('estimate') ? 'active' : '' }}">Estimate</a></li>
                <li><a href="{{ url('/bank') }}" class="{{ request()->is('bank') ? 'active' : '' }}">Payment Info</a>
                </li>
                <li><a href="{{ url('/blog') }}" class="{{ request()->is('blog*') ? 'active' : '' }}">Blog</a></li>
                <li><a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact
                        Us</a></li>
            </ul>

            <div class="sticky-actions">
                <div class="lang-switcher sticky-lang">
                    <button class="lang-btn" id="sticky-btn-en" onclick="setLang('en')">
                        <!-- <span class="lang-flag">🇬🇧</span> -->
                        <span class="lang-label">EN</span>
                    </button>
                    <div class="lang-divider"></div>
                    <button class="lang-btn" id="sticky-btn-ta" onclick="setLang('ta')">
                        <!-- <span class="lang-flag">🇮🇳</span> -->
                        <span class="lang-label">தமிழ்</span>
                    </button>
                </div>
                <button class="sticky-hamburger" id="stickyHamburger" aria-label="Menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>

        <div class="sticky-fire-edge"></div>

        <svg class="sticky-burst right" width="50" height="50" viewBox="0 0 60 60">
            <g fill="none" stroke="#ff6a00" stroke-width="1.5">
                <line x1="30" y1="5" x2="30" y2="20" />
                <line x1="30" y1="40" x2="30" y2="55" />
                <line x1="5" y1="30" x2="20" y2="30" />
                <line x1="40" y1="30" x2="55" y2="30" />
                <line x1="12" y1="12" x2="22" y2="22" />
                <line x1="38" y1="38" x2="48" y2="48" />
                <line x1="48" y1="12" x2="38" y2="22" />
                <line x1="22" y1="38" x2="12" y2="48" />
                <circle cx="30" cy="30" r="5" fill="#ff6a00" />
            </g>
        </svg>
    </div>
</div>

<!-- ===== MOBILE DRAWER ===== -->
<div class="sticky-mobile-menu" id="stickyMobileMenu">
    <div class="mobile-menu-inner">
        <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
        <a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About Us</a>
        <a href="{{ url('/estimate') }}" class="{{ request()->is('estimate') ? 'active' : '' }}">Estimate</a>
        <a href="{{ url('/bank') }}" class="{{ request()->is('bank') ? 'active' : '' }}">Payment Info</a>
        <a href="{{ url('/blog') }}" class="{{ request()->is('blog*') ? 'active' : '' }}">Blog</a>
        <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact Us</a>
    </div>
    <div class="mobile-divider"></div>
    <div class="mobile-lang-wrap">
        <div class="lang-switcher mobile-lang">
            <button class="lang-btn" id="mobile-btn-en" onclick="setLang('en')">
                <span class="lang-flag">🇬🇧</span>
                <span class="lang-label">English</span>
            </button>
            <div class="lang-divider"></div>
            <button class="lang-btn" id="mobile-btn-ta" onclick="setLang('ta')">
                <span class="lang-flag">🇮🇳</span>
                <span class="lang-label">தமிழ்</span>
            </button>
        </div>
    </div>
</div>



<!-- ===== GOOGLE TRANSLATE CONTROLLER ===== -->
<style>
    @media (max-width: 2000px) and (min-width: 1025px) {
        .logo-icon svg {
            margin-left: 100px;
            transition: margin-left 0.3s ease;
        }

        /* Adjust margin specifically for Tamil language */
        html.lang-ta .logo-icon svg {
            margin-left: 50px !important;
        }

        .sticky-logo-icon svg {
            margin-left: 110px;
        }
    }

    @media (max-width: 1024px) and (min-width: 908px) {
        .logo-icon svg {
            margin-left: 50px;
        }

        .sticky-logo-icon svg {
            margin-left: 45px;
        }
    }
</style>
<script>
    (function () {

        var STORAGE_KEY = 'Bluvel_lang';

        function syncButtons(lang) {
            ['en', 'ta'].forEach(function (l) {
                ['btn-' + l, 'sticky-btn-' + l, 'mobile-btn-' + l].forEach(function (id) {
                    var el = document.getElementById(id);
                    if (el) el.classList.toggle('active', l === lang);
                });
            });

            // Toggle a class on the root element for CSS language-based styling
            document.documentElement.classList.toggle('lang-ta', lang === 'ta');

            localStorage.setItem(STORAGE_KEY, lang);
        }

        function doTranslate(lang) {
            // Wait for Google Translate iframe to be ready
            var attempts = 0;
            var interval = setInterval(function () {
                attempts++;

                // Method 1: Use the hidden select dropdown Google injects
                var select = document.querySelector('.goog-te-combo');
                if (select) {
                    select.value = lang;
                    select.dispatchEvent(new Event('change'));
                    clearInterval(interval);
                    syncButtons(lang);
                    return;
                }

                // Method 2: Use Google's iframe postMessage
                var iframe = document.querySelector('.goog-te-banner-frame') ||
                    document.querySelector('iframe.skiptranslate');
                if (iframe) {
                    try {
                        iframe.contentWindow.document
                            .querySelector('[value="' + lang + '"]').click();
                        clearInterval(interval);
                        syncButtons(lang);
                        return;
                    } catch (e) { }
                }

                if (attempts > 20) clearInterval(interval); // give up after 2s
            }, 100);
        }

        window.setLang = function (lang) {
            syncButtons(lang);

            if (lang === 'en') {
                // Google Translate has a built-in "restore" button — trigger it
                var restore = document.querySelector('.goog-te-banner-frame');
                if (restore) {
                    try {
                        restore.contentWindow.document
                            .querySelector('.goog-close-link').click();
                        return;
                    } catch (e) { }
                }

                // Fallback: clear cookie and reload
                var host = window.location.hostname;
                var exp = 'expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
                ['', '; domain=' + host, '; domain=.' + host,
                    '; domain=saitechnosolutions.in',
                    '; domain=.saitechnosolutions.in'].forEach(function (d) {
                        document.cookie = 'googtrans=; ' + exp + d;
                    });
                window.location.replace(window.location.href);
                return;
            }

            doTranslate(lang);
        };

        // On page load, restore last used language
        document.addEventListener('DOMContentLoaded', function () {
            var saved = localStorage.getItem(STORAGE_KEY) || 'en';
            syncButtons(saved);
            if (saved !== 'en') {
                // Wait for Google widget to load, then apply
                setTimeout(function () { doTranslate(saved); }, 800);
            }
        });

    })();
</script>

<!-- ===== STICKY SCROLL + HAMBURGER JS ===== -->
<script>
    (function () {
        var header = document.getElementById('fireStickyHeader');
        var stickyHamburger = document.getElementById('stickyHamburger');
        var mobileMenu = document.getElementById('stickyMobileMenu');
        var mainNavbar = document.querySelector('.navbar-area');
        var mainHamburger = document.querySelector('.navbar-area .hamburger');
        var THRESHOLD = 120;

        function positionAndToggle(triggerBtn) {
            // Close if already open from a different trigger
            var isOpen = mobileMenu.classList.contains('open');

            if (window.scrollY > THRESHOLD) {
                // Sticky header is visible — position below it
                mobileMenu.style.top = header.getBoundingClientRect().bottom + 'px';
            } else {
                // Main navbar is visible — position below it
                mobileMenu.style.top = mainNavbar.getBoundingClientRect().bottom + 'px';
            }

            triggerBtn.classList.toggle('open');
            mobileMenu.classList.toggle('open');
        }

        /* Sticky hamburger */
        stickyHamburger.addEventListener('click', function () {
            // Close main hamburger if open
            if (mainHamburger) mainHamburger.classList.remove('open');
            positionAndToggle(stickyHamburger);
        });

        /* Main navbar hamburger */
        if (mainHamburger) {
            mainHamburger.addEventListener('click', function () {
                // Close sticky hamburger if open
                stickyHamburger.classList.remove('open');
                positionAndToggle(mainHamburger);
            });
        }

        /* Scroll handler */
        window.addEventListener('scroll', function () {
            if (window.scrollY > THRESHOLD) {
                header.classList.add('visible');
            } else {
                header.classList.remove('visible');
                stickyHamburger.classList.remove('open');
                mobileMenu.classList.remove('open');
            }

            if (mainHamburger) mainHamburger.classList.remove('open');
            mobileMenu.classList.remove('open');
        }, { passive: true });

    })();
</script>

<!-- ===== SPARK PARTICLES JS ===== -->
<script>
    const canvas = document.getElementById('sparksCanvas');
    const ctx = canvas.getContext('2d');
    function resize() { canvas.width = window.innerWidth; canvas.height = 160; }
    resize();
    window.addEventListener('resize', resize);
    const sparks = [];
    function createSpark() {
        return {
            x: Math.random() * canvas.width, y: canvas.height,
            vx: (Math.random() - 0.5) * 1.5, vy: -(Math.random() * 2.5 + 1),
            life: 1, decay: Math.random() * 0.015 + 0.008, size: Math.random() * 2.5 + 1,
            color: Math.random() > 0.5
                ? `hsl(${30 + Math.random() * 30}, 100%, ${55 + Math.random() * 20}%)`
                : `hsl(${50 + Math.random() * 20}, 100%, 70%)`
        };
    }
    function update() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        if (Math.random() < 0.3) sparks.push(createSpark());
        if (sparks.length > 120) sparks.splice(0, 5);
        for (let i = sparks.length - 1; i >= 0; i--) {
            const s = sparks[i];
            s.x += s.vx; s.y += s.vy; s.vy += 0.04; s.life -= s.decay;
            if (s.life <= 0) { sparks.splice(i, 1); continue; }
            ctx.save();
            ctx.globalAlpha = s.life * 0.8;
            ctx.beginPath();
            ctx.arc(s.x, s.y, s.size * s.life, 0, Math.PI * 2);
            ctx.fillStyle = s.color; ctx.shadowBlur = 8; ctx.shadowColor = s.color;
            ctx.fill(); ctx.restore();
        }
        requestAnimationFrame(update);
    }
    update();
</script>