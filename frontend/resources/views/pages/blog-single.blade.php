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
        @if($blog->image)
            <div class="single-blog-hero-bg" style="background-image:url('{{ env('MAIN_URL', '/') . $blog->image }}');"></div>
        @else
            <div class="single-blog-hero-bg"
                style="background: radial-gradient(ellipse at center, #2e0800 0%, #0a0000 100%);filter:none;"></div>
        @endif

        <div class="single-blog-hero-content">
            <!-- Breadcrumb pill -->
            <div class="single-blog-breadcrumb">
                <a href="/"><i class="fa-solid fa-house"></i> Home</a>
                <i class="fa-solid fa-chevron-right" style="font-size:9px;opacity:0.5;"></i>
                <a href="{{ route('blog.index') }}">Blog</a>
                <i class="fa-solid fa-chevron-right" style="font-size:9px;opacity:0.5;"></i>
                <span style="color:rgba(255,220,160,0.7);">{{ Str::limit($blog->title, 35) }}</span>
            </div>

            <div class="single-blog-eyebrow">�9�Bluvelel Crackers �� Article</div>

            <h1>{{ $blog->title }}</h1>

            <div class="single-blog-meta">
                @if($blog->created_at)
                    <span><i class="fa-solid fa-calendar-days"></i> {{ $blog->created_at->format('d M, Y') }}</span>
                @endif
                @if($blog->meta_key)
                    <span><i class="fa-solid fa-tag"></i> {{ Str::limit($blog->meta_key, 30) }}</span>
                @endif
                <span><i class="fa-solid fa-clock"></i>
                    {{ max(1, ceil(str_word_count(strip_tags($blog->feet_content ?? '')) / 200)) }} min read
                </span>
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
                @if($blog->image)
                    <div class="blog-main-img-wrap">
                        <img class="blog-main-featured-img" src="{{ env('MAIN_URL', '/') . $blog->image }}"
                            alt="{{ $blog->title }}">
                        <div class="blog-main-img-overlay"></div>
                    </div>
                @endif

                {{-- Meta info strip --}}
                <div class="blog-article-meta-strip">
                    @if($blog->created_at)
                        <span class="blog-meta-chip">
                            <i class="fa-solid fa-calendar"></i>
                            {{ $blog->created_at->format('d M Y') }}
                        </span>
                        <div class="blog-meta-dot"></div>
                    @endif
                    @if($blog->meta_key)
                        <span class="blog-meta-chip">
                            <i class="fa-solid fa-tag"></i>
                            {{ $blog->meta_key }}
                        </span>
                        <div class="blog-meta-dot"></div>
                    @endif
                    <span class="blog-meta-chip">
                        <i class="fa-solid fa-clock"></i>
                        {{ max(1, ceil(str_word_count(strip_tags($blog->feet_content ?? '')) / 200)) }} min read
                    </span>
                </div>

                {{-- Article body --}}
                <div class="blog-main-body">

                    <h2 class="blog-content-title">{{ $blog->title }}</h2>

                    <div class="blog-content-under-title">
                        <div class="blog-content-fire-bar"></div>
                        <div class="blog-content-fire-label">Bluvel Crackers</div>
                    </div>

                    {{-- Rich text content from dashboard --}}
                    <div class="blog-content-body">
                        {!! $blog->feet_content !!}
                    </div>

                    {{-- Footer: back button + share --}}
                    <div class="blog-article-footer">
                        <a href="{{ route('blog.index') }}" class="blog-back-btn">
                            <i class="fa-solid fa-arrow-left"></i> All Articles
                        </a>
                        <!--<div class="blog-share-row">-->
                        <!--    <span class="blog-share-label">Share</span>-->
                        <!--    <a class="blog-share-btn"-->
                        <!--       href="https://wa.me/?text={{ urlencode($blog->title . ' ' . url()->current()) }}"-->
                        <!--       target="_blank" title="WhatsApp">-->
                        <!--        <i class="fa-brands fa-whatsapp" style="color:#25d366;"></i>-->
                        <!--    </a>-->
                        <!--    <a class="blog-share-btn"-->
                        <!--       href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"-->
                        <!--       target="_blank" title="Facebook">-->
                        <!--        <i class="fa-brands fa-facebook-f" style="color:#1877f2;"></i>-->
                        <!--    </a>-->
                        <!--    <a class="blog-share-btn"-->
                        <!--       href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(url()->current()) }}"-->
                        <!--       target="_blank" title="Twitter/X">-->
                        <!--        <i class="fa-brands fa-x-twitter" style="color:#000;"></i>-->
                        <!--    </a>-->
                        <!--</div>-->
                    </div>
                </div>
            </article>

            <!-- ===== SIDEBAR ===== -->
            <aside class="blog-sidebar">

                {{-- Order CTA --}}
                <div class="sidebar-cta-card">
                    <span class="sidebar-cta-icon">�9�3</span>
                    <div class="sidebar-cta-title">Order Crackers!</div>
                    <p class="sidebar-cta-text">
                        Celebrate with India's finest Sivakasi crackers.<br>
                        Get your price estimate in seconds.
                    </p>
                    <a href="/estimate" class="sidebar-cta-btn">
                        <i class="fa-solid fa-calculator"></i>&nbsp;&nbsp;Get Free Estimate
                    </a>
                </div>

                {{-- Recent Posts --}}
                @if($recent->isNotEmpty())
                    <div class="sidebar-card">
                        <div class="sidebar-card-title">
                            <i class="fa-solid fa-fire"></i> Recent Posts
                        </div>
                        @foreach($recent as $post)
                            <a href="{{ route('blog.show', $post->url) }}" class="recent-post-item">
                                <div class="recent-post-img">
                                    @if($post->image)
                                        <img src="{{ env('MAIN_URL', '/') . $post->image }}" alt="{{ $post->title }}" loading="lazy">
                                    @else
                                        �9�2
                                    @endif
                                </div>
                                <div class="recent-post-info">
                                    <div class="recent-post-title">{{ $post->title }}</div>
                                    @if($post->created_at)
                                        <div class="recent-post-date">
                                            <i class="fa-regular fa-calendar"></i>
                                            {{ $post->created_at->format('d M Y') }}
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Tags --}}
                @if($blog->meta_key)
                    <div class="sidebar-card">
                        <div class="sidebar-card-title">
                            <i class="fa-solid fa-tags"></i> Tags
                        </div>
                        @foreach(explode(',', $blog->meta_key) as $tag)
                            <span class="tag-chip"># {{ trim($tag) }}</span>
                        @endforeach
                    </div>
                @endif

                {{-- Contact card --}}
                <div class="sidebar-card" style="text-align:center;">
                    <div class="sidebar-card-title" style="justify-content:center;">
                        <i class="fa-solid fa-headset"></i> Need Help?
                    </div>
                    <p
                        style="font-size:13px;color:rgba(255,200,140,0.6);font-family:'Rajdhani',sans-serif;margin-bottom:16px;line-height:1.6;">
                        Have questions about our crackers or need a bulk order quote?
                    </p>
                    <a href="/contact" style="
                            display:block;padding:11px 18px;
                            background:rgba(255,100,0,0.12);
                            border:1px solid rgba(255,100,0,0.3);
                            border-radius:10px;color:var(--fire-orange);
                            font-weight:700;font-size:12px;
                            letter-spacing:2px;text-transform:uppercase;
                            text-decoration:none;font-family:'Rajdhani',sans-serif;
                            transition:all 0.3s;">
                        <i class="fa-solid fa-envelope"></i>&nbsp; Contact Us
                    </a>
                </div>

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