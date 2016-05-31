<?php

namespace Converter\Tests;

use org\bovigo\vfs\vfsStream;
use Monad\Either;
use function Encoders\encoders;

class EncodersTest extends \PHPUnit_Framework_TestCase
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
    protected $functions;

    protected function setUp()
    {

        $this->rootfs = vfsStream::setup('temp');
        vfsStream::copyFromFileSystem('./tests/testfiles', $this->rootfs);
        $this->functions = encoders();

    }

    public function testJsonEncode()
    {

        $contents = file_get_contents(vfsStream::url('temp/conf.json'));
        $data = $this->functions['json']($this->arr);

        $this->assertEquals($contents, $data->extract());

    }

    public function testXmlEncode()
    {

        $contents = file_get_contents(vfsStream::url('temp/conf.xml'));
        $data = $this->functions['xml']($this->arr);

        $this->assertEquals($contents, $data->extract());

    }

    public function testYmlEncode()
    {

        $contents = file_get_contents(vfsStream::url('temp/conf.yml'));
        $data = $this->functions['yml']($this->arr);

        $this->assertEquals($contents, $data->extract());

    }
}
