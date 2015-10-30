<?php

namespace LaraPress\Routing;

use Illuminate\Http\Request;
use Illuminate\Routing\Matching\HostValidator;
use Illuminate\Routing\Matching\MethodValidator;
use Illuminate\Routing\Matching\SchemeValidator;
use Illuminate\Routing\Matching\UriValidator;
use Illuminate\Routing\Route as RouteBase;
use LaraPress\Routing\Matching\ConditionalValidator;

class Route extends RouteBase {

    protected $wordpressConditional;

    /**
     * WordPress conditional tags.
     *
     * @var array
     */
    protected $conditions = [
        '404'             => 'is_404',
        'archive'         => 'is_archive',
        'attachment'      => 'is_attachment',
        'author'          => 'is_author',
        'category'        => 'is_category',
        'date'            => 'is_date',
        'day'             => 'is_day',
        'front'           => 'is_front_page',
        'home'            => 'is_home',
        'month'           => 'is_month',
        'page'            => 'is_page',
        'paged'           => 'is_paged',
        'postTypeArchive' => 'is_post_type_archive',
        'search'          => 'is_search',
        'subpage'         => 'larapress_is_subpage',
        'single'          => 'is_single',
        'sticky'          => 'is_sticky',
        'singular'        => 'is_singular',
        'tag'             => 'is_tag',
        'tax'             => 'is_tax',
        'template'        => 'larapress_is_template',
        'time'            => 'is_time',
        'year'            => 'is_year'
    ];

    /**
     * Determine if the route matches given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  bool                     $includingMethod
     *
     * @return bool
     */
    public function matches(Request $request, $includingMethod = true)
    {
        $this->compileRoute();

        foreach ($this->getValidators() as $validator)
        {
            if ( ! $includingMethod && $validator instanceof MethodValidator)
            {
                continue;
            }

            if ( ! $validator->matches($this, $request))
            {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the route validators for the instance.
     *
     * @return array
     */
    public static function getValidators()
    {
        if (isset(static::$validators))
        {
            return static::$validators;
        }

        // To match the route, we will use a chain of responsibility pattern with the
        // validator implementations. We will spin through each one making sure it
        // passes and then we will know if the route as a whole matches request.
        return static::$validators = [
            new MethodValidator,
            new ConditionalValidator,
            new SchemeValidator,
            new HostValidator,
            new UriValidator,
        ];
    }

    public function setWordPressConditional($conditional)
    {
        $this->wordpressConditional = $conditional;
    }

    public function wordpressConditional()
    {
        return $this->wordpressConditional;
    }
}
