<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function handle()
    {
        if (get_option('show_on_front') === 'posts' || is_home()) {
            return app()->call([app(PostController::class), 'handle']);
        }

        if (is_front_page()) {
            return view('welcome');
        }

        abort(404);
    }

}
