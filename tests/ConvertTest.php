<?php

namespace Converter\Tests;

use org\bovigo\vfs\vfsStream;
use Monad\Either;
use function Converter\buildConvert;

class ConvertTest extends \PHPUnit_Framework_TestCase
{
    
    protected $rootfs;

    protected function setUp()
    {
        
        $this->rootfs = vfsStream::setup();
        vfsStream::copyFromFileSystem('./tests/testfiles', $this->rootfs);
        
    }
    
    public function testConvert()
    {

        $converter = buildConvert();
        $this->assertEquals(
            0,
            $converter($this->rootfs->url() . '/conf.json',
                $this->rootfs->url() . '/temp.xml')
        );
        $this->assertTrue($this->rootfs->hasChild('temp.xml'));
        $this->assertEquals(
            file_get_contents($this->rootfs->url() . '/conf.xml'),
            file_get_contents($this->rootfs->url() . '/temp.xml')
        );
        
        $this->assertEquals(
            'can\'t overwrite existing file' . PHP_EOL,
            $converter($this->rootfs->url() . '/conf.json',
                $this->rootfs->url() . '/conf.xml')
        );
        
    }
}
