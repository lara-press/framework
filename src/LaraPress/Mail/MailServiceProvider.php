<?php namespace LaraPress\Mail;

use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (config('mail.override_wordpress', false))
        {
            //include(__DIR__ . '/wp_mail.php');
        }
    }
}