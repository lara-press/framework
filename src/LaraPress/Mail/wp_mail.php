<?php

use LaraPress\Mail\WpMail;

if ( ! function_exists('wp_mail')) {
    function wp_mail($to, $subject, $message, $headers = '', $attachments = [])
    {
        /** @var \Illuminate\Mail\Mailer $mailer */
        $mailer = app('mailer');

        $mailer->send(new WpMail($to, $subject, $message, $headers, $attachments));

        return true;
    }
}
