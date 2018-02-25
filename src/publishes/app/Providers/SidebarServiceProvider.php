<?php

namespace App\Providers;

use App\Page as Post;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use LaraPress\Sidebars\SidebarServiceProvider as BaseSidebarServiceProvider;

class SidebarServiceProvider extends BaseSidebarServiceProvider
{
    use ValidatesRequests;

    /**
     * An array of sidebars to be loaded as Wordpress sidebars.
     *
     * @see \LaraPress\Sidebars\SidebarServiceProvider for proper structure
     * @var array
     */
    protected $sidebars = [
        [
            'name'        => 'Example sidebar',
            'description' => 'Just an example sidebar',
        ],
    ];

    public function register()
    {
        parent::register();

        $this->app['metabox']->create([
            'id'            => 'sidebar',
            'title'         => 'Sidebar',
            'context'       => 'side',
            'postType'      => 'project',
            'inputHandler'  => [$this, 'inputHandler'],
            'outputHandler' => [$this, 'outputHandler'],
        ]);
    }

    public function inputHandler(Post $post, Request $request)
    {
        $this->validate($request, [
            'sidebar' => 'in:' . implode(',', array_keys($this->getSidebarOptions())),
        ]);

        $post->setMeta('sidebar', $request->get('sidebar'));
    }

    /**
     * @param Post $post
     *
     * @return string
     */
    public function outputHandler($post)
    {
        return view('metabox.sidebar', [
            'sidebarOptions' => $this->getSidebarOptions(),
            'post'           => $post,
        ])->render();
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
}