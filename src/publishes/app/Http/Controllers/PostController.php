<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;

class PostController extends Controller
{
    protected $posts;

    public function __construct(PostRepository $posts)
    {
        $this->posts = $posts;
    }

    public function handle()
    {
        if (is_single()) {
            return view('welcome');
        }

        $paginator = null;

        if (is_category()) {
            $paginator = $this->posts->paginateByCategory(get_queried_object()->slug);
        } elseif (is_archive()) {
            $paginator = $this->posts->paginateByDate(wp_query()->query['year'], wp_query()->query['monthnum']);
        } elseif (is_home()) {
            $paginator = $this->posts->paginate();
        }

        if ($paginator) {
            return view('welcome', [
                'posts' => $paginator->items(),
            ]);
        }

        abort(404);
    }

}
