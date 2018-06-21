<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    protected $postController;

    function __construct(PostController $postController)
    {
        $this->postController = $postController;

        if (is_front_page() || is_home()) {
            if (is_home()) {
                return app()->call([app(PostController::class), 'handle']);
            }

            return view('welcome');
        }

        abort(404);
    }

}