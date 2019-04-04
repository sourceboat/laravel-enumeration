<?php

namespace Sourceboat\Enumeration;

use Eloquent\Enumeration\AbstractEnumeration;
use Sourceboat\Enumeration\Rules\EnumerationValue;

/**
 * Abstract class to extend from for enum functionality.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
abstract class Enumeration extends AbstractEnumeration
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
     * Get all values in this enumeration.
     *
     * @return array
     */
    public static function values(): array
    {
        return collect(self::members())->map->value()->values()->all();
    }

    /**
     * Get all values in this enumeration.
     *
     * @return array
     */
    public static function localizedValues(): array
    {
        return collect(self::members())->map->localized()->values()->all();
    }

    /**
     * Get all keys in this enumeration.
     *
     * @return array
     */
    public static function keys(): array
    {
        return collect(self::members())->map->key()->values()->all();
    }

    /**
     * Get the values of this enum as options for a select.
     *
     * @param array|null $blacklist
     * @return array options
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
     * @param array|null $blacklist
     * @return array options
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
     * @param array|null $blacklist
     * @return array members
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
     * @param array|null $blacklist
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
     * @param array|null $whitelist the values allowed for this rule, all when left blank.
     * @return \Sourceboat\Enumeration\Rules\EnumerationValue
     */
    public static function makeRuleWithWhitelist(?array $whitelist = null): EnumerationValue
    {
        return new EnumerationValue(static::class, $whitelist);
    }

    /**
     * Get a laravel validation rule for this enum as blacklist.
     *
     * @param array|null $blacklist the values allowed for this rule, all when left blank.
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
     * Returns a string representation of this member.
     *
     * @return string The string representation.
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
     */
    public function __toString()
    {
        return (string) $this->value();
    }
}
