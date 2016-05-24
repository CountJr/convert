<?php
namespace Converter;

function convert($inputFile, $inputFormat, $outputFile, $outputFormat)
{
    $text = file_get_contents($inputFile);
    switch ($inputFormat) {
        case "json":
            $tmpin = $text;
            break;
        case "xml":
            $tmpin = \Converter\Xml\Decode\decode($text);
            break;
        case "yml":
            $tmpin = \Converter\Yml\Decode\decode($text);
            break;
        default:
            return false;
    }
    switch ($outputFormat) {
        case "json":
            $tmpout = $tmpin;
            break;
        case "xml":
            $tmpout = \Converter\Xml\Encode\encode($tmpin);
            break;
        case "yml":
            $tmpout = \Converter\Yml\Encode\encode($tmpin);
            break;
        default:
            return false;
    }
    file_put_contents($outputFile, $tmpout);
    return true;
}
