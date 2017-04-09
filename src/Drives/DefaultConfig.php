<?php
namespace CrCms\FileConfig\Drives;

use CrCms\FileConfig\Contracts\Config;

class DefaultConfig implements Config
{


    public function read(string $content) : array
    {
        //$content = str_replace("\r\n","\n",$content);

        return explode("\n",$content);
    }

    public function write(array $content): string
    {
        return implode("\n",$content);
    }


}