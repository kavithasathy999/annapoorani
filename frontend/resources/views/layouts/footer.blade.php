<!-- ===== Bluvel FIRE FOOTER ===== -->
<footer class="blvel-footer">

    <!-- Background image layer -->
    <div class="footer-bg-image"></div>
    <div class="footer-bg-pattern"></div>

    <!-- Spark canvas -->
    <canvas class="footer-sparks-canvas" id="footerSparksCanvas"></canvas>

    <!-- Floating emoji crackers -->
    <div class="footer-float-icons" id="footerFloatIcons"></div>

    <!-- Burst decorations -->
    <svg class="footer-burst-deco left" width="120" height="120" viewBox="0 0 120 120">
        <g fill="none" stroke="#ff6a00" stroke-width="2">
            <line x1="60" y1="5" x2="60" y2="35" />
            <line x1="60" y1="85" x2="60" y2="115" />
            <line x1="5" y1="60" x2="35" y2="60" />
            <line x1="85" y1="60" x2="115" y2="60" />
            <line x1="22" y1="22" x2="42" y2="42" />
            <line x1="78" y1="78" x2="98" y2="98" />
            <line x1="98" y1="22" x2="78" y2="42" />
            <line x1="42" y1="78" x2="22" y2="98" />
            <circle cx="60" cy="60" r="10" fill="#ff6a00" />
            <circle cx="60" cy="60" r="20" stroke-width="1" opacity="0.4" />
            <circle cx="60" cy="60" r="30" stroke-width="0.5" opacity="0.2" />
        </g>
    </svg>

    <svg class="footer-burst-deco right" width="100" height="100" viewBox="0 0 120 120">
        <g fill="none" stroke="#ffd700" stroke-width="2">
            <line x1="60" y1="5" x2="60" y2="30" />
            <line x1="60" y1="90" x2="60" y2="115" />
            <line x1="5" y1="60" x2="30" y2="60" />
            <line x1="90" y1="60" x2="115" y2="60" />
            <line x1="24" y1="24" x2="40" y2="40" />
            <line x1="80" y1="80" x2="96" y2="96" />
            <line x1="96" y1="24" x2="80" y2="40" />
            <line x1="40" y1="80" x2="24" y2="96" />
            <circle cx="60" cy="60" r="10" fill="#ffd700" opacity="0.7" />
        </g>
    </svg>

    <svg class="footer-burst-deco center-top" width="200" height="200" viewBox="0 0 200 200">
        <g fill="none" stroke="#ff6a00" stroke-width="1">
            <line x1="100" y1="10" x2="100" y2="50" />
            <line x1="100" y1="150" x2="100" y2="190" />
            <line x1="10" y1="100" x2="50" y2="100" />
            <line x1="150" y1="100" x2="190" y2="100" />
            <line x1="36" y1="36" x2="64" y2="64" />
            <line x1="136" y1="136" x2="164" y2="164" />
            <line x1="164" y1="36" x2="136" y2="64" />
            <line x1="64" y1="136" x2="36" y2="164" />
            <circle cx="100" cy="100" r="16" fill="#ff6a00" opacity="0.5" />
            <circle cx="100" cy="100" r="35" stroke-width="0.5" opacity="0.3" />
        </g>
    </svg>

    <!-- ===== MAIN GRID ===== -->
    <div class="footer-main">

        <!-- COL 1 — Brand -->
        <div class="footer-col">
            <a href="/" class="footer-brand-logo">

                <div class="footer-brand-text">
                    <img src="{{ env('MAIN_URL', '/') . $global_settings->logo }}" class="shadow" alt="image">
                </div>
                <div class="footer-logo-icon">
                    <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="footerFireGrad" x1="0%" y1="100%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#ff2200" />
                                <stop offset="50%" stop-color="#ff6a00" />
                                <stop offset="100%" stop-color="#ffd700" />
                            </linearGradient>
                        </defs>
                        <rect x="22" y="20" width="16" height="28" rx="3" fill="url(#footerFireGrad)" />
                        <path d="M30 20 Q35 12 28 6" stroke="#ffd700" stroke-width="2" stroke-linecap="round"
                            fill="none" />
                        <circle cx="28" cy="6" r="3" fill="#ffd700" opacity="0.9">
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

            <p class="footer-brand-desc">
                {!! $global_settings->footer_content ?? 'Since 2026, Bluvel Crackers has been Sivakasi\'s No.1 destination for premium fireworks. We bring joy, colour and light to every celebration across India.' !!}
            </p>

            <div class="footer-socials">
                @if($global_settings->facebook_link)
                    <a href="{{ $global_settings->facebook_link }}" target="_blank" class="footer-social-btn"
                        title="Facebook">
                        <i class="bx bxl-facebook"></i>
                    </a>
                @endif
                @if($global_settings->instagram_link)
                    <a href="{{ $global_settings->instagram_link }}" target="_blank" class="footer-social-btn"
                        title="Instagram">
                        <i class="bx bxl-instagram"></i>
                    </a>
                @endif
                @if($global_settings->whatsapp_number)
                    <a href="https://wa.me/{{ $global_settings->whatsapp_number }}" target="_blank"
                        class="footer-social-btn" title="WhatsApp">
                        <i class="bx bxl-whatsapp"></i>
                    </a>
                @endif
                @if($global_settings->youtube_link)
                    <a href="{{ $global_settings->youtube_link }}" target="_blank" class="footer-social-btn"
                        title="YouTube">
                        <i class="bx bxl-youtube"></i>
                    </a>
                @endif
                @if($global_settings->twitter_link)
                    <a href="{{ $global_settings->twitter_link }}" target="_blank" class="footer-social-btn"
                        title="Twitter">
                        <i class="bx bxl-twitter"></i>
                    </a>
                @endif
            </div>
        </div>

        <!-- COL 2 — Quick Links -->
        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul class="footer-links">
                <li><a href="/">Home</a></li>
                <li><a href="/about">About Us</a></li>
                <li><a href="/estimate">Estimate</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/bank">Payment Info</a></li>
                <li><a href="/contact">Contact Us</a></li>
            </ul>
        </div>

        <!-- COL 3 — Support -->
        <div class="footer-col">
            <h4>Support</h4>
            <ul class="footer-links">
                <li><a href="/estimate">Get a Quote</a></li>
                <li><a href="/bank">Bank Details</a></li>
                <li><a href="/terms-condition">Terms & Conditions</a></li>
            </ul>
        </div>

        <!-- COL 4 — Contact Info -->
        <div class="footer-col">
            <h4>Find Us</h4>
            <ul class="footer-contact-list footer-contact-detailed">
                <li>
                    <span class="ci"><i class="fa-solid fa-location-dot"></i></span>
                    <div>
                        <strong>Address:</strong>
                        <span>{!! $contact->address ?? 'No. 12, Main Bazaar Street,<br>Sivakasi – 626 123,<br>Tamil Nadu, India' !!}</span>
                    </div>
                </li>
                <li>
                    <span class="ci"><i class="fa-solid fa-phone"></i></span>
                    <div>
                        <strong>Phone:</strong>
                        <a href="tel:{{ $contact->phone }}">{{ $contact->phone ?? '+91 987654321' }}</a>
                    </div>
                </li>
                <li>
                    <span class="ci"><i class="fa-solid fa-envelope"></i></span>
                    <div>
                        <strong>Email:</strong>
                        <a href="mailto:{{ $contact->email ?? '' }}">{{ $contact->email ?? 'No email provided' }}</a>
                    </div>
                </li>
                <li>
                    <span class="ci"><i class="fa-solid fa-clock"></i></span>
                    <div>
                        <strong>Working Hours</strong>
                        <span>Mon – Sat: 9:00 AM – 7:00 PM</span><br>
                        <span>Sunday: 10:00 AM – 4:00 PM</span>
                    </div>
                </li>
            </ul>
        </div>

    </div>

    <!-- Divider -->
    <div class="footer-divider"></div>
    @php
        $seoHeadings = \App\Models\SeoHeading::with('seoDatas')->get();
    @endphp
    <div class="footer-product-row">
        <div class="footer-product-cols">

            @foreach($seoHeadings as $heading)

                <div class="footer-product-col">
                    <div class="footer-product-col-header">
                        <h5>{{ $heading->heading }}</h5>
                    </div>

                    <ul class="footer-product-links">
                        @foreach($heading->seoDatas as $data)
                            <li>
                                <a href="{{ url($data->url) }}">
                                    {{ $data->meta_title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

            @endforeach

        </div>
    </div>

    <!-- Second Divider -->
    <div class="footer-divider"></div>

    <!-- Bottom bar -->
    <div class="footer-bottom">
        <p class="footer-copyright">
            © {{ date('Y') }} <a href="/">Bluvel Crackers</a>. All rights reserved.
        </p>
        <div class="footer-legal">
            <a href="https://saitechnosolutions.com/">Developed By Sai Techno Solutions</a>
        </div>
    </div>

</footer>


<script>
    (function () {
        var canvas = document.getElementById('footerSparksCanvas');
        if (!canvas) return;
        var ctx = canvas.getContext('2d');

        function resize() {
            canvas.width = canvas.offsetWidth;
            canvas.height = 200;
        }
        resize();
        window.addEventListener('resize', resize);

        var sparks = [];

        function createSpark() {
            var colors = [
                'hsl(' + (30 + Math.random() * 30) + ',100%,' + (55 + Math.random() * 20) + '%)',
                'hsl(' + (50 + Math.random() * 20) + ',100%,70%)',
                'hsl(0,100%,60%)'
            ];
            return {
                x: Math.random() * canvas.width,
                y: canvas.height,
                vx: (Math.random() - 0.5) * 1.2,
                vy: -(Math.random() * 2 + 0.8),
                life: 1,
                decay: Math.random() * 0.012 + 0.006,
                size: Math.random() * 2 + 0.8,
                color: colors[Math.floor(Math.random() * colors.length)]
            };
        }

        function tick() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            if (Math.random() < 0.25) sparks.push(createSpark());
            if (sparks.length > 80) sparks.splice(0, 4);

            for (var i = sparks.length - 1; i >= 0; i--) {
                var s = sparks[i];
                s.x += s.vx;
                s.y += s.vy;
                s.vy += 0.03;
                s.life -= s.decay;
                if (s.life <= 0) { sparks.splice(i, 1); continue; }

                ctx.save();
                ctx.globalAlpha = s.life * 0.7;
                ctx.beginPath();
                ctx.arc(s.x, s.y, s.size * s.life, 0, Math.PI * 2);
                ctx.fillStyle = s.color;
                ctx.shadowBlur = 7;
                ctx.shadowColor = s.color;
                ctx.fill();
                ctx.restore();
            }
            requestAnimationFrame(tick);
        }
        tick();
    })();
</script>

<!-- ===== FLOATING CRACKER ICONS JS ===== -->
<script>
    (function () {
        var container = document.getElementById('footerFloatIcons');
        if (!container) return;

        var icons = ['🎆', '🎇', '✨', '🔥', '💥', '🌟', '⭐'];

        function spawnIcon() {
            var el = document.createElement('div');
            el.className = 'float-cracker';
            el.textContent = icons[Math.floor(Math.random() * icons.length)];
            var x = Math.random() * 100;
            var duration = 6 + Math.random() * 8;
            var delay = Math.random() * 4;
            var size = 28 + Math.random() * 32;

            el.style.cssText =
                'left:' + x + '%;' +
                'bottom:0;' +
                'font-size:' + size + 'px;' +
                'animation-duration:' + duration + 's;' +
                'animation-delay:' + delay + 's;';

            container.appendChild(el);
            setTimeout(function () { el.remove(); }, (duration + delay) * 1000 + 200);
        }

        setInterval(spawnIcon, 1200);
        for (var i = 0; i < 5; i++) setTimeout(spawnIcon, i * 300);
    })();
</script>