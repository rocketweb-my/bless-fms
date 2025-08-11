<?php

namespace App\Mail\Staff;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientReply extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
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

        return $this->markdown('emails.staff.client_reply')
                    ->subject('New Customer Reply')
                    ->from($default_mail_address,$default_mail_name);
    }
}
