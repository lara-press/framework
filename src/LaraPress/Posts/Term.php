<?php namespace LaraPress\Posts;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Term extends Eloquent {

    protected $primaryKey = 'term_id';

    protected $table = 'wp_terms';
}