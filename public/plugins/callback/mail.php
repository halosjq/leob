<?php

use App\Models\{Bot, Mail};
use App\Config\MailTm;
use App\Config\StringUtils;

if ($idC != $call_cmd[1]) {
    Bot::AnswerQuery($callback_query_id, '❌ Access denied'); exit;
}

$mail = Mail::Get($call_cmd[2]);

if (!$mail['ok']) {
    Bot::AnswerQuery($callback_query_id, '⚠️ Account delete'.PHP_EOL.'All mail accounts that are 10 days old are automatically deleted'); exit;
}

if ($call_cmd[3] == 'main') {
    Bot::AnswerQuery($callback_query_id, 'Main panel loaded', false);
    Bot::EditMsgTxt($chatidC, $messageidC, "<b>Mail: <code>".$mail['mail']."</code>\nPass: <code>".$mail['pass']."</code>\nAccount id:</b> <code>".$mail['acc_id']."</code>", ['inline_keyboard' => [
        [['text' => '📥 Imbox', 'callback_data' => 'mail ' . $idC . '|' . $mail['id'] . '|dm|1'], ['text' => '🗑 Delete', 'callback_data' => 'mail ' . $idC . '|' . $mail['id'] . '|del']],
        [['text' => '🌐 Login', 'url' => 'https://mail.tm/']],
    ]]);
    exit;
}

if ($call_cmd[3] == 'dm') {
    $page = $call_cmd[4];
    $msgs = MailTm::GetMessage($page, $mail['token']);
    
    if (!$msgs['ok']) {Bot::AnswerQuery($callback_query_id, '⚠️ Network error'); exit;}

    $msg = $msgs['body'];
    $total = count($msgs);
    if (empty($msg)) {Bot::AnswerQuery($callback_query_id, '⚠️ No messages'); exit;}

    $button = array();
    foreach ($msg as $i => $item) {
        $title = (empty($msg[$i]['subject'])) ? 'No subject' : $msg[$i]['subject'];
        $title = ($i+1) . '. ' . $title;
        $button['inline_keyboard'][$i][0] = ['text' => $title, 'callback_data' => 'mail ' . $idC . '|' . $mail['id'] . '|ib|'.$msg[$i]['id'] ];
    }
    $button['inline_keyboard'][][0] = ['text' => 'Return', 'callback_data' => 'mail ' . $idC . '|' . $mail['id'] . '|main'];

    Bot::AnswerQuery($callback_query_id, '✅ Messages loaded', false);
    Bot::EditMsgTxt($chatidC, $messageidC, "<b>Mail: <code>".$mail['mail']."</code>\nPass: <code>".$mail['pass']."</code>\nAccount id:</b> <code>".$mail['acc_id']."</code>", $button);
    exit;
}

if ($call_cmd[3] == 'ib') {
    
    $msg = MailTm::GetMessageId($call_cmd[4], $mail['token']);
    if (!$msg['ok']) {Bot::AnswerQuery($callback_query_id, '⚠️ Network error'); exit;}

    $msg = $msg['body'];
    $from = $msg['from'];
    $subject = $msg['subject'];
    $text = $msg['text'];
    $date = $msg['updatedAt'];

    $txt = "*Subject:* ".$subject."\n*From:* _".$from['name']." <".$from['address'].">_\n*Date:* _".$date."_\n\n*Text:* ".StringUtils::QuitMarkdown($text, '');
    Bot::AnswerQuery($callback_query_id, '✅ Message loaded', false);
    Bot::SendMsg($chatidC, $txt, $messageidC, null, 'markdown');

    MailTm::DeleteMessageId($call_cmd[4], $mail['token']);
    exit;
}
if ($call_cmd[3] == 'del') {
    MailTm::Delete($mail['token'], $mail['acc_id']);
    Mail::Delete($mail['id']);

    Bot::AnswerQuery($callback_query_id, '✅ Account delete');
    Bot::EditMsgTxt($chatidC, $messageidC, '<b>✅ Account delete</b>');
}