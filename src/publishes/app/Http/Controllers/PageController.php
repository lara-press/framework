<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function handle()
    {
        if (is_search()) {
            return view('welcome');
        }

        if (is_front_page()) {

            if (is_home()) {
                return app()->call([app(PostController::class), 'handle']);
            }

            return view('welcome');
        }

        if (is_page()) {
            return view('welcome');
        }

        abort(404);
    }

}
