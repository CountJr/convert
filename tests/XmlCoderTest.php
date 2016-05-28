<?php
namespace Converter\Tests;

use org\bovigo\vfs\vfsStream;
use Monad\Either;

class XmlCoderTest extends \PHPUnit_Framework_TestCase
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
    protected $file;

    protected function setUp()
    {
        $this->rootfs = vfsStream::setup('temp');
        vfsStream::copyFromFileSystem('./tests/testfiles', $this->rootfs);
        $this->file = file_get_contents(vfsStream::url('temp/conf.xml'));
    }

    public function testXmlDecoderEncoder()
    {

        $this->assertEquals($this->arr, \Converter\decode('xml', $this->file)->extract());
        $this->assertEquals($this->file, \Converter\encode('xml', $this->arr)->extract());
    }

    public function testXmlDecoderFail()
    {
        $this->assertInstanceOf('Monad\Either\Left', \Converter\decode('xml', 'sdfds fdsf dsf ds fds'));
    }
}
