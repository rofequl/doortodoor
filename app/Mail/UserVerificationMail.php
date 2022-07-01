<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject; public $code ;

    public function __construct($subject,$code){
        $this->subject = $subject;
        $this->code = $code;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.UserVerificationMail')
        ->subject($this->subject,$this->code)->with('subject','code');
        // return $this->markdown('emails.users.UserRegistrationMail');
    }

}
