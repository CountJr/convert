<?php

namespace Converter\Tests;

use function Decoders\decoders;
use function Encoders\encoders;
use function Converter\isCodecExists;

class IsCodecExistsTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * @dataProvider list
     */
    public function testDecodersExists($extension)
    {

        $decoders = decoders();

        $this->assertTrue(isCodecExists($extension, $decoders));

    }


    public function testDecoderNotExists()
    {
        $decoders = decoders();

        $this->assertFalse(isCodecExists('bok', $decoders));
    }

    /**
     * @dataProvider list
     */
    public function testEncodersExists($extension)
    {

        $encoders = encoders();

        $this->assertTrue(isCodecExists($extension, $encoders));

    }

    public function testEncoderNotExists()
    {
        $encoders = encoders();

        $this->assertFalse(isCodecExists('bok', $encoders));
    }

    public function list()
    {

        return [
            ['json'],
            ['xml'],
            ['yml']
        ];

    }
}
