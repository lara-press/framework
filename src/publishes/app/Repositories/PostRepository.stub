<?php

namespace App\Repositories;

use App\Post;
use Illuminate\Database\Eloquent\Builder;

class PostRepository extends Repository
{

    /** @return string */
    public function getModelClassName()
    {
        return Post::class;
    }

    public function paginate()
    {
        return $this->newPostQuery()->paginate(get_posts_per_page());
    }

    public function paginateByCategory($category)
    {
        return $this->newPostQuery()
            ->whereHas('terms', function (Builder $query) use ($category) {
                $query->where('slug', $category);
            })
            ->paginate(get_posts_per_page());
    }

    public function paginateByDate($year, $month = null, $day = null)
    {
        $query = $this->newPostQuery()->whereYear('post_date', $year);

        if ($month) {
            $query->whereMonth('post_date', $month);
        }

        if ($day) {
            $query->whereDay('post_date', $day);
        }

        return $query->paginate(get_posts_per_page());
    }

    public function newPostQuery()
    {
        return $this->newQuery()->orderByDesc('post_date');
    }

}
