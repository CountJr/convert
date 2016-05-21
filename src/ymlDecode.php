<?php
namespace Decoder;

function parse($text)
{
    return json_encode(yaml_parse($text), JSON_UNESCAPED_UNICODE);
}

function handParse($text)
{
    // YAML 1.2 specifications used
}
