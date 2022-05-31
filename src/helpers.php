<?php
use App\Models\{Bot, User};

/**
 * Mensaje a enviar cuando no se puede encontrar el archivo
 */
function NotFoundFile($chat_id, $message_id, $file)
{
    Bot::SendMsg($chat_id, '<i>The file <u>' . $file . '</u> could not be found, report this error to a bot admin</i>', $message_id);
    exit;
}

/**
 * Explode con array
 */
function MultiExlode(array $explodes, string $str): array
{
    $str = str_replace($explodes, $explodes[0], $str);
    return explode($explodes[0], $str);
}

/**
 * Convertir los segundos a dias, horas, minutos y segundos
 */
function SecondsToTime($seconds): string
{
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}


/**
 * Search user by id or username
 *
 * @param string|int $id User id or username
 * @return array|bool Return array with user data or false if not found
 */
function SearchUser($id = null) {
    $id = str_replace(['@', ' ', 'AND', 'OR', '1=1', '=', ',', ';', '.', ':', bot_username, '"'], '', $id);
    if (empty($id)) {
        return false;
    } elseif (!is_numeric($id)) {
        return User::GetUser('@' . $id, 'username');
    } else {
        return User::GetUser($id);
    }
}