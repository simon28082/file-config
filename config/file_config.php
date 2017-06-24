<?php
return [

    /*
    |--------------------------------------------------------------------------
    | config files
    |--------------------------------------------------------------------------
    | The file name (not including the extension) must be unique
    | Example
    | files => [
    |    \CrCms\FileConfig\Drives\JsonConfig::class=>'json.conf',
    |    \CrCms\FileConfig\Drives\SerializeConfig::class=>'serialize.txt',
    |
    | ]
    */
    'files' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | default drive
    |--------------------------------------------------------------------------
    | The default driver, when the index is a natural index, uses this driver
    |
    */
    'default_drive' => \CrCms\FileConfig\Drives\DefaultConfig::class,
];