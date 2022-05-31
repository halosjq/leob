<?php

use App\Gate\Bin;
use App\Models\Bot;


$fim = Bin::Get($call_cmd[1]);

$txt = "Bin: ".$fim['bin']."\nBrand: ".$fim['brand']."\nType: ".$fim['type']."\nLevel: ".$fim['level']."\nBank: ".$fim['bank_name']." - ☎️ ".$fim['bank_phone']."\nCountry: ".$fim['ISO3']." (".$fim['flag'].") - 💱 ".$fim['currency'];
$txt .= ($fim['banned']) ? "\n\n⚠️ Alert: This bin is banned" : '';

Bot::AnswerQuery($callback_query_id, $txt);