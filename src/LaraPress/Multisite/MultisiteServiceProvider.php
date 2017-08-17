<?php

namespace LaraPress\Multisite;

use Illuminate\Support\ServiceProvider;

class MultisiteServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // adjust network url to reflect proper location
        filters()->listen('network_admin_url', function ($url) {
            return str_replace('/wp-admin', '/cms/wp-admin', $url);
        });

        // adjust site url to reflect proper location
        filters()->listen('wpmu_new_blog', function ($blog_id) {
            $siteUrl = get_blog_option($blog_id, 'siteurl');
            update_blog_option($blog_id, 'siteurl', $siteUrl . '/cms');
        });
    }
}