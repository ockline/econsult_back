<?php

namespace App\Mail\Email;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Notifiers extends Mailable
{

    use Queueable, SerializesModels;

    public $body;
    public $title;
    public $source;


    public function __construct($body,$title,$source)
    {
        $this->body = $body;
        $this->title = $title;
        $this->source = $source;

    }

    public function build()
    {
        return $this->view('notifier/notifierEmail')
            ->subject($this->title);
    }

}
