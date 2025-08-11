<?php

namespace App\Mail\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotTracking extends Mailable
{
    use Queueable, SerializesModels;
    public $tickets;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(systemGeneralSetting() != null && systemGeneralSetting()->from_email != null)
        {
            $default_mail_address = systemGeneralSetting()->from_email;
        }else{
            $default_mail_address = 'noreply@antaradesk.com';
        }

        if(systemGeneralSetting() != null && systemGeneralSetting()->from_name != null)
        {
            $default_mail_name = systemGeneralSetting()->from_name;
        }else{
            $default_mail_name = 'Antara Desk';
        }

        return $this->markdown('emails.client.forgot_tracking')
            ->subject('Forgot ticket tracking ID')
            ->from($default_mail_address,$default_mail_name);

    }
}
