<?php

namespace App\Mail\Staff;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($password)
    {
        $this->password = $password;
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

        return $this->markdown('emails.staff.reset_password')
            ->subject('Your Password Has Been Reset')
            ->from($default_mail_address,$default_mail_name);


    }
}
