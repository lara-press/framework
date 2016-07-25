<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\Request;
use App\Page;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class ContactController extends Controller
{
    public function index(Page $page)
    {
        return view('pages.contact', [
            'page'    => $page,
            'address' => get_field('address', 'option'),
            'email'   => get_field('email_address', 'option'),
            'phone'   => get_field('phone_number', 'option'),
            'fax'     => get_field('fax_number', 'option'),
        ]);
    }

    public function submit(ContactRequest $request, Mailer $mailer)
    {
        $mailer->send('partials.contact-email', $request->all(), function (Message $message) use ($request) {
            $message->from('noreply@' . $request->getHost());
            $message->to(config('app.debug') ? 'support@portonefive.com' : get_field('email_address', 'option'));
        });

        return redirect()->back()->with('success', 'Your message has been sent!');
    }
}
