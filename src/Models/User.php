<?php

namespace App\Models;

use App\Config\{GetConfig, Lang, StringUtils};
use App\Db\Query;
use App\Models\{Bot, Chat, Cmd};

class User
{

    public static $U_id;
    public static $U_username;
    public static $U_first_name;
    public static $U_last_name;
    public static $U_language_code;
    public static $U_type_chat;
    public static $user;

    /**
     * Obtener un usuario de la db, se puede especificar la columna a buscar
     * @return array
     */
    final public static function GetUser(string $id, string $from = 'tg_id', bool $set_user = true)
    {

        $datas = Query::Sql("SELECT * FROM users WHERE $from = :id_user", [':id_user' => $id]);

        if ($datas['ok']) {

            if (!$set_user) {
                $datas['datas']['ok'] = true;
                return $datas['datas'];
            }

            self::$user = $datas['datas'];

            self::$user['ok'] = $datas['ok'];
            self::$user['afectRow'] = $datas['afectRow'];
            self::$user['id'] = self::$user['tg_id'];
            self::$user['creditos'] = (float) self::$user['creditos'];
            self::$user['n_ref'] = (int) self::$user['n_ref'];
            self::$user['last_reset'] = (float) self::$user['last_reset'];
            self::$user['n_check'] = (int) self::$user['n_check'];
            self::$user['mention'] = self::Mention(self::$user['username'], self::$user['first_name'] . ' ' . self::$user['last_name'], self::$user['id']);
            self::$user['permalink'] = '<a href="tg://user?id='.self::$user['tg_id'].'">'.self::$user['first_name'].' '.self::$user['last_name'].'</a>';
            self::$user['save_live'] = (bool) self::$user['save_live'];
            self::$user['is_private'] = (bool) self::$user['is_private'];
            self::$user['is_muted'] = (bool) self::$user['is_muted'];
            self::$user['is_banned'] = (bool) self::$user['is_banned'];
            self::$user['member_expired'] = (int) self::$user['member_expired'];
            self::$user['credit_expired'] = (int) self::$user['credit_expired'];
            self::$user['tmp_file'] = 'tmp_' . substr(md5(rand()), 0, 10) . '.txt';
            self::$user['init_time'] = microtime(true);
            
            return self::$user;
        } else {
            return $datas;
        }
    }

    /**
     * Obtener una mención de un usuario
     * @return string
     */
    public static function Mention($username, string $names, string $id, $mode = 'html')
    {
        if (empty($username)) {
            $mention = match($mode) {
                'html' => "<a href='tg://user?id=$id'>$names</a>",
                'markdown' => "[$names](tg://user?id=$id)"
            };
        } else {
            $mention = $username;
        }
        return $mention;
    }

    /**
     * Actualizar el name, last y username siempre en cuando estos sean diferentes al anterior
     */
    private static function UpdateName($first_name, $last_name, $username, $id, array $last)
    {
        $username = ($username) ? '@' . $username : null;
        if ($first_name != $last['first_name'] || $last_name != $last['last_name'] || $username != $last['username']) {
            // Update name
            $query = "UPDATE users SET first_name = :fname, last_name = :lname, username = :uname WHERE tg_id = :tgid";
            $params = [':fname' => $first_name, ':lname' => $last_name, ':uname' => $username, ':tgid' => $id];
            Query::Sql($query, $params);
        }
    }

    /**
     * Obtener el lenguaje del usuario siempre en cuando este este disponible
     * @return string
     */
    public static function Getlang($lang_code)
    {

        $langs = Lang::GetLangs()['data'];
        if (in_array($lang_code, $langs)) {
            return $lang_code;
        } else {
            return GetConfig::Get('DEF_LANG');
        }
    }

    /**
     * Establecer los datos
     */
    private static function Setter(string $id, string $name, string $last, $username, $language_code, $type_chat)
    {
        self::$U_id = $id;
        self::$U_username = ($username) ? '@' . $username : null;
        self::$U_first_name = $name;
        self::$U_last_name = $last;
        self::$U_language_code = $language_code;
        self::$U_type_chat = $type_chat;
    }

