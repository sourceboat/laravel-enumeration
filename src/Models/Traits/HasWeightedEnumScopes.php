<?php

namespace Sourceboat\Enumeration\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Sourceboat\Enumeration\Enums\Interfaces\Weighted;

/**
 * weightedEnumScopes
 */
trait HasWeightedEnumScopes
{
    /**
     * Get all models with a column greater than that enum member.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $enumMember
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereGreaterThanEnum(Builder $query, string $column, Weighted $enumMember): Builder
    {
        return $query->whereIn($column, collect($enumMember->getMembersGreaterThanThis())->map->value());
    }

    /**
     * Get all models with a column greater than that enum member.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $enumMember
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereGreaterThanOrEqualToEnum(Builder $query, string $column, Weighted $enumMember): Builder
    {
        return $query->whereIn($column, collect($enumMember->getMembersGreaterThanOrEqualToThis())->map->value());
    }

    /**
     * Get all models with a column greater than that enum member.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $enumMember
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereEqualToEnum(Builder $query, string $column, Weighted $enumMember): Builder
    {
        return $query->whereIn($column, collect($enumMember->getMembersEqualToThis())->map->value());
    }

    /**
     * Get all models with a column greater than that enum member.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $enumMember
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereLessThanOrEqualToEnum(Builder $query, string $column, Weighted $enumMember): Builder
    {
        return $query->whereIn($column, collect($enumMember->getMembersLessThanOrEqualToThis())->map->value());
    }

    /**
     * Get all models with a column greater than that enum member.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $enumMember
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereLessThanEnum(Builder $query, string $column, Weighted $enumMember): Builder
    {
        return $query->whereIn($column, collect($enumMember->getMembersLessThanThis())->map->value());
    }

    /**
     * Get all models with a column between the enum members.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $lower
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $higher
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereBetweenEnum(Builder $query, string $column, Weighted $lower, Weighted $higher): Builder
    {
        return $query->whereIn($column, collect($lower->getMembersBetweenThisAnd($higher))->map->value());
    }

    /**
     * Get all models with a column between or equal to the enum members.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $lower
     * @param \Sourceboat\Enumeration\Enums\Interfaces\Weighted $higher
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereBetweenOrEqualToEnum(
        Builder $query,
        string $column,
        Weighted $lower,
        Weighted $higher
    ): Builder
    {
        return $query->whereIn($column, collect($lower->getMembersBetweenOrEqualToThisAnd($higher))->map->value());
    }
}
