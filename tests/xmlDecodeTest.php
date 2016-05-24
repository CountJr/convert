<?php
namespace Converter\Tests;

class xmlDecodeTest extends \PHPUnit_Framework_Testcase
{
    public function testXmlEncode()
    {
        $jsonFile = file_get_contents(__DIR__ . '/testfiles/conf.json');
        $xmlFile = file_get_contents(__DIR__ . '/testfiles/conf.xml');
        
        $this->assertEquals($jsonFile, \Converter\Xml\Decode\decode($xmlFile));
    }
}
