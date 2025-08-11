<?php

namespace App\Http\Controllers;

use App\Mail\Client\PublicSubmission as ClientNotificationSumbmission;
use App\Mail\Staff\PublicSubmission as StaffNotificationSumbmission;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BotController extends Controller
{
    public function index(Request $request)
    {



//        $data = $request->json();
        $tracking_id = generateTicketID();
        $owner = 0;
        $category = 1;
        $history = '<li class="smaller">'.Carbon::now().' | submitted by Customer through Catbot</li>';

        if (systemSetting()->autoassign == 1)
        {

            $autoassign_owner = autoAssignTicket($category);

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
            'ip' => $request->ip(),
            'name' => $request->Name,
//            'name' => $data->get('Name'),
            'email' => $request->Email,
//            'email' => $data->get('Email'),
            'category' => $category,
            'priority' => '3',
            'subject' => $request->Subject,
//            'subject' => $data->get('Subject'),
            'message' => $request->Message,
//            'message' => $data->get('Message'),
            'dt' => Carbon::now(),
            'lastchange' => Carbon::now(),
            'status' => 0,
        ]);


        $data['name'] = $request->Name;
        $data['subject'] = $request->Subject;
        $data['trackid'] = $tracking_id;


        Mail::to($owner_email)
//            ->cc($moreUsers)
//            ->bcc($evenMoreUsers)
            ->send(new StaffNotificationSumbmission($data));

        Mail::to($request->Email)
//            ->cc($moreUsers)
//            ->bcc($evenMoreUsers)
            ->send(new ClientNotificationSumbmission($data));
    }
}
