<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PermitRequestMail extends Mailable
{
	use Queueable, SerializesModels;

	public $details;

	public function __construct($details){
		$this->details = $details;
	}
	public function build(){
        	return $this->subject('New Permit/address Request Recieved.')
                ->view('mail.permit-request');
    }
}