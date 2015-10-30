<?php

namespace LaraPress\Posts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\ScopeInterface;

class PostTypeScope implements ScopeInterface {

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  Eloquent                              $model
     *
     * @return void
     */
    public function apply(Builder $builder, Eloquent $model)
    {
        $builder->where('post_type', strtolower(snake_case(class_basename($model))));
    }

    /**
     * Remove the scope from the given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  Eloquent                              $model
     *
     * @return void
     */
    public function remove(Builder $builder, Eloquent $model)
    {
        $query = $builder->getQuery();

        foreach ((array)$query->wheres as $key => $where)
        {
            // If the where clause is a soft delete date constraint, we will remove it from
            // the query and reset the keys on the wheres. This allows this developer to
            // include deleted model in a relationship result set that is lazy loaded.
            if ($this->isPostTypeConstraint($where, 'post_type'))
            {
                unset($query->wheres[$key]);

                $query->wheres = array_values($query->wheres);
            }
        }
    }

    /**
     * Determine if the given where clause is a soft delete constraint.
     *
     * @param  array  $where
     * @param  string $column
     *
     * @return bool
     */
    protected function isPostTypeConstraint(array $where, $column)
    {
        return $where['type'] == 'Null' && $where['column'] == $column;
    }
}
