<?php

namespace Converter;

use Monad\Either;
use function Functional\curry;

function buildConvert(array $functions = [])
{
    
    return function (string $source, string $target, bool $overwrite = false)
 use ($functions) {
        
        $decodeFunction = isset($functions[0])
            ? makeDecodeFunction($functions[0])
            : getDecodeFunction($source);

        $encodeFunction = isset($functions[1])
            ? makeEncodeFunction($functions[1])
            : getEncodeFunction($target);
        
        $result = fileRead($source)
                    ->bind(curry(CONVERTDATA, [$decodeFunction, $encodeFunction]))
                    ->bind(curry(WRITE, [$target, $overwrite]));

        return $result instanceof Either\Left
            ? $result->extract()
            : 0;
    };
}


const CONVERTDATA = 'Converter\convertData';

function convertData(callable $decodeFunction, callable $encodeFunction, $data)
{
    return  $decodeFunction($data)
                ->bind(curry($encodeFunction));
}
