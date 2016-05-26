<?php
namespace Converter\Tests;

class YmlDecodeTest extends \PHPUnit_Framework_Testcase
{
    public function testYmlDecode()
    {
        $jsonFile = file_get_contents(__DIR__ . '/testfiles/conf.json');
        $ymlFile = file_get_contents(__DIR__ . '/testfiles/conf.yml');
        $this->assertEquals($jsonFile, json_encode(\Converter\Yml\decode($ymlFile),JSON_UNESCAPED_UNICODE));
    }

    public function testYmlEncode()
    {
        $jsonFile = json_decode(file_get_contents(__DIR__ . '/testfiles/conf.json'), true);
        $ymlFile = file_get_contents(__DIR__ . '/testfiles/conf.yml');
        $this->assertEquals($ymlFile, \Converter\Yml\encode($jsonFile));
    }
}
