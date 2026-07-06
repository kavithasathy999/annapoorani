@extends('layouts.default')

@section('main-page')
<style>
/* CSS scoped entirely to .safety-page-wrapper to prevent affecting other pages */
.safety-page-wrapper {
    background: #fdfdfd;
    font-family: 'Poppins', sans-serif;
    color: #333;
}

/* ==================================
   Hero Section
   ================================== */
.safety-hero {
    position: relative;
    padding: 100px 20px;
    text-align: center;
    background: url('{{ asset('assets/img/contact-premium.png') }}') center/cover no-repeat;
    overflow: hidden;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.safety-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.85); /* Light glass overlay for readability */
    z-index: 0;
}
.safety-hero-inner {
    position: relative;
    z-index: 1;
    max-width: 1000px;
    margin: 0 auto;
}

.safety-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 8px 18px;
    background: transparent;
    border: 1px solid rgba(12, 104, 155, 0.3);
    color: #0c689b; /* Highlight Blue */
    border-radius: 30px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 24px;
}
.safety-badge i {
    font-size: 12px;
}

.safety-title {
    font-size: 52px;
    font-weight: 800;
    color: #043048; /* Dark Navy */
    margin: 0 0 20px 0;
    line-height: 1.2;
}
.safety-title span {
    color: #0c689b;
}

.safety-title-underline {
    width: 60px;
    height: 3px;
    background: #0c689b;
    margin: 0 auto 30px;
    border-radius: 3px;
}

.safety-desc {
    font-size: 16px;
    color: #000000;
    line-height: 1.7;
    max-width: 600px;
    margin: 0 auto;
}


/* ==================================
   Do's and Don'ts Section
   ================================== */
.safety-dos-donts {
    padding: 50px 20px 70px;
    background: #fcfcfc;
}
.safety-dos-donts-inner {
    max-width: 1400px;
    margin: 0 auto;
}
.sd-header {
    text-align: center;
    margin-bottom: 30px;
}
.sd-title {
    font-size: 34px;
    font-weight: 800;
    color: #0c689b;
    margin: 15px 0 20px;
}

/* Grid Layout */
.sd-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

/* Cards */
.sd-card {
    background: #fff;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.03);
    position: relative;
}
.sd-card.dos {
    border-top: 4px solid #10b981;
}
.sd-card.donts {
    border-top: 4px solid #ef4444;
}

.sd-card-title {
    font-size: 26px;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 35px;
}
.sd-card.dos .sd-card-title {
    color: #10b981;
}
.sd-card.donts .sd-card-title {
    color: #ef4444;
}
.sd-card-title i {
    font-size: 22px;
}

/* List Items */
.sd-list {
    display: flex;
    flex-direction: column;
    gap: 25px;
}
.sd-item {
    display: flex;
    gap: 18px;
    align-items: flex-start;
}
.sd-icon {
    flex-shrink: 0;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    margin-top: 2px;
}
.dos .sd-icon {
    background: #d1fae5;
    color: #10b981;
}
.donts .sd-icon {
    background: #fee2e2;
    color: #ef4444;
}
.sd-text h4 {
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 6px 0;
}
.sd-text p {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
    line-height: 1.6;
}

/* ==================================
   Responsive Breakpoints
   ================================== */
@media screen and (max-width: 992px) {
    .safety-title {
        font-size: 42px;
    }
    .sd-card {
        padding: 30px;
    }
    .safety-dos-donts {
        padding: 40px 20px 60px;
    }
    .sd-header {
        margin-bottom: 25px;
    }
}

@media screen and (max-width: 768px) {
    .sd-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    .safety-title {
        font-size: 36px;
    }
    .safety-desc {
        font-size: 15px;
    }
    .sd-title {
        font-size: 28px;
    }
}

@media screen and (max-width: 480px) {
    .safety-hero {
        padding: 60px 15px;
    }
    .safety-title {
        font-size: 30px;
    }
    .sd-title {
        font-size: 24px;
    }
    .sd-card {
        padding: 25px 20px;
    }
    .sd-text h4 {
        font-size: 15px;
    }
    .sd-text p {
        font-size: 13px;
    }
    .safety-dos-donts {
        padding: 30px 15px 40px;
    }
    .sd-header {
        margin-bottom: 20px;
    }
}

@media screen and (min-width: 992px) {
    .safety-hero-inner {
        transform: translateY(-40px);
    }
}
</style>

