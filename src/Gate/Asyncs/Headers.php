<?php

namespace App\Gate\Asyncs;

use App\Gate\Asyncs\Req;

class Headers
{

    /**
     * Añadir el array de headers a una petición especifica
     */
    public static function Add(?array $header, int $i)
    {
        if ($header == null) {
            return;
        }

        Req::SetOpt($i, [CURLOPT_HTTPHEADER => $header]);
    }

    /**
     * Añadir headers a cada petición
     */
    public static function AddArr(?array $headers)
    {
        if ($headers == null) {
            return;
        }

        foreach ($headers as $i => $value) {
            if (is_array($value)) {
                self::Add($value, $i);
            } else {
                trigger_error('$header must be array of arrays', E_WARNING);
            }
        }
    }
}
