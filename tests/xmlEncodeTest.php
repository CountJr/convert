<?php
namespace Converter\Tests;

class xmlEncodeTest extends \PHPUnit_Framework_Testcase
{
    public function testXmlEncode()
    {
        $jsonFile = file_get_contents(__DIR__ . '/testfiles/conf.json');
        $xmlFile = file_get_contents(__DIR__ . '/testfiles/conf.xml');
        $this->assertEquals($xmlFile, \Converter\Xml\Encode\encode($jsonFile));
    }
}
