<?php

use App\Models\{Bot, User};
use App\Gate\Bin;

if ($call_cmd[1] != $idC) {
    Bot::AnswerQuery($callback_query_id, "⚠️ You can't use this command");
    die('Access denied');
}

$f = User::GetUser($idC, 'tg_id', false);

if ($f['creditos'] < 5) {
    Bot::AnswerQuery($callback_query_id, "⚠️ You don't have enough credits to use this command");
    die('Insufficient credits');
}

$page = (int) $call_cmd[3];
$max = $page;
if ($call_cmd[4] > $max) {
    $max = $call_cmd[4];
}
$extra = Bin::Extras($call_cmd[2], $page, '10');

if (!$extra['ok']) {
    Bot::AnswerQuery($callback_query_id, '⚠️ '.$extra['error']);
    die($extra['error']);
}

$total_extras = count($extra['extras']);

$keyboard = ['inline_keyboard' => [
    [
        ['text' => '⬅️ Previous page', 'callback_data' => 'extra '.$idC.'|'.$call_cmd[2].'|'.($page-1).'|'.$max],
        ['text' => 'Next page ➡️', 'callback_data' => 'extra '.$idC.'|'.$call_cmd[2].'|'.($page + 1).'|'.$max],
    ], [
        ['text' => 'Bin Info ♻️', 'callback_data' => 'bin '.$call_cmd[2]]
    ]
]];

if ($total_extras < 10) {
    unset($keyboard['inline_keyboard'][0][1]);
}
if ($call_cmd[3] == '0') {
    $keyboard = ['inline_keyboard' => [
        [
            ['text' => 'Next page ➡️', 'callback_data' => 'extra '.$idC.'|'.$call_cmd[2].'|'.($page + 1).'|'.$max],
        ], [
            ['text' => 'Bin Info ♻️', 'callback_data' => 'bin '.$call_cmd[2]]
        ]
    ]];
}

if ($call_cmd[3] > $call_cmd[4]) {
    Bot::AnswerQuery($callback_query_id, "⚠️ -1 credit\nYour credits: ".$f['creditos']-1);
    User::Update($idC, $f['status'], $f['staff'], $f['creditos'] - 1, $f['save_live'], $f['member_expired'], $f['credit_expired'], $f['apodo'], $f['antispam']);
}

$txt = "<i><u>Page: ".$page."</u>  | <u>Took: ".User::GetTook(true, 3)."</u>  | <u>Results:</u> ".$total_extras."</i>\n\n".implode("\n",$extra['extras']);
Bot::EditMsgTxt($chatidC, $messageidC, $txt, $keyboard);