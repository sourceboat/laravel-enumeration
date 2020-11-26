<?php

namespace Sourceboat\Enumeration\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Enum implements CastsAttributes
{
    /**
     * @var string
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    private $enumClass;

    /**
     * @var bool
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    private $nullable;

    public function __construct(string $enumClass, bool $nullable = true)
    {
        $this->enumClass = $enumClass;
        $this->nullable = $nullable;
    }

    /**
     * Transform the attribute from the underlying model values.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param mixed $value
     * @param array<mixed> $attributes
     * @return self|null
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingNativeTypeHint
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($this->enumClass::hasValue($value)) {
            return $this->enumClass::memberByValue($value);
        }

        if ($this->nullable && is_null($value)) {
            return $value;
        }

        return $this->enumClass::defaultMember();
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param mixed $value
     * @param array<mixed> $attributes
     * @return array<mixed>
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function set($model, string $key, $value, array $attributes): array
    {
        if ($this->enumClass::hasValue($value) || ($this->nullable && is_null($value))) {
            return [
                $key => $value,
            ];
        }

        if ($value instanceof $this->enumClass) {
            return [
                $key => $value->value(),
            ];
        }

        return [
            $key => $this->enumClass::defaultMember()->value(),
        ];
    }
}
