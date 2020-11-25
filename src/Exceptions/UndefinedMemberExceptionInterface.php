<?php

namespace Sourceboat\Enumeration\Exceptions;

/**
 * The interface implemented by exceptions that are thrown when an undefined
 * member is requested.
 *
 * Copyright © 2017 Erin Millard
 *
 * @api
 */
interface UndefinedMemberExceptionInterface
{
    /**
     * Get the class name.
     *
     * @api
     * @return string The class name.
     */
    public function className(): string;

    /**
     * Get the property name.
     *
     * @api
     * @return string The property name.
     */
    public function property(): string;

    /**
     * Get the value of the property used to search for the member.
     *
     * @api
     * @return mixed The value.
     */
    public function value();
}
