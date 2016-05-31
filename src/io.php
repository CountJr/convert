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
    return strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
}

/**
 * @param $fileName     file name
 * @return \Monad\Either
 */
function fileRead(string $fileName)
{

    if (!is_file($fileName)) {
        return left("file {$fileName} does not exists" . PHP_EOL);
    }
    
    if (!is_readable($fileName)) {
        return left("file {$fileName} is not readable" . PHP_EOL);
    }

    return right(file_get_contents($fileName));
    
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
    
    if (file_exists($fileName) && !$overwrite) {
        return left('can\'t overwrite existing file' . PHP_EOL);
    }
    
    if (file_exists($fileName) && !is_writable($fileName)) {
        return left("file {$fileName} is not writable" . PHP_EOL);
    }
    
    file_put_contents($fileName, $content);
    
    return right(true);
}
