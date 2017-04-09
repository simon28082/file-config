<?php
namespace CrCms\FileConfig\Drives;

use CrCms\FileConfig\Contracts\FormatConfig;

/**
 * Class DefaultConfig
 * @package CrCms\FileConfig\Drives
 */
class DefaultConfig implements FormatConfig
{

    /**
     * @var string
     */
    protected $delimiter = "\n";


    /**
     * @param string $content
     * @return array
     */
    public function read(string $content) : array
    {
        $content = explode($this->delimiter,$content);

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


    /**
     * @param array $content
     * @return string
     */
    public function write(array $content): string
    {
        $string = '';
        foreach ($content as $key=>$value) {
            $string .= "{$key}={$value}\n";
        }
        return rtrim($string,"\n");
    }

}