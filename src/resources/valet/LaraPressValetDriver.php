<?php

class LaraPressValetDriver extends BasicValetDriver
{
    public function __construct()
    {
        $this->subdirectory = '/public';
    }

    public function serves($sitePath, $siteName, $uri)
    {
        return file_exists($sitePath . $this->subdirectory . "/wp-config.php");
    }

    public function isStaticFile($sitePath, $siteName, $uri)
    {
        $staticFilePath = $sitePath . $this->subdirectory . $uri;

        if (file_exists($staticFilePath) && ! is_dir($staticFilePath)) {
            return $staticFilePath;
        }

        return false;
    }

    public function frontControllerPath($sitePath, $siteName, $uri)
    {
        $_SERVER['PHP_SELF'] = $uri;
        $_SERVER['SERVER_ADDR'] = '127.0.0.1';
        $_SERVER['SERVER_NAME'] = $_SERVER['HTTP_HOST'];

        if(strpos($uri, '/wp-admin') === 0) {
            $uri = '/cms' . $uri;
        }

        return parent::frontControllerPath(
            $sitePath . $this->subdirectory, $siteName, $this->forceTrailingSlash($uri)
        );
    }

    private function forceTrailingSlash($uri)
    {
        if (substr($uri, -1 * strlen('/wp-admin')) == '/wp-admin') {
            header('Location: ' . $uri . '/');
            die;
        }

        return $uri;
    }
}