    /**
     * Registrar un usuario nuevo en la DB
     * @return array
     */
    final public static function Register(string $id, $name, $last, $username, string $lang, string $type_chat)
    {
        self::Setter($id, $name, $last, $username, $lang, $type_chat);
        $type_chat = ($type_chat == 'private');
        $query = "INSERT INTO users (tg_id, first_name, last_name, username, lang, is_private, register_date, last_check) VALUES (:id, :firstname, :lastname, :username, :lang, :is_private, :register, :last_check)";
        $data = [':id' => self::$U_id, ':firstname' => $name, ':lastname' => $last, ':username' => self::$U_username, ':lang' => self::$U_language_code, ':is_private' => $type_chat, ':register' => time(), ':last_check' => time()-60];
        Query::Sql($query, $data);
        return self::GetUser($id);
    }

    /**
     * Verificar al usuario y al chat(solo si el usuario es free)
     *
     * @param string $id Id del usuario
     * @param string $type 1: Comandos solo para el staff, 2: Solo para usuarios premium, 3: Todos
     * @param array $up Datos de telegram
     */
    final public static function Check(string $id, int $type, array $up): array
    {
        $data = self::GetUser($id);

        if (isset($up['callback_query'])) {
            # Botones
            $call_id = $up['callback_query']['id'];

            if ($data['ok'] == false) {
                Bot::AnswerQuery($call_id, "⚠️ You are not registered\nSend /register in private chat");
                die;
            }if ($data['is_muted']) {
                Bot::AnswerQuery($call_id, "You are muted ❌");
                die;
            }if ($data['is_banned']) {
                Bot::AnswerQuery($call_id, "You are banned ❌");
                die;
            }if ($up['callback_query']['message']['chat']['type'] == 'private' && $data['status'] == 'free' && $data['creditos'] <= 5) {
                Bot::AnswerQuery($call_id, "⚠️ Only premium users can use the bot in private chat\n\n- Buy credits or a membership to be able to use it");
                die;
            }
        } else {
            # Mensajes de texto
            $name = StringUtils::QuitHtml(@$up['message']['from']['first_name']);
            $last = StringUtils::QuitHtml(@$up['message']['from']['last_name']);
            $username = @$up['message']['from']['username'];
            $chat_type = $up['message']['chat']['type'];
            $chat_id = $up['message']['chat']['id'];
            $msg_id = $up['message']['message_id'];

            if ($data['ok'] == false) {
                $data = self::Register($id, $name, $last, $username, self::Getlang(@$up['message']['from']['language_code']), $chat_type);
            }

            self::UpdateName($name, $last, $username, $id, $data);
            self::CheckBanned($data, $chat_id, $msg_id);
            self::CheckMuted($id, $data, $chat_id, $msg_id);
            self::CheckWarn($data, $chat_id, $msg_id);
            self::CheckExpireMember($data, $chat_id, $msg_id);
            self::CheckExpireCredit($data, $chat_id, $msg_id);
            self::BlockNationalities($data);

            if ($data['status'] == 'free') {
                self::Antiflood($data, $chat_id, $msg_id);
                $data = Chat::Check($chat_id, $data, $chat_type);

                if (($chat_type == 'private' && $data['creditos'] <= 15) && !Cmd::Is('start|claim|register')) {
                    Bot::SendMsg($chat_id, "<i><b><u>⚠️ Only premium users can use the bot in private chat</u></b>\n\n- Buy credits or a membership to be able to use it</i>", $msg_id, ['inline_keyboard' => [[['text' => '👉 Get access 👈', 'url' => 'https://t.me/+UoaOCtRJ6Gk1Y2Zh']]]]);
                    die();
                }
            }

            if ($type == 1 && $data['staff'] == 'user') {
                Bot::SendMsg($chat_id, "<b><i>Only for staff members</i></b>", $msg_id);die;
            }
            if ($type == 2 && $data['status'] == 'free') {
                Bot::SendMsg($chat_id, "<b><i>Only for premium users</i></b>", $msg_id, ['inline_keyboard' => [[['text' => 'About premium access 💰', 'url' => 'https://t.me/' . bot_username . '?start=premium-' . $id]]]]);die;
            }

        }
        return $data;
    }

