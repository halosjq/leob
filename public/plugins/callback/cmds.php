<?php

use App\Models\{Bot, User, Cmd};

$f = User::Check($idC, 3, $up);

if ($call_cmd[1] != $idC) {
    Bot::AnswerQuery($callback_query_id, "❌ Access denied\n - Use your own command"); exit;
}

$keyboard_main = [
    [
        ['text' => 'Tools 🌀', 'callback_data' => 'cmds ' . $idC . '|tools|0'],
        ['text' => 'Gates 💳', 'callback_data' => 'cmds ' . $idC . '|gates'],
        ['text' => 'Others ⚙️', 'callback_data' => 'cmds ' . $idC . '|others|0'],
    ], [
        ['text' => 'Channel', 'url' => 'https://t.me/Kirarichk'],
        ['text' => 'Extras 🧰', 'callback_data' => 'cmds ' . $idC . '|extras|0'],
        ['text' => 'Finish', 'callback_data' => 'finalize|' . $idC],
    ],
];

$level_staff = strtolower($f['staff']);

$t = (isset($up['callback_query']['message']['reply_to_message']['text'])) ? $up['callback_query']['message']['reply_to_message']['text'][0] : '/';

// "RETURN"
if (!isset($call_cmd[2]) || empty($call_cmd[2])) {
    
    switch ($level_staff) {
        case 'owner'  : $keyboard_main[2][0] = ['text' =>'Cmds Staff 🔏', 'callback_data' => 'panel '.$idC.'|owner']; break;
        case 'admin'  : $keyboard_main[2][0] = ['text' =>'Cmds Staff 🔏', 'callback_data' => 'panel '.$idC.'|admin']; break;
        case 'seller' : $keyboard_main[2][0] = ['text' =>'Cmds Staff 🔏', 'callback_data' => 'panel '.$idC.'|seller']; break;
        case 'helper' : $keyboard_main[2][0] = ['text' =>'Cmds Staff 🔏', 'callback_data' => 'panel '.$idC.'|helper']; break;
        case 'mod'    : $keyboard_main[2][0] = ['text' =>'Cmds Staff 🔏', 'callback_data' => 'panel '.$idC.'|mod']; break;
    }

    Bot::EditMsgTxt($chatidC, $messageidC, User::GetGreeting($f['lang'], $f['first_name'], $f['last_name']), ['inline_keyboard' => $keyboard_main]);
    exit;
}

$keyboard_return = ['inline_keyboard' => [[['text' => '🔙 Return', 'callback_data' => 'cmds '.$idC.'|']]]];
$keyboard_back = ['inline_keyboard' => [[['text' => 'Back', 'callback_data' => 'cmds '.$idC.'|']]]];

