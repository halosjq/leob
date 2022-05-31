<?php

use App\Models\Bot;

if (isset($call_cmd[1])) {

    if ($call_cmd[1] != $idC) {
        // Access denied
        Bot::AnswerQuery($callback_query_id, '❌ Access denied');exit;
    }
    // Elimina el mensaje enviado por el bot
    Bot::DelMsg($chatidC, $messageidC);

} else {
    // Elimina el mensaje enviado por el bot
    Bot::DelMsg($chatidC, $messageidC);
}


if (isset($up['callback_query']['message']['reply_to_message']['message_id'])) {
    // Elimina el mensaje enviado por el usuario
    Bot::DelMsg($chatidC, $up['callback_query']['message']['reply_to_message']['message_id']);
}