@extends('layouts.default')

@section('main-page')



    <!-- ===== READING PROGRESS BAR ===== -->
    <div id="readProgress"></div>

    <!-- ===== EMBER PARTICLES ===== -->
    <div id="singleBlogEmbers"></div>

    <!-- ===========================================
             HERO BANNER
        =========================================== -->
    <div class="single-blog-hero">
        @if($seo->image)
            <div class="single-blog-hero-bg" style="background-image:url('{{ env('MAIN_URL', '/') . $seo->image }}');"></div>
        @else
            <div class="single-blog-hero-bg"
                style="background: radial-gradient(ellipse at center, #2e0800 0%, #0a0000 100%);filter:none;"></div>
        @endif

        <div class="single-blog-hero-content">
            <!-- Breadcrumb pill -->
            <div class="single-blog-breadcrumb">
                <a href="/"><i class="fa-solid fa-house"></i> Home</a>
                <i class="fa-solid fa-chevron-right" style="font-size:9px;opacity:0.5;"></i>
                <span style="color:rgba(255,220,160,0.7);">{{ Str::limit($seo->meta_title, 35) }}</span>
            </div>

            <div class="single-blog-eyebrow">�9�Bluvelel Crackers �� Guide</div>

            <h1>{{ $seo->meta_title }}</h1>

            <div class="single-blog-meta">
                @if($seo->meta_key)
                    <span><i class="fa-solid fa-tag"></i> {{ Str::limit($seo->meta_key, 30) }}</span>
                @endif
                @if($seo->name)
                    <span><i class="fa-solid fa-fire"></i> {{ $seo->name }}</span>
                @endif
                <!-- <span><i class="fa-solid fa-clock"></i>
                        {{ max(1, ceil(str_word_count(strip_tags($seo->feet_content ?? '')) / 200)) }} min read
                    </span> -->
            </div>
        </div>

        <div class="single-blog-fire-edge"></div>
    </div>

    <!-- ===========================================
             CONTENT + SIDEBAR
        =========================================== -->
    <section class="single-blog-section">
        <div class="single-blog-wrap">

            <!-- ===== MAIN ARTICLE ===== -->
            <article class="blog-main-card">

                {{-- Featured image --}}
                @if($seo->image)
                    <div class="blog-main-img-wrap">
                        <img class="blog-main-featured-img" src="{{ env('MAIN_URL', '/') . $seo->image }}"
                            alt="{{ $seo->alt_key ?? $seo->meta_title }}">
                        <div class="blog-main-img-overlay"></div>
                    </div>
                @endif

                {{-- Meta info strip --}}
                <div class="blog-article-meta-strip">
                    @if($seo->name)
                        <span class="blog-meta-chip">
                            <i class="fa-solid fa-layer-group"></i>
                            {{ $seo->name }}
                        </span>
                        <div class="blog-meta-dot"></div>
                    @endif
                    @if($seo->meta_key)
                        <span class="blog-meta-chip">
                            <i class="fa-solid fa-tag"></i>
                            {{ $seo->meta_key }}
                        </span>
                        <div class="blog-meta-dot"></div>
                    @endif
                    <!-- <span class="blog-meta-chip">
                            <i class="fa-solid fa-clock"></i>
                            {{ max(1, ceil(str_word_count(strip_tags($seo->feet_content ?? '')) / 200)) }} min read
                        </span> -->
                </div>


                <div class="blog-main-body">

                    <h2 class="blog-content-title">{{ $seo->meta_title }}</h2>

                    <div class="blog-content-under-title">
                        <div class="blog-content-fire-bar"></div>
                        <div class="blog-content-fire-label">Bluvel Crackers</div>
                    </div>


                    <div class="blog-content-body">
                        {!! $seo->feet_content !!}
                    </div>

                    {{-- Footer: back button + share --}}
                    <div class="blog-article-footer">
                        <a href="/" class="blog-back-btn">
                            <i class="fa-solid fa-arrow-left"></i> Back to Home
                        </a>
                        <!--<div class="blog-share-row">-->
                        <!--    <span class="blog-share-label">Share</span>-->
                        <!--    <a class="blog-share-btn"-->
                        <!--       href="https://wa.me/?text={{ urlencode($seo->meta_title . ' ' . url()->current()) }}"-->
                        <!--       target="_blank" title="WhatsApp">-->
                        <!--        <i class="fa-brands fa-whatsapp" style="color:#25d366;"></i>-->
                        <!--    </a>-->
                        <!--    <a class="blog-share-btn"-->
                        <!--       href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"-->
                        <!--       target="_blank" title="Facebook">-->
                        <!--        <i class="fa-brands fa-facebook-f" style="color:#1877f2;"></i>-->
                        <!--    </a>-->
                        <!--    <a class="blog-share-btn"-->
                        <!--       href="https://twitter.com/intent/tweet?text={{ urlencode($seo->meta_title) }}&url={{ urlencode(url()->current()) }}"-->
                        <!--       target="_blank" title="Twitter/X">-->
                        <!--        <i class="fa-brands fa-x-twitter" style="color:#000;"></i>-->
                        <!--    </a>-->
                        <!--</div>-->
                    </div>
                </div>
            </article>

            <!-- ===== SIDEBAR ===== -->
            <aside class="blog-sidebar">




                @if(isset($related) && $related->isNotEmpty())
                    <div class="sidebar-card">
                        <div class="sidebar-card-title">
                            <i class="fa-solid fa-fire"></i> Related Pages
                        </div>
                        @foreach($related as $item)
                            <a href="{{ url($item->url) }}" class="recent-post-item">
                                <div class="recent-post-img">
                                    @if($item->image)
                                        <img src="{{ env('MAIN_URL', '/') . $item->image }}"
                                            alt="{{ $item->alt_key ?? $item->meta_title }}" loading="lazy">
                                    @else
                                        �9�2
                                    @endif
                                </div>
                                <div class="recent-post-info">
                                    <div class="recent-post-title">{{ $item->meta_title }}</div>
                                    @if($item->name)
                                        <div class="recent-post-date">
                                            <i class="fa-solid fa-fire"></i>
                                            {{ $item->name }}
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Tags --}}
                @if($seo->meta_key)
                    <div class="sidebar-card">
                        <div class="sidebar-card-title">
                            <i class="fa-solid fa-tags"></i> Tags
                        </div>
                        @foreach(explode(',', $seo->meta_key) as $tag)
                            <span class="tag-chip"># {{ trim($tag) }}</span>
                        @endforeach
                    </div>
                @endif



            </aside>
        </div>
    </section>

    <script>
        // ���� Ember particles ����������������������������������������������������������
        (function () {
            const container = document.getElementById('singleBlogEmbers');
            const colors = ['#ffd700', '#ff6a00', '#ff2200', '#fffde0', '#ffcc00'];
            function spawnEmber() {
                const el = document.createElement('div');
                el.className = 'ember-particle';
                const size = 2 + Math.random() * 3;
                const x = Math.random() * 100;
                const dur = 5 + Math.random() * 7;
                const del = Math.random() * 4;
                const col = colors[Math.floor(Math.random() * colors.length)];
                el.style.cssText =
                    `left:${x}%;bottom:0;width:${size}px;height:${size}px;` +
                    `background:${col};box-shadow:0 0 5px ${col};` +
                    `animation-duration:${dur}s;animation-delay:${del}s;`;
                container.appendChild(el);
                setTimeout(() => el.remove(), (dur + del) * 1000 + 500);
            }
            setInterval(spawnEmber, 600);
        })();

        // ���� Reading progress bar ��������������������������������������������������
        (function () {
            const bar = document.getElementById('readProgress');
            window.addEventListener('scroll', () => {
                const total = document.body.scrollHeight - window.innerHeight;
                const current = window.scrollY;
                bar.style.width = (total > 0 ? (current / total) * 100 : 0) + '%';
            }, { passive: true });
        })();
    </script>

@endsection