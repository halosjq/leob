<?php

use App\Config\Lang;
use App\Config\StringUtils;
use App\Gate\Bin;
use App\Models\Bot;
use App\Models\User;

$bin = StringUtils::RemoveStrings(Bot::GetContent($query_inline, 4));

if (strlen($bin) < 6) {
    Bot::answerInlineQuery([
        'inline_query_id' => $inline_query_id,
        'results' => json_encode([[
            'type'        => 'article',
            'id'          => Bot::RanId(15),
            'title'       => 'Bin lookup 💳',
            'description' => 'Search your bin 💫',
            'thumb_url'   => 'https://binlist.net/favicon.png',
            'input_message_content' => [
                'message_text' => "<b><i>λ Bin lookup ♻️</i>\nFormat:</b> <code>@" . bot_username . ' bin ' . rand(3, 6) . rand(10000, 99999) . "</code>",
                'parse_mode'   => 'html',
            ],
        ]]),
    ]);
    exit;
}

$fim = Bin::Get($bin);
$u = User::GetUser($inline_query_userid);

if ($fim['ok']) {
    $txt = Lang::$langs['en']['bin']['valid'];
    $txt = sprintf($txt, $fim['bin'], $fim['brand'], $fim['type'], $fim['level'], $fim['bank_name'], $fim['bank_phone'], $fim['country_name'], $fim['ISO3'], $fim['flag'], $fim['currency'], $u['mention'], $u['apodo']);
} else {
    $txt = Lang::$langs['en']['bin']['invalid'];
    $txt = sprintf($txt, $fim['bin']);
}

$emoji = ($fim['ok']) ? '✅' : '❌';

Bot::answerInlineQuery([
    'inline_query_id' => $inline_query_id,
    'cache_time'      => 0.1,
    'results' => json_encode([[
        'type'        => 'article',
        'id'          => Bot::RanId(15),
        'title'       => 'Bin lookup 💳',
        'description' => $fim['error'] . ' ' . $emoji,
        'thumb_url'   => 'https://binlist.net/favicon.png',
        'input_message_content' => [
            'message_text' => $txt,
            'parse_mode'   => 'html',
        ],
    ]]),
]);
