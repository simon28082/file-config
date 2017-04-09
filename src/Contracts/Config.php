<?php
namespace CrCms\FileConfig\Contracts;

interface Config
{

    public function read(string $content) : array;


    public function write(array $content) : string ;


//    public function has(string $key) : bool ;
//
//
//    public function get(string $key,string $default = null) : string ;
//
//
//    public function all() : array ;
//
//
//    public function put(string $key,string $value) : string ;
//
//
//    public function destroy(string $key);

}