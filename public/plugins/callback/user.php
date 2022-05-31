<?php

use App\Models\{Bot, User};
use App\Config\{StringUtils as Utils, Flag, Lang};

if ($idC != $call_cmd[1]) {
    Bot::AnswerQuery($callback_query_id, "❌ Access denied\n - Use your own command");
    exit;
}

$f = User::Check($call_cmd[1], '1', $up);
$lang = Lang::$langs[$f['lang']];
$action = $call_cmd[2] ?? null;

if ($action == 'live') {
    // Change live config
    //Bot::AnswerQuery($callback_query_id, json_encode($call_cmd));
    $live = $call_cmd[3] != '1' ? true : false; // !Live change
    $txt = $live ? '✅' : '❌';
    $msg = $live ? 'Save live ' . $txt : 'Dont save live' . $txt;
    $action = $call_cmd[4] ?? null;
    if ($action == null) {
        $txt = '<b>Actual config save is:</b> <i>'.(!$live ? 'True' : 'False').'</i>';
        Bot::EditMsgTxt($chatidC, $messageidC, $txt, ['inline_keyboard' => [[['text' => $msg, 'callback_data' => 'me '.$idC.'|live|'.$call_cmd[3].'|confirm'],['text' => 'Return', 'callback_data' => 'me ' . $idC . '|cancel']]]]);
    } elseif ($action == 'confirm') {
        $txt = '<b>Error</b>';
        if (User::SaveLive($idC, $live)) {
            $txt = '<b>Live config saved</b>';
        }
        Bot::EditMsgTxt($chatidC, $messageidC, $txt, ['inline_keyboard' => [[['text' => 'Return', 'callback_data' => 'me ' . $idC . '|cancel']]]]);

    }
} elseif ($action == 'lang') {
    // Change lang config
    $de_lang = $f['lang'];
    if (!isset($call_cmd[3]) || empty($call_cmd[3])) {
        $txt = '<i>Actual lang is</i> ' . ucfirst($de_lang) . ' ' . Flag::Emoji($de_lang) . "\n\n<b>Select new lang:</b>";
        unset(Lang::$langs[$f['lang']]);
        $button = array();
        $contador = 0; $ic = 0;
        foreach (Lang::$langs as $key => $item) {
            if ($ic % 2 == 0) {
                $button['inline_keyboard'][$contador][0] = ['text' => ucfirst($key) . ' ' . Flag::Emoji($key), 'callback_data' => 'me ' . $idC . '|lang|' . $key];
            } else {
                $button['inline_keyboard'][$contador][1] = ['text' => ucfirst($key) . ' ' . Flag::Emoji($key), 'callback_data' => 'me ' . $idC . '|lang|' . $key];
                $contador++;
            } $ic++;
        }
        $button['inline_keyboard'][$contador][] = ['text' => 'Cancel', 'callback_data' => 'me ' . $idC . '|cancel|cancel'];
        Bot::EditMsgTxt($chatidC, $messageidC, $txt, $button);
    } else {
        $new_lang = $call_cmd[3];
        $con_lang = $call_cmd[4] ?? null;
        if (isset(Lang::$langs[$new_lang]) && $con_lang != 'confirm') {
            $txt = '<i>Actual lang is</i> ' . ucfirst($de_lang) . ' ' . Flag::Emoji($de_lang) . "\n\n<b>Change to</b> " . ucfirst($new_lang) . ' ' . Flag::Emoji($new_lang) . "\n\n<b>Confirm?</b>";
            $button = array();
            $button['inline_keyboard'][0][] = ['text' => 'Yes', 'callback_data' => 'me ' . $idC . '|lang|' . $new_lang . '|confirm'];
            $button['inline_keyboard'][1][] = ['text' => 'Cancel', 'callback_data' => 'me ' . $idC . '|cancel|cancel'];
            Bot::EditMsgTxt($chatidC, $messageidC, $txt, $button);
        } elseif (isset(Lang::$langs[$new_lang]) && $con_lang == 'confirm') {
            // Change lang
            $f['lang'] = $new_lang;
            $u = User::UpdateLang($f['id'], $f['lang']);
            if ($u['ok']) {
                Bot::AnswerQuery($callback_query_id, "✅ Lang changed to " . ucfirst($new_lang) . ' ' . Flag::Emoji($new_lang));
            }
            Bot::EditMsgTxt($chatidC, $messageidC, '<i>Actual lang is</i> ' . ucfirst($new_lang) . ' ' . Flag::Emoji($new_lang), ['inline_keyboard' => [[['text' => 'Return', 'callback_data' => 'me ' . $idC . '|cancel']]]]);
        } else {
            Bot::AnswerQuery($callback_query_id, "❌ Invalid lang");
        }
    }
} else {
    $member_expired = 'No membership';
    if ($f['member_expired'] > 0) {
        $member_expired = Utils::TimeToString($f['member_expired']-time(), '%d days, %h hours and %m minutes');
    }
    $last_check = 'Never';
    if ($f['last_check'] > 0){
        $last_check = date('D, j M Y', $f['last_check']);
    }

    $auth = $f['is_private'] ? 'Yes' : 'No';
    $_live = $f['save_live'] ? 'Yes' : 'No';
    $_ref = ($f['ref_of'] != '0') ? User::Mention('', $f['ref_of'], $f['ref_of']) : 'No';

    $me = sprintf($lang['me'], $idC, $f['permalink'], $f['apodo'], ucfirst($f['status']), ucfirst($f['staff']), $f['username'], $f['creditos'], $member_expired, $f['warns'], $auth, $f['antispam']."'", $last_check, ucfirst($f['lang']) . ' ' . Flag::Emoji($f['lang']), $_live, $_ref);
    Bot::EditMsgTxt($chatidC, $messageidC, $me, ['inline_keyboard' => [
        [['text' => EmojiBool(!$f['save_live']) . ' Change save live', 'callback_data' => 'me ' . $idC . '|live|'.(int) $f['save_live'] ],
        ['text' => 'Lang ('.Flag::Emoji($f['lang']).')', 'callback_data' => 'me ' . $idC . '|lang']]
    ]]);
    exit;
}

function EmojiBool(bool $bool) {
    return $bool ? '✅' : '❌';
}
