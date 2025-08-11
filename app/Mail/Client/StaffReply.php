<?php

namespace App\Mail\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StaffReply extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket, $message)
    {
        $this->data = $ticket;
        $this->message= $message;
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

        return $this->markdown('emails.client.staff_reply')
            ->subject('New Ticket Reply')
            ->from($default_mail_address,$default_mail_name);

    }
}
