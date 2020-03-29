<?php

namespace Sourceboat\Enumeration\Enums\Traits;

use Sourceboat\Enumeration\Enums\Interfaces\Weighted;

/**
 * Functionality to compare enum members by weight.
 *
 * Implements the weighted interface.
 */
trait IsWeighted
{
    /**
     * Get the config key for the weights of this enum.
     *
     * @return string
     */
    public static function getWeightOptionsKey(): string
    {
        return sprintf('enums.%s.weights', static::class);
    }

    /**
     * Get members of this enum greater than $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array<static>
     */
    public static function getMembersGreaterThan(Weighted $weighted): array
    {
        return static::membersByPredicate(static function (Weighted $member) use ($weighted): bool {
            return $member->isGreaterThan($weighted);
        });
    }

    /**
     * Get members of this enum greater than or equal to $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array<static>
     */
    public static function getMembersGreaterThanOrEqualTo(Weighted $weighted): array
    {
        return static::membersByPredicate(static function (Weighted $member) use ($weighted): bool {
            return $member->isGreaterThanOrEqualTo($weighted);
        });
    }

    /**
     * Get members of this enum between the given members weights.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $lower
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $higher
     * @return array<static>
     */
    public static function getMembersBetween(Weighted $lower, Weighted $higher): array
    {
        return static::membersByPredicate(static function (Weighted $member) use ($lower, $higher): bool {
            return $member->isBetween($lower, $higher);
        });
    }

    /**
     * Get members of this enum between or equal to the given members weights.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $lower
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $higher
     * @return array<static>
     */
    public static function getMembersBetweenOrEqualTo(Weighted $lower, Weighted $higher): array
    {
        return static::membersByPredicate(static function (Weighted $member) use ($lower, $higher): bool {
            return $member->isBetweenOrEqualTo($lower, $higher);
        });
    }

    /**
     * Get members of this enum equal to $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array<static>
     */
    public static function getMembersEqualTo(Weighted $weighted): array
    {
        return static::membersByPredicate(static function (Weighted $member) use ($weighted): bool {
            return $member->isEqualTo($weighted);
        });
    }

    /**
     * Get members of this enum less than or equal to $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array<static>
     */
    public static function getMembersLessThanOrEqualTo(Weighted $weighted): array
    {
        return static::membersByPredicate(static function (Weighted $member) use ($weighted): bool {
            return $member->isLessThanOrEqualTo($weighted);
        });
    }

    /**
     * Get members of this enum less than $weighted.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return array<static>
     */
    public static function getMembersLessThan(Weighted $weighted): array
    {
        return static::membersByPredicate(static function (Weighted $member) use ($weighted): bool {
            return $member->isLessThan($weighted);
        });
    }

    /**
     * Get members of this enum greater than this.
     *
     * @return array<static>
     */
    public function getMembersGreaterThanThis(): array
    {
        return static::getMembersGreaterThan($this);
    }

    /**
     * Get members of this enum greater than or equal to this.
     *
     * @return array<static>
     */
    public function getMembersGreaterThanOrEqualToThis(): array
    {
        return static::getMembersGreaterThanOrEqualTo($this);
    }

    /**
     * Get members of this enum greater than or equal to this.
     *
     * @return array<static>
     */
    public function getMembersEqualToThis(): array
    {
        return static::getMembersEqualTo($this);
    }

    /**
     * Get members of this enum greater than or equal to this.
     *
     * @return array<static>
     */
    public function getMembersLessThanOrEqualToThis(): array
    {
        return static::getMembersLessThanOrEqualTo($this);
    }

    /**
     * Get members of this enum greater than or equal to this.
     *
     * @return array<static>
     */
    public function getMembersLessThanThis(): array
    {
        return static::getMembersLessThan($this);
    }


    /**
     * Get members of this enum between this and the given higher bound.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $higher
     * @return array<static>
     */
    public function getMembersBetweenThisAnd(Weighted $higher): array
    {
        return static::getMembersBetween($this, $higher);
    }

    /**
     * Get members of this enum between or equal to this and the given higher bound.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $higher
     * @return array<static>
     */
    public function getMembersBetweenOrEqualToThisAnd(Weighted $higher): array
    {
        return static::getMembersBetweenOrEqualTo($this, $higher);
    }


    /**
     * Get the weight of this member.
     *
     * @var \Sourceboat\Enumeration\Enums\Interfaces\Weighted $this
     * @return int|float
     */
    public function weight()
    {
        return config(sprintf('%s.%s', static::getWeightOptionsKey(), $this->value()));
    }

    /**
     * Determine if this members weight is greater than the given members weight.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return bool
     */
    public function isGreaterThan(Weighted $weighted): bool
    {
        return $this->weight() > $weighted->weight();
    }

    /**
     * Determine if this members weight is greater or equal than the given members weight.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return bool
     */
    public function isGreaterThanOrEqualTo(Weighted $weighted): bool
    {
        return $this->weight() >= $weighted->weight();
    }

    /**
     * Determine if this members weight is equal to the given members weight.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return bool
     */
    public function isEqualTo(Weighted $weighted): bool
    {
        return $this->weight() === $weighted->weight();
    }

    /**
     * Determine if this members weight is less than the given members weight.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return bool
     */
    public function isLessThan(Weighted $weighted): bool
    {
        return $this->weight() < $weighted->weight();
    }

    /**
     * Determine if this members weight is less than or euqal to the given members weight.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $weighted
     * @return bool
     */
    public function isLessThanOrEqualTo(Weighted $weighted): bool
    {
        return $this->weight() <= $weighted->weight();
    }

    /**
     * Determine if this members weight is between the given members weight.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $lower
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $higher
     * @return bool
     */
    public function isBetween(Weighted $lower, Weighted $higher): bool
    {
        return $this->weight() > $lower->weight()
            && $this->weight() < $higher->weight();
    }

    /**
     * Determine if this members weight is between or equal to the given members weight.
     *
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $lower
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $higher
     * @return bool
     */
    public function isBetweenOrEqualTo(Weighted $lower, Weighted $higher): bool
    {
        return $this->weight() >= $lower->weight()
            && $this->weight() <= $higher->weight();
    }
}
