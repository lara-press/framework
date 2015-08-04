<?php namespace LaraPress\Posts;

class Query extends \WP_Query
{
    /**
     * @param \WP_Query $query
     *
     * @return static
     */
    public static function newInstanceFromWordpressQuery(\WP_Query $query)
    {
        $newQuery = new static;

        foreach (get_object_vars($query) as $property => $value)
        {
            $newQuery->$property = $value;
        }

        return $newQuery;
    }
}
