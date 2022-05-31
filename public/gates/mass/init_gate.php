<?php
ini_set('display_errors', 1);
define('APP_PATH', realpath(dirname(__DIR__, 3)));
require APP_PATH . '/vendor/autoload.php';
require APP_PATH . '/public/gates/functions.php';

use App\Config\{ErrorLog, GetConfig, Lang, StringUtils as Utils};
use App\Models\Bot;

ErrorLog::ActivateErrorLog(APP_PATH . '/src/logs', 200);
GetConfig::load(APP_PATH . '/');