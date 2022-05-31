<?php


////////////////////////////////////////////////////////////////////////////

require '../../vendor/autoload.php';
require './functions.php';
define('APP_PATH', realpath(dirname(dirname(__DIR__))));

use App\Config\{ErrorLog, GetConfig, Lang, StringUtils as Utils};
use App\Models\Bot;
use App\Gate\CurlX;

ErrorLog::ActivateErrorLog(APP_PATH . '/src/logs', 200);
GetConfig::load(APP_PATH . '/', true);

$path = Utils::GetQuery('path', null, true);

if (!file_exists($path)) {ErrorLog::ReportToChannel("#gate #error #fatal #FILE_NOT_FOUND\nFile: " . $path."\nIp: ".GetIp()."\nTime: ".time()); die;}

$up = Bot::GetDatas();

$user = @$up['user']; // User info ['id', 'first_name', 'last_name', 'username', 'language_code', 'etc']
$gate = @$up['gate']; // Gate info ['name', 'link', 'etc']
$ccs  = @$up['ccs'];  // CCS date  [['cc' => [], 'bin' => []]]
$lang = Lang::$langs[$user['lang']]['gate'];

if (!$user || !$gate || !$ccs) die('Invalid request');
if (@$ccs[0]['cc'][0] == null || empty(@$ccs[0]['cc'][0])) die('Put valid CC');

$proxy = ['METHOD' => 'CUSTOM', 'SERVER' => 'socks5h://socks-us.windscribe.com:1080', 'AUTH' => CurlX::GetRandVal(APP_PATH . '/public/files/proxy/windscribe.txt')];
$proxy2 = ['METHOD' => 'CUSTOM', 'SERVER' => 'socks5h://p.webshare.io:80', 'AUTH' => CurlX::GetRandVal(APP_PATH . '/public/files/proxy/webshare.txt')];

require $path;
exit;