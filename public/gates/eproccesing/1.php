<?php

use App\Models\Bot;
use App\Gate\{CurlX, Make, Responses as Res};
use App\Faker\{Name, Address, PhoneNumber, Internet};

$ccs = $ccs[0];
$cc  = $ccs['cc'];
$user['ida'] = Bot::SendMsg($user['chat_id'], "<b>Gate <u>".$gate['name']."</u> <i>started</i>♻️\nCard: <code>".implode('|', $cc)."</code>\nTime:</b> <i>".Make::Took()."'s</i>", $user['msg_id'])['result']['message_id'];