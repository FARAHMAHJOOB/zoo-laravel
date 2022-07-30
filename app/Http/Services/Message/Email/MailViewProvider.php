<?php

namespace App\Http\Services\Message\Email;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailViewProvider extends Mailable {

    use SerializesModels;

    public $details;

    public function __construct($details, $subject, $from)
    {
        $this->details = $details;
        $this->subject = $subject;
        $this->from = $from;
    }

    public function build()
    {
        return $this->subject($this->subject)->view('emails.send-email');
    }

}
