<?php

namespace App\Db;

use App\Config\ErrorLog;

class Query extends Connection
{
    public static $instance;
    private static $db;

    /**
     * 
     */
    private static function ExecuteQuery($datas='') {
        if (empty($datas)) {
            self::$instance->execute();
        } else {
            self::$instance->execute($datas);
        }
    }

    /**
     * Realizar una consulta y la valida
     * @return array
     */
    public static function Sql(string $query, $datas = '') : array 
    {
        try {
            self::$db = self::getConection();
            self::$instance = self::$db->prepare($query);

            self::ExecuteQuery($datas);

            $afectRow = self::$instance->rowCount();

            return ['ok' => ($afectRow != 0), 'afectRow' => $afectRow, 'datas' => self::$instance->fetch(\PDO::FETCH_ASSOC), 'obj' => self::$instance];

        } catch (\PDOException $e) {
            ErrorLog::ReportToChannel('[sql] [query] '.$query);
            ErrorLog::ReportToChannel('[sql] [error] '.$e);
            die('Internal server error');
        }

    }

    /**
     * Obtener multiples filas de un array
     *
     * @param string $args Consulta SQL
     * @param string $datas Datos de la consulta
     * @return array
     */
    public static function GetAllRows(string $query, $datas = ''): array
    {
        $responses = [];

        try {
            self::$db = self::getConection();
            self::$instance = self::$db->prepare($query);
            
            self::ExecuteQuery($datas);

            $rows = self::$instance->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $responses[] = $row;
            }

            return ['ok' => !empty($responses), 'count' => self::$instance->rowCount(), 'rows' => $responses];
            
        } catch (\PDOException $e) {
            ErrorLog::ReportToChannel('[sql] [query] '.$query);
            ErrorLog::ReportToChannel('[sql] [error] '.$e);
            die('Internal server error');
        }
    }

    /**
     * Return only the number of rows affected
     */
    public static function GetCount(string $query, $datas = ''):int
    {
        try {
            self::$db = self::getConection();
            self::$instance = self::$db->prepare($query);

            self::ExecuteQuery($datas);

            return (int) self::$instance->rowCount();
        } catch (\PDOException $e) {
            ErrorLog::ReportToChannel('[sql] [query] '.$query);
            ErrorLog::ReportToChannel('[sql] [error] '.$e);
            die('Internal server error');
        }
    }
}
