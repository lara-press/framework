<?php

namespace App\Providers;

use Illuminate\Contracts\View\Factory;
use LaraPress\Posts\Page;
use LaraPress\Posts\Post as Post;
use LaraPress\View\ViewServiceProvider as BaseViewServiceProvider;

class ViewServiceProvider extends BaseViewServiceProvider
{

    public function register()
    {
        parent::register();

        /** @var Factory $view */
        $view = $this->app['view'];

        actions()->listen('wp', function () use ($view) {

            if (app()->isShared('post')) {

                /** @var Post $post */
                $view->share('__post', $post = app('post'));

                if ($post instanceof Page) {
                    $view->share([
                        '__template' => $post->getMeta('template'),
                        '__sidebar'  => $post->getMeta('sidebar'),
                    ]);
                }
            }
        });

        filters()->listen('wp_title_parts', function ($titleParts) {
            return is_404() ? [trans('page-titles.' . $this->app['router']->currentRouteName())] : $titleParts;
        });
    }
}
