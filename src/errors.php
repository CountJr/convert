<?php
/**
 *  Error handler
 *
 */
namespace Converter\Error;

/**
 * Error handler
 *
 * @param string $text    error description
 * @param int    $errCode error code
 *
 * @return void
 */
function error(string $text, int $errCode = 1)
{
    echo $text . "\n";
    exit($errCode);
}
