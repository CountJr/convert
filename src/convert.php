<?php
/**
 *  Conversion function
 */
namespace Converter;

use function \Converter\Error\error;

/**
 * Main function
 *
 * @param  string $source    input file name
 * @param  string $target    output file name
 * @param  bool   $overwrite
 * @return bool
 */
function convert(string $source, string $target, bool $overwrite = false)
{
    $sourceFormat = fileFormat($source);
    $sourceContent = fileRead($source);
    $array = decode($sourceFormat, $sourceContent);

    $targetFormat = fileFormat($target);
    $result = encode($targetFormat, $array);
    fileWrite($target, $result, $overwrite);
    return true;
}

/**
 * Returns file format from extension
 *
 * @param string $fileName full file name
 *
 * @return string file format
 */
function fileFormat(string $fileName)
{
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    if (!$ext) {
        error('invalid file type');
    }
    return $ext;
}

/**
 * Decodes from string to array
 *
 * @param string $ext     file format
 * @param string $content file contents
 *
 * @return array array
 */
function decode(string $ext, string $content)
{
    switch ($ext) {
        case "json":
            return \Converter\Json\decode($content);
        case "xml":
            return \Converter\Xml\decode($content);
        case "yml":
        case "yaml":
            return \Converter\Yml\decode($content);
    }
    throw new \Exception('unknown input format' . $ext);
}

/**
 * Returns encoded string from array
 *
 * @param string $ext     file format
 * @param array  $content array
 *
 * @return string string
 */
function encode(string $ext, array $content)
{
    switch ($ext) {
        case "json":
            return \Converter\Json\encode($content);
        case "xml":
            return \Converter\Xml\encode($content);
        case "yml":
        case "yaml":
            return \Converter\Yml\encode($content);
    }
    throw new \Exception('unknown input format' . $ext);
}

/**
 * Read file
 *
 * @param string $fileName file name of file to read
 *
 * @return string file contents
 */
function fileRead(string $fileName)
{
    if (!file_exists($fileName)) {
        error('file not exists ' . $fileName);
    }
    return file_get_contents($fileName);
}

/**
 * Write string to file
 *
 * @param string $fileName  file name
 * @param string $content   contents to write
 * @param bool   $overwrite can overwrite target file
 *
 * @return bool
 */
function fileWrite(string $fileName, string $content, bool $overwrite)
{
    if (!$overwrite && file_exists($fileName)) {
        error('file exists and cannot be overwritten');
    }
    file_put_contents($fileName, $content);
    return true;
}
