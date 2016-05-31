<?php

namespace Converter;

use function Functional\curry;
use function Monad\Either\left as left;
use function Monad\Either\right as right;

function makeDecodeFunction(callable $function)
{

    return function (string $text) use ($function) {

        return \Functional\tryCatch(function ($text) use ($function) {
            return $function($text);
        }, function (\Exception $e) {
            return left('incorrect input file' . PHP_EOL);
        }, $text);

    };

}

function getDecodeFunction(string $source)
{

    $funcs = \Decoders\decoders();
    $extension = fileFormat($source);

    return isCodecExists($extension, $funcs)
        ? $funcs[$extension]
        : left('unknown input format ' . $extension . PHP_EOL);

}
