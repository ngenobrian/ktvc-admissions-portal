<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Enquiry;

class EnquiryReply extends Mailable
{
    use Queueable, SerializesModels;

    public $enquiry;

    public function __construct(Enquiry $enquiry)
    {
        $this->enquiry = $enquiry;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re: Your Enquiry to KTVC Admissions',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enquiry_reply',
        );
    }
}