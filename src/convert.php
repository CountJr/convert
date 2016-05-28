<?php
/**
 *  Conversion function
 */
namespace Converter;

use Coders;
use Functional as f;
use Monad\Either;
use function Functional\curry;

/**
 * @param string $source
 * @param string $target
 * @param bool   $overwrite
 * @return \FantasyLand\Monad
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
