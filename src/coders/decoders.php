<?php

namespace Decoders;

use Symfony\Component\Yaml\Yaml;
use function Monad\Either\left as left;
use function Monad\Either\right as right;

function decoders()
{
    
    $decoders = [];

    /**
     * @param string $text
     * @return \Monad\Either
     */
    $decoders['json'] = function (string $text) {
        
        $return = json_decode($text, true);
        
        return !json_last_error()
            ? right($return)
            : left('incorect input file' . PHP_EOL);
    };

    /**
     * @param string $text
     * @return \Monad\Either
     */
    $decoders['xml']  = function (string $text) {
        
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($text, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (libxml_get_errors()) {
            return left('incorect input file' . PHP_EOL);
        }
        
        $array = json_decode(json_encode($xml), true);
        
        foreach ($array as $key => $value) {
            if ((string)(int)$value === $value) {
                $array[$key] = (int)$value;
            }
        }
        
        return right($array);
    };

    /**
     * @param string $text
     * @return \Monad\Either
     */
    $decoders['yml']  = function (string $text) {
        
        return \Functional\tryCatch(function ($text) {
            return right(Yaml::parse($text));
        }, function (\Exception $e) {
            return left('incorect input file' . PHP_EOL);
        }, $text);
    };
    
    return $decoders;
}
