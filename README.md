# laravel-json-translation-loader
A Laravel package to improve the loading of the JSON translation.

[![Travis](https://img.shields.io/travis/JamesHemery/laravel-json-translation-loader.svg?style=for-the-badge)](https://travis-ci.org/JamesHemery/laravel-json-translation-loader)
[![Total Downloads](https://img.shields.io/packagist/dt/jamesh/laravel-json-translation-loader.svg?style=for-the-badge)](https://packagist.org/packages/jamesh/laravel-json-translation-loader)
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg?style=for-the-badge)](https://raw.githubusercontent.com/JamesHemery/laravel-json-translation-loader/master/LICENSE)

This package will allow you to load JSON translation files for groups and namespaces. By default Laravel only allows you to load php files for groups and namespaces translations.

## Installation

You can install the package via composer:

	composer require jamesh/laravel-json-translation-loader

After install package, you should replace Laravel's translation service provider in `config/app.php`
```php
    lluminate\Translation\TranslationServiceProvider::class,
```

By the service provider of this package:
```php
    Jamesh\JsonTranslationLoader\TranslationServiceProvider::class,
```

## Usage

#### Register a namespace

In your service provider:
```php
    public function boot()
    {
        $this->app['translator']->addNamespace('my-namespace', __DIR__ . '/my-custom-lang-directory');
    }
```

## Unit tests

To run the tests, just run `composer install` and `composer test`.