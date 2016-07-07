<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use LaraPress\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LaraPress\Routing\Controller;

class PagesController extends Controller
{
    public function frontPage()
    {
        return view('pages/home', [
            'showHero' => true,
            'heroBackgroundImage' => 'http://cityhub.movoto.com/1460355717158_5-cities-in-idaho-that-will-instantly-feel-like-home-featured.jpg',
            'heroOverlayText' => 'Welcome to McCall Jewelry Company'
        ]);
    }

    public function defaultPage()
    {
        d('test');
    }
}
