<?php

namespace App\Models;

use App\Db\Query;
use App\Models\Bot;

class Chat
{

    /**
     * Obtener la informarción de un grupo
     * @return array
     */
    public static function GetGroup(string $chat_id): array
    {
        $data = Query::Sql("SELECT * FROM groups WHERE g_id = :group_id", [':group_id' => $chat_id]);

        if ($data['ok']) {
            $chat = $data['datas'];
            $chat['ok'] = true;
            $chat['afectRow'] = $data['afectRow'];
            $chat['is_banned'] = (bool) $chat['is_banned'];
            $chat['warns'] = (int) $chat['warns'];
            $chat['members'] = (int) $chat['members'];
            $chat['antispam'] = (int) $chat['antispam'];
            return $chat;
        }
        return $data;
    }

    /**
     * Registar un grupo
     * @return array
     */
    public static function RegisterGroup(string $chat_id): array
    {

        $membersData = Bot::getChatMemberCount(['chat_id' => $chat_id]);
        $members = ($membersData['ok']) ? $membersData['result'] : 0;
        $banned = ($members <= 5) ? true : false;

        $linkData = Bot::createChatInviteLink(['chat_id' => $chat_id]);
        $link = ($linkData['ok']) ? $linkData['result']['invite_link'] : $linkData['description'];

        $finish_time = ($banned) ? time() : time() + (86400 * $_ENV['GROUP_DAY']);

        if ($members < $_ENV['GROUP_MIN']) {$type = 'unauth';
        } else { $type = 'free';}

        $query = "INSERT INTO groups (g_id, is_banned, type, members, finish_time, link) VALUES (:group_id, :banned, :tipo, :members, :finish_time, :link)";
        $datas = [':group_id' => $chat_id, ':banned' => $banned, ':tipo' => $type, ':members' => $members, ':finish_time' => $finish_time, ':link' => $link];
        Query::Sql($query, $datas);

        if ($banned) {
            Bot::leaveChat(['chat_id' => $chat_id]);
        }

        if ($type == 'free') {
            Bot::SendMsg($chat_id, '<i><u>Good News!</u> he has just started his ' . $_ENV['GROUP_DAY'] . '-day free trial for his group');
        }

        if ($members < $_ENV['GROUP_MIN']) {
            Bot::SendMsg($chat_id, '<i>You need at least ' . $_ENV['GROUP_MIN'] . ' members to start your trial</i>');
            Bot::leaveChat(['chat_id' => $chat_id]);die;
        }

        return ['ok' => true, 'id' => $chat_id, 'g_id' => $chat_id, 'members' => $members, 'is_banned' => $banned, 'is_muted' => false, 'finish_time' => $finish_time, 'antispam' => 100, 'type' => $type, 'custom_title' => 'not_change', 'warns' => 0, 'link' => $link, 'description' => 'Group registered successfully'];

    }

    /**
     * Actualizar a información de un chat
     */
    public static function UpdateChatInfo(string | int $chat_id)
    {
        $membersData = Bot::getChatMemberCount(['chat_id' => $chat_id]);
        $members = ($membersData['ok']) ? $membersData['result'] : 0;
        $banned = ($members <= 5) ? true : false;
        $type = $banned ? 'unauth' : 'free';
        $finish_time = ($banned) ? 0 : time() + (86400 * $_ENV['GROUP_DAY']);

        $query = "UPDATE groups SET members = :members, is_banned = :banned, type = :type, finish_time = :finish_time WHERE g_id = :group_id";
        $datas = [':members' => $members, ':banned' => $banned, ':type' => $type, ':finish_time' => $finish_time, ':group_id' => $chat_id];
        return Query::Sql($query, $datas)['ok'];

    }

    /**
     * Checar la información de un chat y modificar la información de un usuario
     */
    public static function Check(string | int $chat_id, array $userData, string | int $chat_type): array
    {
        if ($chat_type == 'private') {
            return $userData;
        }

        $data = self::GetGroup($chat_id);
        if ($data['ok'] == false) {
            $data = self::RegisterGroup($chat_id);
        }

        self::IsUnauth($data, $chat_id);
        self::IsBanned($data, $chat_id);
        self::ReviewMembership($data, $chat_id);

        $userData['apodo'] = ($data['custom_title'] == 'not_change') ? $userData['apodo'] : $data['custom_title'];
        $userData['antispam'] = $data['antispam'];

        if ($data['type'] == 'premium') {$userData['status'] = 'premium';}
        if ($data['type'] == 'free') {$userData['status'] = 'free';}
        return $userData;
    }

    /**
     * Banear/Desbanear un chat
     */
    public static function UpBan(bool $ban, string $chat_id): bool
    {
        $query = "UPDATE groups SET is_banned = :ban WHERE g_id = :group_id";
        $datas = [':ban' => $ban, ':group_id' => $chat_id];
        return Query::Sql($query, $datas)['ok'];
    }

    /**
     * Verificar si el chat esta baneado
     */
    private static function IsBanned(array $data, string $chat_id)
    {
        if (!$data['is_banned']) {
            return;
        }

        Bot::SendMsg($chat_id, '<b><i>❌ This group is banned, not add the bot!</i></b>');
        Bot::leaveChat(['chat_id' => $chat_id]);
        die();
    }

    /**
     * Verificar que el chat no este autorizado
     */
    private static function IsUnauth(array $data, string $chat_id)
    {
        if ($data['type'] != 'unauth') {
            return;
        }

        self::UpdateChatInfo($chat_id);
        Bot::SendMsg($chat_id, '<b><i>❌ This group is not authorized, not add the bot!</i></b>');
        Bot::leaveChat(['chat_id' => $chat_id]);
        die();
    }

    /**
     * Revisar la expiración de la membresia del grupo/chat
     */
    private static function ReviewMembership(array $data, string $chat_id)
    {
        if ($data['finish_time'] <= time() && $data['finish_time'] != 0) {

            Query::Sql("UPDATE groups SET finish_time = 0, type = 'unauth' WHERE g_id = :group_id", [':group_id' => $chat_id]);
            Bot::SendMsg($chat_id, '<b><i>⚠️ Membership expired, bye!</i></b>');
            self::UpdateChatInfo($chat_id);
            Bot::leaveChat(['chat_id' => $chat_id]);
            die();
        }
    }

}
