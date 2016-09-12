<?php 

namespace LaraPress\Posts;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Term extends Eloquent
{

    protected $primaryKey = 'term_id';

    public function getTable()
    {
        return DB_TABLE_PREFIX . 'terms';
    }

    public function taxonomies()
    {
        return $this->hasOne(TermTaxonomy::class, 'term_id');
    }

    public function posts()
    {
        $query = $this->belongsToMany(Post::class, 'wp_term_relationships', 'term_taxonomy_id', 'object_id', 'term_id');

        foreach ($query->getQuery()->getQuery()->wheres as $key => $where) {
            if ($where['column'] == 'post_type' && $where['value'] == 'post') {
                unset($query->getQuery()->getQuery()->wheres[$key]);
            }

            $bindings = $query->getQuery()->getQuery()->getBindings();

            if (($index = array_search('post', $bindings)) !== false) {
                unset($bindings[$index]);
                $query->getQuery()->getQuery()->setBindings($bindings);
            }
        }

        return $query;
    }
}
