<?php

namespace Sourceboat\Enumeration;

use Eloquent\Enumeration\AbstractEnumeration;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Str;
use Sourceboat\Enumeration\Casts\Enum;
use Sourceboat\Enumeration\Rules\EnumerationValue;

/**
 * Abstract class to extend from for enum functionality.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
abstract class Enumeration extends AbstractEnumeration implements Castable
{
    /**
     * Path to the localization for the enum-values.
     *
     * @var string
     */
    protected static $localizationPath = null;

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
     * Get all values in this enumeration.
     *
     * @return array<mixed>
     */
    public static function values(): array
    {
        return collect(self::members())->map->value()->values()->all();
    }

    /**
     * Get all values in this enumeration.
     *
     * @return array<mixed>
     */
    public static function localizedValues(): array
    {
        return collect(self::members())->map->localized()->values()->all();
    }

    /**
     * Get all keys in this enumeration.
     *
     * @return array<string>
     */
    public static function keys(): array
    {
        return collect(self::members())->map->key()->values()->all();
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
                return [ $item->value() => $item->localized() ];
            })->all();
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
                return [ $item->value() => $item->key() ];
            })->all();
    }

    /**
     * Get the members of this enum filtered by $blacklist.
     *
     * @param array<mixed>|null $blacklist
     * @return array<static> members
     */
    public static function membersByBlacklist(?array $blacklist = []): array
    {
        return collect(self::membersByPredicate(static function (Enumeration $enumValue) use ($blacklist): bool {
            return !$enumValue->anyOfArray($blacklist);
        }))->all();
    }

    /**
     * Get a random member of this enum.
     *
     * @param array<mixed>|null $blacklist
     * @return static
     */
    public static function randomMember(?array $blacklist = [])
    {
        return collect(self::membersByBlacklist($blacklist))->random();
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
     * Get the default enum member.
     * Override for your own value / logic.
     *
     * @return static
     */
    public static function defaultMember()
    {
        return collect(static::members())->first();
    }

    /**
     * Checks if this enum has a member with the given value.
     *
     * @param mixed $value
     * @return bool
     */
    public static function hasValue($value): bool
    {
        return in_array($value, static::values());
    }

    /**
     * Checks if this enum has a member with the given key.
     *
     * @param string $key
     * @return bool
     */
    public static function hasKey(string $key): bool
    {
        return in_array($key, static::keys());
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

    public static function castUsing(): CastsAttributes
    {
        return new Enum(static::class);
    }
}
