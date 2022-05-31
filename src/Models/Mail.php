<?php

namespace App\Models;

use App\Db\Query;
use App\Models\Bot;

class Mail {
    
    /**
     * Guardar una cuenta en la db
     */
    public static function Save(string $mail, string $pass, string $accid, ?string $token = null): string
    {
        $id = Bot::RanId();

        $query = "INSERT INTO mailtm (id, token, acc_id, mail, pass, created) VALUES (:id, :token, :accid, :mail, :pass, :created)";
        $datas = [':id' => $id, ':token' => $token, ':accid' => $accid, ':mail' => $mail, ':pass' => $pass, ':created' => time()];

        Query::Sql($query, $datas);
        
        return $id;
    }

    /**
     * Actualizar el jwt token de una cuenta
     */
    public static function UpdateToken(string $id, string $token)
    {
        $query = "UPDATE mailtm SET token = :token WHERE id = :id";
        $datas = [':id' => $id, ':token' => $token];

        return Query::Sql($query, $datas);
    }

    /**
     * Obtener los datos de una cuenta
     */
    public static function Get(string $id): array
    {
        $res = Query::Sql("SELECT * FROM mailtm WHERE id = :id", [':id' => $id]);
        if (!$res['ok']) return $res;
        $res['datas']['ok'] = true;
        return $res['datas'];
    }

    /**
     * Eliminar una cuenta de la db     
     */
    public static function Delete(string $id)
    {
        return Query::Sql("DELETE FROM mailtm WHERE id = :id", [':id' => $id]);
    }

    /**
     * Delete all accounts older than $days
     */
    public static function DeleteOld(int $day):bool
    {
        $seconds = $day * 24 * 60 * 60;
        $accs = Query::GetAllRows("SELECT * FROM mailtm WHERE created < :created", [':created' => time() - $seconds]);
        if ($accs['ok']) {
            foreach ($accs['rows'] as $acc) {
                self::Delete($acc['id']);
            }
            Query::Sql("DELETE FROM mailtm WHERE created < :created", [':created' => time() - $seconds]);
            return true;
        }
        return false;
    }
}