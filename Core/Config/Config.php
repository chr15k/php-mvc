<?php

namespace Chr15k\Core\Config;

use Chr15k\Core\Support\Arr;
use Chr15k\Core\Support\Str;

class Config
{
    private static $instance;
    private static $items = [];

    private function __construct() {}
    final public function __clone() {}
    final public function __wakeup() {}

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public function has($key)
    {
        return Arr::has($this->items($key), $key);
    }

    public function get($key, $default = null)
    {
        return Arr::get($this->items($key), $key, $default);
    }

    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            $items = $this->items($key);
            Arr::set($items, $key, $value);
        }

        $base = Str::before($key, '.');

        static::$items[$base] = $items;
    }

    private function items($key)
    {
        $base = Str::before($key, '.');

        if (empty($base)) {
            return [];
        }

        if (isset(static::$items[$base])) {
            return static::$items[$base];
        }

        $path = sprintf(
            "%s.php",
            merge_paths(root_path(), 'config', $base)
        );

        if (! file_exists($path)) {
            return [];
        }

        static::$items[$base] = [$base => include $path];

        return static::$items[$base];
    }
}