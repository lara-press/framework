<?php

namespace LaraPress\Posts;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CommentMeta extends Eloquent
{

    public $timestamps = false;

    protected $primaryKey = 'meta_id';

    protected $guarded = [];

    /**
     * @return string
     */
    public function getTable()
    {
        return DB_TABLE_PREFIX . 'commentmeta';
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->attributes['meta_value'];
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->attributes['meta_key'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo(Post::class, DB_TABLE_PREFIX . 'commentmeta', 'comment_id', 'meta_id');
    }
}
