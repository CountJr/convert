<?php

namespace Converter;

use Monad\Either;
use function Functional\curry;

/**
 * @param string $source        source file name
 * @param string $target        target file name
 * @param bool   $overwrite     overwrite target file if exists
 * @return \Monad\Either
 */
function convert(string $source, string $target, bool $overwrite = false)
{
    $sourceExtension = fileFormat($source);
    $targetExtension = fileFormat($target);

    return fileRead($source)
        ->bind(curry(DECODE, [$sourceExtension]))
        ->bind(curry(ENCODE, [$targetExtension]))
        ->bind(curry(WRITE, [$target, $overwrite]));
}
