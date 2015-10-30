<?php

namespace LaraPress\Auth;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Meta extends Eloquent
{

    public $timestamps = false;

    protected $primaryKey = 'umeta_id';

    protected $guarded = [];

    public function getTable()
    {
        return DB_TABLE_PREFIX . 'usermeta';
    }

    public function getValue()
    {
        return $this->attributes['meta_value'];
    }

    public function getKey()
    {
        return $this->attributes['meta_key'];
    }

    public function user()
    {
        return $this->belongsTo(config('auth.model'), DB_TABLE_PREFIX . 'usermeta', 'post_id', 'meta_id');
    }
}
