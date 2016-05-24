<?php
namespace Converter\Decoders;

return function ($text) {
        $xml   = simplexml_load_string($text, 'SimpleXMLElement', LIBXML_NOCDATA);
        $array = json_decode(json_encode($xml), true);
        return json_encode($array, JSON_UNESCAPED_UNICODE);
};
