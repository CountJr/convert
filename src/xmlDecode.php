<?php
namespace Decoder;

return function ($text)
    {
        $xml   = simplexml_load_string($text, 'SimpleXMLElement', LIBXML_NOCDATA);
        $array = json_decode(json_encode($xml), TRUE);
        return json_encode($array, JSON_UNESCAPED_UNICODE);
    };
