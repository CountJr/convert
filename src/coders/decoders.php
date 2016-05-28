<?php
namespace Decoders;

use Symfony\Component\Yaml\Yaml;
use Functional;
use Monad\Either;

function decoders()
{
    return [
        /**
         * Json decode
         *
         * @param string $text input string
         *
         * @return array
         */
        'json' => function (string $text) {
            $return = json_decode($text, true);
            return !json_last_error() 
                ? Either\right($return)
                : Either\left('incorect input file' . PHP_EOL);
        },
    
        /**
         * XML decode
         *
         * @param string $text input string
         *
         * @return array
         */
        'xml'  => function (string $text) {
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($text, 'SimpleXMLElement', LIBXML_NOCDATA);
            $array = json_decode(json_encode($xml), true);
            if (libxml_get_errors()) {
                return Either\left('incorect input file' . PHP_EOL);
            }
            foreach ($array as $key => $value) {
                if ((string)(int)$value === $value) {
                    $array[$key] = (int)$value;
                }
            }
            return Either\right($array);
        },
    
        /**
         * YML(YAML) decode
         *
         * @param string $text input string
         *
         * @return mixed
         */
        'yml'  => function (string $text) {
            return \Functional\tryCatch(function ($text) {
                return Either\right(Yaml::parse($text));
            }, function (\Exception $e) {
                return Either\left('incorect input file' . PHP_EOL);
            }, $text);
        },
    ];
}