    /**
     * Acciones a realizar si el usuario esta baneado
     */
    private static function CheckMuted(string $id, array $data, $chat_id, $msg_id)
    {
        if ($data['is_muted']) {
            if ($data['muted'] - time() <= 0) {
                # Unmute
                Bot::SendMsg($id, "<i>🔊 You can talk now</i>");
                $time = time();
                Query::Sql("UPDATE users SET muted = :tmute, is_muted = :smute WHERE tg_id = :id", [':tmute' => $time, ':smute' => false, ':id' => $id]);
            } else {
                # Mute
                $restTime = $data['muted'] - time();
                $txt = sprintf(Lang::$langs[$data['lang']]['muted'], date('m/d/Y - h:i A', $data['muted']), $restTime);
                Bot::SendMsg($chat_id, $txt, $msg_id);
                die();
            }
        }
    }

    /**
     * Acción a realizar si el usuario esta baneado
     */
    private static function CheckBanned(array $data, $chat_id, $msg_id)
    {
        if ($data['is_banned']) {
            $msg = Lang::$langs[$data['lang']]['banned'];
            $txt = '<b><i>' . $msg . '</i></b>';
            $txt .= (empty($data['msg'])) ? '' : "\n<b>Reason:</b> <i>" . $data['msg'] . "</i>";
            Bot::SendMsg($chat_id, $txt, $msg_id);
            die();
        }
    }

    /**
     * Mutear al usuario si tiene 3 o mas warns
     */
    private static function CheckWarn(array $data, $chat_id, $msg_id)
    {
        $mx_warn = GetConfig::Get('MAX_WARN');
        if ($data['warns'] >= $mx_warn) {
            $time = time() + GetConfig::Get('MUTED_TIME');
            Bot::SendMsg($chat_id, "<i>🔇 You are muted for 3 hours <u>(Max numbers of warns)</u></i>", $msg_id);
            $query = "UPDATE users SET warns = 0, muted = :tmute, is_muted = :smute, msg = :msg WHERE tg_id = :id";
            $data = [':tmute' => $time, ':smute' => true, ':msg' => 'Muted because reached the maximum number of warns(' . $mx_warn . ')', ':id' => $data['tg_id']];
            Query::Sql($query, $data);
            die();
        }
    }

    /**
     * Añadir warns al usuario
     */
    public static function AddWarn(array $data, int $cant): bool
    {
        $warns = $data['warns'] + $cant;
        $query = "UPDATE users SET warns=:warn WHERE tg_id=:id";
        return Query::Sql($query, [':warn' => $warns, ':id' => $data['id']])['ok'];
    }

    /**
     * Verificar la membresia del usuario
     */
    private static function CheckExpireMember(array $data): void
    {
        if ($data['member_expired'] != 0 && $data['member_expired'] <= time()) {
            Bot::SendMsg($data['id'], "<i>💸 Your membership has expired</i>");
            $query = "UPDATE users SET member_expired = 0, apodo = 'Free User', status = 'free', antispam = 60 WHERE tg_id = :id";
            Query::Sql($query, [':id' => $data['tg_id']]);
        }
    }

    /**
     * Verificar la expiración de los creditos
     */
    private static function CheckExpireCredit(array $data)
    {
        if ($data['credit_expired'] != 0 && $data['credit_expired'] <= time()) {
            Bot::SendMsg($data['id'], "<i>💸 Your credits have expired</i>");
            $query = "UPDATE users SET credit_expired = 0, creditos = 0 WHERE tg_id = :id";
            Query::Sql($query, [':id' => $data['tg_id']]);
        }
    }

