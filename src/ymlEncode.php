<?php
namespace Converter\Yml\Encode;

function encode($json)
{
    return yaml_emit(json_decode($json, true), YAML_UTF8_ENCODING);
}
