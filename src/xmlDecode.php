<?php
namespace Converter\Xml\Decode;

function decode ($text) {
    $xml   = simplexml_load_string($text, 'SimpleXMLElement', LIBXML_NOCDATA);
    $array = json_decode(json_encode($xml), true);
    foreach ($array as $key => $value) {
        if ((string)(int)$value === $value) {
            $array[$key] = (int)$value;
        }
    }
    return json_encode($array, JSON_UNESCAPED_UNICODE);
};
