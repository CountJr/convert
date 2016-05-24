<?php
namespace Converter\Tests;

class ymlDecodeTest extends \PHPUnit_Framework_Testcase
{
    public function testYmlEncode()
    {
        $decodeFunc = require_once (__DIR__ . '/../src/decoders/ymlDecode.php');
        $jsonFile = file_get_contents(__DIR__ . '/testfiles/conf.json');
        $ymlFile = file_get_contents(__DIR__ . '/testfiles/conf.yml');
        $this->assertEquals($jsonFile, $decodeFunc($ymlFile));
    }
}
