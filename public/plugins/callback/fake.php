<?php

use App\Gate\CurlX;
use App\Models\Bot;

if ($idC != $call_cmd[1]) {
    Bot::AnswerQuery($callback_query_id, '⚠️ Access denied');
    exit;
}
$datas = json_decode(CurlX::Get('https://randomuser.me/api/?nat='.$call_cmd[2])->body, true);

if (!$datas || isset($datas['error'])) {
    Bot::AnswerQuery($callback_query_id, '⚠️ An unknown error occurred'); exit;
}

$mails = ['gmail.com', 'hotmail.com', 'outlook.com', 'outlook.br', 'outlook.jp', 'gmx.es', 'protonmail.com'];
$mails = $mails[array_rand($mails)];
$results = $datas['results']['0'];
$urla = $results['picture']['large'];
$location = $results['location'];
$street = $location['street'];
$names = $results['name'];

/**
 * Edit photo
 */
Bot::editMessageMedia([
    'chat_id'      => $chatidC,
    'message_id'   => $messageidC,
    'media' => json_encode([
        'type'       => 'photo',
        'media'      => $urla,
        'caption'    => "<b>Gender: <code>".ucfirst($results['gender'])."</code>\nName: <code>".$names['title']." ".$names['first']." ".$names['last']."</code>\nMail: <code>".str_replace('example.com', $mails, $results['email'])."</code>\nPhone: <code>".$results['phone']."</code>\nCell: <code>".$results['cell']."</code>\nStreet: <code>".$street['name']." ".$street['number']."</code>\nLocation: <code>".$location['city']." - ".$location['state']."</code>\nPostcode: <code>".$location['postcode']."</code>\nCountry:</b> <code>".$location['country']."</code>",
        'parse_mode' => 'HTML'
    ])
]);

/**
 * Edit Caption
 */
Bot::editMessageCaption([
    'chat_id'      => $chatidC,
    'message_id'   => $messageidC,
    'caption'      => "<b>Gender: <code>".ucfirst($results['gender'])."</code>\nName: <code>".$names['title']." ".$names['first']." ".$names['last']."</code>\nMail: <code>".str_replace('example.com', $mails, $results['email'])."</code>\nPhone: <code>".$results['phone']."</code>\nCell: <code>".$results['cell']."</code>\nStreet: <code>".$street['name']." ".$street['number']."</code>\nLocation: <code>".$location['city']." - ".$location['state']."</code>\nPostcode: <code>".$location['postcode']."</code>\nCountry:</b> <code>".$location['country']."</code>",
    'parse_mode'   => 'HTML',
    'reply_markup' => json_encode([
    'inline_keyboard' => [
            [['text' => 'Gen again ('.$location['country'].') ⚙', 'callback_data' => 'fake '.$idC.'|'.$call_cmd[2]]]
        ]
    ])
]);