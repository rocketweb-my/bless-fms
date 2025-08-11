<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Conversations\Conversation;


class ConversationController extends Conversation
{
    protected $answer;

    protected $num;

    protected $response;

    public function option()
    {
        $question = Question::create('How Can I Help You')
            ->fallback('Unable to create a new database')
            ->callbackId('create_database')
            ->addButtons([
                Button::create('Knowledgebase')->value('kb'),
                Button::create('Submit Ticket')->value('ticket'),
            ]);

        $this->ask($question, function (Answer $answer) {
            // Detect if button was clicked:
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue(); // will be either 'yes' or 'no'
                $selectedText = $answer->getText();
                if ($selectedValue == 'kb')
                {

                    $this->bot->startConversation(new KnowledgebaseConversationController);
                }elseif ($selectedValue == 'ticket'){
                    $this->bot->startConversation(new SupportConversationController);
                }elseif ($selectedText != null){
                    $this->say($selectedText);
                    $this->option();
                }
                //$selectedText = $answer->getText(); // will be either 'Of course' or 'Hell no!'
            }
        });

    }



    public function action($num)
    {
        $this->num = $num+1;
        $data = Bot::find($num);

        if ($data->say != null)
        {
            $this->say($data->say);
        }

        $this->response = $data->response;

        $this->ask($data->ask, function(Answer $answer) {


            $this->say($this->response);

            $next = Bot::find($this->num);
            if ($next != null)
            {
                $this->action($this->num);
            }else{
                $this->say('Bye');
            }


        });
    }


    public function run()
    {
        $this->option();
//        $this->action(1);
    }
}
