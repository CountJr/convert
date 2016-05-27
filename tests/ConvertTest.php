<?php

namespace Converter\Tests;

use org\bovigo\vfs\vfsStream;
use Functional as f;
use Monad\Either;

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
        $this->assertEquals('file extension is missing' . PHP_EOL, \Converter\convert('lalal', 'bububu')->extract());
        $this->assertEquals(
            'write to file error' . PHP_EOL,
            \Converter\convert(vfsStream::url('temp')
            . DIRECTORY_SEPARATOR . 'conf.json', vfsStream::url('temp')
            . DIRECTORY_SEPARATOR . 'conf.json')->extract()
        );
        \Converter\convert(vfsStream::url('temp') . DIRECTORY_SEPARATOR . 'conf.json', vfsStream::url('temp')
            . DIRECTORY_SEPARATOR . 'out.xml');
        $this->assertTrue($this->rootfs->hasChild('out.xml'));
    }

    public function testFileExtension()
    {
        $this->assertInstanceOf(Either\Right::class, \Converter\fileFormat('lala.xml'));
        $this->assertInstanceOf(Either\Left::class, \Converter\fileFormat('lala'));
    }

    /**
     * @dataProvider decodeProvider
     */
    public function testDecodeEncode($format, $file)
    {
        $fileContents = file_get_contents(vfsStream::url('temp') . DIRECTORY_SEPARATOR . $file);
        $this->assertEquals($this->arr, \Converter\decode($format, $fileContents)->extract());
        $this->assertEquals($fileContents, \Converter\encode($format, $this->arr)->extract());
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

    public function testDecodeEncodeFail()
    {
        $this->assertInstanceOf(Either\Left::class, \Converter\decode('lala', 'bubu'));
        $this->assertInstanceOf(Either\Left::class, \Converter\encode('lala', $this->arr));
    }
}
