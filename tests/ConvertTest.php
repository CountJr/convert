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
    protected $json;

    protected function setUp()
    {
        $this->rootfs = vfsStream::setup('temp');
        vfsStream::copyFromFileSystem('./tests/testfiles', $this->rootfs);
        $this->json = file_get_contents(vfsStream::url('temp/conf.json'));
    }

    public function testConvert()
    {
        $this->assertEquals('file lalal does not exists' . PHP_EOL, \Converter\convert('lalal', 'bububu')->extract());
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
        $this->assertEquals('xml', \Converter\fileFormat('lala.xml'));
        $this->assertEquals('', \Converter\fileFormat('lala'));
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
        ];
    }

    public function testDecodeEncodeFail()
    {
        $this->assertInstanceOf(Either\Left::class, \Converter\decode('lala', 'bubu'));
        $this->assertInstanceOf(Either\Left::class, \Converter\encode('lala', $this->arr));
    }
    
    public function testYmlExceptions()
    {
        $funcs = \Decoders\decoders();
        try {
            $this->assertTrue($funcs['yml']('jdshfdks dsjfhds fdhs '));
            //$this->fail('\Exception');
        } catch (\Exception $e) {
            //
        }
        $funcs = \Encoders\encoders();
        try {
            $this->assertTrue($funcs['yml'](['sdfdsf jdlslfkdjs']));
            //$this->fail('\Exception');
        } catch (\Exception $e) {
            //
        }
    }
}
