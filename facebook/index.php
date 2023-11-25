<?php

use Orhanerday\OpenAi\OpenAi;

$open_ai = new OpenAi($open_ai_secret);
$open_ai->setORG("org-evQwRS16eXJhUXWWPv0OoMzS");

// send message
function send_bot(string $message)
{
    global $open_ai;

    $chat = $open_ai->chat([
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                "role" => "user",
                "content" => $message
            ]
        ],
        'temperature' => 1.0,
        'max_tokens' => 500,
        'frequency_penalty' => 0,
        'presence_penalty' => 0,
    ]);


    $response = '';
    if ($chat)
    {
        $data = json_decode($chat);
        $response = $data->choices[0]->message->content;
    }

    return $response;
}