<?php

namespace Chr15k\Core\Database;

use PDO;
use Chr15k\Core\Database\Connector as DB;

abstract class Model
{
    protected static $table;

    public static function all()
    {
        $statement = DB::run('SELECT * FROM ' . static::$table);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $statement = DB::run('SELECT * FROM ' . static::$table . ' WHERE id  = ' . $id);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}