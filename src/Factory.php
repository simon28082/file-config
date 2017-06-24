<?php

namespace CrCms\FileConfig;

/**
 * Class Factory
 * @package CrCms\FileConfig
 */
class Factory
{
    /**
     * @var null
     */
    protected static $fileConfig = null;

    /**
     * @param array $config
     * @return FileConfig
     */
    public static function fileConfig(array $config): FileConfig
    {
        if (static::$fileConfig instanceof FileConfig) {
            return static::$fileConfig;
        }
        static::$fileConfig = new FileConfig($config);

        return static::$fileConfig;
    }
}