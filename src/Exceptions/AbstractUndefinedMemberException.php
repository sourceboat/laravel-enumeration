<?php

namespace Sourceboat\Enumeration\Exceptions;

use Exception;

/**
 * An abstract base class for implementing undefined member exceptions.
 *
 * Copyright © 2017 Erin Millard
 */
abstract class AbstractUndefinedMemberException extends Exception implements
    UndefinedMemberExceptionInterface
{
    private $className;

    private $property;

    private $value;

    /**
     * Construct a new undefined member exception.
     *
     * @param string $message The exception message.
     * @param string $className The name of the class from which the member was requested.
     * @param string $property The name of the property used to search for the member.
     * @param mixed $value The value of the property used to search for the member.
     * @param \Exception|null $cause The cause, if available.
     */
    public function __construct(string $message, string $className, string $property, $value, ?Exception $cause = null)
    {
        $this->className = $className;
        $this->property = $property;
        $this->value = $value;

        parent::__construct($message, 0, $cause);
    }

    /**
     * Get the class name.
     *
     * @return string The class name.
     */
    public function className(): string
    {
        return $this->className;
    }

    /**
     * Get the property name.
     *
     * @return string The property name.
     */
    public function property(): string
    {
        return $this->property;
    }

    /**
     * Get the value of the property used to search for the member.
     *
     * @return mixed The value.
     */
    public function value()
    {
        return $this->value;
    }
}
