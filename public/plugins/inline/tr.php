<?php

use App\Config\Translate;
use App\Models\Bot;

$input = Bot::GetContent($up['inline_query']['query'], strlen($in_cmd[0]));

if (empty($input)) {
    Bot::answerInlineQuery([
        'inline_query_id' => $inline_query_id,
        'results' => json_encode([[
            'type'        => 'article',
            'id'          => Bot::RanId(15),
            'title'       => 'Translate 📥',
            'description' => 'Translate your messages',
            'thumb_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d7/Google_Translate_logo.svg/1200px-Google_Translate_logo.svg.png',
            'input_message_content' => [
                'message_text' => "<b>λ Translate inline\nFormat:</b> <code>@" . bot_username . " tr lang_code text</code>",
                'parse_mode'   => 'html',
            ],
        ]]),
    ]);
    exit;
}

$txt = MultiExlode([' ', "\n"], $input);
$lang_code = explode('|', $txt[0]);
$msg = trim(substr($input, strlen($txt[0])));

$lang_input = (isset($lang_code[0]) && $lang_code[0] != null) ? $lang_code[0] : 'auto';
$lang_output = (isset($lang_code[1]) && $lang_code[1] != null) ? $lang_code[1] : 'en';

if (!isset($lang_code[1])) {
    $lang_input = 'auto';
    $lang_output = $lang_code[0];
}

$tr = Translate::tr($msg, $lang_input, $lang_output);

$emoji = $tr->error ? '❌' : '✅';
$desc = $tr->error ? 'An error occurred' . PHP_EOL . 'Took: ' . $tr->took . "'s" : 'Translated (' . $tr->input->lang . ' ➜ ' . $tr->output->lang . ')' . PHP_EOL . 'Took: ' . $tr->took . "'s";
$message_text = $tr->error ? '<b>⚠️ <i>' . $tr->msg . '</i></b>' : $tr->output->text;

Bot::answerInlineQuery([
    'inline_query_id' => $inline_query_id,
    'cache_time'      => 0.1,
    'results' => json_encode([[
        'type'        => 'article',
        'id'          => Bot::RanId(15),
        'title'       => 'Translate ' . $emoji,
        'description' => $desc,
        'thumb_url'   => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d7/Google_Translate_logo.svg/1200px-Google_Translate_logo.svg.png',
        'input_message_content' => [
            'message_text' => $message_text,
            'parse_mode'   => 'html',
        ],
    ]]),
]);
