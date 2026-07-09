<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EstimateMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $orderId,
        public array $cartItems,
        public float $netTotal,
        public float $actualTotal,
        public string $customerName,
        public string $customerEmail,
        public \App\Models\PaymentSetting $payment,
        public array $globalCharges = [],
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ' Order Confirmed – ' . $this->orderId . ' |Sri Annapoorani Crackers',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.estimate',
        );
    }
}