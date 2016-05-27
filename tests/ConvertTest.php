<?php

namespace Converter\Tests;

use org\bovigo\vfs\vfsStream;

class ConvertTest extends \PHPUnit_Framework_TestCase
{
    protected $rootfs;
    protected $arr = [
        "application" =>
            ["name" => "configuration",
             "secret" => "s3cr3t"],
        "host" => "localhost",
        "port" => 80,
        "servers" => ["server1" => "host1",
                      "server2" => "host2",
                      "server3" => "host3"]
    ];

    protected function setUp()
    {
        $this->rootfs = vfsStream::setup('temp');
        vfsStream::copyFromFileSystem('./tests/testfiles', $this->rootfs);
    }

    public function testConvert()
    {
        \Converter\convert(vfsStream::url('temp') . DIRECTORY_SEPARATOR . 'conf.json', vfsStream::url('temp')
            . DIRECTORY_SEPARATOR . 'out.xml');
        $this->assertTrue($this->rootfs->hasChild('out.xml'));
    }

    public function testFileExtension()
    {
        $this->assertEquals('xml', \Converter\fileFormat('lala.xml'));
    }

    /**
     * @dataProvider decodeProvider
     */
    public function testDecodeEncode($format, $file)
    {
        $fileContents = file_get_contents(vfsStream::url('temp') . DIRECTORY_SEPARATOR . $file);
        $this->assertEquals($this->arr, \Converter\decode($format, $fileContents));
        $this->assertEquals($fileContents, \Converter\encode($format, $this->arr));
    }

    public function decodeProvider()
    {
        return [
            ['json', 'conf.json'],
            ['xml', 'conf.xml'],
            ['yml', 'conf.yml'],
            ['yaml', 'conf.yml']
        ];
    }

    public function testDecodeFail()
    {
        try {
            \Converter\decode('lala', 'bubu');
        } catch (\Exception $e) {
            //
        }
    }

    public function testEncodeFail()
    {
        try {
            \Converter\encode('lala', $this->arr);
        } catch (\Exception $e) {
            //
        }
    }

    public function testFileExtensionFail()
    {
        try {
            \Converter\fileFormat('lala');
        } catch (\Exception $e) {
            //
        }
    }

    public function testFileReadFail()
    {
        try {
            \Converter\fileRead('lala');
        } catch (\Exception $e) {
            //
        }
    }
    
    public function testFileWriteFail()
    {
        try {
            \Converter\fileWrite('lala', 'bububu', false);
        } catch (\Exception $e) {
            //
        }
    }

    public function testFileWriteFail2()
    {
        try {
            \Converter\fileWrite(vfsStream::url('temp') . DIRECTORY_SEPARATOR . 'conf.json', 'bububu', false);
        } catch (\Exception $e) {
            //
        }
    }
}