if ($call_cmd[2] == 'tools') {
    
    $page = (int) $call_cmd[3];
    $cmds = Cmd::GetAll($t);
    if (!$cmds['ok']) {
        Bot::EditMsgTxt($chatidC, $messageidC, $cmds['msg'], $keyboard_return);
        exit;
    }

    if (isset($cmds['cmd'][$page+1])) {
        $keyboard_back['inline_keyboard'][0][] = ['text' => 'Next ➡️', 'callback_data' => 'cmds '.$idC.'|tools|'.($page+1)];
    }

    $txt = "<b><u>Tools all</u> (".$cmds['count']."):</b>\n\n";
    $txt .= implode('', $cmds['cmd'][$page]);
    Bot::EditMsgTxt($chatidC, $messageidC, $txt, $keyboard_back); exit;

} elseif ($call_cmd[2] == 'gates') {
    $type = @$call_cmd[3];
    if ($type == 'f') {
        $page = (int) ($call_cmd[4] ?? 0);
        $cmds = Cmd::GetAll($t, 'gates', 'free');
        if (!$cmds['ok']) {
            $a = Bot::EditMsgTxt($chatidC, $messageidC, $cmds['msg'], $keyboard_return);
            exit;
        }
        $keyboard_back['inline_keyboard'][0][0]['callback_data'] = 'cmds '.$idC.'|gates|0';
        if (isset($cmds['cmd'][$page+1])) {
            $keyboard_back['inline_keyboard'][0][] = ['text' => 'Next ➡️', 'callback_data' => 'cmds '.$idC.'|gates|f|'.($page+1)];
        }

        $txt = "<b><u>Gates Free</u> (".$cmds['count']."):</b>\n\n";
        $txt .= implode('', $cmds['cmd'][$page]);
        Bot::EditMsgTxt($chatidC, $messageidC, $txt, $keyboard_back); exit;
        
    } elseif ($type == 'p') {
        
        $page = (int) ($call_cmd[4] ?? 0);
        $cmds = Cmd::GetAll($t, 'gates', 'premium');
        if (!$cmds['ok']) {
            $a = Bot::EditMsgTxt($chatidC, $messageidC, $cmds['msg'], $keyboard_return);
            exit;
        }
        $keyboard_back['inline_keyboard'][0][0]['callback_data'] = 'cmds '.$idC.'|gates|0';
        if (isset($cmds['cmd'][$page+1])) {
            $keyboard_back['inline_keyboard'][0][] = ['text' => 'Next ➡️', 'callback_data' => 'cmds '.$idC.'|gates|p|'.($page+1)];
        }

        $txt = "<b><u>Gates Premium</u> (".$cmds['count']."):</b>\n\n";
        $txt .= implode('', $cmds['cmd'][$page]);
        Bot::EditMsgTxt($chatidC, $messageidC, $txt, $keyboard_back); exit;

    } else {
        Bot::EditMsgTxt($chatidC, $messageidC, "<b><i>Gates Free:</i></b> For all users\n<b><i>Gates Premium:</i></b> Only for premium user or users with credits", ['inline_keyboard' => [
            [['text' => 'Gates Free', 'callback_data' => 'cmds '.$idC.'|gates|f|0'], ['text' => 'Gates Premium', 'callback_data' => 'cmds '.$idC.'|gates|p|0']],
            [['text' => '🔙 Return ', 'callback_data' => 'cmds '.$idC.'|']],
        ]]);
    }
} elseif ($call_cmd[2] == 'others') {
    
    $page = (int) $call_cmd[3];
    $cmds = Cmd::GetAll($t, 'others');
    if (!$cmds['ok']) {
        Bot::EditMsgTxt($chatidC, $messageidC, $cmds['msg'], $keyboard_return);
        exit;
    }

    if (isset($cmds['cmd'][$page+1])) {
        $keyboard_back['inline_keyboard'][0][] = ['text' => 'Next ➡️', 'callback_data' => 'cmds '.$idC.'|others|'.($page+1)];
    }

    $txt = "<b><u>Others all</u> (".$cmds['count']."):</b>\n\n";
    $txt .= implode('', $cmds['cmd'][$page]);
    Bot::EditMsgTxt($chatidC, $messageidC, $txt, $keyboard_back); exit;

} elseif ($call_cmd[2] == 'extras') {
    
    $page = (int) $call_cmd[3];
    $cmds = Cmd::GetAll($t, 'extras');
    if (!$cmds['ok']) {
        Bot::EditMsgTxt($chatidC, $messageidC, $cmds['msg'], $keyboard_return);
        exit;
    }

    if (isset($cmds['cmd'][$page+1])) {
        $keyboard_back['inline_keyboard'][0][] = ['text' => 'Next ➡️', 'callback_data' => 'cmds '.$idC.'|extras|'.($page+1)];
    }

    $txt = "<b><u>Tools all</u> (".$cmds['count']."):</b>\n\n";
    $txt .= implode('', $cmds['cmd'][$page]);
    Bot::EditMsgTxt($chatidC, $messageidC, $txt, $keyboard_back); exit;

} else {
    switch ($level_staff) {
        case 'owner'  : $keyboard_main[2][0] = ['text' =>'Cmds Staff 🔏', 'callback_data' => 'panel '.$idC.'|owner']; break;
        case 'admin'  : $keyboard_main[2][0] = ['text' =>'Cmds Staff 🔏', 'callback_data' => 'panel '.$idC.'|admin']; break;
        case 'seller' : $keyboard_main[2][0] = ['text' =>'Cmds Staff 🔏', 'callback_data' => 'panel '.$idC.'|seller']; break;
        case 'helper' : $keyboard_main[2][0] = ['text' =>'Cmds Staff 🔏', 'callback_data' => 'panel '.$idC.'|helper']; break;
        case 'mod'    : $keyboard_main[2][0] = ['text' =>'Cmds Staff 🔏', 'callback_data' => 'panel '.$idC.'|mod']; break;
    }

    Bot::EditMsgTxt($chatidC, $messageidC, User::GetGreeting($f['lang'], $f['first_name'], $f['last_name']), ['inline_keyboard' => $keyboard_main]);
    exit;
}
