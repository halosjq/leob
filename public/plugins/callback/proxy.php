<?php

use App\Models\{Bot, User};
use App\Gate\CurlX;

const API_PROXY = 'https://www.secproxy.org/getProxies?key=%s&type=%s&service=all';
const TOKEN_PROXY = 'premium_b364f254a203ae788fd111a7053fd1a1';
const DIR_PROXY = './files/proxy';

// Compara ID's
if ($call_cmd[1] != $idC) {
    Bot::AnswerQuery($callback_query_id, "⚠️ You can't use this command");
    die('Access denied');
}

// Obtiene información del usuario
$f = User::GetUser($idC);

// Min credits
if ($f['creditos'] < 5) {
    Bot::AnswerQuery($callback_query_id, "⚠️ You don't have enough credits to use this command");
    die('Insufficient credits');
}

$proxy_file = DIR_PROXY.'/'.$call_cmd[2].'_'.uniqid($idC.'_').'.txt';

Bot::AnswerQuery($callback_query_id, '-1 credit');
Bot::EditMsgTxt($chatidC, $messageidC, 'Downloading proxies '.$call_cmd[2].'...');

$proxy = CurlX::Get(sprintf(API_PROXY, TOKEN_PROXY, $call_cmd[2]));

if (!$proxy->success) {
    Bot::EditMsgTxt($chatidC, $messageidC, '<b>Curl error when dowloading proxys</b>');
} else {
    
    $proxys = $proxy->body;
    $proxys = PutBannerProxy($proxys);
    file_put_contents($proxy_file, $proxys);

    $total = count(explode("\n", $proxys))-5;
    
    Bot::EditMsgTxt($chatidC, $messageidC, "<i><b>Proxy type:</b> ".ucfirst($call_cmd[2])."\n<b>Cant:</b> ".$total."</i>");
    Bot::sendDocument([
        'chat_id' => $chatidC,
        'document' => new CURLFile($proxy_file),
        'caption' => "Gen by: ".$f['mention'],
        'parse_mode' => 'HTML',
        'reply_to_message_id' => $messageidC,
        'allow_sending_without_reply' => true
    ]);
    unlink($proxy_file);
}

User::Update($idC, $f['status'], $f['staff'], $f['creditos'] - 1, $f['save_live'], $f['member_expired'], $f['credit_expired'], $f['apodo'], $f['antispam']);

function PutBannerProxy(string $proxys) {
    $str = "+--------------------------+\n| Proxy gen: @kirarichkbot |\n+--------------------------+\n\n\n";
    return $str.trim($proxys);
}