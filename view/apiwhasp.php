<?php

$url = 'https://api.green-api.com/waInstance7103856737/sendMessage/9f4302e6f1614ef18604c24e0fb2d6790e33202468154862ab';

//chatId is the number to send the message to (@c.us for private chats, @g.us for group chats)
$data = array(
    'chatId' => '573176862367@c.us',
    'message' => 'Nonononononon'
);

$options = array(
    'http' => array(
        'header' => "Content-Type: application/json\r\n",
        'method' => 'POST',
        'content' => json_encode($data)
    )
);

$context = stream_context_create($options);

$response = file_get_contents($url, false, $context);

echo $response;
?>