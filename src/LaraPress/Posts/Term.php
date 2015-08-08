<?php namespace LaraPress\Posts;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Term extends Eloquent
{

    protected $primaryKey = 'term_id';

    public function getTable()
    {
        return DB_TABLE_PREFIX . 'terms';
    }
}
