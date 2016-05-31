<?php
/**
 * Initially created by Brain.
 * File: ioTest.php
 * Date: 31/05/16
 * Time: 13:34
 */

namespace Converter\Tests;

use org\bovigo\vfs\vfsStream;
use Monad\Either;
use function Converter\fileFormat;
use function Converter\fileRead;
use function Converter\fileWrite;

class IoTest extends \PHPUnit_Framework_TestCase
{

    protected $rootfs;
    protected $contents = 'hello world!';

    protected function setUp()
    {

        $this->rootfs = vfsStream::setup();
        $file = vfsStream::newFile('fileUnreachable', 0000)->withContent($this->contents);
        $this->rootfs->addChild($file);
        $file = vfsStream::newFile('fileReachable', 0666)->withContent($this->contents);
        $this->rootfs->addChild($file);

    }

    public function testFileFormat()
    {

        $this->assertEquals('txt', fileFormat('file.txt'));
        $this->assertEquals('exe', fileFormat('my.eXe'));
        $this->assertEquals('', fileFormat('notforme'));
    }


    public function testFileRead()
    {
        
        $this->assertInstanceOf(Either\Left::class, fileRead($this->rootfs->url() . '/nofile'));
        $this->assertEquals(
            'file ' . $this->rootfs->url() . '/nofile' . ' does not exists' . PHP_EOL,
            fileRead($this->rootfs->url() . '/nofile')->extract()
        );
        
        $this->assertInstanceOf(Either\Left::class, fileRead($this->rootfs->url() . '/fileUnreachable'));
        $this->assertEquals(
            'file ' . $this->rootfs->url() . '/fileUnreachable' . ' is not readable' . PHP_EOL,
            fileRead($this->rootfs->url() . '/fileUnreachable')->extract()
        );
        
        $this->assertEquals($this->contents, fileRead($this->rootfs->url() . '/fileReachable')->extract());
        
    }

    public function testFileWrite()
    {

        // file exists, overwrite false
        $this->assertInstanceOf(
            Either\Left::class,
            fileWrite(
                $this->rootfs->url() . '/fileReachable',
                false,
                'new content'
            )
        );
        $this->assertEquals(
            'can\'t overwrite existing file' . PHP_EOL,
            fileWrite(
                $this->rootfs->url() . '/fileReachable',
                false,
                'new content'
            )->extract()
        );

        // file exists, overwrite, not writable
        $this->assertInstanceOf(
            Either\Left::class,
            fileWrite(
                $this->rootfs->url() . '/fileUnreachable',
                true,
                'new content'
            )
        );
        $this->assertEquals(
            'file ' . $this->rootfs->url() . '/fileUnreachable' . ' is not writable' . PHP_EOL,
            fileWrite(
                $this->rootfs->url() . '/fileUnreachable',
                true,
                'new content'
            )->extract()
        );
        
        // file exists, overwrite, writable
        $this->assertInstanceOf(
            Either\Right::class,
            fileWrite(
                $this->rootfs->url() . '/fileReachable',
                true,
                'new content'
            )
        );
        $this->assertEquals('new content', fileRead($this->rootfs->url() . '/fileReachable')->extract());
        
        
        fileWrite($this->rootfs->url() . '/newFile', false, 'new content');
        $this->assertTrue($this->rootfs->hasChild('newFile'));
        $this->assertEquals('new content', fileRead($this->rootfs->url() . '/newFile')->extract());
    }
}
