<?php
namespace Converter;

use Functional;
use Monad\Either;
use function Functional\curry;

const DECODE = 'Converter\decode';

/**
 * @param string $ext
 * @param string $content
 * @return static
 */
function decode(string $ext, string $content)
{
    $funcs = \Decoders\decoders();
    return array_key_exists($ext, $funcs)
        ? $funcs[$ext]($content)
        : Either\left('unknown input format ' . $ext . PHP_EOL);
}

const ENCODE = 'Converter\encode';

/**
 * @param string $ext
 * @param array  $content
 * @return static
 */
function encode(string $ext, array $content)
{
    $funcs = \Encoders\encoders();
    return array_key_exists($ext, $funcs)
        ? $funcs[$ext]($content)
        : Either\left('unknown output format ' . $ext . PHP_EOL);
}
