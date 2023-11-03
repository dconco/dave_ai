<?php

require './vendor/autoload.php';
require './env.config.php';
require './cors.php';

use Orhanerday\OpenAi\OpenAi;

$open_ai_secret = getenv('OPENAI_API_KEY');
$open_ai = new OpenAi($open_ai_secret);
$open_ai->setORG("org-evQwRS16eXJhUXWWPv0OoMzS");


header("Content-Type: Application/json");

if ($_SERVER['REQUEST_METHOD'] !== "POST")
{
    http_response_code(405);
    exit;
}

$req_data = json_decode(file_get_contents("php://input"), false);
if (empty($req_data->message) || !isset($req_data->message))
{
    header("HTTP/1.1 400 Request body message is empty");
    exit;
}
else if (empty($req_data->origin) || !isset($req_data->origin) || !preg_match('/^((http?:\/\/)?localhost\/?)$/', $req_data->origin))
{
    header("HTTP/1.1 400 Request origin is invalid");
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
    'max_tokens' => 500,
    'frequency_penalty' => 0,
    'presence_penalty' => 0,
]);

// send request back
if ($chat)
{
    $data = json_decode($chat);

    $response = [
        'id' => $data->id,
        'status' => 'success',
        'created' => $data->created,
        'data' => $data->choices[0]->message->content,
    ];


    // if (isset($_COOKIE['message_db']))
    // {
    //     $message_db = (array)json_decode(base64_decode($_COOKIE['message_db']), true);
    //     $value = array_merge($message_db, $response);

    //     $messages = base64_encode(json_encode($value));
    //     setcookie('message_db', $messages, time() + (86400 * 30), "/");
    // }
    // else
    // {
    //     $messages = base64_encode(json_encode($response));
    //     setcookie('message_db', $messages, time() + (86400 * 30), "/");
    // }

    header("HTTP/1.1 200 OK");
    echo json_encode($response);
}
else
{
    http_response_code(500);
    exit;
}