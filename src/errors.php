<?php
/**
 *  Error handler
 *
 * PHP version 7
 *
 * @category None
 * @package  None
 * @author   me <me@somewhere.out>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     none
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
