<?php require __DIR__ . '/../vendor/autoload.php';

use App\Config\{
    ErrorLog,
    GetConfig,
    Lang
};
use App\Models\{
    Bot,
    Cmd,
    User
};

ErrorLog::ActivateErrorLog(dirname(__DIR__) . '/src/logs');
GetConfig::load(__DIR__ . '/../');

$up = Bot::GetDatas();
define('bot_username', $_ENV['BOT_USER']);

if (isset($up['message']['text'])) {
    // Mensajes de texto
    $mg         = $up['message'];
    $id         = $mg['from']['id'];
    $type_chat  = $mg['chat']['type'];
    $chat_id    = $mg['chat']['id'];
    $message    = $mg['text'];
    $message_id = $mg['message_id'];

    $username   = @$mg['from']['username'];
    $first_name = @$mg['from']['first_name'];
    $last_name  = @$mg['from']['last_name'];

    $cmd = Cmd::Validate($message);

    if ($cmd['format']) {

        if ($cmd['valid']) {

            switch ($cmd['access']) {
                case 'premium':$f = User::Check($id, 2, $up);break;
                case 'staff':$f = User::Check($id, 1, $up);break;
                case 'free':$f = User::Check($id, 3, $up);break;
                default:$f = User::Check($id, 3, $up);break;
            }

            $t = $message[0];
            $lang = Lang::$langs[$f['lang']];
            // Test mode
            if ($cmd['status'] && $cmd['test']) {
                if ($f['staff'] != 'user') {
                    // Verified
                    if (file_exists($cmd['route'])) {require $cmd['route'];
                    } else {NotFoundFile($chat_id, $message_id, $cmd['route']);}
                } else {
                    $msg = '<b><i>🚫 Command in testing mode </i></b>';
                    $msg .= (empty($cmd['msg'])) ? '' : "\n<b>Reason:</b> <i>" . $cmd['msg'] . "</i>";
                    Bot::SendMsg($chat_id, $msg, $message_id);
                }
            } elseif ($cmd['status'] && !$cmd['test']) {
                // Access to the command
                if (file_exists($cmd['route'])) {require $cmd['route'];
                } else {NotFoundFile($chat_id, $message_id, $cmd['route']);}
            } else {
                // Command inactive for all users
                $msg = "<i><b>⚠️ " . $t . $cmd['cmd'] . " (" . strtoupper($cmd['type']) . ") command is inactive\nLast review:</b> " . date('d/m/y - h:i A', $cmd['review']) . "</i>";
                $msg .= empty($cmd['msg']) ? '' : "\n<i><b>Reason:</b></i> <code>" . $cmd['msg'] . "</code>";
                Bot::SendMsg($chat_id, $msg, $message_id);
                die;
            }

        } elseif ($cmd['valid'] == false && $type_chat == 'private') {

            Bot::SendMsg($chat_id, "⚠️ <i><u>Alert:</u>\n- Invalid <b>command</b>, type /cmds to <b>know all commands</b></i>", $message_id);
            exit;
        }

        exit;
    }
}

if (isset($up['callback_query'])) {
    // Callback query | Botones Inline
    $call = $up['callback_query'];
    $idC = $call['from']['id']; # User id
    $usernameC = @$call['from']['username']; # Username
    $dataC = $call['data']; # content
    $chatidC = $call['message']['chat']['id']; # Chat_id
    $chatType = $call['message']['chat']['type']; # Chat type
    $messageidC = $call['message']['message_id']; # message_id
    $callback_query_id = $call['id']; #query_id

    $call_cmd = MultiExlode([' ', '|'], $dataC);

    if ($call_cmd[0] == 'finalize') {
        require 'plugins/callback/finalize.php';exit; // Eliminar un mensaje
    } elseif ($call_cmd[0] == 'cmds') {
        require 'plugins/callback/cmds.php';exit; // Comandos del bot
    } elseif ($call_cmd[0] == 'panel') {
        require 'plugins/callback/panel.php';exit; // Comandos para el staff
    } elseif ($call_cmd[0] == 'gates') {
        require 'plugins/callback/gates.php';exit; // Ver los gates disponibles
    } elseif ($call_cmd[0] == 'gen') {
        require 'plugins/callback/ccgen.php';exit; // Generar una cc
    } elseif ($call_cmd[0] == 'me') {
        require 'plugins/callback/user.php';exit; // Información del usuario (/me)
    } elseif ($call_cmd[0] == 'proxy') {
        require 'plugins/callback/proxy.php';exit; // Proxy gen
    } elseif ($call_cmd[0] == 'hit') {
        require 'plugins/callback/hit.php';exit; // Hit gen
    } elseif ($call_cmd[0] == 'fake') {
        require 'plugins/callback/fake.php';exit; // Fake data (edit caption and media)
    } elseif ($call_cmd[0] == 'extra') {
        require 'plugins/callback/extra.php';exit; // Extra search
    } elseif ($call_cmd[0] == 'mass') {
        require 'plugins/callback/mass.php';exit; // Mass view
    } elseif ($call_cmd[0] == 'bin') {
        require 'plugins/callback/bin.php';exit; // Bin info
    } elseif ($call_cmd[0] == 'gbin') {
        require 'plugins/callback/gbin.php';exit; // Gbin info
    } elseif ($call_cmd[0] == 'mail') {
        require 'plugins/callback/mail.php';exit; // Mailtm
    }
    exit;

}

if (isset($up['inline_query'])) {
    // Inline query
    $inlinequery           = $up['inline_query'];
    $query_inline          = strtolower(@$up['inline_query']['query']);
    $inline_query_id       = $up['inline_query']['id']; # id
    $inline_query_userid   = $up['inline_query']['from']['id']; # user_id
    $inline_query_username = @$up['inline_query']['from']['username']; # name

    $in_cmd = MultiExlode([' ', '|', "\n"], $query_inline);

    if ($in_cmd[0] == 'bin' || $in_cmd[0] == 'bins') {
        require 'plugins/inline/bin.php';exit; // Bin lookup
    }if ($in_cmd[0] == 'tr' || $in_cmd[0] == 'translate') {
        require 'plugins/inline/tr.php';exit; // Translate message with google api
    }if ($in_cmd[0] == 'gen' || $in_cmd[0] == 'ccgen') {
        require 'plugins/inline/gen.php';exit; // Generate credit card
    }if ($in_cmd[0] == 'price' || $in_cmd[0] == 'prices') {
        require 'plugins/inline/price.php';exit; // Bot prices
    }
    require 'plugins/inline/cmds.php';exit; // View all commands
}