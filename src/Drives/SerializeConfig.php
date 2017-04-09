<?php
namespace CrCms\FileConfig\Drives;

class SerializeConfig
{

    public function read(string $content) : array
    {
        return unserialize($content);
    }


    public function write(array $content) : string
    {
        return serialize($content);
    }

}