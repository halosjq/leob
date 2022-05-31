<?php

namespace App\Config;

class GetConfig
{

    /** * Array de configuraciones */
    public static $data = [];
    private static $eval = false;

    /**
     * Load the configuration file from .env file
     */
    public static function LoadEnV(string $dir)
    {
        if (is_dir($dir)) {
            try {
                $dotenv = \Dotenv\Dotenv::createImmutable($dir);
                $dotenv->load();
            } catch (\Exception $e) {
                error_log($e->getMessage());
            }
        } else {
            error_log("No se encontro el archivo .env en el directorio: " . $dir);
        }
    }

    /**
     * Custom Dotenv Boolean Support
     */
    public static function evalBool($val)
    {
        $value = strtolower($val);
        switch ($value) {
            case 'true': return true; break;
            case 'false': return false; break;
            default: return $val; break;
        }
    }

    /**
     * Parse the configuration file
     */
    public static function Eval()
    {
        foreach ($_ENV as $i => $v) {
            $v = trim($v);
            $_ENV[$i] = self::evalBool($v);
        }
        self::$eval = true;
    }

    /**
     * Cargar el contenido del archivo de configuración
     */
    public static function load(string $dir = '')
    {
        if (self::$eval == false) {
            // Load the configuration file from .env file
            self::LoadEnV($dir);
            self::Eval();
        }
    }

    /**
     * Obtener la configuración
     */
    public static function Get(string $varName, string $dir = __DIR__ . '/../../')
    {
        self::load();
        return $_ENV[$varName] ?? null;
    }
}
