<!-- ===== CINEMATIC About FOOTER ===== -->
<footer class="About-footer">
    <div class="f-particles" id="footerParticles"></div>

    <div class="f-container">
        <!-- Brand Centerpiece -->
        <div class="f-brand-block">
            <a href="{{ url('/') }}" class="f-logo-wrap">
                <img src="{{ asset('assets/img/logo1.png') }}" alt="Sri Annapoorani Crackers">
            </a>
            <div class="f-brand-tag">Est. 2026 • Sivakasi's Premier Fireworks About</div>
            <div class="f-social-row">
                <a href="{{ $global_settings->facebook_link }}" target="_blank" class="s-link fb" title="Facebook"><i
                        class="fa-brands fa-facebook-f"></i></a>
                <a href="{{ $global_settings->instagram_link }}" target="_blank" class="s-link ig" title="Instagram"><i
                        class="fa-brands fa-instagram"></i></a>
                <a href="https://wa.me/{{ $global_settings->whatsapp_number }}" target="_blank" class="s-link wa"
                    title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                <a href="{{ $global_settings->youtube_link }}" target="_blank" class="s-link yt" title="YouTube"><i
                        class="fa-brands fa-youtube"></i></a>
            </div>
        </div>

        <!-- Links Grid -->
        <div class="f-grid">
            <div class="f-col">
                <h4 class="f-title">Company</h4>
                <ul class="f-list">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/about') }}">About Us</a></li>
                    <li><a href="{{ url('/estimate') }}">Catalogue</a></li>
                    <li><a href="{{ url('/blog') }}">Safety Tips</a></li>
                    <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                </ul>
            </div>
            <!-- <div class="f-col">
                <h4 class="f-title">Category</h4>
                <ul class="f-list">
                    @foreach($footerCategories as $category)
                        <li><a href="{{ url('/estimate?category=' . urlencode(strtolower($category->category_name))) }}">{{ $category->category_name }}</a></li>
                    @endforeach
                </ul>
            </div> -->
            <div class="f-col">
                <h4 class="f-title">Legal</h4>
                <ul class="f-list">
                    <!--<li><a href="{{ url('/terms-condition') }}">Privacy Policy</a></li>-->
                    <li><a href="{{ url('/terms-condition') }}">Terms & Conditions</a></li>
                    <!--<li><a href="{{ url('/contact') }}">Shipping Policy</a></li>-->
                </ul>
            </div>
            <div class="f-col contact-col">
                <h4 class="f-title">Address</h4>
                <div class="f-contact-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <p>{!! str_replace('Main Road,', 'Main Road,<br>', $contact->address ?? 'Viruthunagar to Saathur Main Road,<br>R.R.Nagar, Sivakasi.') !!}</p>
                </div>
            </div>
            
            <div class="f-col contact-col">
                <h4 class="f-title">Contact</h4>
                <div class="f-contact-item">
                    <i class="fa-solid fa-phone"></i>
                    <p><a href="tel:+919360353597">+91 9360353597</a></p>
                </div>
                <div class="f-contact-item">
                    <i class="fa-solid fa-envelope-open-text"></i>
                    <p><a href="mailto:{{ $contact->email }}">{{ $contact->email ?? 'care@Sri Annapooranicrackers.com' }}</a></p>
                </div>
            </div>
        </div>

        <!-- SEO MATRIX (Pilled) -->
        @php $seoHeadings = \App\Models\SeoHeading::with('seoDatas')->get(); @endphp
        @if($seoHeadings->count() > 0)
            <div class="f-seo-matrix">
                @foreach($seoHeadings as $heading)
                    <div class="f-seo-row">
                        <span class="seo-h">{{ $heading->heading }}:</span>
                        <div class="seo-pills">
                            @foreach($heading->seoDatas as $data)
                                <a href="{{ url($data->url) }}">{{ $data->meta_title }}</a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="f-bottom">
            <div class="f-copy">&copy; {{ date('Y') }}Sri Annapoorani Crackers. All Rights Reserved.</div>
            <div class="f-author">Crafted with ❤️ by <a href="https://saitechnosolutions.com" target="_blank">Sai Techno
                    Solutions</a></div>
        </div>
    </div>
