<?php

if (! function_exists('merge_paths')) {
    /**
     * Merge several parts of URL or filesystem path in one path.
     *
     * @param string $path1
     * @param string $path2
     */
    function merge_paths($path1, $path2)
    {
        $paths = func_get_args();
        $last_key = func_num_args() - 1;
        array_walk($paths, function(&$val, $key) use ($last_key) {
            switch ($key) {
                case 0:
                    $val = rtrim($val, '/ ');
                    break;
                case $last_key:
                    $val = ltrim($val, '/ ');
                    break;
                default:
                    $val = trim($val, '/ ');
                    break;
            }
        });
     
        $first = array_shift($paths);
        $last = array_pop($paths);
        $paths = array_filter($paths); // clean empty elements to prevent double slashes
        array_unshift($paths, $first);
        $paths[] = $last;

        return implode('/', $paths);
    }
}

if (! function_exists('template_path')) {
    /**
     * Template storage path.
     *
     * @return string
     */
    function template_path()
    {
        return dirname(__DIR__) . '/../app/Views';
    }
}

if (! function_exists('root_path')) {
    /**
     * Root path.
     *
     * @return string
     */
    function root_path()
    {
        return dirname(__DIR__) . '/../';
    }
}

if (! function_exists('template_cache_path')) {
    /**
     * Template cache path.
     *
     * @return string
     */
    function template_cache_path()
    {
        return root_path() . '/storage/cache/views';
    }
}

if (! function_exists('cache_path')) {
    /**
     * Cache path.
     *
     * @return string
     */
    function cache_path()
    {
        return root_path() . '/storage/cache/data';
    }
}

if (! function_exists('app_path')) {
    /**
     * App path.
     *
     * @return string
     */
    function app_path()
    {
        return dirname(__DIR__) . '/../app/';
    }
}

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        return $value;
    }
}

if (! function_exists('config')) {

    /**
     * Returns the config instance.
     *
     * @return Config
     */
    function config()
    {
        return \Chr15k\Core\Config\Config::getInstance();
    }
}

if (! function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof \Closure ? $value() : $value;
    }
}