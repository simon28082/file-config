<?php

function file_config($key = null, $default = null, array $config = []) {

    if (empty($config)) {
        $config = app('config')->get('file_config');
    }

    if (is_null($key)) {
        return \CrCms\FileConfig\Config::instance($config);
    }

    if (is_array($key)) {
        array_walk($key,function($item,$key) use ($config){
            \CrCms\FileConfig\Config::instance($config)->put($key,$item);
        });
    }

    return \CrCms\FileConfig\Config::instance($config)->get($key, $default);
}