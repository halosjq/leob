<?php

use App\Models\Bot;
use App\Gate\{Gen, Bin};
use App\Config\{Lang, StringUtils as Utils};

$input = Bot::GetContent($query_inline, 4);
$input = str_replace(['rand', 'rnd', 'random'], 'x', $input);
$bim = substr($input, 0, 6);

if (empty($input) || strlen($input) < 6) {
    // Spam Message
    Bot::answerInlineQuery([
        'inline_query_id' => $inline_query_id,
        'results' => json_encode([[
            'type'        => 'article',
            'id'          => Bot::RanId(15),
            'title'       => 'CC-gen 💳',
            'description' => 'Genera tus CCS',
            'thumb_url'   => 'https://namso-gen.com/_nuxt/icons/icon_512.104f87.png',
            'input_message_content' => [
                'message_text' => "<b>λ <i>CC-gen</i> ♻️\nFormat:</b> <code>@" . bot_username . " card|mm|yy|cvc</code>",
                'parse_mode'   => 'html',
            ],
        ]]),
    ]);
    exit;
}

$fim = Bin::Get($bim);
if (!$fim['ok']) {
    $txt = Lang::$langs['en']['bin']['invalid'];
    $txt = sprintf($txt, $fim['bin']);
    Bot::answerInlineQuery([
        'inline_query_id' => $inline_query_id,
        'cache_time' => 0.1,
        'results' => json_encode([[
            'type'        => 'article',
            'id'          => Bot::RanId(15),
            'title'       => 'Put valid bin',
            'description' => 'Genera tus CCS',
            'thumb_url'   => 'https://namso-gen.com/_nuxt/icons/icon_512.104f87.png',
            'input_message_content' => [
                'message_text' => $txt,
                'parse_mode'   => 'html',
            ],
        ]]),
    ]);
    exit;
}

$cgen = explode('|', Utils::CleanString($input));
$val = Gen::Validate($cgen);

if (!$val['ok']) {
    Bot::answerInlineQuery([
        'inline_query_id' => $inline_query_id,
        'cache_time' => 0.1,
        'results' => json_encode([[
            'type'        => 'article',
            'id'          => Bot::RanId(15),
            'title'       => 'Invalid input ❌',
            'description' => 'An error ocurred',
            'thumb_url'   => 'https://namso-gen.com/_nuxt/icons/icon_512.104f87.png',
            'input_message_content' => [
                'message_text' => '<b><i>Input</i>: <code>'.implode('|', $cgen)."</code> ❌\n<i>Error</i>: </b>" . $val['msg'],
                'parse_mode'   => 'html',
            ],
        ]]),
    ]);
    exit;
}

for ($i=0; $i < 4; $i++) { 
    $cgen[$i] = $cgen[$i] ?? 'rnd';
    $cgen[$i] = $cgen[$i] == 'x' ? 'rnd' : $cgen[$i];
}

$gen = Gen::Complet($cgen[0], $cgen[1], $cgen[2], $cgen[3]);

$Strl = ($cgen[0] == 3) ? 15 : 16;
$card = $cgen[0].str_repeat('x', $Strl - strlen($cgen[0]));
$ccgen = implode('|', [$card, $cgen[1], $cgen[2], $cgen[3]]);

if (!$gen['ok']) {
    Bot::answerInlineQuery([
        'inline_query_id' => $inline_query_id,
        'cache_time' => 0.1,
        'results' => json_encode([[
            'type'        => 'article',
            'id'          => Bot::RanId(15),
            'title'       => 'Invalid input ❌',
            'description' => 'An error ocurred',
            'thumb_url'   => 'https://namso-gen.com/_nuxt/icons/icon_512.104f87.png',
            'input_message_content' => [
                'message_text' => '⚠️ <b><i>'.$gen['error'].'</i></b>',
                'parse_mode'   => 'html',
            ],
        ]]),
    ]);
    exit;
}

Bot::answerInlineQuery([
    'inline_query_id' => $inline_query_id,
    'cache_time' => 0.1,
    'results' => json_encode([[
        'type'        => 'article',
        'id'          => Bot::RanId(15),
        'title'       => 'Results ✅',
        'description' => 'Card: ' . $ccgen,
        'thumb_url'   => 'https://namso-gen.com/_nuxt/icons/icon_512.104f87.png',
        'input_message_content' => [
            'message_text' => "<b>Input:</b> <code>".$ccgen."</code>\n\n<code>".implode("\n", $gen['ccs'])."</code>",
            'parse_mode'   => 'html',
        ],
    ]]),
]);
exit;