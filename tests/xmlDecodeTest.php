<?php
namespace Converter\Tests;

class xmlDecodeTest extends \PHPUnit_Framework_Testcase
{
    public function testXmlEncode()
    {
        $decodeFunc = require_once (__DIR__ . '/../src/decoders/xmlDecode.php');
        $jsonFile = file_get_contents(__DIR__ . '/testfiles/conf.json');
        $xmlFile = file_get_contents(__DIR__ . '/testfiles/conf.xml');
        $this->assertEquals($jsonFile, $decodeFunc($xmlFile));
    }
}
