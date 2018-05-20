<?php

namespace LaraPress\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WpMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $message;

    function __construct($to, $subject, $message, $headers, $attachments)
    {
        list($to, $subject, $message, $headers, $attachments) =
            array_values(apply_filters('wp_mail', compact('to', 'subject', 'message', 'headers', 'attachments')));

        $this->to($to);
        $this->subject($subject);
        $this->message = $message;

        if ( ! is_array($attachments)) {
            $attachments = explode('\n', str_replace('\r\n', '\n', $attachments));
        }

        if ( ! empty($attachments)) {
            foreach ($attachments as $attachment) {
                $this->attach($attachment);
            }
        }
    }

    public function build()
    {
        $fromAddress = config('mail.from.address', get_option('admin_email'));
        $fromName = config('mail.from.name', get_option('blogname'));

        return $this->from($fromAddress, $fromName)->view('larapress::email', [
            'content' => $this->message,
        ]);
    }
}
