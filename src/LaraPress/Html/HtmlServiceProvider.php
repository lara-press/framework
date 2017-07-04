<?php

namespace LaraPress\Html;

use Collective\Html\HtmlServiceProvider as BaseHtmlServiceProvider;

class HtmlServiceProvider extends BaseHtmlServiceProvider {

    /**
     * Register the form builder instance.
     *
     * @return void
     */
    protected function registerFormBuilder()
    {
        $this->app->singleton(
            'form',
            function ($app)
            {
                $form = new FormBuilder($app['html'], $app['url'], $app['view'], $app['session.store']->getToken());

                return $form->setSessionStore($app['session.store']);
            }
        );
        
        $this->app->alias('html', 'Collective\Html\HtmlBuilder');
        $this->app->alias('form', 'Collective\Html\FormBuilder');
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('html', 'form');
    }
}
