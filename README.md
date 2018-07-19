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

When you install the package our LaravelSeoRewrites Middleware is automatically pushed to the MiddlewareGroup and activated. 

## Usage

When you save a model, eg a Post model and their slug has changed, you want to redirect from the old slug to the new slug. 
So you could use an Observer class to listen for an update event and check if the old value differs from the one like so:

```php
if ($post->slug !== $post->getOriginal('slug')) {
    CreateSeoRewriteEvent::dispatch($post->getOriginal('slug'), $post->slug);
}
```

You now have created a redirect from the old slug to the new slug!

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