<?php

namespace App\Http\Controllers;

use App\Designer;
use App\Page;
use App\Repositories\ProductRepository;
use LaraPress\Routing\Controller as BaseController;
use LaraPress\Routing\Controller;
use DB;

class DesignerController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $products;

    /**
     * DesignerController constructor.
     * @param ProductRepository $products
     */
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    public function index(Page $page)
    {
        $designers = Designer::paginate();

        return view('pages.designers', [
            'page' => $page,
            'designers' => $designers,
        ]);
    }

    public function show()
    {
        $designer = app('post');
        $products = $this->products->getProductsByDesigner($designer);

        return view('pages.designer', [
            'designer' => $designer,
            'products' => $products,
        ]);
    }
}
