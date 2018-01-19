<?php

namespace LaraPress\Contracts\Posts;

interface CustomPostType {

    /**
     * Return an array of arguments that define the custom post type, these
     * are the arguments that would normally be passed to register_post_type
     *
     * @see register_post_type
     * @return array
     */
    public static function customPostTypeData();
}
