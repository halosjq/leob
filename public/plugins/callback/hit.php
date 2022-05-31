<?php 
use App\Models\Bot;
use App\Models\User;

if ($call_cmd[1] != $idC) {
    Bot::AnswerQuery($callback_query_id, '⚠️ Access denied'); exit;
}

$type      = $call_cmd[2];
$file_name = './files/hits/' . $type . '.txt';
$hits      = file($file_name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if (empty($hits)) {
    Bot::AnswerQuery($callback_query_id, '⚠️ No hits found ' . $type); exit;
}

$hit_id = array_rand($hits);
$hit    = json_decode($hits[$hit_id], true);

$discount = 5;

switch ($type) {
    case 'crunchy_roll':
        $txt = "<b>CrunchyRoll:\n\t- Mail: <code>".$hit['email']."</code>\n\t- Pass: <code>".$hit['pass']."</code>\n\t- Plan: <code>".$hit['plan']."</code>\n\t- Payment:</b> <code>".$hit['payment']."</code>";
        $discount = 7;
        break;
    case 'acorntv':
        $txt = "<b>Acorn Tv:\n\t- Code: <code>".$hit['code']."</code>\n\t- Bonus: <code>".$hit['bonus']."</code>\n\t- Plan: <code>".$hit['plan']."</code>\n\t- BonusTerm: <code>".$hit['BonusTerm']."</code>\n\t- Trial:</b> <code>".$hit['trial']."</code>";
        break;
    case 'flixole':
        $txt = "<b>FlixOle:\n\t- Mail: <code>".$hit['email']."</code>\n\t- Pass:</b> <code>".$hit['pass']."</code>";
        break;
    case 'disney':
        $txt = "<b>Disney+:\n\t- Mail: <code>".$hit['email']."</code>\n\t- Pass: <code>".$hit['pass']."</code>\n\t- Plan: <code>".$hit['plan']."</code>\n\t- LastConnection:</b> <code>".$hit['lastconnection']."</code>";
        $discount = 7;
        break;
    case 'mail_access':
        $txt = "<b>Mail Access:\n\t- Mail: <code>".$hit['email']."</code>\n\t- Pass:</b> <code>".$hit['pass']."</code>";
        break;
    case 'fox':
        $txt = "<b>Fox:\n\t- Mail: <code>".$hit['email']."</code>\n\t- Pass: <code>".$hit['pass']."</code>\n\t- Name: <code>".$hit['name']."</code>\n\t- Acc type: <code>".$hit['acc_type']."</code>\n\t- User type: <code>".$hit['user_type']."</code>\n\t- Brand: <code>".$hit['brand']."</code>\n\t- Platform: <code>".$hit['platform']."</code>\n\t- Verified: <code>".$hit['verified']."</code>\n\t- Device:</b> <code>".$hit['device']."</code>";
        $discount = 2;
        break;
    case 'patreon':
        $txt = "<b>Patreon:</b>\n\t";
        break;
    case 'netflix':
        $txt = "<b>Netflix:\n\t</b>";
        $discount = 10;
        break;
    case 'vpn':
        $txt = "<b>Vpn:\n\t- Mail: <code>".$hit['email']."</code>\n\t- Pass: <code>".$hit['pass']."</code>\n\t- Type:</b> <code>".$hit['type']."</code>";
        $discount = 5;
        break;
    case 'telecentro':
        $txt = "<b>Telecentro:\n\t</b>";
        $discount = 6;
        break;
    case 'xnxx':
        $txt = "<b>Xnxx:\n\t- Mail: <code>".$hit['email']."</code>\n\t- Pass:</b> <code>".$hit['pass']."</code>";
        $discount = 3;
        break;
}

$f = User::Check($idC, 3, $up);
if ($f['creditos'] < $discount) {
    Bot::AnswerQuery($callback_query_id, '⚠️ You don\'t have enough credits'); exit;
}

$button = ['inline_keyboard' => [[['text' => 'Gen again ♻️', 'callback_data' => 'hit '.$idC.'|'.$type],['text' => 'Delete 🗑️', 'callback_data' => 'finalize '.$idC]]]];
Bot::AnswerQuery($callback_query_id, 'Loading hits, please wait'.PHP_EOL.'-'.$discount.' credit');
Bot::EditMsgTxt($chatidC, $messageidC, $txt, $button);

User::Update($idC, $f['status'], $f['staff'], $f['creditos'] - $discount, $f['save_live'], $f['member_expired'], $f['credit_expired'], $f['apodo'], $f['antispam']);

// Delete hit and put in file
unset($hits[$hit_id]);
file_put_contents($file_name, implode(PHP_EOL, $hits));