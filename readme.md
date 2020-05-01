# core-php

[![Latest Version on Packagist][ico-version]][link-packagist]
[![GitHub Workflow Status][ico-actions]][link-actions]
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

If you discover any security related issues, please email info@superbolt.app instead of using the issue tracker.

## Credits

- [Superbolt team][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/superbolt/core-php.svg?style=flat-square
[ico-actions]: https://img.shields.io/github/workflow/status/superboltapp/core-php/Run%20tests/master?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/superbolt/core-php.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/superbolt/core-php
[link-actions]: https://github.com/superboltapp/core-php/actions
[link-downloads]: https://packagist.org/packages/superbolt/core-php
[link-author]: https://github.com/superboltapp
[link-contributors]: ../../contributors
