<?php

namespace LaraPress\Posts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
    public $timestamps = false;

    protected $primaryKey = 'ID';

    protected $dates = ['post_modified', 'post_modified_gmt', 'post_date', 'post_date_gmt'];

    protected $guarded = [''];

    protected $the_post;

    public static function boot()
    {
        parent::boot();

        self::addGlobalScope(new PostTypeScope());
        self::addGlobalScope(new PublishedScope());
    }

    public static function resolveWordPressPostToModel(\WP_Post $post)
    {
        /** @var PostTypeManager $postTypes */
        $postTypes = app('posts.types');

        if ($class = $postTypes->get($post->post_type)) {
            return with(new $class)->newInstance($post->to_array());
        }

        return false;
    }

    /**
     * @param $slug
     *
     * @return static
     */
    public static function findBySlug($slug)
    {
        return self::where('post_name', $slug)->get()->first();
    }

    public function getTable()
    {
        return DB_TABLE_PREFIX . 'posts';
    }

    public static function getAvailableTemplates()
    {
        return ['one-column'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meta()
    {
        return $this->hasMany(Meta::class, 'post_id', 'ID');
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
        return $this->belongsToMany(
            Term::class,
            DB_TABLE_PREFIX . 'term_relationships',
            'object_id',
            'term_taxonomy_id'
        );
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

    public function toWordPressPost()
    {
        $postData = (object) $this->toArray();

        return new \WP_Post($postData);
    }

    public function getField($fieldId, $format = true)
    {
        if ( ! function_exists('acf_is_field_key')) {
            throw new \Exception('Advanced Custom Fields must be installed to use ' . __METHOD__);
        }

        $value   = maybe_unserialize($this->getMeta($fieldId));
        $fieldId = $this->getMeta('_' . $fieldId);

        if ( ! acf_is_field_key($fieldId)) {
            return null;
        }

        $field = get_field_object($fieldId, $this->ID, false, false);

        $value = apply_filters("acf/load_value", $value, $this->ID, $field);
        $value = apply_filters("acf/load_value/type={$field['type']}", $value, $this->ID, $field);
        $value = apply_filters("acf/load_value/name={$field['name']}", $value, $this->ID, $field);
        $value = apply_filters("acf/load_value/key={$field['key']}", $value, $this->ID, $field);

        if ($format) {
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
            function (Meta $meta) use ($metaKey) {
                return $meta->getKey() == $metaKey;
            }
        );

        return $matchingMeta->count() == 1 ? $matchingMeta->first()->getValue() : null;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'comment_post_ID', 'ID');
    }

    public function getExcerptAttribute()
    {
        return $this->getExcerpt(55);
    }

    public function getExcerpt($wordCount = 55)
    {
        $excerpt = $this->post_excerpt;

        if (empty($excerpt)) {

            $excerpt = strip_shortcodes($this->post_content);

            $excerpt = apply_filters('the_content', $excerpt);
            $excerpt = str_replace(']]>', ']]&gt;', $excerpt);

            $excerptLength = apply_filters('excerpt_length', $this->excerptLength ?: $wordCount);

            $excerptMore = apply_filters('excerpt_more', ' ' . '[&hellip;]');
            $excerpt = wp_trim_words($excerpt, $excerptLength, $excerptMore);
        }

        return apply_filters('wp_trim_excerpt', $excerpt, $this->post_excerpt);
    }


    public function getContentAttribute()
    {
        return apply_filters('the_content', $this->post_content);
    }

    /**
     * Truncates text.
     * Cuts a string to the length of $length and replaces the last characters
     * with the ending if the text is longer than length.
     * ### Options:
     * - `ending` Will be used as Ending and appended to the trimmed string
     * - `exact` If false, $text will not be cut mid-word
     * - `html` If true, HTML tags would be handled correctly
     *
     * @param integer $length Length of returned string, including ellipsis.
     * @param bool    $html
     * @param bool    $exact
     * @param string  $ending
     *
     * @return string Trimmed string.
     * @link     http://book.cakephp.org/view/1469/Text#truncate-1625
     */
    function truncateContent($length = 100, $html = true, $exact = true, $ending = '...')
    {
        $openTags = [];
        $text = $this->content;

        if ($html) {
            if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                return $text;
            }

            $totalLength = mb_strlen(strip_tags($ending));
            $truncate    = '';

            preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
            foreach ($tags as $tag) {
                if ( ! preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                    if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                        array_unshift($openTags, $tag[2]);
                    } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                        $pos = array_search($closeTag[1], $openTags);
                        if ($pos !== false) {
                            array_splice($openTags, $pos, 1);
                        }
                    }
                }
                $truncate .= $tag[1];

                $contentLength =
                    mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
                if ($contentLength + $totalLength > $length) {
                    $left           = $length - $totalLength;
                    $entitiesLength = 0;
                    if (preg_match_all(
                        '/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i',
                        $tag[3],
                        $entities,
                        PREG_OFFSET_CAPTURE
                    )) {
                        foreach ($entities[0] as $entity) {
                            if ($entity[1] + 1 - $entitiesLength <= $left) {
                                $left--;
                                $entitiesLength += mb_strlen($entity[0]);
                            } else {
                                break;
                            }
                        }
                    }

                    $truncate .= mb_substr($tag[3], 0, $left + $entitiesLength);
                    break;
                } else {
                    $truncate .= $tag[3];
                    $totalLength += $contentLength;
                }
                if ($totalLength >= $length) {
                    break;
                }
            }
        } else {
            if (mb_strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
            }
        }

        if ( ! $exact) {
            $spacepos = mb_strrpos($truncate, ' ');
            if (isset($spacepos)) {
                if ($html) {
                    $bits = mb_substr($truncate, $spacepos);
                    preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                    if ( ! empty($droppedTags)) {
                        foreach ($droppedTags as $closingTag) {
                            if ( ! in_array($closingTag[1], $openTags)) {
                                array_unshift($openTags, $closingTag[1]);
                            }
                        }
                    }
                }
                $truncate = mb_substr($truncate, 0, $spacepos);
            }
        }
        $truncate .= $ending;

        if ($html) {
            foreach ($openTags as $tag) {
                $truncate .= '</' . $tag . '>';
            }
        }

        return $truncate;
    }

    public function getFeaturedImageSrc($size = 'large')
    {
        return wp_get_attachment_image_src(get_post_thumbnail_id($this->ID), $size);
    }

    public function getFeaturedImage($size = 'large')
    {
        return wp_get_attachment_image(get_post_thumbnail_id($this->ID), $size);
    }

    public function getImageAltTextAttribute()
    {
        return get_post_meta(get_post_thumbnail_id($this->ID), '_wp_attachment_image_alt');
    }

    public function getPermalinkAttribute()
    {
        if (isset(static::$hrefTemplate)) {
            return sprintf(static::$hrefTemplate, $this->post_name);
        }

        return get_permalink($this->ID);
    }

    public function getTemplateAttribute()
    {
        return get_page_template_slug($this->ID);
    }
}
