<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PermitRequestApproveNotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        return $this->subject('PERMIT SEARCH : Your Requested Permit Address data found.')
            ->view('mail.permit-request-approve-notify', ['status' => $this->details->status ] );
    }
}
