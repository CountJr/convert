<?php
/**
 *  YML encode/decode
 */
namespace Converter\Yml;

use Symfony\Component\Yaml\Yaml;

/**
 * YML(YAML) decode
 *
 * @param string $text input string
 *
 * @return mixed
 */
function decode(string $text)
{
    return Yaml::parse($text);
}

/**
 * YML(YAML) encode
 *
 * @param array $arr input array
 *
 * @return string
 */
function encode(array $arr)
{
    return Yaml::dump($arr, 2, 2);
}
