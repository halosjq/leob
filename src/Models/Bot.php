<?php

namespace App\Models;

use CURLFile;

/**
 * Interactuar con la api de telegram
 */
class Bot
{

    private static string $token = '';
    private static string $website = '';
    private static $result;
    public static $bot;

    public static $content;
    public static $update;

    public function __construct()
    {
        self::$token = $_ENV['BOT_TOKEN'];
        self::$website = 'https://api.telegram.org/bot' . self::$token . '/';
    }

    /**
     * Obtener el token del Bot
     */
    public static function GetToken()
    {
        return self::$token;
    }

    /**
     * Crear request a la api de telegram
     */
    private static function request($method, $datas = [], $decode = true)
    {

        $Url = self::$website . $method;
        $ch = curl_init($Url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $datas,
        ]);

        self::$result = curl_exec($ch);
        if (self::$result === false) {
            error_log("#bot #curl #fatal\nError: ".curl_error($ch));
            die;
        }
        curl_close($ch);
        return ($decode) ? json_decode(self::$result, true) : self::$result;
    }

    /**
     * Validar el token
     */
    public static function ValidateToken($update = false)
    {

        if (file_exists('../config_bot_token.json') && $update == false) {
            $data = json_decode(file_get_contents('../../config_bot_token.json'), true);
        } else {
            $data = self::request('Getme');
        }

        if ($data['ok']) {
            // Valid token
            self::$bot = [
                'id' => $data['result']['id'],
                'first_name' => $data['result']['first_name'],
                'username' => $data['result']['username'],
            ];
            file_put_contents('../config_bot_token.json', json_encode($data));

        } else {
            error_log($data['description']);
            http_response_code($data['error_code']);
            die();
        }
    }

    public static function __callStatic($method, $arguments)
    {
        return self::request($method, $arguments[0]);
    }

    /**
     * Obtener datos del webhook
     */
    public static function GetDatas($decode = true)
    {
        self::$content = file_get_contents('php://input') or die('No body');
        self::$update = ($decode) ? @json_decode(self::$content, true) : self::$content;
        if (empty(self::$content) || !self::$update) {
            error_log('No data');
            die('No body');
        }
        return self::$update;
    }

    /**
     * Validar un comando e incluir un archivo externo, en caso de que exista
     * return bool
     */
    public static function Cmd($cmd_name, $file = null)
    {
        $texto = self::$update['message']['text'];
        $separators = explode(' ', $_ENV['CMD_PREFIX']);
        if (in_array($texto[0], $separators)) {

            $text = explode(' ', substr($texto, 1))[0];
            $cmd = explode('|', $cmd_name);

            if (in_array($text, $cmd)) {
                if ($file != null && file_exists($file)) {
                    require $file;
                }

                return true;
            }
        }
        return false;
    }

    /**
     * Obtener el parametro de consulta de un comando, envia un mensaje en caso de que el parametro este vacio
     * @return string|null|void
     */
    public static function GetContent(string $txt, int $int, ?array $sender = ['send' => false])
    {
        $a = trim(substr($txt, $int));

        if ((empty($a) || $a == null) && $sender['send'] == true) {
            Bot::SendMsg($sender['chat_id'], $sender['msg'], $sender['msg_id']);exit;
        }
        return $a;
    }

    /**
     * Enviar una action
     * @link https://core.telegram.org/bots/api#sendchataction
     */
    public static function SendAction(string $chat_id, string $action)
    {
        self::request('sendChatAction', [
            'chat_id' => $chat_id,
            'action' => $action,
        ]);
    }

    /**
     * Enviar mensajes
     *
     * @link https://core.telegram.org/bots/api#sendmessage
     * @return array
     */
    final public static function SendMsg(string $chat, string $content, $reply = '', $button = '', $parse_mode = 'HTML', $web_page_preview = false)
    {
        $payload = [
            'chat_id' => $chat,
            'text' => $content,
            'reply_to_message_id' => $reply,
            'parse_mode' => $parse_mode,
            'reply_markup' => json_encode($button),
            'disable_web_page_preview' => $web_page_preview,
        ];

        if ($reply == null) {
            unset($payload['reply_to_message_id']);
        }

        if ($button == null) {
            unset($payload['reply_markup']);
        }

        self::SendAction($chat, 'typing');
        return self::request('SendMessage', $payload);
    }

    /**
     * Editar un mensaje enviado por el bot
     *
     * @link https://core.telegram.org/bots/api#editmessagetext
     * @return array
     */
    final public static function EditMsgTxt(string $chat, string $msg_id, string $txt, $button = '', $parse_mode = 'HTML') {
        $payload = [
            'chat_id' => $chat,
            'message_id' => $msg_id,
            'parse_mode' => $parse_mode,
            'text' => $txt,
            'reply_markup' => json_encode($button)
        ];
        if (empty($button)) unset($payload['reply_markup']);

        return self::request('editMessageText', $payload);
    }
    /**
     * Enviar fotos
     *
     * @link https://core.telegram.org/bots/api#sendphoto
     * @return array
     */
    final public static function Photo(string $chat, string|CURLFile $photo, string $caption = '', $reply = '', $button = '', $parse_mode = 'HTML')
    {
        if (file_exists($photo)) {
            $photo = new \CURLFile(realpath($photo));
        }

        $payload = [
            'chat_id' => $chat,
            'photo' => $photo,
            'caption' => $caption,
            'reply_to_message_id' => $reply,
            'parse_mode' => $parse_mode,
            'allow_sending_without_reply' => true,
            'reply_markup' => $button,
        ];

        if ($reply == null) {
            unset($payload['reply_to_message_id']);
        }

        if ($button == null) {
            unset($payload['reply_markup']);
        }

        self::SendAction($chat, 'upload_photo');
        return self::request('sendPhoto', $payload);
    }

    /**
     * Responder a callback_querys from inline keyboard
     *
     * @link https://core.telegram.org/bots/api#answercallbackquery
     * @return array
     */
    final public static function AnswerQuery(string $callback_query_id, string $text = '', bool $show_alert = true)
    {
        $payload = [
            'callback_query_id' => $callback_query_id,
            'text' => $text,
            'show_alert' => $show_alert,
        ];

        return self::request('answerCallbackQuery', $payload);
    }

    /**
     * Un id random
     */
    final public static function RanId($lenght = 10): string
    {
        $i = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $i .= rand() . time();
        return substr(md5($i), 0, $lenght);
    }

    /**
     * Eliminar un mensaje de un chat
     * @return array
     */
    final public static function DelMsg(string $chat_id, string $msg_id): array
    {
        return self::request('deleteMessage', [
            'chat_id' => $chat_id,
            'message_id' => $msg_id,
        ]);
    }
}

new Bot();
