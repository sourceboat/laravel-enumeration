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
            return $this->enumClass::memberByValue($value)
                ->isAnyOfArray($this->values ?? $this->enumClass::members());
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
}
