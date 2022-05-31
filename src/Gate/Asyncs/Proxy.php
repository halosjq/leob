<?php

namespace App\Gate\Asyncs;

use App\Gate\Asyncs\Req;

class Proxy
{

    /**
     * Autoruter array
     */
    public static function AutoRouterArr(?array $args): void
    {
        if ($args == null) {
            return;
        }

        foreach ($args as $i => $value) {

            if (is_array($value)) {
                self::AutoRouter($value, $i);
            } else {
                trigger_error('$args must be array of array', E_WARNING);
            }
        }
    }

    /**
     * Detect the tunnel configuration
     */
    public static function AutoRouter(?array $arg, ?int $i): void
    {
        if ($arg == null) {
            return;
        }

        switch ($arg['METHOD']) {
            case 'TUNNEL':self::Tunel($arg, $i);
                break;
            case 'CUSTOM':self::Auth($arg, $i);
                break;
        }
    }

    /**
     * Set a proxy tunnel configuration to current curl structure, support: HTTP/S, SOCKS4, SOCKS5
     */
    private static function Tunel(?array $args, ?int $i): void
    {
        if ($args == null) {
            return;
        }

        Req::SetOpt($i, [
            CURLOPT_PROXY => $args['SERVER'],
            CURLOPT_HTTPPROXYTUNNEL => true,
        ]);
    }

    /**
     * Proxy auth
     */
    private static function Auth(?array $args, ?int $i): void
    {
        if ($args == null) {
            return;
        }

        Req::SetOpt($i, [
            CURLOPT_PROXY => $args['SERVER'],
            CURLOPT_PROXYUSERPWD => $args['AUTH'],
        ]);
    }
}
