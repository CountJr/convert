<?php
namespace Encoder;

function encode($json)
{
    return yaml_emit(json_decode($json, TRUE), YAML_UTF8_ENCODING);
}

