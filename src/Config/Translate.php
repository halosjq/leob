<?php

namespace App\Config;

use App\Config\StringUtils;

/**
 * Traducir un texto dado
 * Repo: https://github.com/Mateodioev/translate
 * @author Mateodioev
 */
class Translate
{
    const VERSION = '0.1';

    private static $langs_code = ['auto' => 'Automatic', 'af' => 'Afrikaans', 'sq' => 'Albanian', 'am' => 'Amharic', 'ar' => 'Arabic', 'hy' => 'Armenian', 'az' => 'Azerbaijani', 'eu' => 'Basque', 'be' => 'Belarusian', 'bn' => 'Bengali', 'bs' => 'Bosnian', 'bg' => 'Bulgarian', 'ca' => 'Catalan', 'ceb' => 'Cebuano', 'ny' => 'Chichewa', 'zh-cn' => 'Chinese Simplified', 'zh-tw' => 'Chinese Traditional', 'co' => 'Corsican', 'hr' => 'Croatian', 'cs' => 'Czech', 'da' => 'Danish', 'nl' => 'Dutch', 'en' => 'English', 'eo' => 'Esperanto', 'et' => 'Estonian', 'tl' => 'Filipino', 'fi' => 'Finnish', 'fr' => 'French', 'fy' => 'Frisian', 'gl' => 'Galician', 'ka' => 'Georgian', 'de' => 'German', 'el' => 'Greek', 'gu' => 'Gujarati', 'ht' => 'Haitian Creole', 'ha' => 'Hausa', 'haw' => 'Hawaiian', 'iw' => 'Hebrew', 'hi' => 'Hindi', 'hmn' => 'Hmong', 'hu' => 'Hungarian', 'is' => 'Icelandic', 'ig' => 'Igbo', 'id' => 'Indonesian', 'ga' => 'Irish', 'it' => 'Italian', 'ja' => 'Japanese', 'jw' => 'Javanese', 'kn' => 'Kannada', 'kk' => 'Kazakh', 'km' => 'Khmer', 'ko' => 'Korean', 'ku' => 'Kurdish (Kurmanji)', 'ky' => 'Kyrgyz', 'lo' => 'Lao', 'la' => 'Latin', 'lv' => 'Latvian', 'lt' => 'Lithuanian', 'lb' => 'Luxembourgish', 'mk' => 'Macedonian', 'mg' => 'Malagasy', 'ms' => 'Malay', 'ml' => 'Malayalam', 'mt' => 'Maltese', 'mi' => 'Maori', 'mr' => 'Marathi', 'mn' => 'Mongolian', 'my' => 'Myanmar (Burmese)', 'ne' => 'Nepali', 'no' => 'Norwegian', 'ps' => 'Pashto', 'fa' => 'Persian', 'pl' => 'Polish', 'pt' => 'Portuguese', 'ma' => 'Punjabi', 'ro' => 'Romanian', 'ru' => 'Russian', 'sm' => 'Samoan', 'gd' => 'Scots Gaelic', 'sr' => 'Serbian', 'st' => 'Sesotho', 'sn' => 'Shona', 'sd' => 'Sindhi', 'si' => 'Sinhala', 'sk' => 'Slovak', 'sl' => 'Slovenian', 'so' => 'Somali', 'es' => 'Spanish', 'su' => 'Sundanese', 'sw' => 'Swahili', 'sv' => 'Swedish', 'tg' => 'Tajik', 'ta' => 'Tamil', 'te' => 'Telugu', 'th' => 'Thai', 'tr' => 'Turkish', 'uk' => 'Ukrainian', 'ur' => 'Urdu', 'uz' => 'Uzbek', 'vi' => 'Vietnamese', 'cy' => 'Welsh', 'xh' => 'Xhosa', 'yi' => 'Yiddish', 'yo' => 'Yoruba', 'zu' => 'Zulu'];

    private static $url_traduc = 'https://translate.googleapis.com/translate_a/single?client=gtx&sl=%s&tl=%s&dt=t&q=%s';

    private static $error = false;
    private static $error_string = '';

    private static $took = 0;

    public static $input_text = '';
    public static $output_text = '';
    public static $input_lang = '';
    public static $output_lang = '';

    /**
     * Verifica las datos puesto, como lenguaje de entrada y salida y el texto puesto
     * @param string text
     * @param string lang_input
     * @param string lang_output
     */
    private static function check()
    {

        if (empty(self::$input_text)) {
            self::$error = true;
            self::$error_string = 'Put text to translate';
        }

        if (!isset(self::$langs_code[self::$input_lang])) {
            self::$error = true;
            self::$error_string = 'Invalid lang code input (' . self::$input_lang . ')';
        }

        if (!isset(self::$langs_code[self::$output_lang])) {
            self::$error = true;
            self::$error_string = 'Invalid lang code output (' . self::$output_lang . ')';
        }

    }

    /**
     * Traduce un texto con la api de google
     * @param string $input_text
     * @param string $input_lang
     * @param string $output_lang
     */
    private static function translate()
    {

        $encode_text = urlencode(self::$input_text);
        $url = sprintf(self::$url_traduc, self::$input_lang, self::$output_lang, $encode_text);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_USERAGENT, 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1');
        $output = curl_exec($ch);
        curl_close($ch);

        if (empty($output)) {
            self::$error = true;
            self::$error_string = 'Unknown error, try again';
        } else {
            $response = json_decode($output);
            $lineas = count($response[0]);
            $content = '';
            for ($i = 0; $i < $lineas; $i++) {
                $content .= $response[0][$i][0];
            }
            $lang_in = $response['2'];

            if ($lang_in == self::$output_lang) {
                self::$error = true;
                self::$error_string = 'The text is already in the language you want to translate (' . self::$langs_code[$lang_in] . ')';
            } else {
                self::$output_text = $content;
                self::$input_lang = self::$langs_code[$lang_in];
                self::$output_lang = self::$langs_code[self::$output_lang];
            }

        }

    }

    /**
     * Recibe los datos para traducir
     * @return object
     */
    public static function tr($in_text, $in_lang = 'auto', $ou_lang = 'en')
    {

        self::$input_text = $in_text;
        self::$input_lang = $in_lang;
        self::$output_lang = $ou_lang;
        self::check();

        self::$took = round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 4);

        if (self::$error == true) {

            return (object) [
                'error' => self::$error,
                'msg' => self::$error_string,
                'took' => self::$took,
            ];

        }

        self::translate();

        if (self::$error == true) {

            return (object) [
                'error' => self::$error,
                'msg' => self::$error_string,
                'took' => self::$took,
            ];

        } else {

            return (object) [
                'error' => self::$error,
                'took' => self::$took,
                'input' => (object) [
                    'text' => self::$input_text,
                    'lang' => self::$input_lang,
                ],
                'output' => (object) [
                    'text' => str_replace(['<', '>'], ['&lt;', '&gt;'], self::$output_text),
                    'lang' => self::$output_lang,
                ],
            ];

        }

    }

}
