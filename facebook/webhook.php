<?php

include_once './send.php';
include_once '../config.php';

$challenge = $_GET['hub_challenge'];
$verify_token = $_GET['hub_verify_token'];

if ($my_verify_token === $verify_token)
{
    echo $challenge;
    exit;
}

$response = file_get_contents('php://input');

$response = json_decode($response, true);

$message = $response['entry'][0]['messaging'][0]['message']['text'];
$sender_id = $response['entry'][0]['messaging'][0]['sender']['id'];
$receiver_id = $response['entry'][0]['messaging'][0]['recipient']['id'];
$message_time = date('d-m-Y H:i:s', $response['entry'][0]['messaging'][0]['timestamp']);

$reply = [
    'sender' => [
        'sender_id' => $sender_id,
        'receiver_id' => $receiver_id,
        'message' => $message,
        'message_time' => $message_time
    ]
];

$get_log = fopen('.log', 'a');
fwrite($get_log, $get_log . "\n\n" . json_encode($reply));

$new_message = $message;

$reply = [
    'messaging_type' => 'RESPONSE',
    'recipient' => [
        'id' => $sender_id,
    ],
    'message' => [
        'text' => $new_message
    ]
];

$response = send_reply($access_token, $reply);
$add_arr = [
    'message' => $new_message,
    'message_time' => $message_time
];

if ($response)
{
    $response = array_merge($response, $add_arr);
    fwrite($get_log, $get_log . "\n\n" . json_encode($response));
}
