<?php

namespace Sourceboat\Enumeration\Exceptions;

use Exception;

/**
 * The supplied member extends an already concrete base class.
 *
 * This exception exists to prevent otherwise valid inheritance structures
 * that are not valid in the context of enumerations.
 *
 * Copyright © 2017 Erin Millard
 *
 * @api
 */
final class ExtendsConcreteException extends Exception
{
    /**
     * @var string
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    private $className;

    /**
     * @var string
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    private $parentClass;

    /**
     * Construct a new extends concrete exception.
     *
     * @param string $className The class of the supplied member.
     * @param string $parentClass The concrete parent class name.
     * @param \Exception|null $cause The cause, if available.
     */
    public function __construct(string $className, string $parentClass, ?Exception $cause = null)
    {
        $this->className = $className;
        $this->parentClass = $parentClass;

        parent::__construct(
            sprintf(
                "Class '%s' cannot extend concrete class '%s'.",
                $this->className(),
                $this->parentClass(),
            ),
            0,
            $cause,
        );
    }

    /**
     * Get the class name of the supplied member.
     *
     * @return string The class name.
     */
    public function className(): string
    {
        return $this->className;
    }

    /**
     * Get the parent class name.
     *
     * @return string The parent class name.
     */
    public function parentClass(): string
    {
        return $this->parentClass;
    }
}
