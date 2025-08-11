<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Conversations\Conversation;

class KnowledgebaseConversationController extends Conversation
{
    public function start()
    {
        $this->say('Please Click Button Below :');
        $this->say('<a class="btn" style="text-decoration: none;" href="'.route('public.knowledgeabase').'" target="_blank">Knowledgebase Page</a>');
        $this->ask1();
    }

    public function ask1()
    {
        $question = Question::create('Anything else I can help?')
            ->fallback('Unable to create a new database')
            ->callbackId('create_database')
            ->addButtons([
                Button::create('Yes')->value('yes'),
                Button::create('No')->value('no'),
            ]);

        $this->ask($question, function (Answer $answer) {
            // Detect if button was clicked:
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue(); // will be either 'yes' or 'no'
                $selectedText = $answer->getText();
                if ($selectedValue == 'yes') {
                    $this->say($selectedText);
                    $this->bot->startConversation(new ConversationController);
                } elseif ($selectedValue == 'no') {
                    $this->say($selectedText);
                    $this->say('Ok, good bye');
                    //$selectedText = $answer->getText(); // will be either 'Of course' or 'Hell no!'
                }
            }
        });
    }

    public function run()
    {
        $this->start();
    }
}
