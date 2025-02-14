<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SignUpEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $seat;
    public $userData;
    public $package;
    public $ownerAmount;
    public $userSubscriptionAmount;
    
    public function __construct($seat, $userData, $package, $ownerAmount, $userSubscriptionAmount)
    {
        $this->seat = $seat;
        $this->userData = $userData;
        $this->package = $package;
        $this->ownerAmount = $ownerAmount;
        $this->userSubscriptionAmount = $userSubscriptionAmount;
    }
    
    public function build()
    {
        return $this->view('emails.signup-email');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
