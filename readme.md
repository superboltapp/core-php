# core-php

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](license.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Debugging background tasks is already hard enough as it is. Superbolt monitors your scheduled tasks and saves the logs for you.

This package integrates access to the Superbolt API with your PHP application.

## Installation

Via Composer

``` bash
$ composer require superbolt/core-php
```

## Usage

``` php
$apiClient = new Superbolt\Core\Api('YOUR_SUPERBOLT_API_KEY');
$cronLogger = new Superbolt\Core\Cron($api);

$startResponse = $cronLogger->sendStartPing('HelloWorldCommand', '* * * * *', 'production');
$finishResponse = $cronLogger->sendFinishPing($startResponse->getCronToken(), 0);
$logResponse = $cronLogger->sendLog($finishResponse->getCronToken(), 'Hello World', 0);
```

Have a look at [Cron.php](src/Cron.php) to see how each method exactly works. The tests of course also are a great case of how this package can be used.

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
vendor/bin/phpunit
```

## Security

If you discover any security related issues, please email package@superbolt.app instead of using the issue tracker.

## Credits

- [Superbolt team][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/superbolt/core-php.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/superbolt/core-php/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/superbolt/core-php.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/superbolt/core-php.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/superbolt/core-php.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/superbolt/core-php
[link-travis]: https://travis-ci.org/superbolt/core-php
[link-scrutinizer]: https://scrutinizer-ci.com/g/superbolt/core-php/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/superbolt/core-php
[link-downloads]: https://packagist.org/packages/superbolt/core-php
[link-author]: https://github.com/superboltapp
[link-contributors]: ../../contributors
