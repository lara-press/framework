<?php

namespace App\Http\Controllers;

use App\Designer;
use App\Page;
use App\Post;
use App\Product;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use LaraPress\Posts\TermTaxonomy;
use LaraPress\Routing\Controller as BaseController;
use LaraPress\Routing\Controller;
use DB;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $products;

    /**
     * DesignerController constructor.
     *
     * @param ProductRepository $products
     */
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    public function index(Page $page)
    {
        $collection = app('wp_query')->query_vars['product_collection'];
        $collection = get_term_by('slug', $collection, 'product_collection');

        if ($collection->parent) {
            return $this->showProducts($collection);
        }

        $collections = $this->getChildCollections($collection->slug);

        return view('pages.products.collection-list', [
            'blurbContent' => $page->content,
            'collections'  => $collections,
        ]);
    }

    protected function showProducts(\WP_Term $collection)
    {
        $products = $this->products->getProductsByCollection($collection->term_id)->paginate();
        $products = $this->prepareProductsForDisplay($products);

        return view('pages.products.product-list', [
            'collection' => $collection,
            'products'   => $products,
        ]);
    }

    public function show($product)
    {
        $product = $this->products->findByName($product);
        $product = $this->prepareProductForDisplay($product);

        return view('pages.products.product', [
            'product' => $product,
        ]);
    }

    /**
     * @param $collectionSlug
     *
     * @return array|int|\WP_Error
     */
    protected function getChildCollections($collectionSlug)
    {
        $watchTaxonomy = get_terms(['product_collection'], [
            'slug'       => $collectionSlug,
            'hide_empty' => false,
        ]);

        if (empty($watchTaxonomy)) {
            return [];
        }

        $collections = get_terms(['product_collection'], [
            'hide_empty' => false,
            'child_of'   => $watchTaxonomy[0]->term_id,
        ]);

        return array_map(function ($collection) {

            $collection->featured_image = get_field(
                'product_collection_featured_image',
                'product_collection_' . $collection->term_id
            );

            $collection->link = get_term_link($collection);

            return $collection;
        }, $collections);
    }

    protected function prepareProductsForDisplay(LengthAwarePaginator $products)
    {
        return $products->map(function($product) {
            return $this->prepareProductForDisplay($product);
        });
    }

    protected function prepareProductForDisplay(Product $product)
    {
        $product->fields = get_fields($product->ID);
        $product->featured_image = $product->getFeaturedImageSrc();

        return $product;
    }
}
