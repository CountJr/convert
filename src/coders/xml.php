<?php
/**
 *  XML encode/decode
 */
namespace Converter\Xml;

/**
 * XML decode
 *
 * @param string $text input string
 *
 * @return array
 */
function decode(string $text)
{
    $xml   = simplexml_load_string($text, 'SimpleXMLElement', LIBXML_NOCDATA);
    $array = json_decode(json_encode($xml), true);
    foreach ($array as $key => $value) {
        if ((string)(int)$value === $value) {
            $array[$key] = (int)$value;
        }
    }
    return $array;
}

/**
 * XML encode
 *
 * @param array $arr input array
 *
 * @return string
 */
function encode(array $arr)
{
    $array_to_xml = function ($data, &$xml_data) use (&$array_to_xml) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item'.$key; //dealing with <0/>..<n/> issues
                }
                $subnode = $xml_data->addChild($key);
                $array_to_xml($value, $subnode);
            } else {
                if (is_numeric($key)) {
                    $key = 'item'.$key; //dealing with <0/>..<n/> issues
                }
                $xml_data->addChild("$key", $value);
            }
        }
    };
    $xml_data = new \SimpleXMLElement(
        '<?xml version="1.0" encoding="UTF-8"?><data></data>'
    );
    $array_to_xml($arr, $xml_data);
    return $xml_data->asXML();
}
