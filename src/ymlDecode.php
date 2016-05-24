<?php
namespace Converter\Yml\Decode;

function decode($text)
{
        return json_encode(yaml_parse($text), JSON_UNESCAPED_UNICODE);
};
