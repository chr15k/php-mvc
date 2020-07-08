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
        return $_SERVER['DOCUMENT_ROOT'] . '/cache';
    }
}

if (! function_exists('app_path')) {
    /**
     * Template storage path.
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
     * Returns the config as an array.
     *
     * Config files are created in the 'config' directory.
     *
     * @param  string $name
     * @return array
     */
    function config($name)
    {
        $path = sprintf(
            "%s.php",
            merge_paths(root_path(), 'config', $name)
        );

        if (! file_exists($path)) {
            return [];
        }

        return include $path;
    }
}
