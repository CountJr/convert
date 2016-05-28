<?php
namespace Decoders;

use Symfony\Component\Yaml\Yaml;

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
            return json_decode($text, true);
        },
    
        /**
         * XML decode
         *
         * @param string $text input string
         *
         * @return array
         */
        'xml'  => function (string $text) {
            $xml = simplexml_load_string($text, 'SimpleXMLElement', LIBXML_NOCDATA);
            $array = json_decode(json_encode($xml), true);
            foreach ($array as $key => $value) {
                if ((string)(int)$value === $value) {
                    $array[$key] = (int)$value;
                }
            }
    
            return $array;
        },
    
        /**
         * YML(YAML) decode
         *
         * @param string $text input string
         *
         * @return mixed
         */
        'yml'  => function (string $text) {
            return Yaml::parse($text);
        },
    ];
}
