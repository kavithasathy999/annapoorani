@extends('layouts.default')

@section('main-page')



    <!-- ===== HERO ===== -->
    <!-- <div class="blog-hero">

            <div class="blog-hero-spark" style="width:100px;height:100px;background:radial-gradient(circle,#ff6a00,transparent);top:10%;left:5%;animation-delay:0s;"></div>
            <div class="blog-hero-spark" style="width:70px;height:70px;background:radial-gradient(circle,#ffd700,transparent);top:20%;right:8%;animation-delay:2s;"></div>
            <div class="blog-hero-spark" style="width:50px;height:50px;background:radial-gradient(circle,#ff2200,transparent);bottom:20%;left:35%;animation-delay:4s;"></div>

            <div class="blog-hero-content">
                <div class="blog-hero-eyebrow">🎇 Bluvel · Sivakasi</div>
                <h1>Our Blog</h1>
                <div class="blog-hero-breadcrumb">
                    <a href="/">Home</a> &nbsp;/&nbsp; Blog
                </div>
            </div>

            <div class="blog-hero-fire-edge"></div>
        </div> -->

    <!-- ===== EMBER PARTICLES ===== -->
    <div id="blogEmbers"></div>

    <!-- ===== BLOG LISTING ===== -->
    <section class="blog-section">
        <div class="blog-inner">

            <div class="blog-section-header">
                <div class="blog-eyebrow">Latest Articles</div>
                <h2 class="blog-section-title">Cracker Tips & News</h2>
                <span class="blog-title-bar"></span>
            </div>

            @if($blogs->isEmpty())
                <div class="blog-empty">
                    <i class="fa-regular fa-newspaper"></i>
                    <p>No blog posts published yet. Check back soon!</p>
                </div>
            @else
                <div class="blog-grid">
                    @foreach($blogs as $blog)
                        <div class="blog-card">
                            <!-- Image -->
                            <div class="blog-card-img-wrap">
                                @if($blog->image)
                                    <img src="{{ env('MAIN_URL', '/') . $blog->image }}" alt="{{ $blog->title }}" loading="lazy">
                                @else
                                    <div class="blog-card-no-img">🎆</div>
                                @endif
                                <div class="blog-card-overlay"></div>
                                <div class="blog-card-date-badge">
                                    {{ $blog->created_at ? $blog->created_at->format('d M Y') : '' }}
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="blog-card-body">
                                <div class="blog-card-title">{{ $blog->title }}</div>
                                <div class="blog-card-excerpt">
                                    {{ $blog->meta_des ? strip_tags($blog->meta_des) : strip_tags(Str::limit($blog->feet_content ?? '', 130)) }}
                                </div>
                                <div class="blog-card-footer">
                                    <a href="{{ route('blog.show', $blog->url) }}" class="blog-card-read-more">
                                        Read More <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

    <script>
        // Ember particles
        (function () {
            const container = document.getElementById('blogEmbers');
            const colors = ['#ffd700', '#ff6a00', '#ff2200', '#fffde0', '#ffcc00'];
            function spawnEmber() {
                const el = document.createElement('div');
                el.className = 'ember-particle';
                const size = 2 + Math.random() * 3;
                const x = Math.random() * 100;
                const dur = 5 + Math.random() * 6;
                const del = Math.random() * 4;
                const col = colors[Math.floor(Math.random() * colors.length)];
                el.style.cssText = `
                    left:${x}%; bottom:0;
                    width:${size}px; height:${size}px;
                    background:${col}; box-shadow:0 0 5px ${col};
                    animation-duration:${dur}s; animation-delay:${del}s;
                `;
                container.appendChild(el);
                setTimeout(() => el.remove(), (dur + del) * 1000 + 500);
            }
            setInterval(spawnEmber, 600);
        })();
    </script>

@endsection