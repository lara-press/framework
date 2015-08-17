<?php namespace LaraPress\Posts;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TermTaxonomy extends Eloquent
{
    protected $primaryKey = 'term_taxonomy_id';

    public function getTable()
    {
        return DB_TABLE_PREFIX . 'term_taxonomy';
    }

    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id', 'term_id');
    }

}
