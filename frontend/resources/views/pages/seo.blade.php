@extends('layouts.default')

@section('main-page')

<style>
/* ===========================================
   PREMIUM SEO PAGE STYLES (GOLDEN LIGHT)
   =========================================== */

/* 1. Page Background & Reading Bar */
.seo-page { 
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
.seo-hero {
    height: 65vh;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
    background: var(--ink);
}

.seo-hero-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    opacity: 0.5;
    transform: scale(1.1);
    transition: transform 0.8s cubic-bezier(0, 0, 0.2, 1);
}

.seo-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, transparent, var(--ink) 95%);
    z-index: 1;
}

.seo-hero-content {
    position: relative;
    z-index: 10;
    width: min(100% - 40px, 900px);
}

.seo-breadcrumb {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
    backdrop-filter: blur(10px);
    padding: 8px 20px;
    border-radius: 50px;
    border: 1.5px solid rgba(255, 255, 255, 0.4);
    color: rgba(255,255,255,0.9);
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 30px;
    text-decoration: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.seo-breadcrumb a { color: #fff; text-decoration: none; transition: 0.3s; }
.seo-breadcrumb a:hover { color: var(--gold-deep); }

.seo-eyebrow {
    display: block;
    color: var(--gold-deep);
    font-size: 0.9rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 5px;
    margin-bottom: 20px;
}

.seo-hero h1 {
    font-family: var(--font-display);
    font-size: clamp(2.5rem, 5vw, 4.5rem);
    color: #fff;
    line-height: 1.1;
    margin-bottom: 30px;
    font-weight: 900;
    text-shadow:
        0 2px 10px rgba(255, 255, 255, 0.3),
        0 0 40px rgba(255, 255, 255, 0.2),
        0 0 80px rgba(255, 255, 255, 0.1);
}

.seo-meta-cluster {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.seo-meta-pill {
    padding: 10px 20px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    border: 1.5px solid rgba(255, 255, 255, 0.3);
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    backdrop-filter: blur(5px);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2);
}

.seo-meta-pill i { color: var(--gold-deep); }

/* 3. Article Content Layout */
.seo-section {
    padding: 100px 0;
    position: relative;
}

.seo-container {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 60px;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 40px;
}

.seo-main-card {
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03));
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border-radius: 40px;
    overflow: hidden;
    box-shadow: 
        0 40px 100px rgba(0, 0, 0, 0.45),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.5) !important;
}

.seo-featured-img-wrap {
    position: relative;
    aspect-ratio: 16/9;
    overflow: hidden;
}

.seo-featured-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 1s cubic-bezier(0.19, 1, 0.22, 1);
}

.seo-main-card:hover .seo-featured-img { transform: scale(1.05); }

.seo-article-body {
    padding: 60px 80px;
}

.seo-content-header { margin-bottom: 50px; }
.seo-content-header h2 { 
    font-family: var(--font-display); 
    font-size: 2.8rem; 
    line-height: 1.2; 
    color: #fff; 
    margin-bottom: 20px;
    text-shadow: 0 2px 10px rgba(255, 255, 255, 0.2);
}

.seo-content-meta-bar {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 40px;
}

.seo-indicator { width: 50px; height: 3px; background: var(--gold-deep); }
.seo-brand-badge { font-weight: 900; text-transform: uppercase; letter-spacing: 2px; font-size: 0.75rem; color: var(--muted); }

.seo-rich-content {
    font-family: var(--font-body);
    font-size: 1.15rem;
    line-height: 1.8;
    color: var(--clay);
}

.seo-rich-content h3, .seo-rich-content h4 { font-family: var(--font-display); color: var(--ink); margin-top: 2em; margin-bottom: 1em; }
.seo-rich-content p { margin-bottom: 1.5em; }
.seo-rich-content ul, .seo-rich-content ol { margin-bottom: 2em; padding-left: 20px; }
.seo-rich-content li { margin-bottom: 10px; }

.seo-rich-content blockquote {
    margin: 3em 0;
    padding: 40px;
    background: var(--off-white);
    border-left: 5px solid var(--gold-deep);
    font-style: italic;
    font-size: 1.4rem;
    font-family: var(--font-display);
    color: var(--ink);
    border-radius: 0 20px 20px 0;
}

/* 4. Sidebar Styles */
.seo-sidebar { position: sticky; top: 110px; height: fit-content; }

.sidebar-card {
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.04));
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 30px;
    padding: 35px;
    border: 2px solid rgba(255, 255, 255, 0.4);
    margin-bottom: 30px;
    box-shadow: 
        0 24px 60px rgba(0, 0, 0, 0.35),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
}

.sidebar-title {
    font-family: var(--font-display);
    font-size: 1.6rem;
    color: var(--ink);
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.sidebar-title i { color: var(--gold-deep); font-size: 1.2rem; }

.related-item {
    display: flex;
    gap: 15px;
    text-decoration: none;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--off-white);
    transition: 0.3s;
}

