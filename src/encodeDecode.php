<?php
namespace Converter;

use Functional as f;
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
    switch ($ext) {
        case "json":
            return Either\right(\Converter\Json\decode($content));
        case "xml":
            return Either\right(\Converter\Xml\decode($content));
        case "yml":
        case "yaml":
            return Either\right(\Converter\Yml\decode($content));
    }
    return Either\left('unknown input format ' . $ext . PHP_EOL);
}

const ENCODE = 'Converter\encode';

/**
 * @param string $ext
 * @param array  $content
 * @return static
 */
function encode(string $ext, array $content)
{
    switch ($ext) {
        case "json":
            return Either\Right::of(\Converter\Json\encode($content));
        case "xml":
            return Either\Right::of(\Converter\Xml\encode($content));
        case "yml":
        case "yaml":
            return Either\Right::of(\Converter\Yml\encode($content));
    }
    return Either\Left::of('unknown output format ' . $ext . PHP_EOL);
}
