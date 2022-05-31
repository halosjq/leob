<?php

use App\Db\Query;
use App\Models\Bot;

$t = $up['callback_query']['message']['reply_to_message']['text'][0] ?? '/';

if ($call_cmd[1] != $idC) {
    Bot::AnswerQuery($callback_query_id, "❌ Access denied\n - Use your own command"); exit;
}

$cmds = GetCmdsStaff($t);
$page = (int) ($call_cmd[3] ?? 0);
$keyboard_back = ['inline_keyboard' => [[['text' => 'Back', 'callback_data' => 'cmds '.$idC.'|']]]];

if (!$cmds['ok']) {
    Bot::EditMsgTxt($chatidC, $messageidC, $cmds['msg'], ['inline_keyboard' => [[['text' => '🔙 Return', 'callback_data' => 'cmds '.$idC.'|']]]]);
    exit;
}

if (isset($cmds['cmds'][$page+1])) {
    $keyboard_back['inline_keyboard'][0][] = ['text' => 'Next ➡️', 'callback_data' => 'panel '.$idC.'|staff|'.($page+1)];
}

$txt = "<b><u>Cmds staff</u> (".$cmds['rows']."):</b>\n\n";
$txt .= implode('', $cmds['cmds'][$page]);
Bot::EditMsgTxt($chatidC, $messageidC, $txt, $keyboard_back); exit;

function GetCmdsStaff(string $t = '', int $parts = 5) {
    $res = Query::GetAllRows("SELECT * FROM cmds WHERE access = :access  ORDER BY `review` ASC", [':access' => 'staff']);
    if (!$res['ok']) return ['ok' => false, 'msg' => '<b>No commands found for staff</b>'];

    $emoji = function(bool $status, bool $test) {
        if ($test) return '⚠️';
        if ($status) return '✅';
        return '❌';
    };

    $cmds = [];

    foreach ($res['rows'] as $comn) {
        $comn['status'] = (bool) $comn['status'];
        $comn['test'] = (bool) $comn['test'];

        $txt = "<b>&gt;_ <i><u>".$comn['name']."</u></i></b> ".$emoji($comn['status'], $comn['test'])."\n     ";
        $txt .= ($comn['status']) ? '<b>Format:</b> <code>'.$t.$comn['cmd'].' '.$comn['format']."</code>\n\n" : '<b>Reason:</b> <i>'.$comn['msg']."</i>\n\n";

        $cmds[] = $txt;
    }
    return ['ok' => true, 'rows' => $res['count'], 'cmds' => array_chunk($cmds, $parts)];
}