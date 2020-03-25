<?php

namespace Sourceboat\Enumeration\Rules;

use Eloquent\Enumeration\Exception\UndefinedMemberExceptionInterface;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class EnumerationValue implements Rule
{
    /**
     * Class of the enum to check.
     *
     * @var string
     */
    private $enumClass;

    /**
     * Whitelist for the enum value to be put in.
     *
     * @var array
     */
    private $values;

    /**
     * Determine whether this rule should check case sensitive or not.
     *
     * @var bool
     */
    private $caseSensitive = false;

    /**
     * Create a new rule instance.
     *
     * @param string $enum The class of the enum to check.
     * @param array<mixed>|null $values A value-whitelist.
     */
    public function __construct(string $enum, ?array $values = null)
    {
        $this->enumClass = $enum;
        $this->values = $values;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     * @return bool
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function passes($attribute, $value): bool
    {
        try {
            return $this->enumClass::memberByValue($value, $this->caseSensitive)
                ->anyOfArray($this->values ?? $this->enumClass::members());
        } catch (UndefinedMemberExceptionInterface $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        $key = 'validation.enum_value';

        return Str::is($key, __($key))
            ? 'The given value is not suitable for :attribute.'
            : __($key);
    }

    /**
     * Set the case sensitivity for this rule.
     *
     * It is not recommended to set this to true for enums with number-values.
     *
     * @param bool $caseSensitive
     * @return void
     */
    public function setCaseSensitivity(bool $caseSensitive): void
    {
        $this->caseSensitive = $caseSensitive;
    }
}