.related-item:last-child { border: none; margin-bottom: 0; padding-bottom: 0; }

.related-item-img {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    background: var(--ink);
    display: flex; align-items: center; justify-content: center; color: var(--gold-deep);
}

.related-item-img img { width: 100%; height: 100%; object-fit: cover; }

.related-content .title {
    font-weight: 800;
    font-size: 0.95rem;
    color: var(--ink);
    line-height: 1.4;
    margin-bottom: 5px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}

.related-content .tag { font-size: 0.75rem; color: var(--gold-deep); font-weight: 700; text-transform: uppercase; }

.related-item:hover { transform: translateX(5px); }
.related-item:hover .title { color: var(--gold-deep); }

.tag-pills { display: flex; flex-wrap: wrap; gap: 8px; }
.tag-pill {
    padding: 8px 16px;
    border-radius: 50px;
    background: var(--off-white);
    color: var(--muted);
    font-size: 0.75rem;
    font-weight: 700;
    border: 1px solid var(--stone);
    transition: 0.3s;
}

.tag-pill:hover { background: var(--ink); color: #fff; border-color: var(--ink); }

@media (max-width: 1200px) {
    .seo-container { grid-template-columns: 1fr; }
    .seo-sidebar { position: relative; top: 0; margin-top: 40px; }
    .seo-article-body { padding: 40px; }
}

@media (max-width: 768px) {
    .seo-hero h1 { font-size: 2.8rem; }
}

/* Dark premium polish aligned with home/about/contact */
.seo-page {
    background:
        linear-gradient(180deg, rgba(8,8,16,0.98), rgba(12,12,24,0.98));
}

.seo-hero {
    min-height: 620px;
}

.seo-hero-overlay {
    background:
        radial-gradient(circle at 50% 42%, rgba(240,168,50,0.16), transparent 18rem),
        linear-gradient(to bottom, rgba(8,8,16,0.66), rgba(8,8,16,0.97));
}

.seo-breadcrumb,
.seo-meta-pill,
.seo-eyebrow {
    border: 1px solid rgba(240,168,50,0.24);
    background: rgba(212,134,10,0.1);
    color: rgba(255,255,255,0.82);
}

.seo-eyebrow {
    display: inline-flex;
    padding: 7px 16px;
    border-radius: 999px;
    color: var(--gold-light);
    letter-spacing: 2.5px;
}

.seo-section {
    background:
        radial-gradient(circle at 50% 0, rgba(212,134,10,0.1), transparent 26rem),
        linear-gradient(180deg, rgba(8,8,16,0.98), rgba(12,12,24,0.98));
}

.seo-main-card,
.sidebar-card {
    background: rgba(15,15,28,0.92);
    border-color: rgba(240,168,50,0.22);
    box-shadow: 0 24px 70px rgba(0,0,0,0.45);
}

.seo-content-header h2,
.seo-rich-content h3,
.seo-rich-content h4,
.sidebar-title,
.related-content .title {
    color: #fff;
}

.seo-rich-content,
.sidebar-card p {
    color: rgba(255,255,255,0.72);
}

/* Fix for editor inline styles on dark theme */
.seo-rich-content span, 
.seo-rich-content p, 
.seo-rich-content div,
.seo-rich-content font,
.seo-rich-content li {
    color: inherit !important;
    background-color: transparent !important;
}

.seo-rich-content h1,
.seo-rich-content h2,
.seo-rich-content h3,
.seo-rich-content h4,
.seo-rich-content h5,
.seo-rich-content h6 {
    color: #fff !important;
    text-shadow: 0 2px 10px rgba(255, 255, 255, 0.2);
    margin-top: 40px;
    margin-bottom: 20px;
}

.seo-rich-content ul, 
.seo-rich-content ol {
    padding-left: 25px;
    margin-bottom: 30px;
    color: rgba(255,255,255,0.72);
}

.seo-rich-content ul li::marker,
.seo-rich-content ol li::marker {
    color: var(--gold-light) !important;
    font-weight: 800;
}

.seo-rich-content li {
    margin-bottom: 12px;
}

.seo-rich-content strong, 
.seo-rich-content b {
    color: #fff !important;
    font-weight: 800;
}

.seo-rich-content a {
    color: var(--gold-light);
    font-weight: 700;
    text-decoration: underline;
}

.seo-rich-content blockquote {
    background: rgba(255,255,255,0.05);
    color: #fff;
    border-left: 4px solid var(--gold-light);
    padding: 20px 30px;
    margin: 40px 0;
    font-style: italic;
}

.seo-brand-badge,
.related-content .tag {
    color: var(--gold-light);
}

.related-item {
    border-bottom-color: rgba(255,255,255,0.1);
}

.tag-pill {
    background: rgba(255,255,255,0.05);
    border-color: rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.72);
}

