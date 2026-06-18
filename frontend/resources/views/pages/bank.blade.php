@extends('layouts.default')

@section('main-page')

<section class="payment-page-section">
    <div class="payment-inner">

        <div class="section-header">
            <div class="section-eyebrow">Checkout</div>
            <h2 class="section-title-main">{{ $payment->heading ?? 'Payment Information' }}</h2>
            <span class="section-title-bar"></span>
            @if(!empty($payment->additional_notes))
                <p class="payment-subtitle">{{ $payment->additional_notes }}</p>
            @endif
        </div>

        <div class="payment-grid">

            <!-- Bank Transfer (no flip) -->
            <div class="payment-card">
                <div class="payment-icon-wrap">
                    <i class="fas fa-university"></i>
                </div>
                <h3 class="payment-card-title">Bank Transfer</h3>
                <div class="payment-divider"></div>
                <div class="payment-detail"><strong>Bank:</strong> {{ $payment->bank_name ?? 'N/A' }}</div>
                <div class="payment-detail"><strong>Acc:</strong> {{ $payment->account_number ?? 'N/A' }}</div>
                <div class="payment-detail"><strong>IFSC:</strong> {{ $payment->ifsc_code ?? 'N/A' }}</div>
                @if(!empty($payment->account_name))
                    <div class="payment-detail" style="margin-top:10px; font-size:14px; color:rgba(255,255,255,0.4);">{{ $payment->account_name }}</div>
                @endif
            </div>

            <!-- Google Pay (flip card) -->
            @if(!empty($payment->gpay_qr_code))
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front payment-card">
                        <div class="payment-icon-wrap">
                            <i class="fab fa-google-pay"></i>
                        </div>
                        <h3 class="payment-card-title">{{ $payment->gpay_label ?? 'Google Pay' }}</h3>
                        <div class="payment-divider"></div>
                        <div class="payment-detail"><strong>Number:</strong><br>{{ $payment->gpay_number ?? 'N/A' }}</div>
                        <div class="flip-hint"><i class="fas fa-sync-alt"></i> Hover to scan QR</div>
                    </div>
                    <div class="flip-card-back">
                        <!-- <div class="qr-full-label">
                            <i class="fab fa-google-pay"></i> Google Pay
                        </div> -->
                        <img src="{{ env('MAIN_URL') . $payment->gpay_qr_code }}" alt="GPay QR" class="qr-full-img qr-zoom">
                        <div class="qr-full-sub">Tap QR to enlarge</div>
                    </div>
                </div>
            </div>
            @else
            <div class="payment-card">
                <div class="payment-icon-wrap"><i class="fab fa-google-pay"></i></div>
                <h3 class="payment-card-title">{{ $payment->gpay_label ?? 'Google Pay' }}</h3>
                <div class="payment-divider"></div>
                <div class="payment-detail"><strong>Number:</strong><br>{{ $payment->gpay_number ?? 'N/A' }}</div>
            </div>
            @endif

            <!-- PhonePe (flip card) -->
            @if(!empty($payment->phonepe_qr_code))
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front payment-card">
                        <div class="payment-icon-wrap">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="payment-card-title">{{ $payment->phonepe_label ?? 'PhonePe' }}</h3>
                        <div class="payment-divider"></div>
                        <div class="payment-detail"><strong>Number:</strong><br>{{ $payment->phonepe_number ?? 'N/A' }}</div>
                        <div class="flip-hint"><i class="fas fa-sync-alt"></i> Hover to scan QR</div>
                    </div>
                    <div class="flip-card-back">
                        <!-- <div class="qr-full-label">
                            <i class="fas fa-mobile-alt"></i> PhonePe
                        </div> -->
                        <img src="{{ env('MAIN_URL') . $payment->phonepe_qr_code }}" alt="PhonePe QR" class="qr-full-img qr-zoom">
                        <div class="qr-full-sub">Tap QR to enlarge</div>
                    </div>
                </div>
            </div>
            @else
            <div class="payment-card">
                <div class="payment-icon-wrap"><i class="fas fa-mobile-alt"></i></div>
                <h3 class="payment-card-title">{{ $payment->phonepe_label ?? 'PhonePe' }}</h3>
                <div class="payment-divider"></div>
                <div class="payment-detail"><strong>Number:</strong><br>{{ $payment->phonepe_number ?? 'N/A' }}</div>
            </div>
            @endif

        </div>
    </div>
</section>

<!-- QR Modal -->
<div id="qrModal" class="qr-modal">
    <span class="close-viewer">&times;</span>
    <div style="position:relative; top:50%; transform:translateY(-50%);">
        <div class="modal-content-wrap">
            <img class="modal-content" id="fullQR">
        </div>
        <div id="caption"></div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById("qrModal");
    const modalImg = document.getElementById("fullQR");
    const captionText = document.getElementById("caption");
    const closeBtn = document.querySelector(".close-viewer");

    document.querySelectorAll('.qr-zoom').forEach(img => {
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
            document.body.style.overflow = 'hidden';
        }
    });

    closeBtn.onclick = function() {
        modal.style.display = "none";
        document.body.style.overflow = '';
    }

    modal.onclick = function(event) {
        if (event.target === modal || (event.target.closest('.qr-modal') === modal && !event.target.closest('.modal-content-wrap'))) {
            modal.style.display = "none";
            document.body.style.overflow = '';
        }
    }
});
</script>

@endsection