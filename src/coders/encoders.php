<?php
namespace Encoders;

use Symfony\Component\Yaml\Yaml;
use Functional;
use Monad\Either;

function encoders()
{
    
    $encoders = [];
    
    /**
     * @param array $arr
     * @return Either\Right
     */
    $encoders['json'] = function (array $arr) {

        return Either\right(json_encode($arr, JSON_UNESCAPED_UNICODE));
    };

    /**
     * @param array $arr
     * @return \Monad\Either
     */
    $encoders['xml'] = function (array $arr) {

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
    
        return  Either\right($xmlData->asXML());
    };

    /**
     * @param array $arr
     * @return \Monad\Either
     */
    $encoders['yml'] = function (array $arr) {

        return \Functional\tryCatch(function ($arr) {
            return Either\right(Yaml::dump($arr, 2, 2));
        }, function (\Exception $e) {
            return Either\left('incorect data' . PHP_EOL);
        }, $arr);
    };
    
    return $encoders;
}
