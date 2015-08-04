<?php namespace LaraPress\Assets;

use Illuminate\Filesystem\Filesystem;
use LaraPress\Actions\Dispatcher;

class Manager {

    const FRONT = 'front';
    const ADMIN = 'admin';
    const LOGIN = 'login';

    const TYPE_SCRIPT = 'script';
    const TYPE_STYLE  = 'style';

    /**
     * @var Dispatcher
     */
    protected $actions;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    public function __construct(Dispatcher $actions, Filesystem $filesystem)
    {
        $this->actions = $actions;
        $this->filesystem = $filesystem;
    }

    public function enqueueScript(
        $handle,
        $path,
        $dependencies = [],
        $version = 0,
        $footer = false,
        $area = self::FRONT
    ) {
        $this->enqueue($handle, $path, $dependencies, $version, $footer, $area, self::TYPE_SCRIPT);
    }

    public function enqueueStyle(
        $handle,
        $path,
        $dependencies = [],
        $version = 0,
        $footer = false,
        $area = self::FRONT
    ) {
        $this->enqueue($handle, $path, $dependencies, $version, $footer, $area, self::TYPE_STYLE);
    }

    public function enqueue(
        $handle,
        $path,
        $dependencies = [],
        $version = 0,
        $footer = false,
        $area = self::FRONT,
        $type = null
    ) {
        if (empty($type) && $this->filesystem->exists($path))
        {
            $extension = $this->filesystem->extension($path);
            $type      = $extension == 'css' ? 'style' : 'script';
        }

        $path = str_replace(public_path(), '', $path);

        $this->add($handle, $path, $dependencies, $version, $footer, $area, $type);
    }

    protected function add($handle, $path, $dependencies, $version, $footer, $area, $type)
    {
        switch ($area)
        {
            case self::ADMIN :
                $hook = 'admin_enqueue_scripts';
                break;
            case self::LOGIN;
                $hook = 'login_enqueue_scripts';
                break;
            default :
                $hook = 'wp_enqueue_scripts';
        }

        $method = 'enqueue' . ucfirst($type);

        if ( ! method_exists($this, $method))
        {
            throw new \Exception('Invalid asset type given');
        }

        $this->actions->listen(
            $hook,
            function () use ($handle, $path, $dependencies, $version, $footer, $area, $type)
            {
                switch ($type)
                {
                    case self::TYPE_SCRIPT :
                        wp_enqueue_script($handle, $path, $dependencies, $version, $footer, $area);
                        break;

                    case self::TYPE_STYLE:
                        wp_enqueue_style($handle, $path, $dependencies, $version, $footer, $area);
                        break;
                }
            }
        );
    }
}
