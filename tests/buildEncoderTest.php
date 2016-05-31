<?php

namespace Converter\Tests;

use function Encoders\encoders;
use function Converter\makeEncodeFunction;
use function Converter\getEncodeFunction;
use Monad\Either;

class BuildEncoderTest extends \PHPUnit_Framework_TestCase
{

    public function testMakeEncodeFunction()
    {

        $string = 'sdd:dfdfd:wwe2:98er:sdmmm';
        $function = function ($array) {
            return implode(':', $array);
        };
        $array = ['sdd', 'dfdfd', 'wwe2', '98er', 'sdmmm'];
        $encoder = makeEncodeFunction($function);

        $this->assertEquals($string, $encoder($array));

        $function = function ($array) {
            throw new \Exception('test');
        };
        $encoder = makeEncodeFunction($function);

        $this->assertInstanceOf(Either\Left::class, $encoder($array));

    }

    public function testGetEncoderFunction()
    {

        $contents = file_get_contents('./tests/testfiles/conf.json');

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
        $function = getEncodeFunction('conf.json');
        $data = is_callable($function) ? $function($arr) : null;

        $this->assertEquals($contents, $data->extract());

    }
}
