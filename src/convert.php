<?php
namespace Converter;

function convert($inputFile, $inputFormat, $outputFile, $outputFormat)
{
    echo "lalalal\n";
    return true;
}
/*
$fromFunc = require_once($fromType . 'Decode.php');
$toFunc = require_once($toType . 'Encode.php');






try {
    $inputString = file_get_contents($fromFile);
} catch (\Exception $e) {
    die("can't open input file");
}

try {
    file_put_contents($toFileName . '.' . $toType, $toFunc($fromFunc($inputString)));
} catch (\Exception $e) {
    die("can't save to file");
}
exit(0);*/
