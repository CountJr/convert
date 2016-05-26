<?php
namespace Converter\Tests;

class XmlDecodeTest extends \PHPUnit_Framework_TestCase
{
    public function testXmlDecode()
    {
        $jsonFile = file_get_contents(__DIR__ . '/testfiles/conf.json');
        $xmlFile = file_get_contents(__DIR__ . '/testfiles/conf.xml');
        
        $this->assertEquals($jsonFile, json_encode(\Converter\Xml\decode($xmlFile), JSON_UNESCAPED_UNICODE));
    }
    
    public function testXmlEncode()
    {
        $jsonFile = json_decode(file_get_contents(__DIR__ . '/testfiles/conf.json'), true);
        $xmlFile = file_get_contents(__DIR__ . '/testfiles/conf.xml');
        $this->assertEquals($xmlFile, \Converter\Xml\encode($jsonFile));
    }
}
