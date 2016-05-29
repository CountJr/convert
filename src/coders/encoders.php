<?php
namespace Encoders;

use Symfony\Component\Yaml\Yaml;
use function Monad\Either\left as left;
use function Monad\Either\right as right;

function encoders()
{
    
    $encoders = [];
    
    /**
     * @param array $arr
     * @return Either\Right
     */
    $encoders['json'] = function (array $arr) {

        return right(json_encode($arr, JSON_UNESCAPED_UNICODE));
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
    
        return  right($xmlData->asXML());
    };

    /**
     * @param array $arr
     * @return \Monad\Either
     */
    $encoders['yml'] = function (array $arr) {

        return \Functional\tryCatch(function ($arr) {
            return right(Yaml::dump($arr, 2, 2));
        }, function (\Exception $e) {
            return left('incorect data' . PHP_EOL);
        }, $arr);
    };
    
    return $encoders;
}
