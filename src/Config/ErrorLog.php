<?php

namespace App\Config;

date_default_timezone_set('America/Lima');

use App\Config\StringUtils;
use App\Models\Bot;

class ErrorLog
{

    /**
     * Establecer que los errores no se muestren en pantalla y se guarden en un archivo
     */
    public static function ActivateErrorLog(string $path = 'logs', int $time_limit = 55)
    {
        if (!is_dir($path)) {error_log('No found dir: '.$path); die('No found dir: '.$path);}
        set_time_limit($time_limit);
        error_reporting(E_ALL);
        ini_set('ignore_repeated_errors', true);
        ini_set('display_errors', false);
        ini_set('log_errors', true);
        ini_set('error_log', $path . '/php-error.log');
    }

    /**
     * Enviar el "error" al canal log
     *
     * @param string $error Error a enviar
     */
    public static function ReportToChannel(string $error): void
    {
        $error = strip_tags($error);
        error_log($error);

        $error = StringUtils::QuitHtml($error);
        $chanel_id = $_ENV['BOT_CHANNEL'];
        
        $res = Bot::SendMsg($chanel_id, $error);
        
        if (!$res['ok']) error_log('[log] [bot] Fail to send message: ' . $res['description']);
    }
}
