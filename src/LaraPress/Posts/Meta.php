<?php namespace LaraPress\Posts;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Meta extends Eloquent {

    public $timestamps = false;

    protected $table = 'wp_postmeta';

    protected $guarded = [];

    public function getValue()
    {
        return $this->attributes['meta_value'];
    }

    public function getKey()
    {
        return $this->attributes['meta_key'];
    }
}
