<?php
namespace Tests;

class Config extends TestCase
{

    public function testPut()
    {
        file_config([
           'a.crcms'=>'http://crcms.cn'
        ]);

        $string = file_config('a.crcms');

        $this->assertEquals('http://crcms.cn',$string);
    }


    public function testAll()
    {
        $config = file_config()->all('a');

        $this->assertArrayHasKey('crcms',$config);
    }


    public function testDestroy()
    {
        file_config()->destroy('a.crcms');

        $config = file_config()->all('a');

        $this->assertArrayNotHasKey('crcms',$config);
    }
}