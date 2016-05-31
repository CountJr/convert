<?php

namespace Converter\Tests;

use org\bovigo\vfs\vfsStream;
use Monad\Either;
use function Decoders\decoders;

class DecodersTest extends \PHPUnit_Framework_TestCase
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
        $this->functions = decoders();

    }

    public function testJsonDecode()
    {
        
        //
        //$data = $function($contents);

        $contents = file_get_contents(vfsStream::url('temp/conf.json'));
        $data = $this->functions['json']($contents);
        
        $this->assertEquals($this->arr, $data->extract());
        
    }

    public function testXmlDecode()
    {

        $contents = file_get_contents(vfsStream::url('temp/conf.xml'));
        $data = $this->functions['xml']($contents);

        $this->assertEquals($this->arr, $data->extract());
        
    }

    public function testYmlDecode()
    {

        $contents = file_get_contents(vfsStream::url('temp/conf.yml'));
        $data = $this->functions['yml']($contents);

        $this->assertEquals($this->arr, $data->extract());
        
    }
    
    public function testDecodeFail()
    {

        $contents = file_get_contents(vfsStream::url('temp/incorr.json'));
        $this->assertInstanceOf(Either\Left::class, $this->functions['json']($contents));

        $contents = file_get_contents(vfsStream::url('temp/incorr.xml'));
        $this->assertInstanceOf(Either\Left::class, $this->functions['xml']($contents));

        $contents = file_get_contents(vfsStream::url('temp/incorr.yml'));
        $this->assertInstanceOf(Either\Left::class, $this->functions['yml']($contents));
        
    }
}
