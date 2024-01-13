<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerify extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $token;

    public function __construct(User $user, $token)
    {
        $this->user  = $user;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Подтверждение адреса электронной почты')
            ->view('emails.verify_email');
    }
}
