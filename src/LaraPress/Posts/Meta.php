<?php

namespace LaraPress\Posts;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Meta extends Eloquent
{

    public $timestamps = false;

    protected $primaryKey = 'meta_id';

    protected $guarded = [];

    public function getTable()
    {
        return DB_TABLE_PREFIX . 'postmeta';
    }

    public function getValue()
    {
        return $this->attributes['meta_value'];
    }

    public function getKey()
    {
        return $this->attributes['meta_key'];
    }

    public function post()
    {
        return $this->belongsTo(Post::class, DB_TABLE_PREFIX . 'postmeta', 'post_id', 'meta_id');
    }
}
