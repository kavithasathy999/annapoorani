@extends('layouts.default')

@section('main-page')



<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2>{{ $contact->page_title }}</h2>
            <ul>
                <li><a href="/">Home</a></li>
                <li>{{ $contact->page_title }}</li>
            </ul>
        </div>
    </div>
</div>

<section class="contact-section">
    <div class="contact-inner">

        <!-- LEFT: Section Header + Info Cards -->
        <div class="contact-left-col">
            <div>
                <div class="section-eyebrow">Reach Out</div>
                <h2 class="section-title-main">{{ $contact->heading ?? 'Have Any Questions?' }}</h2>
                <span class="section-title-bar"></span>
                <p class="section-subtitle" style="text-align:left; margin: 0 0 32px;">
                    {{ strip_tags($contact->subheading ?? 'Have an inquiry or some feedback for us? Fill out the form to contact our team.') }}
                </p>
            </div>

            <!-- Address Card -->
            <div class="contact-card">
                <div class="contact-icon-wrap">
                    <i class="bx bx-map"></i>
                </div>
                <div class="contact-card-body">
                    <h5>Our Address</h5>
                    <p>{{ $contact->address ?? 'No address provided' }}</p>
                </div>
            </div>

            <!-- Phone Card -->
            <div class="contact-card">
                <div class="contact-icon-wrap">
                    <i class="bx bx-phone-call"></i>
                </div>
                <div class="contact-card-body">
                    <h5>Phone Number</h5>
                    <p>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contact->phone ?? '') }}">
                            {{ $contact->phone ?? 'No phone provided' }}
                        </a>
                    </p>
                </div>
            </div>

            <!-- Email Card -->
            <div class="contact-card">
                <div class="contact-icon-wrap">
                    <i class="bx bx-envelope"></i>
                </div>
                <div class="contact-card-body">
                    <h5>Email Address</h5>
                    <p>
                        <a href="mailto:{{ $contact->email ?? '' }}">
                            {{ $contact->email ?? 'No email provided' }}
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- RIGHT: Contact Form -->
        <div class="contact-right-col">
            <div class="contact-form-card">

                @if($contact->form_bg_image ?? false)
                    <div class="contact-form-card-bg" style="background-image: url({{ env('MAIN_URL') . $contact->form_bg_image }});"></div>
                @endif

                <div class="form-heading">Get in Touch</div>
                <div class="form-divider"></div>
                <p class="form-desc">Have inquiries or want to place an order? Contact our team for assistance.</p>

                @if(session('success'))
                    <div class="alert-success-fire">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-danger-fire">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="fire-form">
                    <form action="{{ url('/contact') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-half">
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Your Name*" required>
                            </div>
                            <div class="col-half">
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone Number*">
                            </div>
                            <div class="col-full">
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address*" required>
                            </div>
                            <div class="col-full">
                                <textarea name="message" rows="5" placeholder="Write Your Message*" required>{{ old('message') }}</textarea>
                            </div>
                            <div class="col-full">
                                <button type="submit" class="fire-btn">
                                    <span>Send Message</span>
                                    <i class="bx bx-send"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</section>

<div id="map">
    {!! $contact->map_iframe ?? '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2987.7593473566985!2d-73.78797548432667!3d41.509489596379204!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89dd490255c9bfa7%3A0xfe099945f43b6e47!2sWonderland%20Dr%2C%20East%20Fishkill%2C%20NY%2012533%2C%20USA!5e0!3m2!1sen!2sbd!4v1622957216342!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>' !!}
</div>



@endsection