<div class="safety-page-wrapper">
    
    <!-- Hero Section -->
    <section class="safety-hero">
        <div class="safety-hero-inner">
            <div class="safety-badge">
                <i class="fa-solid fa-shield-halved"></i> FIREWORKS SAFETY
            </div>
            <h1 class="safety-title">Stay <span>Safe</span> This Diwali</h1>
            <div class="safety-title-underline"></div>
            <p class="safety-desc">Essential do's and don'ts for purchasing, bursting, and storing crackers safely. A little negligence can cause fatal injuries.</p>
        </div>
    </section>

    <!-- Do's and Don'ts Section -->
    <section class="safety-dos-donts">
        <div class="safety-dos-donts-inner">
            
            <div class="sd-header">
                <div class="safety-badge">
                    ESSENTIAL SAFETY GUIDELINES
                </div>
                <h2 class="sd-title">Do's & Don'ts for Safe Fireworks</h2>
                <div class="safety-title-underline"></div>
            </div>

            <div class="sd-grid">
                <!-- Do's Card -->
                <div class="sd-card dos">
                    <div class="sd-card-title">
                        <i class="fa-solid fa-circle-check"></i> Do's
                    </div>
                    <div class="sd-list">
                        <div class="sd-item">
                            <div class="sd-icon"><i class="fa-solid fa-check"></i></div>
                            <div class="sd-text">
                                <h4>Instructions</h4>
                                <p>Display fireworks as per the instructions mentioned on the pack.</p>
                            </div>
                        </div>
                        <div class="sd-item">
                            <div class="sd-icon"><i class="fa-solid fa-check"></i></div>
                            <div class="sd-text">
                                <h4>Outdoor</h4>
                                <p>Use fireworks only outdoor.</p>
                            </div>
                        </div>
                        <div class="sd-item">
                            <div class="sd-icon"><i class="fa-solid fa-check"></i></div>
                            <div class="sd-text">
                                <h4>Branded Fireworks</h4>
                                <p>Buy fireworks from authorized / reputed manufacturers only.</p>
                            </div>
                        </div>
                        <div class="sd-item">
                            <div class="sd-icon"><i class="fa-solid fa-check"></i></div>
                            <div class="sd-text">
                                <h4>Distance</h4>
                                <p>Light only one firework at a time, by one person. Others should watch from a safe distance.</p>
                            </div>
                        </div>
                        <div class="sd-item">
                            <div class="sd-icon"><i class="fa-solid fa-check"></i></div>
                            <div class="sd-text">
                                <h4>Water</h4>
                                <p>Keep two buckets of water handy. In the event of fire or any mishap.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Don'ts Card -->
                <div class="sd-card donts">
                    <div class="sd-card-title">
                        <i class="fa-solid fa-circle-xmark"></i> Don'ts
                    </div>
                    <div class="sd-list">
                        <div class="sd-item">
                            <div class="sd-icon"><i class="fa-solid fa-xmark"></i></div>
                            <div class="sd-text">
                                <h4>Don't make tricks</h4>
                                <p>Never make your own fireworks.</p>
                            </div>
                        </div>
                        <div class="sd-item">
                            <div class="sd-icon"><i class="fa-solid fa-xmark"></i></div>
                            <div class="sd-text">
                                <h4>Don't relight</h4>
                                <p>Never try to re-light or pick up fireworks that have not ignited fully.</p>
                            </div>
                        </div>
                        <div class="sd-item">
                            <div class="sd-icon"><i class="fa-solid fa-xmark"></i></div>
                            <div class="sd-text">
                                <h4>Don't carry it</h4>
                                <p>Never carry fireworks in your pockets.</p>
                            </div>
                        </div>
                        <div class="sd-item">
                            <div class="sd-icon"><i class="fa-solid fa-xmark"></i></div>
                            <div class="sd-text">
                                <h4>Don't Touch it</h4>
                                <p>After fireworks display never pick up fireworks that may be left over, they still may be active.</p>
                            </div>
                        </div>
                        <div class="sd-item">
                            <div class="sd-icon"><i class="fa-solid fa-xmark"></i></div>
                            <div class="sd-text">
                                <h4>Don't wear loose clothes</h4>
                                <p>Do not wear loose clothing while using fireworks.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /.sd-grid -->
            
        </div>
    </section>

</div>
@endsection
