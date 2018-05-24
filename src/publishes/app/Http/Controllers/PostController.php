<?php

namespace App\Http\Controllers;

class PostController extends Controller
{
    public function index()
    {
        if (is_home()) {
            return view('welcome');
        }

        abort(404);
    }

}
