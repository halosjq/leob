<?php

namespace App\Models;

use App\Config\{GetConfig, StringUtils};
use App\Db\Query;
use App\Models\Bot;

class Cmd
{

    /**
     * Validar un comando con el texto de entrada
     */
    public static function Is(string $cmd_name, string $file = null): bool
    {
        $texto = Bot::$update['message']['text'];
        $separators = explode(' ', GetConfig::Get('CMD_PREFIX'));
        if (in_array($texto[0], $separators)) {

            $text = explode(' ', substr($texto, 1))[0];
            $cmd = explode('|', $cmd_name);

            if (in_array($text, $cmd)) {
                if ($file != null && file_exists($file)) {
                    require $file;
                }

                return true;
            }
        }
        return false;
    }

    /**
     * Obtener un comando de la DB y procesar la información obtenida
     */
    public static function Get(string $cmd_name): array
    {

        $result = Query::Sql("SELECT * FROM cmds WHERE cmd = :cmd_name", [':cmd_name' => $cmd_name]);
        if ($result['ok']) {
            $data = $result['datas'];
            $data['ok'] = true;
            $data['afectRow'] = $result['afectRow'];
            $data['status'] = (bool) $data['status'];
            $data['test'] = (bool) $data['test'];
            return $data;
        }
        return $result;
    }

    /**
     * Validar el string input y obtener un comando de la DB si es que existe
     */
    public static function Validate(string $txt = null): array
    {
        $message = $txt ?? Bot::$update['message']['text'];
        $message = str_replace(["\n", "'", '@', '&', 'AND', '=', '1=1', "'", '`'], ' ', $message);

        $part1 = substr($message, 1);
        $first = strtolower(explode(' ', $part1)[0]);
        $separators = explode(' ', GetConfig::Get('CMD_PREFIX'));
        if (in_array($message[0], $separators) && !empty($part1)) {
            // Valid format
            $data = self::Get(StringUtils::RemoveNoAlpha($first));
            if ($data['ok']) {
                // Valid cmd
                $data['format'] = true;
                $data['valid'] = true;
                return $data;
            } else {
                return ['format' => true, 'valid' => false];
            }
        } else {
            // Invalid cmd
            return ['format' => false, 'valid' => false];
        }
    }

    /**
     * Añadir un comando a la DB, devuelve true en caso de exito
     */
    public static function AddCmd(string $cmd, string $route, string $form, string $format, string $name, string $type = 'main', string $access = 'free'): bool
    {
        $query = "INSERT INTO cmds (cmd, route, form, format, review, type, access, name) VALUES (:cmd_name, :ruta, :form, :format, :review, :type, :access, :name)";
        $datas = [':cmd_name' => $cmd, ':ruta' => $route, ':form' => $form, ':format' => $format, ':review' => time(), ':type' => $type, ':access' => $access, ':name' => $name];
        $res = Query::Sql($query, $datas);
        return $res['ok'];
    }

    /**
     * Activar/Desactivar un comando
     */
    public static function OffOnCmd(string $cmd_name, string $reason = '', bool $status = true): bool
    {
        $result = Query::Sql("UPDATE cmds SET status = :vstatus, msg = :msg WHERE cmd = :cmd", [':vstatus' => $status, ':msg' => $reason, ':cmd' => $cmd_name]);
        return $result['ok'];
    }

    /**
     * Eliminar un comando de la DB
     */
    public static function DeleteCmd(string $cmd_name): bool
    {
        $result = Query::Sql("DELETE FROM cmds WHERE cmd = :cmd", [':cmd' => $cmd_name]);
        return $result['ok'];
    }

    /**
     * Actualizar un comando de la DB solo para test
     */
    public static function OffOnTest(string $cmd_name, bool $is_test, string $reason = ''): bool
    {
        $result = Query::Sql("UPDATE cmds SET test = :vtest WHERE cmd = :cmd, msg = :msg", [':vtest' => $is_test, ':cmd' => $cmd_name, ':msg' => $reason]);
        return $result['ok'];
    }

    /**
     * Actualizar todos los valores de un comando
     */
    public static function UpdateValues(string $cmd_name, array $last, string $route = null, string $form = null, string $format = null, string $type = null, string $access = null, string $name = null, string $link = null, bool $status = null, bool $test = null)
    {

        $route = $route ?? $last['route'];
        $form = $form ?? $last['form'];
        $format = $format ?? $last['format'];
        $type = $type ?? $last['type'];
        $access = $access ?? $last['access'];
        $name = $name ?? $last['name'];
        $link = $link ?? $last['link'];
        $status = $status ?? $last['status'];
        $test = $test ?? $last['test'];

        $query = "UPDATE cmds SET route = :ruta, form = :form, format = :vformat, type = :vtype, access = :access, name = :vname, link = :link, status = :vstatus, test = :test WHERE cmd = :cmd_name";
        $data = [':ruta' => $route, ':form' => $form, ':vformat' => $format, ':vtype' => $type, ':access' => $access, ':vname' => $name, ':link' => $link, ':vstatus' => $status, ':test' => $test, ':cmd_name' => $cmd_name];
        return Query::Sql($query, $data);
    }

    /**
     * Obtener todos los comandos de la DB según el tipo y nivel de acceso
     */
    public static function GetAll(string $first = '.', string $type = 'tool', string $access = 'all', int $parts = 5): array
    {
        $query = "SELECT * FROM `cmds` WHERE `type` = :cmd";
        $datas = [':cmd' => $type];
        if ($access != 'all') {
            $query .= " AND `access` = :access";
            $datas[':access'] = $access;
        }
        $query .= " ORDER BY `review` ASC";
        $res = Query::GetAllRows($query, $datas);

        $emoji = function(bool $status, bool $test) {
            if ($status && !$test) return '✅';
            if ($test) return '⚠️';
            return '❌';
        };

        if (!$res['ok']) {
            return ['ok' => false, 'msg' => '<b>No commands found (<i>'.$type.':'.$access.'</i>)</b>'];
        }

        $cmds = [];

        foreach ($res['rows'] as $comn) {
            $comn['status'] = (bool) $comn['status'];
            $comn['test'] = (bool) $comn['test'];

            $txt = "<b>&gt;_ <i><u>".$comn['name']."</u></i></b> ".$emoji($comn['status'], $comn['test'])."\n     ";
            $txt .= ($comn['status']) ? '<b>Format:</b> <code>'.$first.$comn['cmd'].' '.$comn['format']."</code>\n\n" : '<b>Reason:</b> <i>'.$comn['msg']."</i>\n\n";

            $cmds[] = $txt;
        }

        return ['ok' => true, 'cmd' => array_chunk($cmds, $parts), 'count' => $res['count']];
    }

}
