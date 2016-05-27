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
    if ($sourceFormat === false) {
        return false;
    }
    $sourceContent = fileRead($source);
    if ($sourceContent === false) {
        return false;
    }
    $array = decode($sourceFormat, $sourceContent);
    if ($array === false) {
        return false;
    }
    $targetFormat = fileFormat($target);
    if ($targetFormat === false) {
        return false;
    }
    $result = encode($targetFormat, $array);
    if ($result === false) {
        return false;
    }
    if (fileWrite($target, $result, $overwrite) === false) {
        return false;
    }
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
        fwrite(STDERR, 'file extension is missing' . PHP_EOL);
        return false;
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
    fwrite(STDERR, 'unknown input format ' . $ext . PHP_EOL);
    return false;
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
    fwrite(STDERR, 'unknown output format ' . $ext . PHP_EOL);
    return false;
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
        fwrite(STDERR, 'file not exists ' . $fileName . PHP_EOL);
        return false;
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
        fwrite(STDERR, 'file exists and cannot be overwritten');
        return false;
    }
    file_put_contents($fileName, $content);
    return true;
}
