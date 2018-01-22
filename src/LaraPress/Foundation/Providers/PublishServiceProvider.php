<?php

namespace LaraPress\Foundation\Providers;

use Illuminate\Support\ServiceProvider;

class PublishServiceProvider extends ServiceProvider
{

    private $publishesDirectory;

    public function boot()
    {
        $this->publishesDirectory = dirname(__DIR__, 3) . '/publishes';

        $optional = array_merge(
            $this->prepareFiles([
                'Events/Event.php',
                'Repositories/Repository.php',
                'Http/Controllers/AdminController.php',
                'Http/Requests/Request.php',
                'Providers/AdminPageServiceProvider.php',
                'Providers/MenuServiceProvider.php',
                'Providers/ShortcodeServiceProvider.php',
                'Providers/SidebarServiceProvider.php',
                'Providers/TaxonomyServiceProvider.php',
                'Providers/WidgetServiceProvider.php',
                'Widgets/ExampleWidget.php',
            ], 'app', 'app_path'),
            $this->prepareFiles([
                'views/metabox/sidebar.blade.php',
            ], 'resources', 'resource_path')
        );

        $base = array_merge(
            $this->prepareFiles([
                'Http/Kernel.php',
                'Http/Controllers/Controller.php',
                'Providers/PostTypeServiceProvider.php',
                'Page.php',
                'Post.php',
                'User.php',
            ], 'app', 'app_path'),
            $this->prepareFiles([
                'app.php',
                'mail.php',
                'images.php',
                'supports.php',
            ], 'config', 'config_path'),
            $this->prepareFiles([
                'wp-config.php',
                'content/mu-plugins/larapress.php',
                'content/themes/larapress/index.php',
                'content/themes/larapress/screenshot.png',
                'content/themes/larapress/style.css',
                'content/themes/larapress/assets/images/larapress.png',
            ], 'public', 'public_path'),
            $this->prepareFiles([
                'views/welcome.blade.php',
            ], 'resources', 'resource_path'), [
            $this->publishesDirectory . '/bootstrap/app.php'            => app_path('../bootstrap/app.php'),
            $this->publishesDirectory . '/routes/web.php'               => app_path('../routes/web.php'),
            $this->publishesDirectory . '/tests/CreatesApplication.php' => app_path('../tests/CreatesApplication.php'),
        ]);

        $this->publishes(array_merge($base, $optional), 'larapress');
    }

    private function prepareFiles($files, $projectFolder, $pathFunction)
    {
        $preparedFiles = [];

        foreach ($files as &$file) {
            $vendorFile = $this->publishesDirectory . '/' . $projectFolder . '/' . $file;
            $preparedFiles[$vendorFile] = $pathFunction($file);
        }

        return $preparedFiles;
    }
}
