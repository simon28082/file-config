<?php

namespace CrCms\FileConfig\Drives;

use CrCms\FileConfig\Contracts\FormatConfig;

/**
 * Class JsonConfig
 * @package CrCms\FileConfig\Drives
 */
class JsonConfig implements FormatConfig
{
    /**
     * @param string $content
     * @return array
     */
    public function read(string $content): array
    {
        return json_decode($content, true);
    }

    /**
     * @param array $content
     * @return string
     */
    public function write(array $content): string
    {
        return json_encode($content);
    }
}