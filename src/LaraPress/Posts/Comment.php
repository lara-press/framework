<?php

namespace LaraPress\Posts;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    public $timestamps = false;

    protected $primaryKey = 'comment_ID';

    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class, 'comment_post_ID', 'ID');
    }

    public function getTable()
    {
        return DB_TABLE_PREFIX . 'comments';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meta()
    {
        return $this->hasMany(CommentMeta::class, 'comment_id', 'comment_ID');
    }
}