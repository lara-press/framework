<?php

namespace LaraPress\Menus;

use Illuminate\Support\Arr;

class MenuBuilder
{

    protected $menuItems;
    protected $activePostId = false;

    /**
     * @param $menuId
     * @return MenuItem[]
     */
    public function find($menuId)
    {
        if (app()->isShared('post')) {
            $this->activePostId = app('post')->ID;
        }

        $this->menuItems = $this->getMenuItems($menuId);

        return $this->transformMenu($this->getTopLevelMenuItems());
    }

    protected function transformMenu($menuItems)
    {
        return array_map(function ($menuItem) {
            return new MenuItem($menuItem, $this->transformMenu(
                $this->getChildMenuItems($menuItem->ID)
            ), request()->url() . '/' === $menuItem->url);
        }, $menuItems);
    }

    protected function getTopLevelMenuItems()
    {
        return Arr::where($this->menuItems, function ($menuItem) {
            return !$menuItem->menu_item_parent;
        });
    }

    protected function getChildMenuItems($parentId)
    {
        return Arr::where($this->menuItems, function ($menuItem) use ($parentId) {
            return intval($menuItem->menu_item_parent) === $parentId;
        });
    }

    protected function getMenuItems($menuId)
    {
        $menuLocations = get_nav_menu_locations();

        if (!Arr::has($menuLocations, $menuId)) {
            return []; // id must be registered and then assigned a menu in WordPress.
        }

        return wp_get_nav_menu_items($menuLocations[$menuId]) ?: [];
    }
}