    /**
     * Add one warn is the user send much messages
     */
    private static function Antiflood(array $data, $chat_id, $msg_id): void
    {
        if ($_ENV['ANTIFLOOD'] == false) {
            return;
        }

        $n_msg = $data['n_msg'] + 1;
        $date = time();

        Query::Sql("UPDATE users SET date_time=:date_time, n_msg=:n_msg WHERE tg_id = :id", [':date_time' => $date, ':n_msg' => $n_msg, ':id' => $data['id']]);

        if ($date < $data['date_time'] + $_ENV['ANTIFLOOD_TIME'] && $data['n_msg'] >= $_ENV['ANTIFLOOD_MSG']) {
            // Antiflood active
            $warns = $data['warns']++;
            Query::Sql("UPDATE user SET date_time=:date_time, n_msg=:n_msg, warns=:warns WHERE tg_id=:id", [':date_time' => 0, ':n_msg' => 0, 'warns' => $warns, ':id' => $data['id']]);
            Bot::SendMsg($chat_id, '<b><i>[ANTI FLOOD]</i> + 1 warn :)</b>', $msg_id);
            die();
        }if ($date > $data['date_time'] + $_ENV['ANTIFLOOD_TIME']) {
            // Reset antiflood
            Query::Sql("UPDATE users SET date_time=:date_time, n_msg=:n_msg WHERE tg_id = :id", [':date_time' => $date, ':n_msg' => 0, ':id' => $data['id']]);
        }

    }

    /**
     * Check antispam for gates
     */
    public static function AntiSpam(array $user): array
    {
        $lastcheck = $user['last_check'] ?? time()-100;
		$init_time = $user['init_time'];

        $antispam = GetConfig::Get('ANTISPAM');
        $owners = array(1663456505,1767091122,5129448944);
        $time_spam = in_array($user['id'], $owners) ? 1 : $antispam;

        $dest = $init_time - $lastcheck;

        if ($dest < $time_spam) {
			return ['ok' => false, 'msg' => '<b><u>ANTI SPAM:</u> use this comand in <i>'.round($time_spam - $dest, 2)."</i>'s</b>"];
		}
        return ['ok' => true, 'msg' => 'null'];
    }
    /**
     * Verificar el numero de checks del usuario
     */
    final public static function IsMaxChecks(array $data, string $chat_id, string $msg_id): void
    {
        $check = GetConfig::Get('CHK_LIMIT');
        $reset = $data['last_reset'] + $check['time'];

        if ($check['limit'] <= $data['n_check']) {
            # Maz numbers of checks
            if ($reset <= time()) {
                # Reset data
                self::ResetChecks($data);
            } else {
                $wait = $reset - time();
                Bot::SendMsg($chat_id, '<b>Max numbers of check already, wait ' . $wait . '\'s</b>', $msg_id);
                die();
            }
        }
    }

    /**
     * Reiniciar el numero de checks, y el las_reset
     */
    final public static function ResetChecks(array $data): bool
    {

        $query = "UPDATE users SET last_reset = :last_reset, n_check = :n_check WHERE tg_id = :id";
        $res = Query::Sql($query, [':last_reset' => time(), ':n_check' => 0, ':id' => $data['id']]);
        return $res['ok'];

    }

    /**
     * Update the numbers off checks gates
     */
    final public static function UpdateChecks(array $data, $up = 1): bool
    {

        $n_check = $data['n_check'] + $up;
        $query = "UPDATE users SET n_check = :n_check WHERE tg_id = :id";
        $res = Query::Sql($query, [':n_check' => $n_check, ':id' => $data['id']]);
        return $res['ok'];
    }

