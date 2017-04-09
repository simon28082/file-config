<?php
namespace CrCms\FileConfig\Drives;

use CrCms\FileConfig\Contracts\Config;

class DefaultConfig implements Config
{


    public function read(string $content) : array
    {
        //$content = str_replace("\r\n","\n",$content);

        $content = explode("\n",$content);
        $array = [];

        foreach ($content as $value) {
            if (empty($value)) {
                continue;
            }
            $value = explode('=',$value);
            $array[$value[0]] = $value[1];
        }

        return $array;

    }

    public function write(array $content): string
    {
        $string = '';
        foreach ($content as $key=>$value) {
            $string .= "{$key}={$value}\n";
        }
        return $string;
    }


}