<?php

namespace App;

use LaraPress\Contracts\Posts\CustomPostType;

class Event extends Post implements CustomPostType
{
    /**
     * Return an array of arguments that define the custom post type, these
     * are the arguments that would normally be passed to register_post_type
     *
     * @see register_post_type
     * @return array
     */
    public function customPostTypeData()
    {
        return [
            'supports' => array('title', 'editor', 'thumbnail',),
            'taxonomies' => [],
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 25,
            'menu_icon' => 'dashicons-calendar',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'map_meta_cap' => true,
        ];
    }
}
