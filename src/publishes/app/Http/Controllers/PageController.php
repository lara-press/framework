<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    protected $postController;

    function __construct(PostController $postController)
    {
        $this->postController = $postController;
    }

    public function index()
    {
        if (get_option('show_on_front') === 'posts' || is_home()) {
            return $this->postController->index();
        }

        if (is_front_page()) {
            return view('welcome');
        }

        abort(404);
    }

}
