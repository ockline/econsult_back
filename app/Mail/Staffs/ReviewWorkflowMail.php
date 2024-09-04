<?php

namespace App\Mail\Staffs;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewWorkflowMail extends Mailable
{

    use Queueable, SerializesModels;


    public $fullname;


    public function __construct($fullname)
    {
        $this->$fullname = $fullname;

    }

    public function build()
    {
        return $this->view('Staff/reviewWorkflow')
        ->subject('Socrate Management System');
    }

}
