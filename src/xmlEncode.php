<?php
namespace Converter\Xml\Encode;

function encode($json)
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
    $arr = json_decode($json, true);
    $xml_data = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data></data>');
    $array_to_xml($arr, $xml_data);
    return $xml_data->asXML();
};
