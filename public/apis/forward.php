<?php

// buffer all upcoming output
ignore_user_abort(true);
ob_start();
echo('{"ok":true}');
// get the size of the output
$size = ob_get_length();

header("Content-Encoding: none\r\n");
header("Content-Length: $size");
header('Connection: close');

// flush all output
ob_end_flush();
ob_flush();
flush();

////////////////////////////////////
require '../../vendor/autoload.php';

use App\Models\Bot;
use App\Config\{ErrorLog, GetConfig};
use App\Db\Query;

ErrorLog::ActivateErrorLog('../../src/logs', 10000);
GetConfig::LoadEnV('../../');

$up = Bot::GetDatas();

$query = $up['users'] ?? null;
$query_sql = match($query) {
  'all' => "SELECT * FROM `users` WHERE `is_private` = true",
  'all_chat' => "SELECT * FROM `groups`",
  'chat_premium' => "SELECT * FROM `groups` WHERE `type` = 'premium' && `is_banned` = false",
  'chat_free' => "SELECT * FROM `groups` WHERE `type` = 'free' && `is_banned` = false",
  'free' => "SELECT * FROM `users` WHERE `status` = 'free' && `is_banned` = false && `is_private` = true",
  'premium' => "SELECT * FROM `users` WHERE `status` = 'premium' && `is_banned` = false && `is_private` = true",
  'muted' => "SELECT * FROM `users` WHERE `is_muted` = '1' && `is_private` = true",
  'banned' => "SELECT * FROM `users` WHERE `is_banned` = '1' && `is_private` = true",
  default => "SELECT * FROM `users` WHERE `tg_id` = '$query' && `is_private` = true",
};

$afect = Query::GetAllRows($query_sql);

if ($afect['count'] < 1) {
    Bot::SendMsg($up['chat_id'], 'No hay usuarios que coincidan con tu query', $up['from_msg_id']);
    exit;
}

$failed = 0;
$success = 0;
$sleep = 100000; // Microseconds
$aprox_s = $afect['count'] / (1000000 / $sleep) + 1;
$aprox_m = $aprox_s / 60;

$msg_ida = Bot::SendMsg($up['chat_id'], '<b>Enviando ' . $afect['count'] . " mensajes\nTiempo de ejecución aproximado:</b> <code>".$aprox_s."'s | ".$aprox_m."min</code>", $up['from_msg_id'])['result']['message_id'];

foreach ($afect['rows'] as $u) {
    usleep($sleep);
    $chat_id = $u['tg_id'] ?? $u['g_id'] ?? null;
    $res = Bot::copyMessage([
        'chat_id' => $chat_id,
        'from_chat_id' => $up['chat_id'],
        'message_id' => $up['msg_id'],
        'disable_notification' => true,
        'protect_content' => true,
        'allow_sending_without_reply' => true,
    ]);
    if ($res['ok'] == true) {
        $success++;
    } else {
        $failed++;
        error_log('Fail to copyMessage to chat ' . $chat_id . ': ' . $res['description']);
    }
}

Bot::EditMsgTxt($up['chat_id'], $msg_ida, 'Enviados: ' . $success . "\nFallidos: " . $failed. "\nTotal: " . $afect['count']);