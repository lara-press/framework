<?php

namespace LaraPress\Admin;

class Column
{
    public $label;
    public $value;

    /**
     * Column constructor.
     * @param string $label
     * @param string|\Closure   $value
     */
    public function __construct(string $label, $value = null)
    {
        $this->label = $label;
        $this->value = $value;
    }

    public function getValue($postId)
    {
        if ($this->value instanceof \Closure) {
            return call_user_func($this->value, $postId);
        }

        return $this->value;
    }
}