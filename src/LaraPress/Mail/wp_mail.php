<?php

if ( ! function_exists('wp_mail'))
{
    function wp_mail($to, $subject, $message, $headers = '', $attachments = [])
    {
        /** @var \Illuminate\Mail\Mailer $mailer */
        $mailer = app('mailer');

        list($to, $subject, $message, $headers, $attachments) =
            array_values(apply_filters('wp_mail', compact('to', 'subject', 'message', 'headers', 'attachments')));

        $mailer->send(
            'larapress::email',
            ['content' => $message],
            function (\Illuminate\Mail\Message $message) use ($to, $subject, $headers, $attachments)
            {
                $message->to($to);
                $message->subject($subject);

                $fromAddress = config('mail.from.address', get_option('admin_email'));
                $fromName    = config('mail.from.name', get_option('blogname'));

                $message->from($fromAddress ?: get_option('admin_email'), $fromName ?: get_option('blogname'));

                if ( ! is_array($attachments))
                {
                    $attachments = explode('\n', str_replace('\r\n', '\n', $attachments));
                }

                if ( ! empty($attachments))
                {
                    foreach ($attachments as $attachment)
                    {
                        $message->attach($attachment);
                    }
                }
            }
        );
    }
}
