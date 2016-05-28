# convert
[![Build Status](https://travis-ci.org/CountJr/convert.svg?branch=master)](https://travis-ci.org/CountJr/convert)
[![Code Climate](https://codeclimate.com/github/CountJr/convert/badges/gpa.svg)](https://codeclimate.com/github/CountJr/convert)
[![Test Coverage](https://codeclimate.com/github/CountJr/convert/badges/coverage.svg)](https://codeclimate.com/github/CountJr/convert/coverage)
[![Issue Count](https://codeclimate.com/github/CountJr/convert/badges/issue_count.svg)](https://codeclimate.com/github/CountJr/convert)
[![Coverage Status](https://coveralls.io/repos/github/CountJr/convert/badge.svg?branch=master)](https://coveralls.io/github/CountJr/convert?branch=master)


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
4. Run Converter: `php composer.phar exec convert -s Source.file -t Target.file [-o]`

Global installation of Composer (manual)
----------------------------------------

Follow instructions [in the documentation](https://getcomposer.org/doc/00-intro.md#globally)


Requirements
------------

PHP 7.0
