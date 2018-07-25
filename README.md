# Laravel Seo Rewrite 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/black-bits/laravel-seo-rewrite.svg?style=flat-square)](https://packagist.org/packages/black-bits/laravel-seo-rewrite)
[![Total Downloads](https://img.shields.io/packagist/dt/black-bits/laravel-seo-rewrite.svg?style=flat-square)](https://packagist.org/packages/black-bits/laravel-seo-rewrite)

## Introduction

With this package we want to give you a simple way to manage your SEO rewrites in your Laravel application. Rewrites are created and deleted 
by dispatching events in your code.

## Installation

You can install the package via composer.

```bash
composer require black-bits/laravel-seo-rewrite
```

Next you need to run our migrations.

```bash
php artisan migrate
```

When you install the package our LaravelSeoRewrites Middleware is automatically pushed to the global MiddlewareGroup and activated. 

## Usage

To create a new redirect, simply create a new SeoRewrite entry.
 - The source value must be a relative path matching one of your routes.
 - The destination can be any relative or absolute URL.
 - The type must be a valid redirect type (permanent, temporary, etc.)

```php
SeoRewrite::create([
    'source'      => '/old-route',
    'destination' => '/new-route',
    'type'        => 301
]);

SeoRewrite::create([
    'source'      => '/old-route',
    'destination' => 'https://your-new.domain/old-route',
    'type'        => 308
]);
```

We run a basic redirect loop detection on model save, but not all cases can be detected.
Please be aware that you can potentially create loops.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

### Security

If you discover any security related issues, please email [hello@blackbits.io](mailto:hello@blackbits.io) instead of using the issue tracker.

## Credits

- [Oliver Heck](https://github.com/oheck)
- [Andreas Przywara](https://github.com/aprzywara)
- [Adrian Raeuchle](https://github.com/araeuchle)
- [All Contributors](../../contributors)

## Support us

Black Bits, Inc. is a web and consulting agency specialized in Laravel and AWS based in Grants Pass, Oregon. You'll find an overview of what we do [on our website](https://blackbits.io).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.