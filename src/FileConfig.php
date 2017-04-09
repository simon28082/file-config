<?php
namespace CrCms\FileConfig;

use Illuminate\Support\Arr;

/**
 * Class FileConfig
 * @package CrCms\FileConfig
 */
class FileConfig
{

    /**
     * @var array
     */
    protected $files = [];


    /**
     * FileConfig constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->files = $this->formatFile($config);
    }


    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key) : bool
    {
        $keys = $this->formatKey($key);

        return (bool)Arr::has($this->read($keys['name']),$keys['key']);
    }


    /**
     * @param string $key
     * @param string $default
     * @return string
     */
    public function get(string $key, string $default = '') : string
    {
        $keys = $this->formatKey($key);

        return Arr::get($this->read($keys['name']),$keys['key'],$default);
    }


    /**
     * @param string $key
     * @return array
     */
    public function all(string $key) : array
    {
        $keys = $this->formatKey($key);

        return $this->read($keys['name']);
    }


    /**
     * @param string $key
     * @param string $value
     */
    public function put(string $key, string $value)
    {
        $keys = $this->formatKey($key);

        $config = $this->read($keys['name']);

        $value = trim($value);

        if ($this->has($key)) {
            $config = Arr::set($config,$keys['key'],$value);
        } else {
            $config = Arr::prepend($config,$value,$keys['key']);
        }

        $this->write($keys['name'],$config);
    }


    /**
     * @param string $key
     */
    public function destroy(string $key)
    {
        $keys = $this->formatKey($key);

        $config = $this->read($keys['name']);

        Arr::forget($config,$keys['key']);

        $this->write($keys['name'],$config);
    }


    /**
     * @param string $key
     * @return array
     */
    protected function formatKey(string $key) : array
    {
        $keys = explode('.',$key);

        $name = array_shift($keys);
        $key = implode('.',$keys);

        return compact('name','key');
    }


    /**
     * @param array $config
     * @return array
     */
    protected function formatFile(array $config) : array
    {
        foreach ($config['files'] as $key=>$file) {
            $drive = is_numeric($key) ? $config['default_drive'] : $key;
            $this->files[$file] = $drive;
        }

        return $this->files;
    }


    /**
     * @param string $key
     * @return array
     */
    protected function read(string $key) : array
    {
        foreach ($this->files as $file=>$drive) {

            $filename = pathinfo($file,PATHINFO_FILENAME);

            if ($filename === $key) {
                if (file_exists($file)) {
                    return (new $drive)->read(file_get_contents($file));
                }
            }
        }

        return [];
    }


    /**
     * @param string $key
     * @param array $config
     * @return int
     */
    protected function write(string $key, array $config) : int
    {
        foreach ($this->files as $file=>$drive) {

            $filename = pathinfo($file,PATHINFO_FILENAME);

            if ($filename === $key) {
                return file_put_contents($file,(new $drive)->write($config));
            }
        }

        return 0;
    }
}