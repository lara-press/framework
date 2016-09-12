<?php

namespace LaraPress\Widgets;

use Illuminate\Support\ServiceProvider;

class WidgetServiceProvider extends ServiceProvider {

    /**
     * An array of class names to be registered as WordPress widgets.
     *
     * @var array
     */
    protected $widgets = [];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['actions']->listen(
            'widgets_init',
            function ()
            {
                foreach ($this->widgets as $widget)
                {
                    if (class_exists($widget))
                    {
                        register_widget($widget);
                    }
                }
            }
        );
    }
}
