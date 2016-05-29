<?php
namespace Converter;

use function Functional\curry;
use function Monad\Either\left as left;
use function Monad\Either\right as right;

/**
 * @param string $fileName      file name
 * @return string               file extension
 */
function fileFormat(string $fileName)
{
    return pathinfo($fileName, PATHINFO_EXTENSION);
}

/**
 * @param $fileName     file name
 * @return \Monad\Either
 */
function fileRead($fileName)
{
    return file_exists($fileName)
        ? right(file_get_contents($fileName))
        : left("file {$fileName} does not exists" . PHP_EOL);
}

const WRITE = 'Converter\fileWrite';

/**
 * @param string $fileName      file name
 * @param string $content       content to write
 * @param bool   $overwrite     overwrite target file if exists
 * @return \Monad\Either
 */
function fileWrite(string $fileName, bool $overwrite, string $content)
{
    $return = !file_exists($fileName) || $overwrite ? file_put_contents($fileName, $content) : false;
    
    return  $return !== false
        ? right(true)
        : left('write to file error' . PHP_EOL);
}
