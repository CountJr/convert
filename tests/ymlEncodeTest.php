<?php
namespace Converter\Tests;

class ymlEncodeTest extends \PHPUnit_Framework_Testcase
{
    public function testYmlEncode()
    {
        $encodeFunc = require_once (__DIR__ . '/../src/encoders/ymlEncode.php');
        $jsonFile = file_get_contents(__DIR__ . '/testfiles/conf.json');
        $ymlFile = file_get_contents(__DIR__ . '/testfiles/conf.yml');
        $this->assertEquals($ymlFile, $encodeFunc($jsonFile));
    }
}
