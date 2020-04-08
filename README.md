# laravel-enumeration

[![Build Status](https://travis-ci.org/sourceboat/laravel-enumeration.svg?branch=master)](https://travis-ci.org/sourceboat/laravel-enumeration)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/sourceboat/laravel-enumeration.svg?style=flat-square)](https://packagist.org/packages/sourceboat/laravel-enumeration)
[![Packagist Stable Version](https://img.shields.io/packagist/v/sourceboat/laravel-enumeration.svg?style=flat-square&label=stable)](https://packagist.org/packages/sourceboat/laravel-enumeration)
[![Packagist downloads](https://img.shields.io/packagist/dt/sourceboat/laravel-enumeration.svg?style=flat-square)](https://packagist.org/packages/sourceboat/laravel-enumeration)
[![MIT Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

Enum implementation for Laravel. Based on [eloquent/enumeration](https://github.com/eloquent/enumeration) and inspired by [bensampo/laravel-enum](https://github.com/bensampo/laravel-enum)

## Features

* Key/value-definition via class constants
* Full featured suite of methods
* Enum artisan generator
* Validation rules for passing enum values as input parameters
* Localization support
* Support to give enum Members a weight
* Extensible

## Table of Contents

* [Requirements](#requirements)
* [Install](#install)
* [Generating enums](#generating-enums)
* [Usage](#usage)
* [Methods](#methods)
* [Validation](#validation)
* [Localization](#localization)
* [Custom cast](#custom-cast)
* [Weighted Enums](#weighted-enums)
* [License information](#license-information)

## Requirements

* eloquent/enumeration 6.0 or newer
* Laravel 7 or newer;
* PHP 7.3 or newer

## Install

Via Composer

``` bash
composer require sourceboat/laravel-enumeration
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

### is(static): bool

Check if the instance is equal to the given member.

``` php
UserType::SuperAdministrator()->is(UserType::Moderator()); // -> false
UserType::SuperAdministrator()->is(UserType::SuperAdministrator()); // -> true
```

### is<Enum_Value>(): bool

Check if the instance is equal to the member indicated by the method name.

``` php
UserType::SuperAdministrator()->isModerator(); // -> false
UserType::SuperAdministrator()->isSuperAdministrator(); // -> true
UserType::SuperAdministrator()->isStudent(); // -> throws Eloquent\Enumeration\Exception\UndefinedMemberException
```

### static randomMember(): static

Returns a random member from the enum. Useful for factories.

``` php
UserType::randomMember(); // Returns Administrator(), Moderator(), Subscriber() or SuperAdministrator()
```

### static defaultMember(): static

Returns the default member for the enum. This function defaults to the first member of the enum when not overridden.

``` php
UserType::defaultMember(); // Returns Administrator()
```

### static membersByBlacklist(?array): array

Returns all members except the ones given.

``` php
UserType::membersByBlacklist([UserType::Moderator()]); // Returns Administrator(), Subscriber() and SuperAdministrator()
```

### static toSelectArray(?array): array

Returns the enum for use in a select as value => key. It is also possible to set an optional blacklist-parameter to filter the returned values.

``` php
UserType::toSelectArray(); // Returns [0 => 'Administrator', 1 => 'Moderator', 2 => 'Subscriber', 3 => 'SuperAdministrator']
```

### toLocalizedSelectArray(?array): array

Returns the enum for use in a select as value => localizedValue, where localizedValue is localized using `->localized()`.
Like `toSelectArray` it is possible to set an optional blacklist-parameter to filter the returned values.

``` php
UserType::toLocalizedSelectArray(); // Returns [0 => 'Administrator', 1 => 'Moderator', 2 => 'Subscriber', 3 => 'Super Administrator']
```

## Validation

### Array Validation

You may validate that a value passed to a controller is a valid value for a given enum by using the `EnumerationValue` rule, for easier handling there are helper methods for creating the rule: `Enumeration::makeRule()`, `Enumeration::makeRuleWithWhitelist($whitelist)` and `Enumeration::makeRuleWithBlacklist($blacklist)`.

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

## Custom Cast

You can use the `Enum` custom cast to enable automatic casting of properties to enums. When used, it will set the property to the default members value when set to an invalid value, same goes when the initial value is invalid when getting it, it will return the default member.

```php
<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Model;
use Sourceboat\Enumeration\Casts\Enum;

class User extends Model
{
    protected $casts = [
        'type' => Enums::class . ':' . UserType::class,
    ];
}
```

By default the custom cast treats the property as nullable, meaning that the property can be set to null and also return it, instead of an enum member, this can the disabled on an per property basis:

```php
<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Model;
use Sourceboat\Enumeration\Casts\Enum;

class User extends Model
{
    protected $casts = [
        'type' => Enums::class . ':' . UserType::class . ',0', // appending the 0 means it is not nullable,
    ];                                                         // this seems counter intuitive, but thats the way it is recognized as `false`,
}                                                              // as `false` is somehow evaluated as `true`.
```

If the casted attribute is not set to be nullable and/or has a value not represented by the enum, you will get the default member of the enum when accessing the attribute.

```php
// For example when the value has been changed manually in the database. Let's say the type is `10`.
$type = $user->type

// Then the following will be the case:

echo $type === UserType::defaultMember(); // "true"
echo $type->value; // "0"
```

Since Laravel 7.5 and version 2.1 of this package it is also possible to use the enum itself as cast type hint, but beware that `null` is always an allowed value.

```php
<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $casts = [
        'type' => UserType::class, 
    ];
}
```

## Weighted Enums

It is Possible to define weights for enum members. the standard way is to define the weights a config file and them implement the `Weighted`-interface with the `IsWeighted`-trait and define the path to your config. The weights can be defined as integer or float values.

``` php
// The Enum
<?php

namespace App\Enums;

use Sourceboat\Enumeration\Enumeration;
use Sourceboat\Enumeration\Enums\Interfaces\Weighted;
use Sourceboat\Enumeration\Enums\Traits\IsWeighted;

/**
 * @method static \App\Enums\UserType Administrator() // These are only for autocompletion etc.
 * @method static \App\Enums\UserType Moderator()
 * @method static \App\Enums\UserType Subscriber()
 * @method static \App\Enums\UserType SuperAdministrator()
 */
final class UserType extends Enumeration implements Weighted
{
    use IsWeighted;

    const Administrator = 0;
    const Moderator = 1;
    const Subscriber = 2;
    const SuperAdministrator = 3;
}
```

For further customization the `Weighted::weight(): int|float`-method can be overridden to use your own way of defining the weights.

The following methods for comparing weighted enum members are available:

* `Weighted::isGreaterThan(Weighted): bool`
* `Weighted::isGreaterThanOrEuqalTo(Weighted): bool`
* `Weighted::isEuqalTo(Weighted): bool`
* `Weighted::isLessThanOrEqualTo(Weighted): bool`
* `Weighted::isLessThan(Weighted): bool`

The following methods for filtering the enum are available:

* `Weighted::getMembersGreaterThanThis(): array<Weighted>`
* `Weighted::getMembersGreaterThanOrEqualToThis(): array<Weighted>`
* `Weighted::getMembersEqualToThis(): array<Weighted>`
* `Weighted::getMembersLessThanOrEqualToThis(): array<Weighted>`
* `Weighted::getMembersLessThanThis(): array<Weighted>`
* `static Weighted::getMembersGreaterThan(Weighted): array<Weighted>`
* `static Weighted::getMembersGreaterThanOrEqualTo(Weighted): array<Weighted>`
* `static Weighted::getMembersEqualTo(Weighted): array<Weighted>`
* `static Weighted::getMembersLessThanOrEqualTo(Weighted): array<Weighted>`
* `static Weighted::getMembersLessThan(Weighted): array<Weighted>`
* `static Weighted::getMembersBetween(Weighted $lowerMember, Weighted $higherMember): array<Weighted>`
* `static Weighted::getMembersBetweenOrEqualTo(Weighted $lowerMember, Weighted $higherMember): array<Weighted>`

### Model-trait `HasWeightedEnumScopes`

With the model trait `HasWeightedEnumsScopes` you can easily search for models with enum values greater than one or between two other enum value, even with string values.

Available scopes:

* `whereGreaterThanEnum(string $attribute, Weighted $member)`
* `whereGreaterThanOrEqualToEnum(string $attribute, Weighted $member)`
* `whereEqualToEnum(string $attribute, Weighted $member)`
* `whereLessThanOrEqualToEnum(string $attribute, Weighted $member)`
* `whereLessThanEnum(string $attribute, Weighted $member)`
* `whereBetweenEnum(string $attribute, Weighted $lowerMember, Weighted $higherMember)`
* `whereBetweenOrEqualEnum(string $attribute, Weighted $lowerMember, Weighted $higherMember)`


## Configurable Enums

It is possible to define config values for enums and access them without defining the whole path, but a logical part of it.
The default path for the configuration is: `enums.<enum class>.<given key>.<enum value>`

For example:

``` php
// The Enum
<?php

namespace App\Enums;

use Sourceboat\Enumeration\Enumeration;
use Sourceboat\Enumeration\Enums\Interfaces\Configurable;
use Sourceboat\Enumeration\Enums\Traits\IsConfigurable;

/**
 * @method static \App\Enums\UserType Administrator()
 * @method static \App\Enums\UserType Moderator()
 * @method static \App\Enums\UserType Subscriber()
 * @method static \App\Enums\UserType SuperAdministrator()
 */
final class UserType extends Enumeration implements Configurable
{
    use IsConfigurable;

    const Administrator = 0;
    const Moderator = 1;
    const Subscriber = 2;
    const SuperAdministrator = 3;
}
```

``` php
// enums.php
<?php
use App\Enums\UserType;

return [
    UserType::class => [
        'permissions' => [
            UserType::Administrator => [
                'user.foreign.edit',
                'user.foreign.delete',
            ],
            UserType::Subscriber => [
                'user.self.edit',
                'user.self.delete',
            ],
        ]
    ]
]
```

then you can access these values by:

``` php 
UserType::Subscriber()->config('permissions'); // which return the given array.
UserType::Moderator()->config('permissions', ['thread.foreign.archive']); // you can also define a default value.
```


## License information

Much of the functionality in this Package is inspired by [bensampo/laravel-enum](https://github.com/bensampo/laravel-enum) and some code has been taken from it and modified, for example the `MakeEnumCommand.php`, the `EnumServiceProvider.php` and this readme.

- [bensampo/laravel-enum](https://github.com/bensampo/laravel-enum) is licensed under MIT
- [eloquent/enumeration](https://github.com/eloquent/enumeration) is licensed under MIT
- [laravel/framework](https://github.com/laravel/framework) is licensed under MIT

This package is also licensed under the MIT license.
