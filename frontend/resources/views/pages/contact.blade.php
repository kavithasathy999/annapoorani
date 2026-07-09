@extends('layouts.default')

@section('main-page')

<div class="main-page-wrap">
    <!-- ========================
             PREMIUM HERO BANNER
             ======================== -->
    <section class="premium-hero">
        <div class="hero-parallax-bg"
            style="background-image: url('{{ $contact->banner_image ? env('MAIN_URL', '/') . $contact->banner_image : asset('assets/img/contact-premium.png') }}');">
        </div>
        <div class="hero-glass-overlay"></div>
        <div class="hero-content-wrap">
            <div class="container">
                <div class="hero-text-center">
                    <span class="hero-eyebrow"><i class="fa-solid fa-headset"></i> {{ $contact->hero_eyebrow ?? '24/7 Concierge' }}</span>
                    <h1 class="hero-display-title">{!! $contact->hero_title ?? 'Connect with<span> Excellence</span>' !!}</h1>
                    <div class="hero-sep"></div>
                    <p class="hero-subtitle">Looking for wholesale or bulk orders? Connect with our team to get exclusive pricing and tailored packages for your grand celebrations and corporate events.</p>
                </div>
            </div>
        </div>

        <div class="scroll-prompt">
            <div class="scroll-mouse">
                <span class="scroll-dot"></span>
            </div>
        </div>
    </section>

    <!-- ========================
             CONTACT INTERFACE
             ======================== -->
    <section class="contact-interface">
        <div class="container">
            <div class="row g-5">

                <!-- Information Column -->
                <div class="col-lg-5">
                    <div class="contact-info-wrap">
                        <span class="c-eyebrow">Direct Contact</span>
                        <!-- <h2 class="c-title">{{ $contact->heading ?? 'How can we help?<em></em>' }}</h2> -->
                         <h2 class="c-title">Any Inquiry?</h2>
                        <div class="c-bar"></div>
                        <p class="c-desc">
                            {{ strip_tags($contact->subheading ?? 'Our representatives at Sivakasi are ready to handle your celebration needs with precision and care.') }}
                        </p>

                        <div class="info-grid">
                            <!-- Address -->
                            <div class="info-block">
                                <div class="ib-icon"><i class="fa-solid fa-location-dot"></i></div>
                                <div class="ib-content">
                                    <h6>Mailing Address</h6>
                                    <p>{{ $contact->address ?? 'No. 12, Main Bazaar, Sivakasi – 626123' }}</p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="info-block">
                                <div class="ib-icon"><i class="fa-solid fa-phone-volume"></i></div>
                                <div class="ib-content">
                                    <h6>Speak to an Artisan</h6>
                                    <p>
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contact->phone ?? '') }}">{{ $contact->phone ?? '+91 90259 78152' }}</a>
                                        @if($contact->phone_2)
                                        <span class="mx-2">|</span>
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contact->phone_2) }}">{{ $contact->phone_2 }}</a>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="info-block">
                                <div class="ib-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
                                <div class="ib-content">
                                    <h6>Digital Inquiry</h6>
                                    <p><a href="mailto:{{ $contact->email ?? '' }}">{{ $contact->email ??
                                                'care@SriShyamcrackers.com' }}</a></p>
                                </div>
                            </div>

                            <!-- WhatsApp Highlight -->
                            <div class="info-block wa-highlight">
                                <div class="ib-icon"><i class="fa-brands fa-whatsapp"></i></div>
                                <div class="ib-content">
                                    <h6>WhatsApp Concierge</h6>
                                    <p><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone ?? '') }}"
                                            target="_blank">Chat with us instantly</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Column -->
                <div class="col-lg-7">
                    <div class="contact-form-glass">
                        <div class="form-header">
                            <h3>Send a Message</h3>
                            <p>Fill out the form below and we'll respond within 24 hours.</p>
                        </div>

                        @if(session('success'))
                        <div class="alert-premium-success" id="ajaxSuccessMsg">
                            <i class="fa-solid fa-circle-check"></i>
                            <span id="ajaxSuccessText">{{ session('success') }}</span>
                        </div>
                        @else
                        <div class="alert-premium-success" id="ajaxSuccessMsg" style="display: none;">
                            <i class="fa-solid fa-circle-check"></i>
                            <span id="ajaxSuccessText"></span>
                        </div>
                        @endif

                        <form action="{{ url('/contact') }}" method="POST" class="luxury-form" id="contactForm">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="input-group-f">
                                        <label>Full Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe"
                                            pattern="[A-Za-z ]+" title="Only alphabets and spaces are allowed" 
                                            oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group-f">
                                        <label>Phone Number</label>
                                        <input type="text" name="phone" id="phoneInput" value="{{ old('phone') }}"
                                            pattern="[0-9]{10}" title="Enter a valid 10-digit mobile number" 
                                            required placeholder="9876543210" maxlength="15">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group-f">
                                        <label>Email Address</label>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            title="Please enter a valid email address (e.g. name@domain.com)"
                                            placeholder="john@example.com" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group-f">
                                        <label>Your Message (Max 50 words)</label>
                                        <textarea name="message" id="contactMessage" rows="5"
                                            placeholder="Tell us about your celebration needs..."
                                            required>{{ old('message') }}</textarea>
                                        <small id="wordCountError" style="color: #ff4d4d; display: none; margin-top: 5px;">You have reached the 50 words limit.</small>
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="cta-btn-gold">
                                        <span>Submit Message</span>
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <script>
                            document.getElementById('contactForm').addEventListener('submit', function(e) {
                                e.preventDefault();
                                const msgField = document.getElementById('contactMessage');
                                const errorText = document.getElementById('wordCountError');
                                const successMsg = document.getElementById('ajaxSuccessMsg');
                                
                                if (successMsg) successMsg.style.display = 'none';

                                const words = msgField.value.trim().split(/\s+/).filter(word => word.length > 0);
                                
                                if (words.length > 50) {
                                    errorText.style.display = 'block';
                                    return;
                                }
                                errorText.style.display = 'none';
                                
                                // Change button state to Submitting
                                const submitBtn = this.querySelector('button[type="submit"]');
                                const btnText = submitBtn.querySelector('span');
                                const icon = submitBtn.querySelector('i');
                                
                                const originalText = btnText.textContent;
                                const originalIconClass = icon ? icon.className : '';
                                
                                submitBtn.disabled = true;
                                submitBtn.style.opacity = '0.8';
                                submitBtn.style.cursor = 'wait';
                                btnText.textContent = 'Redirecting...';
                                if (icon) icon.className = 'fa-solid fa-spinner fa-spin';
                                
                                // PREVENT POPUP BLOCKER: Open blank tab immediately on submit click
                                const waTab = window.open('about:blank', '_blank');
                                
                                const formData = new FormData(this);
                                
                                fetch(this.action, {
                                    method: 'POST',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'Accept': 'application/json'
                                    },
                                    body: formData
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw response;
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        // Construct WhatsApp URL
                                        const adminNum = data.admin_whatsapp || '6380195167';
                                        const waMsg = `New Contact Enquiry:\n\nName: ${formData.get('name')}\nEmail: ${formData.get('email')}\nPhone: ${formData.get('phone')}\nMessage: ${formData.get('message')}`;
                                        const waUrl = `https://wa.me/${adminNum}?text=${encodeURIComponent(waMsg)}`;
                                        
                                        // Redirect the blank tab to WhatsApp
                                        if (waTab) {
                                            waTab.location.href = waUrl;
                                        } else {
                                            // Fallback if browser entirely blocked the blank tab
                                            window.open(waUrl, '_blank') || (window.location.href = waUrl);
                                        }
                                        
                                        // Reset form and show success
                                        this.reset();
                                        if (successMsg) {
                                            document.getElementById('ajaxSuccessText').innerText = data.message || "Thank you for your message!";
                                            successMsg.style.display = 'flex';
                                        }
                                    } else {
                                        if (waTab) waTab.close();
                                        alert("There was an error submitting your form.");
                                    }
                                })
                                .catch(async err => {
                                    console.error(err);
                                    if (waTab) waTab.close();
                                    let errorMsg = "There was an error communicating with the server.";
                                    if(err.status === 422) {
                                        const errData = await err.json();
                                        errorMsg = Object.values(errData.errors).flat().join('\n');
                                    }
                                    alert(errorMsg);
                                })
                                .finally(() => {
                                    // Reset button state
                                    submitBtn.disabled = false;
                                    submitBtn.style.opacity = '1';
                                    submitBtn.style.cursor = 'pointer';
                                    btnText.textContent = originalText;
                                    if (icon) icon.className = originalIconClass;
                                });
                            });
                            
                            document.getElementById('contactMessage').addEventListener('input', function() {
                                let text = this.value;
                                let words = text.trim().split(/\s+/).filter(word => word.length > 0);
                                const errorText = document.getElementById('wordCountError');
                                
                                if (words.length > 50) {
                                    // Limit the textarea to the first 50 words
                                    let match = text.match(/^(\s*\S+){50}/);
                                    if (match) {
                                        this.value = match[0];
                                    }
                                    errorText.style.display = 'block';
                                } else {
                                    errorText.style.display = 'none';
                                }
                            });
                            
                            const phoneInput = document.getElementById('phoneInput');
                            if (phoneInput) {
                                // Handle pasting
                                phoneInput.addEventListener('paste', function(e) {
                                    e.preventDefault();
                                    let pastedText = (e.clipboardData || window.clipboardData).getData('text');
                                    let digits = pastedText.replace(/\D/g, '');
                                    if (digits.startsWith('91') && digits.length > 10) {
                                        digits = digits.substring(2);
                                    }
                                    this.value = digits.substring(0, 10);
                                });

                                // Handle input/typing
                                phoneInput.addEventListener('input', function(e) {
                                    let digits = this.value.replace(/\D/g, '');
                                    if (digits.startsWith('91') && digits.length > 10) {
                                        digits = digits.substring(2);
                                    }
                                    this.value = digits.substring(0, 10);
                                });
                                
                                // Prevent typing more than 10 digits
                                phoneInput.addEventListener('keydown', function(e) {
                                    // Allow control keys like Backspace, Delete, Tab, Arrows
                                    const allowedKeys = ['Backspace', 'Delete', 'Tab', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'];
                                    if (allowedKeys.includes(e.key) || e.ctrlKey || e.metaKey) return;
                                    
                                    // If length is already 10, prevent further typing
                                    if (this.value.length >= 10 && !document.getSelection().toString()) {
                                        e.preventDefault();
                                    }
                                });
                            }
                        </script>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================
             HOW TO ORDER (PREMIUM DARK)
             ======================== -->
    <!--<section class="process-section">-->
    <!--    <div class="section-pattern-overlay"></div>-->
    <!--    <div class="container">-->
    <!--        <div class="section-header text-center mb-5">-->
    <!--            <span class="c-eyebrow">Seamless Experience</span>-->
    <!--            <h2 class="c-title">How to <span>Order</span></h2>-->
    <!--            <div class="c-bar mx-auto"></div>-->
    <!--        </div>-->

    <!--        <div class="row g-4 justify-content-center">-->
                <!-- Step 1 -->
    <!--            <div class="col-lg-3 col-md-6">-->
    <!--                <div class="step-item-glass">-->
    <!--                    <div class="step-num">01</div>-->
    <!--                    <h5>{{ $contact->step1_title ?? 'Select Varieties' }}</h5>-->
    <!--                    <p>{{ $contact->step1_text ?? 'Explore our premium collection and add your favorites to the cart.' }}</p>-->
    <!--                </div>-->
    <!--            </div>-->
                <!-- Step 2 -->
    <!--            <div class="col-lg-3 col-md-6">-->
    <!--                <div class="step-item-glass">-->
    <!--                    <div class="step-num">02</div>-->
    <!--                    <h5>{{ $contact->step2_title ?? 'Secure Estimate' }}</h5>-->
    <!--                    <p>{{ $contact->step2_text ?? 'Review your selection and generate a detailed price estimate.' }}</p>-->
    <!--                </div>-->
    <!--            </div>-->
                <!-- Step 3 -->
    <!--            <div class="col-lg-3 col-md-6">-->
    <!--                <div class="step-item-glass">-->
    <!--                    <div class="step-num">03</div>-->
    <!--                    <h5>{{ $contact->step3_title ?? 'Verify & Pay' }}</h5>-->
    <!--                    <p>{{ $contact->step3_text ?? 'Our concierge will verify stock and guide you through payment.' }}</p>-->
    <!--                </div>-->
    <!--            </div>-->
                <!-- Step 4 -->
    <!--            <div class="col-lg-3 col-md-6">-->
    <!--                <div class="step-item-glass">-->
    <!--                    <div class="step-num">04</div>-->
    <!--                    <h5>{{ $contact->step4_title ?? 'Swift Delivery' }}</h5>-->
    <!--                    <p>{{ $contact->step4_text ?? 'Receive your spectacular fireworks safely at your doorstep.' }}</p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->

    <!-- ========================
             PREMIUM GEOLOCATION
             ======================== -->
    <section class="premium-map-area">
        <div class="container">
            <div class="map-card wow fadeInUp" data-wow-delay="0.2s">
                <div class="map-embed">
                    <iframe src="https://maps.google.com/maps?q=Sri%20Annapoorani%20Crackers,%20Sivakasi&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                
                <div class="map-footer">
                    <div class="map-footer-text">
                        <h5>Visit Our Store</h5>
                        <p>Sri Annapoorani Crackers, Sivakasi</p>
                    </div>
                    <div class="map-action-buttons">
                        <a href="https://maps.app.goo.gl/V7wLBKZ8RJBgG4kM8?g_st=ac" target="_blank" class="map-btn map-btn-primary">
                            <i class="fa-solid fa-map-location-dot"></i> Open in Maps
                        </a>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=Sri+Annapoorani+Crackers,+Sivakasi" target="_blank" class="map-btn map-btn-outline">
                            <i class="fa-solid fa-route"></i> Get Directions
                        </a>
                    </div>
                </div>

                {{-- <div class="map-pin-badge">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Our Sivakasi Headquarters</span>
                    </div> --}}
            </div>
        </div>
    </section>

    <style>
        :root {
            /* Core Palette */
            --gold: #D4860A;
            --gold-deep: #B86E00;
            --gold-light: #F0A832;
            --gold-pale: rgba(212, 134, 10, 0.1);
            --saffron: #E87B2D;

            /* Neutrals - DARK TRANSFORMATION */
            --bg: #080810;
            /* Deep Midnight */
            --surface-1: #0c0c18;
            /* Dark Indigo */
            --surface-2: #121224;
            --surface-3: #1a1a30;
            --border: rgba(255, 255, 255, 0.08);
            --border-gold: rgba(212, 134, 10, 0.3);
            --ink: #FFFFFF;
            --muted: #A0A0A0;
            --subtle: #888888;
            --radius-lg: 32px;
            --radius-md: 20px;
            --radius-sm: 8px;
            --shadow-premium: 0 20px 60px rgba(0, 0, 0, 0.8);
            --font-display: 'Outfit', sans-serif;
        }

        .main-page-wrap {
            position: relative;
            z-index: 1;
            isolation: isolate;
            width: 100%;
            overflow-x: hidden;
            background:
                radial-gradient(circle at 50% 8%, rgba(212, 134, 10, 0.14), transparent 34rem),
                linear-gradient(180deg, #090910 0%, #080810 100%);
        }

        .main-page-wrap>section {
            position: relative;
            z-index: 2;
        }

        .premium-hero .container,
        .contact-interface .container,
        .process-section .container,
        .premium-map-area .container {
            position: relative;
            z-index: 4;
        }

        /* PREMIUM HERO Section */
        .premium-hero {
            height: 85vh;
            min-height: 620px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: var(--bg);
        }

        .hero-parallax-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: 0.3s transform;
            transform: scale(1.1);
        }

        .hero-glass-overlay {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 50% 46%, rgba(240, 168, 50, 0.16), transparent 16rem),
                linear-gradient(to bottom, rgba(8, 8, 16, 0.72), rgba(8, 8, 16, 0.96));
            backdrop-filter: blur(2px);
        }

        .hero-content-wrap {
            position: relative;
            z-index: 10;
            text-align: center;
        }

        .hero-eyebrow {
            color: var(--gold-deep);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 4px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: block;
        }

        .hero-display-title {
            font-family: var(--font-display);
            font-size: clamp(3.2rem, 8vw, 5.5rem);
            line-height: 1.1;
            color: var(--ink) !important;
            margin-bottom: 20px;
            font-weight: 900;
            position: relative;
            z-index: 2;
        }

        .hero-display-title span {
            background: linear-gradient(135deg, var(--gold-deep), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-family: var(--font-accent);
            filter: drop-shadow(0 0 16px rgba(255, 174, 0, 0.3));
        }

        .hero-subtitle {
            color: rgba(255, 255, 255, 0.82);
            max-width: 650px;
            margin: 0 auto;
            font-size: 1.08rem;
            line-height: 1.6;
            font-weight: 400;
            position: relative;
            z-index: 2;
        }

        .hero-sep {
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--gold-light), var(--gold));
            margin: 30px auto;
            border-radius: 2px;
            box-shadow: 0 0 10px rgba(240, 168, 50, 0.5);
        }

        /* Contact Interface */
        .contact-interface {
            padding: 70px 0;
            background: var(--cream);
            position: relative;
            overflow: hidden;
            color: var(--ink);
        }

        /* Ambient top-right golden aurora */
        .contact-interface::before {
            content: '';
            position: absolute;
            top: -250px;
            right: -250px;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(212, 134, 10, .18) 0%, rgba(232, 123, 45, .06) 45%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            animation: auroraFloat 8s ease-in-out infinite alternate;
            z-index: 1;
        }

        /* Ambient bottom-left counterpoint */
        .contact-interface::after {
            content: '';
            position: absolute;
            bottom: -180px;
            left: -180px;
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, rgba(100, 120, 255, .08) 0%, transparent 65%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
        }

        @keyframes auroraFloat {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(30px, 20px) scale(1.08);
            }
        }

        .contact-info-wrap {
            position: relative;
            z-index: 2;
        }

        /* Halo effect from home page */
        .contact-info-wrap::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            filter: blur(50px);
            z-index: -1;
            pointer-events: none;
        }

        .c-eyebrow {
            display: inline-block;
            padding: 7px 20px;
            margin-bottom: 20px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.25), rgba(255, 255, 255, 0.05));
            border: 1.5px solid rgba(255, 255, 255, 0.6);
            border-radius: 50px;
            color: #FFFFFF !important;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            box-shadow:
                0 0 20px rgba(255, 255, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        .c-title {
            font-family: var(--font-display);
            font-size: 4rem;
            line-height: 1.15;
            margin-bottom: 25px;
            color: #FFFFFF !important;
            font-weight: 900;
            text-shadow:
                0 2px 10px rgba(255, 255, 255, 0.3),
                0 0 40px rgba(255, 255, 255, 0.2),
                0 0 80px rgba(255, 255, 255, 0.1);
            letter-spacing: -1px;
        }

        .c-bar {
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--gold-light), var(--gold));
            margin-bottom: 30px;
            border-radius: 2px;
            box-shadow: 0 0 10px rgba(240, 168, 50, 0.5);
        }

        .c-desc {
            color: rgba(255, 255, 255, 0.72);
            line-height: 1.8;
            font-size: 1.1rem;
            margin-bottom: 50px;
        }

        .info-grid {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .info-block {
            display: flex;
            gap: 24px;
            align-items: center;
            padding: 26px 30px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0.04) 100%);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-radius: 22px;
            border: 2px solid rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow:
                0 12px 48px rgba(255, 255, 255, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.3),
                0 0 60px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
        }

        .info-block:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(255, 255, 255, 0.8);
            box-shadow:
                0 28px 72px rgba(255, 255, 255, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.6),
                0 0 80px rgba(255, 255, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.7);
        }

        .info-block::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 60px;
            height: 60px;
            background: radial-gradient(circle at 0% 0%, rgba(255, 255, 255, .3) 0%, transparent 70%);
            border-radius: inherit;
            opacity: 1;
            transition: opacity .3s;
        }

        .info-block:hover {
            transform: translateY(-7px);
            border-color: rgba(255, 255, 255, .8);
            box-shadow:
                0 20px 52px rgba(255, 255, 255, .2),
                0 0 0 1px rgba(255, 255, 255, .5),
                0 0 40px rgba(255, 255, 255, .15),
                inset 0 1px 0 rgba(255, 255, 255, .6);
        }

        .ib-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #FFFFFF, #F0A832);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #111;
            border: 2px solid rgba(255, 255, 255, 0.6);
            transition: all .4s cubic-bezier(.23, 1, .32, 1);
            box-shadow:
                0 0 0 4px rgba(255, 255, 255, .2),
                0 8px 24px rgba(255, 255, 255, .15);
        }

        .ib-content h6 {
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 6px;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        .ib-content p,
        .ib-content a {
            color: rgba(255, 255, 255, 0.74);
            text-decoration: none;
            font-size: 1.05rem;
            transition: .3s;
        }

        .ib-content a:hover {
            color: var(--gold-deep);
        }

        .info-block:hover .ib-icon {
            transform: scale(1.1) translateY(-5px) rotate(5deg);
            box-shadow:
                0 0 0 6px rgba(255, 255, 255, .4),
                0 0 0 12px rgba(255, 255, 255, .15),
                0 8px 32px rgba(255, 255, 255, .3),
                0 0 60px rgba(255, 255, 255, .2);
            animation: badgePulse 3s ease-in-out infinite;
        }

        @keyframes badgePulse {

            0%,
            100% {
                box-shadow: 0 0 0 6px rgba(255, 255, 255, .4), 0 0 0 12px rgba(255, 255, 255, .15), 0 8px 32px rgba(255, 255, 255, .3), 0 0 60px rgba(255, 255, 255, .2);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(255, 255, 255, .6), 0 0 0 20px rgba(255, 255, 255, .2), 0 12px 40px rgba(255, 255, 255, .4), 0 0 80px rgba(255, 255, 255, .3);
            }
        }

        .wa-highlight .ib-icon {
            background: rgba(37, 211, 102, 0.15);
            color: #25D366;
            border: 1px solid rgba(37, 211, 102, 0.3);
        }

        .wa-highlight .ib-content a {
            color: #25D366;
            font-weight: 700;
            border-bottom: 1px solid rgba(37, 211, 102, 0.2);
        }

        .wa-highlight:hover .ib-icon {
            background: #25D366;
            color: #0b0b14;
            box-shadow: 0 10px 20px rgba(37, 211, 102, 0.3);
        }

        /* Form Glass */
        .contact-form-glass {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03));
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            padding: 60px;
            border-radius: 40px;
            border: 2px solid rgba(255, 255, 255, 0.6);
            box-shadow:
                0 40px 100px rgba(0, 0, 0, 0.6),
                0 0 0 1px rgba(255, 255, 255, 0.3),
                0 0 80px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
            position: relative;
            z-index: 2;
            overflow: hidden;
        }

        .contact-form-glass::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 1.5px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.4), transparent, rgba(240, 168, 50, 0.3));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-header h3 {
            font-family: var(--font-display);
            font-size: 2.2rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: 12px;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.4);
            letter-spacing: -1px;
        }

        .form-header p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.1rem;
        }

        .input-group-f {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 5px;
        }

        .input-group-f label {
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 2px;
            padding-left: 5px;
        }

        .input-group-f input,
        .input-group-f textarea {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #FFFFFF !important;
            padding: 18px 24px;
            border-radius: 15px;
            font-weight: 500;
            transition: all .4s cubic-bezier(0.23, 1, 0.32, 1);
            font-size: 1rem;
        }

        .input-group-f input::placeholder,
        .input-group-f textarea::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        .input-group-f input:focus,
        .input-group-f textarea:focus {
            outline: none;
            border-color: rgba(240, 168, 50, 0.6);
            background: rgba(255, 255, 255, 0.08);
            box-shadow:
                0 0 0 4px rgba(240, 168, 50, 0.1),
                0 10px 30px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        .alert-premium-success {
            background: rgba(46, 125, 50, 0.15);
            color: #81c784;
            padding: 22px;
            border-radius: 20px;
            border: 1px solid rgba(76, 175, 80, 0.3);
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 40px;
            backdrop-filter: blur(10px);
        }

        .cta-btn-gold {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            background: linear-gradient(135deg, #FFFFFF 0%, #F0A832 50%, #D4860A 100%);
            background-size: 200% 100%;
            color: #111;
            font-weight: 900;
            font-size: 1.05rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 22px 55px;
            border-radius: 60px;
            border: none;
            box-shadow:
                0 10px 40px rgba(240, 168, 50, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
            transition: all .5s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            width: fit-content;
        }

        .cta-btn-gold::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
            transition: 0.6s ease-in-out;
            transform: skewX(-25deg);
        }

        .cta-btn-gold:hover {
            background-position: 100% 0;
            transform: translateY(-5px) scale(1.02);
            box-shadow:
                0 20px 50px rgba(240, 168, 50, 0.4),
                0 0 0 8px rgba(240, 168, 50, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
            color: #000;
        }

        .cta-btn-gold:hover::before {
            left: 150%;
        }

        .cta-btn-gold i {
            font-size: 1.1rem;
            transition: transform .3s ease;
        }

        .cta-btn-gold:hover i {
            transform: translateX(5px) rotate(-10deg);
        }

        /* Map Section (Professional Redesign) */
        .premium-map-area {
            padding: 80px 0;
            background: #080810;
        }

        .map-card {
            background: #121224;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .map-embed iframe {
            width: 100%;
            height: 450px;
            display: block;
            border: none;
            /* Professional maps usually don't have heavy grayscale filters, letting the natural UI shine */
            filter: none; 
        }

        .map-footer {
            padding: 25px 35px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            background: linear-gradient(180deg, #16162c, #0f0f1d);
        }

        .map-footer-text h5 {
            color: #ffffff;
            margin: 0 0 5px;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .map-footer-text p {
            color: rgba(255, 255, 255, 0.6);
            margin: 0;
            font-size: 0.95rem;
        }

        .map-action-buttons {
            display: flex;
            gap: 15px;
        }

        .map-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .map-btn-primary {
            background: var(--gold-deep);
            color: #fff;
            border: none;
            box-shadow: 0 5px 15px rgba(212, 134, 10, 0.3);
        }

        .map-btn-primary:hover {
            background: var(--gold-light);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(240, 168, 50, 0.4);
        }

        .map-btn-outline {
            background: transparent;
            color: var(--gold-light);
            border: 1.5px solid var(--gold-light);
        }

        .map-btn-outline:hover {
            background: rgba(212, 134, 10, 0.1);
            color: var(--gold-light);
            border-color: var(--gold-light);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .map-footer {
                flex-direction: column;
                align-items: flex-start;
            }
            .map-action-buttons {
                width: 100%;
                flex-direction: column;
            }
            .map-btn {
                justify-content: center;
                width: 100%;
            }
        }

        .map-pin-badge {
            position: absolute;
            top: 30px;
            left: 30px;
            z-index: 10;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            padding: 12px 25px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-gold);
        }

        .map-pin-badge i {
            color: var(--gold-light);
            font-size: 1.2rem;
            filter: drop-shadow(0 0 5px rgba(240, 168, 50, 0.5));
        }

        .map-pin-badge span {
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: var(--ink);
            letter-spacing: 1px;
        }

        /* Process Section (How to Order) */
        .process-section {
            padding: 70px 0;
            background: linear-gradient(180deg, rgba(10, 10, 20, 0.95), rgba(15, 15, 30, 0.98));
            position: relative;
            overflow: hidden;
        }

        .section-pattern-overlay {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(240, 168, 50, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.4;
            pointer-events: none;
        }

        .step-item-glass {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02));
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            padding: 50px 40px;
            border-radius: 35px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            height: 100%;
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
            text-align: center;
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.4),
                inset 0 1px 1px rgba(255, 255, 255, 0.1);
        }

        .step-item-glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at top right, rgba(240, 168, 50, 0.15), transparent 60%);
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .step-item-glass:hover {
            transform: translateY(-15px) scale(1.02);
            border-color: rgba(240, 168, 50, 0.5);
            box-shadow:
                0 40px 80px rgba(0, 0, 0, 0.7),
                0 0 0 1px rgba(240, 168, 50, 0.2),
                inset 0 1px 1px rgba(255, 255, 255, 0.2);
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03));
        }

        .step-item-glass:hover::before {
            opacity: 1;
        }

        .step-num {
            font-family: var(--font-display);
            font-size: 4.5rem;
            font-weight: 900;
            color: transparent;
            -webkit-text-stroke: 1px rgba(240, 168, 50, 0.3);
            line-height: 1;
            margin-bottom: 25px;
            position: relative;
            display: inline-block;
            transition: all 0.5s ease;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.5));
        }

        .step-item-glass:hover .step-num {
            -webkit-text-stroke: 1px rgba(240, 168, 50, 0.8);
            transform: scale(1.1);
            text-shadow: 0 0 30px rgba(240, 168, 50, 0.3);
        }

        .step-item-glass h5 {
            color: #FFFFFF;
            font-weight: 800;
            font-size: 1.4rem;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }

        .step-item-glass p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.05rem;
            line-height: 1.6;
            margin-bottom: 0;
        }

        /* Responsive Overrides */
        @media (max-width: 991px) {

            .contact-interface,
            .process-section {
                padding: 80px 0;
            }

            .hero-display-title {
                font-size: 3rem;
            }

            .contact-form-glass {
                padding: 40px 25px;
            }
        }

        @media (max-width: 768px) {
            .premium-map-area {
                padding-bottom: 60px;
            }

            .map-frame-wrap {
                border-radius: 20px;
                background: #11111d;
                border: 1px solid rgba(240, 168, 50, 0.22);
            }

            .map-pin-badge {
                top: 20px;
                left: 20px;
                padding: 8px 15px;
            }

            .step-item-glass {
                padding: 40px 25px;
            }
        }

        /* SCROLL PROMPT */
        .scroll-prompt {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            cursor: pointer;
        }

        .scroll-mouse {
            width: 26px;
            height: 42px;
            border: 2px solid var(--border);
            border-radius: 20px;
            position: relative;
        }

        .scroll-dot {
            width: 4px;
            height: 4px;
            background: var(--gold-light);
            border-radius: 50%;
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            animation: scrollWheel 2s infinite;
        }

        @keyframes scrollWheel {
            0% {
                opacity: 1;
                top: 8px;
            }

            100% {
                opacity: 0;
                top: 24px;
            }
        }

        /* GROUND LAYER */
        .ground-layer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 120px;
            pointer-events: none;
            z-index: 3;
        }

        .About-footer {
            position: relative;
            z-index: 10;
        }

        .chakkar {
            position: absolute;
            bottom: 20px;
            width: 36px;
            height: 36px;
        }

        .chakkar-inner {
            width: 100%;
            height: 100%;
            border: 3px solid var(--gold-light);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.3s linear infinite;
            box-shadow: 0 0 20px rgba(240, 168, 50, 0.5);
        }

        .flowerpot-wrap {
            position: absolute;
            bottom: 0;
        }

        .flowerpot-body {
            width: 24px;
            height: 30px;
            background: linear-gradient(to bottom, #5c2d0a, #2a1505);
            clip-path: polygon(15% 0%, 85% 0%, 100% 100%, 0% 100%);
        }

        .roman-wrap {
            position: absolute;
            bottom: 0;
        }

        .roman-tube {
            width: 12px;
            height: 50px;
            background: linear-gradient(to right, #444, #666, #444);
            border-radius: 2px;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @media screen and (width: 768px) and (height: 1024px) {

        .f-grid {
            grid-template-columns: 1fr 1fr !important;
        }
        }
        @media screen and (width: 820px) and (height: 1180px) {

        .f-grid {
            grid-template-columns: 1fr 1fr !important;
        }
        }
        @media screen and (width: 540px) and (height: 720px) {

        .f-grid {
            grid-template-columns: 1fr 1fr !important;
        }
        }

    /* Light theme overrides for Contact page */
    .main-page-wrap,
    .premium-hero,
    .hero-gradient,
    .hero-info,
    .contact-interface,
    .info-block,
    .form-wrap,
    .map-section,
    .process-section,
    .step-item-glass,
    .map-wrap,
    .premium-map-area {
        background: #fff !important;
        color: var(--text) !important;
        border-color: rgba(0,0,0,0.08) !important;
        box-shadow: 0 18px 40px rgba(0,0,0,0.08) !important;
    }

    .main-page-wrap {
        background: #f7f7f4 !important;
    }

    .hero-gradient {
        background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(250,250,250,0.96)) !important;
    }

    .hero-display-title,
    .hero-subtitle,
    .c-title,
    .c-desc,
    .f-title,
    .form-header h3,
    .process-section .step-title,
    .input-group-f label {
        color: #111 !important;
    }

    .c-title span,
    .c-eyebrow {
        color: #e53a12 !important;
    }

    .c-eyebrow {
        background: rgba(229, 234, 238, 0.65) !important;
        border-color: rgba(229, 234, 238, 0.9) !important;
    }

    .form-header,
    .contact-interface {
        background: #fcfcfc !important;
    }

    .input-group-f input,
    .input-group-f textarea,
    .input-group-f select,
    .input-group-f .nice-select {
        background: #fff !important;
        color: #111 !important;
        border-color: rgba(0,0,0,0.12) !important;
    }

    .btn-gold {
        background: linear-gradient(135deg, var(--gold-light), var(--gold)) !important;
        color: #080810 !important;
    }

    .step-item-glass {
        background: rgba(255,255,255,0.92) !important;
        border-color: rgba(0,0,0,0.08) !important;
    }
        
    </style>


    @push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        let current = 0;

        function goToSlide(n) {
            if (!slides.length) return;
            slides[current].classList.remove('active');
            if (dots[current]) dots[current].classList.remove('active');
            current = (n + slides.length) % slides.length;
            slides[current].classList.add('active');
            if (dots[current]) dots[current].classList.add('active');
        }

        if (slides.length > 1) {
            slides[current].classList.add('active');
            if (dots[current]) dots[current].classList.add('active');
            setInterval(() => goToSlide(current + 1), 5000);
        }

        document.querySelectorAll('.faq-question, .faq-toggle').forEach(btn => {
            btn.addEventListener('click', function () {
                const item = btn.closest('.faq-item');
                if (!item) return;
                document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
                item.classList.toggle('open');
            });
        });
    });
</script>
@endpush


</div>
@endsection