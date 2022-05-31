<?php 

use App\Models\Bot;
use App\Gate\{Make, Responses as Res};
use App\Faker\{Name, Address};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".$cece."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];

# ~ REQ 1 ~ #
$curl = curl_init($ch);
curl_setopt($curl, CURLOPT_URL, 'https://geo.cardinalcommerce.com/DeviceFingerprintWeb/V2/Bin/Enabled');
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($curl, CURLOPT_POSTFIELDS, '{"bin":"'.$cc[0].'","orgUnitId":"5d039fe2b6112025f87f5fde"}');
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$req1 = curl_exec($curl);

$res1 = json_decode($req1, true);

Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(3, $cece, $gate['name'], $lang['wait']));
$ConfigsEnabled = $res1['ConfigsEnabled'];
$MethodUrlEnabled = $res1['MethodUrlEnabled'];

Res::SetParams($MethodUrlEnabled, $ConfigsEnabled);
$res = Res::cardinal();
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, $cece, $res, $ccs['bin'], $gate['name']));