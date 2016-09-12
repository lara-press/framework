<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use LaraPress\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LaraPress\Routing\Controller;

class PagesController extends Controller
{
    public function frontPage()
    {
        $page = app('post');

        return view('pages/home', [
            'page'                               => $page,
            'showHero'                           => true,
            'heroBackgroundImage'                => 'http://cityhub.movoto.com/1460355717158_5-cities-in-idaho-that-will-instantly-feel-like-home-featured.jpg',
            'heroOverlayText'                    => 'Welcome to McCall Jewelry Company',
            'featuredDesignerBackgroundImage'    => 'https://cdn1.vox-cdn.com/thumbor/ivBxXvjejiQ0h-uFQI6BanrnqAU=/0x47:569x367/1050x591/cdn0.vox-cdn.com/uploads/chorus_image/image/45289880/megan.0.jpg',
            'featuredCollectionBackgroundImage'  => 'https://assets.victorinox.com/medias/?context=bWFzdGVyfHRpbXw0MDk2M3xpbWFnZS9qcGVnfHRpbS9oMmYvaDk0Lzg3OTk0MjMyMDEzMTAuanBnfGRjOTk4MzVlZTc2M2Q2ZTliNDVkYjQwOGVkYjUxNTE4YjE4ZWVlNWMzMWIwNjljOTdmYTIwMjYzNDlmN2E0N2Y',
            'customJewelryDesignBackgroundImage' => 'https://i.ytimg.com/vi/wP5xLwbmP2M/maxresdefault.jpg',
        ]);
    }

    public function defaultPage()
    {
        $page = app('post');

        switch ($page->post_name) {
            case 'designers' :
                return $this->proxyToController(DesignerController::class)->index($page);
            case 'contact' :
                return $this->proxyToController(ContactController::class)->index($page);
        }

        return view('pages.default', ['page' => $page]);
    }

    private function proxyToController($class)
    {
        return app()->make($class);
    }
}
