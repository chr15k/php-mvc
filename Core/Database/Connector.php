<?php

namespace Chr15k\Core\Database;

use PDO;

class Connector
{
    /**
     * Our Database instance singleton.
     *
     * @var PDO
     */
    private static $instance;

    private function __construct() {}
    final public function __clone() {}
    final public function __wakeup() {}

    public static function __callStatic($method, $args)
    {
        return call_user_func_array([static::instance(), $method], $args);
    }

    public static function run($sql, $args = [])
    {
        if (! $args) {
            return static::instance()->query($sql);
        }

        $stmt = static::instance()->prepare($sql);
        $stmt->execute($args);

        return $stmt;
    }

    public static function instance()
    {
        if (is_null(static::$instance)) {
            $config = config()->get('database');

            $dsn = sprintf(
                "%s%s%s%s%s%s%s",
                'mysql:host=',
                $config['host'],
                ';port=',
                $config['port'],
                ';dbname=',
                $config['name'],
                ';charset=utf8'
            );

            static::$instance = new PDO(
                $dsn,
                $config['user'],
                $config['pass']
            );

            // Throw an Exception when an error occurs
            static::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return static::$instance;
    }
}