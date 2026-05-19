<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Application;

class ApplicationReviewed extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    // Pass the application data into the email
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    // Set the Subject Line dynamically based on the status
    public function envelope(): Envelope
    {
        $subject = $this->application->status === 'approved' 
            ? 'Congratulations! Admission Approved - KTVC' 
            : 'Action Required: Admission Application Returned - KTVC';

        return new Envelope(
            subject: $subject,
        );
    }

    // Point to the Blade template we are about to create
    public function content(): Content
    {
        return new Content(
            view: 'emails.application_reviewed',
        );
    }
}