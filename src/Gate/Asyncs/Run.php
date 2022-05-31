<?php

namespace App\Gate\Asyncs;

use App\Gate\Asyncs\Req;

class Run
{
    private static array $headersCallBack;
    private static $ms = 100;
    public static $response;
    public static $data;
    public static $info;
    public static $errorStr;
    public static $errorCode;

    /**
     * Run resquest
     * @return array
     */
    public static function Exec()
    {
        self::MultiMakeStdClass(Req::$total);
        for ($i = 0; $i < Req::$total; $i++) {
            Req::SetOpt($i, [CURLOPT_HEADERFUNCTION => createHeaderCallback(self::$headersCallBack[$i])]);
            curl_multi_add_handle(Req::$mh, Req::$ch[$i]);
        }

        $active = null;
        // Ejecuta los recursos
        do {
            $execReturnValue = curl_multi_exec(Req::$mh, $runningHandles);
        } while ($execReturnValue == CURLM_CALL_MULTI_PERFORM);

        // Loop and continue processing the request
        while ($runningHandles && $execReturnValue == CURLM_OK) {
            // !!!!! changed this if and the next do-while !!!!!

            if (curl_multi_select(Req::$mh) != -1) {
                usleep(self::$ms);
            }

            do {
                $execReturnValue = curl_multi_exec(Req::$mh, $runningHandles);
            } while ($execReturnValue == CURLM_CALL_MULTI_PERFORM);
        }

        // Check for any errors
        if ($execReturnValue != CURLM_OK) {
            trigger_error("Curl multi read error $execReturnValue\n", E_USER_WARNING);
        }

        foreach (Req::$urls as $i => $url) {
            // Check for errors

            self::$info[$i] = curl_getinfo(Req::$ch[$i]);
            self::$response[$i] = curl_multi_getcontent(Req::$ch[$i]);

            if (self::$response[$i] === false) {

                $error_code = curl_errno(Req::$ch[$i]);
                $error_string = curl_error(Req::$ch[$i]);

                self::$data[$i] = [
                    'ok' => false,
                    'code' => self::$info[$i]['http_code'],
                    'headers' => [
                        'request' => key_exists('request_header', self::$info[$i]) ? self::parseHeadersHandle(self::$info[$i]['request_header']) : [],
                        'response' => self::parseHeadersHandle(self::$headersCallBack[$i]->rawResponseHeaders),
                    ],
                    'errno' => $error_code,
                    'error' => $error_string,
                    'body' => '',
                ];
            } else {

                self::$data[$i] = [
                    'ok' => true,
                    'code' => self::$info[$i]['http_code'],
                    'headers' => [
                        'request' => self::parseHeadersHandle(self::$info[$i]['request_header']),
                        'response' => self::parseHeadersHandle(self::$headersCallBack[$i]->rawResponseHeaders),
                    ],
                    'body' => self::$response[$i],
                ];
            }

            // Remove and close the handle
            curl_multi_remove_handle(Req::$mh, Req::$ch[$i]);
            curl_close(Req::$ch[$i]);
        }

        // Clean up the curl_multi handle
        curl_multi_close(Req::$mh);
        self::$data['took'] = self::GetTook();
        self::$data['req'] = Req::$total;
        return self::$data;
    }

    private static function MultiMakeStdClass(int $total): void
    {
        for ($i = 0; $i < $total; $i++) {
            $hcd = new \stdClass();
            $hcd->rawResponseHeaders = '';
            self::$headersCallBack[$i] = $hcd;
        }
    }

    /**
     * Get took script
     */
    private static function GetTook($round = 5)
    {
        $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
        return round($time, $round);
    }
    /**
     * Parse Headers
     */
    private static function parseHeaders(string $raw): array
    {
        $raw = preg_split('/\r\n/', $raw, -1, PREG_SPLIT_NO_EMPTY);
        $http_headers = [];

        for ($i = 1; $i < count($raw); $i++) {
            if (strpos($raw[$i], ':') !== false) {
                list($key, $value) = explode(':', $raw[$i], 2);
                $key = trim($key);
                $value = trim($value);
                isset($http_headers[$key]) ? $http_headers[$key] .= ',' . $value : $http_headers[$key] = $value;
            }
        }

        return [$raw['0']??=$raw['0'], $http_headers];
    }

    /**
     * Parse Array
     */
    private static function parseArray(array $raw): array
    {
        if (array_key_exists('request_header', $raw)) {
            list($scheme, $headers) = self::parseHeaders($raw['request_header']);
            $nh['scheme'] = $scheme;
            $nh += $headers;
            $raw['request_header'] = $nh;
        }

        return $raw;
    }

    /**
     * Parse Headers Handle
     */
    private static function parseHeadersHandle($raw): array
    {
        if (empty($raw)) {
            return [];
        }

        list($scheme, $headers) = self::parseHeaders($raw);
        $request_headers['scheme'] = $scheme;
        unset($headers['request_header']);

        foreach ($headers as $key => $value) {
            $request_headers[$key] = $value;
        }

        return $request_headers;
    }
}

/**
 * Local createHeaderCallback
 */
function createHeaderCallback($headersCallBack)
{
    return function ($_, $header) use ($headersCallBack) {
        $headersCallBack->rawResponseHeaders .= $header;
        return strlen($header);
    };
}