    /**
     * Banear o desbanear a un usuario
     */
    public static function UpBan(bool $ban, string $id, string $msg)
    {
        $query = "UPDATE users SET is_banned = :is_banned, msg = :msg WHERE tg_id = :id";
        $data = [':is_banned' => $ban, ':msg' => $msg, ':id' => $id];
        return Query::Sql($query, $data)['ok'];
    }

    /**
     * Saludar al usuario según su lang-code y el hora actual
     */
    public static function GetGreeting(string $lang_code, string $full_name)
    {
        $hora = date('H');
        $saludo = Lang::$langs[$lang_code]['start'];
        switch ($lang_code) {
            case ($hora >= 00 && $hora <= 12): $saludo = $saludo['day'];
                break; /* Mañana */
            case ($hora >= 13 && $hora <= 18): $saludo = $saludo['afternoon'];
                break; /* Tarde */
            case ($hora >= 19 && $hora <= 24): $saludo = $saludo['night'];
                break; /* Noche */
            default:$saludo = $saludo['day'];
        }
        return sprintf($saludo, $full_name);
    }

    /**
     * Bloquear a los usuarios según la bandera de su nombre
     */
    private static function BlockNationalities(array $data)
    {
        $name = $data['first_name'] . ' ' . $data['last_name'];
        $block = ['🇮🇳'];

        foreach ($block as $value) {
            $pos = strpos($name, $value);
            if ($pos !== false) {
                Bot::SendMsg($data['id'], '<i>🚫 You are blocked by your nationality</i>');
                self::UpBan(true, $data['id'], 'Block user from ' . $value);
                die;
                return true;
            }
        }
        return false;
    }

    /**
     * Eliminar o añadir un usuario al staff
     */
    public static function SetStaff(array $data, string $staff): array
    {
        return self::Update($data['id'], $data['status'], $staff, $data['creditos'], $data['save_live'], $data['member_expired'], $data['credit_expired'], $data['apodo'], $data['antispam']);
    }

    /**
     * Actualizar la información del usuario
     */
    public static function Update(string | int $id, string $status, string $staff, int $creditos, bool $save_live, int $member_expired, int $credit_expired, string $apodo, int $antispam): array
    {
        $query = "UPDATE users SET status = :status, staff = :staff, creditos = :creditos, save_live = :save_live, member_expired = :member_expired, credit_expired = :credit_expired, apodo = :apodo, antispam = :antispam WHERE tg_id = :id";
        $data = [':status' => $status, ':staff' => $staff, ':creditos' => $creditos, ':save_live' => $save_live, ':member_expired' => $member_expired, ':credit_expired' => $credit_expired, ':apodo' => $apodo, ':antispam' => $antispam, ':id' => $id];
        return Query::Sql($query, $data);
    }

    /**
     * Obtener el took total de ejecución en float o int
     */
    public static function GetTook(bool $float = false, int $round = 3)
    {
        $ms = time();
        $s_time = (int) $_SERVER['REQUEST_TIME'];
        if ($float) {
            $ms = (float) microtime(true);
            $s_time = (float) $_SERVER['REQUEST_TIME_FLOAT'];
        }
        return round($ms - $s_time, $round);
    }

    /**
     * Actualizar el last_check
     */
    public static function UpdateLastCheck($id, $time):bool 
    {
        $query = "UPDATE users SET last_check = :last_check WHERE tg_id = :id";
        $data = [':last_check' => $time, ':id' => $id];
        return Query::Sql($query, $data)['ok'];
    }

    /**
     * Actualizar el idioma del usuario
     */
    public static function UpdateLang(string|int $id, string $new_lang):array
    {
        $query = "UPDATE users SET lang = :lang_code WHERE tg_id = :id";
        return Query::Sql($query, [':lang_code' => $new_lang, ':id' => $id]);
    }

    /**
     * Actualizar el save_live del usuario
     */
    public static function SaveLive($id, bool $save):array
    {
        $query = "UPDATE users SET save_live = :save_live WHERE tg_id = :id";
        return Query::Sql($query, [':save_live' => $save, ':id' => $id]);
    }
}
