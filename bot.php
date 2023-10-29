<?php

include 'Bot.php';

$tokken = $_REQUEST['hub_verify_token'];
$hubVerifyToken = 'fb_davebot_token';
$challange = $_REQUEST['hub_challenge'];
$accessToken = 'EAAOOom4rGZAQBO39O3y4LBNjEInMVGMDUSyaZBZAC7RZCLbzMcn8tSZBjpY2ByY8DaBEHSVuLUxcU65pLABWQSHRBcM4ZAvRQ4JV9O9EYbqtCKcK56QincB3oJMswtNYTAMrDfpxdBb7PtggjGXlI9skM5ZClb38lq8aSme8jxqTZAnRsS3aYWPiv0vYRUFHj6JQmdZAilCOhtvSPiktn';

$bot = new Bot();
$bot->setHubVerifyToken($hubVerifyToken);
$bot->setaccessToken($accessToken);
echo $bot->verifyTokken($tokken, $challange);
$input = json_decode(file_get_contents('php://input'), true);
$message = $bot->readMessage($input);
$textmessage = $bot->sendMessage($message);