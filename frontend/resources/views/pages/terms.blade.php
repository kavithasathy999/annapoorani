@extends('layouts.default')

@section('main-page')



    <div class="terms-hero">
        <p>Official Guidelines</p>
        <h1>Terms & Conditions</h1>
    </div>

    <div class="terms-wrapper">
        <div id="sparkContainer"></div>

        <div class="terms-card">
            <div class="terms-content-body">
                @if($terms && $terms->content)
                    {!! $terms->content !!}
                @else
                    <h2>Acceptance of Terms</h2>
                    <p>Welcome to <strong>Bluvel Crackers</strong>. By using this website, you agree to follow all safety
                        protocols and legal conditions listed here.</p>

                    <h2>Order Policy</h2>
                    <p>Orders are subject to seasonal availability. We ensure the highest quality Sivakasi crackers are
                        delivered to your doorstep.</p>

                    <h2>Safety First</h2>
                    <p>Always use crackers in open spaces and follow the instructions on the package. Safety is our primary
                        concern.</p>
                @endif
            </div>
        </div>

        <div class="terms-action">
            <a href="/" class="btn-premium">
                <i class="fa-solid fa-house"></i> Return to Homepage
            </a>
        </div>
    </div>

    <script>
        (function () {
            const container = document.getElementById('sparkContainer');
            function createSpark() {
                const spark = document.createElement('div');
                spark.className = 'spark';
                spark.style.left = Math.random() * 100 + '%';
                spark.style.top = (80 + Math.random() * 20) + '%';
                spark.style.animationDelay = Math.random() * 5 + 's';
                container.appendChild(spark);
                setTimeout(() => spark.remove(), 6000);
            }
            setInterval(createSpark, 400);
        })();
    </script>

@endsection