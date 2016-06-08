# convert
[![Build Status](https://travis-ci.org/CountJr/convert.svg?branch=master)](https://travis-ci.org/CountJr/convert)
[![Code Climate](https://codeclimate.com/github/CountJr/convert/badges/gpa.svg)](https://codeclimate.com/github/CountJr/convert)
[![Test Coverage](https://codeclimate.com/github/CountJr/convert/badges/coverage.svg)](https://codeclimate.com/github/CountJr/convert/coverage)

Installation / Usage
--------------------

1. Download and install Composer by following the [official instructions](https://getcomposer.org/download/).
2. Create a composer.json defining your dependencies.

    ``` json
    "require": {
        "CountJr/convert": "dev-master"
      },
      "repositories": [
        {
          "type": "vcs",
          "url": "https://github.com/CountJr/convert"
        }
      ],
    ```

3. Run Composer: `php composer.phar install`

Global installation of Composer (manual)
----------------------------------------

Follow instructions [in the documentation](https://getcomposer.org/doc/00-intro.md#globally)

CLI usage
---------

Run Converter: `php composer.phar exec convert -s Source.file -t Target.file [-o]`

Library usage
-------------

Build convert function:

`$convert = \Converter\buildConvert([array ("decode" => callable $decodeFunction, "decode" => callable $encodeFunction)])`

$decodeFunction and $encodeFunction are optional.

use convert function

`$convert( string $sourceFileName, string $targetFileName, [bool $overwrite])`

Requirements
------------

PHP 7.0
