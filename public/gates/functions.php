<?php
/**
 * Get user ip
 *
 * @return sring 
 */
function GetIp() {
    return 
    $_SERVER['HTTP_X_FORWARDED_FOR'] 
    ?? $_SERVER['HTTP_FORWARDED_FOR']
    ?? $_SERVER['HTTP_X_FORWARDED']
    ?? $_SERVER['HTTP_FORWARDED']
    ?? $_SERVER['HTTP_CLIENT_IP'] 
    ?? $_SERVER['REMOTE_ADDR']
    ?? 'UNKNOWN';
}

/**
 * Checar si un tag del usuario esta baneado
 */
function checkTagBanned(string $name, string $location):bool|string {
    
    if (!file_exists($location)) false;
    $data = file($location, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($data as $tag) {
        if (strpos(' '.$name, $tag)) return '<b>❌ Banned tag</b> <code>'.$tag."</code>\n<i>Don't use this bot! + 1 warn</i>";
    }
    return false;
}

/**
 * Eliminar todos los .txt de una carpeta
 */
function DelCookie(string $dir):void {
    if (!is_dir($dir)) return;

    $files = glob($dir.'/*.txt');
    foreach ($files as $files) @unlink($files);
}

/**
 * Gate Response
 */
function IsUnspam($res, array $user): void {
    if ($res === false) {
        echo 'Unspam active';
        \App\Models\User::UpdateLastCheck($user['id'], round($user['init_time'])); die;
    }
}

/**
 * Parse adyen cli data
 */
function ParseAdyenCli(string $key, array $cc, string $name):string {
    return 'KEY=" ' . $key . '" CC=' . $cc[0] . ' MES=' . $cc[1] . ' ANO=' . $cc[2] . ' CVV=' . $cc[3] . ' NAME=" ' . $name . '"';
}