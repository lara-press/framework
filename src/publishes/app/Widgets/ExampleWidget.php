<?php

namespace App\Widgets;

use LaraPress\Widgets\Widget;

class ExampleWidget extends Widget
{
    function __construct()
    {
        parent::__construct(class_basename($this), 'Example Widget');
    }

    // Output
    function widget($args, $instance)
    {
    }

    // Admin Form
    public function form($instance)
    {
    }

    // Admin Form Save
    public function update($new_instance, $old_instance)
    {
    }
}
