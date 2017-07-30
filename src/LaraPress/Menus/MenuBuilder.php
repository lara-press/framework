<?php

namespace LaraPress\Menus;

class MenuBuilder
{

    protected $menuItems;
    protected $activePostId = false;

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
            ), $this->activePostId == $menuItem->object_id);
        }, $menuItems);
    }

    protected function getTopLevelMenuItems()
    {
        return array_where($this->menuItems, function ($menuItem) {
            return ! $menuItem->menu_item_parent;
        });
    }

    protected function getChildMenuItems($parentId)
    {
        return array_where($this->menuItems, function ($menuItem) use ($parentId) {
            return intval($menuItem->menu_item_parent) === $parentId;
        });
    }

    protected function getMenuItems($menuId)
    {
        $menuLocations = get_nav_menu_locations();

        if ( ! array_has($menuLocations, $menuId)) {
            abort(500, '"' . $menuId . '" must be registered and then assigned a menu in WordPress.');
        }

        return wp_get_nav_menu_items($menuLocations[$menuId]);
    }
}
