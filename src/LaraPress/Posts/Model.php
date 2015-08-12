<?php namespace LaraPress\Posts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{

    protected $primaryKey = 'ID';

    protected $with = ['meta'];

    protected $dates = ['post_modified', 'post_modified_gmt', 'post_date', 'post_date_gmt'];

    protected $guarded = [''];

    protected $the_post;

    public static function boot()
    {
        parent::boot();

        self::addGlobalScope(new PostTypeScope());
        self::addGlobalScope(new PublishedScope());
    }


    public function getTable()
    {
        return DB_TABLE_PREFIX . 'posts';
    }

    public static function resolveWordpressPostToModel(\WP_Post $post)
    {
        /** @var PostTypeManager $postTypes */
        $postTypes = app('posts.types');

        if ($class = $postTypes->get($post->post_type))
        {
            return with(new $class)->newInstance($post->to_array());
        }

        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meta()
    {
        return $this->hasMany('LaraPress\Posts\Meta', 'post_id', 'ID');
    }

    public function getObjectIdAttribute()
    {
        return $this->ID;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function terms()
    {
        return $this->belongsToMany('LaraPress\Posts\Term', DB_TABLE_PREFIX . 'term_relationships', 'object_id', 'term_taxonomy_id');
    }

    /**
     * @param $metaKey
     * @param $metaValue
     */
    public function setMeta($metaKey, $metaValue)
    {
        update_post_meta($this->ID, $metaKey, $metaValue);

        $this->load('meta');
    }

    public function toWordpressPost()
    {
        $postData = (object) $this->toArray();

        return new \WP_Post($postData);
    }

    public function getField($fieldId, $format = true)
    {
        if ( ! function_exists('acf_is_field_key'))
        {
            throw new \Exception('Advanced Custom Fields must be installed to use ' . __METHOD__);
        }

        $value   = maybe_unserialize($this->getMeta($fieldId));
        $fieldId = $this->getMeta('_' . $fieldId);

        if ( ! acf_is_field_key($fieldId))
        {
            return null;
        }

        $field = get_field_object($fieldId, $this->ID, false, false);

        $value = apply_filters("acf/load_value", $value, $this->ID, $field);
        $value = apply_filters("acf/load_value/type={$field['type']}", $value, $this->ID, $field);
        $value = apply_filters("acf/load_value/name={$field['name']}", $value, $this->ID, $field);
        $value = apply_filters("acf/load_value/key={$field['key']}", $value, $this->ID, $field);

        if ($format)
        {
            $value = acf_format_value($value, $this->ID, $field);
        }

        return $value;
    }

    /**
     * @param $metaKey
     *
     * @return mixed
     */
    public function getMeta($metaKey)
    {
        /** @var Collection $matchingMeta */
        $matchingMeta = $this->meta->filter(
            function (Meta $meta) use ($metaKey)
            {
                return $meta->getKey() == $metaKey;
            }
        );

        return $matchingMeta->count() == 1 ? $matchingMeta->first()->getValue() : null;
    }
}
