<?php
namespace Encoder;

return function ($json) {
        function array_to_xml( $data, &$xml_data ) {
            foreach( $data as $key => $value ) {
                if( is_array($value) ) {
                    if( is_numeric($key) ){
                        $key = 'item' . $key; //dealing with <0/>..<n/> issues
                    }
                    $subnode = $xml_data->addChild($key);
                    array_to_xml($value, $subnode);
                } else {
                    $xml_data->addChild("$key", $value);
                }
            }
        }
        $arr = json_decode($json, TRUE);
        $xml_data = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data></data>');
        array_to_xml($arr,$xml_data);
        return $xml_data->asXML();
};

