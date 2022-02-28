<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotOTPMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = \App\Setting::setting('email');
        $subject = 'OTP for new password';
        $name = \App\Setting::setting('title');
        return $this->from($address, $name)
                    ->subject($subject)
                    ->view('emails.ForgotOTPMail');
    }
}
