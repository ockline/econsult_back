<?php

namespace App\Mail\Staffs;

use log;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InitiateWorkflowMail extends Mailable
{

    use Queueable, SerializesModels;


    public $firstname;


    public function __construct($firstname)
    {
        $this->$firstname = $firstname;

    }

    public function build()
    {

// log::info('bladeeee');
        return $this->view('Staff/initiateWorkflow')
        ->subject('Socrate Management System');
    }

}