</footer>

<style>
    /* ========================
   FOOTER STYLES (CINEMATIC)
   ======================== */
    .About-footer {
        background: linear-gradient(180deg, #FFFFFF, #f9f9f9);
        padding: 120px 40px 40px;
        position: relative;
        overflow: hidden;
        border-top: 2px solid rgba(229, 58, 18, 0.2);
        color: #000;
        font-family: var(--font-body);
        box-shadow: 0 -20px 60px rgba(0, 0, 0, 0.05);
    }

    .f-particles {
        position: absolute;
        inset: 0;
        pointer-events: none;
        opacity: 0.6;
        z-index: 1;
    }

    .f-container {
        max-width: 1400px;
        width: 100%;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

    /* Brand Centerpiece */
    .f-brand-block {
        text-align: center;
        margin-bottom: 100px;
    }

    .f-logo-wrap img {
        height: 80px;
        width: auto;
        margin-bottom: 25px;
        /* filter: brightness(0) invert(1); */
    }

    .f-brand-tag {
        font-family: var(--font-display);
        font-size: 1.4rem;
        color: #0b6698;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 35px;
        opacity: 0.8;
    }

    .f-social-row {
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .s-link {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        backdrop-filter: blur(10px);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15);
    }

    .s-link:hover {
        transform: translateY(-8px);
    }

    .s-link.fb {
        color: #1877F2;
        border: 1.5px solid rgba(24, 119, 242, 0.35);
        background: rgba(24, 119, 242, 0.08);
    }
    .s-link.fb:hover {
        background: #1877F2;
        border-color: #1877F2;
        color: #FFFFFF;
        box-shadow: 0 15px 30px rgba(24, 119, 242, 0.35);
    }

    .s-link.ig {
        color: #E4405F;
        border: 1.5px solid rgba(228, 64, 95, 0.35);
        background: rgba(228, 64, 95, 0.08);
    }
    .s-link.ig:hover {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        border-color: transparent;
        color: #FFFFFF;
        box-shadow: 0 15px 30px rgba(228, 64, 95, 0.35);
    }

    .s-link.wa {
        color: #25D366;
        border: 1.5px solid rgba(37, 211, 102, 0.35);
        background: rgba(37, 211, 102, 0.08);
    }
    .s-link.wa:hover {
        background: #25D366;
        border-color: #25D366;
        color: #FFFFFF;
        box-shadow: 0 15px 30px rgba(37, 211, 102, 0.35);
    }

    .s-link.yt {
        color: #FF0000;
        border: 1.5px solid rgba(255, 0, 0, 0.35);
        background: rgba(255, 0, 0, 0.08);
    }
    .s-link.yt:hover {
        background: #FF0000;
        border-color: #FF0000;
        color: #FFFFFF;
        box-shadow: 0 15px 30px rgba(255, 0, 0, 0.35);
    }

    /* Links Grid */
    .f-grid {
        display: grid;
        grid-template-columns: 1.2fr 1.2fr 1.6fr 1fr;
        gap: 40px;
        margin-bottom: 100px;
    }

    .f-title {
        font-family: var(--font-display);
        font-size: 1.6rem;
        font-weight: 700;
        color: #000;
        margin-bottom: 35px;
        position: relative;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .f-title::before {
        content: '';
        position: absolute;
        top: -15px;
        left: 0;
        width: 40px;
        height: 2px;
        background: #0b6698;
        box-shadow: 0 0 10px #0b6698;
    }

    .f-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 30px;
        height: 2px;
        background: #0b6698;
    }

    .f-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .f-list li {
        margin-bottom: 18px;
    }

    .f-list a {
        color: rgba(0, 0, 0, 0.6);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        transition: .3s;
    }

    .f-list a:hover {
        color: #0b6698;
        padding-left: 10px;
        text-shadow: 0 0 15px rgba(229, 58, 18, 0.3);
    }

    .f-contact-item {
        display: flex;
        gap: 20px;
        align-items: flex-start;
        margin-bottom: 25px;
        color: rgba(0, 0, 0, 0.6);
        font-size: 0.92rem;
    }

    .f-contact-item i {
        color: #0b6698;
        font-size: 1.2rem;
        margin-top: 2px;
    }

    .f-contact-item a {
        color: inherit;
        text-decoration: none;
        transition: .3s;
    }
    .f-contact-item a:hover {
        color: #0b6698;
    }

    /* SEO Matrix */
    .f-seo-matrix {
        padding: 30px 0;
        border-top: 2px solid rgba(0, 0, 0, 0.1);
    }

    .f-seo-row {
        display: flex;
        gap: 20px;
        /* margin-bottom: 30px; */
        align-items: flex-start;
    }

    .seo-h {
        font-weight: 800;
        color: #000;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        flex-shrink: 0;
        margin-top: 5px;
    }

    .seo-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 10px 15px;
    }

    .seo-pills a {
        color: rgba(0, 0, 0, 0.6);
        text-decoration: none;
        font-size: 0.85rem;
        padding: 5px 16px;
        border: 1.5px solid rgba(0, 0, 0, 0.2);
        background: rgba(0, 0, 0, 0.03);
        border-radius: 20px;
        transition: .4s;
        backdrop-filter: blur(5px);
    }

    .seo-pills a:hover {
        color: #FFFFFF;
        border-color: #0b6698;
        background: #0b6698;
        box-shadow: 0 10px 25px rgba(229, 58, 18, 0.2);
        transform: translateY(-2px);
    }

    /* Bottom */
    .f-bottom {
        padding-top: 50px;
        border-top: 2px solid rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        color: rgba(0, 0, 0, 0.5);
    }

    .f-author a {
        color: rgba(0, 0, 0, 0.6);
        text-decoration: none;
        font-weight: 700;
        transition: .3s;
    }

    .f-author a:hover {
        color: #0b6698;
    }

    @media (max-width: 1024px) {
        .f-grid {
            grid-template-columns: 1fr 1fr;
        }

        .f-brand-block {
            margin-bottom: 60px;
        }
    }

    @media (max-width: 600px) {
        .About-footer {
            padding: 60px 20px 20px;
        }

        .f-grid {
            grid-template-columns: 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .f-brand-block {
            margin-bottom: 40px;
        }

        .f-bottom {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        .f-seo-row {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<script>
    /* Particle Burst Animation for Footer */
    (function () {
        const parent = document.getElementById('footerParticles');
        const create = () => {
            const p = document.createElement('div');
            const size = Math.random() * 3 + 1;
            const duration = Math.random() * 3 + 4;
            // Use golden/orange hues for the dark theme
            const hue = 35 + Math.random() * 20;

            p.style.cssText = `
            position: absolute; width: ${size}px; height: ${size}px;
            background: hsl(${hue}, 90%, 60%);
            left: ${Math.random() * 100}%; bottom: -5px;
            border-radius: 50%; opacity: ${Math.random() * 0.5 + 0.2};
            box-shadow: 0 0 15px rgba(240, 168, 50, 0.6);
            animation: footerRise ${duration}s linear forwards;
        `;
            parent.appendChild(p);
            setTimeout(() => p.remove(), duration * 1000);
        };

        const style = document.createElement('style');
        style.innerHTML = `
        @keyframes footerRise {
            0% { transform: translateY(0) scale(1); opacity: 0; }
            10% { opacity: 1; }
            100% { transform: translateY(-400px) scale(0); opacity: 0; }
        }
    `;
        document.head.appendChild(style);
        setInterval(create, 300);
    })();
</script>
