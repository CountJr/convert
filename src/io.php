<?php
namespace Converter;

use Functional as f;
use Monad\Either;
use function Functional\curry;

/**
 * @param string $fileName
 * @return static
 */
function fileFormat(string $fileName)
{
    return pathinfo($fileName, PATHINFO_EXTENSION);
}

//const FILEREAD = 'Converter\fileRead';

/**
 * @param $fileName
 * @return static
 */
function fileRead($fileName)
{
    return file_exists($fileName)
        ? Either\Right::of(file_get_contents($fileName))
        : Either\Left::of("file {$fileName} does not exists" . PHP_EOL);
}

const WRITE = 'Converter\fileWrite';

/**
 * @param string $fileName
 * @param string $content
 * @param bool   $overwrite
 * @return static
 */
function fileWrite(string $fileName, bool $overwrite, string $content)
{
    $return = !file_exists($fileName) || $overwrite ? file_put_contents($fileName, $content) : false;
    return  $return !== false
        ? Either\right(true)
        : Either\left('write to file error' . PHP_EOL);
}
