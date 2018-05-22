<?php

namespace LaraPress\Shortcodes;

use Illuminate\Support\ServiceProvider;
use LaraPress\Actions\Dispatcher;

class ShortcodeServiceProvider extends ServiceProvider
{
    protected $shortcodes = [];

    protected $dynamicShortcodes = [];

    public function register()
    {
        actions()->listen('init', function () {
            foreach ($this->shortcodes as $shortcode) {
                $this->registerShortcodes($shortcode);
            }
            foreach ($this->dynamicShortcodes as $dynamicShortcode) {
                $this->registerDynamicShortcodes(app($dynamicShortcode));
            }
        });
    }

    protected function registerShortcodes($shortcode)
    {
        add_shortcode($shortcode, function ($attributes, $content = null) use ($shortcode) {
            if ($this->hasRenderMethod($shortcode)) {
                return $this->{$this->makeRenderMethodName($shortcode)}($attributes);
            }

            $view = 'shortcodes.' . $shortcode;

            if (view()->exists($view)) {
                view($view)->with([
                    'attributes' => $attributes,
                    'content'    => $content,
                ]);
            }

            return '[' . $shortcode . ']';
        });
    }

    protected function registerDynamicShortcodes(DynamicShortcode $dynamicShortcode)
    {
        foreach ($dynamicShortcode->shortcodes() as $shortcode) {
            add_shortcode($shortcode, function ($attributes, $content = null) use ($dynamicShortcode, $shortcode) {
                return $dynamicShortcode->render($shortcode, $attributes, $content);
            });
        }
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
