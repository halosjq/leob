<?php

use App\Config\Exchange;
use App\Models\Bot;

$cr = ['100' => $_ENV['CR_100'], '200' => $_ENV['CR_200'], '500' => $_ENV['CR_500']];

$prices = Exchange::Prices($cr);

Bot::answerInlineQuery([
    'inline_query_id' => $inline_query_id,
    'results' => json_encode([[
        'type'        => 'article',
        'id'          => Bot::RanId(15),
        'title'       => 'Bot prices 💰',
        'description' => 'Precios del bot, tanto para usuarios como para grupos',
        'thumb_url'   => 'https://telegra.ph/file/d4b298555bcbfed293bcd.jpg',
        'input_message_content' => [
            'message_text' => $prices,
            'parse_mode'   => 'html',
        ],
    ]]),
]);
