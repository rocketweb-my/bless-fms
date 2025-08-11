<?php

namespace App\Http\Controllers;


use App\Mail\Client\PublicSubmission as ClientNotificationSumbmission;
use App\Mail\Staff\PublicSubmission as StaffNotificationSumbmission;
use App\Models\Attachment;
use App\Models\BanEmail;
use App\Models\Bot;
use App\Models\Category;
use App\Models\CustomField;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Conversations\Conversation;
use Illuminate\Support\Facades\Mail;
use function Symfony\Component\Translation\t;

class SupportConversationController extends Conversation
{
    protected $name;
    protected $email;
    protected $category_id;
    protected $category_name;
    protected $subject;
    protected $message;

    public function ask_category()
    {
        $categories = Category::all();

        foreach ($categories as $category)
        {
            $button[] = Button::create($category->name)->value($category->id);
        }

        $question = Question::create('Please Choose Category')
            ->fallback('Unable to create a new database')
            ->callbackId('create_database')
            ->addButtons($button);

        $this->ask($question, function (Answer $answer) {
            // Detect if button was clicked:
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue(); // will be either 'yes' or 'no'
                if ($selectedValue) {
                    $selected_category = Category::find($selectedValue);
                    $this->say('Selected Category : '.$selected_category->name);
                    $this->category_id = $selectedValue;
                    $this->category_name = $selected_category->name;
                    $this->ask_name();
                }
            }
        });

    }

    public function ask_name()
    {
        $this->ask('May I Know What Is Your Name?', function (Answer $response) {
            $this->say('Your Name : ' . $response->getText());
            $this->name = $response->getText();
            $this->ask_email();
        });


    }

    public function ask_email()
    {
        $this->ask('Can You Give Me Your Email For Us To Respond This Ticket', function (Answer $response) {
            $this->say('Your Email : ' . $response->getText());
            $this->email = $response->getText();

            $this->ask_subject();
        });

    }

    public function ask_subject()
    {
        $this->ask('What Is The Subject Of Your Ticket?', function (Answer $response) {
            $this->say('Your Subject : ' . $response->getText());
            $this->subject = $response->getText();
            $this->ask_message();
        });
    }

    public function ask_message()
    {
        $this->ask('Now, Please Write Down Content Of Your Ticket', function (Answer $response) {
            $this->say('Your Message : ');
            $this->message = $response->getText();
            $this->say($this->message);
            $this->ask_final();
        });
    }

    public function ask_final()
    {
        $this->say('Thank you from your response, can you double check all the information before we submit this ticket');
        $this->say('Name : '. $this->name);
        $this->say('Email : '. $this->email);
        $this->say('Cateogry : '. $this->category_name);
        $this->say('Subject : '. $this->subject);
        $this->say('Message : ');
        $this->say($this->message);

        $question = Question::create('Are all information above correct?')
            ->fallback('Unable to create a new database')
            ->callbackId('create_database')
            ->addButtons([
                Button::create('Yes')->value('yes'),
                Button::create('No')->value('no')
            ]);

        $this->ask($question, function (Answer $answer) {
            // Detect if button was clicked:
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue(); // will be either 'yes' or 'no'
                if ($selectedValue == 'yes') {
                    $this->submission_form();
                }else{
                    $this->say('Good Bye');
                }
            }
        });
    }



    public function submission_form()
    {
        //Check Email Ban//

//        $email_ban = BanEmail::where('email',$this->email)->get();
//        if ($email_ban->count() != 0)
//        {
//            toastr()->warning('Your Email Has Been Banned', 'Failed');
//            return redirect()->route('public.index');
//        }
        //Check IP Ban//
//        $ip_ban = checkBanIP($request->ip());
//        if ($ip_ban != 0)
//        {
//            toastr()->warning('Your IP Has Been Banned', 'Failed');
//            return redirect()->route('public.index');
//        }

        //Checkbox value format change from array to text//
//        $checkboxs = CustomField::where('use','1')->where('type','checkbox')->whereNotNull('value')->get();
//
//        if($checkboxs->count() > 0)
//        {
//            foreach ($checkboxs as $checkbox)
//            {
//                if ($request->has('custom'.$checkbox->id))
//                {
//                    $items = $request['custom'.$checkbox->id];
//                    $total_array = count($items);
//                    $new_custom = '';
//                    foreach ( $items as $index => $item)
//                    {
//                        $new_custom .= $item;
//                        if ($index < $total_array-1)
//                        {
//                            $new_custom .= '<br />';
//                        }
//                    }
//                    $request->request->add(['custom'.$checkbox->id => $new_custom]);
//                }
//            }
//        }

        $tracking_id = generateTicketID();
        $attachment_list= '';
        $owner = 0;
        $owner_email = '';
        $history = '<li class="smaller">'.Carbon::now().' | submitted by Customer via Bot</li>';

        //Auto Assign Ticket
        if (systemSetting()->autoassign == 1)
        {

            $autoassign_owner = autoAssignTicket($this->category_id);

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

        // Attachment Start //
//        if($request->file()) {
//            for ($x = 1; $x <= systemSetting()->attachments_max_size ; $x++) {
//                {
//                    if (isset($request->file[$x]))
//                    {
//                        $save_file_name = $tracking_id.'_'.$request->file[$x]->hashName();
//                        $path = $request->file[$x]->storeAs('public/attachment',$save_file_name);
//                        $file_size = $request->file[$x]->getSize();
//                        $original_file_name = $request->file[$x]->getClientOriginalName();
//                        $attachment = Attachment::create([
//                            'ticket_id' => $tracking_id,
//                            'saved_name' => $save_file_name,
//                            'real_name' => $original_file_name,
//                            'size'      => $file_size,
//                        ]);
//                        $attachment_list .= $attachment->id . '#' . $original_file_name .',';
//                    }
//                }
//            }
//        }
        // Attachment End //


        for ($x = 1; $x <= 50; $x++) {
                $custom['custom'.$x] = '';
        }

        $data = [
            'name'      => $this->name,
            'email'     => $this->email,
            'category'  => $this->category_id,
            'subject'   => $this->subject,
            'message'   => $this->message,
            'trackid' => $tracking_id,
            'owner' => $owner,
            'history' => $history,
            'attachments' => $attachment_list,
            'merged' => '',
            'language' => null,
            'articles' => null,
            'dt' => Carbon::now(),
            'lastchange' => Carbon::now(),
            'ip' => '127.0.0.1'
        ];
        $final_data = array_merge($data,$custom);


        Ticket::create($final_data);

        Mail::to($owner_email)
            ->send(new StaffNotificationSumbmission($data));

        Mail::to($this->email)
            ->send(new ClientNotificationSumbmission($data));

        $this->say('Ticket created, This is your tracking number : '. $tracking_id);

    }

    public function ask_file()
    {
        $this->askForFiles('Please upload an attachment.', function ($file) {
            $this->say($file);
        }, function(Answer $answer) {
            // This method is called when no valid image was provided.
        });
    }


    public function run()
    {
        $this->ask_category();
    }


}
