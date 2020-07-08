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

    /**
     * Disable instantiation.
     */
    private function __construct()
    {
        echo 'Connection created.';
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            $config = config('database');

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

            static::$instance = new PDO($dsn, $config['user'], $config['pass']);

            // Throw an Exception when an error occurs
            static::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return static::$instance;
    }

    /**
     * Disable the cloning of this class.
     * 
     * @return void
     */
    final public function __clone()
    {
        throw new Exception('Feature disabled.');
    }

    /**
     * Disable the wakeup of this class.
     * 
     * @return void
     */
    final public function __wakeup()
    {
        throw new Exception('Feature disabled.');
    }
}