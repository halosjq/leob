<?php

namespace App\Db;

use \PDO;
use App\Config\ErrorLog;

class Connection
{

    private static $host = '';
    private static $user = '';
    private static $password = '';
    private static $hostFrom = '';

    public static $dsn;

    private static function from(string $host, string $user, string $password)
    {
        self::$host = $host;
        self::$user = $user;
        self::$password = $password;
    }

    /**
     * Set data from conect to the database
     *
     * @param string $ip IP or hostname of the database server
     * @param string $port PORT myql
     * @param string $dbname Data base name
     */
    public static function PrepareConection(string $ip, string $port, string $dbname, string $charset = 'utf8')
    {
        self::$hostFrom = 'mysql:host=' . $ip . ';port=' . $port . ';dbname=' . $dbname;
        self::from(self::$hostFrom, $_ENV['DB_USER'], $_ENV['DB_PASS']);
    }

    /**
     * Get PDO connection, die in case of fail to conect to db
     */
    public static function getConection()
    {
        try {
            if (self::$dsn == null) {
                $opt = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
                self::$dsn = new PDO(self::$host, self::$user, self::$password, $opt);
                self::$dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Eliminar esto, solo para pruebas
            }
            return self::$dsn;

        } catch (\PDOException $p) {
            ErrorLog::ReportToChannel('[db] [error] [fatal]' . $p);
            die('Fatal error: Failed to connect to DataBase, show logs for know more');
        }
    }

    /**
     * Eliminar la conexión
     */
    public static function Disconect(): void
    {
        self::$dsn = null;
    }
}

Connection::PrepareConection($_ENV['DB_HOST'], '3306', $_ENV['DB_NAME']);
