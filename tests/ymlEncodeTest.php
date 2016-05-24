<?php
namespace Converter\Tests;

class ymlEncodeTest extends \PHPUnit_Framework_Testcase
{
    public function testYmlEncode()
    {
        $jsonFile = file_get_contents(__DIR__ . '/testfiles/conf.json');
        $ymlFile = file_get_contents(__DIR__ . '/testfiles/conf.yml');
        $this->assertEquals($ymlFile, \Converter\Yml\Encode\encode($jsonFile));
    }
}
