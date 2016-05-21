<?php

namespace Converter;


//$formats = ['xml', 'yml', 'json'];

// TODO: check formats

list ($dumb, $fromFile, $toFile, ) = $argv;

$fromType = substr($fromFile, strrpos($fromFile, '.') + 1);
$fromType = $fromType === 'yaml' ? 'yml' : $fromType;

$toType = substr($toFile, strrpos($toFile, '.') + 1);
$toType = $toType === 'yaml' ? 'yml' : $toType;
$toFileName = substr($toFile, 0, strrpos($toFile, '.'));

require_once ($fromType . 'Decode.php');
require_once ($toType . 'Encode.php');

$contens = file_get_contents($fromFile);
$tmp1 = \Decoder\parse($contens);
//print_r($tmp1);
$tmp2 = \Encoder\encode($tmp1);
//print_r($tmp2);
file_put_contents($toFileName . '.' . $toType, $tmp2);
