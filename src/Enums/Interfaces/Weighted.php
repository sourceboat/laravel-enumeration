<?php

namespace Sourceboat\Enumeration\Enums\Interfaces;

/**
 * Defines the interface for weighted enums.
 */
interface Weighted
{
    /**
     * Get members of this enum greater than $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array
     */
    public static function getMembersGreaterThan(Weighted $weighted): array;

    /**
     * Get members of this enum greater than or equal to $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array
     */
    public static function getMembersGreaterThanOrEqualTo(Weighted $weighted): array;

    /**
     * Get members of this enum equal to $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array
     */
    public static function getMembersEqualTo(Weighted $weighted): array;

    /**
     * Get members of this enum less than or equal to $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array
     */
    public static function getMembersLessThanOrEqualTo(Weighted $weighted): array;

    /**
     * Get members of this enum less than or equal to $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array
     */
    public static function getMembersLessThan(Weighted $weighted): array;

    /**
     * Get members of this enum greater than this.
     *
     * @return array
     */
    public function getMembersGreaterThanThis(): array;

    /**
     * Get members of this enum greater than or queal to this.
     *
     * @return array
     */
    public function getMembersGreaterThanOrEqualToThis(): array;

    /**
     * Get members of this enum equal to this.
     *
     * @return array
     */
    public function getMembersEqualToThis(): array;

    /**
     * Get members of this enum less than or equal to this.
     *
     * @return array
     */
    public function getMembersLessThanOrEqualToThis(): array;

    /**
     * Get members of this enum less than this.
     *
     * @return array
     */
    public function getMembersLessThanThis(): array;

    /**
     * The weight of this enum member.
     *
     * @return int|float
     */
    public function weight();

    /**
     * Determine if this members weight is greater than the given members weight.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $member
     * @return bool
     */
    public function isGreaterThan(Weighted $member): bool;

    /**
     * Determine if this members weight is greater or equal than the given members weight.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $member
     * @return bool
     */
    public function isGreaterThanOrEqualTo(Weighted $member): bool;

    /**
     * Determine if this members weight is equal to the given members weight.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $member
     * @return bool
     */
    public function isEqualTo(Weighted $member): bool;

    /**
     * Determine if this members weight is less than the given members weight.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $member
     * @return bool
     */
    public function isLessThan(Weighted $member): bool;

    /**
     * Determine if this members weight is less than or euqal to the given members weight.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $member
     * @return bool
     */
    public function isLessThanOrEqualTo(Weighted $member): bool;
}
