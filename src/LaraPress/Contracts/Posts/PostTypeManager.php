<?php

namespace LaraPress\Contracts\Posts;

interface PostTypeManager {

    public function register($model);

    public function get($postType);

    public function all();
}
