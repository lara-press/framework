<?php

namespace LaraPress\Shortcodes;

use Illuminate\Support\ServiceProvider;
use LaraPress\Actions\Dispatcher;

class ShortcodeServiceProvider extends ServiceProvider
{
    protected $shortcodes = [];

    /**
     * Register any application services.
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        /** @var Dispatcher $action */
        $action = $this->app['actions'];

        $action->listen(
            'init',
            function () {
                foreach ($this->shortcodes as $shortcode) {

                    add_shortcode($shortcode, function ($attributes, $content = null) use ($shortcode) {

                        if ($this->hasRenderMethod($shortcode)) {
                            return $this->{$this->makeRenderMethodName($shortcode)}($attributes);
                        }

                        return view('shortcodes.' . $shortcode)->with([
                            'attributes' => $attributes,
                            'content'    => $content
                        ]);
                    });
                }
            }
        );
    }

    protected function hasRenderMethod($shortcode)
    {
        return method_exists($this, $this->makeRenderMethodName($shortcode));
    }

    protected function makeRenderMethodName($shortcode)
    {
        return camel_case($shortcode) . 'Shortcode';
    }
}
