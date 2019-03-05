<?php

namespace Sourceboat\Enumeration\Rules;

use Eloquent\Enumeration\Exception\UndefinedMemberExceptionInterface;
use Illuminate\Contracts\Validation\Rule;

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
    private $casesensitive = false;

    /**
     * Create a new rule instance.
     *
     * @param string $enum The class of the enum to check.
     * @param array|null $values A value-whitelist.
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
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function passes($attribute, $value): bool
    {
        try {
            return $this->enumClass::memberByValue($value, $this->casesensitive)
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
        return __('laravel_enumeration::validation.enum_value');
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
        $this->casesensitive = $caseSensitive;
    }
}
