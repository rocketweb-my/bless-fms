<?php

namespace App\Console\Commands;

namespace App\Console\Commands;


use App\Models\Category;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;

use Webklex\IMAP\Commands\ImapIdleCommand;
use Webklex\PHPIMAP\Message;
use Illuminate\Support\Carbon;
use App\Models\Ticket;
use Illuminate\Support\Facades\Mail;
use App\Mail\Client\PublicSubmission as ClientNotificationSumbmission;
use App\Mail\Staff\PublicSubmission as StaffNotificationSumbmission;
use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\ClientManager;
use App\Models\SettingEmail;
use Webklex\IMAP\Facades\Client as ClientFacade;
use Webklex\PHPIMAP\Exceptions\ConnectionFailedException;
use Webklex\PHPIMAP\Exceptions\FolderFetchingException;
use Webklex\PHPIMAP\Folder;
use Illuminate\Support\Facades\Log;




class ImapChecker extends Command
{

    protected $signature = 'imap_checker';

    protected $description = 'Check Imap Email';

    protected $account = "default";

    protected $folder_name = "INBOX";

    public function onNewMessage(Message $message){

        $tracking_id = generateTicketID();
        $attachment_list= '';
        $owner = 0;
        $owner_email = '';
        $sender_name = $message->getFrom()[0]->personal;
        $sender_email = $message->getFrom()[0]->mail;
        $sender_subject = $message->subject;
        $sender_message = strip_tags($message->getTextBody());
        $history = '<li class="smaller">'.Carbon::now().' | submitted by Customer</li>';

        $category = Category::first();


        //Auto Assign Ticket
        if (systemSetting()->autoassign == 1)
        {

        $autoassign_owner = autoAssignTicket($category->id);

            if ($autoassign_owner != null)
            {
                $owner   = $autoassign_owner->id;
                $owner_email = $autoassign_owner->email;
                $history .= '<li class="smaller">'.Carbon::now().' | automatically assigned to '.$autoassign_owner->name.' ('.$autoassign_owner->user.')</li>';
            }
            else
            {
                $owner= 0;
            }
        }


        Ticket::create([
            'trackid' => $tracking_id,
            'owner' => $owner,
            'history' => $history,
            'merged' => '',
            'language' => null,
            'articles' => null,
            'ip' => '127.0.0.1',
            'name' => $sender_name,
            'email' => $sender_email,
            'category' => $category->id,
            'priority' => '3',
            'subject' => $sender_subject,
            'message' => $sender_message,
            'dt' => Carbon::now(),
            'lastchange' => Carbon::now(),
            'status' => 0,
        ]);

        $data['name'] = $sender_name;
        $data['subject'] = $sender_subject;
        $data['trackid'] = $tracking_id;


        Mail::to($owner_email)
//            ->cc($moreUsers)
//            ->bcc($evenMoreUsers)
            ->send(new StaffNotificationSumbmission($data));

        Mail::to($sender_email)
//            ->cc($moreUsers)
//            ->bcc($evenMoreUsers)
            ->send(new ClientNotificationSumbmission($data));

    }

    public function handle() {
        if (is_array($this->account)) {
            $setting = SettingEmail::first();
            $client = ClientFacade::make([
                'host'          => $setting->host,
                'port'          => $setting->port,
                'encryption'    => 'ssl',
                'validate_cert' => true,
                'username'      => $setting->username,
                'password'      => decrypt($setting->password),
                'protocol'      => 'imap'
            ]);
        }else{
            $setting = SettingEmail::first();
            $client = ClientFacade::make([
                'host'          => $setting->host,
                'port'          => $setting->port,
                'encryption'    => 'ssl',
                'validate_cert' => true,
                'username'      => $setting->username,
                'password'      => decrypt($setting->password),
                'protocol'      => 'imap'
            ]);
        }

        try {
            $client->connect();
        } catch (ConnectionFailedException $e) {
            Log::error($e->getMessage());
            return 1;
        }

        /** @var Folder $folder */
        try {
            $folder = $client->getFolder($this->folder_name);
        } catch (ConnectionFailedException $e) {
            Log::error($e->getMessage());
            return 1;
        } catch (FolderFetchingException $e) {
            Log::error($e->getMessage());
            return 1;
        }

        try {
            $folder->idle(function($message){
                $this->onNewMessage($message);
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return 1;
        }

        return 0;
    }

}
