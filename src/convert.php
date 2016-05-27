<?php
/**
 *  Conversion function
 */
namespace Converter;

use Functional as f;
use Monad\Either;

/**
 * @param string $source
 * @param string $target
 * @param bool   $overwrite
 * @return \FantasyLand\Monad
 */
function convert(string $source, string $target, bool $overwrite = false)
{
    $extension = fileFormat($source);
    $contents = f\sequenceM($extension, fileRead($source));
    $array = f\sequenceM($contents, decode($extension->extract(), $contents->extract()));
    $extension = f\sequenceM($array, fileFormat($target));
    $result = f\sequenceM($extension, encode(
        $extension->extract(),
        is_array($array->extract()) ? $array->extract() : []
    ));
    return f\sequenceM($result, fileWrite($target, $result->extract(), $overwrite));
}


/**
 * @param string $fileName
 * @return static
 */
function fileFormat(string $fileName)
{
    return pathinfo($fileName, PATHINFO_EXTENSION)
        ? Either\Right::of(pathinfo($fileName, PATHINFO_EXTENSION))
        : Either\Left::of('file extension is missing' . PHP_EOL);
}


/**
 * @param string $ext
 * @param string $content
 * @return static
 */
function decode(string $ext, string $content)
{
    switch ($ext) {
        case "json":
            return Either\Right::of(\Converter\Json\decode($content));
        case "xml":
            return Either\Right::of(\Converter\Xml\decode($content));
        case "yml":
        case "yaml":
            return Either\Right::of(\Converter\Yml\decode($content));
    }
    return Either\Left::of('unknown input format ' . $ext . PHP_EOL);
}


/**
 * @param string $ext
 * @param array  $content
 * @return static
 */
function encode(string $ext, array $content)
{
    switch ($ext) {
        case "json":
            return Either\Right::of(\Converter\Json\encode($content));
        case "xml":
            return Either\Right::of(\Converter\Xml\encode($content));
        case "yml":
        case "yaml":
            return Either\Right::of(\Converter\Yml\encode($content));
    }
    return Either\Left::of('unknown output format ' . $ext . PHP_EOL);
}


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


/**
 * @param string $fileName
 * @param string $content
 * @param bool   $overwrite
 * @return static
 */
function fileWrite(string $fileName, string $content, bool $overwrite)
{
    $return = !file_exists($fileName) || $overwrite ? file_put_contents($fileName, $content) : false;
    return  $return !== false
        ? Either\Right::of(true)
        : Either\Left::of('write to file error' . PHP_EOL);
}
