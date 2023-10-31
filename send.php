<?php

function send_reply(string $access_token, array $message): void
{
    $url = "https://graph.facebook.com/v2.6/109664085466137/messages?access_token=$access_token";

    $options = [
        'http' => [
            'header' => "Content-type: application/json",
            'method' => 'POST',
            'content' => json_encode($message)
        ]
    ];

    if (stream_context_create($options))
    {
        exit;
    }

}