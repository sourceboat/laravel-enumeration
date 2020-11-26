<?php

namespace Sourceboat\Enumeration;

use Exception;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionObject;
use Sourceboat\Enumeration\Casts\Enum;
use Sourceboat\Enumeration\Exceptions\ExtendsConcreteException;
use Sourceboat\Enumeration\Exceptions\UndefinedMemberException;
use Sourceboat\Enumeration\Exceptions\UndefinedMemberExceptionInterface;
use Sourceboat\Enumeration\Rules\EnumerationValue;

/**
 * Abstract class to extend from for enum functionality.
 *
 * Many functions are extracted from the package `eloquent/enumeration`
 * and therefore the following notice applies to them, conforming with their MIT-Licence:
 * Copyright © 2017 Erin Millard
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
abstract class Enumeration implements Castable
{
    /**
     * Path to the localization for the enum-values.
     *
     * @var string
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    protected static $localizationPath = null;

    /**
     * @var string
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    private $key;

    /** @var mixed */
    private $value;

    /**
     * @var array<static>
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    private static $members = [];

    /**
     * Construct and register a new value multiton member.
     *
     * @api
     * @param string $key The string key to associate with this member.
     * @param mixed $value The value of this member.
     * @throws \Sourceboat\Enumeration\Exception\ExtendsConcreteException If the constructed member has an invalid inheritance hierarchy.
     */
    protected function __construct(string $key, $value)
    {
        $this->key = $key;
        $this->value = $value;

        self::registerMember($this);
    }

    /**
     * Get the default enum member.
     * Override for your own value / logic.
     *
     * @return static
     */
    public static function defaultMember()
    {
        return collect(static::members())
            ->first();
    }

    /**
     * Get a random member of this enum.
     *
     * @param array<mixed>|null $blacklist
     * @return static
     */
    public static function randomMember(?array $blacklist = [])
    {
        return collect(self::membersByBlacklist($blacklist))
            ->random();
    }

    /**
     * Get the localized version of value.
     *
     * @return string
     */
    public function localized(): string
    {
        return trans(static::getLocalizationPath() . '.' . $this->value());
    }

    /**
     * Check if this instance equals to a specific member of the enum.
     *
     * @param static $value The member to check for
     * @return bool
     */
    public function is($value): bool
    {
        return $this === $value;
    }

    /**
     * Returns the string key of this member.
     *
     * @api
     * @return string The associated string key of this member.
     */
    final public function key(): string
    {
        return $this->key;
    }

    /**
     * Check if this member is in the specified list of members.
     *
     * @api
     * @param static $a The first member to check.
     * @param static $b The second member to check.
     * @param static $c,... Additional members to check.
     * @return bool True if this member is in the specified list of members.
     */
    final public function anyOf($a, $b): bool
    {
        return $this->anyOfArray(func_get_args());
    }

    /**
     * Check if this member is in the specified list of members.
     *
     * @api
     * @param array<static> $values An array of members to search.
     * @return bool True if this member is in the specified list of members.
     */
    final public function anyOfArray(array $values): bool
    {
        return in_array($this, $values, true);
    }

    /**
     * Returns the value of this member.
     *
     * @api
     * @return mixed The value of this member.
     */
    final public function value()
    {
        return $this->value;
    }

    /**
     * Get all values in this enumeration.
     *
     * @return array<mixed>
     */
    public static function values(): array
    {
        return collect(self::members())
            ->map->value()
            ->values()
            ->all();
    }

    /**
     * Get all values in this enumeration.
     *
     * @return array<mixed>
     */
    public static function localizedValues(): array
    {
        return collect(self::members())
            ->map->localized()
            ->values()
            ->all();
    }

    /**
     * Get all keys in this enumeration.
     *
     * @return array<string>
     */
    public static function keys(): array
    {
        return collect(self::members())
            ->map->key()
            ->values()
            ->all();
    }

    /**
     * Get the values of this enum as options for a select.
     *
     * @param array<mixed>|null $blacklist
     * @return array<mixed> options
     */
    public static function toLocalizedSelectArray(?array $blacklist = []): array
    {
        return collect(self::membersByBlacklist($blacklist))
            ->mapWithKeys(static function (Enumeration $item): array {
                return [$item->value() => $item->localized()];
            })
            ->all();
    }

    /**
     * Get the values of this enum as options for a select.
     *
     * @param array<mixed>|null $blacklist
     * @return array<mixed> options
     */
    public static function toSelectArray(?array $blacklist = []): array
    {
        return collect(self::membersByBlacklist($blacklist))
            ->mapWithKeys(static function (Enumeration $item): array {
                return [$item->value() => $item->key()];
            })
            ->all();
    }

    /**
     * Get the members of this enum filtered by $blacklist.
     *
     * @param array<mixed>|null $blacklist
     * @return array<static> members
     */
    public static function membersByBlacklist(?array $blacklist = []): array
    {
        return self::membersByPredicate(static function (Enumeration $enumValue) use ($blacklist): bool {
            return !$enumValue->anyOfArray($blacklist);
        });
    }

    /**
     * Get a laravel validation rule for this enum as whitelist.
     *
     * @return \Sourceboat\Enumeration\Rules\EnumerationValue
     */
    public static function makeRule(): EnumerationValue
    {
        return self::makeRuleWithBlacklist();
    }

    /**
     * Get a laravel validation rule for this enum as whitelist.
     *
     * @param array<mixed>|null $whitelist the values allowed for this rule, all when left blank.
     * @return \Sourceboat\Enumeration\Rules\EnumerationValue
     */
    public static function makeRuleWithWhitelist(?array $whitelist = null): EnumerationValue
    {
        return new EnumerationValue(static::class, $whitelist);
    }

    /**
     * Get a laravel validation rule for this enum as blacklist.
     *
     * @param array<mixed>|null $blacklist the values allowed for this rule, all when left blank.
     * @return \Sourceboat\Enumeration\Rules\EnumerationValue
     */
    public static function makeRuleWithBlacklist(?array $blacklist = []): EnumerationValue
    {
        return self::makeRuleWithWhitelist(self::membersByBlacklist($blacklist));
    }

    /**
     * Checks if this enum has a member with the given value.
     *
     * @param mixed $value
     * @return bool
     */
    public static function hasValue($value): bool
    {
        return in_array($value, static::values(), true);
    }

    /**
     * Checks if this enum has a member with the given key.
     *
     * @param string $key
     * @return bool
     */
    public static function hasKey(string $key): bool
    {
        return in_array($key, static::keys(), true);
    }

    /**
     * @param array<mixed> $arguments
     * @return \Illuminate\Contracts\Database\Eloquent\CastsAttributes
     */
    public static function castUsing(array $arguments): CastsAttributes
    {
        return new Enum(static::class, ...$arguments);
    }

    /**
     * Returns a single member by string key.
     *
     * @api
     * @param string $key The string key associated with the member.
     * @param bool|null $isCaseSensitive True if the search should be case sensitive.
     * @return static The member associated with the given string key.
     * @throws \Sourceboat\Enumeration\UndefinedMemberExceptionInterface If no associated member is found.
     */
    final public static function memberByKey(string $key, ?bool $isCaseSensitive = null)
    {
        return static::memberBy('key', $key, $isCaseSensitive);
    }

    /**
     * Returns a single member by string key. Additionally returns a default if
     * no associated member is found.
     *
     * @api
     * @param string $key The string key associated with the member.
     * @param static|null $default The default value to return.
     * @param bool|null $isCaseSensitive True if the search should be case sensitive.
     * @return static The member associated with the given string key, or the default value.
     */
    final public static function memberByKeyWithDefault(string $key, $default = null, ?bool $isCaseSensitive = null)
    {
        return static::memberByWithDefault('key', $key, $default, $isCaseSensitive);
    }

    /**
     * Returns a single member by string key. Additionally returns null if the
     * supplied key is null.
     *
     * @api
     * @param string|null $key The string key associated with the member, or null.
     * @param bool|null $isCaseSensitive True if the search should be case sensitive.
     * @return static|null The member associated with the given string key, or null if the supplied key is null.
     * @throws \Sourceboat\Enumeration\UndefinedMemberExceptionInterface If no associated member is found.
     */
    final public static function memberOrNullByKey(string $key, ?bool $isCaseSensitive = null)
    {
        return static::memberOrNullBy('key', $key, $isCaseSensitive);
    }

    /**
     * Returns a single member by comparison with the result of an accessor
     * method.
     *
     * @api
     * @param string $property The name of the property (accessor method) to match.
     * @param mixed $value The value to match.
     * @param bool|null $isCaseSensitive True if the search should be case sensitive.
     * @return static The first member for which $member->{$property}() === $value.
     * @throws \Sourceboat\Enumeration\UndefinedMemberExceptionInterface If no associated member is found.
     */
    final public static function memberBy(string $property, $value, ?bool $isCaseSensitive = null)
    {
        $member = static::memberByWithDefault($property, $value, null, $isCaseSensitive);

        if (is_null($member)) {
            throw static::createUndefinedMemberException(static::class, $property, $value);
        }

        return $member;
    }

    /**
     * Returns a single member by comparison with the result of an accessor
     * method. Additionally returns a default if no associated member is found.
     *
     * @api
     * @param string $property The name of the property (accessor method) to match.
     * @param mixed $value The value to match.
     * @param static|null $default The default value to return.
     * @param bool|null $isCaseSensitive True if the search should be case sensitive.
     * @return static|null The first member for which $member->{$property}() === $value, or the default value.
     */
    final public static function memberByWithDefault(
        string $property,
        $value,
        $default = null,
        ?bool $isCaseSensitive = null
    )
    {
        if (is_null($isCaseSensitive)) {
            $isCaseSensitive = true;
        }

        if (!$isCaseSensitive && is_scalar($value)) {
            $value = strtoupper(strval($value));
        }

        return static::memberByPredicateWithDefault(
            static function (self $member) use (
                $property,
                $value,
                $isCaseSensitive
            )
            {
                $memberValue = $member->{$property}();

                if (!$isCaseSensitive && is_scalar($memberValue)) {
                    $memberValue = strtoupper(strval($memberValue));
                }

                return $memberValue === $value;
            },
            $default,
        );
    }

    /**
     * Returns a single member by comparison with the result of an accessor
     * method. Additionally returns null if the supplied value is null.
     *
     * @api
     * @param string $property The name of the property (accessor method) to match.
     * @param mixed $value The value to match, or null.
     * @param bool|null $isCaseSensitive True if the search should be case sensitive.
     * @return static|null The first member for which $member->{$property}() === $value, or null if the supplied value is null.
     * @throws \Sourceboat\Enumeration\UndefinedMemberExceptionInterface If no associated member is found.
     */
    final public static function memberOrNullBy(string $property, $value, ?bool $isCaseSensitive = null)
    {
        $member = static::memberByWithDefault($property, $value, null, $isCaseSensitive);

        if (is_null($member)) {
            if (is_null($value)) {
                return null;
            }

            throw static::createUndefinedMemberException(static::class, $property, $value);
        }

        return $member;
    }

    /**
     * Returns a single member by predicate callback.
     *
     * @api
     * @param callable $predicate The predicate applies to the member to find a match.
     * @return static The first member for which $predicate($member) evaluates to boolean true.
     * @throws \Sourceboat\Enumeration\UndefinedMemberExceptionInterface If no associated member is found.
     */
    final public static function memberByPredicate(callable $predicate)
    {
        $member = static::memberByPredicateWithDefault($predicate);

        if (is_null($member)) {
            throw static::createUndefinedMemberException(static::class, '<callback>', '<callback>');
        }

        return $member;
    }

    /**
     * Returns a single member by predicate callback. Additionally returns a
     * default if no associated member is found.
     *
     * @api
     * @param callable $predicate The predicate applied to the member to find a match.
     * @param static|null $default The default value to return.
     * @return static The first member for which $predicate($member) evaluates to boolean true, or the default value.
     */
    final public static function memberByPredicateWithDefault(callable $predicate, $default = null)
    {
        foreach (static::members() as $member) {
            if ($predicate($member)) {
                return $member;
            }
        }

        return $default;
    }

    /**
     * Returns an array of all members in this multiton.
     *
     * @api
     * @return array<string,static> All members.
     */
    final public static function members(): array
    {
        $class = static::class;

        if (!array_key_exists($class, self::$members)) {
            self::$members[$class] = [];
            static::initializeMembers();
        }

        return self::$members[$class];
    }

    /**
     * Returns a set of members by comparison with the result of an accessor
     * method.
     *
     * @api
     * @param string $property The name of the property (accessor method) to match.
     * @param mixed $value The value to match.
     * @param bool|null $isCaseSensitive True if the search should be case sensitive.
     * @return array<string,static> All members for which $member->{$property}() === $value.
     */
    final public static function membersBy(string $property, $value, ?bool $isCaseSensitive = null): array
    {
        if ($isCaseSensitive === null) {
            $isCaseSensitive = true;
        }

        if (!$isCaseSensitive && is_scalar($value)) {
            $value = strtoupper(strval($value));
        }

        return static::membersByPredicate(
            static function (self $member) use (
                $property,
                $value,
                $isCaseSensitive
            )
            {
                $memberValue = $member->{$property}();

                if (!$isCaseSensitive && is_scalar($memberValue)) {
                    $memberValue = strtoupper(strval($memberValue));
                }

                return $memberValue === $value;
            },
        );
    }

    /**
     * Returns a set of members by predicate callback.
     *
     * @api
     * @param callable $predicate The predicate applied to the members to find matches.
     * @return array<string,static> All members for which $predicate($member) evaluates to boolean true.
     */
    final public static function membersByPredicate(callable $predicate): array
    {
        $members = [];

        foreach (static::members() as $key => $member) {
            if (!$predicate($member)) {
                continue;
            }

            $members[$key] = $member;
        }

        return $members;
    }

    /**
     * Returns a single member by value.
     *
     * @api
     * @param mixed $value The value associated with the member.
     * @param bool|null $isCaseSensitive True if the search should be case sensitive.
     * @return static The first member with the supplied value.
     * @throws \Sourceboat\Enumeration\UndefinedMemberExceptionInterface If no associated member is found.
     */
    final public static function memberByValue($value, ?bool $isCaseSensitive = null)
    {
        return static::memberBy('value', $value, $isCaseSensitive);
    }

    /**
     * Returns a single member by value. Additionally returns a default if no
     * associated member is found.
     *
     * @api
     * @param mixed $value The value associated with the member.
     * @param static|null $default The default value to return.
     * @param bool|null $isCaseSensitive True if the search should be case sensitive.
     * @return static The first member with the supplied value, or the default value.
     */
    final public static function memberByValueWithDefault($value, $default = null, ?bool $isCaseSensitive = null)
    {
        return static::memberByWithDefault('value', $value, $default, $isCaseSensitive);
    }

    /**
     * Returns a single member by value. Additionally returns null if the
     * supplied value is null.
     *
     * @api
     * @param mixed|null $value The value associated with the member, or null.
     * @param bool|null $isCaseSensitive True if the search should be case sensitive.
     * @return static|null The first member with the supplied value, or null if the supplied value is null.
     * @throws \Sourceboat\Enumeration\UndefinedMemberExceptionInterface If no associated member is found.
     */
    final public static function memberOrNullByValue($value, ?bool $isCaseSensitive = null)
    {
        return static::memberOrNullBy('value', $value, $isCaseSensitive);
    }

    /**
     * Returns a set of members matching the supplied value.
     *
     * @api
     * @param mixed $value The value associated with the members.
     * @param bool|null $isCaseSensitive True if the search should be case sensitive.
     * @return array<string,static> All members with the supplied value.
     */
    final public static function membersByValue($value, ?bool $isCaseSensitive = null): array
    {
        return static::membersBy('value', $value, $isCaseSensitive);
    }

    /**
     * Get the localization path for this enum.
     *
     * @return string
     */
    protected static function getLocalizationPath(): string
    {
        return static::$localizationPath ?? sprintf('enums.%s', static::class);
    }

    /**
     * Override this method in child classes to implement one-time
     * initialization for a multiton class.
     *
     * This method is called the first time the members of a multiton are
     * accessed. It is called via late static binding, and hence can be
     * overridden in child classes.
     *
     * @api
     */
    protected static function initializeMembers(): void
    {
        $reflector = new ReflectionClass(static::class);

        foreach ($reflector->getReflectionConstants() as $constant) {
            if (! $constant->isPublic()) {
                continue;
            }

            new static($constant->getName(), $constant->getValue());
        }
    }

    /**
     * Override this method in child classes to implement custom undefined
     * member exceptions for a multiton class.
     *
     * @api
     * @param string $className The name of the class from which the member was requested.
     * @param string $property The name of the property used to search for the member.
     * @param mixed $value The value of the property used to search for the member.
     * @param \Exception|null $previous The cause, if available.
     * @return \Sourceboat\Enumeration\Exception\UndefinedMemberExceptionInterface The newly created exception.
     */
    protected static function createUndefinedMemberException(
        string $className,
        string $property,
        $value,
        ?Exception $previous = null
    ): UndefinedMemberExceptionInterface
    {
        return new UndefinedMemberException($className, $property, $value, $previous);
    }

    /**
     * Registers the supplied member.
     *
     * Do not attempt to call this method directly. Instead, ensure that
     * AbstractMultiton::__construct() is called from any child classes, as this
     * will also handle registration of the member.
     *
     * @param static $member The member to register.
     * @throws \Sourceboat\Enumeration\Exception\ExtendsConcreteException If the supplied member has an invalid inheritance hierarchy.
     */
    private static function registerMember($member): void
    {
        $reflector = new ReflectionObject($member);
        $parentClass = $reflector->getParentClass();

        if (!$parentClass->isAbstract()) {
            throw new ExtendsConcreteException(
                get_class($member),
                $parentClass->getName(),
            );
        }

        self::$members[static::class][$member->key()] = $member;
    }

    /**
     * Returns a string representation of this member.
     *
     * @return string The string representation.
     */
    public function __toString(): string
    {
        return (string) $this->value();
    }

    /**
     * Implements `is<EnumKey>` methods for the enum.
     *
     * @param string $method
     * @param array<mixed> $arguments
     * @return mixed
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
    public function __call($method, $arguments)
    {
        if (Str::startsWith($method, 'is')) {
            $key = Str::after($method, 'is');

            return $this->is(static::memberByKey($key, false));
        }
    }

    /**
     * Maps static method calls to members.
     *
     * @api
     * @param string $key The string key associated with the member.
     * @param array<mixed> $arguments Ignored.
     * @return static The member associated with the given string key.
     * @throws \Sourceboat\Enumeration\UndefinedMemberExceptionInterface If no associated member is found.
     */
    final public static function __callStatic(string $key, array $arguments)
    {
        return static::memberByKey($key);
    }
}
