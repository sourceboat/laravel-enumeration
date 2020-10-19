<?php

namespace Sourceboat\Enumeration\Enums\Interfaces;

/**
 * Defines the interface for weighted enums.
 */
interface Weighted
{
    /**
     * Get members of this enum greater than this.
     *
     * @return array<static>
     */
    public function getMembersGreaterThanThis(): array;

    /**
     * Get members of this enum greater than or queal to this.
     *
     * @return array<static>
     */
    public function getMembersGreaterThanOrEqualToThis(): array;

    /**
     * Get members of this enum equal to this.
     *
     * @return array<static>
     */
    public function getMembersEqualToThis(): array;

    /**
     * Get members of this enum less than or equal to this.
     *
     * @return array<static>
     */
    public function getMembersLessThanOrEqualToThis(): array;

    /**
     * Get members of this enum less than this.
     *
     * @return array<static>
     */
    public function getMembersLessThanThis(): array;

    /**
     * Get members of this enum between this and the given higher bound.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $higher
     * @return array<static>
     */
    public function getMembersBetweenThisAnd(Weighted $higher): array;

    /**
     * Get members of this enum between or equal to this and the given higher bound.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $higher
     * @return array<static>
     */
    public function getMembersBetweenOrEqualToThisAnd(Weighted $higher): array;

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

    /**
     * Determine if this members weight is between the given members weight.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $lower
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $higher
     * @return bool
     */
    public function isBetween(Weighted $lower, Weighted $higher): bool;

    /**
     * Determine if this members weight is between or equal to the given members weight.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $lower
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $higher
     * @return bool
     */
    public function isBetweenOrEqualTo(Weighted $lower, Weighted $higher): bool;

    /**
     * Get members of this enum greater than $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array<static>
     */
    public static function getMembersGreaterThan(Weighted $weighted): array;

    /**
     * Get members of this enum greater than or equal to $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array<static>
     */
    public static function getMembersGreaterThanOrEqualTo(Weighted $weighted): array;

    /**
     * Get members of this enum equal to $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array<static>
     */
    public static function getMembersEqualTo(Weighted $weighted): array;

    /**
     * Get members of this enum less than or equal to $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array<static>
     */
    public static function getMembersLessThanOrEqualTo(Weighted $weighted): array;

    /**
     * Get members of this enum less than or equal to $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array<static>
     */
    public static function getMembersLessThan(Weighted $weighted): array;

    /**
     * Get members of this enum between the given members weights.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $lower
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $higher
     * @return array<static>
     */
    public static function getMembersBetween(Weighted $lower, Weighted $higher): array;

    /**
     * Get members of this enum between or equal to the given members weights.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $lower
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $higher
     * @return array<static>
     */
    public static function getMembersBetweenOrEqualTo(Weighted $lower, Weighted $higher): array;
}
