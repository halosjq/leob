<?php

namespace App\Config\Crypto;

use RuntimeException;

/**
 * Read and generate key file
 * @method static read(string $path): string
 * @method static generate(string $path): string
 */
class Key {
    /**
     * Reads key file contents
     *
     * @param string $path File path
     *
     * @return string
     */
    public static function read(string $path): string
    {
        if (empty($path)) {
            throw new RuntimeException('Key path is empty.');
        }

        if (!file_exists($path) || is_dir($path)) {
            throw new RuntimeException('Key file not found.');
        }

        $key_file = fopen($path, 'rb');
        $secret = fread($key_file, filesize($path));

        fclose($key_file);

        return $secret;
    }

    
    /**
     * Generates key file
     *
     * @param string $path File ouput save
     *
     * @return string
     * @throws Exception
     */
    public static function generate(string $path): string
    {
        if (empty($path)) {
            throw new RuntimeException('Key path is empty.');
        }

        $key_file = fopen($path, 'wb');

        if (function_exists('random_bytes')) {
            $secret = bin2hex(random_bytes(128));
        } else {
            $secret = bin2hex(openssl_random_pseudo_bytes(128));
        }

        fwrite($key_file, $secret);
        fclose($key_file);

        return $secret;
    }
}