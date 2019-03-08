<?php

namespace Sourceboat\Enumeration\Traits;

use Eloquent\Enumeration\Exception\UndefinedMemberException;

/**
 * This trait allows for casting of model properties to enum members and
 * setting them via enum members.
 */
trait HasEnums
{
    /**
     * Get the attribute-enum-mapping from this model.
     *
     * @return array
     */
    public function getEnumsArray(): array
    {
        return $this->enums ?? [];
    }

    /**
     * Returns whether the attribute was marked as enum
     *
     * @param string $key
     * @return bool
     */
    public function isEnumAttribute(string $key): bool
    {
        return isset($this->getEnumsArray()[$key]);
    }

    /**
     * Get an attribute from the model.
     *
     * @param string $key
     * @return mixed
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function getAttribute($key)
    {
        if ($this->isEnumAttribute($key)) {
            return $this->getAttributeValue($key);
        }

        return parent::getAttribute($key);
    }

    /**
     * Get a plain attribute.
     *
     * @param string $key
     * @return mixed
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function getAttributeValue($key)
    {
        if ($this->isEnumAttribute($key)) {
            $class = $this->getEnumsArray()[$key];

            try {
                return $class::memberByValue($this->getAttributeFromArray($key));
            } catch (UndefinedMemberException $e) {
                return $class::defaultMember();
            }
        }

        return parent::getAttributeValue($key);
    }

    /**
     * Set a given attribute on the model.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function setAttribute($key, $value)
    {
        if ($this->isEnumAttribute($key)) {
            $class = $this->getEnumsArray()[$key];

            if (! $value instanceof $class) {
                $value = $class::memberByValue($value);
            }

            $this->attributes[$key] = $value->value();

            return $this;
        }

        parent::setAttribute($key, $value);
    }
}
