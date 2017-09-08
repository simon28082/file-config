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
     * @var array
     */
    protected $config = [];

    /**
     * FileConfig constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->files = $this->formatFile();
    }

    /**
     * Determine whether the value exists
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        $keys = $this->formatKey($key);

        return (bool)Arr::has($this->read($keys['name']), $keys['key']);
    }

    /**
     * Get the specified value
     * @param string $key
     * @param string $default
     * @return string
     */
    public function get(string $key, string $default = ''): string
    {
        $keys = $this->formatKey($key);

        return Arr::get($this->read($keys['name']), $keys['key'], $default);
    }

    /**
     * Get all values
     * @param string $key
     * @return array
     */
    public function all(string $key): array
    {
        $keys = $this->formatKey($key);

        return $this->read($keys['name']);
    }

    /**
     * Write new data
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function put(string $key, $value): bool
    {
        $value = $this->formatValue($value);
        $keys = $this->formatKey($key);
        $config = $this->read($keys['name']);

        $config = $this->has($key) ?
            Arr::set($config, $keys['key'], $value) :
            Arr::prepend($config, $value, $keys['key']);

        return (bool)$this->write($keys['name'], $config);
    }

    /**
     * delete data
     * @param string $key
     * @return bool
     */
    public function destroy(string $key): bool
    {
        $keys = $this->formatKey($key);
        $config = $this->read($keys['name']);
        Arr::forget($config, $keys['key']);

        return (bool)$this->write($keys['name'], $config);
    }

    /**
     * Load the new file
     * @param string $path
     * @param string|null $drive
     * @return FileConfig
     */
    public function load(string $path, string $drive = null): self
    {
        $this->files[$path] = $drive ?? $this->config['default_drive'];

        return $this;
    }

    /**
     * Format array key
     * @param string $key
     * @return array
     */
    protected function formatKey(string $key): array
    {
        $keys = explode('.', $key);
        $name = array_shift($keys);
        $key = implode('.', $keys);

        return compact('name', 'key');
    }

    /**
     * Format the file
     * @return array
     */
    protected function formatFile(): array
    {
        foreach ($this->config['files'] as $key => $file) {
            is_numeric($key) ? $drive = $this->config['default_drive'] : list($drive,$file) = [$file,$key];
            $this->files[$file] = $drive;
        }

        return $this->files;
    }

    /**
     * Read the configuration file
     * @param string $key
     * @return array
     */
    protected function read(string $key): array
    {
        foreach ($this->files as $file => $drive) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            if ($filename === $key && file_exists($file)) {
                return (new $drive)->read(file_get_contents($file));
            }
        }

        return [];
    }

    /**
     * Write the configuration file
     *
     * @param string $key
     * @param array $content
     * @return int
     */
    protected function write(string $key, array $content): int
    {
        foreach ($this->files as $file => $drive) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            if ($filename === $key) {
                return file_put_contents($file, (new $drive)->write($content));
            }
        }

        return 0;
    }

    /**
     * @param $data
     * @return string
     */
    protected function formatValue($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => &$value) {
                $value = $this->formatValue($value);
            }
        } else {
            $data = trim($data);
        }

        return $data;
    }
}