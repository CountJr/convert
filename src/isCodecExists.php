<?php

namespace Converter;

/**
 * @param string $extension     file extention
 * @param array  $functions     list of functions
 * @return bool
 */
function isCodecExists(string $extension, array $functions)
{
    return array_key_exists($extension, $functions);
}
