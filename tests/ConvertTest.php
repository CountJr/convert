<?php

namespace Converter\Tests;

class ConvertTest extends \PHPUnit_Framework_TestCase
{
    public function testFileExtension()
    {
        $this->assertEquals('xml', \Converter\fileFormat('lala.xml'));
    }
}
