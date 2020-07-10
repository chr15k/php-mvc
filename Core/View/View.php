<?php

namespace Chr15k\Core\View;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    /**
     * The Twig\Environment singleton.
     * 
     * @var Environment
     */
    public static $instance;

    private function __construct() {}
    final public function __clone() {}
    final public function __wakeup() {}

    public static function twigEnvironment()
    {
        if (is_null(static::$instance)) {
            static::$instance = static::buildTwigEnvironment();
        }

        return static::$instance;
    }

    public static function buildTwigEnvironment()
    {
        $loader = new FilesystemLoader(template_path());

        return new Environment($loader, [
            'cache' => template_cache_path(),
            'debug' => (bool) config()->get('app.debug')
        ]);
    }

    public static function make($view, array $args = [])
    {
        echo static::twigEnvironment()->render($view, $args);
    }
}