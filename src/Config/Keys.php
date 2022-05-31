<?php

namespace App\Config;

use App\Db\Query;
use App\Models\Bot;
use App\Models\User;

/**
 * Create, validate keys for users and groups
 */
class Keys
{

    private static $min = 5;
    private static $com = ['kirari', 'Kirari'];

    /**
     * Validar una key para grupos o usuarios
     */
    final public static function Validate(string $Key): bool
    {
        if ($Key == null) {
            return false;
        }

        $key = explode('-', $Key);
        if (count($key) != 4) {
            return false;
        } elseif (in_array($key[0], self::$com) === false) {
            return false;
        } elseif (strlen($key[2]) < self::$min || strlen($key[3]) < self::$min) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * Generar una key para usuarios
     */
    final public static function genKey(int | string $typeId, int $rand = 10): string
    {
        return 'Kirari-' . $typeId . '-' . substr(md5(rand()), 0, rand(self::$min, $rand)) . '-' . substr(md5(rand()), 0, rand(self::$min, $rand));
    }

    /**
     * Guardar una key en la db
     */
    final public static function Save(string $key, string $type, string $expire, int $credits, int $reedem): array
    {
        $query = "INSERT INTO `keysp` (`key_id`, `type`, `credits`, `expire`, `r_reedem`) VALUES (:key, :type, :crdt, :expire, :reedem)";
        return Query::Sql($query, [':key' => $key, ':type' => $type, ':crdt' => $credits, ':expire' => $expire, ':reedem' => $reedem]);
    }

    /**
     * Obtener informacion de una key de la db
     */
    final public static function Get(string $key)
    {

        if (!self::Validate($key)) {
            return ['ok' => false, 'msg' => 'Invalid key'];
        }

        $res = Query::Sql("SELECT * FROM keysp WHERE key_id = '$key'");

        if ($res['ok']) {
            $data = $res['datas'];
            $data['ok'] = true;
            $data['msg'] = 'Valid Key';
            return $data;
        }
        return ['ok' => false, 'msg' => 'Key not found'];
    }

    /**
     * Actualizar la información de una key
     */
    private static function Update(string $key, string $type, string $expire, int $credits, int $reedem): bool
    {
        $query = "UPDATE keysp SET type = :type, credits = :crdt, expire = :expire, r_reedem = :reedem WHERE key_id = :key";
        return Query::Sql($query, [':key' => $key, ':type' => $type, ':crdt' => $credits, ':expire' => $expire, ':reedem' => $reedem])['ok'];
    }

    /**
     * Eliminar una key de la db
     */
    private static function Delete(string $key)
    {
        return Query::Sql("DELETE FROM keysp WHERE key_id = :key", [':key' => $key])['ok'];
    }

    final public static function Claim(string $key, array $user)
    {
        $data = self::Get($key);
        if ($data['ok']) {
            // Valid
            $user['credit_expired'] = ($user['credit_expired'] == 0) ? time() : $user['credit_expired']; // Si credit_expired es 0, se actualiza a la fecha actual
            $user['member_expired'] = ($user['member_expired'] == 0) ? time() : $user['member_expired']; // Si member_expired es 0, se actualiza a la fecha actual

            $cr = $data['credits'] + $user['creditos']; // Creditos totales
            $cr_expired = $data['expire'] + $user['credit_expired']; // Cuando expiran los creditos
            $member = ($user['status'] == 'premium') ? 'premium' : $data['type']; // Status del usuario
            $antispam = ($member == 'premium') ? 45 : $user['antispam']; // Antispam
            $apodo = ($member == 'premium') ? 'Premium user' : $user['apodo']; // Apodo del usuario
            $member_expired = $data['expire'] + $user['member_expired']; // Cuando expira el status del usuario
            $reedem = $data['r_reedem'] - 1; // Cantidad de veces a canjear la key

            self::Update($key, $data['type'], $data['expire'], $data['credits'], $reedem);
            if ($reedem < 1) {
                self::Delete($key);
            }

            Bot::SendMsg($user['id'], "<b><i>The key was exchanged ✅</i>\nStatus: <code>" . $member . "</code>\nCredits: <code>" . $data['credits'] . "</code>\nExpired in: <code>" . date('h:i A m/d/y', time() + $data['expire']) . "</code></b>");
            $u = User::Update($user['id'], $member, $user['staff'], $cr, $user['save_live'], $member_expired, $cr_expired, $apodo, $antispam);
            if (!$u['ok']) {
                Bot::SendMsg($user['id'], '<b><i>❌ An unknown error occurred, please try again</i></b>');
            }
            $channel_id = GetConfig::Get('BOT_CHANNEL');
            Bot::SendMsg($channel_id, "<b>Key redeemed\nKey:</b> <i>".$key."</i>\n<b>User: (<code>".$user['id']."</code>) ".$user['mention']." [".ucfirst($user['apodo'])."]</b>");
            return $u;
        } else {
            return $data;
        }
    }
}
