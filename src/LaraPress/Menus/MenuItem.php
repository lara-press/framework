<?php

namespace LaraPress\Menus;

class MenuItem {

    /**
     * @param \WP_Post $menuItem
     * @param $children
     */
    function __construct(\WP_Post $menuItem, array $children = [])
    {
        foreach ($menuItem->to_array() as $key => $value) {
            $this->{$key} = $value;
        }
        $this->children = $children;
    }
}