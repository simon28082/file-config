<?php
namespace CrCms\FileConfig\Contracts;

/**
 * Interface FormatConfig
 * @package CrCms\FileConfig\Contracts
 */
interface FormatConfig
{

    /**
     * @param string $content
     * @return array
     */
    public function read(string $content) : array;


    /**
     * @param array $content
     * @return string
     */
    public function write(array $content) : string ;


}