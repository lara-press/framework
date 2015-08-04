<?php namespace LaraPress\MetaBox;

use Closure;

class MetaBox {

    /** @var string */
    protected $id;

    /** @var string */
    protected $title;

    /** @var string */
    private   $postType;

    /** @var string */
    protected $context;

    /** @var string */
    protected $priority;

    /** @var Closure */
    protected $outputHandler;

    /** @var Closure */
    protected $inputHandler;

    public function __construct(
        $id,
        $title,
        $outputHandler = null,
        $inputHandler = null,
        $postType = null,
        $context = 'advanced',
        $priority = 'default'
    ) {
        $this->setId($id);
        $this->setTitle($title);
        $this->setOutputHandler($outputHandler);
        $this->setInputHandler($inputHandler);
        $this->setContext($context);
        $this->setPriority($priority);
        $this->setPostType($postType);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param string $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return callable
     */
    public function getOutputHandler()
    {
        return $this->outputHandler;
    }

    /**
     * @param callable $outputHandler
     */
    public function setOutputHandler($outputHandler)
    {
        $this->outputHandler = $this->makeListener($outputHandler);
    }

    /**
     * Register an event listener with the dispatcher.
     *
     * @param  mixed $listener
     *
     * @return mixed
     */
    public function makeListener($listener)
    {
        return is_string($listener) ? $this->createClassListener($listener) : $listener;
    }

    /**
     * Create a class based listener using the IoC container.
     *
     * @param  mixed $listener
     *
     * @return \Closure
     */
    public function createClassListener($listener)
    {
        $container = $this->container;

        return function () use ($listener, $container)
        {
            return call_user_func_array(
                $this->createClassCallable($listener, $container),
                func_get_args()
            );
        };
    }

    /**
     * @return callable
     */
    public function getInputHandler()
    {
        return $this->inputHandler;
    }

    /**
     * @param callable $inputHandler
     */
    public function setInputHandler($inputHandler)
    {
        $this->inputHandler = $this->makeListener($inputHandler);
    }

    /**
     * @return mixed
     */
    public function getPostType()
    {
        return $this->postType;
    }

    /**
     * @param mixed $postType
     */
    public function setPostType($postType)
    {
        $this->postType = $postType;
    }

    /**
     * Create the class based event callable.
     *
     * @param  string                          $listener
     * @param  \Illuminate\Container\Container $container
     *
     * @return callable
     */
    protected function createClassCallable($listener, $container)
    {
        list($class, $method) = $this->parseClassCallable($listener);

        return [$container->make($class), $method];
    }

    /**
     * Parse the class listener into class and method.
     *
     * @param  string $listener
     *
     * @return array
     */
    protected function parseClassCallable($listener)
    {
        $segments = explode('@', $listener);

        return [$segments[0], count($segments) == 2 ? $segments[1] : 'handle'];
    }
}
