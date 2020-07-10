<?php

namespace Chr15k\Core\Cache;

/**
 * Cache class.
 */
class Cache
{
    /**
     * Cache path.
     * 
     * @var string
     */
    protected $path;

    /**
     * Cache duration.
     *
     * @var int
     */
    protected $duration;

    /**
     * Cache file extension.
     *
     * @var string
     */
    protected $ext;

    /**
     * Cache Constructor.
     *
     * @param   string  $path
     * @param   int     $duration
     * @return  void
     */
    function __construct(string $path, int $duration = 60)
    {
        $this->path = $path;
        $this->duration = $duration;

        $this->ext = '.cache';
    }

    /**
     * Get the cached file.
     *
     * @param  string|int   $key
     * @return string|false
     */
    public function get($key)
    {
        $file = $this->filename($key);

        if (file_exists($file) && time() - filemtime($file) < $this->duration) {
            return unserialize(file_get_contents($file));         
        }

        return false;
    }

    /**
     * Set the cached file.
     *
     * @param  string  $key
     * @param  string  $value
     * @return void
     */
    public function set($key, $value)
    {
        $file = $this->filename($key);

        file_put_contents($file, serialize($value));
    }

    /**
     * Generate a filename for the cached file.
     *
     * @param  string $key
     * @return string
     */
    private function filename($key)
    {
        return merge_paths($this->path, $key . $this->ext);
    }
}