<?php

namespace LaraPress\Menus;

class MenuItem
{

    protected $children;
    protected $isActive;

    /**
     * @param \WP_Post $menuItem
     * @param array    $children
     * @param          $isActive
     */
    public function __construct(\WP_Post $menuItem, array $children = [], $isActive)
    {
        foreach ($menuItem->to_array() as $key => $value) {
            $this->{$key} = $value;
        }

        $this->children = $children;
        $this->isActive = $isActive;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function isActive()
    {
        return $this->isActive;
    }

    public function hasActiveDescendant()
    {
        $hasActiveDescendant = false;

        foreach ($this->getChildren() as $child) {
            if ($child->isActive()) {
                $hasActiveDescendant = true;
                break;
            } elseif (count($child->children) > 0) {
                $hasActiveDescendant = $child->hasActiveDescendant();
            }
        }

        return $hasActiveDescendant;
    }
}