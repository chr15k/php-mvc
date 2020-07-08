<?php

namespace Chr15k\Core\Support;

use Dotenv\Dotenv;

class Env
{
	/**
     * Our single Env instance.
     * 
     * @var Dotenv
     */
    private static $instance;

    /**
     * Disable instantiation.
     */
    private function __construct()
    {
        // Private to disable instantiation.
    }

    public static function loadDotenv()
    {
    	if (is_null(static::$instance)) {
        	static::$instance = Dotenv::createUnsafeImmutable(root_path());
        }

        static::$instance->load();
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