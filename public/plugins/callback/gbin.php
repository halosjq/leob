<?php

use App\Models\{Bot, User};
use App\Gate\Bin;
use App\Config\Lang;

if ($idC != $call_cmd[1]) {
    Bot::AnswerQuery($callback_query_id, '❌ Access denied '); exit;
}

$fim = Bin::Get($call_cmd[2].rand(10000, 99999));

$f = User::GetUser($idC);
$lang = Lang::$langs[$f['lang']];

if (!$fim['ok']) {
    Bot::AnswerQuery($callback_query_id, '❌ Invalid bin', false);
    $txt = sprintf($lang['bin']['invalid'], $fim['bin']);
} else {
    Bot::AnswerQuery($callback_query_id, 'Valid bin ✅', false);
    $txt = sprintf($lang['bin']['valid'], $fim['bin'], $fim['brand'], $fim['type'], $fim['level'], $fim['bank_name'], $fim['bank_phone'], $fim['country_name'], $fim['ISO3'], $fim['flag'], $fim['currency'], $f['mention'], $f['apodo']);
}

Bot::EditMsgTxt($chatidC, $messageidC, $txt, [
    'inline_keyboard' => [
        [
            ['text' => 'Gen again ♻️', 'callback_data' => 'gbin '.$idC.'|'.$call_cmd[2]]
        ]
    ]
]);