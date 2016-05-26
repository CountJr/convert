<?php
/**
 *  Json encode/decode
 */
namespace Converter\Json;

/**
 * Json decode
 *
 * @param string $text input string
 *
 * @return array
 */
function decode(string $text)
{
    return json_decode($text, true);
}

/**
 * Json encode
 *
 * @param array $arr input array
 *
 * @return string
 */
function encode(array $arr)
{
    return json_encode($arr, JSON_UNESCAPED_UNICODE);
}
