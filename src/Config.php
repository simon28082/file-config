<?php
namespace CrCms\FileConfig;

use Illuminate\Support\Arr;

class Config
{

    protected $files = [];

    protected static $instance = null;

    private function __construct(array $config)
    {
        $this->files = $this->formatFile($config);
    }

    //a.abc
    public function has(string $key) : bool
    {
        $keys = $this->formatKey($key);
        return (bool)Arr::has($this->read($keys['name']),$keys['key']);
    }


    public function get(string $key,string $default = '') : string
    {
        $keys = $this->formatKey($key);
        return Arr::get($this->read($keys['name']),$keys['key'],$default);
    }


    public function put(string $key,string $value)
    {
        $keys = $this->formatKey($key);

        $config = $this->read($keys['name']);

        $value = trim($value);

        if ($this->has($key)) {
            $config = Arr::set($config,$keys['key'],$value);
        } else {
            $config = Arr::prepend($config,$keys['key'],$value);
        }

        $this->write($keys['name'],$config);
    }


    public function destroy(string $key)
    {
        $keys = $this->formatKey($key);
        $config = $this->read($keys['name']);
        Arr::forget($config,$keys['key']);
    }

    protected function formatKey(string $key) : array
    {
        $keys = explode('.',$key)[0];

        $name = $keys[0];
        $key = implode('.',$keys);

        return compact('name','key');
    }


    protected function formatFile(array $config) : array
    {
        foreach ($config['files'] as $key=>$file) {
            $drive = is_numeric($key) ? $config['default_drive'] : $key;
            $this->files[$file] = $drive;
        }

        return $this->files;
    }

    protected function read(string $key) : array
    {
        foreach ($this->files as $file=>$drive) {

            $filename = pathinfo($file,PATHINFO_FILENAME);

            if ($filename === $key) {
                return (new $drive)->read($file);
            }
        }
    }


    protected function write(string $key,array $config)
    {
        foreach ($this->files as $file=>$drive) {

            $filename = pathinfo($file,PATHINFO_FILENAME);

            if ($filename === $key) {
                return (new $drive)->write($config);
            }
        }
    }

    public static function instance(array $config) : Config
    {
        if (static::$instance instanceof static) {
            return static::$instance;
        }

        static::$instance = new static($config);

        return static::$instance;
    }
}