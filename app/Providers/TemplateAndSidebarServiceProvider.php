<?php

namespace App\Providers;

use App\Page as Post;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\FileViewFinder;

class TemplateAndSidebarServiceProvider extends ServiceProvider
{

    use ValidatesRequests;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['metabox']->create(
            [
                'id'            => 'template_sidebar',
                'title'         => 'Template & Sidebar',
                'context'       => 'side',
                'postType'      => 'page',
                'inputHandler'  => [$this, 'metaBoxInput'],
                'outputHandler' => [$this, 'metaBoxOutput']
            ]
        );
    }

    public function metaBoxInput(Post $post, Request $request)
    {
        $this->validate(
            $request,
            [
                'template' => 'in:' . implode(',', array_keys($this->getTemplateOptions())),
                'sidebar'  => 'in:' . implode(',', array_keys($this->getSidebarOptions()))
            ]
        );

        $post->setMeta('template', $request->get('template'));
        $post->setMeta('sidebar', $request->get('sidebar'));
    }

    protected function getTemplateOptions()
    {
        /** @var FileViewFinder $viewFinder */
        $viewFinder = $this->app['view.finder'];

        $templates = [];
        foreach ($viewFinder->getPaths() as $path) {
            $possibleTemplates = $viewFinder->getFilesystem()->files($path . '/templates');

            foreach ($possibleTemplates as $template) {
                $templates[basename($template, '.blade.php')] =
                    ucwords(str_replace('-', ' ', basename($template, '.blade.php')));
            }
        }

        return $templates;
    }

    protected function getSidebarOptions()
    {
        global $wp_registered_sidebars;

        $sidebars = [];
        foreach ($wp_registered_sidebars as $sidebarId => $sidebar) {
            $sidebars[$sidebarId] = $sidebar['name'];
        }

        return $sidebars;
    }

    public function metaBoxOutput(Post $post)
    {
        return view(
            'metabox.template-sidebar',
            [
                'templateOptions' => $this->getTemplateOptions(),
                'sidebarOptions'  => $this->getSidebarOptions(),
                'post'            => $post
            ]
        );
    }
}
