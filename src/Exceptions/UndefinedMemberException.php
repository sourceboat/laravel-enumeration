<?php

namespace Sourceboat\Enumeration\Exceptions;

use Exception;

/**
 * The requested member was not found.
 *
 * Copyright © 2017 Erin Millard
 */
final class UndefinedMemberException extends AbstractUndefinedMemberException
{
    /**
     * Construct a new undefined member exception.
     *
     * @param string $className The name of the class from which the member was requested.
     * @param string $property The name of the property used to search for the member.
     * @param mixed $value The value of the property used to search for the member.
     * @param \Exception|null $cause The cause, if available.
     */
    public function __construct(string $className, string $property, $value, ?Exception $cause = null)
    {
        parent::__construct(
            sprintf(
                'No member with %s equal to %s defined in class %s.',
                $property,
                var_export($value, true),
                var_export($className, true),
            ),
            $className,
            $property,
            $value,
            $cause,
        );
    }
}
