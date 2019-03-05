# laravel-enumeration

[![Build Status](https://travis-ci.org/sourceboat/laravel-enumeration.svg?branch=master)](https://travis-ci.org/sourceboat/laravel-enumeration)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/sourceboat/laravel-enumeration.svg?style=flat-square)](https://packagist.org/packages/sourceboat/laravel-enumeration)
[![Packagist Stable Version](https://img.shields.io/packagist/v/sourceboat/laravel-enumeration.svg?style=flat-square&label=stable)](https://packagist.org/packages/sourceboat/laravel-enumeration)
[![Packagist downloads](https://img.shields.io/packagist/dt/sourceboat/laravel-enumeration.svg?style=flat-square)](https://packagist.org/packages/sourceboat/laravel-enumeration)
[![MIT Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

Strongly typed enum implementation for Laravel. Based on [eloquent/enumeration](https://github.com/eloquent/enumeration) and inspired by [bensampo/laravel-enum](https://github.com/bensampo/laravel-enum)

## Features

* Strongly typed
* Key/value-definition via class constants
* Full featured suite of methods
* Enum artisan generator
* Validation rules for passing enum values as input parameters
* Localization support
* Extendible

## Table of Contents

* [Guide](#guide)
* [Install](#install)
* [Generating enums](#generating-enums)
* [Usage](#usage)
* [Methods](#methods)
* [Validation](#validation)
* [Localization](#localization)
* [License information](#license-infromation)

## Requirements

* eloquent/enumeration 6.0 or newer
* Laravel 5.4 or newer; Tested with 5.7
* PHP 7.1 or newer

## Install

Via Composer

``` bash
$ composer require sourceboat/laravel-enumeration
```

If you're using Laravel < 5.5 you'll need to add the service provider to `config/app.php`
``` php
'Sourceboat\Enumeration\EnumerationServiceProvider'
```

## Generating enums

```php
php artisan make:enum UserType
```

## Usage

Given the following enum:
``` php
<?php

namespace App\Enums;

use Sourceboat\Enumeration\Enumeration;

/**
 * @method static \App\Enums\UserType Administrator() // These are only for autocompletion etc.
 * @method static \App\Enums\UserType Moderator()
 * @method static \App\Enums\UserType Subscriber()
 * @method static \App\Enums\UserType SuperAdministrator()
 */
final class UserType extends Enumeration
{
    const Administrator = 0;
    const Moderator = 1;
    const Subscriber = 2;
    const SuperAdministrator = 3;
}
```

Values can now be accessed like so:
``` php
UserType::Moderator() // Returns an instance of UserType with UserType::Moderator()->value === 1
```

## Methods

### static keys(): array

Returns an array of the keys for an enumeration.

``` php
UserType::keys(); // Returns ['Administrator', 'Moderator', 'Subscriber', 'SuperAdministrator']
```

### static values(): array

Returns an array of the values for an enum.

``` php
UserType::values(); // Returns [0, 1, 2, 3]
```

### key(): string

Returns the key for the given enum value.

``` php
UserType::Moderator()->key(); // Returns 'Moderator'
```

### value(): mixed

Returns the value for the given enum key.

``` php
UserType::Moderator()->value(); // Returns 1
```

### localized(): string

Returns the localized version of the value, default path is `enums.<EnumClass>.<EnumValue>`, path can be overridden by setting `protected static $localizationPath`.

``` php
UserType::SuperAdministrator()->localized(); // Returns for example 'Super Administrator', but `enums.App\Enums\UserType.3` when not set.
```

### static randomMember(): static

Returns a random member from the enum. Useful for factories.

``` php
UserType::randomMember(); // Returns Administrator(), Moderator(), Subscriber() or SuperAdministrator()
```

### static membersByBlacklist(?array): array

Returns all members except the ones given.

``` php
UserType::membersByBlacklist([UserType::Moderator()]); // Returns Administrator(), Subscriber() and SuperAdministrator()
```

### static toSelectArray(): array

Returns the enum for use in a select as value => description.

``` php
UserType::toSelectArray(); // Returns [0 => 'Administrator', 1 => 'Moderator', 2 => 'Subscriber', 3 => 'SuperAdministrator']
```

### toLocalizedSelectArray(): array

Returns the enum for use in a select as value => description, where description is localized using `->localized()`.

``` php
UserType::toLocalizedSelectArray(); // Returns [0 => 'Administrator', 1 => 'Moderator', 2 => 'Subscriber', 3 => 'Super Administrator']
```

## Validation

### Array Validation
You may validate that an enum value passed to a controller is a valid value for a given enum by using the `EnumerationValue` rule, for easier handling there are helper methods for creating the rule: `Enumeraction::makeRule()`, `Enumeration::makeRuleWithWhitelist($whitelist)` and `Enumeration::makeRuleWithBlacklist($blacklist)`.

``` php
public function store(Request $request)
{
    $this->validate($request, [
        'user_type' => [
            'required',
            UserType::makeRule(), // Allows all enumeration values
        ],
    ]);
}
```

``` php
public function store(Request $request)
{
    $this->validate($request, [
        'user_type' => [
            'required',
            UserType::makeRuleWithWhitelist([UserType::Moderator(), UserType::Subscriber()]), // allows only the values `1` and `2`
        ],
    ]);
}
```

``` php
public function store(Request $request)
{
    $this->validate($request, [
        'user_type' => [
            'required',
            UserType::makeRuleWithBlacklist([UserType::SuperAdministrator(), UserType::Administrator()]), // allows all values but the values `0` and `3`
        ],
    ]);
}
```

## Localization

You can translate the strings returned by the `localized` methods using Laravel's built in [localization](https://laravel.com/docs/5.6/localization) features.

Add a new `enums.php` keys file for each of your supported languages. In this example there is one for English and one for Danish.

```php
// resources/lang/en/enums.php
<?php

use App\Enums\UserType;

return [

    UserType::class => [
        UserType::Moderator => 'Moderator',
    ],

];
```

```php
// resources/lang/da/enums.php
<?php

use App\Enums\UserType;

return [

    UserType::class => [
        UserType::Moderator => 'studievært',
    ],

];
```

## License information

Much of the functionality in this Package is inspired by [bensampo/laravel-enum](https://github.com/bensampo/laravel-enum) and some code has been taken from it and modified, for example the `MakeEnumCommand.php`, the `EnumServiceProvider.php` and this readme.

- [bensampo/laravel-enum](https://github.com/bensampo/laravel-enum) is licensed under MIT
- [eloquent/enumeration](https://github.com/eloquent/enumeration) is licensed under MIT
- [laravel/framework](https://github.com/laravel/framework) is licensed under MIT

This package is also licensed under the MIT license.

## TODOs

* [x]  Tests for all enumeration-functions and the rule.
* [ ]  Model-Trait to enable casting of enumerations and "on the fly"-validation for enumeration values on models.
