@extends('layouts.default')

@section('main-page')
    <!-- Start Page Title -->
    {{-- <div class="page-title-area"  style=" min-height: 300px;
    background-image: url('/assets/img/ab.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;">
        <div class="container">
            <div class="page-title-content">
                <h2>About Us</h2>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li>About Us</li>
                </ul>
            </div>
        </div>
    </div> --}}

    <section class="hero">
    <div class="overlay"></div>

    <div class="hero-content">
        <h1 style="color: #fff">ABOUT US</h1>
        <p style="color: #fff">Home → About Us</p>
    </div>

    <!-- Right Curve Shape -->
    <div class="curve"></div>
</section>
<style>

.hero {
    position: relative;
    height: 400px;
    background: url('your-image.jpg') center/cover no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

/* Dark Blue Overlay */
.overlay {
    position: absolute;
    width: 100%;
    height: 100%;
   min-height: 300px;
    background-image: url('/assets/img/ab.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    top: 0;
    left: 0;
}

/* Text Content */
.hero-content {
    position: relative;
    text-align: center;
    color: #fff;
    z-index: 2;
}

.hero-content h1 {
    font-size: 48px;
    letter-spacing: 2px;
    margin-bottom: 10px;
}

.hero-content p {
    font-size: 18px;
    opacity: 0.9;
}

/* Right Side Curve */
/* .curve {
    position: absolute;
    right: -150px;
    bottom: -200px;
    width: 500px;
    height: 500px;
    background: #1f4ed8;
    border-radius: 50%;
    z-index: 1;
} */
</style>
    <!-- End Page Title -->

    <!-- Start About Area -->
    <section class="about-area ptb-100">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-12" data-aos="fade-right">
                    <div class="about-image">
                        <img src="assets/img/about/about.jpg" class="shadow" alt="image">
                    </div>
                </div>

                <div class="col-lg-6 col-md-12" data-aos="fade-left">
                    <div class="about-content">
                        {{-- <span class="sub-title">About Us</span> --}}
                        <h2>ABOUT THE CRACKERS</h2>
                        {{-- <h6>Xton.com offers you flexible and responsive shopping experience.</h6> --}}
                        <p>Located in the heart of Sivakasi, The Boys Crackers has been a symbol of festivity since 2016.
                            Renowned for providing top-notch fireworks that light up the sky with dazzling colors and joy,
                            we are the go-to choice for all celebrations. Our dedication to quality, affordability, variety,
                            timely delivery, and safety has established us as the preferred destination for your celebratory
                            needs. <br>

                            Our reputation as a reliable brand in the business has been solidified by our commitment to
                            quality, safety, and a large selection of pyrotechnics. Being the best option for celebrations,
                            we promise that your events will be truly remarkable. <br>

                            For a memorable celebration, be it a lavish festival, a happy occasion, or a little
                            get-together, The Boys Crackers has the best crackers . Your festivities are in brilliant and
                            safe hands thanks to our large assortment, affordable prices, and eco-friendly solutions.</p>

                        {{-- <div class="features-text">
                            <h5><i class='bx bx-planet'></i>Ships to more than 10 countries and regions</h5>
                            <p>We provide customers with a hassle-free and worry-free international shopping experience from
                                buying to delivery.</p>
                        </div> --}}
                    </div>
                </div>
            </div>

            {{-- <div class="about-inner-area">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="about-text">
                            <h3>Our Story</h3>
                            <p>One of the most popular on the web is shopping.</p>

                            <ul class="features-list">
                                <li><i class='bx bx-check'></i> People like Xton</li>
                                <li><i class='bx bx-check'></i> World's finest Xton</li>
                                <li><i class='bx bx-check'></i> The original Xton</li>
                                <li><i class='bx bx-check'></i> We trust Xton</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="about-text">
                            <h3>Our Values</h3>
                            <p>The best of both worlds. Store and web.</p>

                            <ul class="features-list">
                                <li><i class='bx bx-check'></i> Always in style!</li>
                                <li><i class='bx bx-check'></i> Discover your favorite shopping</li>
                                <li><i class='bx bx-check'></i> Find yourself</li>
                                <li><i class='bx bx-check'></i> Feel-good shopping</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6   ">
                        <div class="about-text">
                            <h3>Our Promise</h3>
                            <p>Rediscover a great shopping tradition</p>

                            <ul class="features-list">
                                <li><i class='bx bx-check'></i> Get better shopping</li>
                                <li><i class='bx bx-check'></i> Love shopping again</li>
                                <li><i class='bx bx-check'></i> Online shopping.</li>
                                <li><i class='bx bx-check'></i> Shopping for all seasons</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>

<style>
    .about-section {
  padding: 80px 0;
  background: #f5f5f5;
}


/* Image */
.about-image img {
  width: 100%;
  max-width: 550px;
  border-radius: 15px;
  box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

/* Content Box */
.about-content {
  flex: 1;
  background: #ffffff;
  padding: 40px;
  border-radius: 15px;
  box-shadow: 0 15px 40px rgba(0,0,0,0.08);
  transition: 0.3s ease;
}

.about-content:hover {
  transform: translateY(-8px);
}

.about-content h2 {
  font-size: 32px;
  margin-bottom: 20px;
  color: #222;
  font-weight: 700;
}

.about-content p {
  font-size: 16px;
  line-height: 1.8;
  color: #555;
  margin-bottom: 15px;
}

/* Button */
.read-more-btn {
  display: inline-block;
  padding: 12px 25px;
  background: #ff6600;
  color: #fff;
  text-decoration: none;
  border-radius: 30px;
  transition: 0.3s;
}

.read-more-btn:hover {
  background: #e05500;
}
</style>
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1200,
    once: true
  });
</script>
    <section class="counter-section">
    <div class="container">
        <div class="row">

            <!-- Product Count -->
            <div class="col-md-4">
                <div class="counter-card">
                    <div class="counter-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <h2 class="counter" data-target="250">0</h2>
                    <h5>Products</h5>
                </div>
            </div>

            <!-- Customer Count -->
            <div class="col-md-4">
                <div class="counter-card">
                    <div class="counter-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h2 class="counter" data-target="1200">0</h2>
                    <h5>Happy Customers</h5>
                </div>
            </div>

            <!-- Client Success -->
            <div class="col-md-4">
                <div class="counter-card">
                    <div class="counter-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h2 class="counter" data-target="100">0</h2>
                    <h5>Client Success %</h5>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
    .counter-section {
    padding: 80px 0;
    background: #f5f7fa;
}

.counter-card {
    background: #ffffff;
    padding: 40px 20px;
    border-radius: 15px;
    text-align: center;
    transition: 0.4s;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.counter-card:hover {
    background: #2563eb;
    color: #fff;
    transform: translateY(-10px);
}

.counter-icon {
    width: 80px;
    height: 80px;
    background: #2563eb;
    color: #fff;
    font-size: 30px;
    line-height: 80px;
    border-radius: 50%;
    margin: 0 auto 20px;
    transition: 0.4s;
}

.counter-card:hover .counter-icon {
    background: #fff;
    color: #2563eb;
}

.counter {
    font-size: 40px;
    font-weight: bold;
    margin-bottom: 10px;
}
</style>

<script>
const counters = document.querySelectorAll('.counter');
const speed = 200;

const startCounter = (counter) => {
    const updateCount = () => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText;

        const increment = target / speed;

        if (count < target) {
            counter.innerText = Math.ceil(count + increment);
            setTimeout(updateCount, 20);
        } else {
            counter.innerText = target;
            if(target == 100){
                counter.innerText = target + "%";
            }
        }
    };
    updateCount();
};

// Scroll Animation Trigger
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            startCounter(entry.target);
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

counters.forEach(counter => {
    observer.observe(counter);
});
</script>
    <!-- End About Area -->
    {{-- <div class="ns-feature-wrap pb-40 mb-4">
        <div class="container py-5">
            <div class="section-title">
                <h2>OUR PURPOSE AND DEDICATION</h2>
            </div>
            <div class="row justify-content-center my-5 ">
                <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6">
                    <div class="ns-feature-item mb-70">
                        <img class="ns-feature-item-img" src="assets/img/feature/feature-bg-1.jpg" alt="Not Found">

                        <h4 class="ns-feature-item-title">OUR PURPOSE</h4>
                        <p>To illuminate your happy and festive times while establishing new benchmarks for outstanding
                            Crackers experiences.</p>
                        <div class="ns-feature-item-icon"><i class="fa fa-user-check fa-1x whitClr"></i></div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6">
                    <div class="ns-feature-item mb-70">
                        <img class="ns-feature-item-img" src="assets/img/feature/feature-bg-2.jpg" alt="Not Found">
                        <h4 class="ns-feature-item-title">OUR DEDICATION</h4>
                        <p>Providing a wide variety of crackers, from eye-catching sparkles to spectacular flying shells, so
                            that every party is as colourful and distinctive as you are.</p>
                        <div class="ns-feature-item-icon"><i class="fa fa-check fa-1x whitClr"></i></div>
                    </div>
                </div>

            </div>
        </div>
    </div> --}}

    <style>
        .ns-feature-item::after {
            content: "";
            position: absolute;
            bottom: 38px;
            /* move line above bottom */
            left: 0;
            width: 100%;
            /* full width */
            height: 4px;
            /* background: #f4a100; */
            z-index: 1;
        }

        .ns-feature-item-icon {
            position: absolute;
            left: 50%;
            bottom: -40px;
            /* keep icon overlapping */
            transform: translateX(-50%);
            width: 85px;
            height: 85px;
            background: #1f1f1f;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 28px;
            border: 6px solid #f4f4f4;
            z-index: 2;
            /* above yellow line */
        }

        .ns-feature-wrap {
            background: #f4f4f4;
            padding-top: 80px;
        }

        .ns-feature-item {
            background: #e9e9eb;
            text-align: center;
            padding: 50px 25px 80px;
            border-radius: 10px;
            position: relative;
            overflow: visible;
            transition: 0.3s ease;
        }

        .ns-feature-item::after {
            content: "";
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 4px;
            background: #f4a100;
        }

        .ns-feature-item:hover {
            transform: translateY(-8px);
        }

        .ns-feature-item-img {
            display: none;
            /* Hide background image if not required */
        }

        .ns-feature-item-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #111;
        }

        .ns-feature-item p {
            font-size: 15px;
            color: #666;
            margin-bottom: 0;
        }

        .ns-feature-item-icon {
            position: absolute;
            left: 50%;
            bottom: -35px;
            transform: translateX(-50%);
            width: 80px;
            height: 80px;
            background: #1f1f1f;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 28px;
            border: 6px solid #f4f4f4;
            transition: 0.3s ease;
        }

        .ns-feature-item:hover .ns-feature-item-icon {
            /* background: #f4a100; */
        }

        /* Equal height */
        .ns-feature-item {
            height: 100%;
        }
    </style>


    <!-- Start Offer Area -->
    {{-- <section class="offer-area bg-image1 ptb-100 jarallax" data-jarallax='{"speed": 0.3}'>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <div class="offer-content">
                        <span class="sub-title">Limited Time Offer!</span>
                        <h2>-40% OFF</h2>
                        <p>Get The Best Deals Now</p>
                        <a href="#" class="default-btn">Discover Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- End Offer Area -->
    <section class="cta-one">
        <div class="cta-one__wrap">
            <div class="cta-one__bg" style="background-image: url(assets/images/backgrounds/cta-one-bg-img.png);">
            </div>
            <div class="container">
                <div class="cta-one__inner">
                    <div class="cta-one__left">
                        {{-- <div class="cta-one__icon">
                                <span class="icon-support"></span>
                            </div> --}}
                        <h3>Let’s Make a Difference in
                            <br> the Lives of Others
                        </h3>
                    </div>
                    <div class="cta-one__right">
                        <div class="cta-one__btn-box">
                            <a href="become-volunteer.html" class="cta-one__btn thm-btn">Estimate Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .cta-one {
            padding: 60px 0;
        }

        .cta-one__wrap {
            /* background: #e53935; */
            border-radius: 18px;
            position: relative;
            overflow: hidden;
        }

        .cta-one__bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0.15;
        }

        .cta-one__inner {
            border-radius: 25px 0px;
            background: #e53935;
            position: relative;
            z-index: 2;
            padding: 60px 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .cta-one__left {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .cta-one__icon {
            width: 110px;
            height: 110px;
            background: #f4b400;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 40px;
            color: #fff;
        }

        .cta-one__left h3 {
            color: #ffffff;
            font-size: 42px;
            font-weight: 700;
            line-height: 1.2;
            margin: 0;
        }

        .cta-one__btn {
            background: #2c2c2c;
            color: #ffffff;
            padding: 18px 40px;
            border-radius: 12px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
            transition: 0.3s ease;
        }

        .cta-one__btn:hover {
            background: #000;
            color: #fff;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .cta-one__inner {
                flex-direction: column;
                text-align: center;
                gap: 30px;
            }

            .cta-one__left {
                flex-direction: column;
            }

            .cta-one__left h3 {
                font-size: 30px;
            }
        }
    </style>


    <!-- Start Partner Area -->
    {{-- <div class="partner-area ptb-70">
        <div class="container">
            <div class="section-title">
                <h2>Our Partners</h2>
            </div>

            <div class="partner-slides owl-carousel owl-theme">
                <div class="partner-item">
                    <a href="index.html"><img src="assets/img/partner/partner1.png" alt="image"></a>
                </div>

                <div class="partner-item">
                    <a href="index.html"><img src="assets/img/partner/partner2.png" alt="image"></a>
                </div>

                <div class="partner-item">
                    <a href="index.html"><img src="assets/img/partner/partner3.png" alt="image"></a>
                </div>

                <div class="partner-item">
                    <a href="index.html"><img src="assets/img/partner/partner4.png" alt="image"></a>
                </div>

                <div class="partner-item">
                    <a href="index.html"><img src="assets/img/partner/partner5.png" alt="image"></a>
                </div>

                <div class="partner-item">
                    <a href="index.html"><img src="assets/img/partner/partner6.png" alt="image"></a>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Partner Area -->

    <!-- Start Testimonials Area -->
    {{-- <section class="testimonials-area ptb-100">
        <div class="container">
            <div class="section-title">
                <span class="sub-title">Testimonials</span>
                <h2>What Clients Says About Us</h2>
            </div>

            <div class="testimonials-slides owl-carousel owl-theme">
                <div class="single-testimonials-item">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book.</p>

                    <div class="info">
                        <img src="assets/img/user1.jpg" class="shadow rounded-circle" alt="image">
                        <h3>John Smith</h3>
                        <span>Student</span>
                    </div>
                </div>

                <div class="single-testimonials-item">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book.</p>

                    <div class="info">
                        <img src="assets/img/user2.jpg" class="shadow rounded-circle" alt="image">
                        <h3>Sarah Taylor</h3>
                        <span>Student</span>
                    </div>
                </div>

                <div class="single-testimonials-item">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book.</p>

                    <div class="info">
                        <img src="assets/img/user3.jpg" class="shadow rounded-circle" alt="image">
                        <h3>David Warner</h3>
                        <span>Student</span>
                    </div>
                </div>

                <div class="single-testimonials-item">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book.</p>

                    <div class="info">
                        <img src="assets/img/user4.jpg" class="shadow rounded-circle" alt="image">
                        <h3>James Anderson</h3>
                        <span>Student</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Testimonials Area -->

    <!-- Start Facility Area -->
    <section class="facility-area pb-70">
        <div class="container">
            <div class="facility-slides owl-carousel owl-theme">
                <div class="single-facility-box">
                    <div class="icon">
                        <i class='flaticon-tracking'></i>
                    </div>
                    <h3>Free Shipping Worldwide</h3>
                </div>

                <div class="single-facility-box">
                    <div class="icon">
                        <i class='flaticon-return'></i>
                    </div>
                    <h3>Easy Return Policy</h3>
                </div>

                <div class="single-facility-box">
                    <div class="icon">
                        <i class='flaticon-shuffle'></i>
                    </div>
                    <h3>7 Day Exchange Policy</h3>
                </div>

                <div class="single-facility-box">
                    <div class="icon">
                        <i class='flaticon-sale'></i>
                    </div>
                    <h3>Weekend Discount Coupon</h3>
                </div>

                <div class="single-facility-box">
                    <div class="icon">
                        <i class='flaticon-credit-card'></i>
                    </div>
                    <h3>Secure Payment Methods</h3>
                </div>

                <div class="single-facility-box">
                    <div class="icon">
                        <i class='flaticon-location'></i>
                    </div>
                    <h3>Track Your Package</h3>
                </div>

                <div class="single-facility-box">
                    <div class="icon">
                        <i class='flaticon-customer-service'></i>
                    </div>
                    <h3>24/7 Customer Support</h3>
                </div>
            </div>
        </div>
    </section>
    <!-- End Facility Area -->

    <!-- Start Instagram Area -->
    <div class="instagram-area">
        <div class="container-fluid">
            <div class="instagram-title">
                <a href="#" target="_blank"><i class='bx bxl-instagram'></i> Follow us on @xton</a>
            </div>

            <div class="instagram-slides owl-carousel owl-theme">
                <div class="single-instagram-post">
                    <img src="assets/img/instagram/img1.jpg" alt="image">
                    <i class='bx bxl-instagram'></i>
                    <a href="https://www.instagram.com/" target="_blank" class="link-btn"></a>
                </div>

                <div class="single-instagram-post">
                    <img src="assets/img/instagram/img2.jpg" alt="image">
                    <i class='bx bxl-instagram'></i>
                    <a href="https://www.instagram.com/" target="_blank" class="link-btn"></a>
                </div>

                <div class="single-instagram-post">
                    <img src="assets/img/instagram/img3.jpg" alt="image">
                    <i class='bx bxl-instagram'></i>
                    <a href="https://www.instagram.com/" target="_blank" class="link-btn"></a>
                </div>

                <div class="single-instagram-post">
                    <img src="assets/img/instagram/img4.jpg" alt="image">
                    <i class='bx bxl-instagram'></i>
                    <a href="https://www.instagram.com/" target="_blank" class="link-btn"></a>
                </div>

                <div class="single-instagram-post">
                    <img src="assets/img/instagram/img10.jpg" alt="image">
                    <i class='bx bxl-instagram'></i>
                    <a href="https://www.instagram.com/" target="_blank" class="link-btn"></a>
                </div>

                <div class="single-instagram-post">
                    <img src="assets/img/instagram/img6.jpg" alt="image">
                    <i class='bx bxl-instagram'></i>
                    <a href="https://www.instagram.com/" target="_blank" class="link-btn"></a>
                </div>

                <div class="single-instagram-post">
                    <img src="assets/img/instagram/img7.jpg" alt="image">
                    <i class='bx bxl-instagram'></i>
                    <a href="https://www.instagram.com/" target="_blank" class="link-btn"></a>
                </div>

                <div class="single-instagram-post">
                    <img src="assets/img/instagram/img8.jpg" alt="image">
                    <i class='bx bxl-instagram'></i>
                    <a href="https://www.instagram.com/" target="_blank" class="link-btn"></a>
                </div>

                <div class="single-instagram-post">
                    <img src="assets/img/instagram/img9.jpg" alt="image">
                    <i class='bx bxl-instagram'></i>
                    <a href="https://www.instagram.com/" target="_blank" class="link-btn"></a>
                </div>

                <div class="single-instagram-post">
                    <img src="assets/img/instagram/img5.jpg" alt="image">
                    <i class='bx bxl-instagram'></i>
                    <a href="https://www.instagram.com/" target="_blank" class="link-btn"></a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Instagram Area -->

    <!-- Start Sidebar Modal -->
    <div class="modal right fade sidebarModal" id="sidebarModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class='bx bx-x'></i></span>
                </button>

                <div class="modal-body">
                    <div class="sidebar-about-content">
                        <h3>About The Store</h3>

                        <div class="about-the-store">
                            <p>One of the most popular on the web is shopping. Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit.</p>

                            <ul class="sidebar-contact-info">
                                <li><i class='bx bx-map'></i> <a href="#" target="_blank">Wonder Street, USA, New
                                        York</a></li>
                                <li><i class='bx bx-phone-call'></i> <a href="tel:+01321654214">+01 321 654 214</a></li>
                                <li><i class='bx bx-envelope'></i> <a href="mailto:hello@xton.com">hello@xton.com</a></li>
                            </ul>
                        </div>

                        <ul class="social-link">
                            <li><a href="https://www.facebook.com/" class="d-block" target="_blank"><i
                                        class='bx bxl-facebook'></i></a></li>
                            <li><a href="https://twitter.com/login" class="d-block" target="_blank"><i
                                        class='bx bxl-twitter'></i></a></li>
                            <li><a href="https://www.instagram.com/" class="d-block" target="_blank"><i
                                        class='bx bxl-instagram'></i></a></li>
                            <li><a href="https://www.linkedin.com/login" class="d-block" target="_blank"><i
                                        class='bx bxl-linkedin'></i></a></li>
                            <li><a href="https://www.pinterest.com/" class="d-block" target="_blank"><i
                                        class='bx bxl-pinterest-alt'></i></a></li>
                        </ul>
                    </div>

                    <div class="sidebar-new-in-store">
                        <h3>New In Store</h3>

                        <ul class="products-list">
                            <li>
                                <a href="products-one-row-2.html"><img src="assets/img/products/img1.jpg"
                                        alt="image"></a>
                            </li>

                            <li>
                                <a href="products-one-row-2.html"><img src="assets/img/products/img2.jpg"
                                        alt="image"></a>
                            </li>

                            <li>
                                <a href="products-one-row-2.html"><img src="assets/img/products/img3.jpg"
                                        alt="image"></a>
                            </li>

                            <li>
                                <a href="products-one-row-2.html"><img src="assets/img/products/img4.jpg"
                                        alt="image"></a>
                            </li>
                        </ul>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua.</p>
                        <a href="products-left-sidebar-with-categories-3.html" class="shop-now-btn">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Sidebar Modal -->

    <!-- Start QuickView Modal Area -->
    <div class="modal fade productsQuickView" id="productsQuickView" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class='bx bx-x'></i></span>
                </button>

                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="products-image">
                            <img src="assets/img/quick-view-img.jpg" alt="image">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="products-content">
                            <h3><a href="#">Long Sleeve Leopard T-Shirt</a></h3>

                            <div class="price">
                                <span class="old-price">$210.00</span>
                                <span class="new-price">$200.00</span>
                            </div>

                            <div class="products-review">
                                <div class="rating">
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                </div>
                                <a href="#" class="rating-count">3 reviews</a>
                            </div>

                            <ul class="products-info">
                                <li><span>Vendor:</span> <a href="#">Lereve</a></li>
                                <li><span>Availability:</span> <a href="#">In stock (7 items)</a></li>
                                <li><span>Products Type:</span> <a href="#">T-Shirt</a></li>
                            </ul>

                            <div class="products-color-switch">
                                <h4>Color:</h4>

                                <ul>
                                    <li><a href="#" data-bs-toggle="tooltip" data-placement="top" title="Black"
                                            class="color-black"></a></li>
                                    <li><a href="#" data-bs-toggle="tooltip" data-placement="top" title="White"
                                            class="color-white"></a></li>
                                    <li><a href="#" data-bs-toggle="tooltip" data-placement="top" title="Green"
                                            class="color-green"></a></li>
                                    <li><a href="#" data-bs-toggle="tooltip" data-placement="top"
                                            title="Yellow Green" class="color-yellowgreen"></a></li>
                                    <li><a href="#" data-bs-toggle="tooltip" data-placement="top" title="Teal"
                                            class="color-teal"></a></li>
                                </ul>
                            </div>

                            <div class="products-size-wrapper">
                                <h4>Size:</h4>

                                <ul>
                                    <li><a href="#">XS</a></li>
                                    <li class="active"><a href="#">S</a></li>
                                    <li><a href="#">M</a></li>
                                    <li><a href="#">XL</a></li>
                                    <li><a href="#">XXL</a></li>
                                </ul>
                            </div>

                            <div class="products-add-to-cart">
                                <div class="input-counter">
                                    <span class="minus-btn"><i class='bx bx-minus'></i></span>
                                    <input type="text" value="1">
                                    <span class="plus-btn"><i class='bx bx-plus'></i></span>
                                </div>

                                <button type="submit" class="default-btn">Add to Cart</button>
                            </div>

                            <a href="#" class="view-full-info">View Full Info</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End QuickView Modal Area -->

    <!-- Start Shopping Cart Modal -->
    <div class="modal right fade shoppingCartModal" id="shoppingCartModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class='bx bx-x'></i></span>
                </button>

                <div class="modal-body">
                    <h3>My Cart (3)</h3>

                    <div class="products-cart-content">
                        <div class="products-cart">
                            <div class="products-image">
                                <a href="#"><img src="assets/img/products/img1.jpg" alt="image"></a>
                            </div>

                            <div class="products-content">
                                <h3><a href="#">Long Sleeve Leopard T-Shirt</a></h3>
                                <span>Blue / XS</span>
                                <div class="products-price">
                                    <span>1</span>
                                    <span>x</span>
                                    <span class="price">$250.00</span>
                                </div>
                                <a href="#" class="remove-btn"><i class='bx bx-trash'></i></a>
                            </div>
                        </div>

                        <div class="products-cart">
                            <div class="products-image">
                                <a href="#"><img src="assets/img/products/img2.jpg" alt="image"></a>
                            </div>

                            <div class="products-content">
                                <h3><a href="#">Causal V-Neck Soft Raglan</a></h3>
                                <span>Blue / XS</span>
                                <div class="products-price">
                                    <span>1</span>
                                    <span>x</span>
                                    <span class="price">$200.00</span>
                                </div>
                                <a href="#" class="remove-btn"><i class='bx bx-trash'></i></a>
                            </div>
                        </div>

                        <div class="products-cart">
                            <div class="products-image">
                                <a href="#"><img src="assets/img/products/img3.jpg" alt="image"></a>
                            </div>

                            <div class="products-content">
                                <h3><a href="#">Hanes Men's Pullover</a></h3>
                                <span>Blue / XS</span>
                                <div class="products-price">
                                    <span>1</span>
                                    <span>x</span>
                                    <span class="price">$200.00</span>
                                </div>
                                <a href="#" class="remove-btn"><i class='bx bx-trash'></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="products-cart-subtotal">
                        <span>Subtotal</span>

                        <span class="subtotal">$524.00</span>
                    </div>

                    <div class="products-cart-btn">
                        <a href="#" class="default-btn">Proceed to Checkout</a>
                        <a href="#" class="optional-btn">View Shopping Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Shopping Cart Modal -->

    <!-- Start Wishlist Modal -->
    <div class="modal right fade shoppingWishlistModal" id="shoppingWishlistModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class='bx bx-x'></i></span>
                </button>

                <div class="modal-body">
                    <h3>My Wish List (3)</h3>

                    <div class="products-cart-content">
                        <div class="products-cart">
                            <div class="products-image">
                                <a href="#"><img src="assets/img/products/img1.jpg" alt="image"></a>
                            </div>

                            <div class="products-content">
                                <h3><a href="#">Long Sleeve Leopard T-Shirt</a></h3>
                                <span>Blue / XS</span>
                                <div class="products-price">
                                    <span>1</span>
                                    <span>x</span>
                                    <span class="price">$250.00</span>
                                </div>
                                <a href="#" class="remove-btn"><i class='bx bx-trash'></i></a>
                            </div>
                        </div>

                        <div class="products-cart">
                            <div class="products-image">
                                <a href="#"><img src="assets/img/products/img2.jpg" alt="image"></a>
                            </div>

                            <div class="products-content">
                                <h3><a href="#">Causal V-Neck Soft Raglan</a></h3>
                                <span>Blue / XS</span>
                                <div class="products-price">
                                    <span>1</span>
                                    <span>x</span>
                                    <span class="price">$200.00</span>
                                </div>
                                <a href="#" class="remove-btn"><i class='bx bx-trash'></i></a>
                            </div>
                        </div>

                        <div class="products-cart">
                            <div class="products-image">
                                <a href="#"><img src="assets/img/products/img3.jpg" alt="image"></a>
                            </div>

                            <div class="products-content">
                                <h3><a href="#">Hanes Men's Pullover</a></h3>
                                <span>Blue / XS</span>
                                <div class="products-price">
                                    <span>1</span>
                                    <span>x</span>
                                    <span class="price">$200.00</span>
                                </div>
                                <a href="#" class="remove-btn"><i class='bx bx-trash'></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="products-cart-btn">
                        <a href="#" class="optional-btn">View Shopping Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Wishlist Modal -->

    <!-- Start Size Guide Modal Area -->
    <div class="modal fade sizeGuideModal" id="sizeGuideModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="bx bx-x"></i></span>
                </button>

                <div class="modal-sizeguide">
                    <h3>Size Guide</h3>
                    <p>This is an approximate conversion table to help you find your size.</p>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Italian</th>
                                    <th>Spanish</th>
                                    <th>German</th>
                                    <th>UK</th>
                                    <th>US</th>
                                    <th>Japanese</th>
                                    <th>Chinese</th>
                                    <th>Russian</th>
                                    <th>Korean</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>34</td>
                                    <td>30</td>
                                    <td>28</td>
                                    <td>4</td>
                                    <td>00</td>
                                    <td>3</td>
                                    <td>155/75A</td>
                                    <td>36</td>
                                    <td>44</td>
                                </tr>
                                <tr>
                                    <td>36</td>
                                    <td>32</td>
                                    <td>30</td>
                                    <td>6</td>
                                    <td>0</td>
                                    <td>5</td>
                                    <td>155/80A</td>
                                    <td>38</td>
                                    <td>44</td>
                                </tr>
                                <tr>
                                    <td>38</td>
                                    <td>34</td>
                                    <td>32</td>
                                    <td>8</td>
                                    <td>2</td>
                                    <td>7</td>
                                    <td>160/84A</td>
                                    <td>40</td>
                                    <td>55</td>
                                </tr>
                                <tr>
                                    <td>40</td>
                                    <td>36</td>
                                    <td>34</td>
                                    <td>10</td>
                                    <td>4</td>
                                    <td>9</td>
                                    <td>165/88A</td>
                                    <td>42</td>
                                    <td>55</td>
                                </tr>
                                <tr>
                                    <td>42</td>
                                    <td>38</td>
                                    <td>36</td>
                                    <td>12</td>
                                    <td>6</td>
                                    <td>11</td>
                                    <td>170/92A</td>
                                    <td>44</td>
                                    <td>66</td>
                                </tr>
                                <tr>
                                    <td>44</td>
                                    <td>40</td>
                                    <td>38</td>
                                    <td>14</td>
                                    <td>8</td>
                                    <td>13</td>
                                    <td>175/96A</td>
                                    <td>46</td>
                                    <td>66</td>
                                </tr>
                                <tr>
                                    <td>46</td>
                                    <td>42</td>
                                    <td>40</td>
                                    <td>16</td>
                                    <td>10</td>
                                    <td>15</td>
                                    <td>170/98A</td>
                                    <td>48</td>
                                    <td>77</td>
                                </tr>
                                <tr>
                                    <td>48</td>
                                    <td>44</td>
                                    <td>42</td>
                                    <td>18</td>
                                    <td>12</td>
                                    <td>17</td>
                                    <td>170/100B</td>
                                    <td>50</td>
                                    <td>77</td>
                                </tr>
                                <tr>
                                    <td>50</td>
                                    <td>46</td>
                                    <td>44</td>
                                    <td>20</td>
                                    <td>14</td>
                                    <td>19</td>
                                    <td>175/100B</td>
                                    <td>52</td>
                                    <td>88</td>
                                </tr>
                                <tr>
                                    <td>52</td>
                                    <td>48</td>
                                    <td>46</td>
                                    <td>22</td>
                                    <td>16</td>
                                    <td>21</td>
                                    <td>180/104B</td>
                                    <td>54</td>
                                    <td>88</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Size Guide Modal Area -->

    <!-- Start Shipping Modal Area -->
    <div class="modal fade productsShippingModal" id="productsShippingModal" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class='bx bx-x'></i></span>
                </button>

                <div class="shipping-content">
                    <h3>Shipping</h3>
                    <ul>
                        <li>Complimentary ground shipping within 1 to 7 business days</li>
                        <li>In-store collection available within 1 to 7 business days</li>
                        <li>Next-day and Express delivery options also available</li>
                        <li>Purchases are delivered in an orange box tied with a Bolduc ribbon, with the exception of
                            certain items</li>
                        <li>See the delivery FAQs for details on shipping methods, costs and delivery times</li>
                    </ul>

                    <h3>Returns and Exchanges</h3>
                    <ul>
                        <li>Easy and complimentary, within 14 days</li>
                        <li>See conditions and procedure in our return FAQs</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Shipping Modal Area -->

    <!-- Start Products Filter Modal Area -->
    <div class="modal left fade productsFilterModal" id="productsFilterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class='bx bx-x'></i> Close</span>
                </button>

                <div class="modal-body">
                    <div class="woocommerce-widget-area">
                        <div class="woocommerce-widget filter-list-widget">
                            <h3 class="woocommerce-widget-title">Current Selection</h3>

                            <div class="selected-filters-wrap-list">
                                <ul>
                                    <li><a href="#"><i class='bx bx-x'></i> 44</a></li>
                                    <li><a href="#"><i class='bx bx-x'></i> XI</a></li>
                                    <li><a href="#"><i class='bx bx-x'></i> Clothing</a></li>
                                    <li><a href="#"><i class='bx bx-x'></i> Shoes</a></li>
                                </ul>

                                <a href="#" class="delete-selected-filters"><i class='bx bx-trash'></i> <span>Clear
                                        All</span></a>
                            </div>
                        </div>

                        <div class="woocommerce-widget collections-list-widget">
                            <h3 class="woocommerce-widget-title">Collections</h3>

                            <ul class="collections-list-row">
                                <li><a href="#">Men's</a></li>
                                <li class="active"><a href="#" class="active">Women’s</a></li>
                                <li><a href="#">Clothing</a></li>
                                <li><a href="#">Shoes</a></li>
                                <li><a href="#">Accessories</a></li>
                                <li><a href="#">Uncategorized</a></li>
                            </ul>
                        </div>

                        <div class="woocommerce-widget price-list-widget">
                            <h3 class="woocommerce-widget-title">Price</h3>

                            <div class="collection-filter-by-price">
                                <input class="js-range-of-price" type="text" data-min="0" data-max="1055"
                                    name="filter_by_price" data-step="10">
                            </div>
                        </div>

                        <div class="woocommerce-widget size-list-widget">
                            <h3 class="woocommerce-widget-title">Size</h3>

                            <ul class="size-list-row">
                                <li><a href="#">20</a></li>
                                <li><a href="#">24</a></li>
                                <li class="active"><a href="#">36</a></li>
                                <li><a href="#">30</a></li>
                                <li><a href="#">XS</a></li>
                                <li><a href="#">S</a></li>
                                <li><a href="#">M</a></li>
                                <li><a href="#">L</a></li>
                                <li><a href="#">L</a></li>
                                <li><a href="#">XL</a></li>
                            </ul>
                        </div>

                        <div class="woocommerce-widget color-list-widget">
                            <h3 class="woocommerce-widget-title">Color</h3>

                            <ul class="color-list-row">
                                <li class="active"><a href="#" title="Black" class="color-black"></a></li>
                                <li><a href="#" title="Red" class="color-red"></a></li>
                                <li><a href="#" title="Yellow" class="color-yellow"></a></li>
                                <li><a href="#" title="White" class="color-white"></a></li>
                                <li><a href="#" title="Blue" class="color-blue"></a></li>
                                <li><a href="#" title="Green" class="color-green"></a></li>
                                <li><a href="#" title="Yellow Green" class="color-yellowgreen"></a></li>
                                <li><a href="#" title="Pink" class="color-pink"></a></li>
                                <li><a href="#" title="Violet" class="color-violet"></a></li>
                                <li><a href="#" title="Blue Violet" class="color-blueviolet"></a></li>
                                <li><a href="#" title="Lime" class="color-lime"></a></li>
                                <li><a href="#" title="Plum" class="color-plum"></a></li>
                                <li><a href="#" title="Teal" class="color-teal"></a></li>
                            </ul>
                        </div>

                        <div class="woocommerce-widget brands-list-widget">
                            <h3 class="woocommerce-widget-title">Brands</h3>

                            <ul class="brands-list-row">
                                <li><a href="#">Gucci</a></li>
                                <li><a href="#">Virgil Abloh</a></li>
                                <li><a href="#">Balenciaga</a></li>
                                <li class="active"><a href="#">Moncler</a></li>
                                <li><a href="#">Fendi</a></li>
                                <li><a href="#">Versace</a></li>
                            </ul>
                        </div>

                        <div class="woocommerce-widget aside-trending-widget">
                            <div class="aside-trending-products">
                                <img src="assets/img/offer-bg.jpg" alt="image">

                                <div class="category">
                                    <h3>Top Trending</h3>
                                    <span>Spring/Summer 2024 Collection</span>
                                </div>
                                <a href="products-right-sidebar.html" class="link-btn"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Products Filter Modal Area --> --}}
@endsection
