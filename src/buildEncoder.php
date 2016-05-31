<?php

namespace Converter;

use function Functional\curry;
use function Monad\Either\left as left;
use function Monad\Either\right as right;

function makeEncodeFunction(callable $function)
{

    return function (array $array) use ($function) {

        return \Functional\tryCatch(function ($array) use ($function) {
            return $function($array);
        }, function (\Exception $e) {
            return left('incorrect output file' . PHP_EOL);
        }, $array);

    };

}

function getEncodeFunction($source)
{

    $funcs = \Encoders\encoders();
    $extension = fileFormat($source);

    return isCodecExists($extension, $funcs)
        ? $funcs[$extension]
        : left('unknown output format ' . $extension . PHP_EOL);

}
