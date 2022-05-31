<?php

use App\Config\Exchange;
use App\Models\Bot;

$cr = ['100' => $_ENV['CR_100'], '200' => $_ENV['CR_200'], '500' => $_ENV['CR_500']];

$prices = Exchange::Prices($cr);

Bot::answerInlineQuery([
    'inline_query_id' => $inline_query_id,
    'results' => json_encode(
        [
            [
                'type'        => 'article',
                'id'          => Bot::RanId(15),
                'title'       => 'Bot prices 💰',
                'description' => 'Precios del bot, tanto para usuarios como para grupos',
                'thumb_url'   => 'https://telegra.ph/file/d4b298555bcbfed293bcd.jpg',
                'input_message_content' => [
                    'message_text' => $prices,
                    'parse_mode'   => 'html',
                ],
            ], [
                'type'        => 'article',
                'id'          => Bot::RanId(15),
                'title'       => 'Translate 📥',
                'description' => 'Translate your messages',
                'thumb_url'   => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d7/Google_Translate_logo.svg/1200px-Google_Translate_logo.svg.png',
                'input_message_content' => [
                    'message_text' => "<b>λ Translate inline\nFormat:</b> <code>@" . bot_username . " tr lang_code text</code>",
                    'parse_mode'   => 'html',
                ],
            ], [
                'type'        => 'article',
                'id'          => Bot::RanId(15),
                'title'       => 'Bin lookup 💳',
                'description' => 'Search your bin 💫',
                'thumb_url'   => 'https://binlist.net/favicon.png',
                'input_message_content' => [
                    'message_text' => "<b><i>λ Bin lookup ♻️</i>\nFormat:</b> <code>@" . bot_username . ' bin ' . rand(3, 6) . rand(10000, 99999) . "</code>",
                    'parse_mode'   => 'html',
                ],
            ], [
                'type'        => 'article',
                'id'          => Bot::RanId(15),
                'title'       => 'CC-gen 💳',
                'description' => 'Genera tus CCS',
                'thumb_url'   => 'https://namso-gen.com/_nuxt/icons/icon_512.104f87.png',
                'input_message_content' => [
                    'message_text' => "<b>λ <i>CC-gen</i> ♻️\nFormat:</b> <code>@" . bot_username . " card|mm|yy|cvc</code>",
                    'parse_mode'   => 'html',
                ],
            ]
        ]
    ),
]);
