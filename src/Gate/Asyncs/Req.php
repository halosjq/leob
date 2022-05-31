<?php

namespace App\Gate\Asyncs;

use App\Gate\Asyncs\Cookie;
use App\Gate\Asyncs\Headers;
use App\Gate\Asyncs\Proxy;
use App\Gate\Asyncs\Run;
use App\Gate\Asyncs\StringUtil;

class Req
{

    public static $ch;
    public static $mh;
    public static $urls;
    public static $total;
    public static $out;
    public static $out_headers;
    public static $in_headers;

    private static $default = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLINFO_HEADER_OUT => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_AUTOREFERER => true,
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
    ];

    /**
     * Set urls
     */
    public static function Set(array $urls): void
    {
        self::$urls = $urls;
        self::$total = count($urls);
    }

    /**
     * curl_multi_init and curl_init
     */
    private static function init(): void
    {
        self::$mh = curl_multi_init();

        foreach (self::$urls as $i => $value) {
            self::$ch[$i] = curl_init($value);
            self::SetOpt($i, self::$default);
        }
    }

    /**
     * Add curl_opt config
     */
    public static function SetOpt(int $resource, array $option): void
    {
        curl_setopt_array(self::$ch[$resource], $option);
    }

    public static function Get(array $urls, array $headers = null, array $server = null, $cookie = null): array
    {
        self::Set($urls);
        self::init();
        for ($i = 0; $i < self::$total; $i++) {
            self::CheckParam($i, $headers, $server, $cookie);
            self::SetOpt($i, [CURLOPT_USERAGENT => self::UserAgent()]);
        }
        return Run::Exec();
    }

    public static function Post(array $urls, $post = null, array $headers = null, array $server = null, $cookie = null): array
    {
        self::Set($urls);
        self::init();
        $post = (StringUtil::ArrayOfArrays($post)) ? $post : StringUtil::Duplicate($post, self::$total);
        for ($i = 0; $i < self::$total; $i++) {
            self::CheckParam($i, $headers, $server, $cookie);
            self::SetOpt($i, [
                CURLOPT_USERAGENT => self::UserAgent(),
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => StringUtil::DataType($post[$i]),
            ]);
        }
        return Run::Exec();
    }

    public static function Custom($method, array $urls, $post = null, array $headers = null, array $server = null, $cookie = null)
    {
        self::Set($urls);
        self::init();

        $method = (is_string($method) && $method != null) ? StringUtil::Duplicate($method, self::$total) : $method;
        $post = (StringUtil::ArrayOfArrays($post)) ? $post : StringUtil::Duplicate($post, self::$total);
        $server = (StringUtil::ArrayOfArrays($server)) ? $server : StringUtil::Duplicate($server, self::$total);
        $cookie = (is_array($cookie)) ? $cookie : StringUtil::Duplicate($cookie, self::$total);

        for ($i = 0; $i < self::$total; $i++) {
            self::CheckParam($i, $headers, $cookie, $server);
            self::SetOpt($i, [
                CURLOPT_CUSTOMREQUEST => strtoupper($method[$i]),
                CURLOPT_USERAGENT => self::UserAgent(),
                CURLOPT_POSTFIELDS => StringUtil::DataType($post[$i]),
            ]);
        }
        return Run::Exec();
    }

    /**
     * Add headers, cookie, and proxy
     */
    public static function CheckParam(int $i, $header, $cookie, $server): void
    {

        if ($header != null && is_array($header[$i])) {
            Headers::Add($header[$i], $i);
        }
        if ($cookie != null && is_string($cookie[$i])) {
            Cookie::Set($cookie[$i], $i);
        }
        if ($server != null && is_array($server[$i])) {
            Proxy::AutoRouter($server[$i], $i);
        }
    }

    /**
     * Obtiene un useragent random
     * @return string
     */
    public static function UserAgent()
    {
        $uas = [
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:83.0) Gecko/20100101 Firefox/83.0",
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:81.0) Gecko/20100101 Firefox/81.0",
            "Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:80.0) Gecko/20100101 Firefox/80.0",
            "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:80.0) Gecko/20100101 Firefox/80.0",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:81.0) Gecko/20100101 Firefox/81.0",
            "Mozilla/5.0 (X11; Linux x86_64; rv:80.0) Gecko/20100101 Firefox/80.0",
            "Mozilla/5.0 (X11; Linux x86_64; rv:75.0) Gecko/20100101 Firefox/75.0",
            "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:79.0) Gecko/20100101 Firefox/79.0",
            "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:77.0) Gecko/20100101 Firefox/77.0",
            "Mozilla/5.0 (X11; U; Linux i686; fr; rv:1.8) Gecko/20060110 Debian/1.5.dfsg-4 Firefox/1.5",
            "Mozilla/5.0 (Android 10; Mobile; rv:79.0) Gecko/79.0 Firefox/79.0",
            "Mozilla/5.0 (Android 9; Mobile; rv:68.6.0) Gecko/68.6.0 Firefox/68.6.0",
            "Mozilla/5.0 (Android 7.1.1; Mobile; rv:68.0) Gecko/68.0 Firefox/68.0",
            "Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_2 like Mac OS X) AppleWebKit/603.2.4 (KHTML, like Gecko) FxiOS/7.5b3349 Mobile/14F89 Safari/603.2.4",
            "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.1 Safari/605.1.15",
            "Mozilla/5.0 (iPhone; CPU iPhone OS 13_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.5 Mobile/15E148 Snapchat/10.77.5.59 (like Safari/604.1)",
            "Mozilla/5.0 (iPhone; CPU iPhone OS 13_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/80.0.3987.95 Mobile/15E148 Safari/604.1",
        ];
        return StringUtil::GetRandArr($uas);
    }

    public static function Async()
    {}
}
