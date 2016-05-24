<?php
namespace Converter\Tests;

class xmlEncodeTest extends \PHPUnit_Framework_Testcase
{
    public function testXmlEncode()
    {
        $encodeFunc = require_once (__DIR__ . '/../src/encoders/xmlEncode.php');
        $jsonFile = file_get_contents(__DIR__ . '/testfiles/conf.json');
        $xmlFile = file_get_contents(__DIR__ . '/testfiles/conf.xml');
        $this->assertEquals($xmlFile, $encodeFunc($jsonFile));
    }
}
