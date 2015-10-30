<?php

namespace LaraPress\Html;

use Illuminate\Html\FormBuilder as BaseFormBuilder;

class FormBuilder extends BaseFormBuilder
{
    /**
     * Create a text input field.
     *
     * @param  string $name
     *
     * @return string
     */
    public function nonce($name = '_wpnonce')
    {
        return wp_nonce_field('-1', $name, true, false);
    }
}
