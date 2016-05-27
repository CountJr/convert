<?php

namespace Converter\Tests;

class JsonTest extends \PHPUnit_Framework_TestCase
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
    protected $jsonFile;

    protected function setUp()
    {
        $this->jsonFile = file_get_contents(__DIR__ . '/testfiles/conf.json');
    }
    
    public function testJsonDecode()
    {
        $this->assertEquals($this->arr, \Converter\Json\decode($this->jsonFile));
    }

    public function testJsonEncode()
    {
        $this->assertEquals($this->jsonFile, \Converter\Json\encode($this->arr));
    }
}
