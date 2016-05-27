<?php

namespace Converter\Tests;

class XmlTest extends \PHPUnit_Framework_TestCase
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
    protected $xmlFile;

    protected function setUp()
    {
        $this->xmlFile = file_get_contents(__DIR__ . '/testfiles/conf.xml');
    }
    
    public function testXmlDecode()
    {
        $this->assertEquals($this->arr, \Converter\Xml\decode($this->xmlFile));
    }
    
    public function testXmlEncode()
    {
        $this->assertEquals($this->xmlFile, \Converter\Xml\encode($this->arr));
    }
}
