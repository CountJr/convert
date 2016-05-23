<?php

namespace Converter;


$formats = ['xml', 'yml', 'json'];

// TODO: check formats
if (3 !== count($argv) || !preg_match('/^\w+\.\w{3,4}$/i', trim($argv[1])) || !preg_match('/^\w+\.\w{3,4}$/i', $argv[2])) {
    die("invalid arguments");
} else {
    array_shift($argv);
    list ($fromFile, $toFile, ) = $argv;
}


$fromType = substr($fromFile, strrpos($fromFile, '.') + 1);
$fromType = $fromType === 'yaml' ? 'yml' : $fromType;
if (!in_array($fromType, $formats)){
    die("unsupported input format");
}

$toType = substr($toFile, strrpos($toFile, '.') + 1);
$toType = $toType === 'yaml' ? 'yml' : $toType;
$toFileName = substr($toFile, 0, strrpos($toFile, '.'));
if (!in_array($toType, $formats)){
    die("unsupported output format");
}

$fromFunc = require_once ($fromType . 'Decode.php');
$toFunc = require_once ($toType . 'Encode.php');

try {
    $inputString = file_get_contents($fromFile);
} catch (\Exception $e) {
    die("can't open input file");
}

try {
    file_put_contents($toFileName . '.' . $toType, 
        $toFunc($fromFunc($inputString)));
} catch (\Exception $e) {
    die("can't save to file");
}
exit(0);
