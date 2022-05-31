<?php

use App\Models\Bot;
use App\Gate\Gen;

if ($call_cmd[1] != $idC) {
    Bot::AnswerQuery($callback_query_id, '⚠️ Access denied'); exit;
}

$cgen = array_slice($call_cmd, 2, 4);

$gen = Gen::Complet($cgen[0], $cgen[1], $cgen[2], $cgen[3]);

if (!$gen['ok']) {
    Bot::AnswerQuery($callback_query_id, '⚠️ '.$gen['error']); exit;
}

$Strl = ($cgen[0] == 3) ? 15 : 16;
$card = $cgen[0].str_repeat('x', $Strl - strlen($cgen[0]));
$ccgen = implode('|', [$card, $cgen[1], $cgen[2], $cgen[3]]);

Bot::AnswerQuery($callback_query_id, '⚙ Generating, please wait', false);
Bot::editMessageText([
    'chat_id'      => $chatidC,
    'message_id'   => $messageidC,
    'parse_mode'   => 'html',
    'text'         => "<b>Input:</b> <code>".$ccgen."</code>\n\n<code>".implode("\n", $gen['ccs'])."</code>",
    'reply_markup' => json_encode([
        'inline_keyboard' => [
            [
                ['text' => 'Gen Again ⚙', 'callback_data' => 'gen '.$idC.'|'.implode('|', $cgen)],
                ['text' => 'Bin Info ♻️', 'callback_data' => 'bin '.substr($cgen[0], 0, 6)]
            ], [
                ['text' => 'Delete 🗑', 'callback_data' => 'finalize|'.$idC]
            ]
        ]
    ])
]);