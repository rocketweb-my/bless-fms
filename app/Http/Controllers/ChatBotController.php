<?php

namespace App\Http\Controllers;

use App\Mail\Client\PublicSubmission as ClientNotificationSumbmission;
use App\Mail\Staff\PublicSubmission as StaffNotificationSumbmission;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ChatBotController extends Controller
{
    public function submit_ticket(Request $request)
    {
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
            'name' => $request->name,
            'email' => $request->email,
            'category' => $category,
            'priority' => '3',
            'subject' => $request->subject,
            'message' => $request->message,
            'dt' => Carbon::now(),
            'lastchange' => Carbon::now(),
            'status' => 0,
        ]);

        $data['name'] = $request->name;
        $data['subject'] = $request->subject;
        $data['trackid'] = $tracking_id;

        Mail::to($owner_email)
        //            ->cc($moreUsers)
        //            ->bcc($evenMoreUsers)
                ->send(new StaffNotificationSumbmission($data));

        Mail::to($request->email)
        //            ->cc($moreUsers)
        //            ->bcc($evenMoreUsers)
                ->send(new ClientNotificationSumbmission($data));


        $result = Array (
                "0" => Array (
                    "text" => "Support Ticket Successfully Submitted",
                ),
                "1" => Array (
                    "text" => "Ticket tracking ID : ".$tracking_id,
                )
            );

        return json_encode($result);

    }

    public function check_ticket(Request $request)
    {

        $tickets = Ticket::where('email', $request->email)->get();

        if ($tickets->count() == 0)
        {
            $result = Array (
                    "0" => Array (
                        "text" => "No tickets found for this email address.",
                    ),
                );
        }else
        {
            foreach($tickets as $index => $ticket)
            {
                        switch ($ticket->status)
                        {
                            case 1:
                                $status = 'Waiting Reply';
                                break;

                            case 2:
                                $status = 'Replied';
                                break;
                            case 3:
                                $status = 'Resolved';
                                break;
                            case 4:
                                $status = 'In Progress';
                                break;
                            case 5:
                                $status = 'On Hold';
                                break;
                            default:
                                $status = 'New';
                                break;
                        }



                $result[] = array("text" => "Ticket tracking ID : ".$ticket->trackid);
                $result[] = array("text" => "Subject : ".$ticket->subject);
                $result[] = array("text" => "Status : ".$status);

                // $result[] = array_merge($trackingId, $statusResult);

            }
        }

        return json_encode($result);

    }


}
