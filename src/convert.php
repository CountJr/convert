<?php
namespace Converter;

function convert($inputFile, $inputFormat, $outputFile, $outputFormat)
{
    $inFunc = '\Converter\\' . ucfirst($inputFormat) . '\\Decode\\decode';
    $outFunc = '\Converter\\' . ucfirst($inputFormat) . '\\Encode\\encode';
    if(!function_exists($inFunc) || !function_exists($outFunc)) {
        return false;
    }
    file_put_contents($outputFile, $outFunc($inFunc(file_get_contents($inputFile))));
    return true;
}
