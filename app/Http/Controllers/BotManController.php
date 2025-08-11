<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Conversations\Conversation;

class BotManController extends Controller
{
    protected $replies;
    protected $answer;

    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function($botman, $message) {

            if ($message == 'yes') {
                $botman->startConversation(new ConversationController);
            }else{
                $botman->reply("Write 'yes' to if you need any help");
            }

        });

        $botman->listen();
    }

}
