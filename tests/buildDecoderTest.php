<?php

namespace Converter\Tests;

use function Decoders\decoders;
use function Converter\makeDecodeFunction;
use function Converter\getDecodeFunction;
use Monad\Either;

class BuildDecoderTest extends \PHPUnit_Framework_TestCase
{

    public function testMakeDecodeFunction()
    {

        $string = 'sdd:dfdfd:wwe2:98er:sdmmm';
        $function = function ($string) {
            return explode(':', $string);
        };
        $array = ['sdd', 'dfdfd', 'wwe2', '98er', 'sdmmm'];
        $decoder = makeDecodeFunction($function);
        
        $this->assertEquals($array, $decoder($string));
            
        $function = function ($string) {
            throw new \Exception('test');
        };
        $decoder = makeDecodeFunction($function);
        
        $this->assertInstanceOf(Either\Left::class, $decoder($string));
        
    }

    public function testGetDecoderFunction()
    {

        $contents = '{"application":
        {"name":"configuration","secret":"s3cr3t"},
        "host":"localhost",
        "port":80,
        "servers":
        {"server1":"host1","server2":"host2","server3":"host3"}}';
        
        $arr = [
            "application" =>
                ["name" => "configuration",
                 "secret" => "s3cr3t"],
            "host" => "localhost",
            "port" => 80,
            "servers" => ["server1" => "host1",
                          "server2" => "host2",
                          "server3" => "host3"]
        ];
        $function = getDecodeFunction('conf.json');
        $data = is_callable($function) ? $function($contents) : null;

        $this->assertEquals($arr, $data->extract());
        
    }
}
