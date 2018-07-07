<?php

namespace App\Http\Controllers;

class PostController extends Controller
{
    public function index()
    {
        if (is_home()) {
            return view('welcome');
        }

        $paginator = null;

        if (is_category()) {
            $paginator = $this->posts->paginateByCategory(get_queried_object()->slug);
        } elseif (is_archive()) {
            $paginator = $this->posts->paginateByDate(
                array_get(wp_query()->query, 'year'),
                array_get(wp_query()->query, 'monthnum'),
                array_get(wp_query()->query, 'day')
            );
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
