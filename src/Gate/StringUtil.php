<?php

namespace App\Gate\Asyncs;

class StringUtil
{

    /**
     * Cambiar el tipo de dato segun el tipo
     * @param mixed $data
     */
    public static function DataType($data, bool $encode = true)
    {
        if (empty($data)) {
            return false;
        } elseif (is_array($data) || is_object($data)) {
            return ($encode) ? json_encode($data) : http_build_query($data);
        } else {
            return $data;
        }
    }

    /**
     * Obtener un elemento aleatorio de un array
     */
    public static function GetRandArr(array $input): string
    {
        $input = $input[array_rand($input)];
        return trim($input);
    }

    /**
     * Get a rand value from specify file.txt
     * @return string
     */
    public static function GetRandVal(string $file): string
    {
        $_ = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return self::GetRandArr($_);
    }

    /**
     * Duplica un string o un array
     * @param array|object|string|int $str A duplicar
     * @param integer $cant Cantidad de veces a duplicar
     */
    public static function Duplicate($str, int $cant = 10): array
    {
        $new = array();
        for ($i = 0; $i < $cant; $i++) {
            $new[] = $str;
        }
        return $new;
    }

    /**
     * Detect array of arrays
     */
    public static function ArrayOfArrays($input): bool
    {
        if (is_string($input) || empty($input) || is_bool($input) || is_null($input)) {
            return false;
        }

        if (is_array($input)) {
            foreach ($input as $value) {
                if (!is_array($value)) {
                    return false;
                }

            }
            return true;
        }
        return false;
    }

}
