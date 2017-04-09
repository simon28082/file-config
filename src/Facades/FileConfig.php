<?php
namespace CrCms\FileConfig\Facades;


use Illuminate\Support\Facades\Facade;

class FileConfig extends Facade
{
    protected static function getFacadeAccessor() {
        return 'file.config';
    }
}