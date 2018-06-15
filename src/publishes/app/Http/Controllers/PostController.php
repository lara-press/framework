<?php

namespace App\Http\Controllers;

class PostController extends Controller
{
    public function handle()
    {
        if (is_home()) {
            return view('welcome');
        }

        abort(404);
    }

}
