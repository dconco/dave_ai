<?php

require './vendor/autoload.php';
require './env.config.php';
require './cors.php';

use Orhanerday\OpenAi\OpenAi;

$open_ai_secret = getenv('OPENAI_API_KEY');
$open_ai = new OpenAi($open_ai_secret);
$open_ai->setORG("org-evQwRS16eXJhUXWWPv0OoMzS");


header("Content-Type: Application/json");

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    exit;
}

$req_data = json_decode(file_get_contents("php://input"), false);
if (empty($req_data->message)) {
    http_response_code(400);
    exit;
}

// send message
$chat = $open_ai->chat([
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        [
            "role" => "user",
            "content" => $req_data->message
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
        'created' => date('Y-m-d H:i:s', $data->created)
    ];

    http_response_code(200);
    echo json_encode($response);
} else {
    http_response_code(500);
    exit;
}
