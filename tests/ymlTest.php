<?php

namespace Converter\Tests;

class YmlTest extends \PHPUnit_Framework_TestCase
{
    protected $arr = [
        "application" =>
            ["name" => "configuration",
             "secret" => "s3cr3t"],
        "host" => "localhost",
        "port" => 80,
        "servers" => ["server1" => "host1",
                      "server2" => "host2",
                      "server3" => "host3"]
    ];
    protected $ymlFile;
    
    protected function setUp()
    {
        $this->ymlFile = file_get_contents(__DIR__ . '/testfiles/conf.yml');
    }

    public function testYmlDecode()
    {
        $this->assertEquals($this->arr, \Converter\Yml\decode($this->ymlFile));
    }

    public function testYmlEncode()
    {
        $this->assertEquals($this->ymlFile, \Converter\Yml\encode($this->arr));
    }
}
