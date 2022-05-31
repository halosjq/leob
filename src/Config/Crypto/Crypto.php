<?php

namespace App\Config\Crypto;

use Exception;
use RuntimeException;

class Crypto {
    public const ALGO = 'aes256';

    public static function DecryptText(string $str, string $secret = '', string $algo = self::ALGO): string
    {
        $secret = hash('SHA256', $secret, true);
        if (!in_array($algo, openssl_get_cipher_methods(true), true)) {
            throw new RuntimeException('Unknown algorithm. For a list of supported algorithms visit: (https://secure.php.net/manual/en/function.openssl-get-cipher-methods.php)');
        }
        if (file_exists($secret) && !is_dir($secret)) {
            $secret = Key::read($secret);
        }
        $encryptionKey = base64_decode($secret);
        list($Encrypted_Data, $InitializationVector ) = array_pad(explode('::', base64_decode($str), 2), 2, null);
        return openssl_decrypt($Encrypted_Data, $algo, $encryptionKey, 0, $InitializationVector);
    }

    public static function EncryptText(string $str, string $secret = '', string $algo = self::ALGO): string
    {
        $secret = hash('SHA256', $secret, true);
        if (!in_array($algo, openssl_get_cipher_methods(true), true)) {
            throw new RuntimeException('Unknown algorithm. For a list of supported algorithms visit: (https://secure.php.net/manual/en/function.openssl-get-cipher-methods.php)');
        }
        if (file_exists($secret) && !is_dir($secret)) {
            $secret = Key::read($secret);
        }
        $encryptionKey = base64_decode($secret);
        $InitializationVector  = openssl_random_pseudo_bytes(openssl_cipher_iv_length($algo));
        $EncryptedText = openssl_encrypt($str, $algo, $encryptionKey, 0, $InitializationVector);
        return base64_encode($EncryptedText . '::' . $InitializationVector);
    }
    
    /**
     * Decrypts environment file and returns content in a string
     *
     * @param string $path Path to file
     * @param string $secret Secret key
     * @param string $algo Algorithm
     *
     * @return string
     */
    public static function decrypt(string $path = '.env', string $secret = '', string $algo = self::ALGO): string
    {
        if (!file_exists($path)) {
            throw new RuntimeException('File does not exist.');
        }

        $handler = fopen($path, 'rb');
        $cipher = fread($handler, filesize($path));
        fclose($handler);
        return self::DecryptText($cipher, $secret, $algo);
    }

    /**
     * Encrypts files and returns content in a string
     *
     * @param string $path File name to encrypt
     * @param string $secret Key use to encrypt
     * @param string $algo Algorithm
     * @param string|null $output File name to save when $save is true
     * @param bool $save Pass True to save the file
     *
     * @throws Exception
     */
    public static function encrypt(string $path = '.env', string $secret = '', string $algo = self::ALGO, ?string $output = null, bool $save = true): string
    {
        if (!file_exists($path)) {
            throw new RuntimeException('File does not exist.');
        }

        $output = $output ?? $path.'.enc';
        $handler = fopen($path, 'rb');
        $data = fread($handler, filesize($path));
        fclose($handler);

        $encrypt = self::EncryptText($data, $secret, $algo);
        if ($save) {
            $output_file = fopen($output, 'wb');
            fwrite($output_file, $encrypt);
            fclose($output_file);
        }
        return $encrypt;
    }
}