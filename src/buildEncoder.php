<?php

namespace Converter;

use function Functional\curry;
use function Monad\Either\left as left;
use function Monad\Either\right as right;

/**
 * buils custom encoder
 *
 * @param callable $function
 * @return \Closure
 */
function makeEncodeFunction(callable $function)
{

    return function (array $array) use ($function) {

        return \Functional\tryCatch(function ($array) use ($function) {
            return right($function($array));
        }, function (\Exception $e) {
            return left('incorrect output file' . PHP_EOL);
        }, $array);

    };

}

/**
 * get build in encoder
 *
 * @param string $source
 * @return \Closure
 */
function getEncodeFunction(string $source)
{

    $funcs = \Encoders\encoders();
    $extension = fileFormat($source);

    return isCodecExists($extension, $funcs)
        ? $funcs[$extension]
        : function (array $x) use ($extension) {
            return left('unknown output format ' . $extension . PHP_EOL);
        };

}
