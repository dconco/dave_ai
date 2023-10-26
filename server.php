<?php

require __DIR__ . './vendor/autoload.php';
require __DIR__ . './env.config.php';

use Orhanerday\OpenAi\OpenAi;

$open_ai_secret = getenv('OPENAI_API_KEY');
$open_ai = new OpenAi($open_ai_secret);
$open_ai->setORG("org-evQwRS16eXJhUXWWPv0OoMzS");

header("Content-Type: Application/json");

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    exit;
}

// send message
$chat = $open_ai->chat([
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        [
            "role" => "user",
            "content" => "who is dave conco?"
        ]
    ],
    'temperature' => 1.0,
    'max_tokens' => 150,
    'frequency_penalty' => 0,
    'presence_penalty' => 0,
]);


// send request back
if ($chat == true) {
    $data = json_decode($chat);

    $response = [
        'id' => $data->id,
        'status' => 'success',
        'data' => $data->choices[0]->message->content,
        'created' => date($data->created, 'Y-m-d H:i:s')
    ];

    http_response_code(200);
    echo json_encode($response);
} else {
    http_response_code(500);
    exit;
}
