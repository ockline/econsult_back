<?php

namespace App\Mail\Change;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApproveReqMail extends Mailable
{

    use Queueable, SerializesModels;


    public $fullname;


    public function __construct($fullname)
    {
        $this->$fullname = $fullname;

    }

    public function build()
    {
        return $this->view('change/approverReqNotification')
        ->subject('ICT Change Management');
    }

}
