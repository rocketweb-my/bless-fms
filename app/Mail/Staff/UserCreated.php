<?php

namespace App\Mail\Staff;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreated extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$password)
    {
        $this->email = $email;
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

        if(systemGeneralSetting() != null && systemGeneralSetting()->help_desk_title != null)
        {
            return $this->markdown('emails.staff.user_created')
                ->subject('Welcome to '.systemGeneralSetting()->help_desk_title)
                ->from($default_mail_address,$default_mail_name);
        }else{
            return $this->markdown('emails.staff.user_created')
                ->subject('Welcome to Antara Desk')
                ->from($default_mail_address,$default_mail_name);
        }

    }
}
