<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url; // full reset link

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function build()
    {
        return $this->subject('Reset Your Password')
            ->view('emails.customer.reset')
            ->with(['url' => $this->url]);
    }
}
