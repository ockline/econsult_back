<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $body;
    public $subject;
    public $recipientName;

    public function __construct(string $subject, string $body, string $recipientName = '')
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->recipientName = $recipientName;
    }

    public function build()
    {
        return $this->view('emails.notification_email')
            ->subject($this->subject);
    }
}
