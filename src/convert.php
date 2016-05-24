<?php
namespace Converter;

function convert($inputFile, $inputFormat, $outputFile, $outputFormat)
{
    $decodeFile = __DIR__ . DIRECTORY_SEPARATOR . 'decoders' . DIRECTORY_SEPARATOR . $inputFormat . 'Decode.php';
    $encodeFile = __DIR__ . DIRECTORY_SEPARATOR . 'encoders' . DIRECTORY_SEPARATOR . $outputFormat . 'Encode.php';
    if(!file_exists($decodeFile) || !file_exists($encodeFile)) {
        return false;
    } else {
        $decodeFunc = require_once $decodeFile;
        $encodeFunc = require_once $encodeFile;
        $tmp = $decodeFunc(file_get_contents($inputFile));
        file_put_contents($outputFile, $encodeFunc($tmp));
    }
    return true;
}
