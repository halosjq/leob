<?php
ini_set('display_errors', 1);
$content = file_get_contents("php://input");
$update = json_decode($content, true);
$dirInit = dirname(__FILE__);
require $dirInit.'/../../main/config.php';

require $dirInit.'/../../main/function_main.php'; // Function main
require $dirInit.'/../../main/conexion.php'; // Sql conection
require $dirInit.'/../../main/function_others.php'; // Function secundary
require $dirInit.'/../functions.php'; // Another functions
require $dirInit.'/functions.php'; // Functions for mass gates

$file_name = '../../files/tmp/'.$update['file'];

if (!file_exists($file_name)) {
  die(' No such file or directory');
}

$cards = file($file_name, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
$total_cards = count($cards);

$meta = array();
$meta['live'] = 0;
$meta['dead'] = 0;
$meta['erro'] = 0;
$meta['time'] = 0;

for ($i=0; $i < $total_cards; $i++) { 
  $data = explode('||', $cards[$i]);

  if (strpos($data[2], '✅')) {
    $meta['live']++; # Live
  } elseif (strpos($data[2], '❌')) {
    $meta['dead']++; # Dead
  } else {
    $meta['erro']++; # Error
  }
  
}

$cost = ($meta['live'] * 1) + ($meta['dead'] * 0.1) + ($meta['erro'] * 0);
$newC = $update['user']['creditos'] - $cost;
$user_id = $update['user']['id'];

$con->query("UPDATE `users` SET `creditos`='$newC' WHERE `tg_id` = '$user_id'");
$con->close();
$took_total = tokkk($update['user']['init_time']);
$botedit = [
  'text' => "<i><b><u>Mass ".$update['cmd']['name']."</u> | Took:</b> ".$took_total."'s\n\n<b>Total:</b> ".$total_cards."| <b>Lives:</b> ".$meta['live']." | <b>Deads:</b> ".$meta['dead']." | <b>Error:</b> ".$meta['erro']."</i>\n\nNote: Press the button to show result",
  'chat_id' => $update['user']['chat_id'],
  'message_id' => $update['user']['to_edit'],
  'parse_mode' => 'HTML',
  'reply_markup' => json_encode([
    'inline_keyboard' => [
      [['text' => 'View result 👀', 'callback_data' => 'mass '.$update['user']['id'].'|'.$update['cmd']['code'].'|'.$update['file'].'|'.$took_total ]]
    ]
  ]),
];

bot('editMessageText', $botedit);
exit();

function tokkk($init, $round = 3) {
  $took = time() - $init;
  return round($took, $round);
}