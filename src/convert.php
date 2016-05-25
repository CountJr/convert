<?php
/**
 *  Conversion function
 *
 * PHP version 7
 *
 * @category None
 * @package  None
 * @author   me <me@somewhere.out>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     none
 */
namespace Converter;

use function \Converter\Error\error;

/**
 * Main function
 *
 * @param string $inputFile  input file name
 * @param string $outputFile output file name
 * 
 * @return bool
 */
function convert(string $inputFile, string $outputFile)
{
    $inputFormat = fileFormat($inputFile);
    $inputContent = fileRead($inputFile);
    $array = decode($inputFormat, $inputContent);

    $outputFormat = fileFormat($outputFile);
    $result = encode($inputFormat, $array);
    fileWrite($outputFile, $result);
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
    $fileExt = strtolower(substr($fileName, strrpos($fileName, '.') + 1));
    if (!$fileExt) {
        error('invalid file type');
    }
    return $fileExt;
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
        return \Converter\Yml\decode($content);
    default:
        error('unknown input format' . $ext);
    }
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
        return \Converter\Yml\encode($content);
    default:
        error('unknown output format' . $ext);
    }
}

/**
 * Reading file
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
 * @param string $fileName file name
 * @param string $content  contents to write
 *                        
 * @return bool
 */
function fileWrite(string $fileName, string $content)
{
    file_put_contents($fileName, $content);
    return true;
}
