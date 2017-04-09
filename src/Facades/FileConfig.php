<?php
namespace CrCms\FileConfig\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class FileConfig
 * @package CrCms\FileConfig\Facades
 */
class FileConfig extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'file.config';
    }
}