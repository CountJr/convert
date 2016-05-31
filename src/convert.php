<?php

namespace Converter;

use Monad\Either;
use function Functional\curry;
use function Monad\Either\left as left;

/**
 * returns callable converter with optional custom functions
 *
 * @param callable|null $decodeFunction
 * @param callable|null $encodeFunction
 * @return \Closure
 */
function buildConvert(callable $decodeFunction = null, callable $encodeFunction = null)
{
    return function (string $source, string $target, bool $overwrite = false)
 use ($decodeFunction, $encodeFunction) {
        
        $decodeFunction = !is_null($decodeFunction)
            ? makeDecodeFunction($decodeFunction)
            : getDecodeFunction($source);

        
        $encodeFunction = !is_null($encodeFunction)
            ? makeEncodeFunction($encodeFunction)
            : getEncodeFunction($target);
        
        $result = fileRead($source)
                    ->bind(curry(CONVERTDATA, [$decodeFunction, $encodeFunction]))
                    ->bind(curry(WRITE, [$target, $overwrite]));

        return $result->either(RETURNERROR, RETURNZERO);
    };
}


const CONVERTDATA = 'Converter\convertData';

/**
 * @param callable $decodeFunction
 * @param callable $encodeFunction
 * @param          $data
 * @return mixed
 */
function convertData(
    callable $decodeFunction,
    callable $encodeFunction,
    $data
) {

    return  $decodeFunction($data)
                ->bind(curry($encodeFunction));
}

const RETURNERROR = 'Converter\returnError';

/**
 * @param $data
 * @return string
 */
function returnError($data)
{
    return $data;
}

const RETURNZERO = 'Converter\returnZero';

/**
 * @param $data
 * @return int
 */
function returnZero($data)
{
    return 0;
}
