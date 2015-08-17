<?php namespace LaraPress\MetaBox;

use Illuminate\Contracts\Foundation\Application;
use LaraPress\Actions\Dispatcher;
use LaraPress\Posts\Post;

class Manager {

    /** @var MetaBox[] */
    protected static $registeredMetaBoxes;

    /**
     * @var Application
     */
    protected $container;

    /**
     * @var Dispatcher
     */
    protected $actions;

    public function __construct(Application $container, Dispatcher $actions)
    {
        $this->container = $container;
        $this->actions   = $actions;
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
        return $this->container->make('LaraPress\MetaBox\MetaBox', $params);
    }

    public function register(MetaBox $metaBox)
    {
        $container = $this->container;

        $this->actions->listen(
            'add_meta_boxes',
            function () use ($metaBox, $container)
            {
                add_meta_box(
                    $metaBox->getId(),
                    $metaBox->getTitle(),
                    function () use ($container, $metaBox)
                    {
                        $post = Post::resolveWordPressPostToModel(get_post());
                        echo $container->call($metaBox->getOutputHandler(), ['post' => $post] + func_get_args());
                    },
                    $metaBox->getPostType(),
                    $metaBox->getContext(),
                    $metaBox->getPriority()
                );
            }
        );

        if (is_callable($metaBox->getInputHandler()))
        {
            $this->actions->listen(
                'save_post_page',
                function ($postId, $post, $isUpdate) use ($metaBox, $container)
                {
                    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
                    {
                        return;
                    }

                    $post = Post::resolveWordPressPostToModel($post);

                    $container->call($metaBox->getInputHandler(), compact('metaBox', 'postId', 'post', 'isUpdate'));
                },
                $metaBox->getPriority(),
                3
            );
        }

        return $metaBox;
    }
}
