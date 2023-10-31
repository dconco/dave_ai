<?php

include_once './send.php';

$my_verify_token = 'davebot123';

$challenge = $_GET['hub_challenge'];
$verify_token = $_GET['hub_verify_token'];

if ($my_verify_token === $verify_token)
{
    echo $challenge;
    exit;
}

$access_token = 'EAAOOom4rGZAQBO4uy0kczvtZCSuzZA7NH83hSWewMTAliyb3RaOS0qm1BrGbifZCreoI1N4cZBzKgxHyf1Wrw5enH6KYZAp3nYAn7KZBxNsmzdr2PcvtUofWvnYzN9CIVFzh0LqStVcudqEno8MKTZCNBsZAZAG9qeuZCC9ZBwezpL5naiJXLl6YznwZCluHOODy9aZAuPROPF7RZBAfa52tQTF';

$response = file_get_contents('php://input');

$response = json_decode($response, true);

$message = $response['entry'][0]['messaging'][0]['message']['text'];
$sender_id = $response['entry'][0]['messaging'][0]['sender']['id'];
$receiver_id = $response['entry'][0]['messaging'][0]['recipient']['id'];

$message_time = date('d-m-Y H:i:s', $response['entry'][0]['messaging'][0]['timestamp']);

$reply = [
    'messaging_type' => 'RESPONSE',
    'recipient' => [
        'id' => $sender_id,
    ],
    'message' => [
        'text' => $message
    ]
];

send_reply($access_token, $reply);