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
                'Events/Event.stub',
                'Repositories/Repository.stub',
                'Repositories/PostRepository.stub',
                'Http/Controllers/AdminController.stub',
                'Http/Requests/Request.stub',
                'Providers/AdminPageServiceProvider.stub',
                'Providers/MenuServiceProvider.stub',
                'Providers/ShortcodeServiceProvider.stub',
                'Providers/SidebarServiceProvider.stub',
                'Providers/TaxonomyServiceProvider.stub',
                'Providers/ViewServiceProvider.stub',
                'Providers/WidgetServiceProvider.stub',
                'Widgets/ExampleWidget.stub',
            ], 'app', 'app_path'),
            $this->prepareFiles([
                'views/metabox/sidebar.blade.stub',
            ], 'resources', 'resource_path')
        );

        $base = array_merge(
            $this->prepareFiles([
                'Http/Kernel.stub',
                'Http/Controllers/Controller.stub',
                'Http/Controllers/PostController.stub',
                'Http/Controllers/PageController.stub',
                'Http/Controllers/Controller.stub',
                'Providers/PostTypeServiceProvider.stub',
                'Page.stub',
                'Post.stub',
                'User.stub',
            ], 'app', 'app_path'),
            $this->prepareFiles([
                'app.stub',
                'mail.stub',
                'images.stub',
                'supports.stub',
            ], 'config', 'config_path'),
            $this->prepareFiles([
                'wp-config.php',
                'index.php',
                'content/mu-plugins/larapress.php',
                'content/plugins/.gitkeep',
                'content/themes/larapress/index.php',
                'content/themes/larapress/screenshot.png',
                'content/themes/larapress/style.css',
                'content/themes/larapress/assets/images/larapress.png',
            ], 'public', 'public_path'),
            $this->prepareFiles([
                'views/metabox/sidebar.blade.stub',
                'views/welcome.blade.stub',
            ], 'resources', 'resource_path'), [
            $this->publishesDirectory . '/.gitignore'         => base_path('.gitignore'),
            $this->publishesDirectory . '/artisan'            => base_path('artisan'),
            $this->publishesDirectory . '/bootstrap/app.stub' => base_path('bootstrap/app.php'),
            $this->publishesDirectory . '/routes/web.stub'    => base_path('routes/web.php'),
            $this->publishesDirectory . '/laravel-tests/CreatesApplication.stub'
                                                              => base_path('tests/CreatesApplication.php'),
        ]);

        $this->publishes(array_merge($base, $optional), 'larapress');
    }

    private function prepareFiles($files, $projectFolder, $pathFunction)
    {
        $preparedFiles = [];

        foreach ($files as &$file) {
            $vendorFile = $this->publishesDirectory . '/' . $projectFolder . '/' . $file;
            $preparedFiles[$vendorFile] = str_replace('.stub', '.php', $pathFunction($file));
        }

        return $preparedFiles;
    }
}
