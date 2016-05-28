<?php
namespace Encoders;

use Symfony\Component\Yaml\Yaml;

function encoders()
{
    return [
        /**
         * Json encode
         *
         * @param array $arr input array
         *
         * @return string
         */
        'json' => function (array $arr) {
            return json_encode($arr, JSON_UNESCAPED_UNICODE);
        },

        /**
         * XML encode
         *
         * @param array $arr input array
         *
         * @return string
         */
        'xml' => function (array $arr) {
            $arrayToXml = function ($data, &$xmlData) use (&$arrayToXml) {
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $subnode = $xmlData->addChild($key);
                        $arrayToXml($value, $subnode);
                    } else {
                        $xmlData->addChild("$key", $value);
                    }
                }
            };
            $xmlData = new \SimpleXMLElement(
                '<?xml version="1.0" encoding="UTF-8"?><data></data>'
            );
            $arrayToXml($arr, $xmlData);

            return $xmlData->asXML();
        },

        /**
         * YML(YAML) encode
         *
         * @param array $arr input array
         *
         * @return string
         */
        'yml' => function (array $arr) {
            return Yaml::dump($arr, 2, 2);
        },
    ];
}
