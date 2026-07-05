<?php

namespace App\Mail;

use App\Models\ContactEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $enquiry;
    public $role;

    public function __construct(ContactEnquiry $enquiry, $role = 'admin')
    {
        $this->enquiry = $enquiry;
        $this->role = $role;
    }

    public function build()
    {
        $subject = $this->role === 'user' ? 'Message Received - Thank You!' : 'New Contact Form Submission';
        return $this->subject($subject)
                    ->view('emails.contact_email');
    }
}