@media (max-width: 575px) {
    .seo-hero {
        min-height: 540px;
        height: 68vh;
    }

    .seo-container {
        padding: 0 18px;
    }

    .seo-article-body,
    .sidebar-card {
        padding: 26px;
    }
}

</style>

<div class="seo-page">
    <!-- Reading Progress -->
    <div id="readProgress"></div>

    <!-- Cinematic Hero -->
    <section class="seo-hero">
        @if($seo->image)
            <div class="seo-hero-bg parallax-target" style="background-image:url('{{ env('MAIN_URL', '/') . $seo->image }}');"></div>
        @else
            <div class="seo-hero-bg parallax-target" style="background: linear-gradient(45deg, #1a0500, #2e0800);"></div>
        @endif
        <div class="seo-hero-overlay"></div>

        <div class="seo-hero-content">
            <div class="seo-breadcrumb wow fadeInUp">
                <a href="/"><i class="fa-solid fa-house"></i> Home</a>
                <i class="fa-solid fa-chevron-right" style="font-size:9px; opacity:0.5;"></i>
                <span>{{ Str::limit($seo->meta_title, 35) }}</span>
            </div>

            <span class="seo-eyebrow wow fadeInUp" data-wow-delay="0.1s">Bespoke Collection</span>
            <h1 class="wow fadeInUp" data-wow-delay="0.2s">{{ $seo->meta_title }}</h1>

            <div class="seo-meta-cluster wow fadeInUp" data-wow-delay="0.3s">
                @if($seo->meta_key)
                    <div class="seo-meta-pill"><i class="fa-solid fa-hashtag"></i> {{ explode(',', $seo->meta_key)[0] }}</div>
                @endif
                @if($seo->name)
                    <div class="seo-meta-pill"><i class="fa-solid fa-sparkles"></i> {{ $seo->name }}</div>
                @endif
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="seo-section">
        <div class="seo-container">
            
            <main class="seo-main-card wow fadeInUp">
                @if($seo->image)
                    <div class="seo-featured-img-wrap">
                        <img src="{{ env('MAIN_URL', '/') . $seo->image }}" class="seo-featured-img" alt="{{ $seo->alt_key ?? $seo->meta_title }}">
                    </div>
                @endif

                <div class="seo-article-body">
                    <div class="seo-content-header">
                        <div class="seo-content-meta-bar">
                            <div class="seo-indicator"></div>
                            <span class="seo-brand-badge">Premium Feature</span>
                        </div>
                        <h2>{{ $seo->meta_title }}</h2>
                    </div>

                    <div class="seo-rich-content">
                        {!! $seo->feet_content !!}
                    </div>

                    <div style="margin-top: 60px; padding-top: 40px; border-top: 1px solid var(--stone);">
                        <a href="/" class="btn-gold" style="display:inline-flex; width:auto; padding: 15px 35px; border-radius: 50px;">
                            <span>Back to Showcase</span> <i class="fa-solid fa-arrow-left" style="order:-1; margin-right:15px; margin-left:0;"></i>
                        </a>
                    </div>
                </div>
            </main>

            <!-- Sidebar -->
            <aside class="seo-sidebar">
                
                @if(isset($related) && $related->isNotEmpty())
                    <div class="sidebar-card wow fadeInUp">
                        <div class="sidebar-title"><i class="fa-solid fa-fire-flame-curved"></i> Elevated Guides</div>
                        <div class="related-list">
                            @foreach($related as $item)
                                <a href="{{ url($item->url) }}" class="related-item">
                                    <div class="related-item-img">
                                        @if($item->image)
                                            <img src="{{ env('MAIN_URL', '/') . $item->image }}" alt="{{ $item->meta_title }}">
                                        @else
                                            <i class="fa-solid fa-star"></i>
                                        @endif
                                    </div>
                                    <div class="related-content">
                                        <div class="title">{{ $item->meta_title }}</div>
                                        <span class="tag">{{ $item->name ?? 'Premium' }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($seo->meta_key)
                    <div class="sidebar-card wow fadeInUp" data-wow-delay="0.1s">
                        <div class="sidebar-title"><i class="fa-solid fa-tags"></i> Keywords</div>
                        <div class="tag-pills">
                            @foreach(explode(',', $seo->meta_key) as $tag)
                                <span class="tag-pill"># {{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

            </aside>
        </div>
    </section>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Reading Progress
        const progress = document.getElementById('readProgress');
        window.addEventListener('scroll', () => {
            const h = document.documentElement, 
                  b = document.body,
                  st = 'scrollTop',
                  sh = 'scrollHeight';
            const percent = (h[st]||b[st]) / ((h[sh]||b[sh]) - h.clientHeight) * 100;
            progress.style.width = percent + '%';

            // Parallax
            const target = document.querySelector('.parallax-target');
            if(target) {
                target.style.transform = `scale(1.1) translateY(${window.scrollY * 0.4}px)`;
            }
        });

    });
</script>
@endpush

@include('pages._cracker-canvas')

@endsection
