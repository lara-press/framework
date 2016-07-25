<?php

namespace App\Repositories;

use App\Product;
use App\Designer;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository extends Repository
{
    /** @return string */
    public function getModelClassName()
    {
        return Product::class;
    }

    public function getProductsByDesigner(Designer $designer)
    {
        return $this->newQuery()->whereHas('meta', function (Builder $query) use ($designer) {
            $query->where('meta_key', 'product_designer')
                ->where('meta_value', $designer->ID);
        })->get();
    }

    /**
     * @param $collection
     * @return Builder
     */
    public function getProductsByCollection($collection)
    {
        $collection = is_int($collection) ? $collection : $this->getCollectionBySlug($collection)->term_id;

        return $this->newQuery()->whereHas('meta', function (Builder $query) use ($collection) {
            $query->where('meta_key', 'product_collection')
                ->where('meta_value', $collection);
        });
    }

    /**
     * @param $slug
     * @return bool|\WP_Term
     */
    public function getCollectionBySlug($slug)
    {
        return get_term_by('slug', $slug, 'product_collection');
    }
}
