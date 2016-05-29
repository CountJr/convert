<?php

namespace Converter;

use Functional;
use Monad\Either;
use function Functional\curry;

const DECODE = 'Converter\decode';

/**
 * @param string $ext       format of file
 * @param string $content   file's content
 * @return \Monad\Either
 */
function decode(string $ext, string $content)
{
    $funcs = \Decoders\decoders();
    
    return isCodecExists($ext, $funcs)
        ? $funcs[$ext]($content)
        : Either\left('unknown input format ' . $ext . PHP_EOL);
}

const ENCODE = 'Converter\encode';

/**
 * @param string $ext       format of file
 * @param array  $content   array to convert
 * @return \Monad\Either
 */
function encode(string $ext, array $content)
{
    $funcs = \Encoders\encoders();
    
    return isCodecExists($ext, $funcs)
        ? $funcs[$ext]($content)
        : Either\left('unknown output format ' . $ext . PHP_EOL);
}

/**
 * @param string $extension     file extention
 * @param array  $functions     list of functions
 * @return bool
 */
function isCodecExists(string $extension, array $functions)
{
    return array_key_exists($extension, $functions);
}
