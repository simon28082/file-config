<?php

namespace CrCms\FileConfig\Drives;

use CrCms\FileConfig\Contracts\FormatConfig;

/**
 * Class SerializeConfig
 * @package CrCms\FileConfig\Drives
 */
class SerializeConfig implements FormatConfig
{
    /**
     * @param string $content
     * @return array
     */
    public function read(string $content): array
    {
        return unserialize($content);
    }

    /**
     * @param array $content
     * @return string
     */
    public function write(array $content): string
    {
        return serialize($content);
    }
}