<?php

namespace Converter;

use function Functional\curry;
use function Monad\Either\left as left;
use function Monad\Either\right as right;

/**
 * build custom decoder
 *
 * @param callable $function
 * @return \Closure
 */
function makeDecodeFunction(callable $function)
{

    return function (string $text) use ($function) {

        return \Functional\tryCatch(function ($text) use ($function) {
            return right($function($text));
        }, function (\Exception $e) {
            return left('incorrect input file' . PHP_EOL);
        }, $text);

    };

}

/**
 * get build in decoder
 *
 * @param string $source
 * @return \Closure
 */
function getDecodeFunction(string $source)
{

    $funcs = \Decoders\decoders();
    $extension = fileFormat($source);

    return isCodecExists($extension, $funcs)
        ? $funcs[$extension]
        : function (string $x) use ($extension) {
            return left('unknown input format ' . $extension . PHP_EOL);
        };

}
