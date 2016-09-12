<?php

namespace LaraPress\Contracts\Taxonomies;

interface CustomTaxonomy
{

    /**
     * Return an array of arguments that define the custom taxonomy, these
     * are the arguments that would normally be passed to register_taxonomy
     *
     * @see register_taxonomy
     * @return array
     */
    public function taxonomyData();

    /**
     * Return an array of post types that this taxonomy supports
     *
     * @see register_taxonomy
     * @return array
     */
    public function supportsPostTypes();
}
