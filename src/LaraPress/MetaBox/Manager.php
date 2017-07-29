<?php

namespace LaraPress\MetaBox;

use Illuminate\Contracts\Foundation\Application;
use LaraPress\Actions\Dispatcher;
use LaraPress\Posts\Post;

class Manager
{

    /** @var MetaBox[] */
    protected static $registeredMetaBoxes;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Dispatcher
     */
    protected $actions;

    public function __construct(Application $app, Dispatcher $actions)
    {
        $this->app = $app;
        $this->actions = $actions;
    }

    public function create(array $attributes = [])
    {
        return self::$registeredMetaBoxes[] = $this->register($this->newMetaBox($attributes));
    }

    /**
     * @param array $params
     *
     * @return MetaBox
     */
    public function newMetaBox(array $params = [])
    {
        return $this->app->makeWith(MetaBox::class, $params);
    }

    public function register(MetaBox $metaBox)
    {
        $app = $this->app;

        $this->actions->listen('add_meta_boxes', function () use ($metaBox, $app) {
            add_meta_box(
                $metaBox->getId(),
                $metaBox->getTitle(),
                function () use ($app, $metaBox) {
                    $post = Post::resolveWordPressPostToModel(get_post());
                    echo $app->call($metaBox->getOutputHandler(), ['post' => $post] + func_get_args());
                },
                $metaBox->getPostType(),
                $metaBox->getContext(),
                $metaBox->getPriority()
            );
        });

        if (is_callable($metaBox->getInputHandler())) {
            $this->actions->listen('save_post', function ($postId, $post, $isUpdate) use ($metaBox, $app) {
                if ($post->post_type !== $metaBox->getPostType() || defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                    return;
                }
                $post = Post::resolveWordPressPostToModel($post);
                $app->call($metaBox->getInputHandler(), compact('metaBox', 'postId', 'post', 'isUpdate'));
            }, $metaBox->getPriority(), 3);
        }

        return $metaBox;
    }
}
